<?php

namespace model;

use DateTime;

class Fatura
{
    private int $id;
    private Cadastro $cadastro;
    private Assinatura $assinatura;
    private string $descricao;
    private DateTime $vencimento;
    private float $valor;

    public function __construct(int $id, Cadastro $cadastro, Assinatura $assinatura, string $descricao, DateTime $vencimento, float $valor)
    {
        $this->id = $id;
        $this->cadastro = $cadastro;
        $this->assinatura = $assinatura;
        $this->descricao = $descricao;
        $this->vencimento = $vencimento;
        $this->valor = $valor;
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

    public function getAssinatura(): Assinatura
    {
        return $this->assinatura;
    }

    public function setAssinatura(Assinatura $assinatura): void
    {
        $this->assinatura = $assinatura;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getVencimento(): DateTime
    {
        return $this->vencimento;
    }

    public function setVencimento(DateTime $vencimento): void
    {
        $this->vencimento = $vencimento;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function setValor(float $valor): void
    {
        $this->valor = $valor;
    }
}