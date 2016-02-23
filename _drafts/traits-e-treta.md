---
layout: post
title:  "Traits! Vai dar treta!!!"
author: 
    name: "Marcio Albuquerque"
    mail: "marcio.lima.albuquerque@gmail.com"
    github: "mlalbuquerque"
    blog: "http://culturabeta.com.br"
    twitter: "@mlalbuquerque"
    facebook: "mlalbuquerque"
categories: experiência php7
---

Não sei o quanto andam usando de novas funcionalidades do PHP do 5.5 pra cá.
Tenho tentado usar de tudo, pra aprender um pouco, ver viablidades de uso real e
me divertir um pouco também!

Vim aqui falar um pouquinho sobre Traits, essa novidade não tão nova, que introduz
um conceito interessante de usar mixins, como em linguagens como Ruby. A ideia,
basicamente, é poder introduzir __*pedaços de código*__ em classes, garantindo um reuso
desses __*pedaços*__ em várias classes. Normalmente, esse conceito é usado em linguagens
que não têm herança múltipla, como o PHP, Ruby, entre outras.

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