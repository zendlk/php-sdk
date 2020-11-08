<?php
namespace Zend\Support;

class Config {

	/**
	 * We need to have registry to keep our configuration
	 * values that requested later from the Zend SDK
	 */
	protected $Registry = array();


	public function __construct(array $params) {

		/**
		 * Configure PHP SDK version information into the registry
		 * so we can use this version information in everywhere.
		 */
		$this->Registry["sdk"] = array(
			"version" => 1.0
		);

		/**
		 * Check if we got authentication token (JWT) to access
		 * Zend API and throw error if not.
		 */
		if ( isset($params["token"]) ):
			$this->Registry["token"] = $params["token"];
		else:
			throw new \Exception("Authorization token undefined");
		endif;

		/**
		 * fall back to version 1.0 if the configuration value
		 * not contain any version string with it.
		 */
		if ( isset($params["version"]) ):
			$this->Registry["version"] = $params["version"];
		else:
			$this->Registry["version"] = "v1.0";
		endif;

		/**
		 * We have add any extra value without any validation to
		 * the configuration registry from here on.
		 */
		foreach ( $params as $key => $element ):
			if ( !array_key_exists($key, $this->Registry) ):
				$this->Registry[$key] = $element;
			endif;
		endforeach;

	}


	public function __get($key) {
		return ( array_key_exists($key, $this->Registry) ) ? $this->Registry[$key] : false;
	}
}

?>
