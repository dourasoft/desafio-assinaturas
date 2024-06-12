<?php

include_once "DTO.php";

/**
 * @extends DTO<Fatura>
 */
class FaturaDTO implements DTO, JsonSerializable
{
    private int $id;
    private CadastroDTO $cadastro;
    private AssinaturaDTO $assinatura;
    private string $descricao;
    private DateTime $vencimento;
    private float $valor;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): FaturaDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getCadastro(): CadastroDTO
    {
        return $this->cadastro;
    }

    public function setCadastro(CadastroDTO $cadastro): FaturaDTO
    {
        $this->cadastro = $cadastro;
        return $this;
    }

    public function getAssinatura(): AssinaturaDTO
    {
        return $this->assinatura;
    }

    public function setAssinatura(AssinaturaDTO $assinatura): FaturaDTO
    {
        $this->assinatura = $assinatura;
        return $this;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): FaturaDTO
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getVencimento(): DateTime
    {
        return $this->vencimento;
    }

    public function setVencimento(DateTime $vencimento): FaturaDTO
    {
        $this->vencimento = $vencimento;
        return $this;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function setValor(float $valor): FaturaDTO
    {
        $this->valor = $valor;
        return $this;
    }

    function build()
    {
        $fatura = new Fatura(
            $this->id,
            $this->cadastro,
            $this->assinatura,
            $this->descricao,
            $this->vencimento,
            $this->valor
        );

        return $fatura;
    }


    public function jsonSerialize(): mixed
    {
        return array(
            "id" => $this->id,
            "cadastro" => $this->cadastro,
            "assinatura" => $this->assinatura,
            "descricao" => $this->descricao,
            "vencimento" => $this->vencimento,
            "valor" => $this->valor
        );
    }
}