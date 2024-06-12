<?php


include_once "DTO.php";
use model\Cadastro;

/**
 * @extends DTO<Cadastro>
 */
class CadastroDTO implements DTO, JsonSerializable
{
    private int $id;
    private string $nome;
    private string $email;
    private string $telefone;

    public function __construct(){
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): CadastroDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): CadastroDTO
    {
        $this->nome = $nome;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): CadastroDTO
    {
        $this->email = $email;
        return $this;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): CadastroDTO
    {
        $this->telefone = $telefone;
        return $this;
    }

    function build()
    {
       $cadastro = new Cadastro(
           $this->id,
           $this->nome,
           $this->email,
           $this->telefone
       );
       return $cadastro;
    }

    public function jsonSerialize(): mixed
    {
        return array(
            "id" => $this->id,
            "nome" => $this->nome,
            "email" => $this->email,
            "telefone" => $this->telefone
        );
    }
}