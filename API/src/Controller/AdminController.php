<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Error;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    public function __construct(private UserRepository $userRepo)
    {
    }

    #[Route('api/admin', name: 'admin')]
    public function index(): Response
    {
        try {
            $users = $this->userRepo->findAll();
        } catch (Error $e) {
            return new JsonResponse(status: 500);
        };

        $users_info = [];

        foreach ($users as $user) {

            if ($user->getKickedOut() || ($user->getTokenExpiredAt() < new \DateTime('now')) || in_array('ROLE_ADMIN', $user->getRoles())) {
            } else {
                $users_info[] = ['id' => $user->getId(), 'email' => $user->getEmail(), 'isKicked' => $user->getKickedOut()];
            }
        }

        return new JsonResponse($users_info);
    }

    #[Route('api/admin/kick-out/{user_id}', name: 'admin_kick')]
    public function kick_out($user_id): Response
    {
        try {
            $user = $this->userRepo->find($user_id);
        } catch (Exception $e) {
            return new JsonResponse(["message" => "Something went wrong, try again later"], status: 500);
        };

        if (!$user) {
            return new JsonResponse(["message" => sprintf("There is no user with %d id", $user_id)], status: 404);
        }

        if($user->getKickedOut()) {
            return new JsonResponse(["message" => sprintf("User with %d id has been already kicked out", $user_id)], status: 404);
        }
        
        $user->setKickedOut(true);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        } catch (Exception $e) {
            return new JsonResponse(status: 500);
        }
        return new JsonResponse(["message" => sprintf('User with id %d has been kicked out', $user_id)]);
    }
}
