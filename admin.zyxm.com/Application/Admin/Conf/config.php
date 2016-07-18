<?php
return array(
    // 数据库设置
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'zyxm',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'woshihujun',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  '',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  false,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
   /* 'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号*/

    'URL_CASE_INSENSITIVE'  =>  true,   // 默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：

    define('BASE_URL','http://www.zyxm.com'),
    'TMPL_PARSE_STRING'=>[
        '__CSS__'=> BASE_URL . '/Public/Admin/css',
        '__JS__'=> BASE_URL . '/Public/Admin/js',
        '__IMG__'=> BASE_URL . '/Public/Admin/images',
        '__UPLOADIFY__'=> BASE_URL.'/Public/ext/uploadify',
        '__LAYER__'=> BASE_URL.'/Public/ext/layer',
        '__ZTREE__'=> BASE_URL.'/Public/ext/ztree',
        '__TREEGRID__'=> BASE_URL.'/Public/ext/treegrid',
        '__UEDITOR__'=> BASE_URL.'/Public/ext/ueditor',
        ],
    'PAGE_SETTING'=>[
        'PAGE_SIZE'=>20,
        'PAGE_THEME'=>'%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%',
    ],

   'UPLOAD_SETTING'       =>  require 'upload.php',

    'ACCESS_IGNORE'=>[
        'IGNORE'=>[//所有用户都可见
            'Admin/Admin/login',
            'Admin/Captcha/captcha',
        ],
        'USER_IGNORE'=>[//登陆用户都可见
            'Admin/Index/index',
            'Admin/Index/top',
            'Admin/Index/menu',
            'Admin/Index/main',
            'Admin/Admin/logout',
            'Admin/Admin/editPwd',
        ],
    ],

    'COOKIE_PREFIX'=>'admin_shop_com_',
);