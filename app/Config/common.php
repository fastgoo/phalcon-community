<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/7/17
 * Time: 下午2:27
 */

return new \Phalcon\Config([
    'login_type' => [
        1
    ],
    /**
     * 七牛上传配置信息
     */
    'qiniu' => [
        'accessKey' => 'IdL1wiByfNrlNHvRjOE1EoH9CljdnwS4NQYd9NYC',
        'secretKey' => 'gy3_H3ABF2Jj_vm9B4PnUV5SREEAxk0Q3ObQmuaR',
        'bucket' => 'fastgoo',
        'url' => 'https://resource.fastgoo.net',
    ],
    /**
     * 授权认证器配置
     */
    'socialite' => [
        'github' => [
            'client_id' => '3de789e5949912c3a83b',
            'client_secret' => 'ba135baaffd5c4c5791d58f248f9503c1cb6f2cb',
            'redirect' => 'http://www.iphalcon.cn/auth/github/callback',
        ],
        'qq' => [
            'client_id' => '101452332',
            'client_secret' => '1e2731aba5d6bef3f967eaa5d8b50371',
            'redirect' => 'https://phalcon.fastgoo.net/auth/qq/callback',
        ],
        'wechat' => [
            'client_id' => 'wx3f37b98cf00ee980',
            'client_secret' => '4c39e3310498042dbca1ebf5b37a862d',
            'redirect' => 'http://www.iphalcon.cn/auth/wechat/callback',
        ],
    ],
    /**
     * Jpush极光推送配置
     */
    'jpush' => [
        'default' => [
            'app_key' => '',
            'master_secret' => '',
            'production' => false,
        ]
    ],
    /**
     * 微信支付配置信息
     */
    'wechat_pay' => [
        'app' => [
            'app_id' => 'wx85a292bbab3bfdc6',
            'app_secret' => 'b0ec55c14084a6c37b9967f06594d2ce',
            'mch_id' => '1466807002',
            'md5_key' => '08f725bgf05ef5783d7efc50f4041d92',
            'cert_pem' => '',
            'key_pem' => '',
        ],
        'web' => [
            'app_id' => 'wxaf04a9b500505485',
            'app_secret' => '50b899b8e88bc51918e9c8ffa753a591',
            'mch_id' => '1316706001',
            'md5_key' => '181d0ecef6e3d3a6cb8c1008ddfa9056',
            'cert_pem' => BASE_PATH . '/resource/wechat/apiclient_cert.pem',
            'key_pem' => BASE_PATH . '/resource/wechat/apiclient_key.pem',
        ]
    ],
    /**
     * 支付宝支付
     */
    'alipay' => [
        'app_id' => '2016082501801628',
        'partner' => '2088021466056978',
        'seller_id' => 'hzqxnet@163.com',
        'ali_public_key' => BASE_PATH . '/resource/alipay/alipay_public_key.pem',
        'rsa_private_key' => BASE_PATH . '/resource/alipay/rsa_private_key.pem',
    ],
    /**
     * JwtAuth token授权配置
     */
    'jwt_auth' => [
        'type' => 'HS256',
        'key' => 'zhouxiansheng',
        'privete' => BASE_PATH . '/resource/jwtauth/id_ras',
        'public' => BASE_PATH . '/resource/jwtauth/id_ras.pub',
    ],
    /**
     * 头部菜单显示
     */
    'header_title' => [
        'forum' => [
            'icon' => '&#xe62e;',
            'title' => '社区',
            'url' => '/forum/home/index',
        ],
        /*'news' => [
            'icon' => '&#xe756;',
            'title' => '资讯',
            'url' => '/news/home/index',
        ],*/
        'doc' => [
            'icon' => '&#xe705;',
            'title' => '文档',
            'url' => 'http://docs.iphalcon.cn/',
        ]
    ],
    /**
     * 社区首页标签以及状态
     */
    'tag_list' => [
        0 => ['name' => '最新', 'has_new' => 0,],
        1 => ['name' => '热门', 'has_new' => 0,],
        2 => ['name' => '精华', 'has_new' => 0,],
        3 => ['name' => '分享', 'has_new' => 0,],
        4 => ['name' => '求助', 'has_new' => 0,],
    ],
    'tags' => ['动态', '分享', '求助'],
    'verify_title' => [
        110 => '管理员',
        100 => '创始人',
    ]
]);
