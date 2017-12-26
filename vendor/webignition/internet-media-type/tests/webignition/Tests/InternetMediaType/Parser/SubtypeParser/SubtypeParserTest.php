<?php

namespace webignition\Tests\InternetMediaType\Parser\SubtypeParser;

use webignition\Tests\InternetMediaType\BaseTest;

class SubtypeParserTest extends BaseTest {
    
    
    /**
     *
     * @var \webignition\InternetMediaType\Parser\SubtypeParser
     */
    private $parser;
    
    
    public function setUp() {
        parent::setUp();
        $this->parser = new \webignition\InternetMediaType\Parser\SubtypeParser();
    }

    public function testParseSubtypeWithNoParameters() {
        $this->assertEquals('html', $this->parser->parse('text/html'));
    }

    public function testParseSubtypeWithParameters() {
        $this->assertEquals('html', $this->parser->parse('text/html; charset=ISO-8859-4'));
    }    
    
    
    public function testParseInvalidtype() {        
        try {
            $this->parser->parse('text/h t m l; charset=ISO-8859-4');
        } catch (\webignition\InternetMediaType\Parser\SubtypeParserException $exception) {
            $this->assertEquals(1, $exception->getCode());
            return;
        }
        
        $this->fail('Invalid internal character exception not thrown');
    }
 
}