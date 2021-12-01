<?php

namespace App\Security;

use App\Entity\User;
use App\Service\CheckRoute;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RouteVoter extends Voter
{
    const VIEW = 'view';

    const ROUTES = [
        "participation_1_post" => "participation_1_get",
        "participation_2_get" => "participation_1_post",
        "participation_2_post" => "participation_2_get",
        "confirmation" => "participation_2_post",
    ];


    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var RequestStack
     */
    private $request;

    public function __construct(RouterInterface $router, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->request = $requestStack->getCurrentRequest();
    }

    protected function supports(string $attribute, $subject)
    {
        return (in_array($this->request->attributes->get('_route'), array_keys(self::ROUTES)));
    }

    /**
     * @param string         $attribute
     * @param Request        $subject
     * @param TokenInterface $token
     *
     *
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();
        $referer = $this->request->headers->get('referer');

        $routename = $this->request->attributes->get('_route');

        $url = $this->router->generate(self::ROUTES[$routename], ['token' => $user->getToken()], Router::ABSOLUTE_URL);
        return $url === $referer;
    }
}