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

{#社区文章类型头部#}
{#{{ partial("common/category",['links': '123']) }}#}

<div class="fly-panel">
</div>

<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md8">
            <div class="fly-panel" style="margin-bottom: 0;">
                {#推荐资源链接#}
                {{ partial("common/tag",['links': '123']) }}
                {#文章列表#}
                {{ partial("common/article_rows",['links': '123']) }}
                {#分页栏#}
                {{ partial("common/pagination",['status': true]) }}
                {#<div style="text-align: center">
                    <div class="laypage-main">
                        <a href="jie/index.html" class="laypage-next">加载更多</a>
                    </div>
                </div>#}

            </div>
        </div>
        <div class="layui-col-md4">

            {#推荐资源链接#}
            {{ partial("common/recommend",['status': true]) }}

            {#签到模块#}
            {#{{ partial("common/sign",['status': true]) }}#}

            {#回复周排行榜#}
            {{ partial("common/reply_rank",['status': true]) }}

            {#本周热门资讯推荐#}
            {{ partial("common/hot_recommend",['status': true]) }}

            {#广告#}
            {{ partial("common/advertising",['status': true]) }}

            {#本周热门资讯推荐#}
            {{ partial("common/links",['status': true]) }}
        </div>
    </div>
</div>
{#页脚#}
{{ partial("common/footer",['links': '123']) }}


<script src="/app/layui/layui.all.js"></script>
<script>
    layui.cache.page = '';
    layui.cache.user = {
        username: '游客'
        , uid: -1
        , avatar: '/app/images/avatar/00.jpg'
        , experience: 83
        , sex: '男'
    };
    layui.config({
        version: true,
        base:"/app/mods/",
    }).extend({
        fly: 'index'
    }).use('fly');
</script>
</body>
</html>