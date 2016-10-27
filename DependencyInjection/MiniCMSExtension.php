<?php
namespace MiniCMSBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

/**
 * 
 * @author Tanguy Reviller
 * 
 */
class MiniCMSExtension extends Extension
{
	/**
	 * 
	 * {@inheritDoc}
	 * @see \Symfony\Component\DependencyInjection\Extension\ExtensionInterface::load()
	 */
	public function load(array $configs, ContainerBuilder $container)
	{
		$configuration = new Configuration();

		$config = $this->processConfiguration($configuration, $configs);
		
		if($config['default_access_level'] == 'admin')
			$container->setParameter('default_access_level', 2);
		elseif($config['default_access_level'] == 'member')
			$container->setParameter('default_access_level', 1);
		else
			$container->setParameter('default_access_level', 0);
		
		$container->setParameter('page_versioning', $config['versioning']);

		$loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

		$loader->load('services.yml');
	}
}
