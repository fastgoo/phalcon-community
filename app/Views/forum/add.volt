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


<div class="layui-container fly-marginTop" style="padding-top: 20px;">
    <div class="fly-panel" pad20 style="padding-top: 5px;">
        <!--<div class="fly-none">没有权限</div>-->
        <div class="layui-form layui-form-pane">
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title">
                    <li class="layui-this">发表新帖<!-- 编辑帖子 --></li>
                </ul>
                <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                    <div class="layui-tab-item layui-show">
                        <form action="/forum/article/save" method="post">
                            <div class="layui-row layui-col-space15 layui-form-item">
                                <div class="layui-col-md3">
                                    <label class="layui-form-label">所在专栏</label>
                                    <div class="layui-input-block">
                                        <select lay-verify="required" name="tag" lay-filter="column">
                                            {% for index, item in tags %}
                                                <option value="{{ index }}">{{ item }}</option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-col-md9">
                                    <label for="L_title" class="layui-form-label">标题</label>
                                    <div class="layui-input-block">
                                        <input type="text" id="L_title" name="title" required lay-verify="required"
                                               autocomplete="off" class="layui-input">
                                        <!-- <input type="hidden" name="id" value="{{ d.edit.id }}"> -->
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item layui-form-text">
                                <div class="layui-input-block">
                        <textarea id="L_content" name="content" required lay-verify="required" placeholder="请输入内容"
                                  class="layui-textarea fly-editor" style="height: 150px;"></textarea>
                                </div>
                            </div>
                            {#<div class="layui-form-item">#}
                            {#<div class="layui-inline">#}
                            {#<label class="layui-form-label">悬赏飞吻</label>#}
                            {#<div class="layui-input-inline" style="width: 190px;">#}
                            {#<select name="experience">#}
                            {#<option value="20">20</option>#}
                            {#<option value="30">30</option>#}
                            {#<option value="50">50</option>#}
                            {#<option value="60">60</option>#}
                            {#<option value="80">80</option>#}
                            {#</select>#}
                            {#</div>#}
                            {#<div class="layui-form-mid layui-word-aux">发表后无法更改飞吻</div>#}
                            {#</div>#}
                            {#</div>#}
                            <div class="layui-form-item">
                                <label for="L_vercode" class="layui-form-label">答案验证</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="L_vercode" name="verify_answer" required
                                           lay-verify="required"
                                           placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid">
                                    <span style="color: #c00;">{{ verify_question }}</span>
                                </div>
                            </div>
                            <input type="hidden" id="securityToken" name="{{ this.security.getTokenKey() }}"
                                   value="{{ this.security.getToken() }}"/>
                            <div class="layui-form-item">
                                <button class="layui-btn" lay-filter="article-publish" lay-submit>立即发布</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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