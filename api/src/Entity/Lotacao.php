<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    paginationItemsPerPage: 10,
    operations: [
        new Get('lotacao/{id}'),
        new Post('lotacao'),
        new GetCollection('lotacoes'),
    ],
    normalizationContext: [
        'groups' => [self::GROUP_READ_LOTACAO]
    ],
    denormalizationContext: [
        'groups' => [self::GROUP_WRITE_LOTACAO]
    ],
)]
class Lotacao
{
    private const GROUP_READ_LOTACAO = 'read:lotacao';
    private const GROUP_WRITE_LOTACAO = 'write:lotacao';

    private const READING_GROUPS = [
        self::GROUP_READ_LOTACAO,
    ];

    private const GROUPS = [
        self::GROUP_READ_LOTACAO,
        self::GROUP_WRITE_LOTACAO,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        name: 'lot_id',
        type: Types::INTEGER
    )]
    #[Groups(self::READING_GROUPS)]
    private ?int $id = null;

    #[ORM\OneToOne(
        targetEntity: Pessoa::class,
        inversedBy: 'lotacao',
    )]
    #[ORM\JoinColumn(
        name: 'pes_id',
        referencedColumnName: 'pes_id',
        nullable: false,
        unique: true
    )]
    #[Groups(self::GROUPS)]
    private Pessoa $pessoa;

    #[ORM\ManyToOne(targetEntity: Unidade::class)]
    #[ORM\JoinColumn(
        name: 'unid_id',
        referencedColumnName: 'unid_id',
        nullable: true
    )]
    #[Groups(self::GROUPS)]
    private ?Unidade $unidade = null;

    #[ORM\Column(
        name: 'lot_data_lotacao',
        type: Types::DATE_MUTABLE,
        nullable: false
    )]
    #[Groups(self::GROUPS)]
    private \DateTimeInterface $dataLotacao;

    #[ORM\Column(
        name: 'lot_data_remocao',
        type: Types::DATE_MUTABLE,
        nullable: true
    )]
    #[Groups(self::GROUPS)]
    private ?\DateTimeInterface $dataRemocao = null;

    #[ORM\Column(
        name: 'lot_portaria',
        length: 100
    )]
    #[Groups(self::GROUPS)]
    private string $portaria;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPessoa(): Pessoa
    {
        return $this->pessoa;
    }

    public function setPessoa(Pessoa $pessoa): self
    {
        $this->pessoa = $pessoa;

        return $this;
    }

    public function getUnidade(): ?Unidade
    {
        return $this->unidade;
    }

    public function setUnidade(?Unidade $unidade): self
    {
        $this->unidade = $unidade;

        return $this;
    }

    public function getDataLotacao(): \DateTimeInterface
    {
        return $this->dataLotacao;
    }

    public function setDataLotacao(\DateTimeInterface $dataLotacao): self
    {
        $this->dataLotacao = $dataLotacao;

        return $this;
    }

    public function getDataRemocao(): \DateTimeInterface
    {
        return $this->dataRemocao;
    }

    public function setDataRemocao(\DateTimeInterface $dataRemocao): self
    {
        $this->dataRemocao = $dataRemocao;

        return $this;
    }

    public function getPortaria(): string
    {
        return $this->portaria;
    }

    public function setPortaria(string $portaria): self
    {
        $this->portaria = $portaria;

        return $this;
    }
}
