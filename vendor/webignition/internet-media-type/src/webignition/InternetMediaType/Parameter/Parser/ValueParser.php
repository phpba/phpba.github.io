<?php

namespace webignition\InternetMediaType\Parameter\Parser;

use webignition\StringParser\StringParser;
use webignition\QuotedString\Parser as QuotedStringParser;
use webignition\QuotedString\QuotedString;

/**
 * Parses out the value from an internet media type parameter string
 *  
 */
class ValueParser extends StringParser {
    
    const ATTRIBUTE_VALUE_SEPARATOR = '=';
    const QUOTED_STRING_DELIMITER = '"';
    
    const STATE_IN_NON_QUOTED_VALUE = 1;
    const STATE_IN_QUOTED_VALUE = 2;
    
    
    /**
     * Attribute part of the attribute=value parameter string
     * 
     * @var string
     */
    private $attribute = '';
    
    
    /**
     *
     * @param string $attribute
     * @return \webignition\InternetMediaType\Parameter\Parser\ValueParser 
     */
    public function setAttribute($attribute) {
        $this->attribute = $attribute;
        return $this;
    }
    
    
    /**
     *
     * @param string $inputString
     * @return string|QuotedString
     */
    public function parse($inputString) {                
        $output = parent::parse($this->getNonAttributePart($inputString));       
        
        if ($this->getCurrentState() == self::STATE_IN_NON_QUOTED_VALUE) {
            return $output;
        }
        
        if ($output == '') {
            return null;
        }
        
        $quotedStringParser = new QuotedStringParser();
        return $quotedStringParser->parse($output);
    }
    
    /**
     *
     * @return string
     */
    private function getNonAttributePart($inputString) {
        return substr($inputString, strlen($this->attribute) + strlen(self::ATTRIBUTE_VALUE_SEPARATOR));
    }    
    
    protected function parseCurrentCharacter() {
        switch ($this->getCurrentState()) {
            case self::STATE_UNKNOWN:
                $this->deriveState();
                break;
            
            
            default:
                $this->appendOutputString();
                $this->incrementCurrentCharacterPointer();
                break;
        }
    }
    
    
    private function deriveState() {        
        if ($this->isCurrentCharacterQuotedStringDelimiter()) {
            $this->setCurrentState(self::STATE_IN_QUOTED_VALUE);
        } else {
            $this->setCurrentState(self::STATE_IN_NON_QUOTED_VALUE);
        }
    }
    
    
    /**
     *
     * @return boolean
     */
    private function isCurrentCharacterQuotedStringDelimiter() {
        return $this->getCurrentCharacter() == self::QUOTED_STRING_DELIMITER;
    }

}