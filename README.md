---
layout: page
title: Quer postar no Blog? Saiba como!
permalink: /writing/
---

# Blog do grupo PHP Bahia

Esse é o blog do grupo PHP Bahia. Toda contribuição será muito bem vinda.

[https://phpba.github.io][phpba]

## Instalação

O blog foi construido usando o [jekyll], logo para fazer um post e ir olhando localmente será necessário instalá-lo e suas dependências: [jekyll-paginate] e [jekyll-sitemap].

~~~
$ gem install jekyll
$ gem install jekyll-paginate
$ gem install jekyll-sitemap
~~~

## Uso

Poderá fazer as modificações e já ir vendo o resultado. Para tal:

~~~
$ jekyll server --watch
~~~

## Contribuindo

1. Faça um fork do repositório
2. Cria uma branch para sua contribuição: `git checkout -b sua-contribuicao`
3. Commit as mudanças: `git commit -am 'Mensagem sobre a mudança'`
4. Suba as alterações: `git push origin sua-contribuicao`
5. Manda um pull request

## Escrevendo posts

Para escrever um post siga os passos:

1. Faça um fork do repositório
2. Cria uma branch para seu post: `git checkout -b nome_do_post`
3. Crie um arquivo na pasta `_posts` com o nome `ANO-MES-DIA-titulo.markdown` o formato da data é YYYY-MM-DD
4. Commit o post: `git commit -am 'nome do post'`
5. Suba o post: `git push origin nome_do_post`
6. Manda um pull request

## Formato do post

~~~ yaml
---
layout: post                        // Layout que será exibido o post, o nome do layout é post :)
title:  "Hello World"               // Titulo do post  
date:   2016-02-07 15:32:25         // Data e hora do post
original:                           // Link do post original, caso tenha replicado de seu blog pessoal
author: 
    name: Paulo de Almeida          // Nome do autor do post
    mail: paulodealmeida@gmail.com  // E-mail do autor
    github: paulodealmeida          // Endereço no GitHub
    blog:                           // Endereço do blog do autor
    twitter:                        // Conta no Twitter
    facebook:                       // Conta no Facebook  
categories:                         // Categorias do post separadas por virgula, se não houver categoria escrever "Sem categoria"
tags:                               // Tags
---

Lorem ipsum dolor sit amet.         // Texto do post
~~~


Na documentação do [Jekyll](http://jekyllrb.com/docs/posts/) tem outras informações para posts mais complexos.

## Agradecimento

* Deixamos aqui, primeiramente, nosso agradecimento a todos os [contribuidores] do blog
* Também não podemos deixar de agradecer ao [@bencentra][author] pelo [centrarium][theme].

[phpba]: https://phpba.com.br
[jekyll]: http://jekyllrb.com/
[jekyll-sitemap]: https://github.com/jekyll/jekyll-sitemap
[jekyll-paginate]: https://github.com/jekyll/jekyll-paginate
[contribuidores]: https://github.com/phpba/phpba.github.io/graphs/contributors
[author]: https://github.com/bencentra/
[theme]: https://github.com/bencentra/centrarium
