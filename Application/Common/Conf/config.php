<?php
return array(
    //开启调试
    'SHOW_PAGE_TRACE' => false,
    //URL不区分大小写
    'URL_CASE_INSENSITIVE' => true,
    //是否开启session
    'SESSION_AUTO_START' => true,

      //表单令牌
     'TOKEN_ON' => true,  // 是否开启令牌验证 默认关闭
     'TOKEN_NAME' => '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
     'TOKEN_TYPE' => 'md5',  //令牌哈希验证规则 默认为MD5
     'TOKEN_RESET' => true,  //令牌验证出错后是否重置令牌 默认为true

    'LOG_RECORD' => true, // 开启日志记录
    'LOG_LEVEL' => 'EMERG,ALERT,CRIT,ERR,WARN', // 只记录EMERG ALERT CRIT ERR 错误

    //数据库配置1
    'DB_TYPE' => 'mysqli', // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'actshop', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => 'D82fc0e822ed', // 密码
    'DB_PORT' => 3306, // 端口
    'DB_PARAMS' => array(), // 数据库连接参数
    'DB_PREFIX' => 'l_', // 数据库表前缀
    'DB_CHARSET' => 'utf8', // 字符集
    'DB_DEBUG' => true, // 数据库调试模式 开启后可以记录SQL日志
    'DB_PARAMS' => array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL),//开启字段大小写

    'TMPL_CACHE_ON' => true,


    //URL模式，去掉index.php
//    'URL_MODEL' => 2,


    //I方法增加trim
    'DEFAULT_FILTER' => 'trim,htmlspecialchars',

);