<?php

namespace App\Repository;

use App\Entity\Rate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Article;

/**
 * @method Rate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rate[]    findAll()
 * @method Rate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rate::class);
    }
    
    public function getSumValuesByArticle(Article $article)
    {
        $qb = $this->getEntityManager()->createQueryBuilder('c');
        $qb->select('SUM(r.value) as value, COUNT(r.value) as amount');
        $qb->from('App:Rate', 'r');
        $qb->where('r.article = :article');
        $qb->setParameter('article', $article->getId());
        
        return $qb->getQuery()->getSingleResult();
    }
    
}
