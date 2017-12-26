<?php

namespace webignition\Tests\InternetMediaType\Parser;

class DefaultTest extends ParserTest {    

    public function testParseNoParameters() {  
        $internetMediaType = $this->parser->parse('text/html');
        
        $this->assertEquals('text', $internetMediaType->getType());
        $this->assertEquals('html', $internetMediaType->getSubtype());
    }
    
    public function testParseWithSingleParameter() {  
        $internetMediaType = $this->parser->parse('text/html; charset=ISO-8859-4');
        $parameters = $internetMediaType->getParameters();
        
        $this->assertEquals('text', $internetMediaType->getType());
        $this->assertEquals('html', $internetMediaType->getSubtype());
        $this->assertEquals(1, count($parameters));
        
        /* @var $parameter \webignition\InternetMediaType\Parameter\Parameter */
        $parameter = $parameters['charset'];
        $this->assertEquals('charset', $parameter->getAttribute());
        $this->assertEquals('ISO-8859-4', $parameter->getValue());
    }    
    
    public function testParseWithMultipleParameters() {  
        $internetMediaType = $this->parser->parse('text/html; charset=ISO-8859-4; attribute1=parameter1; attribute2="parameter number two"');
        $parameters = $internetMediaType->getParameters();
        
        $this->assertEquals('text', $internetMediaType->getType());
        $this->assertEquals('html', $internetMediaType->getSubtype());
        $this->assertEquals(3, count($parameters));
        
        $charsetParameter = $parameters['charset'];
        $this->assertEquals('charset', $charsetParameter->getAttribute());
        $this->assertEquals('ISO-8859-4', $charsetParameter->getValue());        
        
        $attribute1Parameter = $parameters['attribute1'];
        $this->assertEquals('attribute1', $attribute1Parameter->getAttribute());
        $this->assertEquals('parameter1', $attribute1Parameter->getValue());                
        
        $attribute2Parameter = $parameters['attribute2'];
        $this->assertEquals('attribute2', $attribute2Parameter->getAttribute());
        $this->assertInstanceOf('\webignition\QuotedString\QuotedString', $attribute2Parameter->getValue());
        $this->assertEquals('parameter number two', $attribute2Parameter->getValue()->getValue());
    } 
    
    
    public function testIgnoreInvalidAttributes() {  
        $this->parser->setIgnoreInvalidAttributes(true);
        $internetMediaType = $this->parser->parse('application/x-javascript; charset: UTF-8');
        
        $this->assertEquals('application/x-javascript', (string)$internetMediaType);        
    }   
    
}