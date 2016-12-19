<?php
namespace MiniCMSBundle\Command;

use MiniCMSBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this->setName('minicms:create-admin')
			->setDescription('Create new admin user.')
			->addArgument('username', InputArgument::REQUIRED, 'Username of admin user.')
			->addArgument('password', InputArgument::REQUIRED, 'Password of this user.')
			->addArgument('email', InputArgument::REQUIRED, 'Email of the administrator.');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$em = $this->getContainer()->get('doctrine.orm.entity_manager');
		$encoder = $this->getContainer()->get('security.password_encoder');
		
		$adminUser = new User();
		
		$adminUser->setEmail($input->getArgument('email'));
		$adminUser->setUsername($input->getArgument('username'));
		$adminUser->setPassword($encoder->encodePassword($adminUser, $input->getArgument('password')));
		$adminUser->setSalt('');
		$adminUser->setRoles(array('ROLE_ADMIN'));
		
		$em->persist($adminUser);
		$em->flush();
		
		$output->writeln('');
		$output->writeln('Admin user created !');
	}
}
