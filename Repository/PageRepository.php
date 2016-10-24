<?php

namespace MiniCMSBundle\Repository;

/**
 * DAO for page entities
 * 
 * @author Tanguy Reviller
 */
class PageRepository extends \Doctrine\ORM\EntityRepository
{
	public function findPageByCategory($category, $slug)
	{
		$query = $this->createQueryBuilder('a');
		
		$query
			->leftJoin('a.category', 'cat')
			->addSelect('cat')
			->where('a.slug = :slug')
			->andWhere('cat.name = :cat')
			->setParameter(':slug', $slug)
			->setParameter(':cat', $category);
		
		return $query->getQuery()->getOneOrNullResult();
	}
}
