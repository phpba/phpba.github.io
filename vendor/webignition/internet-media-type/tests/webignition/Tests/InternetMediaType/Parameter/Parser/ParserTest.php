<?php

namespace webignition\Tests\InternetMediaType\Parameter\Parser;

use webignition\Tests\InternetMediaType\BaseTest;

class ParserTest extends BaseTest {
    
    /**
     *
     * @var \webignition\InternetMediaType\Parameter\Parser\Parser
     */
    private $parser;
    
    
    public function setUp() {
        parent::setUp();        
        $this->parser = new \webignition\InternetMediaType\Parameter\Parser\Parser();
    }
    

    public function testParseUnquotedParameter() {    
        $parameter = $this->parser->parse("charset=ISO-8859-4");
        
        $this->assertEquals('charset', $parameter->getAttribute());
        $this->assertEquals('ISO-8859-4', $parameter->getValue());
    }
    
    
    public function testParseQuotedParameter() {      
        $parameter = $this->parser->parse('charset="utf-8"');
        
        $this->assertEquals('charset', $parameter->getAttribute());
        $this->assertInstanceOf('\webignition\QuotedString\QuotedString', $parameter->getValue());
        $this->assertEquals('utf-8', $parameter->getValue()->getValue());
    }   
    
    public function testParseNullValueParameter() {      
        $parameter = $this->parser->parse('foo');
        
        $this->assertEquals('foo', $parameter->getAttribute());
        $this->assertNull($parameter->getValue());
        $this->assertEquals('foo', (string)$parameter);
    }    
    
}