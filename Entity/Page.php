<?php
namespace MiniCMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * This class represents page entities in database
 *
 * @author Tanguy Reviller
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="MiniCMSBundle\Repository\PageRepository")
 */
class Page
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="string", length=255)
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="contenu", type="text")
	 */
	private $content;

	/**
	 * @var string
	 *
	 * @Gedmo\Slug(fields={"title"})
	 * @ORM\Column(name="slug", type="string", length=255, unique=true)
	 */
	private $slug;

	/**
	 * @var \DateTime
	 * @ORM\Column(name="dateCreation", type="datetime")
	 */
	private $dateCreation;

	/**
	 * @var \DateTime
	 * @ORM\Column(name="dateUpdate", type="datetime")
	 */
	private $dateUpdate;

	/**
	 * @var boolean
	 * @ORM\Column(name="homepage", type="boolean")
	 */
	private $homepage;

	/**
	 * @ORM\ManyToOne(targetEntity="MiniCMSBundle\Entity\Category")
	 */
	private $category;
	
	/**
	 * 
	 * @param \MiniCMSBundle\Entity\Category $category
	 */
	public function setCategory(Category $category)
	{
		$this->category = $category;
	}
	
	/**
	 * 
	 * @return \MiniCMSBundle\Entity\Category
	 */
	public function getCategory()
	{
		return $this->category;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getHomepage()
	{
		return $this->homepage;
	}

	/**
	 * @param boolean $homepage
	 */
	public function setHomepage($homepage)
	{
		$this->homepage = $homepage;
	}

	/**
	 * @return DateTime
	 */
	public function getDateUpdate()
	{
		return $this->dateUpdate;
	}

	/**
	 * @param Datetime $dateModif
	 */
	public function setDateUpdate($dateUpdate)
	{
		$this->dateModif = $dateUpdate;
	}

	/**
	 * @return \DateTime
	 */
	public function getDateCreation()
	{
		return $this->dateCreation;
	}

	/**
	 * @param \DateTime $dateCreation
	 */
	public function setDateCreation($dateCreation)
	{
		$this->dateCreation = $dateCreation;
	}

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 *
	 * @return Page
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set contenu
	 *
	 * @param string $contenu
	 *
	 * @return Page
	 */
	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * Get contenu
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Set slug
	 *
	 * @param string $slug
	 *
	 * @return Page
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;

		return $this;
	}

	/**
	 * Get slug
	 *
	 * @return string
	 */
	public function getSlug()
	{
		return $this->slug;
	}
}

