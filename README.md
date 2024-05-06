## Rodar o projeto
- Clone o projeto com `git clone`  
- Adicione as dependencias do projeto com `composer install`
- Com servidor de banco de dados rodando e configurado execute as migrations com `php artisan migrate`
- Popule as tabelas executando as seeds a baixo:
    - `php artisan db:seed --class=CadastroSeeder`
    - `php artisan db:seed --class=AssinaturaSeeder`
    - `php artisan db:seed --class=FaturaSeeder`
- Execute o servidor de API com `php artisan serve`   

## Task que converte assinatura com vencimento igual ou inferior a 10 dias em fatura
- Listar as tasks que podem ser agendadas `php artisan schedule:list`
- Iniciar o trabalho das tasks `php artisan schedule:work`
- Executar diretamente o command da task para testes `php artisan app:verificar-assinaturas`

## Rodar cenários de testes
 - Rodar todos os testes `php artisan test`

 - Rodar um cenário específico, exemplo: `php artisan test --filter test_donnot_creating_a_new_fatura_without_a_required_field`

## Front-end para mostrar informações do projeto
Siga as instruções no [reposiório](https://github.com/skymarkos7/front-assinatura-marcos-lourenco-desafio): `https://github.com/skymarkos7/front-assinatura-marcos-lourenco-desafio`

## Collection para o postman
A colleciton está na pasta [docs](docs\desafio-api-de-assinaturas-jobs-assincrôno.postman_collection.json)

Na mesma pasta deixei um arquivo [swagger](docs\swagger.yaml) para uma conferência visual das rotas, fique a vontade para visualizar colando o conteúdo do arquivo no editor online [swagger.editor](https://editor.swagger.io/)
 

<hr>

# DouraSoft

Desafio Assinaturas

Desenvolvimento de uma API para cobrar assinaturas de seus cadastros em **PHP** e **PostgreSQL**

## Deverá conter
**Cadastros**: ID, Codigo, Nome, Email e Telefone

**Assinaturas**: ID, Cadastro, Descrição, Valor

**Faturas**: ID, Cadastro, Assinatura, Descrição, Vencimento, Valor.

## Instruções 🌄

1. Faça um fork do projeto para sua conta pessoal
2. Crie uma branch com o padrão: `desafio-seu-nome`
3. Submeta seu código criando um Pull Request
4. Estão faltando alguns campos propositalmente, você deve criá-los

## Como o Sistema Deve Funcionar ⚙️
 - Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Cadastros
 - Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Assinaturas
 - Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Faturas
 - Deve possuir uma Task que verifica uma vez ao dia todas as assinaturas que vencem daqui a 10 dias e converta elas em faturas.
 - A Task não pode converter faturas já convertidas hoje.
 
## Você deve 🧯
- Utilizar composer
- Utilizar qualquer Framework PHP. Caso opte por não utilizar, desenvolver nos padrões de projeto MVC.
- Utilizar o Postman para documentar a API. Exporte a documentação junto ao projeto na pasta docs.

## Não esqueça de 📆
- Criar as Migrations
- Criar os Seeds

## Pontos Extras ⏭️
- Criar os casos de testes utilizando PHPUnit
- Criar o frontend em um projeto separado com o framework de sua preferência.

## Dúvidas ❓

Abra uma [issue](https://github.com/dourasoft/desafio-assinaturas/issues/new)

Ou envie um email para: **paulo@dourasoft.com.br**

Boa sorte! 💪
