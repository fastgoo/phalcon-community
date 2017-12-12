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
  <img src="{{ user.head_img }}" alt="{{ user.nickname }}">
  <i class="iconfont icon-renzheng" title="Fly社区认证"></i>
  <h1>
    {{ user.nickname }}
    {% if user.sex %}
    	<i class="iconfont icon-nv"></i>
    {% else %}
    	<i class="iconfont icon-nan"></i>
    {% endif %}
  </h1>
  <p class="fly-home-info">
    <i class="iconfont icon-kiss" title="飞吻"></i><span style="color: #FF7200;">66666 飞吻</span>
    <i class="iconfont icon-shijian"></i><span>{{ date('Y-m-d', user.created_time) }}加入</span>
    <i class="iconfont icon-chengshi"></i><span>来自{{ user.city }}</span>
  </p>
  <p class="fly-home-sign">（{{ user.sign }}）</p>
</div>
<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md6 fly-home-jie">
      <div class="fly-panel">
        <h3 class="fly-panel-title">{{ user.nickname }} 最近的提问</h3>
        <ul class="jie-row">
        {% for name, value in user_aricles %}
          <li>
          <a href="{{ this.url.get('/forum/article/detail/') }}{{ value.id }}"  class="jie-title">
            {{ value.title }}
           </a>
            <i><?php echo timeCompute($value->created_time) ;?></i>
            <em class="layui-hide-xs">{{ value.view_nums }}阅/{{  value.reply_nums }}答</em>
          </li>
          {% endfor %}
        </ul>
      </div>
    </div>
    <div class="layui-col-md6 fly-home-da">
      <div class="fly-panel">
        <h3 class="fly-panel-title">{{ user.nickname }} 最近的回答</h3>
        <ul class="home-jieda">
		{% for name, reply in replys %}
        <li>
          <p>
          <span><?php echo timeCompute($reply->created_time) ;?></span>
        		  在<a href="{{ this.url.get('/forum/article/detail/') }}{{ reply.id }}" target="_blank">{{ reply.title }}</a>中回答：
          </p>
          <div class="home-dacontent">
            {{ reply.content }}
          </div>
        </li>
        {% endfor %}
          <!-- <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><span>没有回答任何问题</span></div> -->
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