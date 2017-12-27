<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ userInfo.nickname }}的主页</title>
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

<div class="fly-home fly-panel" style="background-image: url();">
    <img src="{{ userInfo.head_img }}" alt="{{ userInfo.nickname }}">
    {% if userInfo.verify_type %}
        <i class="iconfont icon-renzheng" title="认证信息: {{ verifyTitle[userInfo.verify_type] }}"></i>
    {% endif %}
    <h1> {{ userInfo.nickname }}
        {% if userInfo.sex == 1 %}
            <i class="iconfont icon-nv"></i>
        {% else %}
            <i class="iconfont icon-nan"></i>
        {% endif %}
        {% if userInfo.verify_type %}
            <i class="layui-badge fly-badge-vip">{{ verifyTitle[userInfo.verify_type] }}</i>
        {% endif %}
    </h1>
    &nbsp;
    <p class="fly-home-info">
        <i class="iconfont icon-shijian"></i><span>{{ date("Y-m-d",userInfo.created_time) }} 加入</span>
        <i class="iconfont icon-chengshi"></i><span>来自中国 {{ userInfo.city }}</span>
    </p>
    <p class="fly-home-sign">{{ userInfo.sign ? userInfo.sign : '（这个人很懒，什么都没留下）' }}</p></div>
<div class="fly-panel">
</div>
<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md6 fly-home-jie">
            <div class="fly-panel"><h1 class="fly-panel-title">最近发布</h1>
                <ul class="jie-row">
                    {% for index, item in articleList %}
                        <li>
                            {% if item.is_top %}
                                <span class="layui-badge layui-bg-orange">顶</span>
                            {% endif %}
                            {% if item.is_essence %}
                                <span class="layui-badge layui-bg-red">精</span>
                            {% endif %}
                            <a href="/forum/article/detail/{{ item.id }}" class="jie-title">{{ item.title }}</a>
                            <i><?=timeCompute($item->created_time);?></i>
                            <em class="layui-hide-xs">
                                <i class="layui-icon" title="人气" style="font-size: 18px; color: #ff1813;">&#xe756;</i>
                                {{ item.view_nums }}
                                &nbsp;
                                <i class="layui-icon" title="回答" style="font-size: 18px; color: #1E9FFF;">&#xe63a;</i>
                                {{ item.reply_nums }}
                            </em>
                        </li>
                    {% endfor %}
                    <?php if(count($articleList) <= 0){?>
                    <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i
                                style="font-size:14px;">这个人很懒，没有发表过任何文章</i></div>
                    <?php }?>

                </ul>
            </div>
        </div>
        <div class="layui-col-md6 fly-home-da">
            <div class="fly-panel"><h1 class="fly-panel-title">最近回复</h1>
                <ul class="home-jieda">
                    {% for index, item in replyList %}
                        <li><p><span><?=timeCompute($item->created_time);?></span> 标题：
                                <a href="/forum/article/detail/{{ item.articleInfo.id }}"
                                   target="_blank">{{ item.articleInfo.title }}</a>
                            </p>
                            <div class="home-dacontent">{{ item.content }}</div>
                        </li>
                    {% endfor %}
                    <?php if(count($replyList) <= 0){?>
                    <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i
                                style="font-size:14px;">这个人很懒，没有任何回复</i></div>
                    <?php }?>
                </ul>
            </div>
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