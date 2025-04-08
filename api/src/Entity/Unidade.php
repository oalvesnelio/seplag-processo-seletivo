<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    paginationItemsPerPage: 10,
    operations: [
        new Get('unidade/{id}'),
        new Put('unidade/{id}'),
        new Post('unidade'),
        new GetCollection('unidades'),
    ],
    normalizationContext: [
        'groups' => [self::GROUP_READ_UNIDADE]
    ],
    denormalizationContext: [
        'groups' => [self::GROUP_WRITE_UNIDADE]
    ],
)]
class Unidade
{
    private const GROUP_READ_UNIDADE = 'read:unidade';
    private const GROUP_WRITE_UNIDADE = 'write:unidade';

    private const READING_GROUPS = [
        self::GROUP_READ_UNIDADE,
    ];

    private const GROUPS = [
        self::GROUP_READ_UNIDADE,
        self::GROUP_WRITE_UNIDADE,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        name: 'unid_id',
        type: Types::INTEGER
    )]
    #[Groups(self::READING_GROUPS)]
    private ?int $id;

    #[ORM\Column(
        name: 'unid_nome',
        length: 200,
        type: Types::STRING
    )]
    #[Groups(self::GROUPS)]
    #[Assert\NotBlank()]
    private string $nome;

    #[ORM\Column(
        name: 'unid_sigla',
        length: 20,
        type: Types::STRING
    )]
    #[Groups(self::GROUPS)]
    #[Assert\NotBlank()]
    private string $sigla;

    #[ORM\ManyToMany(
        targetEntity: Endereco::class,
        inversedBy: 'unidades',
    )]
    #[ORM\JoinTable(name: 'unidade_endereco')]
    #[ORM\JoinColumn(
        name: 'unid_id',
        referencedColumnName: 'unid_id'
    )]
    #[ORM\InverseJoinColumn(
        name: 'end_id',
        referencedColumnName: 'end_id',
    )]
    #[Groups(self::GROUPS)]
    #[ApiProperty(
        openapiContext: [
            'example' => [
                'endereco/1',
                'endereco/2'
            ]
        ]
    )]
    private ?Collection $enderecos = null;

    public function __construct()
    {
        $this->prepareEnderecos();
    }

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

    public function getSigla(): string
    {
        return $this->sigla;
    }

    public function setSigla(string $sigla): self
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * @return Collection<int, Endereco>
     */
    public function getEnderecos(): Collection
    {
        $this->prepareEnderecos();

        return $this->enderecos;
    }

    public function addEndereco(Endereco $endereco): self
    {
        if (!$this->enderecos->contains($endereco)) {
            $this->enderecos->add($endereco);
        }

        return $this;
    }

    public function removeEndereco(Endereco $endereco): self
    {
        $this->enderecos->removeElement($endereco);

        return $this;
    }

    private function prepareEnderecos(): void
    {
        if (null === $this->enderecos) {
            $this->enderecos = new ArrayCollection();
        }
        if (is_array($this->enderecos)) {
            $this->enderecos = new ArrayCollection($this->enderecos);
        }
    }
}
