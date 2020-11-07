<?php
namespace Zend\API;

class Messages {

    // PROPS
    private $Config = null;
    private $JSON = array();

    // CONSTRUCT
    public function __construct(\Zend\Support\Config $Config) { $this->Config = $Config; }

    public function send() {

        // SENDER ID
        $this->json["sender"] = $Config->sender;

        // REQUEST
        $handler = curl_init("https://api.zend.lk/v1.0/message");
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($this->json));
        curl_setopt($handler, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ "Content-Type: application/json" ]);
        $response = curl_exec($handler);
        curl_close($handler);

        var_dump( $response );
    }

    // SETTERS
    public function to($to) { $this->json["to"] = $to; }
    public function type(string $type) { $this->json["type"] = $type; }
    public function text(string $text) { $this->json["text"] = $text; }

}

?>