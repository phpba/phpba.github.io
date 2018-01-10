---
layout: post
title:  "Relatórios de alto nível com PHP"
date:   2018-01-10 17:00:00
author:
    name: "Daniel Rodrigues"
    mail: "danielrodrigues-ti@hotmail.com"
    github: "geekcom"
    blog: "https://medium.com/@geekcom2"
categories:
    - Relatórios
    - Business intelligence
    - BI
tags: ["relatorios", "PHP", "BI"]
cover:  "/assets/posts/2018/01/relatorios/phpjasper.png"
---
Embora seja uma parte essencial em qualquer sistema, criar relatórios com PHP tem tirado o sono de muitos desenvolvedores,
muitas ferramentas exigem que o desenvolvedor escreva código em HTML + CSS
pra depois gerar um PDF e quando falamos em dados complexos a coisa complica
de tal forma que as vezes é necessário algumas centenas de linhas de código.

Agora todos os seus problemas acabam agora com o [phpjasper](https://github.com/PHPJasper/phpjasper/blob/master/docs/pt_BR/LEIA-ME_pt_BR.md) uma biblioteca livre para geração de relatórios PHP.

> PHPJasper é a solução perfeita para compilar e processar relatórios Jasper (.jrxml & .jasper) com PHP, ou seja, gerar relatórios com PHP.

### Preparando o ambiente

Primeiro você vai precisar do open jdk instalado no seu servidor já que iremos procesar arquivos do tipo jrxml ou .jasper,
para quem não conhece o Jasper Reports é a ferramenta mais famosa do mundo do desenvolvimento quando tratamos de saída de dados(relatórios),
baixe o [Jaspersoft Studio](https://community.jaspersoft.com/project/jaspersoft-studio) para o seu sistema operacional preferido e crie um modelo de relatório.

### Gerando seu relatório

```php
require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = __DIR__ . '/vendor/geekcom/phpjasper/examples/hello_world.jasper';
$output = __DIR__ . '/vendor/geekcom/phpjasper/examples';
$options = [
    'format' => ['pdf', 'rtf']
];

$jasper = new PHPJasper;

$jasper->process(
    $input,
    $output,
    $options
)->execute();
```

Simples assim, você deve apenas indicar onde está o relatório que você acabou de criar no jasper studio **$input**,
indicar onde o deve ser gerado o relatório **$output** e indicar o tipo de relatório que você deseja criar **$options**, os formatos possíves são:

**{‘pdf’, ‘rtf’, ‘xls’, ‘xlsx’, ‘docx’, ‘odt’, ‘ods’, ‘pptx’, ‘csv’, ‘html’, ‘xhtml’, ‘xml’, ‘jrprint’}**

É possivel ainda gerar relatórios de praticamente qualquer fonte dados, bancos relacionais como mysql, postgres,
sqlServer, bancos não relacionais como mongodb, gerar relatórios a partir de um arquivo XML ou Json por exemplo.

No repositório tem muitos [exemplos](https://github.com/PHPJasper/examples) de uso e a documentação está em português
e inglês, vale a pena parar de sofrer com relatórios e tentar algo novo,
toda contribuição é bem vinda.