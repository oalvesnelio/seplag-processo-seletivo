<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\AppController;
use App\Dto\ServidorEfetivoLotadoDTO;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    paginationItemsPerPage: 10,
    operations: [
        new Get('servidor-efetivo/{id}'),
        new Put('servidor-efetivo/{id}'),
        new Post('servidor-efetivo'),
        new GetCollection('servidores-efetivos'),
        new GetCollection(
            uriTemplate: 'servidores-efetivos/lotados/{unidadeId}',
            controller: AppController::class . '::servidoresLotados',
            uriVariables: [
                'unidadeId' => [
                    'from_class' => Unidade::class,
                    'property' => 'id',
                ],
            ],
            output: ServidorEfetivoLotadoDTO::class,
            normalizationContext: [
                'groups' => ['read:servidor-efetivo-lotacao']
            ]
        ),
    ],
    normalizationContext: [
        'groups' => [self::GROUP_READ_SERVIDOR_EFETIVO]
    ],
    denormalizationContext: [
        'groups' => [self::GROUP_WRITE_SERVIDOR_EFETIVO]
    ],
)]
class ServidorEfetivo
{
    private const GROUP_READ_SERVIDOR_EFETIVO = 'read:pessoa-efetivo';
    private const GROUP_WRITE_SERVIDOR_EFETIVO = 'write:pessoa-efetivo';

    private const GROUPS = [
        self::GROUP_READ_SERVIDOR_EFETIVO,
        self::GROUP_WRITE_SERVIDOR_EFETIVO,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        name: 'se_id',
        type: Types::INTEGER
    )]
    #[Groups(self::GROUP_READ_SERVIDOR_EFETIVO)]
    private ?int $id;

    #[ORM\OneToOne(
        targetEntity: Pessoa::class
    )]
    #[ORM\JoinColumn(
        name: 'pes_id',
        referencedColumnName: 'pes_id',
        nullable: false,
    )]
    #[Groups(self::GROUPS)]
    #[ApiProperty(
        openapiContext: [
            'example' => 'pessoa/1'
        ]
    )]
    private Pessoa $pessoa;

    #[ORM\Column(
        name: 'se_matricula',
        type: Types::STRING,
        unique: true,
        nullable: false,
        length: 20
    )]
    #[Groups(self::GROUPS)]
    private string $matricula;

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

    public function getMatricula(): string
    {
        return $this->matricula;
    }

    public function setMatricula(string $matricula): self
    {
        $this->matricula = $matricula;

        return $this;
    }
}
