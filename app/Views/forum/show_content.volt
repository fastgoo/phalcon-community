<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>phalcon中文社区</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="phalcon框架,phalcon社区,php中文社区,php">
    <meta name="description" content="Fly社区是模块化前端UI框架Layui的官网社区，致力于为web开发提供强劲动力">
    <link rel="stylesheet" href="/app/layui/css/layui.css">
    <link rel="stylesheet" href="/app/css/global.css">
</head>
<body>
{#首页头部菜单栏#}
{{ partial("common/header",['links': '123']) }}

{#社区文章类型头部#}
{#{{ partial("common/category",['links': '123']) }}#}

<br>
<div class="layui-container fly-marginTop">
    <div class="fly-panel">
        <div class="fly-none">
            <h2><i class="iconfont icon-tishilian"></i></h2>
            <p>这是一个基于 layui 的极简通用型社区页面模版</p>
            <h2><i class="iconfont icon-tishilian"></i></h2>
            <p>这是一个基于 layui 的极简通用型社区页面模版</p>
        </div>
    </div>
</div>
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
        version: "2.0.0",
        base:"/app/mods/",
    }).extend({
        fly: 'index'
    }).use('fly','face');
</script>

<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    document.write(unescape("%3Cspan id='cnzz_stat_icon_30088308'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "w.cnzz.com/c.php%3Fid%3D30088308' type='text/javascript'%3E%3C/script%3E"));</script>

</body>
</html>