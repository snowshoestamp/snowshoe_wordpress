<?php
include( plugin_dir_path( __FILE__ ) . 'OAuthSimple.php');

class SSSApiClient {
    protected $app_key = null;
    protected $app_secret = null;

    public function __construct($app_key, $app_secret) {
        $this->app_key = $app_key;
        $this->app_secret = $app_secret;
    }

    public function processData($data) {
        $data = array("data" => $data);
        $app_key = $this->app_key;
        $app_secret = $this->app_secret;

        $oauth = new OAuthSimple();
        $result = $oauth->sign(
            Array("path" => "http://beta.snowshoestamp.com/api/v2/stamp",
                  "parameters" => $data,
                  "action" => "POST",
                  "signatures" => Array("consumer_key" => $app_key,
                                        "shared_secret" => $app_secret)));

        $header = $oauth->getHeaderString();
        $ch = curl_init($result['signed_url']);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: ".$header));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $return = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $return;
    }
}
?>
