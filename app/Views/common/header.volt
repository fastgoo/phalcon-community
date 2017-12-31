<div class="fly-header layui-bg-black">
    <div class="layui-container">
        <a class="fly-logo" href="/forum/home/index">
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
            <li class="layui-nav-item layui-hide-xs" style="margin-right: 50px;margin-top: 5px;">
                <span class="fly-search"><i class="layui-icon"></i></span>
            </li>
            <input type="hidden" value="{{ local_user ? 1 : 0 }}" id="local_user"/>
            <input type="hidden" value="{{ login_type }}" id="set_login_type"/>
            <!-- 登入后的状态 -->
            {% if local_user %}
                <li class="layui-nav-item">
                    <a class="fly-nav-avatar" href="javascript:;">
                        <cite class="layui-hide-xs">{{ local_user['nickname'] }}</cite>
                        {% if local_user['verify_type'] %}
                            <i class="iconfont icon-renzheng layui-hide-xs"
                               title="认证信息：{{ verify_title[local_user['verify_type']] }}"></i>
                        {% endif %}
                        {#<?php if(!empty($verify_title[$local_user['verify_type']])){?>
                        <i class="layui-badge fly-badge-vip layui-hide-xs">{{ verify_title[local_user['verify_type']] }}</i>
                        <?php }?>#}
                        <img src="{{ local_user['head_img'] }}">
                        {% if is_has_new_msg > 0 %}
                            <span class="layui-badge-dot" style="position: relative; top: -10px; left: -7px;"></span>
                        {% endif %}
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="/forum/article/add"><i class="layui-icon">&#xe642;</i>发布文章</a></dd>
                        <dd><a href="/user/my/index"><i class="layui-icon">&#xe620;</i>个人中心</a></dd>
                        <dd><a href="/user/my/message">
                                <i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息
                                {% if is_has_new_msg > 0 %}
                                    <span class="layui-badge-dot"
                                          style="position: relative; top: -1px; left: -5px;"></span>
                                {% endif %}
                            </a>
                        </dd>
                        <hr style="margin: 5px 0;">
                        <dd><a id="loginout" style="text-align: center;">退出</a></dd>
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