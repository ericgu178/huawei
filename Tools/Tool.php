<?php
namespace huawei\Tools;

class Tool
{
    static public function imgToBase64($image_file) 
    {
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = base64_encode($image_data);
        return $base64_image;
    }
}