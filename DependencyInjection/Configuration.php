<?php

namespace MiniCMSBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('mini_cms');

		$rootNode
			->children()
				->enumNode('default_access_level')
					->defaultValue('public')
					->values(array('public', 'member', 'admin'))
				->end()
			->end()
		;
		
		return $treeBuilder;
	}
}
