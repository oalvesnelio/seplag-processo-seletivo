<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class ServidorEfetivoLotadoDTO
{
    private const GROUP_READ_SERVIDOR_EFETIVO_POR_LOTACAO = 'read:servidor-efetivo-lotacao';

    #[Groups(self::GROUP_READ_SERVIDOR_EFETIVO_POR_LOTACAO)]
    public string $nome;

    #[Groups(self::GROUP_READ_SERVIDOR_EFETIVO_POR_LOTACAO)]
    public string $idade;

    #[Groups(self::GROUP_READ_SERVIDOR_EFETIVO_POR_LOTACAO)]
    public ?string $unidade;

    #[Groups(self::GROUP_READ_SERVIDOR_EFETIVO_POR_LOTACAO)]
    public ?string $fotografia;

    public function __construct(string $nome, int $indade, string $unidade, ?string $fotografia = null)
    {
        $this->nome = $nome;
        $this->idade = $indade;
        $this->unidade = $unidade;
        $this->fotografia = $fotografia;
    }
}
