<?php

namespace webignition\InternetMediaType\Parameter;

use webignition\QuotedString\QuotedString;

/**
 * A parameter value present in an Internet media type
 * 
 * If media type == 'text/html; charset=UTF8', parameter == 'charset=UTF8'
 * 
 * Defined as:
 * 
 * parameter               = attribute "=" value
 * attribute               = token
 * value                   = token | quoted-string
 * 
 * The type, subtype, and parameter attribute names are case-insensitive
 * 
 * http://www.w3.org/Protocols/rfc2616/rfc2616-sec3.html#sec3.6
 *  
 */
class Parameter {
    
    const ATTRIBUTE_VALUE_SEPARATOR = '=';
    const EMPTY_ATTRIBUTE = '';
    const EMPTY_VALUE = '';
    
    /**
     * The parameter attribute.
     * 
     * For a parameter of 'charset=UTF8', this woud be 'charset'
     * 
     * @var string
     */
    private $attribute;
    
    
    /**
     * The parameter value
     * 
     * For a parameter of 'charset=UTF8', this would be 'UTF8'
     * 
     * @var string|QuotedString
     */
    private $value;
    
    
    /**
     *
     * @param string $attribute
     * @return \webignition\InternetMediaType\Parameter 
     */
    public function setAttribute($attribute) {        
        $this->attribute = trim(strtolower($attribute));
        return $this;
    }
    
    
    /**
     *
     * @return string
     */
    public function getAttribute() {
        return ($this->hasAttribute()) ? $this->attribute : '';
    }
    
    
    /**
     *
     * @param string|QuotedString $value
     * @return \webignition\InternetMediaType\Parameter 
     */
    public function setValue($value) {
        if (is_string($value)) {
            $this->value = trim($value);
        } else {
            $this->value = $value;
        }        
        
        return $this;        
    }
    
    
    /**
     *
     * @return string|QuotedString
     */
    public function getValue() {        
        return $this->value;
    }
    
    
    /**
     *
     * @return boolean
     */
    private function hasAttribute() {
        if (is_null($this->attribute)) {
            return false;
        }
         
        if ($this->attribute == self::EMPTY_ATTRIBUTE) {
            return false;
        }
        
        return true;
    }
    
    
    /**
     *
     * @return boolean
     */    
    private function hasValue() {
        if (is_null($this->value)) {
            return false;
        }
         
        if ($this->value == self::EMPTY_VALUE) {
            return false;
        }
        
        return true;
    }
    
    
    /**
     *
     * @return string
     */
    public function __toString() {
        if (!$this->hasAttribute() && !$this->hasValue()) {
            return '';
        }
        
        if (!$this->hasAttribute()) {
            return '';
        }
        
        if (!$this->hasValue()) {
            return $this->getAttribute();
        }
        
        return $this->getAttribute() . self::ATTRIBUTE_VALUE_SEPARATOR . $this->getValue();
    }    
}