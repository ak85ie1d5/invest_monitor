<?php

namespace App\Repository;

use App\Entity\ArticleArchive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticleArchive>
 */
class ArticleArchiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleArchive::class);
    }

    /**
     * Returns, among the given links, those already stored in database.
     *
     * @param string[] $links
     *
     * @return string[]
     */
    public function findExistingLinks(array $links): array
    {
        if (!$links) {
            return [];
        }

        return $this->createQueryBuilder('a')
            ->select('a.link')
            ->where('a.link IN (:links)')
            ->setParameter('links', $links)
            ->getQuery()
            ->getSingleColumnResult();
    }

    /**
     * @throws Exception
     */
    public function findAllSortedByDate(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT `aa`.`title`, `aa`.`publication_date`, `aa`.`link`
            FROM `article_archive` `aa`
            ORDER BY `aa`.`publication_date` DESC;
        ';

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return ArticleArchive[] Returns an array of ArticleArchive objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ArticleArchive
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
