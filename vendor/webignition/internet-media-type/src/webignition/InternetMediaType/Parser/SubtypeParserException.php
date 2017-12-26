<?php

namespace webignition\InternetMediaType\Parser;

use \Exception as BaseException;

class SubtypeParserException extends BaseException {    
    
    const INTERNAL_INVALID_CHARACTER_CODE = 1;
    
    /**
     *
     * @var int
     */
    private $position;
    
    public function __construct($message, $code, $position, $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->position = $position;
    }
    
    
    /**
     * 
     * @param int $position
     */
    public function setPosition($position) {
        $this->position = $position;
    }
    
    
    /**
     * 
     * @return int|null
     */
    public function getPosition() {
        return $this->position;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function isInvalidInternalCharacterException() {
        return $this->getCode() === self::INTERNAL_INVALID_CHARACTER_CODE;
    }
    
}