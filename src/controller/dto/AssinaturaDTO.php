<?php


include_once "DTO.php";

use model\Assinatura;

/**
 * @extends DTO<Assinatura>
 */
class AssinaturaDTO implements DTO, JsonSerializable
{
    private int $id;
    private CadastroDTO $cadastro;
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

    public function setId(int $id): AssinaturaDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getCadastro(): CadastroDTO
    {
        return $this->cadastro;
    }

    public function setCadastro(CadastroDTO $cadastro): AssinaturaDTO
    {
        $this->cadastro = $cadastro;
        return $this;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): AssinaturaDTO
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function setValor(float $valor): AssinaturaDTO
    {
        $this->valor = $valor;
        return $this;
    }

    public function getVencimento(): DateTime
    {
        return $this->vencimento;
    }

    public function setVencimento(DateTime $vencimento): AssinaturaDTO
    {
        $this->vencimento = $vencimento;
        return $this;
    }

    function build()
    {
        $assinatura = new Assinatura(
            $this->id,
            $this->cadastro,
            $this->descricao,
            $this->valor,
            $this->vencimento
        );
        return $assinatura;
    }


    public function jsonSerialize(): mixed
    {

        return array(
            "id" => $this->id,
            "cadastro" => $this->cadastro,
            "descricao" => $this->descricao,
            "vencimento" => $this->vencimento,
            "valor" => $this->valor
        );
    }
}