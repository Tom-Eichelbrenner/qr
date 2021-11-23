<?php

namespace App\Controller;

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
     */
    public function index()
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
        return $this->render('je-participe.html.twig', [
            'token' => $token
        ]);
    }

    /**
     * @Route("/je-ne-participe-pas", name="desistement", methods={"GET"})
     *
     * @return Response
     */
    public function jeNeParticipePas()
    {
        return $this->render('je-ne-participe-pas.html.twig');
    }

    /**
     * @Route("/je-participe/2/{token}", name="formulaire", methods={"GET"})
     *
     * @return Response
     */
    public function formulaire($token)
    {
        return $this->render('formulaire.html.twig', [
            'token' => $token
        ]);
    }

    /**
     * @Route("/règles-sanitaires", name="règles-sanitaires", methods={"GET"})
     *
     * @return Response
     */
    public function reglesSanitaires()
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
     * @Route("/inscrit/{id}", name="inscrit", methods={"GET"})
     *
     * @return Response
     */
    public function inscrit($id)
    {
        return $this->render('inscrit.html.twig', [
            'id' => $id
        ]);
    }
}
