<?php
namespace MiniCMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="MiniCMSBundle\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class User implements UserInterface
{
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @var string
	 * @ORM\Column(name="username", type="string", length=255, unique=true)
	 */
	private $username;
	
	/**
	 * 
	 * @var string
	 * @ORM\Column(name="email", type="string", length=255, unique=true)
	 * @Assert\Email()
	 * @Assert\NotBlank()
	 */
	private $email;
	
	/**
	 * 
	 * @var string
	 * @ORM\Column(name="password", type="string", length=255)
	 */
	private $password;
	
	/**
	 * 
	 * @var string
	 * @ORM\Column(name="salt", type="string", length=255)
	 */
	private $salt;
	
	/**
	 * 
	 * @var string
	 * @ORM\Column(name="roles", type="array")
	 */
	private $roles;

	
	/**
	 * 
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * 
	 * @param string $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}
	
	/**
	 * 
	 * @param string $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}
	
	/**
	 * 
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}
	
	/**
	 * 
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getSalt()
	{
		return $this->salt;
	}
	
	/**
	 * 
	 * @param string $salt
	 */
	public function setSalt($salt)
	{
		$this->salt = $salt;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getRole()
	{
		return $this->role;
	}
	
	/**
	 * 
	 * @param array $role
	 */
	public function setRoles($role)
	{
		$this->roles = $role;
	}
	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getRoles()
	 */
	public function getRoles() {
		return $this->roles;
	}

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
	 */
	public function eraseCredentials() {
		// TODO: Auto-generated method stub

	}

}
