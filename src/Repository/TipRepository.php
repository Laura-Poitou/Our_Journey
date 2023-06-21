<?php

namespace App\Repository;

use App\Entity\Tip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tip>
 *
 * @method Tip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tip[]    findAll()
 * @method Tip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tip::class);
    }

    public function save(Tip $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tip $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return [] Returns tips related to a user travel article
    */
    public function findArticleTips($user, $article): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "
        SELECT `tip`.*, `user`.`nickname`
        FROM `tip`
        INNER JOIN `article` ON `article`.`id` = `tip`.`article_id`
        INNER JOIN `user` ON `user`.`id` = `tip`.`user_id`
        WHERE `user_id` = :userId AND `article`.`id` = :articleId";

        $statement = $connection->prepare($sql);       
        $resultSet = $statement->executeQuery(['userId' => $user->getId(), 'articleId' => $article->getId()]);

        return $resultSet->fetchAllAssociative();

    }

//    /**
//     * @return Tip[] Returns an array of Tip objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tip
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
