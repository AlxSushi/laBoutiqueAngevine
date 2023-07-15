<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'register')]
    public function index(): Response
    {

        $user = new User();
        $formRegister = $this->createForm(RegisterType::class, $user);

        return $this->render('register/register.html.twig',
        [
            'formRegister' => $formRegister->createView()
        ]);
    }
}
