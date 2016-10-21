<?php
namespace MiniCMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontendController extends Controller
{
	public function homeAction()
	{
		return $this->render('MiniCMSBundle:Frontend:home.html.twig');
	}
}