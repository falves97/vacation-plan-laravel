# Vacation Plan Laravel

## Ferramentas usadas no projeto

| Lib/Framework | Versão |
|---------------|--------|
| Docker        | ^26.*  | 
| Frankenphp    | ^1.*   | 
| Larave        | ^10.*  | 
| PostgreSQL    | ^16.*  | 

## Como buildar para ambiente local

Antes de qualquer coisa, é necessário, copiar o `.env.example` para `.env`.

``` shell
cp .env.example .env
```

Rode o comando a baixo para construir as imagens docker.
A flag `--no-cache` é para evitar qualquer problema com a camada de cache das imagens do docker.
Talvez você precise usa `sudo` com docker, dependendo de como você fez a instalação dele no seu ambiente.

``` shell
docker compose build --no-cache
```

Para subir os containers, basta inserir o comando:

``` shell
docker compose up -d
```

Após subir os containers, é necessário configurar as bibliotecas e próprio Laravel.
Para isso rode os seguintes comandos dentro do container `webserver`. 

``` shell
php artisan key:generate
```
``` shell
php artisan migrate
```

Para configurar o Laravel Passport, use o comando:

```
php artisan passport:install
```

Após isso, copie o id e chave gerada para o Personal Client, cole-as no .env, nas variáveis de ambiente:

```
PASSPORT_PERSONAL_ACCESS_CLIENT_ID=""
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=""
```
