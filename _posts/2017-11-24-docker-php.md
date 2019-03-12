---
layout: post
title:  "Docker e Docker Compose com PHP"
date:   2017-11-24 10:00:00
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
tags: 
    - docker
    - docker-compose
    - infra
cover:  "/assets/posts/2017/11/docker/viagens-de-babar.jpg"
---
Conteineres chegaram para ficar, independente do ambiente em que se trabalha. Seja desenvolvimento, homologação ou produção, muitas pessoas estão usando conteineres pela facilidade de uso, pela manutenabilidade, por ser um processo repetível e bastante configurável, e uma alta e benéfica volatilidade (podemos criar e destruir conteineres ao nosso bel prazer e de forma fácil!!! :D).

E o Docker, é hoje, a principal tecnologia de conteineres do mercado. Tecnologias de Conteineres e Docker se confundem, mas existem outras tecnologias, como o Core OS rkt. Mas, neste post, vamos falar mesmo do Docker e como usá-lo como ambiente de desenvolvimento de PHP. Afinal, o blog é sobre PHP, mas o que mostrarei aqui podem ser aplicados para outras linguagens.

Não irei falar aqui o que é o Docker e o Docker Compose (tecnologia complementar ao Docker para orquestrar serviços baseados em Docker). De vez em quando, darei uma dica ou lembrarei de algo, mas se quiserem saber mais, leiam estes tutoriais:

* [Tutorial Docker](https://docs.docker.com/get-started/)
* [Tutorial Docker Compose](https://docs.docker.com/compose/gettingstarted/)

E para instalação especificamente, basta seguir os links abaixo:

* [Instalação do Docker](https://docs.docker.com/engine/installation/)
* [Instalação do Docker Compose](https://docs.docker.com/compose/install/)

Com as ferramentas instaladas, basta rodar os comandos abaixo para verificar se estão instaladas e as versões (suas versões podem ser mais novas do que essa):

```shell
$ docker -v
Docker version 17.06.1-ce, build 874a737
$ docker-compose -v
docker-compose version 1.15.0, build e12f3b9
```

Montando infra de desenvolvimento
-----------------
A ideia do post é mostrar uma possível infra de desenvolvimento básica para PHP com:

* PHP 7.1 (com opções para outras versões, Composer e Git)
* Apache ou Nginx ou Servidor Embutido
* MySQL ou PostgreSQL

Então, vamos direto ao ponto e iniciar pelo arquivo `docker-compose.yml`, que define nossos serviços. Iniciarei com PHP 7.1.11, Apache e MySQL.

#### docker-compose.yml
```yaml
version: "3"
services:
    database:
        image: mysql:5.7.20
        restart: always
        environment:
            MYSQL_ROOT_PASSWORD: 12345
            MYSQL_DATABASE: usuarios
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
        build:
            context: ./dockerfiles
            dockerfile: php7.1.dockerfile
            args:
                - "UID=$UID"
                - "GID=$GID"
                - "USER=$USER"
        volumes:
            - ".:/var/www/html"
            - "./dockerfiles/config/php.ini:/usr/local/etc/php/php.ini"
            - "./dockerfiles/config/xdebug.ini:/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
        environment:
            PATH: "/root/.composer/vendor/bin:${PATH}"
volumes:
    data:
```

Vamos detalhar os **serviços** e explicar porque trabalho com eles.

1. **database** - aqui estou trabalhando com o MySQL, mas trabalho hoje muito mais com PostgreSQL (depois mostrarei como trabalhar com outros serviços).
  * **_image_** - aqui estou usando a imagem oficial do MySQL (`mysql`). Também, sempre prefiro especificar a *tag* que estou trabalhando, pois assim saberei exatamente a versão do banco.
  * **_restart_** - esta diretiva diz como tratar o serviço caso ele pare abruptamente. No caso, ele sempre irá reiniciar se parar. Se for uma parada explícita (você parar o serviço de propósito), ele não reinicia.
  * **_environment_** - nesta entrada definimos variáveis de ambiente do serviço. Normalmente, são variáveis que serão usadas internamente pelo conteiner. Dessas acima, a única obrigatória mesmo é a `MYSQL_ROOT_PASSWORD`. Todas as outras são opcionais, mas mesmo assim eu configuro por questões de clareza. Assim, sabemos o nome do banco, o usuário e a senha a serem usadas pela infra, respectivamente definidas em `MYSQL_DATABASE`, `MYSQL_USER` e `MYSQL_PASSWORD`.
  * **_volumes_** - volumes sempre é importante em serviços baseados em conteiner, caso queira persistir dados entre iniciações dos conteineres. Caso contrário, os dados se perdem quando o conteiner é parado ou destruído. No caso, esta única entrada em `volumes` é para definir a persistência dos dados do banco na máquina hospedeira (host). Na documentação da imagem, indica o endereço `/var/lib/mysql` como o local no conteiner ondes os dados serão guardados. Então, mapeando o volume `data` para este caminho, os dados serão persistidos no host e tudo a cargo do próprio Docker. **OBS: LEMBRE SEMPRE** que quando mapeamos volumes, os **dados que existem no conteiner serão apagados e sobrescritos pelos dados encontrados no host**.
2. **webserver** - serviço de servidor web, neste caso, Apache. Estou usando uma imagem não oficial, pois esta imagem oferece variáveis de ambiente interessantes que facilitam a configuração do Apache.
  * **_image_** - a imagem é do grupo WebDevOps. Bem legal, bem estruturada e com várias opções. Uso a versão do **alpine** por ser bem menor (24MB) em comparação com outras baseadas em Debian (~90MB) ou Ubuntu (~110MB).
  * **_depends_on_** - indica uma dependência deste serviço. Ou seja, o serviço `webserver` depende do serviço `php`. Cria uma ordem para iniciar os serviços. Então, este serviço só inicia depois que o serviço do qual ele depende já tiver iniciado.
  * **_ports_** - define as portas mapeadas entre host e conteiner. A marcação é sempre na ordem `HOST:CONTEINER`. No caso, a porta 80 (http) do host, aponta para  aporta 80 do conteiner. O mesmo vale para a porta 443 (https). Então, podemos acessar este serviço pelo endereço `http://localhost/` ou `https://localhost/`. Se não fizéssemos isso, teríamos que saber qual o IP do conteiner para poder acessá-lo.
  * **_volumes_** - parte bem importante, pois cria um volume, mapeando a pasta local (onde o arquivo docker-compose.yml se encontra) para a pasta `/var/www/html` do conteiner, que é a pasta configurada como **Document Root** do Apache (veja a seção abaixo). Com isso, todos os arquivos dentro da pasta (pasta do projeto), podem ser servidos pelo Apache.
  * **_environment_** - aqui temos 3 variáveis que nos ajudam a configurar o Apache. Podemos configurar como acessar o PHP via FPM (`WEB_PHP_SOCKET`), o *timeout* do PHP (`WEB_PHP_TIMEOUT`) e o Document Root do Apache (`WEB_DOCUMENT_ROOT`). Existem [outras variáveis](http://dockerfile.readthedocs.io/en/latest/content/DockerImages/dockerfiles/apache.html) para poderem usar, se quiserem.
3. **php** - serviço que define o PHP usado no ambiente. Neste caso, crio uma imagem nova, que não existe. E o Docker Compose sabe como tratar isso de forma bem simples. Fiz assim já para embutir extensões que normalmente uso, o Composer (programador PHP não tem como não saber o que é, né?) e o Git (o Composer depende dele e podemos usar pro projeto também).
    * **_image_** - pode colocar o nome que quiser aqui. Eu coloquei seguindo a regra do Docker: NAMESPACE/CONTEINER:TAG (mlalbuquerque/php:7.1).
    * **_build_** - aqui estão as diretivas de como construir a imagem ([docker build](https://docs.docker.com/compose/reference/build/)). Como a imagem não existe nem localmente nem no [Docker Hub](https://hub.docker.com), ele usa essas informações para contruir a imagem:
        * **_context_** - pasta onde irá procurar pelos arquivos necessários para a build da imagem
        * **_dockerfile_** - caso o arquivo Dockerfile não tenha este nome, deve ter esta diretiva para dizer qual o nome do arquivo. No caso, o arquivo é php7.1.dockerfile e ele se encontra dentro da pasta `./dockerfiles`.
        * **_args_** - argumentos que são passados no momento da build (diretivas `ARG` dentro do Dockerfile). No caso, foram criadas 3 argumentos (`UID`, `GID` e `USER`), que usam variáveis de ambiente do host (`$UID`, `$GID` e `$USER`) como valores. Um porém: o Docker não tem acesso às variáveis $UID e $GID, portanto, podemos usar um arquivo `.env` (um arquivo estilo INI) para definir valores de variáveis de ambiente que não existem. Uma [recurso](https://docs.docker.com/compose/environment-variables/#the-env-file) bem legal do Docker Compose.

        Depois, mostrarei os arquivos que usei para montar a imagem (`php7.1.dockerfile`) e o `.env`.
    * **_volumes_** - mais uma vez, mapeando volumes para poder usar os arquivos dentro do conteiner. No caso do serviço PHP, coloquei 3 volumes: um com mapeamento de pasta, outros dois para poder configurar o PHP e o XDebug, respectivamente. Assim, o conteiner saberá onde procurar os arquivos PHP, poderemos configurar o PHP e o XDebug para usar com IDEs.
    * **_environment_** - mais uma definição de variável de ambiente interna ao conteiner. Neste caso, estamos colocando um novo caminho no PATH para que o conteiner reconheça o Composer.

A última linha (`volumes`) serve para definir um volumes que podem ser usados por qualquer um dos serviços. Usamos o `data` no `database`. Não tem nenhuma diretiva, pois usa o padrão do Docker.

Além destes arquivos, temos mais dois.

#### php7.1.dockerfile
```dockerfile
ARG PHP_VERSION=7.1.11-fpm-alpine
ARG XDEBUG_VERSION=2.5.5
FROM php:${PHP_VERSION}
ARG UID=root
ARG GID=root
ARG USER

# Instalando extensões necessárias do PHP
RUN apk add --update --no-cache \
        alpine-sdk autoconf curl curl-dev freetds-dev \
        libxml2-dev jpeg-dev openldap-dev libmcrypt-dev \
        libpng-dev libxslt-dev postgresql-dev \
    && rm /var/cache/apk/*
RUN docker-php-ext-configure ldap --with-ldap=/usr
RUN docker-php-ext-configure xml --with-libxml-dir=/usr
RUN docker-php-ext-configure gd --with-jpeg-dir=/usr/include --with-png-dir=/usr/include
RUN docker-php-ext-install \
    bcmath calendar curl dom fileinfo gd hash json ldap mbstring mcrypt \
    mysqli pgsql pdo pdo_dblib pdo_mysql pdo_pgsql sockets xml xsl zip

# Instalando o XDebug
RUN pecl install xdebug-${XDEBUG_VERSION}
RUN docker-php-ext-enable xdebug

# Configurando o XDebug
RUN echo "xdebug.remote_enable = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_autostart = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.connect_back = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Instalando o Git (Composer usa para baixar alguns pacotes)
RUN apk add --update --no-cache git && rm /var/cache/apk/*

# Instalando o Composer
RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Setando o user:group do conteiner para o user:group da máquina host (ver arquivo .env e docker-compose.yml)
# Assim, o Composer passa a usar o mesmo user:group do usuário do host
# Configura também as pastas para o novo usuário
RUN chown -R ${UID}:${GID} /var/www/html
RUN chown -R ${UID}:${GID} /root/.composer
RUN mkdir -p /.composer && chown -R ${UID}:${GID} /.composer
RUN mkdir -p /.config && chown -R ${UID}:${GID} /.config
VOLUME /var/www/html
VOLUME /root/.composer
VOLUME /.composer
VOLUME /.config
USER ${UID}
```

#### .env
```ini
# Para uso no Docker
# USER => seu usuário do host
# UID => ID do seu usuário (para descobrir => $ id -u)
# GID => ID do seu grupo (para descobrir => $ id -g)
UID=1000
GID=888
```

Perceba que o arquivo `.env` serve para configurar variáveis de ambiente que não existem ou que o Docker não pode usar. A variável $USER o Docker tem acesso, então não precisa setar. As outras precisam e serão substituídas no `docker-compose.yml`. Para ver o efeito, rode o comando abaixo e veja as substituições:

```shell
$ docker-compose config
```

Como estará na seção `args` da seção `build` do serviço `php`, serão usados como valores dos argumentos do Dockerfile `php7.1.dockerfile` (diretivas ARG nas linhas 4 a 6). Assim, construirá a imagem usando esses argumentos que estão em `.env`.

Neste momento, temos um ambiente com Apache 2.4, PHP 7.1 e MySQL 5.7, já com Composer e Git para ajudar no desenvolvimento do projeto. Agora, tudo no seu lugar, basta rodar o comando abaixo para subir o ambiente:

```shell
$ docker-compose up
```

Caso queira subir apenas um dos serviços (caso o serviço dependa de alguém, levanta os dependentes também):

```shell
$ docker-compose up database
$ docker-compose up webserver
$ docker-compose up php
```

Nos dois casos, ele deixa o log dos serviços no terminal. Se quiser deixar o terminal livre, basta colocar a diretiva `-d` depois de `up`:

```shell
$ docker-compose up -d
```

Pronto!! Ambiente pronto pra usar.

## Alternativas
Podemos trabalhar com PostgreSQL ao invés de MySQL ou mesmo com Nginx ou Servidor Embutido do PHP no lugar do Apache. Abaixo, coloco as alterações que precisam ser feitas para essas trocas.

#### PostgreSQL no lugar do MySQL
Basta trocas as diretivas do serviço `database` pelas diretivas abaixo. Lembrar que o YAML precisa respeitar identação:

```yaml
database:
    image: postgres:9.6-alpine
    volumes: 
        - "data:/var/lib/postgresql/data"
    environment:
        POSTGRES_PASSWORD: usuarios
        POSTGRES_USER: dbadmin
        POSTGRES_DB: dbpassword
```

#### Nginx no lugar do Apache
Mais uma vez, basta trocar as diretivas de `webserver` e mudar apenas uma linha em `php`:

```yaml
webserver:
    image: webdevops/nginx:alpine
    depends_on:
        - php
    ports: 
        - "80:80"
        - "443:443"
    volumes: 
        - ".:/app"
    environment:
        WEB_PHP_SOCKET: "php:9000"
        WEB_PHP_TIMEOUT: 600
        WEB_DOCUMENT_ROOT: "/app"
php:
    volumes:
        # mude APENAS o primeiro volume neste serviço
        - ".:/app" # no lugar de .:/var/www/html
```

#### Servidor PHP embutido no lugar do Apache
Não mudamos o `docker-compose.yml`, dessa vez. Agora, precisaríamos modificar apenas o arquivo `php7.1.dockerfile` para colocar umas diretivas para que use o o servidor embutido. Lembrando que neste caso, não podemos usar HTTPS no projeto. Mas também não precisamos carregar mais um serviço. Meça suas necessidades! Outra coisa, não precisa apagar o serviço `webserver`, mas pode apagar tranquilamente, pois não usaremos mais o Apache (ou Nginx).

```dockerfile
# Colocar estas linhas no final do arquivo php7.1.dockerfile
EXPOSE 8080
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/var/www/html"]
```

No caso acima, agora nosso serviço `php` já inicia rodando o servidor embutido, na porta 8080 e apontando a pasta `/var/www/html` do conteiner como o **Document Root** de nosso projeto. Neste caso, precisamos reconstruir nossa imagem. Podemos fazer isso através do Docker:

```shell
$ docker build -t mlalbuquerque/php:7.1 -f php7.1.dockerfile .
```
Lembre de usar o mesmo nome de imagem (`mlalbuquerque/php:7.1`) e referenciar o arquivo dockerfile (porque não está usando o nome padrão).
Podemos também usar o Docker Compose para tanto:

```shell
$ docker-compose build php
```
Neste caso, fica mais fácil, bastando apontar o nome do serviço, pois nele consta o nome da imagem e todas as diretivas relativas ao build no arquivo `docker-compose.yml`.

No arquivo dockerfile `php7.1.dockerfile`, como a diretiva `CMD` é quem indica o caminho, e esta diretiva sempre pode ser sobrescrita dentro do docker-compose.yml, caso precise apontar para outra pasta, digamos `/app/public`, podemos fazer da seguinte maneira no serviço `php`:

```yaml
# coloque esta diretiva a mais no serviço php do docker-compose.yml
command: ["php", "-S", "0.0.0.0:8080", "-t", "/app/public"]
```

Pronto!! Mudamos o comando e quando iniciar o serviço `php`, ele inicia com o comando `php -S 0.0.0.0:8080 -t /app/public`.

# Conclusão
Temos agora um ambiente para trabalhar com PHP de forma simples e que podemos configurar como quisermos, com opcionais para trabalhar com outros serviços. Nos prṍximos posts falarei sobre outros tópicos:

* ~~Montando um ambiente com PHP, Apache e MySQL (e alternativas)~~ - [Docker e Docker Compose com PHP]({% post_url 2017-11-24-docker-php %})
* Como trabalhar com este ambiente - [Conteinerizando PHP e outras coisas]({% post_url 2017-11-29-docker-php-2 %})
* Imagem do PHP já vir com algum framework (Laravel, Symfony e Zend Expressive) - [Imagem Docker com PHP + Framework(s)]({% post_url 2017-12-13-docker-frameworks-php %})
* Docker Compose para testes automatizados com Selenium
* Configurar IDE para trabalhar com o XDebug do conteiner (Netbeans e Visual Studio Code)
* Uso de shell scripts para automatizar mais ainda as tarefas (PHPUnit, Behat, etc)
* Subir as imagens para o Docker Hub

Até o próximo post!!!
