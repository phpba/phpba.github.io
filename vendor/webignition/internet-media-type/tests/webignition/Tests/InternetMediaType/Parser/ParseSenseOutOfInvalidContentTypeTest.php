<?php

namespace webignition\Tests\InternetMediaType\Parser;

class ParseSenseOutOfInvalidContentTypeTest extends ParserTest {

    public function testParseCommaSeparatedContentTypeDuplicated() {  
        $this->parser->getConfiguration()->enableAttemptToRecoverFromInvalidInternalCharacter();        
        $this->assertEquals('application/x-javascript; charset=utf-8', $this->parser->parse('application/x-javascript, application/x-javascript; charset=utf-8'));
    }
    
    public function testParseWithNoSemiColonBetweenTypeAndParameter() {
        $this->parser->getConfiguration()->enableAttemptToRecoverFromInvalidInternalCharacter();        
        $this->assertEquals('text/html; charset=UTF-8', $this->parser->parse('text/html charset=UTF-8'));
    }
    
    public function testParseAttributeColonValue() {
        $this->parser->getConfiguration()->enableIgnoreInvalidAttributes();
        $this->parser->getConfiguration()->enableAttemptToRecoverFromInvalidInternalCharacter();
        
        $this->assertEquals('text/css; charset=UTF-8', $this->parser->parse('text/css; charset: UTF-8'));
    }
    
    
    public function testPaserNoSemiColonBetweenTypeAndParameterAndAttributeColonValue() {
        $this->parser->getConfiguration()->enableIgnoreInvalidAttributes();
        $this->parser->getConfiguration()->enableAttemptToRecoverFromInvalidInternalCharacter();
        
        $this->assertEquals('text/css; charset=UTF-8', $this->parser->parse('text/css charset: UTF-8'));
    }    
}