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