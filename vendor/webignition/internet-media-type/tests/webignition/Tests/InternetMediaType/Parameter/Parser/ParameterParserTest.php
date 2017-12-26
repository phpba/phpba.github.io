<?php

namespace webignition\Tests\InternetMediaType;

class ParameterParserTest extends BaseTest {

    public function testParseUnquotedParameter() {
        $parser = new \webignition\InternetMediaType\Parameter\Parser\Parser();       
        $parameter = $parser->parse("charset=ISO-8859-4");
        
        $this->assertEquals('charset', $parameter->getAttribute());
        $this->assertEquals('ISO-8859-4', $parameter->getValue());
    }
    
    
    public function testParseQuotedParameter() {
        $parser = new \webignition\InternetMediaType\Parameter\Parser\Parser();       
        $parameter = $parser->parse('charset="utf-8"');
        
        $this->assertEquals('charset', $parameter->getAttribute());
        $this->assertInstanceOf('\webignition\QuotedString\QuotedString', $parameter->getValue());
        $this->assertEquals('utf-8', $parameter->getValue()->getValue());
    }   
    
    public function testParseNullValueParameter() {
        $parser = new \webignition\InternetMediaType\Parameter\Parser\Parser();       
        $parameter = $parser->parse('foo');
        
        $this->assertEquals('foo', $parameter->getAttribute());
        $this->assertNull($parameter->getValue());
        $this->assertEquals('foo', (string)$parameter);
    }     
}