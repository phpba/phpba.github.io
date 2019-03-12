---
layout: post
title: "Buscas com alta performance e melhor resultado: ElasticSearch"
date: 2016-02-16 01:15:00
author: 
    name: "Hugo Henrique"
    mail: "contato@hugohenrique.com.br"
    github: "hugohenrique"
    blog: ""
    twitter: "@hugohenrique"
categories: elasticsearch
cover:  "/assets/posts/2016/02/elasticsearch.png"
---

**Se você está satisfeito com a perfomance da sua busca atual, eu acho que esse post não irá ser muito útil para você!**

Você precisa tornar os resultados da sua busca mais relevantes para o usuário?
Que tal usarmos um engine [full-text](https://en.wikipedia.org/wiki/Full_text_search)?

Se você provavelmente usa o MySQL, certamente você ouviu falar que ele tem suporte a buscas full-text ou até tentou usar esse recurso dele, mais com certeza você ainda não conseguiu suprir sua necessidade, ou por mais que tenha conseguido melhorar a sua busca, percebeu que após colocar em produção teve uma aumento absurdo de processamento. Daqui alguns meses a empresa que você trabalha irá fazer um mega-ultra-promoção, que com certeza, esse evento acarretará em um ganho exponencial de acessos. 

Te faço agora um simples questionamento: 

1. Sua estrutura está pronta para escalar em tempo hábil?
2. Não teremos surpresa? *Seu chefe certamente irá lhe perguntar algo desse tipo? ``:)``*

Posso lhe sugerir uma ferramenta que irá evitar esses transtornos e consequetemente lhe proporcionar uma melhor entrega nos resultados da busca na sua aplicação?

## [ElasticSearch](http://www.elasticsearch.org/)

> Wikipedia: *ElasticSearch? (ES) é um servidor de buscas distribuído baseado no Apache Lucene. Foi desenvolvido por Shay Banon e disponibilizado sobre os termos Apache License. ElasticSearch foi desenvolvido em Java e possui código aberto liberado como sob os termos da Licença Apache.*

ElasticSearch (ES) é um motor de busca distribuído baseado no Apache Lucene, é open-source e uma ótima __engine__ para buscas full-text.

Características:

 * É distribuído;
 * Alta disponibilidade;
 * Disponibiliza dados em tempo real;
 * Orientado a documentos;
 * *Schema-less* (Não exige a declaração do esquema)

Grandes empresas da web já usam o ES, como:

 * Facebook
 * Twitter
 * GitHub
 * FourSquare

Por ser orientado a documentos o ES obviamente armazena os dados em forma de documentos e os disponibiliza em formato *JSON*.
O documento trabalha com o conceito simples de chave e valor. As chaves são *strings* e o valor pode ser qualquer tipo de dado válido.

Apenas para facilitar o entendimento vamos comparar com o MySQL:

| ES       | MySQL
| ---------|---------
| Index    | Database
| Type     | Table
| Document | Row
| Mapping  | Schema
| Field    | Column
| Mapping  | Schema

## Indexar documentos
Por seus recursos estarem disponíveis em uma *API RESTful*, para indexar um documento ao ES é extremamente fácil, basta somente fazer uma simples requisição POST ao ``type`` que pretende indexar, passando o documento no corpo da requisição um exemplo simples:

~~~
$ curl -XPOST '127.0.0.1:9200/mystore/product' -d '{
  "name": "Smartphone",
  "price": 400.00,
  "color": "gray"
}'
~~~

Ou seja, ao ``index`` **``mystore``** no ``type`` ``product`` estamos criando um novo produto "Smartphone".
Você pode também setar um identificador ao que deseja inserir ou também omitir se preferir como fiz no exemplo acima. 
Como resposta da requisição teremos:

~~~ JSON
{
  "_index": "mystore",
  "_type": "product",
  "_id": 1,
  "_version": 1,
  "_source": {
    "name": "Smartphone",
    "price": 400.00,
    "color": "gray"
  }
}
~~~

Perceba que a resposta retorna os chamados [*metafields*](https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping-fields.html): _index, _type, _id, _version, _source que são usados para personalizar a forma como são tratados na associação de um documento.

Se quiser resgatar esse produto inserido acima, basta fazer um requisição GET:

~~~
$ curl -XGET '127.0.0.1:9200/mystore/product/1'
~~~

O ES tem inúmeros recursos e uma [ótima documentação online](https://www.elastic.co/guide/index.html) e para fazer uma busca existe muitas formas, a mais simples é usando *query string* na URL:

```
http://127.0.0.1/myshop/product/_search?q=Smartphone
```

Ou seja, dizemos ao ES *me traga tudo que você encontrar com o termo **Smartphone***.

Se executarmos essa query acima obtermos o resultado:

~~~ JSON
{
  "took": 3,
  "timed_out": false,
  "_shards": {
    "total": 5,
    "successful": 5,
    "failed": 0
  },
  "hits": {
    "total": 1,
    "max_score": 0.30685282,
    "hits": [
      {
        "_index": "myshop",
        "_type": "products",
        "_id": "1",
        "_score": 0.30685282,
        "_source": {
          "name": "Smartphone",
          "price": 400.00,
          "color": "gray"
        }
      }
    ]
  }
}
~~~

Fazendo uma consulta usando a Query DSL simples seria algo como:

~~~
$ curl -XGET '127.0.0.1:9200/mystore/products' -d '{
  "query": {
    "match": {
      "name": "Smartphone"
    }
  }
}
~~~

Mais de novo, o ES dispõe de uma DSL muito potente, por isso vale a pena explorar bem seus recursos.

### Um pouco de conceitos

É importante lembrarmos que o ES não é um banco relacional nos conceitos DBMS, e com essa informação você precisa internalizar que conceitos como: normalização de dados e sub-queries, [devem ser quase sempre evitados](https://www.elastic.co/guide/en/elasticsearch/guide/current/denormalization.html) afinal de contas o ES foi desenvolvido para trabalhar com grandes volumes de dados.

Outro ponto importante, o ES não substitui por exemplo, um banco de dados relacional, pois como já vimos sua proposta é trabalhar com buscas full-text.

## Integração com o PHP

Já existem diversas libs que permitem e facilitam essa integração, nesse post vou recomendar duas.

A primeira é o cliente oficial, que você pode encontrar mais detalhes no [repositório oficial do ES no GitHub](https://github.com/elastic/elasticsearch-php), possui atualizações constantes e tem uma boa documentação.

A segunda é uma lib também muito utilizada chamada [**Elastica**](https://github.com/ruflin/Elastica) que não é oficial, mais que a comunidade adotou bastante. Ela possui [boa documentação](http://elastica.io) e sua comunidade é bastante ativa. Mais antes de utilizar qualquer uma dessas, lhe sugiro conhecer as duas, não custa nada. ``:P``

## Conclusão

O ES é uma ferramenta muito poderosa e proporciona a você um ótimo desempenho em alta escala.
Ele pode ser usado para diferentes contextos, como: 

 * Pesquisas estruturadas
 * Auto-completar
 * Geo-localização

Segundo o GitHub ele usa ElasticSearch para consultar mais de 130 bilhões de linhas de código.
Novamente, vale a pena navegar por sua documentação e conhecer os diversos recursos ofericidos por essa excelente ferramenta.

Espero ter contribuído em algo para vocês e nos próximos posts abordarei funções e casos de uso mais avançados.
Se tiverem alguma crítica e/ou sugestão não hesite em entrar em contato, será um prazer.

## Leituras complementares

 1. [ElasticSearch Guide](https://www.elastic.co/guide/index.html)
 2. [O que é ElasticSearch, e como posso usá-lo?](https://www.linkedin.com/pulse/o-que-é-elasticsearch-e-como-posso-usá-lo-douglas-falsarella)
 3. [Seu site tão rápido quanto o Google usando ElasticSearch](http://imasters.com.br/design-ux/user-experience-design/seu-site-tao-rapido-quanto-o-google-usando-elasticsearch)
 4. [Introduction to Elasticsearch in PHP](http://www.sitepoint.com/introduction-to-elasticsearch-in-php/)
