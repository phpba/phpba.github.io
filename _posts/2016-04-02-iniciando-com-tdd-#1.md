---
layout: post
title:  "Iniciando com TDD #1 - Minha motivação e primeiro contato"
date:   2016-04-02 03:15:00
author: 
    name: "Felix Costa"
    mail: "fx3costa@gmail.com"
    github: "fxcosta"
    blog: "https://fxcosta.wordpress.com/"
    twitter: "@fxcosta"
    facebook: "fx3costa"
categories: 
    - php
tags: 
    - tdd
    - php
    - unit-testing
---

### Motivação

Já faz um tempo que eu comecei a me preocupar com o código que eu estava desenvolvendo.
Mas não me preocupar somente em ele estar errado e conter algum bug que passou despercebido,
mas sim preocupado em saber se minha solução estava bem desenhada e se ela evoluiria junto com o
software sem quebrar nada futuramente.

Aquele estilo de codificar, entregando a primeira solução que me viesse a cabeça sem
ao menos pensar no design da aplicação e aqueles testes manuais que as vezes tomavam mais tempo
que o tempo de codificação começaram a não mais fazer sentido.

O software era entregue, em menos de 5 horas surgiam os primeiros bugs. Mas como? Eu pensava. Eu o testei completamente. Até soltava a famosa frase: "Mas funciona na minha máquina!". Não fazia sentido. Como algo que eu testei aqui funcionava e em produção não? Será que os meus testes
realmente eram eficazes ou confiáveis? Piorava quando aparecia uma nova feature. Ela era concluída e testada - da mesma maneira ruim - e em produção simplesmente quebrava as antigas features. Mas era óbvio. Afinal, são quase trocentas features, como ficar testando cada uma delas a cada nova funcionalidade?

Foi que acabei encontrando, por acaso como na maioria dos casos, o conceito de testes automatizados.
Acredito que se você está lendo esse texto, certamente já ouviu falar, ou conhece um pouco suas vantagens ou o domina com certa experiência. O intuito do texto não é exatamente abordar toda a filosofia por trás do [TDD - Test Driven Development](https://pt.wikipedia.org/wiki/Test_Driven_Development), mas tentar nortear afim de começarmos a pensar
dessa maneira. Ao final do artigo deixarei diversos materiais para quem deseja se aprofundar tecnicamente no assunto. Recomendo todos eles.

Como toda quebra de paradigma no começo parece estranho, ruim, custoso. Mas também como em toda quebra de paradigma nos acostumamos. Mas, que tal agora pularmos a parte da história e vermos como
foi meu primeiro contato?


### Como começar?

Mudar a forma de pensar e agir de algo que você já faz é árduo. Assim como foi para mim pensar em [NoSQL](https://pt.wikipedia.org/wiki/NoSQL), foi para mim pensar em TDD. O que? como criar um teste de algo que ainda nem existe?

Assim também como todo bom iniciante, fui atrás dessas e outras perguntas e elas motivaram não só meu inicio como minha primeira ajuda com o assunto. [Nelson Senna](http://nelsonsar.github.io/), mais conhecido pela comunidade PHP Brasil, me ofereceu gentilmente ajuda dando a ideia de um [Pair Programming](https://en.wikipedia.org/wiki/Pair_programming). Nem preciso dizer que aceitei sem nem pensar, né? Um cara com a experiência dele e um defensor da filosofia TDD, puts, ou entendia de vez ou então entendia de vez.

Agradeço ao Nelson pela grande ajuda e por ser o motivador desse artigo.

Então, como começar? Perguntar para quem mais tem experiência é um ótimo começo.

### A ideia e o ambiente

Como o proprio Nelson fala em seu [artigo](http://nelsonsar.github.io/2016/02/23/How-I-practice-TDD.html), começar a aprender TDD com códigos reais, códigos de produção, pode não ser uma boa alternativa devido a complexidade existente naquele cenário, que pode
dificultar o entendimento de algumas coisas e adoção progressiva da filosofia. Então, podemos começar do mais simples, certo? Certo, mas mais do que simples, algo funcional, que nós faça realmente ter um problema de design e que nos faça exercitar nosso poder de soluções.

Então, conheci o [Project Euler](https://projecteuler.net/archives) que é um projeto muito interessante, como um repositório de problemas matemáticos de diferentes níveis, inclusive os mais básicos que nos permitem ter um bom cenário para testar. E o principal de tudo: o caso simples do problema é entregue pela questão. O que facilita os nossos testes porque sabemos exatamente o que vamos fazer e o que nossa classe deve retornar para nós.

O nosso ambiente não possui nenhuma configuração além da necessária para rodar um projeto PHP. No meu caso, eu preferi iniciar um projeto utilizando o [Composer](https://getcomposer.org/), que me permitiria controlar minhas dependências e gerar meu autoloading. O framework usado para testes no caso é o famoso [PHPUnit](https://phpunit.de/). A hierarquia de pastas é:

- src
    - PHPEuler
- tests
    - PHPEuler
- vendor
- composer.json

É interessante que sua pasta que conterá suas classes de testes contenham uma réplica de namespace da sua pasta central src, para manter uma melhor organização. Se ainda não tivermos o PHPUnit instalado, podemos simplesmente adiciona-lo em nosso composer.json:

~~~ JSON
    "require": {},
    "require-dev": {
        "phpunit/phpunit": "4.6.*"
    },
~~~

O PHPUnit possui um arquivo de configuração completo com todas as opções e preferências, mas por hora, vamos ignora-lo, ao menos nessa primeira etapa. Porém, ainda é necessário especificar para a suíte de testes qual o nosso autoload central, por isso, nosso comando ao executar nossos testes será:

~~~
$ vendor/bin/phpunit --bootstrap vendor/autoload.php tests
~~~

Onde "bootstrap" é a configuração para faze-lo encontrar nossas classes e "tests" é o diretório onde nossas classes de testes estão, segundo a nossa hierarquia de pastas.

O ambiente está pronto. Agora vamos a parte interessante.

### Finalmente, código

Pronto. Agora vamos pegar um problema no Project Euler, criar minha classe que resolve o problema
e depois criamos os testes, certo? Não. Não é o objetivo do texto, mas nunca é demais citar: [red-green-refactoring](http://blog.cleancoder.com/uncle-bob/2014/12/17/TheCyclesOfTDD.html). São os passos por trás do TDD. Falhar, passar, refatorar.

* Nosso código deve falhar inicialmente porque ele não foi projetado pra passar (ainda). 
* O nosso código deve passar com o mínimo de esforço possível, somente o básico para passar.
* Vamos refazer o nosso código para que ele atenda aos princípios da orientação a objetos e para que o teste continue passando.

Perceba que, o 3 passo é essencial para entender design orientado a objetos, que nada mais é que a orientação a objetos seguida da melhor e correta maneira. Tente seguir os princípios, na primeira semana poderá ser ruim, na segunda também, mas na terceira... tudo faz sentido.

Então, basicamente o nosso primeiro passo é criar uma classe de teste para uma classe que ainda não existe. Faz sentido? Sim, queremos ter certeza de que ele irá falhar (RED). É um método obrigatório? Eu não poderia simplesmente criar a classe já antes? É um bom tópico para discussão. O que vocês acham?

Em todo caso, vamos a nosso problema. Consultando o Project Euler, escolhemos um problema simples, que de cara é o [problema 1](https://projecteuler.net/problem=1): Encontrar a soma de todos os múltiplos de 3 e 5 em um determinado range. O problema nos dá uma base para teste:

~~~
If we list all the natural numbers below 10 that are multiples of 3 or 5, we get 3, 5, 6 and 9. The sum of these multiples is 23.
~~~

Escolhido o problema a ser atacado, é hora de codar. Nossas classes devem possuir o mesmo nome da
classe que resolverá o problema seguido do prefixo Test, em nosso caso, MultipleCalculatorTest.php

~~~ PHP
<?php

namespace PHPEuler;

class MultipleCalculatorTest extends \PHPUnit_Framework_TestCase
{

}
~~~

Precisamos entender agora o que deverá ser testado. O nosso problema pede uma soma de múltiplos de determinados números. Isso corresponde a uma unidade do sistema. Uma única responsabilidade de todo um sistema. Testamos unidades com funções. Convém que o nome das nossas funções responsáveis por testar unidades do sistema contenham um nome que deixe explicito o que elas se propõem a testar. Até mesmo pra evitar codeblocks em uma classe de testes. No nosso caso, o que queremos?


~~~ PHP
<?php

namespace PHPEuler;

class MultipleCalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testMultiplesSumOfThreeAndFiveUpToTen()
    {
    }
}
~~~

Com esse esqueleto podemos partir para o teste. Mas há ainda passos a seguir nesse teste. Basicamente, nosso teste de unidade deve estar separado em 3 etapas:

* O que estamos esperando como retorno
* O retorno que recebemos da nossa classe
* A asserção para verificar se os dois valores correspondem com a asserção feita

Utilizando o guia base do problema que escolhemos, qual o valor que nós esperamos?

~~~
$expected = 23;
~~~

O que recebemos da nossa classe?

~~~
$calculator = new MultipleCalculator();
$result = $calculator->sum(10);
~~~

Uma pequena pausa para o snippet acima é que mesmo que sua classe não exista, podemos explicitar
o que nós esperamos que ela faça. A classe nem mesmo existe ainda, mas já temos em mente que um de seus comportamentos será fazer uma soma. Semanticamente nós temos uma classe que calcula múltiplos que contém um método de soma que recebe o que? O que precisamos para devolver a soma de múltiplos de 3 e 5? Precisamos do nosso range, e é exatamente o que passamos para sum()

Finalmente, como saber se o que recebemos condiz com o que estamos esperando? As famosas [asserções](https://phpunit.de/manual/current/pt_br/appendixes.assertions.html), que existem aos montes de diferentes tipos para diferentes "comparações". A mais simples e famosa e que nos atende muito bem é somente a que verifique se os dois valores são iguais:

~~~
$this->assertEquals($expected, $result);
~~~

~~~ PHP
<?php

namespace PHPEuler;

class MultipleCalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testMultiplesSumOfThreeAndFiveUpToTen()
    {
        $expected = 23;
        $calculator = new MultipleCalculator();

        $result = $calculator->sum(10);

        $this->assertEquals($expected, $result);
    }
}
~~~

Ao rodar nosso código, independente da classe implementada ou não, teremos um erro. Estamos na fase Red do ciclo de TDD. Lembre-se, para testar basta rodar agora em seu terminal:

~~~
$ vendor/bin/phpunit --bootstrap vendor/autoload.php tests
~~~

Consegue identificar o erro que o PHPUnit informou? Se a classe não existe, a crie dentro do seu pacote /src, se o método não existe, o crie. Se rodarmos novamente continuaremos tendo problemas, provavelmente porque sum() não nos retornou algo que fosse parecido com 23. Apenas pra ter o gostinho, implemente o seguinte:

~~~ PHP
<?php

namespace PHPEuler;

class MultipleCalculator
{
    public function sum($limit)
    {
        return 23;
    }
}
~~~

Temos Green. Mas não funcional ainda. O que precisa ser feito é, resolver o problema da maneira mais rápida afim de faze-lo passar (usar só o return 23; não vale :P)

~~~ PHP
<?php

namespace PHPEuler;

class MultipleCalculator
{
    public function sum($limit)
    {
        $sum = 0;

        for($i = 0; $i < $limit; $i++) {
            if($i % 3 == 0 || $i % 5 == 0) {
                $sum += $i;
            }
        }

        return $sum;
    }
}

~~~

Rodou? Verde. Eu resolvi o problema e o teste está passando, de tal forma que se colocarmos qualquer range, até mesmo o 100 como o problema pedia, ele nos retornará um número e será o mesmo que estamos esperando. Em produção, nosso código estaria pronto para entregar o que deve entregar.

Mas do ponto de vista do design OO, essa não é ainda uma boa solução. É nesse momento que saimos do momento Green e entramos no momento Refactoring. O momento onde nós agora nos dedicamos a rescrever a nossa classe, para que tente atender sempre aos bons principios e para que, principalmente, passe nos testes novamente.

O pensamento é: o que pode ser melhorado? Aparenta ser um método inofensivo que simplesmente retorna o que ele deve. Não há nada o que melhorar? Sim, há, e, pelo menos dessa vez, vos entregarei o que está errado nela.

O nome do método é sum(), logo, ele tem a responsabilidade de somar algo. Ele faz isso enquanto ele está em loop e ele retorna isso. Mas há algo dentro dele que não é uma soma.

~~~
if($i % 3 == 0 || $i % 5 == 0) {
~~~

Isso não me parece ser um trabalho de uma classe que soma. Saber se um número é ou não múltiplo não deve ser responsabilidade de um método que promete somar e entregar somas. Não há reuso de código. Estamos ferindo diretamente [SRP - Single Responsability Principle](https://en.wikipedia.org/wiki/Single_responsibility_principle) - Responsabilidades únicas para cada classe e para cada método. MultipleCalculator só pode ser responsável por calcular múltiplos enquanto seus métodos devem possuir uma responsabilidade em específico.

Um guia que é recomendável - pra não dizer obrigatório - seguir quando estamos desenvolvendo, principalmente com testes porque fica bem mais visivel, é o catalogo de [Objects Calisthenics](http://williamdurand.fr/2013/06/03/object-calisthenics/).
Eles apresentam algumas regras para escrever um bom código OO. Se dermos uma olhada no catalogo e compararmos com nosso código poderemos saber se ele está próximo ou não do ideal. E vemos que logo no primeiro problema citado pelo catalogo o nosso falha:

~~~
1. Only One Level Of Indentation Per Method
~~~

Somente um nível de identação por método. O nosso possui dois:

~~~
for($i = 0; $i < $limit; $i++) { // 1 nível
    if($i % 3 == 0 || $i % 5 == 0) { // 2 nível
        $sum += $i;
    }
}
~~~

Ou seja, realmente temos que partir pro refactoring afim de tornar essa classe realmente pronta para produção. Pausa pra meditação ninja.....

~~~
<?php

namespace PHPEuler;

class MultipleCalculator
{
    public function sum($limit)
    {
        $sum = 0;

        for($iterator = 0; $iterator < $limit; $iterator++) {
            $sum += $this->isDivisible($iterator);
        }

        return $sum;
    }

    /**
     * @param $number
     * @return mixed
     */
    private function isDivisible($number)
    {
        if($number % 3 == 0 || $number % 5 == 0)
            return $number;
    }
}
~~~

Rodou? Green. Ciclo completo, classe pronta, unidade testada. Podemos garantir que essa classe funciona e mesmo que hajam mudanças, saberemos de maneira muito rápida se ainda funciona ou não. Basta acionar nossa suite de testes novamente.

Claro, não está perfeita e pode ser melhorada, mas por hora é o bastante para nós. O artigo ficou maior do que eu imaginava.

Obviamente, subi todos os códigos usados no artigo e no pair programming para meu repositório com a intenção de ficar aberto para todos e com o objetivo de virar uma especie de série sobre TDD, a medida que eu vou aprendendo. O meu repositório é esse [aqui](https://github.com/fxcosta/tdd-series). Fork, comente, critique, contribua :-)

Pretendo lançar o mais breve possível a parte 2 desse artigo e ir aumentando o nível de complexidade dos estudos até chegar em um código de produção.


### Considerações finais e referências

Como deixei subentendido no começo do artigo, este é voltado para quem está com problemas
em iniciar no mundo de testes, assim como eu tive e tenho. Espero que seja útil e que tenha ajudado de alguma forma. Claro, essa primeira parte talvez tenha sido básica demais, mas aos poucos usar testes será uma coisa tão simples e natural quanto desenvolver da antiga forma: focado em terminar um código e não em entregar valor.

Se tiverem alguma crítica e/ou sugestão entre em contato, estou a disposição. Se houver algum erro, peço humildemente que me informe para que possa ser corrigido brevemente.

1 - [TDD: How to use Math to get into it](http://nelsonsar.github.io/2016/02/23/How-I-practice-TDD.html)

2 - [PHPUnit: como iniciar sem dores](http://tableless.com.br/phpunit-como-iniciar-sem-dores/)

3 - [TDD Simples e prático](http://www.devmedia.com.br/test-driven-development-tdd-simples-e-pratico/18533)

4 - [Object Calisthenics](http://williamdurand.fr/2013/06/03/object-calisthenics/)

5 - [Introduction to TDD](http://www.agiledata.org/essays/tdd.html)

6 - [Meu repositório com todos os códigos](https://github.com/fxcosta/tdd-series)