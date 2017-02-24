<?php
// AcmeBundle\Security\LoginSuccessHandler.php

namespace AdminBundle\Security;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    protected $router;
    protected $authorizationChecker;

    public function __construct(Router $router, AuthorizationChecker $authorizationChecker) {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {

        $response = null;

        $session = new Session();

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $session->getFlashBag()->add('info', 'Welcome to your BackOffice');
            $response = new RedirectResponse($this->router->generate('admin_homepage'));
        } else if ($this->authorizationChecker->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->router->generate('octasoft_homepage'));
        }

        return $response;
    }

}