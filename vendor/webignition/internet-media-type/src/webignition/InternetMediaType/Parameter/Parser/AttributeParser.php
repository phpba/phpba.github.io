<?php

namespace webignition\InternetMediaType\Parameter\Parser;

use webignition\StringParser\StringParser;

/**
 * Parses out the attribute name from an internet media type parameter string
 *  
 */
class AttributeParser extends StringParser {
    
    const ATTRIBUTE_VALUE_SEPARATOR = '=';
    const STATE_IN_ATTRIBUTE_NAME = 1;
    const STATE_INVALID_INTERNAL_CHARACTER = 2;
    const STATE_LEFT_ATTRIBUTE_NAME = 3;
    
    /**
     * Collection of characters not valid in an attribute name
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
     * @var boolean
     */
    private $hasAttemptedToFixAttributeInvalidInternalCharacter = false;    
    
    
    
    /**
     *
     * @var \webignition\InternetMediaType\Parser\Configuration  
     */
    private $configuration;
    
    
    /**
     * 
     * @param \webignition\InternetMediaType\Parser\Configuration $configuration
     * @return \webignition\InternetMediaType\Parser\Parser
     */
    public function setConfiguration(\webignition\InternetMediaType\Parser\Configuration $configuration) {
        $this->configuration = $configuration;
        return $this;
    }
    
    
    /**
     * 
     * @return \webignition\InternetMediaType\Parser\Configuration
     */
    public function getConfiguration() {
        if (is_null($this->configuration)) {
            $this->configuration = new \webignition\InternetMediaType\Parser\Configuration();
        }
        
        return $this->configuration;
    }

    
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
                $this->setCurrentState(self::STATE_IN_ATTRIBUTE_NAME);
                break;
            
            case self::STATE_IN_ATTRIBUTE_NAME:
                if ($this->isCurrentCharacterInvalid()) {                    
                    if ($this->shouldIgnoreInvalidCharacter()) {
                        $this->incrementCurrentCharacterPointer();
                        $this->setCurrentState(self::STATE_LEFT_ATTRIBUTE_NAME);
                        $this->clearOutputString();                        
                    } else {
                        $this->setCurrentState(self::STATE_INVALID_INTERNAL_CHARACTER);
                    }
                } elseif ($this->isCurrentCharacterAttributeValueSeparator()) {
                    $this->setCurrentState(self::STATE_LEFT_ATTRIBUTE_NAME);
                } else {
                    $this->appendOutputString();
                    $this->incrementCurrentCharacterPointer();
                }
                
                break;
                
            case self::STATE_LEFT_ATTRIBUTE_NAME:
                $this->stop();
                break;
            
            case self::STATE_INVALID_INTERNAL_CHARACTER:                                
                if ($this->shouldAttemptToFixInvalidInternalCharacter()) {
                    $this->hasAttemptedToFixAttributeInvalidInternalCharacter = true;
                    
                    $attributeFixer = new AttributeFixer();
                    $attributeFixer->setInputString($this->getInputString());
                    $attributeFixer->setPosition($this->getCurrentCharacterPointer());
                    $fixedInputString = $attributeFixer->fix();
                    
                    return $this->parse($fixedInputString);                  
                }
                
                throw new AttributeParserException(
                    'Invalid internal character after at position '.$this->getCurrentCharacterPointer(),
                    1,
                    $this->getCurrentCharacterPointer()
                );
        }
    }
    
    /**
     * 
     * @return boolean
     */
    private function shouldIgnoreInvalidCharacter() {
        if (!$this->getConfiguration()->ignoreInvalidAttributes()) {
            return false;
        }
        
        if (!$this->getConfiguration()->attemptToRecoverFromInvalidInternalCharacter()) {
            return true;
        }
        
        if ($this->hasAttemptedToFixAttributeInvalidInternalCharacter) {
            return true;
        }
        
        return false;
    }
    
    
    /**
     * 
     * @return boolean
     */
    private function shouldAttemptToFixInvalidInternalCharacter() {
        return $this->getConfiguration()->attemptToRecoverFromInvalidInternalCharacter() && !$this->hasAttemptedToFixAttributeInvalidInternalCharacter;
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
    private function isCurrentCharacterAttributeValueSeparator() {
        return $this->getCurrentCharacter() == self::ATTRIBUTE_VALUE_SEPARATOR;
    }

}