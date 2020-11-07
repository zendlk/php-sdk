<?php
namespace Zend\API;

class Messages {

    // PROPS
    private $text = null;
    private $destinations = null;

    public function __construct(\Zend\Support\Config $Config) {
        var_dump( $Config );
    }

    public function send() {
        error_log($this->text);
        error_log($this->destinations);
    }

    // SETTERS
    public function to(array $to) { $this->destinations = $to; }
    public function text(string $text) { $this->text = $text; }

}

?>