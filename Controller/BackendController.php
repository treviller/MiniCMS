<?php
namespace MiniCMSBundle\Controller;

use MiniCMSBundle\Entity\Page;
use MiniCMSBundle\Form\Type\CategoryType;
use MiniCMSBundle\Form\Type\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MiniCMSBundle\Entity\Category;

/**
 * Controller for backend part of the bundle
 * 
 * @author Tanguy Reviller
 */
class BackendController extends Controller
{
	/**
	 * url'/admin/home'
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function homeAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$pages = $em->getRepository('MiniCMSBundle:Page')->findPagesAndCategories();
		
		return $this->render('MiniCMSBundle:Backend:home.html.twig', array('pages' => $pages));
	}
	
	/**
	 * url '/admin/add'
	 * 
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function addAction(Request $request)
	{
		$page = new Page();
		
		$form = $this->get('form.factory')->create(PageType::class, $page, array('access_level' => $this->container->getParameter('default_access_level')));
		
		if($request->isMethod("post") && $form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			
			if($page->getHomepage() == true)
			{
				$this->checkHomepage($em);
			}
			
			if($page->getAccess() === null)
			{
				$page->setAccess($this->container->getParameter('default_access_level'));
			}
			
			$em->persist($page);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('info', 'Page successfully added !');
			return $this->redirectToRoute('mini_cms_backend_home');
		}
		
		return $this->render('MiniCMSBundle:Backend:add.html.twig', array('form' => $form->createView()));
	}
	
	/**
	 * url '/admin/update/{slug}'
	 * 
	 * @param string $slug
	 * @param Request $request
	 * @throws NotFoundHttpException
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function editAction($slug, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		
		$page = $em->getRepository('MiniCMSBundle:Page')->findOneBy(array('slug' => $slug));
		
		if($page === null)
			throw new NotFoundHttpException('This page doesn\'t exist');
		
		$form = $this->get('form.factory')->create(PageType::class, $page, array('access_level' => $this->container->getParameter('default_access_level')));
		
		if($request->isMethod("post") && $form->handleRequest($request)->isValid())
		{
			if($page->getHomepage() == true)
			{
				$this->checkHomepage($em);
			}
				
			$em->persist($page);
			$em->flush();
				
			$request->getSession()->getFlashBag()->add('info', 'Page successfully edited !');
			return $this->redirectToRoute('mini_cms_backend_home');
		}
		
		return $this->render('MiniCMSBundle:Backend:edit.html.twig', array('page' => $page, 'form' => $form->createView()));
	}
	
	/**
	 * url '/admin/delete/{slug}'
	 * 
	 * @param string $slug
	 * @param Request $request
	 * @throws NotFoundHttpException
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function deleteAction($slug, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		
		$page = $em->getRepository('MiniCMSBundle:Page')->findOneBy(array('slug' => $slug));
		
		if($page === null)
			throw new NotFoundHttpException('This page does not exist.');
		
		if($request->isMethod("post"))
		{
			$em->remove($page);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('info', 'The page was correctly deleted.');
			return $this->redirectToRoute('mini_cms_backend_home');
		}
		
		return $this->render('MiniCMSBundle:Backend:delete.html.twig', array('page' => $page));
	}
	
	/**
	 * 
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function addCategoryAction(Request $request)
	{
		$category = new Category();
		
		$form = $this->get('form.factory')->create(CategoryType::class, $category);
		
		if($request->isMethod('post') && $form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($category);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('info', 'Category successfully added !');
			
			return $this->redirectToRoute('mini_cms_backend_home');
		}
		
		return $this->render('MiniCMSBundle:Backend:addCategory.html.twig', array('form' => $form->createView()));
	}
	
	public function checkHomepage($em)
	{
		$pageHome = $em->getRepository('MiniCMSBundle:Page')->findOneBy(array('homepage' => true));
		
		if($pageHome !== null)
		{
			$pageHome->setHomepage(false);
			$em->persist($pageHome);
		}
	}
}
