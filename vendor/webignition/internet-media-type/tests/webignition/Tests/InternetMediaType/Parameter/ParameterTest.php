<?php

namespace webignition\Tests\InternetMediaType\Parameter;

use webignition\Tests\InternetMediaType\BaseTest;

abstract class ParameterTest extends BaseTest {
    
    
    /**
     *
     * @var \webignition\InternetMediaType\Parameter\Parameter
     */
    protected $parameter;    
    
    public function setUp() {
        parent::setUp();
        $this->parameter = new \webignition\InternetMediaType\Parameter\Parameter();
    }
}