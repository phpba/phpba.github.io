---
layout: post
title:  "Para Iniciantes: O surpreendente Laragon."
date:   2018-05-31 23:15:00
author: 
    name: "Frank Rocha"
    mail: "fsrocha.dev@gmail.com"
    github: "fsrocha-dev"
    blog: "https://medium.com/@fsrocha"
categories: 
    - Infraestrutura
    - Estudos
tags: ["Infraestrutura", "PHP", "Servidor"]
cover:  "/assets/posts/2018/05/infraestrutura/capa_laragon.png"
---
Eis um grande problema para quem está iniciando no mundo do desenvolvimento PHP, montar seu ambiente de desenvolvimento. É certo que a grande maioria se depara com soluções como Wamp ou Xamp! oque não é de todo desprezivél, haja visto que o principal foco daquele que está iniciando no mundo da programação, deveria ser somente em aprender de fato a Linguagem escolhida, se debruçar sobre o manual da linguagem e torrar muito café ao longo dos estudos durante muitas madrugadas.
Mas eis que acabaram os seus problemas, vou lhes apresentar rapidamente o [Laragon](http://laragon.org), uma alternativa super produtiva e elegante para preparar seu ambiente PHP.

# Mas, qual vantagem de usar Laragon?
Como tinha dito, o Laragon é a maneira mais rápida de preparar um ambiente completo de desenvolvimento, sua instalação é básica, é dar next, next next. e você pode baixa-lo no seguinte link [laragon.org](https://laragon.org/download/#PHP). vou listar abaixo as suas vantagens.

- Não precisa se preocupar em criar VirtualHost.
- Posso trabalhar com vários bancos de dados já pré configurados(Mysql, PostgreSql, MongoDB)
- Com apenas alguns clicks, posso escolher:
   - Qual banco de dados usar: Mysql, PostgreSql, Mongo etc.
   - Qual versão do php quero usar.
   - Se quero usar como servidor o Apache ou Nginx.
   - Mail Catcher e Mail Sender.

E tudo isso já pré configurado!.

# VirtualHost automático?
Isso mesmo! ao instalar o laragon, você encontrará dentro do seu diretório, uma pasta chamada "www", toda pasta que você criar dentro dela, ao iniciar o laragon ele irá interpretar que aquela pasta é um novo projeto, e automaticamente criará um VirtualHost para você com o nome da pasta! Ex: se você criar dentro da pasta "www" uma pasta com o nome "blog", ele irá criar um virtualhost, ai é só você abrir o seu navegador e digitar blog.test, e você verá no navegador o seu site que está dentro da pasta blog.

![VirtualHost](/assets/posts/2018/05/virtualhost_laragon.jpg)


# Instalação automática dos principais Frameworks PHP.
Fácilmente você poderá criar projetos com os mais usados frameworks php, como Symfony, Laravel, WordPress, Joomla e muitos outros.

![Menu Frameworks](/assets/posts/2018/05/menu_laragon.jpg)


# Cather Mail
Ao desenvolver um sistema para web, por vezes precisamos enviar alguns e-mails para fins de teste, para não ter que encher nossa caixa de e-mail, com teste de e-mail, Laragon oferece um recurso de captura de e-mail. Ele armazenará e-mails enviados de seu sistema e os exibirá por 5 segundos por padrão. Dessa maneira, você pode visualizar seus e-mails com facilidade e não precisará pesquisá-los na sua caixa de entrada ou na pasta de spam.

# E-mail com remetente
Você também pode enviar email com laragon, usando o Mail Sender. Simplesmente com o endereço e a senha do Gmail você poderá enviar e-mails.
OBS: só funciona com o Gmail.

# Conclusão.
Enfim, se você está iniciando no mundo da programação, precisa de uma ambiente para desenvolvimento fácil e super produtivo, a melhor opção para você jovem Dev, será o Laragon, depois de aperfeiçoar as suas habilidades com a linguagem, ai sim, seria uma boa pedida aprender um pouco sobre containers com Docker, aqui no PHPBA já existem ótimos [posts](http://phpba.com.br/posts/#Docker), criado por Marcio Albuquerque sobre o assunto.

Então Devs, não há mais desculpas para estudar PHP, Espero que tenham gostado e qualquer dúvida, crítica ou sugestão basta colocar nos comentários, responderei o mais rápido possível.

Há só para animar, estou produzindo uma video aula explicando de forma mais ampla o uso do Laragon!