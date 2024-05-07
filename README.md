# Sobre
Neste projeto optei por utilizar Repositories, Services e Controllers para deixar o projeto limpo e escalável. Para gerar as faturas, utilizei um command do laravel que permite rodar tanto manualmente, quanto com shchedule 1x ao dia, utilizei jobs assincronos para processar a criação das faturas.

Acho importante ressaltar que em um projeto real, melhorias de performance podem ser feitas, utilizando um banco de dados em memoria, como redis ou memcached, a execução dos jobs também pode ser feita de forma a aproveitar melhor todos os cores do processador utilizando o supervisor para executar os workers por exemplo.

Abri mão de algumas práticas recomendadas, como por exemplo não versionar credenciais do .env para que a execução se torne mais fácil na hora de testar.

## Rodando o Projeto

### Com Docker:

1. Navegue até a pasta `backend`.
2. Execute o seguinte comando no terminal:

`docker compose up -d`

### Sem Docker:

1. Instale as dependências com o Composer:

`composer install`

2. Execute as migrações do banco de dados:

`php artisan migrate`

3. Execute o seeder para popular o banco de dados:

`php artisan db:seed`

4. Inicie o worker para processar as filas:

`php artisan queue:work --tries=3`

5. Inicie o worker para executar os agendamentos:

`php artisan schedule:work`

## Testando o Projeto

### Com Postman:

- Importe a documentação da API contida na pasta `docs` para o Postman.

### Com PHPUnit:

- Execute o seguinte comando no terminal:

`php artisan test`