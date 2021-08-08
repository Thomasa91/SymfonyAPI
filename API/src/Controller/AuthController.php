<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function App\Validator\validate;
class AuthController extends AbstractController
{   
    #[Route('user/login', name: 'login', methods :'POST')]
    public function login(Request $request, JWTTokenManagerInterface $JWTManager, UserRepository $userRepo) : Response
    {   

        $data = $request->toArray();

        $email = $data['email'];
        $password =$data['password'];

        if(!validate($email, $password)) {
            return new JsonResponse(["message" => "Wrong credentials"], status: 400);
        }

        try {
            $user = $userRepo->findOneBy(['email' => $email]);
        } catch(Exception $e) {
            return new JsonResponse(["message" => "Something went wrong, try again later"], status: 500);
        }
        if(!$user || !password_verify($password, $user->getPassword())) {
            return new JsonResponse(["message" => "Wrong credentials"], status: 400);
        }

        $token = $JWTManager->create($user);
        $roles = json_encode($JWTManager->parse($token)['roles']);
        $tokenExpired = new \DateTime();
        $tokenExpired->setTimestamp($JWTManager->parse($token)['exp']);

        $user->setTokenExpiredAt($tokenExpired);
        $user->setKickedOut(false);
        $em = $this->getDoctrine()->getManager();
 
        try {
            $em->persist($user);
            $em->flush();
        } catch(Exception $e) {
            return new JsonResponse(["message" => "Wrong credentials"], status: 500);
        }

        return new JsonResponse(['token' => $token,  'roles' => $roles]);
    }
}
 