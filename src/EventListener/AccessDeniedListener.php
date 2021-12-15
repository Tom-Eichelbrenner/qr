<?php

namespace App\EventListener;

use App\Exception\FormRegisteredException;
use App\Exception\FormUncompletedException;
use App\Exception\UserParticipateException;
use App\Exception\UserWithdrawedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedListener implements EventSubscriberInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var SessionInterface
     */
    private $session;


    public function __construct(RouterInterface $router, SessionInterface $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * @return \array[][]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onKernelException', 999999],
            ],
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        if (! $event->isMainRequest()) {
            return;
        }
        $exception = $event->getThrowable();
        $message = $event->getThrowable()->getMessage();
        if ($exception instanceof FormRegisteredException) {
            $user = $exception->getUser();
            $url = $this->router->generate('confirmation', ['token' => $user->getToken()]);
            $response = new RedirectResponse($url);
            $this->session->set('user', $exception->getUser());
        } elseif ($exception instanceof UserWithdrawedException) {
            $user = $exception->getUser();
            $url = $this->router->generate('withdrawal', ['token' => $user->getToken()]);
            $response = new RedirectResponse($url);
            $this->session->set('user', $exception->getUser());
        } elseif ($exception instanceof FormUncompletedException) {
            $user = $exception->getUser();
            $url = $this->router->generate('index', ['token' => $user->getToken()]);
            $response = new RedirectResponse($url);
            $this->session->set('user', $exception->getUser());
        } elseif ($exception instanceof AccessDeniedException || $exception instanceof UnauthorizedHttpException || $exception instanceof NotFoundHttpException) {
            $url = $this->router->generate('error');
            $response = new RedirectResponse($url);
            $response->headers->set('Location', $url);
            // get the session
            $session = $this->session;
            $session->set('message', $message);
        }

        if (isset($response) && isset($url)) {
            $event->setResponse($response);
        }
    }
}
