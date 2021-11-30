<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\PDFCreator;
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
     * @Route("/je-participe/{token}", name="participation_1_get", methods={"GET"})
     *
     * @param $token
     *
     * @return Response
     */
    public function participation1Get($token): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user, [
            'step' => UserType::STEP1,
            'action' => $this->generateUrl('participation_1_post', ['token' => $token]),
        ]);

        return $this->render('form_1.twig', [
            'token' => $token,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/je-participe/{token}", name="participation_1_post", methods={"POST"})
     *
     * @param                  $token
     * @param Request          $request
     * @param SendinBlueClient $client
     *
     * @return Response
     * @throws Exception
     */
    public function participation1Post($token, Request $request, SendinblueClient $client): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user, [
            'step' => UserType::STEP1,
            'action' => $this->generateUrl('participation_1_post', ['token' => $token]),
        ]);

        $data = $request->request->all('user') ?? [];
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $client->updateContact($user);
            if ($result instanceof User) {
                return $this->redirectToRoute('participation_2_get', ['token' => $token]);
            }
            $form->addError(new FormError('Une erreur est survenue, veuillez réessayer.'));
        }
        return $this->render('form_1.twig', [
            'token' => $token,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/je-participe/2/{token}", name="participation_2_get", methods={"GET"})
     *
     * @param $token
     *
     * @return Response
     */
    public function participation2Get($token): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user, [
            'step' => UserType::STEP2,
            'action' => $this->generateUrl('participation_2_post', ['token' => $token]),
        ]);
        return $this->render('form_2.twig', [
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
     */
    public function participation2Post($token, Request $request, SendinBlueClient $client, PDFCreator $creator): Response
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
                /** @var User $user */
                $user = $this->getUser();
                $file = $creator->generatePdf("pdf/template.html.twig", $user, "pdf/participation" . uniqid() . ".pdf");
                $client->sendTransactionnalEmail($user, $client::TEMPLATE_INVITATION, [], $file);

                return $this->redirectToRoute('confirmation', ['token' => $token]);
            }
            $form->addError(new FormError('Une erreur est survenue, veuillez réessayer'));
        }
        return $this->render('form_2.twig', [
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
     */
    public function withdrawal($token, SendinBlueClient $client, PDFCreator $creator): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->getParticipation() == false) {
            return $this->render('je-ne-participe-pas.html.twig', [
                'token' => $token
            ]);
        } else {
            $user->setParticipation(false);
            $client->updateContact($user);
            $file = $creator->generatePdf("pdf/template.html.twig", $user, "pdf/participation" . uniqid() . ".pdf");
            $client->sendTransactionnalEmail($user, $client::TEMPLATE_WITHDRAWAL, [], $file);
        }
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
    public function confirmation($token, SendinBlueClient $client, PDFCreator $creator): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        dump($user);
        if ($user->getParticipation() == true) {
            return $this->render('confirmation.html.twig', [
                'token' => $token
            ]);
        } else {
            $user->setParticipation(true);
            $client->updateContact($user);
            $file = $creator->generatePdf("pdf/template.html.twig", $user, "pdf/participation" . uniqid() . ".pdf");
            $client->sendTransactionnalEmail($user, $client::TEMPLATE_CONFIRMATION, [], $file);
        }
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
