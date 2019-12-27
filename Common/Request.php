<?php
namespace Huawei\Common;
use \Huawei\Tools\Request as tool;
// use \Huawei\OpenPlatform\AccessToken\ServiceProvider as token;

class Request
{
    protected $config = [];

    protected $ak_id = null;

    protected $ak_secret = null;
    
    public function __construct($config)
    {
        $this->config = $config;
        $this->ak_id = $this->config['ak_id'] ?? trigger_error('ak_id不存在');
        $this->ak_secret = $this->config['ak_secret'] ?? trigger_error('ak_secret不存在');
    }

    /**
     * 执行
     *
     * @return void
     * @author EricGU178
     */
    public function execute($url,$request_data = [],$headers = [])
    {
        if (empty($request_data)) {
            $response = tool::curl_get_https($url);
        }
        if (!empty($headers)) {
            $response = tool::requestNormalPost($url,$request_data,$headers);
        } else {
            $response = tool::curl_post_https($url,$request_data);
        }
        return json_decode($response,true);
    }

    // /**
    //  * 获取access_token
    //  *
    //  * @return void
    //  * @author EricGU178
    //  */
    // protected function getAccessToken()
    // {
    //     $token = new token($this->config);
    //     return $token->getAccessToken();
    // }
}