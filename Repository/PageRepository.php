<?php

namespace MiniCMSBundle\Repository;

/**
 * DAO for page entities
 * 
 * @author Tanguy Reviller
 */
class PageRepository extends \Doctrine\ORM\EntityRepository
{
	/**
	 * Get page with its category
	 * 
	 * @param string $category
	 * @param string $slug
	 * @return mixed|NULL
	 */
	public function findPageByCategory($category, $slug)
	{
		$query = $this->createQueryBuilder('a');
		
		$query
			->leftJoin('a.category', 'cat')
			->addSelect('cat')
			->where('a.slug = :slug')
			->andWhere('cat.slug = :cat')
			->setParameter(':slug', $slug)
			->setParameter(':cat', $category);
		
		return $query->getQuery()->getOneOrNullResult();
	}

	/**
	 * Get all pages with their categories
	 * 
	 * @return array
	 */
	public function findPagesAndCategories()
	{
		$query = $this->createQueryBuilder('a');
		
		$query
			->leftJoin('a.category', 'cat')
			->addSelect('cat')
		;
		
		return $query->getQuery()->getArrayResult();
	}
	
	public function listPages()
	{
		$query = $this->createQueryBuilder('p');
		
		$query->innerJoin('p.category', 'c')
			->addSelect('c');
		
		return $query->getQuery()->getResult();
	}
}
