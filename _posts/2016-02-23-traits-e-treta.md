---
layout: post
title:  "Traits! Vai dar treta!!!"
date: 2016-02-23 06:00:00
author: 
    name: "Marcio Albuquerque"
    mail: "marcio.lima.albuquerque@gmail.com"
    github: "mlalbuquerque"
    blog: "http://culturabeta.com.br"
    twitter: "@mlalbuquerque"
    facebook: "mlalbuquerque"
categories: experiência php7
---

Não sei o quanto andam usando de novas funcionalidades do PHP do 5.4 pra cá.
Tenho tentado usar de tudo, pra aprender um pouco, ver viablidades de uso real e
me divertir um pouco também!

Vim aqui falar um pouquinho sobre Traits, essa novidade não tão nova, que introduz
um conceito interessante de usar mixins, como em linguagens como Ruby. A ideia,
basicamente, é poder introduzir __*pedaços de código*__ em classes, garantindo um reuso
desses __*pedaços*__ em várias classes. Normalmente, esse conceito é usado em linguagens
que não têm herança múltipla, como o PHP, Ruby, entre outras.

Não vou falar aqui do uso de traits em frameworks, como Laravel ou Symfony, que fazem bastante
dessa ferramenta. Mas quando poderiam usar traits e como usar, de forma bem simples.

Um exemplo de Trait está abaixo:

~~~
trait OSCheckTrait
{
    
    public static function serverOS()
    {
        $os_type = php_uname('s');
        $os = null;
        if (preg_match('/^(unix|linux|darwin)/i', $os_type) || preg_match('/bsd$/i', $os_type)) {
            $os = 'unix';
        } elseif (preg_match('/^win)/i', $os_type)) {
            $os = 'windows';
        } else {
            throw new \Exception('OS not determined!');
        }
        return $os;
    }
    
}
~~~

Essa trait tem um método - __*pedaço de código*__ - que retorna o tipo de SO do servidor.
É o tipo de código que pode-se reutilizado em várias partes de seu código/sistema/app.

E como usamos isso? Basta dizer que sua classe está usando essa trait que imediatamente
ela passa a ter acesso ao(s) método(s) definidos na trait.

~~~
class PrinterManagerFactory
{

    use OSCheckTrait;

    public static function build()
    {
        $printer_manager = "\\App\\PrinterManager\\" . ucfirst(self::serverOS()) . 'PrinterManager';
        return new $printer_manager;
    }

}
~~~

Vejam que usei apenas <code>use OSCheckTrait</code> e já tenho acesso ao método - <code>self::serverOS()</code>.
Lembrem-se também que traits também seguem as PSR-1, PSR-2 e PSR-4.

Depois, utilizei essa mesma trait em outra classe Factory, reutilizando o método.

~~~
class PrinterUtilFactory
{
    use OSCheckTrait;

    public static function build()
    {
        $printer_util = "\\App\\Util\\" . ucfirst(self::serverOS()) . 'PrinterUtil';
        return new $printer_util;
    }
}
~~~

Agora vem a treta!! Muitos poderiam dizer: "*Mas você poderia criar uma classe pai que tivesse
esse método e herdar as duas classes Factory dessa classe pai. Assim, as duas classes já teriam
o método e poderia reutilizar do mesmo jeito!*".

É bem verdade isso, mas aí eu não poderia o método <code>serverOS</code> da trait em outras
classes, que foi o que acabou acontecendo. Na verdade, essa foi a ordem dos
eventos: eu criei a classe pai. Vi que precisaria do método em outros locais e refatorei tudo:
criei a trait, a chamei nas classes que queria usar (além das Factories) e destrui a classe.
Naquele esquema, __*BABY STEPS*__!!

Por isso que digo sempre, não precisa sair querendo usar tudo que se conhece e aprende, mas é
importante saber das coisas novas para quando precisar, sabe como e quando usar.

Espero que tenha ajudado em como e quando usar traits um pouquinho. Qualquer dúvida, estamos aí.
Se querem saber um pouco mais sobre traits, no próprio portal do PHP tem bons
[exemplos de Traits](http://php.net/manual/pt_BR/language.oop5.traits.php).

### [EDITADO EM 24/02/2016]

Por causa de uma [ideia](https://github.com/phpba/phpba.github.io/pull/39#issuecomment-187958850)
de [Jonata Weber](https://github.com/jonataa), acabei colocando mais um adendo sobre testes com Trait.

Eu estava fazendo no esquema de criar um objeto falso - __Mock__ - em tempo de execução que usaria minha trait
e depois testaria. MAS, versões mais novas do PHPUnit resolveram nossos problemas: <code>getMockForTrait()</code>.
Isso faz com que consigamos criar um objeto que usa a trait e não precisamos mais escrever código com
a classe falsa que usa a trait.

Usando a minha trait que mostrei mais acima, basta fazer algo assim no PHPUnit:

~~~
class OSCheckTraitTest extends PHPUnit_Framework_TestCase
{
    private $osCheck;
    
    public function setUp()
    {
        $this->osCheck = $this->getMockForTrait(OSCheckTrait::class);
    }

    public function testReturnsUnixRunningOnLinux()
    {
        $this->assertEquals('unix', $this->osCheck->serverOS());
    }
}
~~~

Reparem como fucou super fácil trabalhar os testes das traits. E ainda tem mais: se a trait tiver
métodos abstratos, podemos fazer algo assim para falsificar esse método - __*method mocking*__:

~~~
class OSCheckTraitTest extends PHPUnit_Framework_TestCase
{
    private $osCheck;
    
    public function setUp()
    {
        $this->osCheck = $this->getMockForTrait(OSCheckTrait::class);
        $this->osCheck->expects($this->any())
                ->method('getSomething')  // Um método abstrato qualquer da trait
                ->willReturn([10, 20, 30]);
    }

    public function testReturnsUnixRunningOnLinux()
    {
        $this->assertEquals('unix', $this->osCheck->serverOS());
    }

    public function testGetSomethingIsOnlyIntegers()
    {
        $this->assertContainsOnly('int', $this->osCheck->getSomething());
    }

    public function testGetSomethingHasThreeElements()
    {
        $this->assertCount(3, $this->osCheck->getSomething());
    }

}
~~~

Muito fácil. Mais uma vez, __PHPUNIT TO THE RESCUE!!!__

######(Nota mental: contribuir para o PHPUnit de alguma forma)