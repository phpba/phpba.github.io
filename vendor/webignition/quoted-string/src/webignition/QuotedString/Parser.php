<?php

namespace webignition\QuotedString;

/**
 * Parse a given input string into a QuotedString
 * 
 */
class Parser {
    
    const QUOTE_DELIMITER = '"';
    const ESCAPE_CHARACTER = '\\';
    const STATE_IN_QUOTED_STRING = 1;
    const STATE_LEFT_QUOTED_STRING = 2;
    const STATE_UNKNOWN = 3;
    const STATE_INVALID_LEADING_CHARACTERS = 4;
    const STATE_INVALID_TRAILING_CHARACTERS = 5;      
    const STATE_ENTERING_QUOTED_STRING = 6;
    const STATE_INVALID_ESCAPE_CHARACTER = 7;
    
    /**
     *
     * @var int
     */
    private $currentState = self::STATE_UNKNOWN;
    
    
    /**
     *
     * @var string
     */
    private $inputString;
    
    
    /**
     *
     * @var string
     */
    private $outputString;
    
    
    /**
     * Pointer to position of current character
     * 
     * @var int
     */
    private $currentCharacterIndex = 0;
    
    
    /**
     *
     * @var int
     */
    private $inputStringLength = 0;
    
    
    /**
     *
     * @param type $inputString 
     */
    public function parse($inputString) {
        $this->inputString = trim($inputString);
        $this->inputStringLength = strlen($inputString);
        
        while ($this->currentCharacterIndex < $this->inputStringLength) {            
            $this->parseCurrentCharacter();
        }

        return new QuotedString($this->outputString);
    }
    
    
    private function parseCurrentCharacter() {       
        switch ($this->currentState) {            
            case self::STATE_ENTERING_QUOTED_STRING:
                $this->currentCharacterIndex++;
                $this->currentState = self::STATE_IN_QUOTED_STRING;
                break;             
            
            case self::STATE_IN_QUOTED_STRING:
                if ($this->isCurrentCharacterQuoteDelimiter()) {                    
                    if ($this->isPreviousCharacterEscapeCharacter()) {
                        $this->outputString .= $this->getCurrentCharacter();
                        $this->currentCharacterIndex++;
                    } else {
                        $this->currentState = self::STATE_LEFT_QUOTED_STRING;
                        $this->currentCharacterIndex++;
                    }
                }
                
                if ($this->isCurrentCharacterEscapeCharacter()) {
                    if ($this->isNextCharacterQuoteCharacter()) {
                        $this->currentCharacterIndex++;                        
                    } else {
                        $this->currentState = self::STATE_INVALID_ESCAPE_CHARACTER;
                    }
                }
               
                if (!$this->isCurrentCharacterQuoteDelimiter() && !$this->isCurrentCharacterEscapeCharacter()) {
                    $this->outputString .= $this->getCurrentCharacter();
                    $this->currentCharacterIndex++;
                }
                
                break;
            
            case self::STATE_LEFT_QUOTED_STRING:
                if ($this->currentCharacterIndex < $this->inputStringLength - 1) {
                    $this->currentState = self::STATE_INVALID_TRAILING_CHARACTERS;
                    $this->currentCharacterIndex++;
                }
                
                break;
                
            case self::STATE_UNKNOWN:
                $this->deriveCurrentState();
                break;                

            case self::STATE_INVALID_LEADING_CHARACTERS:
                throw new Exception('Invalid leading characters before first quote character', 1);
                break;
            
            case self::STATE_INVALID_ESCAPE_CHARACTER:
                throw new Exception('Invalid escape character at position '.$this->currentCharacterIndex, 3);
                break;
            
            case self::STATE_INVALID_TRAILING_CHARACTERS:
                throw new Exception('Invalid trailing characters after last quote character at position '.$this->currentCharacterIndex.' - did you forget to escape an internal quote?', 2);
                break;                
        }
    }
    
    
    private function deriveCurrentState() {
        if ($this->isCurrentCharacterFirstCharacter()) {
            if ($this->isCurrentCharacterQuoteDelimiter()) {
                return $this->currentState = self::STATE_ENTERING_QUOTED_STRING;
            }
            
            return $this->currentState = self::STATE_INVALID_LEADING_CHARACTERS;
        }
    }
    
    
    /**
     *
     * @return boolean
     */
    private function isCurrentCharacterQuoteDelimiter() {
        return $this->getCurrentCharacter() == self::QUOTE_DELIMITER;
    }
    

    /**
     *
     * @return boolean
     */
    private function isCurrentCharacterEscapeCharacter() {
        return $this->getCurrentCharacter() == self::ESCAPE_CHARACTER;
    }    
    
    /**
     *
     * @return boolean
     */
    private function isPreviousCharacterEscapeCharacter() {
        return $this->getPreviousCharacter() == self::ESCAPE_CHARACTER;
    }
    
    
    /**
     *
     * @return boolean
     */
    private function isNextCharacterQuoteCharacter() {
        return $this->getNextCharacter() == self::QUOTE_DELIMITER;
    }
    
    
    /**
     *
     * @return boolean 
     */
    private function isCurrentCharacterFirstCharacter() {
        if ($this->currentCharacterIndex != 0) {
            return false;
        }
        
        return !is_null($this->getCurrentCharacter());
    }
    
    
    /**
     *
     * @return string
     */
    private function getCurrentCharacter() {
        return ($this->currentCharacterIndex < $this->inputStringLength) ? $this->inputString[$this->currentCharacterIndex] : null;
    }   
    
    
    /**
     *
     * @return string
     */
    private function getPreviousCharacter() {
        if ($this->currentCharacterIndex == 0) {
            return null;
        }
        
        $previousCharacterIndex = $this->currentCharacterIndex - 1;
        return ($previousCharacterIndex > $this->inputStringLength) ? null : $this->inputString[$previousCharacterIndex];
    }
    
    
    /**
     *
     * @return string
     */
    private function getNextCharacter() {        
        return ($this->currentCharacterIndex == $this->inputStringLength - 1) ? null : $this->inputString[$this->currentCharacterIndex + 1];
    }
}
 