<?php

namespace App\Repository;

use App\Entity\Pessoa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PessoaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pessoa::class);
    }

    public function findEnderecosFuncionaisByNome(string $nome): array
    {
        $qb = $this->createQueryBuilder('p');

        $expr = $qb->expr();

        $qb
            ->innerJoin('p.enderecos', 'e')
            ->where($expr->like('p.nome', ':nome'))
            ->setParameter('nome', "%{$nome}%")
        ;

        return $qb->getQuery()->getResult();
    }
}
