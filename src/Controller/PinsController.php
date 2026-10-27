<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PineRepository;
use App\Repository\UserRepository;
use App\Entity\Pine;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Doctrine\ORM\EntityManagerInterface;

class PinsController extends AbstractController
{  #[Route('/pins', name: 'app_home')]
    public function index( PineRepository $repo): Response
    {   
		$pines= $repo->findAll();
        return $this->render('pins/index.html.twig',['pines'=>$pines ]);
	}
  #[Route('/pins/{id}<[0-9]+>', name: 'app_show')]
  public function show(PineRepository $repo ,Int $id):Response
  {  
   $pine =$repo->find($id);
	
	  return $this->render('pins/show.html.twig',['id'=>$id,'pine'=>$pine]);
  }
  
  
  
  
  #[Route('/pins/create', name: 'app_create')]
  public function create(Request $request, EntityManagerInterface $em,UserRepository $repo): Response
  
 {
	   $form=$this->createFormBuilder()
	     ->add('imageFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true,
            'delete_label' => '...',
            'download_label' => '...',
            'download_uri' => false,
            'image_uri' => false,
            'asset_helper' => true,
        ])
		            ->add('title',TextType::class)
				  ->add('description',TextareaType::class)
				  ->add('submit',SubmitType::class)
				  ->getForm();
				  
				  
	 $form->handleRequest($request);
     if ( $form->isSubmitted() && $form->isValid())
     { 
	 $joedoe=$repo->findOneBy(['email'=>'joedoe@gmail.com']);
		$data= $form->getData();
		$pin =new Pine();
		$pin->setTitle($data['title']);
		$pin->setDescription($data['description']);
		$pin->setUser($joedoe);
		
        $em->persist($pin);
		$em->flush();
         $this->addFlash('success','pin added successfully');
         $this->redirectToRoute('app_home');
		
	 }		 
				  
	  
	  return $this->render('pins/create.html.twig',['form'=>$form->createView()]);
  }
  
  
  
   #[Route('/pins/{id}<[0-9]+>/editer', name: 'app_editer')]
  public function Editer(Pine $pine, EntityManagerInterface $em,Request $request):Response {
	

	   $form=$this->createFormBuilder($pine)
	              ->add('title',TextType::class)
				  ->add('description',TextareaType::class)
				  ->add('submit',SubmitType::class)
				  ->getForm();
				  
			$id = $pine->getId();  
	 $form->handleRequest($request);
     if ( $form->isSubmitted() && $form->isValid()){
		 $em->flush();
		 
		  $this->addFlash('success','pin updated successfully');
		  return $this->redirectToRoute('app_show',['id'=>$pine->getId(),$pine]);
	 }
		 
 return  $this->render('pins/editer.html.twig',['form'=>$form->createView(),'id'=>$id,'pine'=>$pine]);	
  }
  #[Route('/pins/{id}<[0-9]+>/remove', name: 'app_remove')]
  public function remove(EntityManagerInterface $em,Pine $pine){
	
	$em->remove($pine);
	$em->flush();
	 $this->addFlash('info','pin deleted successfully');
	return $this->redirectToRoute('app_home');
  }
  
  
  
  
}
