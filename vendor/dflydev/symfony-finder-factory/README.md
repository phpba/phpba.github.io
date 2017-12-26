Symfony Finder Factory
======================

A factory for Symfony Finder ([symfony/finder][1]) Finder instances.

The idea being able to inject a factory to create Finder instances into
services rather than calling `new Finder` in each service.


Requirements
------------

 * PHP 5.3+
 * Symfony Finder ~2.0

 
Installation
------------
 
Through [Composer][2] as [dflydev/symfony-finder-factory][3]


Usage
-----

```php
<?php
namespace My;

use Dflydev\Symfony\FinderFactory;
use Dflydev\Symfony\FinderFactoryInterface;

class Service
{
    public function __construct(FinderFactoryInterface $finderFactory = null)
    {
        $this->finderFactory = $finderFactory ?: new FinderFactory;
    }

    public function doThingsWithTempFiles()
    {
        $finder = $this->finderFactory->create();

        $finder->in(sys_get_temp_dir());
        
        // do stuff with temp files
    }
}
```


Use Case
--------

Mocking Finder has proven to be extremely difficult if `new Finder` is
called inside of a class. By injecting a mocked Finder Factory we can
have the opportunity to get mocked Finder instances inside our classes
for the purpose of testing.

This is best shown by example:

```php
<?php
namespace My;

use Dflydev\Symfony\FinderFactory;
use Dflydev\Symfony\FinderFactoryInterface;
use Symfony\Component\Finder\Finder;

class Service
{
    public function __construct(FinderFactoryInterface $finderFactory = null)
    {
        $this->finderFactory = $finderFactory ?: new FinderFactory;
    }

    public function findTmpFilesNew()
    {
        // Potential for mocked injected Finder Factory to return
        // a mocked Finder instance.
        $finder = $this->finderFactory->create();

        return $finder->in(sys_get_temp_dir());
    }

    public function findTmpFilesOld()
    {
        // Difficult to Mock
        $finder = new Finder;

        return $finder->in(sys_get_temp_dir());
    }
}
```


License
-------

MIT, see LICENSE.


Community
---------

If you have questions or want to help out, join us in the
<a href="irc://irc.freenode.net/#dflydev">#dflydev</a> channel
on irc.freenode.net.


Not Invented Here
-----------------

This project is based on work previously submitted to Symfony core
([symfony/symfony#5650][4]) but rejected.


[1]: https://packagist.org/packages/symfony/finder
[2]: http://getcomposer.org
[3]: https://packagist.org/packages/dflydev/symfony-finder-factory
[4]: https://github.com/symfony/symfony/pull/5650