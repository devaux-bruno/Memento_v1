<?php

namespace App\Repository;

use App\Entity\Likesystem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Likesystem|null find($id, $lockMode = null, $lockVersion = null)
 * @method Likesystem|null findOneBy(array $criteria, array $orderBy = null)
 * @method Likesystem[]    findAll()
 * @method Likesystem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeSystemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Likesystem::class);
    }

    public function findIfUserAllReadyVote($userId, $articleId)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.likeUser = :val1')
            ->andWhere('o.likeArticle = :val2')
            ->setParameter('val1', $userId)
            ->setParameter('val2', $articleId)
            ->getQuery()
            ->getResult();
    }

    public function findIfUserVoteYes($userId, $articleId)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.likeUser = :val1')
            ->andWhere('o.likeArticle = :val2')
            ->andWhere('o.likeNote = :val3')
            ->setParameter('val1', $userId)
            ->setParameter('val2', $articleId)
            ->setParameter('val3', 'yes')
            ->getQuery()
            ->getResult();
    }

    public function findIfUserVoteNo($userId, $articleId)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.likeUser = :val1')
            ->andWhere('o.likeArticle = :val2')
            ->andWhere('o.likeNote = :val3')
            ->setParameter('val1', $userId)
            ->setParameter('val2', $articleId)
            ->setParameter('val3', 'no')
            ->getQuery()
            ->getResult();
    }

}