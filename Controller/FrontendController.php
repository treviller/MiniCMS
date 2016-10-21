<?php
namespace MiniCMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontendController extends Controller
{
	/**
	 * 'frontend_home' '/'
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function homeAction()
	{
		return $this->render('MiniCMSBundle:Frontend:home.html.twig');
	}

	/**
	 * 'frontend_view', '/page/{title}'
	 * @param string $title
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function viewAction($title)
	{
		$view = null;

		if($view === null)
		{
			return $this->redirectToRoute('frontend_home');
		}

		return $this->render($view);
	}
}