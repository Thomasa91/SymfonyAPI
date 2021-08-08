<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Error;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function App\Validator\validate;

 #[Route('/api',)]
class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserRepository $userRepo): Response
    {
        $data = $request->toArray();
        
        $email = $data['email'];
        $password = $data['password'];

        if(!validate($email, $password)) {
            return new JsonResponse(["message" => "Wrong credentials"], status: 400);
        }

        try {
            if($userRepo->findBy(['email' => $email])) {
                return new JsonResponse(["message" => "Email has been already used"], status: 400);
            }
        } catch(Exception $e) {
                return new JsonResponse(["message" => "Something went wrong, try again later"], status: 500);
        }
        $user = new User();
        try {
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
        } catch(Error $e) {
            return new JsonResponse(["message" => "Something went wrong, try again later"], status: 500);
        }  
        // Uncomment to register user with admin privileges
        // $user->setRoles(['ROLE_ADMIN']);
        $user->setKickedOut(false);
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->persist($user);
            $em->flush();
        } catch(Exception $e) {
            return new JsonResponse(["message" => "Something went wrong, try again later"], status: 500);
        }
        return new JsonResponse('User has been created');
    }
}
