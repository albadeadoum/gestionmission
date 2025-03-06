<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Vérifiez le statut de l'utilisateur avant de le laisser se connecter
        $user = $token->getUser();
        
        if ($user->getStatus() !== 'ACTIF') {
            // Redirigez l'utilisateur vers une page d'erreur ou déconnectez-le.
            // Par exemple, vous pouvez lancer une exception pour signaler une erreur d'authentification.
            //throw new \Exception('User status is not active.');
            //throw new AccessDeniedHttpException('Votre statut n\'est pas actif. Veuillez contacter l\'administrateur.');
            //$error = "User status is not active.";
            return new RedirectResponse($this->urlGenerator->generate('app_logout'));
            //return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        }

        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        if (in_array('ROLE_CHAUFFEUR', $user->getRoles())) {
            return new RedirectResponse($this->urlGenerator->generate('app_mobile_home'));
        }

        // Redirigez l'utilisateur vers la page d'accueil
        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
