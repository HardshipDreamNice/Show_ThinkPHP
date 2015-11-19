<?php
return array(
	//'配置项'=>'配置值'

    /* 数据库设置 */
    'DB_TYPE'                => 'mysql', // 数据库类型
    'DB_HOST'                => '127.0.0.1', // 服务器地址
    'DB_NAME'                => 'shop', // 数据库名
    'DB_USER'                => 'root', // 用户名
    'DB_PWD'                 => 'woainilaopo20', // 密码
    'DB_PORT'                => '3306', // 端口
    'DB_PREFIX'              => 'it_', // 数据库表前缀

    // 更改过滤XSS方法
    'DEFAULT_FILTER'         => 'removeXSS',

    // 设置访问模块 前天 及 后台
    'MODULE_ALLOW_LIST'       => array('Home', 'Admin'),

    // 定义上传文件白名单
    'UPLOAD_ALLOW_EXT' => array('jpg', 'gif', 'png', 'jpeg'),
    // 定义上传文件根路径 必须加'.'号
    'UPLOAD_ROOT_PATH' => './Public/Uploads/',
    // 定义上传最大值
    'UPLOAD_FILE_MAXSIZE' => 3145728,
);
