<?php

namespace webignition\StringParser;

/**
 * Abstract parser for parsing a string one character at a time, taking an input
 * string and returning an output string.
 * 
 * The parser is state-based and provides a default state of 0 (STATE_UNKNOWN).
 * 
 * Loops indefinitely until the current character pointer reaches the end of the 
 * string, unless an exception breaks the flow.
 * 
 * Concrete classes must implement parseCurrentCharacter() and in this method
 * must decide, based on the current state, the current character and the
 * characters surrounding it, whether to add the current character to the output,
 * whether to increment the current character pointer and whether to change the
 * current state.
 * 
 * Within parseCurrentCharacter(), make good use of:
 * 
 * - getCurrentState(): you might want to create a switch statement to behave
 *                     dependent on the state
 * 
 * - getCurrentCharacter()
 * - getPreviousCharacter()
 * - getNextCharacter()
 * - getCurrentCharacterPointer()
 * - incrementCurrentCharacterPointer()
 * - setCurrentState()
 * - isCurrentCharacterFirstCharacter()
 * - stop(): if you're done all you need to, stop the parser
 * 
 * Concrete class implementation thoughts:
 * 
 * - consider what states your parser can be in, what are all the possible
 *   situations you could encounter when parsing a particular type of string?
 * 
 * - list all states
 * 
 * - implement a switch statement in parseCurrentCharacter() that takes into
 *   account all states
 * 
 * - consider in each state what conditons cause the parser to change to a
 *   different state, or simpy stay in the same state
 * 
 * - consider how an examination of the current, previous and next characters
 *   determine where state changes occur
 * 
 * - consider in which states you want to append the current character to what is
 *   to be output
 * 
 * - consider what states are invalid, and in those states throw exceptions
 * 
 * - don't assume you're starting in a valid state, make use of the initial
 *   'unknown' state and figure out what state you're in
 * 
 * - override the parse() method if you want to return not a string but perhaps
 *   an object instantiated from the parsed string
 * 
 * - define your states as class constants, make it clear through the constant
 *   name what state you're in
 *  
 */
abstract class StringParser {
    
    const STATE_UNKNOWN = 0;
  
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
    private $currentCharacterPointer = 0;
    
    
    /**
     *
     * @var int
     */
    private $inputStringLength = 0;
    
    
    /**
     *
     * @param string $inputString
     * @return string
     */
    public function parse($inputString) {        
        $this->reset();
        $this->inputString = $inputString;
        $this->inputStringLength = strlen($inputString);        
        
        while ($this->getCurrentCharacterPointer() < $this->getInputStringLength()) {            
            $this->parseCurrentCharacter();
        }

        return $this->outputString;
    }
    
    
    protected function clearOutputString() {
        $this->outputString = '';
    }
    
    
    private function reset() {
        $this->outputString = '';
        $this->currentCharacterPointer = 0;
        $this->currentState = self::STATE_UNKNOWN;        
    }
    
    
    abstract protected function parseCurrentCharacter();
    
    
    /**
     * Stop parsing
     *  
     */
    protected function stop() {
        $this->currentCharacterPointer = $this->getInputStringLength();
    }
    
    
    /**
     *
     * @return int
     */
    protected function getCurrentState() {
        return $this->currentState;
    }
    
    /**
     *
     * @param int $currentState 
     */
    protected function setCurrentState($currentState) {
        $this->currentState = $currentState;
    }
    
    
    protected function appendOutputString() {
        $this->outputString .= $this->getCurrentCharacter();
    }
    
    
    /**
     *
     * @return string
     */
    protected function getCurrentCharacter() {
        return ($this->getCurrentCharacterPointer() < $this->getInputStringLength()) ? $this->inputString[$this->getCurrentCharacterPointer()] : null;
    }   
    
    
    /**
     *
     * @return string
     */
    protected function getPreviousCharacter() {
        if ($this->getCurrentCharacterPointer() == 0) {
            return null;
        }
        
        $previousCharacterIndex = $this->getCurrentCharacterPointer() - 1;
        return ($previousCharacterIndex > $this->getInputStringLength()) ? null : $this->inputString[$previousCharacterIndex];
    }
    
    
    /**
     *
     * @return string
     */
    protected function getNextCharacter() {        
        return ($this->getCurrentCharacterPointer() == $this->getInputStringLength() - 1) ? null : $this->inputString[$this->getCurrentCharacterPointer() + 1];
    }
    
    
    /**
     *
     * @return int
     */
    protected function getInputStringLength() {
        return $this->inputStringLength;
    }
    
    
    /**
     *
     * @return int
     */
    protected function getCurrentCharacterPointer() {
        return $this->currentCharacterPointer;
    }

    
    /**
     * Increment by one the current character pointer 
     */
    protected function incrementCurrentCharacterPointer() {
        $this->currentCharacterPointer++;
    }   
    
    
    /**
     *
     * @return boolean 
     */
    protected function isCurrentCharacterFirstCharacter() {
        if ($this->getCurrentCharacterPointer() != 0) {
            return false;
        }
        
        return !is_null($this->getCurrentCharacter());
    }  
    
    
    /**
     *
     * @return boolean 
     */
    protected function isCurrentCharacterLastCharacter() {
        return is_null($this->getNextCharacter());
    }    
    
    
    /**
     * 
     * @return string
     */
    protected function getInputString() {
        return $this->inputString;
    }
}