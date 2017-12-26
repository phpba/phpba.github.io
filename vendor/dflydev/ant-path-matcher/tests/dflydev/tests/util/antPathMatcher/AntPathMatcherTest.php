<?php

/*
 * This file is a part of the Ant Path Matcher library.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\tests\util\antPathMatcher;

use dflydev\util\antPathMatcher\AntPathMatcher;

use dflydev\core\io\CompositeResourceLoader;

/**
 * Description of CompositeResourceLoaderTest
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class AntPathMatcherTest extends \PHPUnit_Framework_TestCase
{
    
    public function testLeadingPathCharacterMismatch() {
        $antPathMatcher = new AntPathMatcher();
        $this->assertFalse($antPathMatcher->match('/foo', 'foo'));
        $this->assertFalse($antPathMatcher->match('foo', '/foo'));
    }

    /**
     * @dataProvider testMatchesProvider
     */
    public function testMatches($pattern, $shouldMatch, $shouldNotMatch)
    {
        $antPathMatcher = new AntPathMatcher();
        foreach ($shouldMatch as $path) {
            $this->assertTrue($antPathMatcher->match($pattern, $path), $this->formatTestMatchesMessage($pattern, $path));
        }
        foreach ($shouldNotMatch as $path) {
            $this->assertFalse($antPathMatcher->match($pattern, $path), $this->formatTestMatchesMessage($pattern, $path));
        }
    }
    
    public function formatTestMatchesMessage($pattern, $path)
    {
        return 'Testing path "' . $path . '" against pattern "' . $pattern . '"';
    }

    public function testMatchesProvider()
    {
        return array(
            array(
                'com/t?st',
                array('com/test.jsp', 'com/tast.jsp', 'com/txst.jsp'),
                array('com/toast.jsp', 'com/README.md')
            ),
            array(
                'com/*.jsp',
                array('com/test.jsp', 'com/tast.jsp', 'com/txst.jsp', 'com/toast.jsp'),
                array('toast.jsp', 'com/README.md'),
            ),
            array(
                'com/**/test.jsp',
                array('com/test.jsp', 'com/foo/test.jsp', 'com/foo/bar/test.jsp'),
                array('test.jsp', 'com/test.txt'),
            ),
            array(
                'com/**/*.jsp',
                array('com/foo.jsp', 'com/bar/baz.jsp', 'com/foo/bar/baz.jsp'),
                array('test.jsp', 'com/test.txt'),
            ),
            array(
                'com/**/bar/*.jsp',
                array('com/bar/baz.jsp', 'com/foo/bar/baz.jsp'),
                array('test.jsp', 'com/foo/bar/test.txt'),
            ),
            array(
                'com/**/foo/',
                array('com/test/foo', 'com/test/foo/'),
                array(),
            ),
            array(
                'com/**/**/foo/*.jsp',
                array('com/test/foo/bar.jsp',),
                array(),
            ),
            array(
                'com/**/a/**/b/**/foo/*.jsp',
                array('com/AAA/a/BBB/b/FOO/foo/bar.jsp','com/A/AA/a/B/BB/b/F/OO/foo/bar.jsp',),
                array(),
            ),
            array(
                'com/foo/',
                array('com/foo/bar.jsp','com/foo/bar/baz.jsp',),
                array('com.txt', 'com/foo.txt'),
            )
        );
    }
    
    public function testMatchStart()
    {
        $antPathMatcher = new AntPathMatcher();
        $this->assertTrue($antPathMatcher->matchStart('foo/**', 'foo/bar/baz'));
        $this->assertTrue($antPathMatcher->matchStart('foo/**/baz', 'foo/bar/baz'));
        $this->assertTrue($antPathMatcher->matchStart('foo/**/baz', 'foo/bar/BAT'));
    }
    
    public function testIsPattern()
    {
        $antPathMatcher = new AntPathMatcher();
        $this->assertTrue($antPathMatcher->isPattern('foo/'));
        $this->assertTrue($antPathMatcher->isPattern('foo/**'));
        $this->assertTrue($antPathMatcher->isPattern('foo/t?st.html'));
        $this->assertTrue($antPathMatcher->isPattern('foo/t*st.html'));
        $this->assertTrue($antPathMatcher->isPattern('t?st.html'));
        $this->assertTrue($antPathMatcher->isPattern('t*st.html'));
        $this->assertFalse($antPathMatcher->isPattern('foo'));
        $this->assertFalse($antPathMatcher->isPattern('foo/bar'));
    }

}
