# Fullstack Challenge - Dictionary

## Introdução

Neste desafio proposto pela plataforma Coodesh foi construido um aplicativo para listar palavras em inglês e suas informacoes, que sao fornecidas pela **Free Dictionary API**.

## Tecnologias utilizadas

### Back-End

- PHP
- Laravel

### Banco de Dados

- PostgreSQL

## Como instalar

### Requisitos

- PHP 8.1.2+
- Composer 2.7.9+

### Instalação

Para executar a aplicação siga os seguintes passos:

- Clone o projeto
- Com o terminal aberto no projeto recem clonado, navegue ate o diretorio de back-end
``cd/backend-dictionary``
- Instale as dependencias utilizando o composer
``composer install``
- Crie um banco de dados, e entao altere o arquivo ```config/database.php```, informando as credenciais corretas.
- Faca uma copia do arquivo ```.env.example```, renomeie-o para ```.env``` e informe
as credenciais corretas.
- Execute os comandos
    ```php artisan key:generate```
    ```php artisan optimize```
    ```php artisan migrate```
    ```php artisan serve```

O back-end da aplicacao esta pronto para ser utilizado.
