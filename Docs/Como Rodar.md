## Tecnologias Utilizadas

- **Laravel 11:** Um framework PHP poderoso e flexível para construir aplicativos web.
- **PostgreSQL 12:** Um sistema de gerenciamento de banco de dados relacional de código aberto.
- **NGINX 1.12:** Um servidor web rápido, leve e altamente configurável.
- **Docker 26.1.1:** Uma plataforma de código aberto para desenvolvimento, envio e execução de aplicativos em contêineres.
- **Docker Compose 2.27:** Uma ferramenta para definir e executar aplicativos Docker multi-contêineres.
- **Postman 10.24:** Uma plataforma de colaboração para o desenvolvimento de APIs. Você pode usá-lo para testar, documentar e compartilhar APIs.
- **Git:** Um sistema de controle de versão distribuído para rastrear as alterações no código fonte durante o desenvolvimento de software.

## Rodar a aplicação

```bash
docker-compose up -d --build
```
```bash
docker exec laravelapp php artisan migrate && docker exec laravelapp php artisan db:seed
```
## Comando para executar a task
```bash
docker exec laravelapp php artisan app:verificar-assinaturas
```

## Acessos
*Esta informação é importante!*
*A url que deve ser usada é*
```ÙRL
https://localhost
```
