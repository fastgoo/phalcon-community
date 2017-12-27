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
        <div class="layui-tab layui-tab-brief" lay-filter="user">
            <ul class="layui-tab-title" id="LAY_mine">
                <li class="layui-this" lay-id="info">我的资料</li>
                <li lay-id="avatar" class="">头像</li>
                <li lay-id="email" class="">邮箱认证</li>
            </ul>
            <div class="layui-tab-content" style="padding: 20px 0;">
                <div class="layui-form layui-form-pane layui-tab-item layui-show">
                    <form method="post" action="/user/my/setInfo" onsubmit="return false">
                        <div class="layui-form-item"><label for="L_username" class="layui-form-label">昵称</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_username" name="username"
                                       required="" lay-verify="required" autocomplete="off"
                                       value="{{ user.nickname }}" class="layui-input"></div>
                        </div>
                        <div class="layui-form-item"><label for="L_city" class="layui-form-label">城市</label>
                            <div class="layui-input-inline"><input type="text" id="L_city" name="city"
                                                                   autocomplete="off" value="{{ user.city }}" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item"><label for="L_sex" class="layui-form-label">性别</label>
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="radio" name="sex" value="0" {{ user.sex == 0 ? 'checked' : '' }} title="男">
                                    <div class="layui-unselect layui-form-radio {{ user.sex == 0 ? 'layui-form-radioed' : '' }}">
                                        <i class="layui-anim layui-icon"></i>
                                        <div>男</div>
                                    </div>
                                    <input type="radio" name="sex" value="1" {{ user.sex == 1 ? 'checked' : '' }} title="女">
                                    <div class="layui-unselect layui-form-radio {{ user.sex == 1 ? 'layui-form-radioed' : '' }}">
                                        <i class="layui-anim layui-icon"></i>
                                        <div>女</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text" style="width: 100%;">
                            <label for="L_sign" class="layui-form-label">签名</label>
                            <div class="layui-input-block">
                                <textarea placeholder="随便写些什么刷下存在感" id="L_sign" name="sign" autocomplete="off" class="layui-textarea" style="height: 150px;">{{ user.sign }}</textarea></div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn" id="set_userinfo" lay-filter="set_userinfo" lay-submit="" >确认修改</button>
                        </div>
                    </form>
                </div>
                <div class="layui-form layui-form-pane layui-tab-item">
                    <div class="layui-form-item">
                        <div class="avatar-add">
                            <button type="button" class="layui-btn upload-img"><i class="layui-icon"></i>上传头像</button>
                            <input class="layui-upload-file" type="file" name="file">
                            <img id="user_avatar" src="{{ user.head_img }}">
                            <span class="loading"></span></div>
                    </div>
                </div>
                <div class="layui-form layui-form-pane layui-tab-item">
                    <form method="post" action="/user/email/emailCheck" onsubmit="return false">
                        <div class="layui-form-item"><label for="L_email" class="layui-form-label">邮箱</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_email" name="email" required="" lay-verify="email"
                                       autocomplete="off" value="{{ user.email }}" class="layui-input"></div>
                            <div class="layui-form-mid layui-word-aux">
                                &nbsp;&nbsp;&nbsp;<a href="javascript:" style="font-size: 12px; color: #4f99cf;" id="send_email_code">发送验证码</a>
                            </div>
                        </div>
                        <div class="layui-form-item"><label for="L_code" class="layui-form-label">验证码</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_code" name="code" required="" autocomplete="off" value=""
                                       class="layui-input"></div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn" id="set_user_email" lay-filter="set_user_email" lay-submit="">保存</button>
                        </div>
                    </form>
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