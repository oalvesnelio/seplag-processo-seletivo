<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    paginationItemsPerPage: 10,
    operations: [
        new Get('cidade/{id}'),
        new Put('cidade/{id}'),
        new Post('cidade'),
        new GetCollection('cidades'),
    ],
    normalizationContext: [
        'groups' => [self::GROUP_READ_CIDADE]
    ],
    denormalizationContext: [
        'groups' => [self::GROUP_WRITE_CIDADE]
    ],
)]
class Cidade
{
    #reads
    private const GROUP_READ_CIDADE = 'read:cidade';

    # writes
    private const GROUP_WRITE_CIDADE = 'write:cidade';

    private const READING_GROUPS = [
        self::GROUP_READ_CIDADE,
    ];

    private const GROUPS = [
        self::GROUP_READ_CIDADE,
        self::GROUP_WRITE_CIDADE,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        name: 'cid_id',
        type: Types::INTEGER
    )]
    #[Groups(self::READING_GROUPS)]
    private ?int $id;

    #[ORM\Column(
        name: 'cid_nome',
        length: 200,
        type: Types::STRING
    )]
    #[Groups([
        self::GROUP_READ_CIDADE,
        self::GROUP_WRITE_CIDADE,
        'read:enderecos-funcionais',
    ])]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 3,
        max: 200,
        minMessage: 'O nome da cidade deve ter no mínimo {{ limit }} caracteres',
        maxMessage: 'O nome da cidade deve ter no máximo {{ limit }} caracteres'
    )]
    private ?string $nome;

    #[ORM\Column(
        name: 'cid_uf',
        length: 2,
        type: Types::STRING
    )]
    #[Groups([
        self::GROUP_READ_CIDADE,
        self::GROUP_WRITE_CIDADE,
        'read:enderecos-funcionais',
    ])]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 2,
        minMessage: 'O estado deve ter {{ limit }} caracteres',
        maxMessage: 'O estado deve ter {{ limit }} caracteres'
    )]
    private string $uf;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getUf(): string
    {
        return $this->uf;
    }

    public function setUf(string $uf): self
    {
        $this->uf = $uf;

        return $this;
    }
}
