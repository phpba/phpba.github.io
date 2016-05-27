---
layout: post
title:  "2º PHPeetup: Entendendo os Microframeworks"
date:   2016-05-27 14:30:00
author: 
    name: Felipe Bastos
    mail: felipebastosweb@gmail.com
    github: felipebastosweb
    blog:
    twitter: felipebastosweb
    facebook: felipebastosweb
categories: 
    - Php
    - phpeetup
tags: 
    - phpeetup
    - palestra
cover:  "/assets/posts/2016/05/2phpeetup/capa.jpg"
---

### Retrospectiva

Antes do palestrante entrar no Assunto Microframeworks e MicroServiços realizamos (todos participaram) uma Retrospectiva dos últimos 15 anos da Tecnologia PHP. Sim, uma retrospectiva de nossas experiências é uma atividade importantíssima antes de iniciarmos um novo projeto pois ela nos faz relembrar tudo o que deu certo ou errado e nos ajuda a tomar decisões mais acertadas no projeto que se inicia.

Ao relembrar muitas das dificuldades que passamos abrimos espaço para entender o por quê surgiu a tecnologia de MicroFrameworks e o por quê dos Micro Serviços começarem a dominar o Cloud Computing e o desenvolvimento de software.

Durante a retrospectiva relembramos da migração dos sistemas desestruturados (Spaguetti) para o código em camadas (MVC - Model View Controller). Vimos a mudança de requisitos não funcionais os critérios de desempenho dos frameworks monolíticos (Zend e Symfony 1) para critérios mais elaborados como a Componentização, a miniaturização dos frameworks, o código refatorado, e a melhoria de desempenho derivada dessas abordagens. Relembramos também como era nossa postura diante da manutenção e escala dos sistemas, na Era onde os sistemas ainda podiam parar. Por fim, adentramos na Era atual onde Dividimos e Conquistamos mais rápido nunca, em hipótese alguma, parando o serviço.

### Conceito

Foi apresentado o grande diferencial de uma aplicação comum (hoje em extinção) para uma aplicação orientada a Serviços, onde segundo <i>Martin Fowler e James Lewis</i>, as Aplicações hoje estão passando a serem concebidas como uma suíte de Serviços implementados de forma Independentes entre si.

Durante a apresentação vimos que um Micro Serviço necessita ser construído com Frameworks bem pequenos para atender a critérios de desempenho, flexibilidade, etc e que a unidade mais atômica de um framework é uma Classe (Geralmente na forma de Container - ex. Pimple). Vimos ainda que não é necessário ter Rest e vismos um exemplo prático de como surgiram os primeiros microframeworks, mesmo que tivessem nascido de brincadeiras de quem conseguia fazer o menor framework, o conceito ali começou a ser validado e hoje diversas empresas o utilizam (ex. Amazon AWS).

<script src="https://gist.github.com/felipebastosweb/630431218b1faae82fab7b0214a28133.js"></script>

###### Componentização

Dando prosseguimento a apresentação, acompanhamos um Comparativo entre a nova modalidade de Componentes vistos nos Microframeworks e os Componentes Físicos de produtos (Armadura do Iron Man), a forma como são testados desde a sua criação, a independencia deles entre si e como em conjunto formam estruturas complexas expetaculares. Além disso, o Felipe citou como a automação da Infraestrutura dos sistemas e a necessidade de maior inteligencia (artificial) na autogestão (referencia ao Jarvis de Tony Stark) está transformando a forma como as empresas lidam com tecnologia (referencia a Amazon AWS, etc).

Ainda sobre Componentes, acompanhamos (através da figura da Armadura Anti-Hulk) como os componentes especificos contribuem para a construção de Micro Aplicações com propósitos específicos, e principalmente como isso contribui para a melhoria da manutenção e escalabilidade dos sistemas.

###### Escalabilidade

Ao falar da escalabilidade, vimos o quão custoso é iniciar uma aplicação monolítica e o impacto disso na hora de escalar. Fomos levados a incluir nos nossos critérios de escolha não apenas o framework preferido ou que temos maior produtividade, mas a pensarmos nos custos com processamento, replicação, deploy, manutenção e até mesmo os custos financeiros dos nossos projetos. Vimos ainda que quando a aplicação é Orientada a Serviços podemos tratar cada serviço de forma isolada, escalá-los de acordo com a composição necessária para atender a uma demanda real por serviços oriundas dos nossos clientes, e vimos que apesar de termos um aumento de custos em virtude do aumento do parque de tecnologias incluídasno projeto, todo os demais ganhos com redução de custos tornam os projetos mais lucrativos e interessantes para todas as partes (o cliente que paga e recebe geração de valor diariamente, a fábrica de software que entrega valor e recebe pagamentos periodicamente, e o desenvolvedor que se torna mais produtivo e trabalha em mais projetos).

Vimos também que com a evolução diária dos projetos as equipes precisam de tornar mais multifuncional e evolutiva, como abordado no Manifesto Ágil. E dessa forma, a equipe se torna mais flexivel e o trabalho otimizado e desafiador sempre.

###### As Opções e o Estudo de Caso

Comentamos sobre algumas das várias opções existentes no mercado, entre elas o Slim, o Silex e o Aura e suas vantagens e desvantagens. Em seguida o Felipe Bastos nos contou sobre um estudo de caso em que ele optou pelo Slim para atender a uma necessidade do cliente em um prazo extremamente curto de 1 semana. Nesse estudo de caso ele demonstrou como utilizou o Goutte (Lib que usa Componentes Symfony) junto com o Slim para automatizar trabalhos administrativos que ele precisa desempenhar todo ano.

E por fim, já fora da figura de dev e assumindo uma postura mais gerencial ... ele justificou por que hoje em dia todo mundo está adotando projetos Orientados a Serviços (Micro Serviços), que utilizem equipes ágeis e métodos cada vez mais ágeis, e que tenham altíssimo Valor de Negócio e custos decrescentes para entregar incrementos de Produto para os Clientes..

Se você quiser ver os slides (inacabados - não tive tempo) da apresentação ![Slides](http://pt.slideshare.net/felipeabm/entendendo-os-microframeworks-em-php)

Ou pode ver aqui mesmo, no PHPBA.

<iframe src="//www.slideshare.net/slideshow/embed_code/key/KYHArhmskyHW2v" width="595" height="485" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="border:1px solid #CCC; border-width:1px; margin-bottom:5px; max-width: 100%;" allowfullscreen> </iframe> <div style="margin-bottom:5px"> <strong> <a href="//www.slideshare.net/felipeabm/entendendo-os-microframeworks-em-php" title="Entendendo os microframeworks em PHP" target="_blank">Entendendo os microframeworks em PHP</a> </strong> from <strong><a href="//www.slideshare.net/felipeabm" target="_blank">felipebastosweb</a></strong> </div>

![Final](/assets/posts/2016/05/2phpeetup/final.jpg)
