<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllWithTags() {
        return $this->createQueryBuilder('p')
                ->leftJoin('p.tags', 't')
                ->addSelect('t')
                ->getQuery()
                ->getResult();
    }
    
    public function findByTagWithTags($tag) {
        return $this->createQueryBuilder('p')
                ->leftJoin('p.tags', 't')
                ->leftJoin(Product::class, 'p2', Join::WITH, 'p2.id = p.id')
                ->leftJoin('p2.tags', 't2')
                ->addSelect('t')
                ->where('t2.id = :id')
                ->setParameter(':id', $tag->getId())
                ->getQuery()
                ->getResult();
    }
    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
