<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>phalcon中文社区</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="phalcon框架,phalcon社区,php中文社区,php,phalcon中文,phalcon中文社区">
    <meta name="description" content="phalcon中文社区,国内的phalcon社区交流平台">
    <link rel="stylesheet" href="/app/layui/css/layui.css">
    <link rel="stylesheet" href="/app/css/global.css">
</head>
<body>
{#首页头部菜单栏#}
{{ partial("common/header",['links': '123']) }}

<br>
<div class="layui-container fly-marginTop fly-user-main">
    {{ partial("user/menu") }}
    <div class="site-tree-mobile layui-hide"><i class="layui-icon"></i></div>
    <div class="site-mobile-shade"></div>
    <div class="fly-panel fly-panel-user" pad20="">
        <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
            <ul class="layui-tab-title" id="LAY_mine">
                <li class="layui-this">回复文章</li>
                <li class="">@我</li>
            </ul>
            <div class="layui-tab-content" style="padding: 20px 0;">
                <div class="layui-form layui-form-pane layui-tab-item layui-show">
                    <button class="layui-btn layui-btn-radius layui-btn-danger" id="LAY_delallmsg">清空消息</button>
                    <div id="LAY_minemsg" style="margin-top: 10px;">
                        <!--<div class="fly-none">您暂时没有最新消息</div>-->
                        <ul class="mine-msg">
                             <?php foreach (range(1,10) as $val){?>
                            <li data-id="123">
                                <blockquote class="layui-elem-quote">
                                    <a href="/jump?username=Absolutely" target="_blank">
                                        <cite>Absolutely</cite>
                                        </a>回答了您的求解<a target="_blank" href="/jie/8153.html/page/0/#item-1489505778669">
                                        <cite>layui后台框架</cite>
                                    </a>
                                </blockquote>
                                <p><span>1小时前</span><a href="javascript:;" class="layui-btn layui-btn-small layui-btn-danger fly-delete">删除</a></p>
                            </li>
                            <?php }?>
                            <li data-id="123">
                                <blockquote class="layui-elem-quote">
                                    系统消息：欢迎使用 layui
                                </blockquote>
                                <p><span>1小时前</span><a href="javascript:;" class="layui-btn layui-btn-small layui-btn-danger fly-delete">删除</a></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="layui-form layui-form-pane layui-tab-item">
                    <button class="layui-btn layui-btn-danger" id="LAY_delallmsg">清空全部消息</button>
                    <div id="LAY_minemsg" style="margin-top: 10px;">
                        <!--<div class="fly-none">您暂时没有最新消息</div>-->
                        <ul class="mine-msg">
                            <li data-id="123">
                                <blockquote class="layui-elem-quote">
                                    <a href="/jump?username=Absolutely" target="_blank"><cite>Absolutely</cite></a>回答了您的求解<a target="_blank" href="/jie/8153.html/page/0/#item-1489505778669"><cite>layui后台框架</cite></a>
                                </blockquote>
                                <p><span>1小时前</span><a href="javascript:;" class="layui-btn layui-btn-small layui-btn-danger fly-delete">删除</a></p>
                            </li>
                            <li data-id="123">
                                <blockquote class="layui-elem-quote">
                                    系统消息：欢迎使用 layui
                                </blockquote>
                                <p><span>1小时前</span><a href="javascript:;" class="layui-btn layui-btn-small layui-btn-danger fly-delete">删除</a></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
{#页脚#}
{{ partial("common/footer",['links': '123']) }}


<script src="/app/layui/layui.js"></script>
<script>
    layui.cache.page = '';
    layui.cache.user = {
        username: '游客'
        , uid: -1
        , avatar: '<?=BASE_PATH;?>/public/app/images/avatar/00.jpg'
        , experience: 83
        , sex: '男'
    };
    layui.config({
        version: true,
        base: "/app/mods/",
    }).extend({
        fly: 'index'
    }).use('fly', 'face');
</script>
</body>
</html>