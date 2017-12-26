<?php

namespace webignition\StringParser\Concrete;

use webignition\StringParser\StringParser;

/**
 * A simple demonstration parser that does nothing other than parse over and
 * return exactly what it has been given
 *  
 */
class PassThroughParser extends StringParser {
    
    const STATE_IN_VALUE = 1;
    
    protected function parseCurrentCharacter() {
        switch ($this->getCurrentState()) {
            case self::STATE_UNKNOWN:
                $this->setCurrentState(self::STATE_IN_VALUE);
                break;
            
            case self::STATE_IN_VALUE:
                    $this->appendOutputString();
                    $this->incrementCurrentCharacterPointer();

                break;
        }
    }

}