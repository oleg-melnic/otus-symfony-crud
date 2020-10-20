<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, News::class);
        $this->entityManager = $entityManager;
    }

    public function save($data)
    {
        $item = new News();
        $item->setTitle($data['title'])
            ->setText($data['text']);

        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }

    public function update(?News $newsItem): News
    {
        $this->entityManager->persist($newsItem);
        $this->entityManager->flush();

        return $newsItem;
    }

    public function remove(?News $newsItem)
    {
        $this->entityManager->remove($newsItem);
        $this->entityManager->flush();
    }
}
