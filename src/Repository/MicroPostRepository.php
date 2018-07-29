<?php

namespace App\Repository;

use App\Entity\MicroPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\RegistryInterface;
//use App\Entity\User;

/**
 * @method MicroPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method MicroPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method MicroPost[]    findAll()
 * @method MicroPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MicroPostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MicroPost::class);
    }

    // version #1
    public function findAllByUsers(Collection $users)
    {
        return $this->createQueryBuilder('p')
            ->where('p.user IN (:following)')
            ->setParameter('following', $users)
            ->orderBy('p.time', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // version #2
    /*public function findAllByUsers($userIds)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin(
                User::class,
                'u',
                'WITH',
                'p.user = u.id'
            )
            ->where('u.id IN (:following)')
            ->setParameter('following', $userIds)
            ->orderBy('p.time', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }*/
}
