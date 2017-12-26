<?php

namespace webignition\Tests\InternetMediaType\Parameter;

class ToStringTest extends ParameterTest {
    
    private $data = array(
        array(
            'attribute' => 'attribute1',
            'value' => 'value1',
            'expectedOutput' => 'attribute1=value1'
        ),
        array(
            'attribute' => 'Attribute2',
            'value' => 'value2',
            'expectedOutput' => 'attribute2=value2'
        ),
        array(
            'attribute' => 'ATTribUTE3',
            'value' => 'VALUE3',
            'expectedOutput' => 'attribute3=VALUE3'
        ),
        array(
            'attribute' => '',
            'value' => '{anything}',
            'expectedOutput' => ''
        ),
        array(
            'attribute' => 'attributeValue',
            'value' => '',
            'expectedOutput' => 'attributevalue'
        ),            
        array(
            'attribute' => 'attributeValue',
            'value' => null,
            'expectedOutput' => 'attributevalue'
        ),             
    );
    
    public function testToString() {        
        foreach ($this->data as $testDataSet) {
            $this->parameter->setAttribute($testDataSet['attribute']);
            $this->parameter->setValue($testDataSet['value']);
            $this->assertEquals($testDataSet['expectedOutput'], (string)$this->parameter);
        } 
    }
  
}