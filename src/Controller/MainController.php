<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\SendinBlueClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $user = $client->getContact("test_1234567890_token");
        $user->setParticipation(!$user->getParticipation());
        $client->updateContact($user);
        $client->getContact("test_1234567890_token");
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/je-participe/{token}", name="participation", methods={"GET"})
     *
     * @return Response
     */
    public function participation($token)
    {
        return $this->render('je-participe.html.twig', [
            'token' => $token
        ]);
    }

    /**
     * @Route("/je-ne-participe-pas/{token}", name="withdrawal", methods={"GET"})
     *
     * @return Response
     */
    public function withdrawal($token)
    {
        return $this->render('je-ne-participe-pas.html.twig', [
            'token' => $token
        ]);
    }

    /**
     * @Route("/je-participe/2/{token}", name="form", methods={"GET"})
     *
     * @return Response
     */
    public function form($token)
    {
        return $this->render('formulaire.html.twig', [
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
