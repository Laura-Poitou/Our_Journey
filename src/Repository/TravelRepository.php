<?php

namespace App\Repository;

use App\Entity\Travel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Travel>
 *
 * @method Travel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Travel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Travel[]    findAll()
 * @method Travel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TravelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Travel::class);
    }

    public function save(Travel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Travel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return [] Returns an array of user travels
    */
    public function findAllByUser($user): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT *
        FROM `travel`
        INNER JOIN `user_travel` ON `user_travel`.`travel_id` = `travel`.`id`
        WHERE `user_id` = :userId
        ORDER BY `travel`.`title` ASC';

        $statement = $connection->prepare($sql);       
        $resultSet = $statement->executeQuery(['userId' => $user->getId()]);

        return $resultSet->fetchAllAssociative();

    }

    /**
    * @return [] Returns an array of all articles related to a user travel
    */
    public function findTravelAndArticles($user, $travel): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "
        SELECT `article`.*
        FROM `travel`
        INNER JOIN `user_travel` ON `user_travel`.`travel_id` = `travel`.`id`
        INNER JOIN `article` ON `travel`.`id` = `article`.`travel_id`
        WHERE `user_id` = :userId AND `travel`.`id` = :travelId";

        $statement = $connection->prepare($sql);       
        $resultSet = $statement->executeQuery(['userId' => $user->getId(), 'travelId' => $travel->getId()]);

        return $resultSet->fetchAllAssociative();

    }

    /**
    * @return [] Returns an article related to a user travel
    */
    public function findTravelArticle($user, $travel, $article): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "
        SELECT `article`.*
        FROM `travel`
        INNER JOIN `user_travel` ON `user_travel`.`travel_id` = `travel`.`id`
        INNER JOIN `article` ON `travel`.`id` = `article`.`travel_id`
        WHERE `user_id` = :userId AND `travel`.`id` = :travelId AND `article`.`id` = :articleId";

        $statement = $connection->prepare($sql);       
        $resultSet = $statement->executeQuery(['userId' => $user->getId(), 'travelId' => $travel->getId(), 'articleId' => $article->getId()]);

        return $resultSet->fetch();

    }

    /**
    * @return [] Returns an array of all destinations related to a user travel
    */
    public function findTravelDestinations($user, $travel): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "
        SELECT `destination`.*, `travel`.`id` AS 'travel_id'
        FROM `travel`
        INNER JOIN `user_travel` ON `user_travel`.`travel_id` = `travel`.`id`
        INNER JOIN `travel_destination` ON `travel`.`id` = `travel_destination`.`travel_id`
        INNER JOIN `destination` ON `destination`.`id` = `travel_destination`.`destination_id`
        WHERE `user_id` = :userId AND `travel`.`id` = :travelId";

        $statement = $connection->prepare($sql);       
        $resultSet = $statement->executeQuery(['userId' => $user->getId(), 'travelId' => $travel->getId()]);

        return $resultSet->fetchAllAssociative();

    }



}
