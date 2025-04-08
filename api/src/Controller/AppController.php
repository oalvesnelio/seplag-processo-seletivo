<?php

namespace App\Controller;

use App\Dto\EnderecosFuncionaisDTO;
use App\Dto\ServidorEfetivoLotadoDTO;
use App\Entity\Pessoa;
use App\Repository\PessoaRepository;
use App\Repository\ServidorEfetivoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AppController extends AbstractController
{
    public function servidoresLotados(int $unidadeId, ServidorEfetivoRepository $repository): JsonResponse
    {
        return new JsonResponse(
            array_map(
                function ($servidor) {
                    return new ServidorEfetivoLotadoDTO(
                        $servidor->getPessoa()->getNome(),
                        $servidor->getPessoa()->getIdade(),
                        $servidor->getPessoa()->getLotacao()->getUnidade()->getNome(),
                        $servidor->getPessoa()->getFoto() ? $servidor->getPessoa()->getFoto()->getUrl() : null
                    );
                },
                $repository->findByUnidadeId($unidadeId)
            )
        );
    }

    public function enderecosFuncionais(string $nome, PessoaRepository $repository): JsonResponse
    {
        $enderecos = array_map(
            function (Pessoa $pessoa) {
                return new EnderecosFuncionaisDTO(
                    $pessoa->getNome(),
                    $pessoa->getLotacao()->getUnidade()->getNome(),
                    $pessoa->getEnderecos()->toArray()
                );
            },
            $repository->findEnderecosFuncionaisByNome($nome)
        );

        return $this->json(
            $enderecos,
            context: [
                'groups' => ['read:enderecos-funcionais']
            ]
        );
    }
}
