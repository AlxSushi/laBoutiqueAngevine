<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager= $entityManager;
    }

    #[Route('modifier_mon_mot_de_passe', name: 'password')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $notification = null;

        $user = $this->getUser();
        $formChangePassword = $this->createForm(ChangePasswordType::class, $user);
        $formChangePassword->handleRequest($request);

        if ($formChangePassword->isSubmitted() && $formChangePassword->isValid()) {
            $oldPassword = $formChangePassword->get('password')->getData();

            if ($passwordHasher->isPasswordValid($user, $oldPassword )) {
                $newPassword = $formChangePassword->get('new_password')->getData();
                $password = $passwordHasher->hashPassword($user, $newPassword);

                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = 'Votre mot de passe a bien été mis à jours';
            } else {
                $notification = 'Votre mot de passe ne correspond pas, veuillez réessayer';
            }
        }


        return $this->render('account_password/password.html.twig', [
            'formChangePassword' => $formChangePassword->createView(),
            'notification'=> $notification
        ]);
    }
}