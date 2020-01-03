<?php
/**
 * Date:2019-12-31
 * Author:Ericgu178
 * 华为开放接口
 */
namespace huawei;

class Huawei
{
    static public function init($name,array $config)
    {
        $namespace = self::title($name);
        $index = "\\huawei\\{$namespace}\\Application";
        if (class_exists($index)) {
            return new $index($config);
        } else {
            trigger_error("错误huawei::{$name}，请检查");
        }
    }

    /**
     * 重载
     *
     * @return void
     * @author EricGU178
     */
    static public function __callStatic($name, $arguments)
    {
        return self::init($name, ...$arguments);//参数展开
    }

    static private function title($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        return $value;
    }
}