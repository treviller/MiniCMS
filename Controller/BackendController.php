<?php
namespace MiniCMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MiniCMSBundle\Entity\Page;
use MiniCMSBundle\Form\Type\PageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BackendController extends Controller
{
	public function homeAction()
	{
		$em = $this->getDoctrine()->getManager();

		$pages = $em->getRepository('MiniCMSBundle:Page')->findAll();

		return $this->render('MiniCMSBundle:Backend:home.html.twig', array('pages' => $pages));
	}

	public function addAction(Request $request)
	{
		$page = new Page();

		$form = $this->get('form.factory')->create(PageType::class, $page);

		if($request->isMethod("post") && $form->handleRequest($request)->isValid())
		{
			$page->setDateCreation(new \Datetime());
			$page->setDateModif(new \Datetime());
			$em = $this->getDoctrine()->getManager();
			$em->persist($page);
			$em->flush();
				
			$request->getSession()->getFlashBag()->add('info', 'Page added !');
			return $this->redirectToRoute('backend_home');
		}

		return $this->render('MiniCMSBundle:Backend:add.html.twig', array('form' => $form->createView()));
	}

	public function editAction($slug, Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$page = $em->getRepository('MiniCMSBundle:Page')->findOneBy(array('slug' => $slug));

		if($page === null)
			throw new NotFoundHttpException('La page est introuvable');

			$form = $this->get('form.factory')->create(PageType::class, $page);

			if($request->isMethod("post") && $form->handleRequest($request)->isValid())
			{
				$page->setDateModif(new \Datetime());
				$em->persist($page);
				$em->flush();

				$request->getSession()->getFlashBag()->add('info', 'Page edited !');
				return $this->redirectToRoute('backend_home');
			}

			return $this->render('MiniCMSBundle:Backend:edit.html.twig', array('page' => $page, 'form' => $form->createView()));
	}

	public function deleteAction($slug, Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$page = $em->getRepository('MiniCMSBundle:Page')->findOneBy(array('slug' => $slug));

		if($page === null)
			throw new NotFoundHttpException('La page est introuvable');

			if($request->isMethod("post"))
			{
				$em->remove($page);
				$em->flush();
					
				$request->getSession()->getFlashBag()->add('info', 'The page was correctly deleted.');
				return $this->redirectToRoute('backend_home');
			}

			return $this->render('MiniCMSBundle:Backend:delete.html.twig', array('page' => $page));
	}
	
	public function sethomeAction($slug)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('MiniCMSBundle:Page');
	
		$pageHome = $repository->findOneBy(array('homepage' => true));
		$page = $repository->findOneBy(array('slug' => $slug));
	
		if($page === null)
			throw new NotFoundHttpException('Page not found !');
	
			if($pageHome !== null)
			{
				$pageHome->setHomepage(false);
				$em->persist($pageHome);
			}
	
			$page->setHomepage(true);
			$em->persist($page);
			$em->flush();
			return $this->redirectToRoute('mini_cms_backend_home');
	}
}