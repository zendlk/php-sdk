<?php
namespace Zend\API;

class OTP {

    private static $json = array();
    private static $config = null;
    private static $response = null;

    public static function Request(\Zend\Support\Config $Config, array $Request) {
        self::$config = $Config;

        /**
         * First of all check if we got the sender id information
         * on the request and override current sender id configuration
         * provided by the configuration instance. otherwise we have
         * to check configuration instance for sender id information.
         */
        if ( isset($Request["sender"]) AND !empty($Request["sender"]) ):
            self::$json["sender"] = $Request["sender"];
        else:
            if ( self::$config->sender() ):
                self::$json["sender"] = self::$config->sender();
            else:
                throw new \Exception("sender id undefined");
            endif;
        endif;

        /**
         * Check if we got valid set of destination or and throw an
         * Exception if there is no destinations defined.
         */
        if ( isset($Request["to"]) AND !empty($Request["to"]) ):
            self::$json["to"] = $Request["to"];
        else:
            throw new \Exception("destination undefined");
        endif;


        $handler = curl_init(self::$config->url()."/otp/send");
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode(self::$json));
        curl_setopt($handler, CURLOPT_HEADER, false);
        curl_setopt($handler, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer ".self::$config->token()
        ]);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_USERAGENT, "zend/php-sdk");
        self::$response = json_decode(curl_exec($handler), true);
        curl_close($handler);

        return ( self::$response["status"] == "success" ) ? self::$response["data"]["otp"]["id"] : false;

    }

}

?>