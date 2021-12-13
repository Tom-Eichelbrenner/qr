<?php

namespace App\Security;

use App\Entity\User;
use App\Exception\FormRegisteredException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class RouteVoter extends Voter
{
    public const VIEW = 'view';

    public const ROUTES = [
        "participation_1_get" => [
            "index",
            "confirmation"
        ],
        "participation_1_post" => [
            "participation_1_get"
        ],
        "participation_2_get" => [
            "participation_1_post"
        ],
        "participation_2_post" => [
            "participation_2_get"
        ],
        "confirmation" => [
            "participation_1_post",
            "participation_2_get", // in case of empty form
            "participation_2_post",
            "localisation"
        ],
        'countermark' => [
            'confirmation'
        ],
        "localisation" => [
            'confirmation'
        ]
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

    /**
     * @param string $attribute
     * @param mixed  $subject
     *
     * @return bool
     */
    protected function supports(string $attribute, $subject): bool
    {
        return true;
    }

    /**
     * @param string         $attribute
     * @param Request        $subject
     * @param TokenInterface $token
     *
     *
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();

        if ($user->getParticipation() === false) {
            throw new FormRegisteredException($user);
            return false;
        }

        $referer = $this->request->headers->get('referer');

        $routename = $this->request->attributes->get('_route');

        if ($routename === 'index' || $routename === "localisation") {
            return true;
        }

        $urls = [];

        foreach (self::ROUTES[$routename] as $allowedRouteName) {
            $urls[] = $this->router->generate($allowedRouteName, ['token' => $user->getToken()], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        $access = in_array($referer, $urls);

        if (! $access) {
            throw new AccessDeniedException('');
        }

        return true;
    }
}
