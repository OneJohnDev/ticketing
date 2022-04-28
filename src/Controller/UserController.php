<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use MongoDB\Driver\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'app_user')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $users= $doctrine->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }


    #[Route('/admin/user/update/{id}', name: 'app_user_update')]
    public function updateUser(ManagerRegistry $doctrine, int $id)
    {
        /** @var $user User */
        $error="";
        if(isset($_GET['role'])){
            $user = $doctrine->getRepository(User::class)->find($id);
            foreach($user->getRoles() as $role){
                if($_GET['role']==$role){
                    $error="L'utilisateur a déjà ce rôle !";
                }
            }
            if($error == ""){
                $roles = $user->getRoles();
                $roles[] = $_GET['role'];
                $user->setRoles($roles);
                $entityManager = $doctrine->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }
        $user = $doctrine->getRepository(User::class)->find($id);

        $form = $this->createForm(UserType::class, $user);

        return $this->renderForm('user/update.html.twig', [
            'form' => $form,
            'roles' => $user->getRoles(),
            'error' => $error,
        ]);
    }

    #[Route('/admin/user/deleteRole/{id}', name: 'app_role_delete')]
    public function deleteRole(ManagerRegistry $doctrine, int $id): Response
    {
        /** @var $user User */
        $message="";
        if(isset($_GET['role'])){
            $user = $doctrine->getRepository(User::class)->find($id);
            $roles = $user->getRoles();
            if (($key = array_search($_GET['role'], $roles)) !== false) {
                unset($roles[$key]);
            }
            $user->setRoles($roles);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $message="Le role a bien été supprimé !";


        }
        $user = $doctrine->getRepository(User::class)->find($id);
        $roles = $user->getRoles();
        return $this->render('user/deleteRole.html.twig', [
            'roles' => $roles,
            'message' => $message,
            'user' => $user,
        ]);
    }
}
