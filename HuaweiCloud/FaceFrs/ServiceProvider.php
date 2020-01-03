<?php
namespace huawei\HuaweiCloud\FaceFrs;
use huawei\Common\Request;
use huawei\Tools\Tool;

/**
 * face
 *
 * 人脸 v2
 * 
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

    /**
     * 人脸检测
     *
     * 对输入图片进行人脸检测和分析，输出人脸在图像中的位置、人脸关键点位置和人脸关键属性。
     * 官方接口 更新时间 2019/11/08 GMT+08:00
     * 
     * @param string $file
     * @return void
     * @author EricGU178
     */
    public function detect($file)
    {
        $url    =   $this->host . 'v2/' . $this->config['project_id'] . '/face-detect';
        $data   =   [
            'image_base64'  =>  Tool::imgToBase64($file)
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
     * 将两个人脸进行比对，来判断是否为同一个人，返回比对置信度。如果传入的图片中包含多个人脸，选取最大的人脸进行比对。
     * 官方接口 更新时间 2019/11/08 GMT+08:00
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
     * 人脸搜索
     *
     * 人脸搜索是指在已有的人脸库中，查询与目标人脸相似的一张或者多张人脸，并返回相应的置信度。
     * 支持传入图片或者faceID进行人脸搜索，如果传入的是多张人脸图片，选取图片中检测到的最大尺寸人脸作为检索的输入。
     * 官方接口 更新时间 2019/11/08 GMT+08:00
     * 
     * @param int $type 1 文件 2 链接 3 人脸编号（导入人脸时，系统返回的人脸编号，即人脸ID。）
     * @param string $data 数据
     * @param string $face_set_name 人脸库
     * @param integer $top_n 返回查询到的最相似的N张人脸，N默认为10。
     * @param float $threshold 人脸相似度阈值，低于这个阈值则不返回，取值范围0~1，一般情况下建议取值0.93，默认为0。
     * @param array $other 其他
     * @return void
     * @author EricGU178
     */
    public function search($type,$data,$face_set_name,$top_n = 10,$threshold = 0.93,$other = [])
    {
        $url    =   $this->host . 'v2/' . $this->config['project_id'] . '/face-sets/' . $face_set_name . '/search';
        $data   =   [
            'top_n'  =>  $top_n,
            'threshold'  =>  $threshold
        ];
        if ($type == 1) {
            $data['image_base64'] = Tool::imgToBase64($data);
        } else if ($type == 2) {
            $data['image_url'] = $data;
        } else if ($type == 3) {
            $data['face_id'] = $data;
        }
        
        $data = array_merge($data,$other);

        $header = $this->commonHeader($url, $data);
        $head   = [];
        foreach ($header as $k => $v) {
            $head[] = $k . ':' . $v;
        }
        $response = $this->execute($url, $data, $head);
        return $response;
    }

    /**
     * 创建人脸库
     *
     * 创建用于存储人脸特征的人脸库。您最多可以创建10个人脸库，每个人脸库最大容量为10万个人脸特征。如有更大规格的需求请联系客服。
     * 官方接口 更新时间 2019/11/08 GMT+08:00
     * @return void
     * @author EricGU178
     */
    public function create_face_sets($face_set_name)
    {
        $url    =   $this->host . 'v2/' . $this->config['project_id'] . '/face-sets';
        $data   =   [
            'face_set_name'  =>  $face_set_name,
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
     * 查询所有人脸库
     *
     * 未证明可用
     * 
     * 查询当前用户所有人脸库的状态信息。
     * 官方接口 更新时间 2019/11/08 GMT+08:00
     * @return void
     * @author EricGU178
     */
    public function face_sets()
    {
        $url    =   $this->host . 'v2/' . $this->config['project_id'] . '/face-sets';
        $data   =   [];
        $header = $this->commonHeader($url, $data , 'GET');
        $head   = [];
        foreach ($header as $k => $v) {
            $head[] = $k . ':' . $v;
        }
        $response = $this->execute($url, $data, $head);
        return $response;
    }

    /**
     * 删除人脸库
     *
     * 删除人脸库以及其中所有的人脸。
     * 
     * @param  string $face_set_name
     * @return void
     * @author EricGU178
     */
    public function delete_face_sets($face_set_name)
    {
        $url    =   $this->host . 'v2/' . $this->config['project_id'] . '/face-sets/' . $face_set_name;
        $data   =   [];
        $header = $this->commonHeader($url, $data , 'DELETE');
        $head   = [];
        foreach ($header as $k => $v) {
            $head[] = $k . ':' . $v;
        }
        $response = $this->execute($url, $data, $head);
        return $response;
    }

    /**
     * 查询人脸库
     *
     * 未证明可用
     * 
     * 查询当前用户所有人脸库的状态信息。
     * 官方接口 更新时间 2019/11/08 GMT+08:00
     * @return void
     * @author EricGU178
     */
    public function search_face_sets($face_set_name)
    {
        $url    =   $this->host . 'v2/' . $this->config['project_id'] . '/face-sets/' . $face_set_name;
        $data   =   [];
        $header = $this->commonHeader($url, $data , 'GET');
        $head   = [];
        foreach ($header as $k => $v) {
            $head[] = $k . ':' . $v;
        }
        $response = $this->execute($url, $data, $head);
        return $response;
    }

    /**
     * 添加人脸
     *
     * 添加人脸到人脸库中，将检测到的最大人脸增加到人脸库当中。
     * 
     * @return void
     * @author EricGU178
     */
    public function create_faces($face_set_name,$file)
    {
        $url    =   $this->host . 'v2/' . $this->config['project_id'] . '/face-sets/' . $face_set_name . '/faces';
        $data   =   [
            'image_base64'  =>  Tool::imgToBase64($file)
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
     * 查询人脸
     * 
     * 查询指定人脸库中人脸信息。
     *
     * GET   /v2/{project_id}/face-sets/{face_set_name}/faces?face_id={face_id}
     * 更新时间 2019/11/08 GMT+08:00
     * @param string $face_set_name
     * @param string $face_id
     * @return void
     * @author EricGU178
     */
    public function search_feces($face_set_name,$face_id)
    {
        $url    =   $this->host . 'v2/' . $this->config['project_id'] . '/face-sets/' . $face_set_name . '/faces?face_id=' . $face_id;
        $data   =   [];
        $header =   $this->commonHeader($url, $data,'GET','face_id='.$face_id);
        $head   =   [];
        foreach ($header as $k => $v) {
            $head[] = $k . ':' . $v;
        }
        $response = $this->execute($url, $data, $head);
        return $response;
    }

    /**
     * 构建 请求头部
     *
     * @param string $url
     * @param array $data
     * @return void
     * @author EricGU178
     */
    private function commonHeader($url, $data, $method = 'POST' , $queryString = '')
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
                'method'    =>  $method,
                'queryString'   =>  $queryString
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