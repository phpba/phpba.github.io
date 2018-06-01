---
layout: post
title:  "Composer para iniciantes"
date:   2018-02-11 12:00:00
author: 
    name: "Renê Soares"
    mail: "reenerochase@gmail.com"
    github: "renesoaresse"
    blog: "https://medium.com/@reenesoares"
categories: 
    - Composer
    - Iniciantes
tags: ["Composer", "Iniciantes", "PHP"]
cover:  "/assets/posts/2018/02/composer/composer.png"
---
Com a grande diversidade dos frameworks PHP uma peça fundamental passa despercebida pelos desenvolvedores, mesmo utilizando diariamente. Sim, vamos falar sobre o composer.

# O que seria o composer?
O composer é uma ferramenta de gerenciamento de dependências para sua aplicação, sendo assim ela permite que você declare as bibliotecas que seu projeto vai utilizar e faz o instalação, atualização e gerenciamento delas.

# Por que usar o composer?
Quem tem mais tempo desenvolvendo ou pegou um projeto legado já se deparou com o seguinte problema: preciso criar uma tarefa que ao final gere um PDF e quando vai verificar se existe a biblioteca de PDF se depara com a mesma em várias versões. Complicado não é? Mas o composer ele ajuda a você não passar mais por isso, pois ele vai gerenciar essas dependências e as suas versões do mesmo.

# Instalando no macOS, Linux e Windows
Há instalação para o macOs e linux seguem o mesmo processo, porém é sempre bom ressaltar que você deve ter o PHP na versão 5.3.2 ou maior já instalado . Basta ir no site oficial do [composer](https://getcomposer.org/download/) e rodar esse código abaixo:

```php
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Mas o que esses comandos querem dizer?

- Baixa para o diretório atual o instalador
- Verifica se o instalador não está corrompido
- Roda a instalação do composer
- Apaga o instalador

Simples não é? Nesse momento você só vai poder usar o composer no diretório atual de onde foi instalado, para usar em qualquer diretório do sistema basta usar o comando mv composer.phar /usr/local/bin/composer e depois usar o comando composer — version. Gostaria de ressaltar que em algumas versões do macOS não existe o diretório /usr por padrão. Caso receba algum erro sobre a falta desse diretório basta rodar o comando mkdir -p /usr/local/bin antes do comando mv comentado acima.

Já a instalação no windows é bem mais simples, basta ir novamente no site oficial do composer e baixar/rodar o arquivo Composer-Setup.exe.

# O arquivo de configurações
Depois de baixado e instalado vamos falar sobre o arquivo de configuração composer.json.

Para criar esse arquivo, temos 2 maneiras:

- Criar o arquivo na mão;
- Criar o arquivo via o comando do composer;

Vou explicar a segunda opção pois é que mais uso e que facilita a minha vida. Para criar o arquivo composer.json eu uso o comando composer init, pois antes de criar o arquivo o composer vai fazer uma série de perguntas para somente depois criar o arquivo. Há primeira pergunta é o “name” do projeto, depois vem a “description” que é uma descrição do projeto, “author” nome/email do autor do projeto, “type” tipo do projeto, “homepage” site onde pode ser encontrado a documentação do projeto, “require” pacotes obrigatórios para o projeto, “require-dev” pacotes obrigatórios para o projeto em ambiente de desenvolvimento e “license” que é a licensa do projeto. Isso tudo é gerado no seu arquivo composer.json porém os itens dos campos require e require-dev você deve colocar depois que o comando rodar.

# Packagist
Agora que você tem o esqueleto do seu arquivo composer.json agora é hora de escolher os pacotes que vão ser utilizados no projeto. Para isso o composer usa como seu repositório o [Packagist](https://packagist.org/) onde os desenvolvedores podem disponibilizar os pacotes. Outra informação é que o packagist lhe fornece o total de instalações dos pacotes por dia, mês e o total. O mais legal é que estas estatísticas são fiéis, ou seja, se alguém remover um pacote do seu composer.json o total de instalações é reduzido. Com esta informação restam contagens apenas aplicações que realmente estão utilizando determinado projeto.

#Conclusão
Depois de escolher os pacotes para o projeto e colocarem no seu arquivo composer.json, basta usar o comando composer install para instalar todos os pacotes, bacana não é? Espero que tenham gostado do composer e comecem a utilizar e todos os projetos. Qualquer dúvida, crítica ou sugestão basta colocar nos comentário.