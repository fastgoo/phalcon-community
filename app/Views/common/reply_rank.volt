{% if status %}
    <?php if(count($reply_rank) <= 0){?>
    <dl class="fly-panel fly-list-one">
        <dt class="fly-panel-title">活跃榜</dt>
        <div class="fly-none">大家好像都不是很活跃</div>
    </dl>
    <?php }else{?>
    <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
        <h3 class="fly-panel-title">活跃榜</h3>
        <dl>
            {% for index, item in reply_rank %}
                <dd>
                    <a href="/user/home/detail/{{ item['userInfo']['id'] }}">
                        <img src="{{ item['userInfo']['head_img'] }}">
                        <cite>{{ item['userInfo']['nickname'] }}</cite>
                        <i>{{ item['reply_nums'] }}次回答</i>
                    </a>
                </dd>
            {% endfor %}
        </dl>
    </div>
    <?php }?>
{% endif %}