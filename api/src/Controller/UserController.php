<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Entity\File;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{


    /**
     * @Route("/login", methods={"POST"}, name="login")
     */
    public function login(Request $request)
    {
        session_start();

        $login = $request->query->get('login');
        $password = $request->query->get('password');

        $data = json_decode($request->getContent(), true);
        $login = $data['login'];
        $password = $data['password'];

        $user = $this->getDoctrine()->getRepository(User::class)
            ->findByLogin($login);

        if (!$user) return $this->json(['message' => 'Wrong login.', 'test' => $login], 400);
        if (!password_verify($password, $user[0]->getPassword())) return $this->json(['message' => 'Wrong password'], 400);

        $_SESSION['idUser'] = $user[0]->getId();
        $_SESSION['active'] = true;

        return $this->json(['message' => 'Logged in'], 200);
    }

    /**
     * @Route("/create", methods={"POST"}, name="create")
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $login = $data['login'];
        $email = $data['email'];
        $password = $data['password'];

        $entityManager = $this->getDoctrine()->getManager();

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $isUser = $this->getDoctrine()->getRepository(User::class)
            ->findByLogin($login);
        if ($isUser) return $this->json(['message' => 'Login is used.'], 400);

        $isEmail = $this->getDoctrine()->getRepository(User::class)
            ->findByEmail($email);
        if ($isEmail) return $this->json(['message' => 'Email is used.'], 400);

        $avatarFile = $this->getDoctrine()->getRepository(File::class)
        ->find(1);

        $user = new User();
        $user->setLogin($login)
            ->setPassword($hashedPassword)
            ->setEmail($email)
            ->setIdavatarfile($avatarFile)
            ->setCreationdate(new \DateTime());

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'Account created.'], 201);
    }

    /**
     * @Route("/logout", methods={"GET"}, name="logout")
     */
    public function logout()
    {
        session_start();
        $_SESSION = array();
        return $this->json(['message' => 'Logged out']);
    }

    /**
     * @Route("/", methods={"DELETE"}, name="delete")
     */
    public function delete(Request $request)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) $this->json(['message' => 'No access'], 400);

        $password = $request->query->get('password');
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)
            ->find($_SESSION['idUser']);

        if (!$user) return $this->json(['message' => 'User not exist'], 404);
        if (!password_verify($password, $user[0]->getPassword())) return $this->json(['message' => 'Wrong password'], 400);

        
        $entityManager->remove($user[0]);
        $entityManager->flush();

        return $this->json(['message' => 'User deleted'], 200);
    }
    /**
     * @Route("/edit", methods={"PUT"}, name="update")
     */
    public function update(Request $request)
    {
        session_start();
        if(!isset($_SESSION['idUser'])) $this->json(['message' => 'No access'], 400);

        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($_SESSION['idUser']);
        if(!$user) return $this->json(['message' => 'User not exist'], 400);
        
        $data = json_decode($request->getContent(), true);

        if(!isset($data['password'])
        || !password_verify($data['password'], $user->getPassword())) return $this->json(['message' => 'Wrong password'], 400);
        
        if(isset($data['newLogin'])) {
            $isLogin = $this->getDoctrine()->getRepository(User::class)->findByLogin($data['newLogin']);
            if($isLogin) return $this->json(['message' => 'Login is used.'], 400);
            $user->setLogin($data['newLogin']);
        }
        if(isset($data['newPassword'])) $user->setPassword(password_hash($data['newPassword'], PASSWORD_BCRYPT));
        if(isset($data['newMail'])) {
            $isMail = $this->getDoctrine()->getRepository(User::class)->findByEmail($data['newEmail']);
            if(!$isMail) $user->setEmail($data['newMail']);
        }

        $entityManager->flush();

        return $this->json(['message' => 'User updated']);
    }

    /**
     * @Route("/status", methods={"GET"}, name="status")
     */
     public function isLogin()
     {
         session_start();
         if(isset($_SESSION['idUser'])) return $this->json(['status' => true]);
         return $this->json(['status' => false]);
     }
}
