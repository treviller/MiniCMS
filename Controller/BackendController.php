<?php
namespace MiniCMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackendController extends Controller
{
	public function homeAction()
	{

		return $this->render('MiniCMSBundle:Backend:home.html.twig');
	}

	public function addAction()
	{
		return $this->render('MiniCMSBundle:Backend:add.html.twig');
	}

	public function updateAction()
	{
		return $this->render('MiniCMSBundle:Backend:edit.html.twig');
	}

	public function deleteAction()
	{
		return $this->render('MiniCMSBundle:Backend:delete.html.twig');
	}
}