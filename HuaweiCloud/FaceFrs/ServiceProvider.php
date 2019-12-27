<?php
namespace huawei\HuaweiCloud\FaceFrs;
use huawei\Common\Request;
use huawei\Tools\Tool;
/**
 * face
 *
 * @author EricGU178
 */
class ServiceProvider extends Request
{
    /**
     * v2 华北-北京四
     *
     * @var
     */
    protected $host = 'https://face.cn-north-4.myhuaweicloud.com/';

    public function detect($file)
    {
        $url    =   $this->host . 'v2/' . $this->config['project_id'] . '/face-detect';
        $data   =   [
            'image_base64'  =>  1231
        ];
        $header = $this->commonHeader($url, $data);
        $head   = [];
        foreach ($header as $k => $v) {
            $head[] = $k . ':' . $v;
        }
        $response = $this->execute($url, $data, $head);
        return $response;
    }

    /**
     * 人脸比对
     *
     * @param string $file1
     * @param string $file2
     * @return void
     * @author EricGU178
     */
    public function compare($file1,$file2)
    {
        $url    =   $this->host . 'v2/' . $this->config['project_id'] . '/face-compare';
        $data   =   [
            'image1_base64'  =>  Tool::imgToBase64($file1),
            'image2_base64'  =>  Tool::imgToBase64($file2)
        ];
        $header = $this->commonHeader($url, $data);
        $head   = [];
        foreach ($header as $k => $v) {
            $head[] = $k . ':' . $v;
        }
        $response = $this->execute($url, $data, $head);
        return $response;
    }


    /**
     * 构建 请求头部
     *
     * @param [type] $url
     * @param [type] $data
     * @return void
     * @author EricGU178
     */
    private function commonHeader($url, $data)
    {
        // 美区时间
        date_default_timezone_set('UTC');
        $date = date('Ymd') . 'T' . date('His') . 'Z';
        $header  = [
            'Content-Type'      => 'application/json',
            'Host'              =>  'face.cn-north-4.myhuaweicloud.com',
            'X-Sdk-Date'        => $date,
            'Authorization'     => $this->authorization($data,$url,[
                'content-type'  =>  'application/json',
                'host'              =>  'face.cn-north-4.myhuaweicloud.com',
                'x-sdk-date'    =>  $date,
            ],[
                'method'    =>  'POST',
                'queryString'   =>  ''
            ]),
        ];
        // print_r($header);die;
        return $header;
    }

    /**
     * 生成签名
     *
     * 华为 ak签名 地址 https://support.huaweicloud.com/devg-apisign/api-sign-algorithm.html
     * @return void
     * @author EricGU178
     */
    private function authorization($data,$url,$header,$option)
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }
        $body256        =   hash("sha256", $data); // sha256 加密
        $parse          =   parse_url($url);
        $path           =   $parse['path'] . '/'; // 计算签名时，URI必须以“/”结尾。发送请求时，可以不以“/”结尾。

        $head = ''; // 请求体
        $signedHeaders = ''; // 参与消息头的签名
        $count = count($header);
        $i = 0;
        foreach ($header as $key => $value) {
            $i ++;
            $head .= strtolower($key) . ':' . $value . "\n";
            if ($count == $i) {
                $signedHeaders .= $key;
                break;
            }
            $signedHeaders .= $key . ';';
        }
        $method = $option['method']; // 方法
        $queryString = $option['queryString']; // 查询字符串 parm1=value1&parm2=
        $stringToSign  = "$method\n$path\n$queryString\n$head\n$signedHeaders\n$body256";
        // echo '震' . $stringToSign . "\n";
        $signStringToSign    =    hash('sha256',$stringToSign);
        // echo '撼' . $signStringToSign . "\n";
        $date = $header['x-sdk-date'];
        $stringToSign2      =  "SDK-HMAC-SHA256\n$date\n$signStringToSign";
        // echo '你' . $stringToSign2 . "\n";
        $authorization      =  "SDK-HMAC-SHA256 Access=" . $this->config['ak_id'] . ", SignedHeaders=$signedHeaders, Signature=".hash_hmac("sha256",$stringToSign2,$this->config['ak_secret']);
        // echo '妈' . $authorization . "\n";
        return $authorization;
    }
}