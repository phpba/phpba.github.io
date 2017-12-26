<?php

namespace webignition\Tests\InternetMediaType\Parameter\SetAttribute;

use webignition\Tests\InternetMediaType\Parameter\ParameterTest;

class SetAttributeTest extends ParameterTest {    
    
    public function testGetValueSet() {
        $attribute = 'foo';
        $this->parameter->setAttribute($attribute);
        $this->assertEquals($attribute, $this->parameter->getAttribute());
    }
    
    public function testValueIsLowercasedWhenSet() {
        $testData = array(
            'attribute' => 'attribute',
            'ATTRIBUTE' => 'attribute',
            'AttriBuTE' => 'attribute',
            null => ''
        );
        
        foreach ($testData as $input => $expectedOutput) {
            $this->parameter->setAttribute($input);
            $this->assertEquals($expectedOutput, $this->parameter->getAttribute());
        }        
    }
    
    
    public function testValueIsSetAsString() {
        $testData = array(
            'value1' => 'value1',
            'Value2' => 'Value2',
            'VALUE3' => 'VALUE3',
            0 => '0',
            123 => '123',
            null => ''
        );
        
        foreach ($testData as $input => $expectedOutput) {
            $this->parameter->setValue($input);
            $this->assertEquals($expectedOutput, $this->parameter->getValue());
        }         
    }
//    
//    
//    public function testToString() {
//        $testData = array(
//            array(
//                'attribute' => 'attribute1',
//                'value' => 'value1',
//                'expectedOutput' => 'attribute1=value1'
//            ),
//            array(
//                'attribute' => 'Attribute2',
//                'value' => 'value2',
//                'expectedOutput' => 'attribute2=value2'
//            ),
//            array(
//                'attribute' => 'ATTribUTE3',
//                'value' => 'VALUE3',
//                'expectedOutput' => 'attribute3=VALUE3'
//            ),
//            array(
//                'attribute' => '',
//                'value' => '{anything}',
//                'expectedOutput' => ''
//            ),
//            array(
//                'attribute' => 'attributeValue',
//                'value' => '',
//                'expectedOutput' => 'attributevalue'
//            ),            
//            array(
//                'attribute' => 'attributeValue',
//                'value' => null,
//                'expectedOutput' => 'attributevalue'
//            ),             
//        );
//        
//        $parameter = new \webignition\InternetMediaType\Parameter\Parameter();
//        $this->assertEquals('', (string)$parameter);
//        
//        foreach ($testData as $testDataSet) {
//            $parameter->setAttribute($testDataSet['attribute']);
//            $parameter->setValue($testDataSet['value']);
//            $this->assertEquals($testDataSet['expectedOutput'], (string)$parameter);
//        } 
//    }
//    
//    public function testChaining() {
//        $parameter1 = new \webignition\InternetMediaType\Parameter\Parameter();
//        $this->assertEquals('', (string)$parameter1);
//
//        $parameter2 = new \webignition\InternetMediaType\Parameter\Parameter();
//        $this->assertEquals('attributename', (string)$parameter2->setAttribute('attributename'));
//        
//        $parameter3 = new \webignition\InternetMediaType\Parameter\Parameter();
//        $this->assertEquals('attribute3=value3', $parameter3->setAttribute('attribute3')->setValue('value3'));
//    }    
}