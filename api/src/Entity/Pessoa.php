<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use App\Entity\Lotacao;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    paginationItemsPerPage: 10,
    operations: [
        new Get('pessoa/{id}'),
        new Put('pessoa/{id}'),
        new Post('pessoa'),
        new GetCollection('pessoas'),
    ],
    normalizationContext: [
        'groups' => [self::GROUP_READ_PESSOA]
    ],
    denormalizationContext: [
        'groups' => [self::GROUP_WRITE_PESSOA]
    ],
)]
class Pessoa
{
    private const GROUP_READ_PESSOA = 'read:pessoa';
    private const GROUP_WRITE_PESSOA = 'write:pessoa';

    private const READING_GROUPS = [
        self::GROUP_READ_PESSOA,
    ];

    private const GROUPS = [
        self::GROUP_READ_PESSOA,
        self::GROUP_WRITE_PESSOA,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        name: 'pes_id',
        type: Types::INTEGER
    )]
    #[Groups(self::READING_GROUPS)]
    private ?int $id;

    #[ORM\Column(
        name: 'pes_nome',
        length: 200,
        type: Types::STRING
    )]
    #[Groups(self::GROUPS)]
    private string $nome;

    #[ORM\Column(
        name: 'pes_data_nascimento',
        type: Types::DATE_MUTABLE
    )]
    #[Groups(self::GROUPS)]
    private \DateTimeInterface $dataNascimento;

    #[ORM\Column(
        name: 'pes_sexo',
        length: 9,
        type: Types::STRING
    )]
    #[Groups(self::GROUPS)]
    private string $sexo;

    #[ORM\Column(
        name: 'pes_mae',
        length: 200,
        type: Types::STRING,
        nullable: true
    )]
    #[Groups(self::GROUPS)]
    private string $mae;

    #[ORM\Column(
        name: 'pes_pai',
        length: 200,
        type: Types::STRING,
        nullable: true
    )]
    #[Groups(self::GROUPS)]
    private string $pai;

    #[ORM\ManyToMany(
        targetEntity: Endereco::class,
        inversedBy: 'pessoas',
        cascade: ['persist', 'remove']
    )]
    #[ORM\JoinTable(name: 'pessoa_endereco')]
    #[ORM\JoinColumn(
        name: 'pes_id',
        referencedColumnName: 'pes_id'
    )]
    #[ORM\InverseJoinColumn(
        name: 'end_id',
        referencedColumnName: 'end_id',
        onDelete: 'CASCADE'
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

    #[ORM\OneToOne(
        targetEntity: FotoPessoa::class,
        mappedBy: 'pessoa',
    )]
    #[Groups(self::GROUPS)]
    private ?FotoPessoa $foto = null;

    #[ORM\OneToOne(
        targetEntity: Lotacao::class,
        mappedBy: 'pessoa',
    )]
    #[Groups(self::GROUPS)]
    private ?Lotacao $lotacao = null;

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

    public function getDataNascimento(): \DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function getIdade(): int
    {
        $dataNascimento = $this->getDataNascimento();
        $hoje = new \DateTime();

        return $hoje->diff($dataNascimento)->y;
    }

    public function setDataNascimento(\DateTimeInterface $dataNascimento): self
    {
        $this->dataNascimento = $dataNascimento;

        return $this;
    }

    public function getSexo(): ?string
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo): self
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getMae(): string
    {
        return $this->mae;
    }

    public function setMae(string $mae): self
    {
        $this->mae = $mae;

        return $this;
    }

    public function getPai(): string
    {
        return $this->pai;
    }

    public function setPai(string $pai): self
    {
        $this->pai = $pai;

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

    public function getLotacao(): ?Lotacao
    {
        return $this->lotacao;
    }

    public function setLotacao(?string $lotacao): self
    {
        $this->lotacao = $lotacao;

        return $this;
    }

    public function getFoto(): ?FotoPessoa
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }
}
