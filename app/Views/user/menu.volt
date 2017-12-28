<ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
    <li class="layui-nav-item">
        <a href="/user/home/detail/{{ local_user['id'] }}"> <i class="layui-icon"></i> 个人主页</a>
    </li>
    <li class="layui-nav-item{{ user_menu_choose == "set_info" ? ' layui-this' : '' }}">
        <a href="{{ user_menu_choose != "set_info" ? '/user/my/index' : 'javascript:' }}"> <i class="layui-icon"></i> 基本资料 </a>
    </li>
    <li class="layui-nav-item{{ user_menu_choose == "message" ? ' layui-this' : '' }}">
        <a href="{{ user_menu_choose != "message" ? '/user/my/message' : 'javascript:' }}"> <i class="layui-icon"></i> 我的消息 </a>
    </li>
    <li class="layui-nav-item{{ user_menu_choose == "article" ? ' layui-this' : '' }}">
        <a href="{{ user_menu_choose != "article" ? '/user/my/article' : 'javascript:' }}"> <i class="layui-icon">&#xe609;</i> 我的文章 </a>
    </li>
    <li class="layui-nav-item{{ user_menu_choose == "attention" ? ' layui-this' : '' }}">
        <a href="{{ user_menu_choose != "attention" ? '/user/my/attention' : 'javascript:' }}"> <i class="layui-icon">&#xe658;</i> 我的关注 </a>
    </li>
    <span class="layui-nav-bar" style="top: 167.5px; height: 0px; opacity: 0;"></span>
</ul>