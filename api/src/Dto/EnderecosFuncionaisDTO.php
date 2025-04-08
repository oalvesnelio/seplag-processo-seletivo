<?php

namespace App\Dto;

use App\Entity\Endereco;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

class EnderecosFuncionaisDTO
{
    private const GROUP_READ_ENDERECOS_FUNCIONAIS = 'read:enderecos-funcionais';

    #[Groups(self::GROUP_READ_ENDERECOS_FUNCIONAIS)]
    public string $nome;

    #[Groups(self::GROUP_READ_ENDERECOS_FUNCIONAIS)]
    public string $unidade;

    #[Groups(self::GROUP_READ_ENDERECOS_FUNCIONAIS)]
    public array $enderecos;

    public function __construct(string $nome, string $unidade, array $enderecos)
    {
        $this->nome = $nome;
        $this->unidade = $unidade;
        $this->enderecos = $enderecos;
    }
}
