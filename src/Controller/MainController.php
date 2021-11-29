<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\SendinBlueClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     *
     * @return Response
     * @throws \Exception
     */
    public function index(SendinBlueClient $client)
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/je-participe/{token}", name="participation", methods={"GET"})
     *
     * @return Response
     */
    public function participation($token)
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
     * @return Response
     */
    public function participationPost($token, Request $request, SendinblueClient $client)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user, [
            'step' => UserType::STEP1,
            'action' => $this->generateUrl('participation_post', ['token' => $token]),
        ]);

        // assign form data to user
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $client->updateContact($user);
            return $this->redirectToRoute('form', ['token' => $token]);
        }
    }

    /**
     * @Route("/je-participe/2/{token}", name="form", methods={"GET"})
     *
     * @return Response
     */
    public function form($token)
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
     * @return Response
     */
    public function participation2Post($token, Request $request, SendinBlueClient $client)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user, [
            'step' => UserType::STEP2,
            'action' => $this->generateUrl('participation_2_post', ['token' => $token]),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $client->updateContact($user);
            return $this->redirectToRoute('confirmation', ['token' => $token]);
        }
    }

    /**
     * @Route("/je-ne-participe-pas/{token}", name="withdrawal", methods={"GET"})
     *
     * @return Response
     */
    public function withdrawal($token, SendinBlueClient $client)
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
    public function healthRules()
    {
        return $this->render('règles-sanitaires.html.twig');
    }

    /**
     * @Route("/je-participe/confirmation/{token}", name="confirmation", methods={"GET"})
     *
     * @return Response
     */
    public function confirmation($token)
    {
        dump($this->getUser());
        return $this->render('confirmation.html.twig', [
            'token' => $token
        ]);
    }

    /**
     * @Route("/inscrit/{id}", name="registered", methods={"GET"})
     *
     * @return Response
     */
    public function registered($id)
    {
        return $this->render('inscrit.html.twig', [
            'id' => $id
        ]);
    }
}
