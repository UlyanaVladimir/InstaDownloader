<?php
namespace frontend\models;

use yii\base\Model;

//require_once('core.class.php');
define('BASEPATH', str_replace('\\', '/', dirname(__FILE__)) . '/');

class VK extends Model {

    private $token,
    $v_api = '5.73',
    $sleep = 350000,
    $debug = false;

    const BASE_URL = 'https://api.vk.com/method/';

    function __construct($access_token, $debug = false) {
        $this->token = $access_token;
        $this->debug = $debug;
    }

    public function curl($url, $data = false) {
        try {
            usleep(350000);

            if ($ch = curl_init($url)) {
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                if($data) {
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, ($data));
                }
                $out = curl_exec($ch);

                if (curl_errno($ch)) {
                    return null;
                } else {
                    return $out;
                }
            }
        } finally {
            curl_close($ch);
        }
        return null;
    }

    public function api($method = '', $params = array()) {
        $url = self::BASE_URL.$method;

        if (!array_key_exists('access_token', $params) && !is_null($this->token)) {
            $params['access_token'] = $this->token;
        }

        if (!array_key_exists('v', $params) && !is_null($this->v_api)) {
            $params['v'] = $this->v_api;
        }

        ksort($params);

        @$response = json_decode($this->curl($url,$params), true);

        if(($response == NULL) or isset($response['error'])){
            usleep($this->sleep);
            @$response = json_decode($this->curl($url,$params), true);

            if (($response == NULL) or isset($response['error'])) {
                usleep($this->sleep);
                @$response = json_decode($this->curl($url,$params), true);
            }

            if (($response == NULL) or isset($response['error'])) {
                if($this->debug) {
                    setLog(json_encode($response));
                }
                return $response;
            }
        }

        return $response;
    }

    public function downloadImage($url,$filename){
        if(file_exists($filename)){
            @unlink($filename);
        }
        $fp = fopen($filename,'w');
        if($fp){
            $ch = curl_init ($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            $result = parse_url($url);
            curl_setopt($ch, CURLOPT_REFERER, $result['scheme'].'://'.$result['host']);
            curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0');
            $raw=curl_exec($ch);
            curl_close ($ch);
            if($raw){
                fwrite($fp, $raw);
            }
            fclose($fp);
            if(!$raw){
                @unlink($filename);
                return false;
            }
            return true;
        }
        return false;
    }

    private function setLog($message) {
        $log_file_name = 'tmp/vkapi_error.txt';

        if(file_exists($log_file_name)) {
            $log = array_diff(explode("\r\n", file_get_contents($log_file_name)), array(''));
        }

        $log[] = date("m.d.Y-H:i:s").' | '.$message;

        if(file_put_contents($log_file_name, implode("\r\n\r\n", $log))) {
            return true;
        } else {
            return false;
        }
    }

}

?>