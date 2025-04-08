<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity()]
#[ApiResource(
    paginationItemsPerPage: 10,
    operations: [
        new Get('foto-pessoa/{id}'),
        new Post('foto-pessoa'),
        new GetCollection('foto-pessoas'),
    ],
    normalizationContext: [
        'groups' => [self::GROUP_READ_FOTO_PESSOA]
    ],
    denormalizationContext: [
        'groups' => [self::GROUP_WRITE_FOTO_PESSOA]
    ],
)]
class FotoPessoa
{
    private const GROUP_READ_FOTO_PESSOA = 'read:foto-pessoa';
    private const GROUP_WRITE_FOTO_PESSOA = 'write:foto-pessoa';

    private const READING_GROUPS = [
        self::GROUP_READ_FOTO_PESSOA,
    ];

    private const GROUPS = [
        self::GROUP_READ_FOTO_PESSOA,
        self::GROUP_WRITE_FOTO_PESSOA,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        name: 'fp_id',
        type: Types::INTEGER
    )]
    #[Groups(self::READING_GROUPS)]
    private ?int $id;

    #[ORM\OneToOne(
        targetEntity: Pessoa::class,
        inversedBy: 'foto',
    )]
    #[ORM\JoinColumn(
        name: 'pes_id',
        referencedColumnName: 'pes_id',
        nullable: false,
        unique: true
    )]
    #[Groups(self::GROUPS)]
    private Pessoa $pessoa;

    #[ORM\Column(
        name: 'fp_data',
        type: Types::DATE_MUTABLE
    )]
    #[Groups(self::GROUPS)]
    private \DateTimeInterface $data;

    #[ORM\Column(
        name: 'fp_bucket',
        length: 50
    )]
    #[Groups(self::GROUPS)]
    private string $bucket;

    #[ORM\Column(
        name: 'fp_hash',
        length: 50
    )]
    #[Groups(self::GROUPS)]
    private string $hash;

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

    public function getData(): \DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getBucket(): string
    {
        return $this->bucket;
    }

    public function setBucket(string $bucket): self
    {
        $this->bucket = $bucket;

        return $this;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }
}
