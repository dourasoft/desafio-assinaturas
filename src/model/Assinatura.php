<?php

namespace model;

use DateTime;

class Assinatura
{
    private int $id;
    private Cadastro $cadastro;
    private string $descricao;
    private DateTime $vencimento;
    private float $valor;

    public function __construct($id, $cadastro, $descricao, $valor, $vencimento)
    {
        $this->id = $id;
        $this->cadastro = $cadastro;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->vencimento = $vencimento;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCadastro(): Cadastro
    {
        return $this->cadastro;
    }

    public function setCadastro(Cadastro $cadastro): void
    {
        $this->cadastro = $cadastro;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function setValor(float $valor): void
    {
        $this->valor = $valor;
    }

    public function getVencimento(): DateTime
    {
        return $this->vencimento;
    }

    public function setVencimento(DateTime $vencimento): void
    {
        $this->vencimento = $vencimento;
    }


}