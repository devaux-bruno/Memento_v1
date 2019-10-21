<?php

namespace App\Repository;

use App\Entity\Likesystem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
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

    public function findTopMemento()
    {
        $rawSql = "SELECT a.*,  AVG(l.like_note) as nbrnote , u.*
                    FROM articles a, likesystem l , users u
                    WHERE a.article_id = l.like_article_id
                    AND a.article_user_id = u.user_id
                    AND l.like_note = 'yes'
                    GROUP BY a.article_id ORDER BY nbrnote DESC LIMIT 0,10";

        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        } catch (DBALException $e) {
        }
        $stmt->execute([]);

        return $stmt->fetchAll();
    }

}