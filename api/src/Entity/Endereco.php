<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\AppController;
use App\Entity\Cidade;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    paginationItemsPerPage: 10,
    operations: [
        new Get('endereco/{id}'),
        new Put('endereco/{id}'),
        new Post('endereco'),
        new GetCollection('enderecos'),
        new GetCollection(
            uriTemplate: 'enderecos-funcionais/{nome}',
            controller: AppController::class . '::enderecosFuncionais',
            uriVariables: [
                'nome' => [
                    'from_class' => Pessoa::class,
                    'property' => 'nome',
                ],
            ],
            normalizationContext: [
                'groups' => ['read:enderecos-funcionais']
            ]
        ),
    ],
    normalizationContext: [
        'groups' => [self::GROUP_READ_ENDERECO]
    ],
    denormalizationContext: [
        'groups' => [self::GROUP_WRITE_ENDERECO]
    ],
)]
class Endereco
{
    private const GROUP_READ_ENDERECO = 'read:endereco';
    private const GROUP_WRITE_ENDERECO = 'write:endereco';

    private const READING_GROUPS = [
        self::GROUP_READ_ENDERECO,
    ];

    private const GROUPS = [
        self::GROUP_READ_ENDERECO,
        self::GROUP_WRITE_ENDERECO,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        name: 'end_id'
    )]
    #[Groups(self::READING_GROUPS)]
    private ?int $id = null;

    #[ORM\Column(
        name: 'end_tipo_logradouro',
        length: 50
    )]
    #[Groups([
        self::GROUP_READ_ENDERECO,
        self::GROUP_WRITE_ENDERECO,
        'read:enderecos-funcionais',
    ])]
    #[Assert\NotBlank()]
    private string $tipoLogradouro;

    #[ORM\Column(
        name: 'end_logradouro',
        length: 200
    )]
    #[Groups([
        self::GROUP_READ_ENDERECO,
        self::GROUP_WRITE_ENDERECO,
        'read:enderecos-funcionais',
    ])]
    #[Assert\NotBlank()]
    private string $logradouro;

    #[ORM\Column(
        name: 'end_numero',
        type: 'integer'
    )]
    #[Groups([
        self::GROUP_READ_ENDERECO,
        self::GROUP_WRITE_ENDERECO,
        'read:enderecos-funcionais',
    ])]
    #[Assert\NotBlank()]
    private int $numero;

    #[ORM\Column(
        name: 'end_bairro',
        length: 100
    )]
    #[Groups([
        self::GROUP_READ_ENDERECO,
        self::GROUP_WRITE_ENDERECO,
        'read:enderecos-funcionais',
    ])]
    #[Assert\NotBlank()]
    private string $bairro;

    #[ORM\ManyToOne(
        targetEntity: Cidade::class,
    )]
    #[ORM\JoinColumn(
        name: 'cid_id',
        referencedColumnName: 'cid_id',
    )]
    #[Groups([
        self::GROUP_READ_ENDERECO,
        self::GROUP_WRITE_ENDERECO,
        'read:enderecos-funcionais',
    ])]
    #[Assert\NotBlank()]
    #[ApiProperty(
        openapiContext: [
            'example' => 'cidade/1'
        ]
    )]
    private Cidade $cidade;

    #[ORM\ManyToMany(
        targetEntity: Pessoa::class,
        mappedBy: 'enderecos'
    )]
    private ?Collection $pessoas = null;

    #[ORM\ManyToMany(
        targetEntity: Unidade::class,
        mappedBy: 'enderecos'
    )]
    private ?Collection $unidades = null;

    public function __construct()
    {
        $this->preparePessoas();
        $this->prepareUnidades();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoLogradouro(): string
    {
        return $this->tipoLogradouro;
    }

    public function setTipoLogradouro(string $tipoLogradouro): self
    {
        $this->tipoLogradouro = $tipoLogradouro;

        return $this;
    }

    public function getLogradouro(): string
    {
        return $this->logradouro;
    }

    public function setLogradouro(string $logradouro): self
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getBairro(): string
    {
        return $this->bairro;
    }

    public function setBairro(string $bairro): self
    {
        $this->bairro = $bairro;

        return $this;
    }

    public function getCidade(): Cidade
    {
        return $this->cidade;
    }

    public function setCidade(Cidade $cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * @return Collection<int, Pessoa>
     */
    public function getPessoas(): Collection
    {
        $this->preparePessoas();

        return $this->pessoas;
    }

    public function addPessoa(Pessoa $pessoa): self
    {
        $this->preparePessoas();

        if (!$this->pessoas->contains($pessoa)) {
            $this->pessoas->add($pessoa);
            $pessoa->addEndereco($this);
        }

        return $this;
    }

    public function removePessoa(Pessoa $pessoa): self
    {
        $this->preparePessoas();

        if ($this->pessoas->removeElement($pessoa)) {
            $pessoa->removeEndereco($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Pessoa>
     */
    public function getUnidades(): Collection
    {
        $this->prepareUnidades();

        return $this->pessoas;
    }

    public function addUnidade(Unidade $unidade): self
    {
        $this->prepareUnidades();

        if (!$this->unidades->contains($unidade)) {
            $this->unidades->add($unidade);
            $unidade->addEndereco($this);
        }

        return $this;
    }

    public function removeUnidade(Unidade $unidade): self
    {
        $this->prepareUnidades();

        if ($this->unidades->removeElement($unidade)) {
            $unidade->removeEndereco($this);
        }

        return $this;
    }

    private function preparePessoas(): void
    {
        if (is_null($this->pessoas)) {
            $this->pessoas = new ArrayCollection();
        }

        if (is_array($this->pessoas)) {
            $this->pessoas = new ArrayCollection($this->pessoas);
        }
    }

    private function prepareUnidades(): void
    {
        if (is_null($this->unidades)) {
            $this->unidades = new ArrayCollection();
        }

        if (is_array($this->unidades)) {
            $this->unidades = new ArrayCollection($this->unidades);
        }
    }
}
