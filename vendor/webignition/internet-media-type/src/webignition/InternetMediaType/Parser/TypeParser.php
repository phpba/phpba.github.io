<?php

namespace webignition\InternetMediaType\Parser;

use webignition\StringParser\StringParser;

/**
 * Parses out the type from an internet media type string
 *  
 */
class TypeParser extends StringParser {
    
    const TYPE_SUBTYPE_SEPARATOR = '/';
    const STATE_IN_TYPE = 1;
    const STATE_INVALID_INTERNAL_CHARACTER = 2;
    const STATE_LEFT_TYPE = 3;
    
    /**
     * Collection of characters not valid in a type
     *  
     * @var array
     */
    private $invalidCharacters = array(
        ' ',
        '"',
        '\\'
    );
    
    /**
     *
     * @param string $inputString
     * @return string
     */
    public function parse($inputString) {
        return parent::parse(trim($inputString));
    }
    
    protected function parseCurrentCharacter() {        
        switch ($this->getCurrentState()) {
            case self::STATE_UNKNOWN:
                $this->setCurrentState(self::STATE_IN_TYPE);
                break;
            
            case self::STATE_IN_TYPE:
                if ($this->isCurrentCharacterInvalid()) {                   
                    $this->setCurrentState(self::STATE_INVALID_INTERNAL_CHARACTER);
                } elseif ($this->isCurrentCharacterTypeSubtypeSeparator()) {
                    $this->setCurrentState(self::STATE_LEFT_TYPE);
                } else {
                    $this->appendOutputString();
                    $this->incrementCurrentCharacterPointer();
                }
                
                break;
                
            case self::STATE_LEFT_TYPE:
                $this->stop();
                break;
            
            case self::STATE_INVALID_INTERNAL_CHARACTER:
                throw new TypeParserException('Invalid internal character after at position '.$this->getCurrentCharacterPointer(), 1);
                break;
        }
    }
    
    
    /**
     *
     * @return boolean
     */
    private function isCurrentCharacterInvalid() {
        return in_array($this->getCurrentCharacter(), $this->invalidCharacters);
    }
    
    
    /**
     *
     * @return boolean
     */
    private function isCurrentCharacterTypeSubtypeSeparator() {
        return $this->getCurrentCharacter() == self::TYPE_SUBTYPE_SEPARATOR;
    }

}