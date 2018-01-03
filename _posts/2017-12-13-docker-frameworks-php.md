---
layout: post
title:  "Imagem Docker com PHP + Framework(s)"
date:   2017-12-13 12:30:00
author: 
    name: "Marcio Albuquerque"
    mail: "marcio.lima.albuquerque@gmail.com"
    github: "mlalbuquerque"
    blog: "http://culturabeta.com.br"
    twitter: "mlalbuquerque"
    facebook: "mlalbuquerque"
categories: 
    - docker
    - infraestrutura
    - framework
tags: ["docker", "docker-compose", "infra", "php", "framework", "laravel", "symfony", "zend expressive"]
cover:  "/assets/posts/2017/11/docker/viagens-de-babar.jpg"
---
Já passamos por dois posts ([Docker e Docker Compose com PHP]({% post_url 2017-11-24-docker-php %}) e [Conteinerizando PHP e outras coisas]({% post_url 2017-11-29-docker-php-2 %})) falando de PHP, Docker, Docker Compose. Hoje, iremos um passo além, um passo pequeno, mas que pode ajudar várias pessoas que trabalham com **frameworks PHP**. Não é um guia definitivo, até porque podem existir diversas maneiras de se trabalhar com  frameworks PHP conteinerizados. É apenas um guia de como eu trabalho. Então, pode usar a vontade a ideia e dar sugestões de melhorias. Acho que sempre pode existir uma maneira melhor de se trabalhar. Ainda mais na nossa profissão...

Vamos direto ao que interessa!!!

# Imagem PHP com Laravel
Já digo de cara, se quiserem podem usar a imagem que criei e disponibilizei no [Docker Hub](https://hub.docker.com/r/mlalbuquerque/php-laravel/). Mas mostrarei como criei essa imagem aqui e podem usar a mesma ideia para outros frameworks.

Podemos reutilizar uma imagem já criada no post [Conteinerizando PHP e outras coisas]({% post_url 2017-11-29-docker-php-2 %}), a `mlalbuquerque/php:7.1`. Já criei também a `mlalbuquerque/php:7.2`, caso já queiram brincar com a nova versão do PHP. Em cima dessa imagem, vou criar mais diretivas para colocar o Laravel.

#### php7.1-laravel.dockerfile
```dockerfile
FROM mlalbuquerque/php:7.1
# Instalando o Laravel
RUN composer global require "laravel/installer"
ENV PATH "$PATH:/root/.composer/vendor/bin"
```

Pronto, temos o [Laravel Installer](https://laravel.com/docs/5.4/installation#installing-laravel) na imagem. É apenas uma ferramenta para poder gerar projetos Laravel. Feito isso, podemos contruir a imagem:

```shell
$ docker build -t mlalbuquerque/php-laravel -f php7.1-laravel.dockerfile .
```

Com isso, temos a imagem gerada com o nome `mlalbuquerque/php-laravel`. Com a imagem pronta, podemos rodar o **Laravel Installer** para criar projetos. Então, subimos um conteiner baseado nessa imagem:

```shell
$ docker run --name LARAVEL -v $(pwd):/var/www/html -it mlalbuquerque/php-laravel
```

E depois podemos rodar o comando para gerar o projeto Laravel dentro da pasta onde está:

```shell
$ docker exec -it LARAVEL laravel new meu_projeto
```

O comando irá gerar uma pasta chamada `meu_projeto` e criará/baixará todos os arquivos necessários para o projeto, incluindo o arquivo `artisan`. Com isso, podemos mapear o **Laravel Artisan** da seguinte maneira:

```shell
$ alias artisan="docker exec -it LARAVEL php artisan"
```

E podemos rodar os comandos do Artisan assim (exemplos):

```shell
$ artisan tinker
$ artisan migrate
$ artisan make:controller MeuControlador
```

Todos eles irão rodar o **Laravel Artisan** na pasta local do host e mapeando tudo para `/var/www/html` do conteiner. Com isso, podemos criar agora um arquivo do Docker Compose da seguinte maneira:

#### docker-compose.yml
```yaml
version: "3"
services:
    database:
        image: mysql:5.7.20
        environment:
            MYSQL_ROOT_PASSWORD: 12345
            MYSQL_DATABASE: db
            MYSQL_USER: dbadmin
            MYSQL_PASSWORD: dbpassword
        volumes:
            - "data:/var/lib/mysql"
    webserver:
        image: webdevops/apache:alpine
        depends_on:
            - php
        ports: 
            - "80:80"
            - "443:443"
        volumes: 
            - ".:/var/www/html"
        environment:
            WEB_PHP_SOCKET: "php:9000"
            WEB_PHP_TIMEOUT: 600
            WEB_DOCUMENT_ROOT: "/var/www/html"
    php:
        image: mlalbuquerque/php-laravel
        build:
            context: ./dockerfiles
            dockerfile: php7.1-laravel.dockerfile
        volumes:
            - ".:/var/www/html"
            - "./dockerfiles/config/php.ini:/usr/local/etc/php/php.ini"
            - "./dockerfiles/config/xdebug.ini:/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
        environment:
            PATH: "/root/.composer/vendor/bin:${PATH}"
volumes:
    data:
```

Como já vimos nos posts anteriores, no serviço `php` temos a diretiva `build`, caso não tenha já construído a imagem `mlalbuquerque/php-laravel` (lembrar de colocar o arquivo `php7.1-laravel.dockerfile` dentro da pasta `dockerfiles` ou de mudar o local onde procurar pelo arquivo). Com este arquivo `docker-compose.yml`, basta darmos o comando `docker-compose up` e temos os serviços rodando e o PHP já com Laravel.

# Imagem PHP com Symfony
Vou me basear na versão mais nova do Symfony, a versão 4. No caso do Laravel, a imagem já vem com o **Laravel Installer**, facilitando a criação de novos projetos a partir da imagem. Já o Symfony cria os projetos com o seguinte comando **Composer**:

```shell
$ composer create-project symfony/skeleton [NOME DO PROJETO]
```

Como o **Composer** já vem instalado na imagem `mlalbuquerque/php:7.1` (ou mesmo na `mlalbuquerque/php:7.2`), podemos usar o arquivo `docker-compose.yml` abaixo:

#### docker-compose.yml
```yaml
version: "3"
services:
    database:
        image: mysql:5.7.20
        environment:
            MYSQL_ROOT_PASSWORD: 12345
            MYSQL_DATABASE: db
            MYSQL_USER: dbadmin
            MYSQL_PASSWORD: dbpassword
        volumes:
            - "data:/var/lib/mysql"
    webserver:
        image: webdevops/apache:alpine
        depends_on:
            - php
        ports: 
            - "80:80"
            - "443:443"
        volumes: 
            - ".:/var/www/html"
        environment:
            WEB_PHP_SOCKET: "php:9000"
            WEB_PHP_TIMEOUT: 600
            WEB_DOCUMENT_ROOT: "/var/www/html"
    php:
        image: mlalbuquerque/php:7.1
        volumes:
            - ".:/var/www/html"
        environment:
            PATH: "/root/.composer/vendor/bin:${PATH}"
volumes:
    data:
```

Depois, inicie os serviços com **Docker Compose**...
```shell
$ docker-compose up -d
```
Veja qual o nome do conteiner criado baseado no serviço `php` e use na criação de um alias (ou chame direto o comando do alias). Para efeitos de exemplo, imagine que o nome do conteiner seja projeto_php_1...
```shell
$ alias create-symfony="docker exec -it projeto_php_1 composer create-project symfony/skeleton"
```

Ao final, chame o comando para criação do projeto dentro da pasta onde está:
```shell
$ create-symfony "meu-projeto"
```

Nesse caso, ele criará uma pasta chamada `meu-projeto` e lá dentro estará tudo que precisa para iniciar seu projeto Symfony. Ele irá pedir algumas confirmações, como escolha do *Router*, do *Template Renderer*, entre outras coisas. Basta sair escolhendo o que preferir.

# Imagem PHP com Zend Expressive
Basta seguir a ideia da **Imagem PHP com Symfony** e criar um alias novo e chamar este novo alias:
```shell
$ alias create-expressive="docker exec -it projeto_php_1 composer create-project zendframework/zend-expressive-skeleton"
$ create-expressive "meu-projeto"
```

Claro que terá que verificar o nome do conteiner, mas a ideia permanece. Se formos ver outros frameworks, podem seguir a mesma ideia do Symfony (sem instalação prévia usando o `compose create-project`) ou a ideia do Laravel (se o framework tiver um instalador).

# Conclusão
Ter os frameworks no projeto não é algo tão difícil, até porque, hoje em dia, ter um projeto baseado em algum framework PHP (*skeleton*) é uma questão de copiar arquivos, seja por instaladores (Laravel) ou por `composer create-project` (Symfony e Zend-Expressive) ou mesmo copiando arquivos ([outra maneira de se fazer com Zend Expressive](https://docs.zendframework.com/zend-expressive/getting-started/standalone/)). Mostrei particularidades de 3 frameworks, mas as ideias podem ser utilizadas em vários outros. Quem seguiu os posts anteriores, já poderia fazer tranquilamente o que descrevi neste post.

Espero que tenha ajudado um pouco mais na criação de ambientes de desenvolvimento para PHP usando Docker. No próximo post,um pedido recorrente de várias pessoas: trabalhando com Selenium + Docker. Vou mostrar como subir um ambiente usando Selenium Hub e poder testar no Firefox e Chrome usando o Selenium (usando como base o Behat).

E só relembrando, o que falamos até agora:

* ~~Montando um ambiente com PHP, Apache e MySQL (e alternativas)~~ - [Docker e Docker Compose com PHP]({% post_url 2017-11-24-docker-php %})
* ~~Como trabalhar com este ambiente~~ - [Conteinerizando PHP e outras coisas]({% post_url 2017-11-29-docker-php-2 %})
* ~~Imagem do PHP já vir com algum framework (Laravel, Symfony e Zend Expressive)~~ - [Imagem Docker com PHP + Framework(s)]({% post_url 2017-12-13-docker-frameworks-php %})
* Docker Compose para testes automatizados com Selenium
* Configurar IDE para trabalhar com o XDebug do conteiner (Netbeans e Visual Studio Code)
* Uso de shell scripts para automatizar mais ainda as tarefas (PHPUnit, Behat, etc)
* Subir as imagens para o Docker Hub

Até o próximo post!!!