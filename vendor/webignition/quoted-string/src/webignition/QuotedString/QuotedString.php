<?php

namespace webignition\QuotedString;

/**
 * A quoted string as defined in RFC2822 section 3.2.5:
 * http://tools.ietf.org/html/rfc2822#section-3.2.5
 * 
 * This does not include the ability for a quoted string
 * to have leading and trailing commands and folding
 * white space.
 * 
 * Quoted string format:
 * 
 * "{anything apart from quote or backslash, unless \" is used to escape quote}"
 */
class QuotedString {
    
    /**
     * The unquoted value
     * 
     * @var string
     */
    private $value;
    
    
    /**
     *
     * @param string $value 
     */
    public function __construct($value = null) {
        $this->value = $value;
    }
    
    
    /**
     * Value for the quoted string
     * 
     * Double quotes in the string must not be escaped - this is the unquoted
     * value
     *
     * @param string $value
     * @return \webignition\QuotedString\QuotedString 
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
    
    
    /**
     *
     * @return string
     */
    public function getValue() {
        return (string)$this->value;
    }    
    
    
    /**
     *
     * @return string
     */
    public function __toString() {
        return '"'.  str_replace('"', '\"', $this->value).'"';
    }
    
    
}