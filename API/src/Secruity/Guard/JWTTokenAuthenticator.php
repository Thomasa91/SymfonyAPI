<?php

namespace App\Security\Guard;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTTokenAuthenticator extends BaseAuthenticator
{
    public function checkCredentials($credentials, UserInterface $user)
    {
        
        // TODO change message
        if($user->getKickedOut()) {
            throw new AuthenticationException('Invalid JWT Token  because i say so ');
        }
        return true;
    }
}
