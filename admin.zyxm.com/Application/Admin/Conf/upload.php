<?php

return [
    'rootPath'     => ROOT_PATH,
    'savePath'     => 'uploads/',
    'mimes'        => array(), //允许上传的文件MiMe类型
    'maxSize'      => 0, //上传的文件大小限制 (0-不做限制)
    'exts'         => array(), //允许上传的文件后缀
    'autoSub'      => true, //自动子目录保存文件
    'subName'      => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
    'saveName'     => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
    'saveExt'      => '', //文件保存后缀，空则使用原后缀
    'replace'      => false, //存在同名是否覆盖
    'hash'         => true, //是否生成hash编码
    'callback'     => false, //检测文件是否存在回调，如果存在返回文件信息数组
    'driver'       => '', // 文件上传驱动
   'driverConfig' => array(
        'SecretKey' => '9cxiI2yx7gXvxV6cpVG6W0UaFG4zFljrJYgV2F-d', //SK
        'accessKey'  => 'OgLrYqHreIe7rHYajwX7ItmJ4tO5aOwaYRb-SD8M', //AK
        'domain'     => 'o9hoik6dt.bkt.clouddn.com', //域名
        'bucket'     => 'tp1120', //空间名称
        'timeout'    => 300, //超时时间
    ),// 上传驱动配置*/
];
