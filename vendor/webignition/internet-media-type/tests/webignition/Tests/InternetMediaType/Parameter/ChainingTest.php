<?php

namespace webignition\Tests\InternetMediaType\Parameter;

class ChainingTest extends ParameterTest {   
    
    public function testChaining() {
        $attribute = 'attribute';
        $value = 'value';
        
        $this->assertEquals($attribute . '=' . $value, $this->parameter->setAttribute($attribute)->setValue($value)->__toString());
    }    
}