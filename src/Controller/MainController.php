<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\SendinBlueClient;
use Exception;
use Sendinblue\Client\ApiException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     *
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/je-participe/{token}", name="participation", methods={"GET"})
     *
     * @param $token
     *
     * @return Response
     */
    public function participation($token): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user, [
            'step' => UserType::STEP1,
            'action' => $this->generateUrl('participation_post', ['token' => $token]),
        ]);

        return $this->render('je-participe.html.twig', [
            'token' => $token,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/je-participe/{token}", name="participation_post", methods={"POST"})
     *
     * @param                  $token
     * @param Request          $request
     * @param SendinBlueClient $client
     *
     * @return Response
     * @throws ApiException
     * @throws Exception
     */
    public function participationPost($token, Request $request, SendinblueClient $client): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user, [
            'step' => UserType::STEP1,
            'action' => $this->generateUrl('participation_post', ['token' => $token]),
        ]);

        $data = $request->request->all('user') ?? [];
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $client->updateContact($user);
            if ($result instanceof User) {
                return $this->redirectToRoute('form', ['token' => $token]);
            }
            $form->addError(new FormError('Une erreur est survenue, veuillez réessayer.'));
        }
        return $this->render('je-participe.html.twig', [
            'token' => $token,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/je-participe/2/{token}", name="form", methods={"GET"})
     *
     * @param $token
     *
     * @return Response
     */
    public function form($token): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user, [
            'step' => UserType::STEP2,
            'action' => $this->generateUrl('participation_2_post', ['token' => $token]),
        ]);
        return $this->render('formulaire.html.twig', [
            'token' => $token,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/je-participe/2/{token}", name="participation_2_post", methods={"POST"})
     *
     * @param                  $token
     * @param Request          $request
     * @param SendinBlueClient $client
     *
     *
     * @return Response
     * @throws ApiException
     * @throws Exception
     */
    public function participation2Post($token, Request $request, SendinBlueClient $client): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user, [
            'step' => UserType::STEP2,
            'action' => $this->generateUrl('participation_2_post', ['token' => $token]),
        ]);

        $data = $request->request->all('user') ?? [];
        $form->submit($data);

        if ($form->isSubmitted()) {
            $result = $client->updateContact($user);
            if ($result instanceof User) {
                return $this->redirectToRoute('confirmation', ['token' => $token]);
            }
            $form->addError(new FormError('Une erreur est survenue, veuillez réessayer'));
        }
        return $this->render('formulaire.html.twig', [
            'token' => $token,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/je-ne-participe-pas/{token}", name="withdrawal", methods={"GET"})
     *
     * @param                  $token
     * @param SendinBlueClient $client
     *
     * @return Response
     * @throws ApiException
     */
    public function withdrawal($token, SendinBlueClient $client): Response
    {
        $user = $client->getContact($token);
        $user->setParticipation(false);
        $client->updateContact($user);
        return $this->render('je-ne-participe-pas.html.twig', [
            'token' => $token
        ]);
    }


    /**
     * @Route("/règles-sanitaires", name="healthRules", methods={"GET"})
     *
     * @return Response
     */
    public function healthRules(): Response
    {
        return $this->render('règles-sanitaires.html.twig');
    }

    /**
     * @Route("/je-participe/confirmation/{token}", name="confirmation", methods={"GET"})
     *
     * @param $token
     *
     * @return Response
     */
    public function confirmation($token): Response
    {
        dump($this->getUser());
        return $this->render('confirmation.html.twig', [
            'token' => $token
        ]);
    }

    /**
     * @Route("/inscrit/{id}", name="registered", methods={"GET"})
     *
     * @param $id
     *
     * @return Response
     */
    public function registered($id): Response
    {
        return $this->render('inscrit.html.twig', [
            'id' => $id
        ]);
    }
}
