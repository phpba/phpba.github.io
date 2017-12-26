---
layout: post
title: "EditorConfig: Padronização de código para seus projetos"
date: 2016-11-23 15:30:00
author:
    name: "Gildásio Júnior"
    mail: "gjuniioor@protonmail.com"
    github: "gjuniioor"
    blog: "https://gjuniioor.github.io"
    twitter:
    facebook:
categories:
    - padrões
    - boas práticas
tags:
    - padrões
    - boas práticas
cover:
---

Postado originalmente em meu blog: [gjuniioor.github.io/blog/editorconfig/](https://gjuniioor.github.io/blog/editorconfig/)

Cansado de sempre discutir com sua equipe sobre padrões de estilização de código e ainda continuar dando ruim? Bem, [Editor Config \[0\]][0] deve ser a solução que você esperava!

## O que é Editor Config:

É um plugin que você pode instalar em vários editores de código ou IDEs para padronização dos estilos. 

Por exemplo, tamanho de tabulação. Se a indentação será feita por tabs ou espaços. Linha em branco no fim do arquivo?

Ele trabalha de forma simples, apenas instale o plugin em seu editor e crie um arquivo .editorconfig na raiz do seu projeto. Você também pode ter um arquivo desses como configuração global em sua máquina, basta adicionar o arquivo em seu diretório `home`.

## Instalação

Como utilizo vim, vou deixar aqui um link direto para as instruções que o próprio projeto disponibiliza: [editorconfig-vim \[1\]][1]

Os demais programas você pode ver na seção sobre [download \[2\]][2] no site do Editor Config para saber como fazer.

## Montando arquivo de configuração

O arquivo pode ficar alocado tanto no repositório de cada projeto como você pode fazer um padrão para você, localizado em sua pasta de usuário. O arquivo leva o nome `.editorconfig`, simpesmente.

Quando o Editor Config vai começar a trabalhar, ele olha para o diretório atual do arquivo aberto, em busca do .editorconfig e vai olhando também em todos os diretórios pai desse. Só para quando encontra a cláusula `root = true` em um desses arquivos. Portanto, é interessante começar o arquivo de configuração de seu projeto já com isso.

Nesse arquivo você pode fazer as regras dos estilos variando pelo formato do arquivo, utilizando as extensões como delimitadores, por exemplo `[*.html]`, ou colocar para valer para todos os formatos, com `[*]`. Importante salientar que a ordem em que as coisas são colocaras importa. Ele vai ler o arquivo e aplicar a configuração de cima para baixo, portanto, configurações mais genéricas devem ficar no topo.

Depois, basta você colocar as propriedades e seus valores na  sequência. A lista de todas as propriedades você pode ver na [wiki do Editor Config \[3\]][3], mais especificamente [nessa página \[4\]][4].

Algumas dessas propriedades eu acho bem interessante para se citar aqui, seguem elas:

### Charset

Você pode configurar o charset utilizado nos arquivos, veja:

~~~
charset = utf-8
~~~

### Indentação

Indentação é algo importante e que é caso de vida ou morte, certo? Pois bem, você pode configurar como que vai ser a identação, com espaços ou tabs, e colocar o tamanho:

~~~
indent_style = space
indent_size = 4
~~~

### Remoção de espaços em branco

Outra coisa interessante é tirar todos os espaços em branco que acaba deixando no final das linhas, seja por qualquer motivo. Para resolver isso:

~~~
trim_trailing_whitespace = true
~~~

### Outras propriedades

Ainda há várias outras propriedades, como falei anteriormente, como por exemplo, insere uma linha em branco no fim dos arquivos? Como deve ser tratado o final da linha?

Enfim, fica ai a página com as propriedades que o plugin aceita para uma configuração mais personalizada a partir de suas necessidades.

## Utilização em projetos

É interessante utilizar esse tipo de configuração em projetos para poder ter uma padronização do estilo do código. Principalmente quando falamos do mundo software livre, em que diversos programadores, com diversas configurações pessoais, estão ajudando em um mesmo projeto.

É bastante comum de se ver um .editorconfig na raiz de vários projetos que se tem por ai. Faça uma [pesquisa dessas \[5\]][5] no Github que você verá a quantidade de resultados que não aparece.

E é muito bom começar a fazer uso disso, principalmente para não ter essas inconsistências e acabar matando o padrão outrora resolvido, simplesmente por um mal entendido, certo?

Por fim, um forte abraço a todos e até mais ver!

## Links

~~~
[0]: http://editorconfig.org/
[1]: https://github.com/editorconfig/editorconfig-vim#readme
[2]: http://editorconfig.org/#download
[3]: https://github.com/editorconfig/editorconfig/wiki
[4]: https://github.com/editorconfig/editorconfig/wiki/EditorConfig-Properties
[5]: https://github.com/search?utf8=%E2%9C%93&q=.editorconfig
~~~

[0]: http://editorconfig.org/
[1]: https://github.com/editorconfig/editorconfig-vim#readme
[2]: http://editorconfig.org/#download
[3]: https://github.com/editorconfig/editorconfig/wiki
[4]: https://github.com/editorconfig/editorconfig/wiki/EditorConfig-Properties
[5]: https://github.com/search?utf8=%E2%9C%93&q=.editorconfig
