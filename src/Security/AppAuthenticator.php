<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AppAuthenticator extends AbstractLoginFormAuthenticator
{
    public function __construct(private RouterInterface $router)
    {
    }

    public function authenticate(Request $request): Passport
    {
        $email = (string) $request->request->get('_username', '');
        $password = (string) $request->request->get('_password', '');
        $csrfToken = (string) $request->request->get('_csrf_token');

        // Guardar último email ingresado en la sesión
        $request->getSession()->set('_security.last_username', $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $csrfToken),
                new RememberMeBadge(),
            ]
        );
    }


    public function getLoginUrl(Request $request): string
    {
        return $this->router->generate('app_login');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Redirigir a home después de login exitoso
        return new RedirectResponse($this->router->generate('home'));
    }
}

