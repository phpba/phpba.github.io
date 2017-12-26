<?php

namespace webignition\Tests\InternetMediaType\Parameter\Parser\ValueParser;

use webignition\Tests\InternetMediaType\BaseTest;

class ValueParserTest extends BaseTest {
    
    
    /**
     *
     * @var \webignition\InternetMediaType\Parameter\Parser\ValueParser 
     */
    private $parser;
    
    public function setUp() {
        parent::setUp();
        $this->parser = new \webignition\InternetMediaType\Parameter\Parser\ValueParser();
    }

    public function testParseNonQuotedValue() {
        $this->parser->setAttribute('charset');
        $this->assertEquals('ISO-8859-4', $this->parser->parse("charset=ISO-8859-4"));
    }
    
    
    public function testParseQuotedValue() {
        $this->parser->setAttribute('charset');
        $output = $this->parser->parse('charset="quoted value here"');
        
        $this->assertInstanceOf('\webignition\QuotedString\QuotedString', $output);
        $this->assertEquals('quoted value here', $output->getValue());
    } 
}