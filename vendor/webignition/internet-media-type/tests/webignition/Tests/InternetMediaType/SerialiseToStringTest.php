<?php

namespace webignition\Tests\InternetMediaType;

use webignition\InternetMediaType\InternetMediaType;
use webignition\InternetMediaType\Parameter\Parameter;
use webignition\InternetMediaType\Parser\Parser as InternetMediaTypeParser;

class SerialiseToStringTest extends BaseTest {

    public function testSerialiseNoParameters() {
        $mediaType = new InternetMediaType();
        $mediaType->setType('text');
        $mediaType->setSubtype('html');
        
        $this->assertEquals('text/html', (string)$mediaType);
    }
    
    public function testSerialiseWithSingleParameter() {
        $mediaType = new InternetMediaType();
        $mediaType->setType('text');
        $mediaType->setSubtype('html');
        
        $parameter = new Parameter();
        $parameter->setAttribute('attribute1');
        $parameter->setValue('value1');        
        
        $mediaType->addParameter($parameter);
        
        $this->assertEquals('text/html; attribute1=value1', (string)$mediaType);
    }    
  
    public function testSerialiseWithMultipleParameters() {
        $mediaType = new InternetMediaType();
        $mediaType->setType('text');
        $mediaType->setSubtype('html');
        
        $parameter1 = new Parameter();
        $parameter1->setAttribute('attribute1');
        $parameter1->setValue('value1');                
        $mediaType->addParameter($parameter1);
        
        $parameter2 = new Parameter();
        $parameter2->setAttribute('attribute2');
        $parameter2->setValue('value2');                
        $mediaType->addParameter($parameter2);
        
        $parameter3 = new Parameter();
        $parameter3->setAttribute('attribute3');
        $parameter3->setValue('value3');                
        $mediaType->addParameter($parameter3);        
        
        $this->assertEquals('text/html; attribute1=value1; attribute2=value2; attribute3=value3', (string)$mediaType);
    }    
    
    public function testGetTypeSubtypeString() {
        $mediaType = new InternetMediaType();
        $mediaType->setType('text');
        $mediaType->setSubtype('html');
        
        $this->assertEquals('text/html', $mediaType->getTypeSubtypeString());
        
        $mediaTypeParser = new InternetMediaTypeParser();
        $mediaType = $mediaTypeParser->parse('application/json; charset=UTF-8');
        
        $this->assertEquals('application/json', $mediaType->getTypeSubtypeString());
    }
    
    public function testWithSlightlyInvalidMediaTypeString() {
        $mediaType = new InternetMediaType();
        $mediaType->setType('text');
        $mediaType->setSubtype('javascript');
        
        $parameter1 = new Parameter();
        $parameter1->setAttribute('UTF-8');
        
        $mediaType->addParameter($parameter1);
        
        $parameter2 = new Parameter();
        $parameter2->setAttribute('charset');
        $parameter2->setValue('UTF-8');
        
        $mediaType->addParameter($parameter1);
        $mediaType->addParameter($parameter2);        
        
        $this->assertEquals('text/javascript', $mediaType->getTypeSubtypeString());        
        $this->assertEquals('text/javascript; utf-8; charset=UTF-8', (string)$mediaType);
    }     
}