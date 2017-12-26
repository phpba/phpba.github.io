<?php

class ParseThroughParserTest extends PHPUnit_Framework_TestCase {

    public function testPassThroughParser() {
        $parser = new \webignition\StringParser\Concrete\PassThroughParser();
        $this->assertEquals("comes out the same as it goes in", $parser->parse("comes out the same as it goes in"));
        $this->assertEquals("comes out the same as it goes in again", $parser->parse("comes out the same as it goes in again"));
    }

}