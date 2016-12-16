<?php
namespace MiniCMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MiniCMSBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use MiniCMSBundle\Entity\User;

class UsersController extends Controller
{
	public function loginAction(Request $request)
	{
		$user = new User();
		
		$form = $this->get('form.factory')->create(UserType::class, $user);
		
		if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
		{
			return $this->redirectToRoute('mini_cms_frontend_home');
		}
		
		$authenticationUtils = $this->get('security.authentication_utils');
		
		return $this->render('MiniCMSBundle:Users:login.html.twig', array('form' => $form->createView(), 
																		'last_username' => $authenticationUtils->getLastUsername(),
																		'error' => $authenticationUtils->getLastAuthenticationError()));
	}
	
	public function registerAction(Request $request)
	{
		if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
		{
			return $this->redirectToRoute('mini_cms_frontend_home');
		}
		
		$user = new User();
		
		$form = $this->get('form.factory')->create(UserType::class, $user);
		
		if($request->isMethod('post') && $form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			
			$user->setSalt('');
			$user->setRoles(array('ROLE_USER'));
			$em->persist($user);
			$em->flush();
			
			$request->getSession()->getFlashbag()->add('info', 'You are successfully registered.');
			return $this->redirectToRoute('login');
		}
		return $this->render('MiniCMSBundle:Users:register.html.twig', array('form' => $form->createView()));
	}
}