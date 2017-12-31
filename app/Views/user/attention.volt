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
            <input value="{{ dynamic_nums }}" type="hidden" id="dynamic_nums"/>
            <input value="{{ attention_nums }}" type="hidden" id="attention_nums"/>
            <ul class="layui-tab-title" id="LAY_mine">
                <li data-type="mine-jie" lay-id="index" class="layui-this">
                    关注动态
                </li>
                <li data-type="collection" lay-id="collection">
                    关注用户
                </li>
            </ul>
            <div class="layui-tab-content" style="">
                <div class="layui-tab-item layui-show">
                    <ul class="fly-list my-article">

                    </ul>
                    <div id="LAY_page"></div>
                    <div style="text-align: center;margin-top: 20px;padding-bottom: 10px;">
                        <div id="article_dynamic_pagination"></div>
                    </div>
                </div>
                <div class="layui-tab-item">
                    <ul class="fly-list attention_user">

                    </ul>
                    <div id="LAY_page1"></div>
                    <div style="text-align: center;margin-top: 20px;padding-bottom: 10px;">
                        <div id="attention_user_pagination"></div>
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
            str += '<a href="/user/home/detail/' + data.user_id + '" class="fly-avatar"><img class="avatar" src="' + data.head_img + '" alt="周先生" height="20px;"></a>';
            str += '<div class="fly-list-info">';
            str += '<a href="/user/home/detail/' + data.user_id + '" link="">';
            str += '<cite>' + data.nickname + '</cite>';
            if (data.type_name) {
                str += '<i class="iconfont icon-renzheng" title="认证信息：' + data.type_name + '"></i>';
                str += '<i class="layui-badge fly-badge-vip">' + data.type_name + '</i>';
            }
            str += '</a></div>';
            str += '<span style="color: #9F9F9F">关注于：' + data.time + '</span>';
            str += '<div class="fly-list-badge">';
            str += '<button class="layui-btn layui-btn-radius layui-btn-primary cancel_attention" data-user_id="'+data.attention_user_id+'">取消关注</button>';
            str += '</div>';
            str += '</li>';
            return str;
        };

        var showTemplate = function (data) {
            console.log(data);
            var str = '<li>';
            str += '<a href="/user/home/detail/' + data.user_id + '" class="fly-avatar">';
            str += '<img src="' + data.head_img + '" alt="'+data.nickname+'"></a>';
            str += '<h2><a href="/forum/article/detail/' + data.id + '">' + data.title + '</a></h2>';
            str += '<div class="fly-list-info">';
            str += '<a href="/user/home/detail/' + data.user_id + '" link="">';
            str += '<cite>' + data.nickname + '</cite>';
            if (data.type_name) {
                str += '<i class="iconfont icon-renzheng" title="认证信息：' + data.type_name + '"></i>';
                str += '<i class="layui-badge fly-badge-vip">' + data.type_name + '</i>';
            }
            str += '</a>';
            str += '<span>发布于: ' + data.time + '</span>';
            str += '</div>';
            return str;
        };

        var request = {
            post: function (url, param, callback) {
                $.post(url, param ? param : {}, function (res) {
                    if (res.code == 1) {
                        callback(res.data);
                    }
                })
            }
        };

        $(document).on("click",'.cancel_attention',function () {
            var user_id = $(this).data('user_id');
            var that = $(this);
            request.post('/user/attention/setAttention',{user_id:user_id},function () {
                console.log(that.parent().parent());
                that.parent().parent().remove();
            })
        });

        layui.use('laypage', function () {
            var laypage = layui.laypage;
            laypage.render({
                elem: 'article_dynamic_pagination'
                , count: $("#dynamic_nums").val()
                , limit: $("#page_nums").val()
                , jump: function (obj) {
                    request.post('/user/attention/dynamic', {
                        current_page: obj.curr,
                        page_nums: obj.limit
                    }, function (data) {
                        var str = '';
                        for (var i = 0; i < data.rows.length; i++) {
                            str += showTemplate(data.rows[i]);
                        }
                        $(".my-article").html(str);
                    });
                }
            });
            laypage.render({
                elem: 'attention_user_pagination'
                , count: $("#attention_nums").val()
                , limit: $("#page_nums").val()
                , jump: function (obj) {
                    request.post('/user/attention/myAttentionList', {
                        type: 2,
                        current_page: obj.curr,
                        page_nums: obj.limit
                    }, function (data) {
                        var str = '';
                        for (var i = 0; i < data.rows.length; i++) {
                            str += showTemplate1(data.rows[i]);
                        }
                        $(".attention_user").html(str);
                    });
                }
            });
        });
    });
</script>
</body>
</html>