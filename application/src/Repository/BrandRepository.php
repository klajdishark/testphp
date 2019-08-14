<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Brand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brand[]    findAll()
 * @method Brand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(RegistryInterface $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Brand::class);
        $this->entityManager = $entityManager;
    }


    /**
     * @param Brand $brand
     */
    public function save(Brand $brand){
        $this->entityManager->persist($brand);
        $this->entityManager->flush();
    }

    /**
     * @param Brand $brand
     */
    public function delete(Brand $brand){
        $this->entityManager->remove($brand);
        $this->entityManager->flush();
    }
}
