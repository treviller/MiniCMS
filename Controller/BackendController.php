<?php
namespace MiniCMSBundle\Controller;

use MiniCMSBundle\Entity\Page;
use MiniCMSBundle\Form\Type\CategoryType;
use MiniCMSBundle\Form\Type\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MiniCMSBundle\Entity\Category;
use MiniCMSBundle\Entity\Version;
use Doctrine\ORM\EntityManager;

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
			
			if($this->container->getParameter('page_versioning'))
			{
				$page->updateVersion();
			}
			$em->persist($page);
			$em->flush();
				
			$request->getSession()->getFlashBag()->add('info', 'Page successfully edited !');
			return $this->redirectToRoute('mini_cms_backend_home');
		}
		
		return $this->render('MiniCMSBundle:Backend:edit.html.twig', array('page' => $page, 'form' => $form->createView(), 'versioning' => $this->container->getParameter('page_versioning')));
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
	 * url '/admin/addCat'
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
	
	/**
	 * url '/admin/versions/{slug}'
	 * 
	 * @param string $slug
	 * @throws NotFoundHttpException
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listVersionsAction($slug)
	{
		if($this->container->getParameter('page_versioning') == false)
			throw new NotFoundHttpException('Versioning isn\'t enabled');
		
		$em = $this->getDoctrine()->getManager();

		$versions = $em->getRepository('MiniCMSBundle:Version')->findBySlug($slug);
		
		return $this->render('MiniCMSBundle:Backend:listVersions.html.twig', array('versions' =>$versions));
	}
	
	/**
	 * url '/admin/view/{id}'
	 * 
	 * @param Request $request
	 * @param int $id
	 * @throws NotFoundHttpException
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function viewVersionAction(Request $request, $id)
	{
		if($this->container->getParameter('page_versioning' == false))
			throw new NotFoundHttpException('Versioning isn\'t enabled');
		
		$em = $this->getDoctrine()->getManager();
		
		$version = $em->getRepository('MiniCMSBundle:Version')->findOneByWithPage($id);
		
		if($request->isMethod('post'))
		{
			$page = $version->getPage();
			
			$page->setTitle($version->getTitle());
			$page->setContent($version->getContent());
			
			$em->persist($page);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('info', 'Version successfully changed.');
			
			return $this->redirectToRoute('mini_cms_backend_home');
		}
		
		return $this->render('MiniCMSBundle:Backend:viewVersion.html.twig', array('version' => $version));
	}
	
	/**
	 * Control that there is only one homepage
	 * 
	 * @param EntityManager $em
	 */
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
