# DouraSoft

Desafio Assinaturas - DouraSoft

Desenvolvimento de uma API para cobrar assinaturas de seus cadastros em **PHP** e **PostgreSQL**

## Deverá conter
**Cadastros**: ID, Codigo, Nome, Email e Telefone

**Assinaturas**: ID, Cadastro, Descrição, Valor

**Faturas**: ID, Cadastro, Assinatura, Vencimento, Valor.

## Instruções

1. Faça um fork do projeto para sua conta pessoal
2. Crie uma branch com o padrão: `desafio-seu-nome`
3. Submeta seu código criando um Pull Request
4. Estão faltando alguns campos propositalmente, você deve criá-los

## Como o Sistema Deve Funcionar

 - Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Cadastros
 - Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Assinaturas
 - Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Faturas
 - Deve possuir uma Task que verifica uma vez ao dia todas as assinaturas que vencem daqui a 10 dias e converta elas em faturas.
 - A Task não pode converter faturas já convertidas hoje.
 
## Você deve

- Utilizar composer
- Utilizar qualquer Framework PHP. Caso opte por não utilizar, desenvolver nos padrões de projeto MVC.
- Utilizar quaisquer bibliotecas ou frameworks para o frontend como VueJS, React, jQuery ou outras
- Utilizar quaisquer frameworks CSS como Bootstrap, Materialize ou outras

## Não esqueça de

- Criar as Migrations
- Criar os Seeds
- Criar o frontend em um projeto separado.
- A task não pode converter faturas já convertidas hoje.

## Dúvidas:question:

Abra uma [issue](https://github.com/dourasoft/desafio-assinaturas/issues/new)

Ou envie um email para: **paulo@dourasoft.com.br**

Boa sorte! :muscle:
