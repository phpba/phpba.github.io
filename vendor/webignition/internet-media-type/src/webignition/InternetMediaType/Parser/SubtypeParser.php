<?php

namespace webignition\InternetMediaType\Parser;

use webignition\StringParser\StringParser;

/**
 * Parses out the subtype from an internet media type string
 *  
 */
class SubtypeParser extends StringParser {
    
    const TYPE_SUBTYPE_SEPARATOR = '/';
    const TYPE_PARAMETER_SEPARATOR = ';';
    
    const STATE_IN_TYPE = 1;
    const STATE_IN_SUBTYPE = 2;
    const STATE_LEFT_SUBTYPE = 3;    
    const STATE_INVALID_INTERNAL_CHARACTER = 4;
    
    /**
     * Collection of characters not valid in a subtype
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
                $this->setCurrentState(self::STATE_IN_TYPE);
                break;

            case self::STATE_IN_TYPE:
                if ($this->isCurrentCharacterTypeSubtypeSeparator()) {
                    $this->setCurrentState(self::STATE_IN_SUBTYPE);
                }
                
                $this->incrementCurrentCharacterPointer();
                
                break;            
            
            case self::STATE_IN_SUBTYPE:
                if ($this->isCurrentCharacterInvalid()) {                   
                    $this->setCurrentState(self::STATE_INVALID_INTERNAL_CHARACTER);
                } elseif ($this->isCurrentCharacterTypeParameterSeparator()) {
                    $this->setCurrentState(self::STATE_LEFT_SUBTYPE);
                } else {
                    $this->appendOutputString();
                    $this->incrementCurrentCharacterPointer();
                }
                
                break;
                
            case self::STATE_LEFT_SUBTYPE:
                $this->stop();
                break;
            
            case self::STATE_INVALID_INTERNAL_CHARACTER:
                if ($this->shouldAttemptToFixInvalidInternalCharacter()) {
                    $this->hasAttemptedToFixAttributeInvalidInternalCharacter = true;
                    
                    $fixer = new TypeFixer();
                    $fixer->setInputString($this->getInputString());
                    $fixer->setPosition($this->getCurrentCharacterPointer());
                    $fixedType = $fixer->fix();
                    
                    return $this->parse($fixedType);
                }
                
                throw new SubtypeParserException(
                    'Invalid internal character after at position '.$this->getCurrentCharacterPointer(),
                    SubtypeParserException::INTERNAL_INVALID_CHARACTER_CODE,
                    $this->getCurrentCharacterPointer()
                );
        }
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
    private function isCurrentCharacterTypeSubtypeSeparator() {
        return $this->getCurrentCharacter() == self::TYPE_SUBTYPE_SEPARATOR;
    }
    
    
    /**
     *
     * @return boolean
     */
    private function isCurrentCharacterTypeParameterSeparator() {
        return $this->getCurrentCharacter() == self::TYPE_PARAMETER_SEPARATOR;
    }    

}