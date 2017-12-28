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
        <input type="hidden" id="page_nums" value="15"/>
        <div class="layui-tab layui-tab-brief" lay-filter="user">
            <ul class="layui-tab-title" id="LAY_mine">
                <li data-type="mine-jie" lay-id="index" class="layui-this">
                    关注动态
                </li>
                <li data-type="collection" data-url="/collection/find/" lay-id="collection">
                    关注用户
                </li>
            </ul>
            <div class="layui-tab-content" style="">
                <div class="layui-tab-item layui-show">
                    <ul class="fly-list my-article">
                        <li><a href="http://robot.test.com/user/home/detail/11" class="fly-avatar"> <img
                                        src="https://resource.fastgoo.net/201712271700178747.gif" alt="周先生"> </a>
                            <h2><a href="http://robot.test.com/forum/article/detail/1">phalcon中文社区开源项目大佬征集</a>
                            </h2>
                            <div class="fly-list-info">
                                <a href="http://robot.test.com/user/home/detail/11" link="">
                                    <cite>周先生</cite>
                                    <i class="iconfont icon-renzheng" title="认证信息：110"></i>
                                    <i class="layui-badge fly-badge-vip">管理员</i>
                                </a>
                                <span>发布于: 17天前</span>
                            </div>
                        </li>
                    </ul>
                    <div id="LAY_page"></div>
                    <div style="text-align: center;margin-top: 20px;padding-bottom: 10px;">
                        <div id="my_article_pagination"></div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <ul class="fly-list my-collection">
                        <li>
                            <a href="http://robot.test.com/user/home/detail/11" class="fly-avatar">
                                <img class="avatar" src="https://resource.fastgoo.net/201712271700178747.gif" alt="周先生"
                                     height="20px;">
                            </a>
                            <div class="fly-list-info">
                                <a href="http://robot.test.com/user/home/detail/11" link="">
                                    <cite>周先生</cite>
                                    <i class="iconfont icon-renzheng" title="认证信息：110"></i>
                                    <i class="layui-badge fly-badge-vip">管理员</i>
                                </a>
                            </div>
                            <span style="color: #9F9F9F">关注于：12天前</span>
                            <div class="fly-list-badge">
                                <button class="layui-btn layui-btn-radius layui-btn-primary">取消关注</button>
                            </div>
                        </li>
                        <li>
                            <a href="http://robot.test.com/user/home/detail/11" class="fly-avatar">
                                <img class="avatar" src="https://resource.fastgoo.net/201712271700178747.gif" alt="周先生"
                                     height="20px;">
                            </a>
                            <div class="fly-list-info">
                                <a href="http://robot.test.com/user/home/detail/11" link="">
                                    <cite>周先生</cite>
                                    <i class="iconfont icon-renzheng" title="认证信息：110"></i>
                                    <i class="layui-badge fly-badge-vip">管理员</i>
                                </a>
                            </div>
                            <span style="color: #9F9F9F">关注于：12天前</span>
                            <div class="fly-list-badge">
                                <button class="layui-btn layui-btn-radius layui-btn-primary">取消关注</button>
                            </div>
                        </li>
                        <li>
                            <a href="http://robot.test.com/user/home/detail/11" class="fly-avatar">
                                <img class="avatar" src="https://resource.fastgoo.net/201712271700178747.gif" alt="周先生"
                                     height="20px;">
                            </a>
                            <div class="fly-list-info">
                                <a href="http://robot.test.com/user/home/detail/11" link="">
                                    <cite>周先生</cite>
                                    <i class="iconfont icon-renzheng" title="认证信息：110"></i>
                                    <i class="layui-badge fly-badge-vip">管理员</i>
                                </a>
                            </div>
                            <span style="color: #9F9F9F">关注于：12天前</span>
                            <div class="fly-list-badge">
                                <button class="layui-btn layui-btn-radius layui-btn-primary">取消关注</button>
                            </div>
                        </li>
                    </ul>
                    <div id="LAY_page1"></div>
                    <div style="text-align: center;margin-top: 20px;padding-bottom: 10px;">
                        <div id="my_collection_pagination"></div>
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
<script>
    var $ = layui.jquery;
    $(function () {
        var showTemplate1 = function (data) {
            var str = '<li>';
            if (data.articleInfo.is_top == 1) {
                str += '<span class="layui-badge layui-bg-orange">顶</span>';
            }
            if (data.articleInfo.is_essence == 1) {
                str += '<span class="layui-badge layui-bg-red">精</span>';
            }
            str += '<span class="layui-badge layui-bg-cyan">' + data.tag_name + '</span>';
            str += '<a class="jie-title" href="/forum/article/detail/' + data.articleInfo.id + '" target="_blank">' + data.articleInfo.title + '</a>';
            str += '<i>收藏于 ' + data.time + '</i>';
            str += '</li>';
            return str;
        };

        var showTemplate = function (data) {
            console.log(data);
            var str = '<li>';
            if (data.is_top == 1) {
                str += '<span class="layui-badge layui-bg-orange">顶</span>';
            }
            if (data.is_essence == 1) {
                str += '<span class="layui-badge layui-bg-red">精</span>';
            }
            str += '<span class="layui-badge layui-bg-cyan">' + data.tag_name + '</span>';
            str += '<a class="jie-title" href="/forum/article/detail/' + data.id + '" target="_blank">' + data.title + '</a>';
            str += '<i>' + data.created_time + '</i>';
            str += '<a class="mine-edit" href="/forum/article/edit/' + data.id + '">编辑</a>';
            str += '<a class="mine-delete delete-article" href="javascript:" data-id="' + data.id + '">删除</a>';
            str += '<em class="layui-hide-xs">';
            str += '<i class="layui-icon" title="人气" style="font-size: 18px; color: #ff1813;">&#xe756;</i>' + data.view_nums + ' &nbsp;';
            str += '<i class="layui-icon" title="回答" style="font-size: 18px; color: #1E9FFF;">&#xe63a;</i>' + data.reply_nums;
            str += '</em>';
            str += '</li>';
            return str;
        };

        var request = {
            post: function (param, callback) {
                $.post('/user/article/getMyData', param ? param : {}, function (res) {
                    if (res.code == 1) {
                        callback(res.data);
                    }
                })
            }
        };

        layui.use('laypage', function () {
            var laypage = layui.laypage;
            laypage.render({
                elem: 'my_article_pagination'
                , count: $("#article_nums").text()
                , limit: $("#page_nums").val()
                , jump: function (obj) {
                    request.post({
                        type: 1,
                        current_page: obj.curr,
                        page_nums: obj.limit
                    }, function (data) {
                        var str = '';
                        for (var i = 0; i < data.rows.length; i++) {
                            str += showTemplate(data.rows[i]);
                        }
                        {#$(".my-article").html(str);#}
                    });
                }
            });
            laypage.render({
                elem: 'my_collection_pagination'
                , count: $("#collection_nums").text()
                , limit: $("#page_nums").val()
                , jump: function (obj) {
                    request.post({
                        type: 2,
                        current_page: obj.curr,
                        page_nums: obj.limit
                    }, function (data) {
                        var str = '';
                        for (var i = 0; i < data.rows.length; i++) {
                            str += showTemplate1(data.rows[i]);
                        }
                        {# $(".my-collection").html(str); #}
                    });
                }
            });
        });
    });
</script>
</body>
</html>