<?php

namespace App\Repository;

use App\Entity\ServidorEfetivo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ServidorEfetivoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServidorEfetivo::class);
    }

    public function findByUnidadeId($unidadeId): array
    {
        $qb = $this->createQueryBuilder('se');

        $qb->join('se.pessoa', 'p')
            ->join('p.lotacao', 'l')
            ->join('l.unidade', 'u')
            ->where('u.id = :unidadeId')
            ->setParameter('unidadeId', $unidadeId);

        return $qb->getQuery()->getResult();
    }
}
