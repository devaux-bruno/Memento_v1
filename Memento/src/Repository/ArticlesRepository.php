<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    public function findAll()
    {
        return $this->findBy(array(),['articleCreateAt' => 'Desc']);
    }


    public function findArticleBySearch($term)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.articleMotsCles LIKE :searchTerm OR p.articleDescription LIKE :searchTerm OR p.articleTitle LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$term.'%')
            ->getQuery()
            ->getResult()
            ;
    }


}