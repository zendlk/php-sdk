<?php
namespace Zend\Support;

class Config {

    /**
     * We need to have registry to keep our configuration
     * values that requested later from the Zend SDK
     */
    protected $Registry = array();


    public function __construct(array $params) {
        $this->Registry = $params;
    }


    public function __get($key) {
        return ( array_key_exists($key, $this->Registry) ) ? $this->Registry[$key] : false;
    }
}

?>
