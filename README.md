## Sobre o app:

Este é um exemplo prático de uso de HTML5, PHP 8.1, JavaScript, Jquery (Ajax) e TailwindCSS
para desenvolvimento Front-End conectado com Framework Laravel Rest API na versão do PHP 8.2.

São dois projetos em PHP:
- (Frontend) desafio-assinaturas-front
- (Backend)  desafio-assinaturas

## Container Docker (opcional):

Projeto Frontend - Criei 1 container para facilitar o uso da aplicação com:
- Container Servidor Web `http://localhost:3000`

Projeto Backend - Utilizei Laravel Sail
 - Container Servidor web `http://localhost` ou `http://webserverapi`
 - Container de Banco de dados Postgres

## Iniciando o aplicativo:

- Desvincule os projetos de dentro da mesma pasta caso ache necessário.

- Antes de mais nada, em um terminal, crie a rede docker que será responsável por conectar 
os dois projetos com: `docker network create ntw --driver bridge`

- Estou subindo o .env dos dois projetos já configurados para o correto funcionamento.
Segue alguns parâmetros que coloquei no .env da API que vale serem mencionados:

- Defina o horário que será executado diariamente: `HORA_DIA_VALIDA_ASSINATURAS="11:42"`
(obs: mude esse horário para testar a task de gerar faturas)

- Defina o intervalo de dias para geração das faturas: `DIAS_GERA_FATURA=10`

## Configurando o Projeto Backend

Em um Terminal com WSL preferencialmente acesse até a pasta do projeto e execute:
- Instale os pacotes (não necessariamente precisa ser no Terminal com WSL): `composer install --ignore-platform-reqs`
- Construa os containers: `sudo ./vendor/bin/sail build` ou em caso de erros `sudo ./vendor/bin/sail build --no-cache`
- Suba os containers: `sudo ./vendor/bin/sail up -d`
- Acesse `http://localhost` para constatar o funcionamento

## Configurando o Projeto Frontend

Em um Terminal acesse até a pasta do projeto e execute:
- Instale os pacotes: `composer install --ignore-platform-reqs`
- Construa os containers e os suba: `docker-compose up -d --build`
- Acesse `http://localhost:3000` para constatar o funcionamento

## Migrations (Banco de Dados)

Acesse até a pasta do projeto Backend e execute qualquer um dos comandos para subir as migrations:
- `php artisan migrate --seed` ou `sudo ./vendor/bin/sail artisan migrate --seed` 
- `php artisan migrate:fresh --seed` ou `sudo ./vendor/bin/sail artisan migrate:fresh --seed`

## Test Unitário

Em um Terminal com WSL preferencialmente acesse até a pasta do projeto e execute:
- `php artisan test --filter nome-do-metodo-teste-unitario` ou `sudo ./vendor/bin/sail artisan test --filter nome-do-metodo-teste-unitario` 

## Pasta .postman

- Encontra-se exportado as collections utilizadas para elaboração da API

## Login do Sistema

- `dourasoft@dourasoft.com.br`
- `.Dourasoft123.` 