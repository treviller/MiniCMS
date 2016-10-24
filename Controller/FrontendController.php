<?php
namespace MiniCMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
		
		if($category == "uncategorized")
		{
			$category = null;
		}
		
		$page = $em->getRepository('MiniCMSBundle:Page')->findOneBy(array('category' => $category, 'slug' => $slug));
		
		if($page === null)
		{
			throw new NotFoundHttpException('Page not found !');
		}
		
		return $this->render('MiniCMSBundle:Frontend:view.html.twig', array('page' => $page));
	}
}
