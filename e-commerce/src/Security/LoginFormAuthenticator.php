<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

class LoginFormAuthenticator extends AbstractAuthenticator
{
    protected $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function supports(Request $request): ?bool
    {
        
        return $request->attributes->get("_route") === "security_login" && 
        $request->isMethod("POST");
    }

    public function authenticate(Request $request): Passport
    {
        // return $request->request->get("login");
        // return $userProvider->loadUserByUsername($credentials["email"]);
        // $this->encoder->isPasswordValid($user, $credentials["password"]); // methode 5.1

        $credentials = $request->request->get('login');
        return new Passport( new UserBadge($credentials['email']),
        new PasswordCredentials($credentials['password']) );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse("/");
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $errorMsg = "Erreur d'authentification"; 

        if ($exception->getMessage() === "Bad credentials.") 
        {
            $errorMsg = "Cette adresse email n'est pas connue.";
        } elseif ($exception->getMessage() === "The presented password is invalid.") 
        {
            $errorMsg = "Le mot de passe ne correspond pas";
        }

        $exception = new AuthenticationException($errorMsg);

        $request->attributes->set(Security::LAST_USERNAME, $request->request->all()['login']['email']);
        $request->attributes->set(Security::AUTHENTICATION_ERROR, $exception);
        return null;
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}
