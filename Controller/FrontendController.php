<?php
namespace MiniCMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MiniCMSBundle\Entity\Page;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/** 
 * Controller for frontend part of the bundle
 * 
 * @author Tanguy Reviller
 */
class FrontendController extends Controller
{
	/**
	 * url'/'
	 * 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function homeAction()
	{
		$page = $this->getDoctrine()->getManager()->getRepository('MiniCMSBundle:Page')->findOneBy(array('homepage' => true));
		
		if($page === null)
			return $this->render('MiniCMSBundle:Frontend:home.html.twig');
		return $this->render('MiniCMSBundle:Frontend:view.html.twig', array('page' => $page));
	}
	
	 /**
	  * url'/{category}/{slug}'
	  * 
	  * @param string $slug
	  * @return \Symfony\Component\HttpFoundation\Response
	  * @throws NotFoundHttpException
	  */
	public function viewAction($category, $slug)
	{
		$page = null;
		
		$em = $this->getDoctrine()->getManager();
		
		$page = $em->getRepository('MiniCMSBundle:Page')->findPageByCategory($category, $slug);
		
		if($page === null)
		{
			throw new NotFoundHttpException('Page not found !');
		}
			
		switch($page->getAccess())
		{
			case Page::ACCESS_ADMIN:
				if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
					throw new AccessDeniedException('Access reserved.');
			break;
			case Page::ACCESS_MEMBER:
				if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
					return $this->redirectToRoute('login');
			break;
		}
		return $this->render('MiniCMSBundle:Frontend:view.html.twig', array('page' => $page));
	}
}
