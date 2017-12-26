<?php

namespace webignition\Tests\InternetMediaType\ParserTypeParser;

use webignition\Tests\InternetMediaType\BaseTest;

class TypeParserTest extends BaseTest {
    
    
    /**
     *
     * @var \webignition\InternetMediaType\Parser\TypeParser
     */
    private $parser;
    
    public function setUp() {
        parent::setUp();
        $this->parser = new \webignition\InternetMediaType\Parser\TypeParser();
    }

    public function testParseValidType() {
        $this->assertEquals('text', $this->parser->parse('text/html; charset=ISO-8859-4'));
    }
    
    
    public function testParseInvalidType() {        
        try {
            $this->parser->parse('t e x t/html; charset=ISO-8859-4');
        } catch (\webignition\InternetMediaType\Parser\TypeParserException $exception) {
            $this->assertEquals(1, $exception->getCode());
            return;
        }
        
        $this->fail('Invalid internal character exception not thrown');
    }
 
}