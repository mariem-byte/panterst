<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserFormType;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function show(): Response
    {
        return $this->render('account/show.html.twig');
    }
	
	
	#[Route('/account/edit', name: 'app_account_edit')]
    public function edit(Request $request): Response
    {   $user=$this->getUser();
		$form=$this->createForm(UserFormType::class,$user);
		$form->handleRequest($request);
		if($form->isSubmitted()&&$form->isValid()){
			dd($form->getData());
		}
        return $this->render('account/edit.html.twig',['form'=>$form->createView()]);
    }
	
	
	 #[Route('/account/changePassword', name: 'app_changepassword')]
    public function changePassword(Request $request ,EntityManagerInterface $em,UserPasswordEncoderInterface $passwordEncoder): Response
    { 
	    $user=$this->getUser();
		$form=$this->createForm(ChangePasswordFormType::class);
	    $form->handleRequest($request);
		if ($form->isSubmitted()&&$form->isValid())
		{
			$user->setPassword($passwordEncoder->encodePassowrd($form['newPassword']->getData()));
			$em->flush();
		}
	
	
        return $this->render('account/changepassword.html.twig',['form'=>$form->createView()]);
    }
}
