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

<div class="fly-panel">
</div>
<div class="fly-home fly-panel" style="background-image: url();">
  {{ partial("common/user_index_head",['links': 'true']) }}
</div>
<div class="layui-container">
  {{ partial("common/user_index",['links': 'true']) }}
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
        version: "2.0.0",
        base:"/app/mods/",
    }).extend({
        fly: 'index'
    }).use('fly');
</script>
</body>
</html>