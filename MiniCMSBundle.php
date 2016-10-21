<?php
namespace MiniCMSBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MiniCMSBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}