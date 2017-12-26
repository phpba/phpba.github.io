<?php

class QuotedStringTest extends PHPUnit_Framework_TestCase {

    public function testWithoutEnclosedQuotes() {
        $quotedString = new \webignition\QuotedString\QuotedString();
        $quotedString->setValue('value');
        
        $this->assertEquals('"value"', (string)$quotedString);
    }
    
    
    public function testWithEnclosedQuotes() {
        $quotedString = new \webignition\QuotedString\QuotedString();
        $quotedString->setValue('v"al"ue');
        
        $this->assertEquals('"v\"al\"ue"', (string)$quotedString);        
    }
}