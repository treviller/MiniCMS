<?php
namespace MiniCMSBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Tanguy Reviller
 * @see Symfony\Component\HttpKernel\Bundle\Bundle and FOS\UserBundle\FOSUserBundle
 */
class MiniCMSBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
