<?php
namespace MiniCMSBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This class provides a Tinymce implementation for a use in Twig
 * 
 * @author Tanguy Reviller
 *
 */
class TinymceImpl extends \Twig_Extension
{
	/**
	 * @var Symfony\Component\DependencyInjection\ContainerInterface
	 */
	private $container;
	
	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * Twig function
	 * 
	 * @return string
	 */
	public function tinymceInit()
	{
		$globals = $this->container->get('twig')->getGlobals();
		
		$appFunction = $globals['app'];
		
		$content ="<script src=\"".$appFunction->getRequest()->getBasePath()."/bundles/minicms/tinymce/tinymce.min.js\"></script>.
				   <script src=\"".$appFunction->getRequest()->getBasePath()."/bundles/minicms/tinymce/jquery.tinymce.min.js\"></script>
				   <script type=\"text/javascript\">tinymce.init({
																	selector: '.tinymce',
																	height: 500,
																	plugins: [
																			'advlist autolink lists link image charmap print preview anchor',
																			'searchreplace visualblocks code fullscreen',
																			'insertdatetime media table contextmenu paste code'
																	],
																	toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
					});</script>";

		return $content;
	}

	/**
	 * 
	 * {@inheritDoc}
	 * @see Twig_Extension::getFunctions()
	 */
	public function getFunctions()
	{
		return array(new \Twig_SimpleFunction('tinymceInit', array($this, 'tinymceInit'), array('is_safe' => array('html'))));
	}
}
