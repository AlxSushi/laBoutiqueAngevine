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

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('//mon-compte/modifier-mot-de-passe', name: 'account_password')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $notification = null;
        $user = $this->getUser();
        $passwordForm = $this->createForm(ChangePasswordType::class, $user);

        $passwordForm->handleRequest($request);
        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $oldPassword = $passwordForm->get('old_password')->getData();
             if ($passwordHasher->isPasswordValid($user, $oldPassword)) {
                 $newPassword = $passwordForm->get('new_password')->getData();
                 $password = $passwordHasher->hashPassword($user, $newPassword);

                 $user->setPassword($password);
                 $this->entityManager->persist($user);
                 $this->entityManager->flush();
                 $notification = "Votre de mot de passe a été mis à jour.";
             }
             else {
                 $notification = "Votre mot de passe actuel est erroné";
             }
        }

        return $this->render('account/account_password.html.twig', [
                'passwordForm' => $passwordForm->createView(),
                'notification' => $notification
            ]);
    }
}
