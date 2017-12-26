<?php

namespace webignition\Tests\InternetMediaType\Parser;

use webignition\Tests\InternetMediaType\BaseTest;

abstract class ParserTest extends BaseTest {
    
    
    /**
     *
     * @var \webignition\InternetMediaType\Parser\Parser
     */
    protected $parser;
    
    
    public function setUp() {
        parent::setUp();
        $this->parser = new \webignition\InternetMediaType\Parser\Parser();
    }
    
}