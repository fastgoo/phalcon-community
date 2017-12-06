<div class="fly-header layui-bg-black">
    <div class="layui-container">
        <a class="fly-logo" href="javascript:;">
            <img src="/app/images/logo.png" alt="layui" height="40">
        </a>
        <ul class="layui-nav fly-nav layui-hide-xs">
            {% for key, item in this.commonConfig.header_title %}
                <li class="layui-nav-item {{ header_choose_type == key?'layui-this':'' }}">
                    <a href="{{ item.url }}"><i class="layui-icon">{{ item.icon }}</i>{{ item.title }}</a>
                </li>
            {% endfor %}
        </ul>
        <ul class="layui-nav fly-nav-user">
            <!-- 登入后的状态 -->
            {% if local_user %}
                <li class="layui-nav-item">
                    <a class="fly-nav-avatar" href="javascript:;">
                        <cite class="layui-hide-xs">{{ local_user['nickname'] }}</cite>
                        {% if local_user['verify_type'] %}
                            <i class="iconfont icon-renzheng layui-hide-xs" title="认证信息：layui 作者"></i>
                        {% endif %}
                        {#{% if local_user['vip'] > 0 %}
                            <i class="layui-badge fly-badge-vip layui-hide-xs">{{ local_user['title'] }}</i>
                        {% endif %}#}
                        <img src="{{ local_user['head_img'] }}">
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="user/set.html"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
                        <dd><a href="user/message.html"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a>
                        </dd>
                        <dd><a href="user/home.html"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a>
                        </dd>
                        <hr style="margin: 5px 0;">
                        <dd><a href="/user/logout/" style="text-align: center;">退出</a></dd>
                    </dl>
                </li>
            {% else %}
                <li class="layui-nav-item">
                    <a href="javascript:" class="login-header">登录 / 注册</a>
                </li>
            {% endif %}
        </ul>
    </div>
</div>