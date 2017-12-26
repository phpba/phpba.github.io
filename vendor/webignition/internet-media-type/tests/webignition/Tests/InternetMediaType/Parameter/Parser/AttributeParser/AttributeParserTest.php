<?php

namespace webignition\Tests\InternetMediaType\Parameter\Parser\AttributeParser;

use webignition\Tests\InternetMediaType\BaseTest;

class AttributeParserTest extends BaseTest {
    
    
    /**
     *
     * @var \webignition\InternetMediaType\Parameter\Parser\AttributeParser
     */
    private $parser;
    
    
    public function setUp() {
        parent::setUp();
        $this->parser = new \webignition\InternetMediaType\Parameter\Parser\AttributeParser();
    }

    public function testParseValidAttributeName() {
        $this->assertEquals('charset', $this->parser->parse("charset=ISO-8859-4"));
    }
    
    public function testParseInvalidInternalCharactersAttributeName() {        
        try {
            $this->parser->parse("ch arset=ISO-8859-4");
        } catch (\webignition\InternetMediaType\Parameter\Parser\AttributeParserException $exception) {
            $this->assertEquals(1, $exception->getCode());
            return;
        }
        
        $this->fail('Invalid internal character exception not thrown');                        
    }
    
    public function testParseMissingValue() {
        $this->assertEquals('charset', $this->parser->parse("charset"));
        $this->assertEquals('charset', $this->parser->parse("charset="));
    }    
}