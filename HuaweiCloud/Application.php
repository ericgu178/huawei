<?php

/*
 * 华为云
 *
 * Eric Gu 178
 *
 * 入口服务
 * 
 */

namespace huawei\HuaweiCloud;
use \huawei\Common\Register; 

class Application extends Register
{
    /**
     * 容器
     * 
     * @var array
     */
    protected $providers = [
        \huawei\HuaweiCloud\FaceFrs\ServiceProvider::class, //人脸识别
    ];
}
