<?php
namespace Zend\API;

class Messages {

    // PROPS
    private $Config = null;
    private $json = array();

    // CONSTRUCT
    public function __construct(\Zend\Support\Config $Config) { $this->Config = $Config; }

    public function send() {

        // SENDER ID
        $this->json["sender"] = $this->Config->sender;

        // REQUEST
        $handler = curl_init("https://api.zend.lk/v".$this->Config->version."/message");
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($this->json));
        curl_setopt($handler, CURLOPT_HEADER, false);
        curl_setopt($handler, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->Config->token
        ]);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_USERAGENT, "zend/php-sdk:".$this->Config->sdk["version"]);
        $response = curl_exec($handler);
        curl_close($handler);

        return json_decode($response, true);
    }

    // SETTERS
    public function to($to) { $this->json["to"] = $to; }
    public function type(string $type) { $this->json["type"] = $type; }
    public function text(string $text) { $this->json["message"] = $text; }

}

?>