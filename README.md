# Fullstack Challenge - Dictionary

## Introdução

Neste desafio foi construido um aplicativo para listar palavras em inglês, utilizando dados da **Free Dictionary API**

## Tecnologias utilizadas

### Back-End

- PHP
- Laravel

### Banco de Dados

- mySQL

## Como instalar

### Requisitos

- PHP 8.1.2+
- Composer 2.7.9+

### Instalação

Para executar a aplicação siga os seguintes passos:

- Clone o projeto
- Com o terminal aberto no projeto recem clonado, naavegue ate o diretorio de back-end
``cd/backend-dictionary``
- Instale as dependencias utilizando o composer
``composer install``
- Crie um banco de dados com o nome ```fullstack-dictionary```
- Altere o arquivo ```config/database.php```, informando as credenciais corretas.
- Faca uma copia do arquivo ```.env.example``` na raiz do projeto, renomeie-o para ```.env```, informe
as credenciais corretas.
- Execute os comandos
    ```php artisan key:generate```
    ```php artisan optimize```
    ```php artisan migrate```

O back-end da aplicacao esta pronto para ser utilizado.
