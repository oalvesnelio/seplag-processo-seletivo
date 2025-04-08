<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    paginationItemsPerPage: 10,
    operations: [
        new Get('servidor-temporario/{id}'),
        new Put('servidor-temporario/{id}'),
        new Post('servidor-temporario'),
        new GetCollection('servidores-temporarios'),
    ],
    normalizationContext: [
        'groups' => [self::GROUP_READ_SERVIDOR_TEMPORARIO]
    ],
    denormalizationContext: [
        'groups' => [self::GROUP_WRITE_SERVIDOR_TEMPORARIO]
    ],
)]
class ServidorTemporario
{
    private const GROUP_READ_SERVIDOR_TEMPORARIO = 'read:pessoa-temporario';
    private const GROUP_WRITE_SERVIDOR_TEMPORARIO = 'write:pessoa-temporario';

    private const GROUPS = [
        self::GROUP_READ_SERVIDOR_TEMPORARIO,
        self::GROUP_WRITE_SERVIDOR_TEMPORARIO,
    ];
    #[
        ORM\Id,
        ORM\OneToOne(
            targetEntity: Pessoa::class
        )
    ]
    #[ORM\JoinColumn(
        name: 'pes_id',
        referencedColumnName: 'pes_id'
    )]
    #[Groups(self::GROUPS)]
    private Pessoa $pessoa;

    #[ORM\Column(
        name: 'st_data_admissao',
        type: Types::DATE_MUTABLE
    )]
    #[Groups(self::GROUPS)]
    private \DateTimeInterface $dataAdmissao;

    #[ORM\Column(
        name: 'st_data_demissao',
        type: Types::DATE_MUTABLE,
        nullable: true
    )]
    #[Groups(self::GROUPS)]
    private ?\DateTimeInterface $dataDemissao = null;

    public function getPessoa(): Pessoa
    {
        return $this->pessoa;
    }

    public function setPessoa(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;

        return $this;
    }

    public function getDataAdmissao(): \DateTimeInterface
    {
        return $this->dataAdmissao;
    }

    public function setDataAdmissao(\DateTimeInterface $dataAdmissao)
    {
        $this->dataAdmissao = $dataAdmissao;

        return $this;
    }

    public function getDataDemissao(): ?\DateTimeInterface
    {
        return $this->dataDemissao;
    }

    public function setDataDemissao(?\DateTimeInterface $dataDemissao)
    {
        $this->dataDemissao = $dataDemissao;

        return $this;
    }
}
