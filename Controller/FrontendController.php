<?php
namespace MiniCMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MiniCMSBundle\Entity\Page;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

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
		$repo = $this->getDoctrine()->getManager()->getRepository('MiniCMSBundle:Page');
		$homepage = $repo->findOneBy(array('homepage' => true));
		$pages = $repo->listPages();
		
		if($homepage === null)
			return $this->render('MiniCMSBundle:Frontend:home.html.twig', array('pages' => $pages));
		
		return $this->render('MiniCMSBundle:Frontend:view.html.twig', array('homepage' => $homepage, 'pages' => array()));
	}
	
	 /**
	  * url'/{category}/{slug}'
	  * 
	  * @param string $slug
	  * @return \Symfony\Component\HttpFoundation\Response
	  * @throws NotFoundHttpException
	  */
	public function viewAction(Request $request, $category, $slug)
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
				{
					$request->getSession()->getFlashbag()->add('warning', 'You need to be logged to access to this page.');
					return $this->redirectToRoute('login');
				}
					
			break;
		}
		
		$pages = $em->getRepository('MiniCMSBundle:Page')->listPages();
		
		return $this->render('MiniCMSBundle:Frontend:view.html.twig', array('actualPage' => $page, 'pages' => $pages));
	}
}
