<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{


    /**
     * @Route("/login/{login}/{password}", methods={"POST"}, name="user_login")
     */
    public function login(string $login, string $password)
    {
        session_start();

        $users = $this->getDoctrine()->getRepository(User::class)
        ->findByLogin($login);

        if(!$users) return $this->json(['message' => 'Bad login.'], 400);
        if(!password_verify($password, $users[0]->getPassword())) return $this->json(['message' => 'Wrong password'], 400);

        $_SESSION['idUser'] = $users[0]->getId();
        $_SESSION['active'] = true;

        return $this->json(['message' => 'Logged in'], 200);
    }

    /**
     * @Route("/{login}/{email}/{password}", methods={"POST"}, name="user_create")
     */
    public function create(string $login, string $email, string $password)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $users = $this->getDoctrine()->getRepository(User::class)
        ->findByLogin($login);
        if($users) return $this->json(['message' => 'Login is used.'], 400);

        $users = $this->getDoctrine()->getRepository(User::class)
        ->findByEmail($email);
        if($users) return $this->json(['message' => 'Email is used.'], 400);

        $user = new User();
        $user->setLogin($login)
            ->setPassword($hashedPassword)
            ->setEmail($email)
            ->setCreationdate(new \DateTime());
        
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'Account created.'], 201);
    }

    /**
     * @Route("/logout", methods={"GET"}, name="user_logout")
     */
     public function logout()
     {
        session_start();
        $_SESSION = array();
        return $this->json(['message' => 'Wylogowales sie']);
     }

     /**
     * @Route("/{password}", methods={"DELETE"}, name="user_delete")
     */
    public function delete($password)
    {
       session_start();

       if(isset($_SESSION['idUser'])) {
        $entityManager = $this->getDoctrine()->getManager();
        $users = $this->getDoctrine()->getRepository(User::class)
         ->findById($_SESSION['idUser']);
 
         $entityManager->remove($users[0]);
         $entityManager->flush();

         if(!$users) return $this->json(['message' => 'User not exist'], 404);
         if(!password_verify($password, $users[0]->getPassword())) return $this->json(['message' => 'Wrong password'], 400);

         return $this->json(['message' => 'User deleted'], 200);
       }

       return $this->json(['message' => 'You are not logged in'], 404);
    }
    /**
     * @Route("/edit/", methods={"PUT"}, name="user_update")
     */
    public function update()
    {
       session_start();

       if(isset($_SESSION['idUser'])) {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)
         ->findById($_SESSION['idUser']);
 
         $user[0]->setLogin("jkis");
         $entityManager->flush();

         return $this->json(['message' => 'update usera']);
       }

       return $this->json(['message' => 'Nie updatnales']);
    }
}
