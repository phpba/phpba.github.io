Ant Path Matcher Utility
========================

An [Ant](http://ant.apache.org/) path pattern matcher for PHP. Implementation kindly borrowed from [Spring](http://www.springsource.org).

Requirements
------------

 * PHP 5.3+

Usage
-----

```php
<?php
use dflydev\util\antPathMatcher\AntPathMatcher;
$antPathMatcher = new AntPathMatcher();
if ($antPathMatcher->match('foo/**/baz/*.txt', 'foo/bar/baz/hello-world.txt')) {
  echo "This is true!\n";
}
```

License
-------

This library is licensed under the New BSD License - see the LICENSE file for details.

Community
---------

If you have questions or want to help out, join us in the
[#dflydev](irc://irc.freenode.net/#dflydev) channel on irc.freenode.net.

Not Invented Here
-----------------

There are other PHP ports of Ant-like pattern matching but most were
either found to be incomplete, tied to actually walking a disk, or so
heavily embedded into another larger project it was not feasible to
use.

This implementation is purely string based and is based on the
AntPathMatcher found in Spring.
