<?php

namespace webignition\InternetMediaType;

use webignition\InternetMediaType\Parameter\Parameter;

/**
 * Models an Internet Media Type as defined as:
 * 
 * HTTP uses Internet Media Types [17] in the Content-Type (section 14.17) and 
 * Accept (section 14.1) header fields in order to provide open and extensible data
 * typing and type negotiation.
 * 
 * media-type     = type "/" subtype *( ";" parameter )
 * type           = token
 * subtype        = token
 * 
 * Parameters MAY follow the type/subtype in the form of attribute/value pairs
 * 
 * parameter               = attribute "=" value
 * attribute               = token
 * value                   = token | quoted-string
 * 
 * The type, subtype, and parameter attribute names are case-insensitive
 * 
 * http://www.w3.org/Protocols/rfc2616/rfc2616-sec3.html#sec3.7 
 * 
 * Note: may have multiple parameters as per Content-Type example
 * in http://www.w3.org/Protocols/rfc1341/rfc1341.html section 7.3.2:
 * 
 *       Content-Type: Message/Partial;
 *           number=2; total=3;
 *           id="oc=jpbe0M2Yt4s@thumper.bellcore.com";
 * 
 */
class InternetMediaType {
    
    const TYPE_SUBTYPE_SEPARATOR = '/';  
    const PARAMETER_ATTRIBUTE_VALUE_SEPARATOR = '=';
    const ATTRIBUTE_PARAMETER_SEPARATOR = ';';
    
    /**
     * Main media type.
     * 
     * For a 'text/html' media type, this would be 'text'
     * 
     * @var string
     */
    private $type = null;
    
    
    /**
     * Subtype, a type within a type
     * 
     * For a 'text/html' media type, this would be 'html'
     * 
     * @var string
     */
    private $subtype = null;
    
    
    /**
     * Collection of Parameter objects
     * 
     * @var Parameter[]
     */
    private $parameters = array();
    
    
    /**
     *
     * @param string $type
     * @return InternetMediaType
     */
    public function setType($type) {
        $this->type = strtolower($type);
        return $this;
    }
    
    
    /**
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }
    
    
    /**
     *
     * @param string $subtype
     * @return InternetMediaType
     */
    public function setSubtype($subtype) {
        $this->subtype = strtolower($subtype);
        return $this;
    }
    
    
    /**
     *
     * @return string
     */
    public function getSubtype() {
        return $this->subtype;
    }
    
    
    /**
     *
     * @param Parameter $parameter
     * @return InternetMediaType
     */
    public function addParameter(Parameter $parameter) {
        $this->parameters[$parameter->getAttribute()] = $parameter;
        return $this;
    }
    
    
    /**
     *
     * @param string $attribute
     * @return boolean
     */
    public function hasParameter($attribute) {
        return !is_null($this->getParameter($attribute));
    }
    
    
    /**
     *
     * @param Parameter $parameter
     * @return InternetMediaType
     */
    public function removeParameter(Parameter $parameter) {
        if ($this->hasParameter($parameter->getAttribute())) {
            unset($this->parameters[$parameter->getAttribute()]);
        }
        
        return $this;
    }
    
    
    /**
     *
     * @param string $attribute
     * @return Parameter|null
     */
    public function getParameter($attribute) {
        $attribute = trim(strtolower($attribute));
        return isset($this->parameters[$attribute]) ? $this->parameters[$attribute] : null;
    }
    
    
    /**
     * Get collection of Parameter objects
     * 
     * @return Parameter[]
     */
    public function getParameters() {
        return $this->parameters;
    }
    
    
    /**
     *
     * @return boolean 
     */
    public function hasType() {
        if (is_null($this->type)) {
            return false;
        }
        
        if ($this->getType() == '') {
            return false;
        }
        
        return true;
    }
    
    
    /**
     *
     * @return boolean 
     */
    public function hasSubtype() {
        if (is_null($this->subtype)) {
            return false;
        }
        
        if ($this->getSubtype() == '') {
            return false;
        }
        
        return true;
    }    
    
    
    public function __toString() {
        $string = $this->getTypeSubtypeString();
        
        if (count($this->getParameters()) === 0) {
            return $string;
        }
              
        $parameterStringParts = array();
        
        foreach ($this->getParameters() as $parameter) {
            $parameterStringParts[] = (string)$parameter;     
        }
        
        if (!$this->isEmptyParameterStringCollection($parameterStringParts)) {
            $string .= self::ATTRIBUTE_PARAMETER_SEPARATOR . ' ' . implode(self::ATTRIBUTE_PARAMETER_SEPARATOR.' ', $parameterStringParts); 
        }      
               
        return trim($string);
    }
    
    private function isEmptyParameterStringCollection($parameterStringCollection) {
        if (count($parameterStringCollection) === 0) {
            return true;
        }
        
        foreach ($parameterStringCollection as $value) {
            if ($value != '') {
                return false;
            }
        }
        
        return true;
    }
    
    
    /**
     * Get a string of the form {type}/{subtype}
     * 
     * @return string
     */
    public function getTypeSubtypeString() {
        $string = '';
        
        if (!$this->hasType()) {
            return $string;
        }
        
        if (!$this->hasSubtype()) {
            return $string;
        }
        
        return $this->getType() . self::TYPE_SUBTYPE_SEPARATOR . $this->getSubtype();
    }
    
}
