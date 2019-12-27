```php
use huawei\Huawei;
$s = Huawei::HuaweiCloud([
    'ak_id' =>  '', // ak id
    'ak_secret' =>  '', // ak 私钥
    'project_id'    =>  '' // 产品ID
])->face_frs->compare('/Users/zkbr/Desktop/download.jpg','/Users/zkbr/Desktop/download.jpg');

// 人脸比对

print_r($s);
`