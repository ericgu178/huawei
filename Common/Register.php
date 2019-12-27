<?php
namespace Huawei\Common;

/**
 * 注册器
 *
 * @author EricGU178
 */
class Register
{
    /**
     * 容器
     *
     * @var array
     * @author EricGU178
     */
    protected $providers = [];

    /**
     * 配置文件
     *
     * @var array
     * @author EricGU178
     */
    protected $config = [];


    /**
     * 初始化
     *
     * @author EricGU178
     */
    public function __construct($config)
    {
        if (empty($config)) {
            throw new \Exception("华为云配置文件出错");
        }
        $this->config = $config;
    }

    /**
     * 注册器
     *
     * @param string $marker
     * @param array $config
     * @return void
     * @author EricGU178
     */
    public function register($marker,$config=[])
    {
        $url = 'xxx';
        foreach ($this->providers as $value) {
            if (strstr($value, $marker)) {
                $url = $value;
                break;
            }
        }
        if (class_exists($url)) {
            return new $url($config);
        } else {
            throw new \Exception("暂时没有这个类");
        }
    }

    /**
     * 获取未定义的变量内容
     *
     * @param string $name
     * @return void
     * @author EricGU178
     */
    public function __get($name) 
    {
        $marker = self::title($name);
        return $this->register($marker,$this->config);
    }
    
    /**
     * 转换字符
     *
     * @param string $value
     * @return void
     * @author EricGU178
     */
    static private function title($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        $name = str_replace(" ",'', $value);
        return $name;
    }
}