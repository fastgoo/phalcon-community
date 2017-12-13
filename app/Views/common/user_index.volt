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
          <span>
          <?php echo timeCompute($reply->created_time) ;?></span>
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
