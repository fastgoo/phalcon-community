{% if status %}
    <dl class="fly-panel fly-list-one">
        <dt class="fly-panel-title">本周热门</dt>
        {% for index, item in hot_article %}
            <dd>
                <a href="/forum/article/detail/{{ item.id }}">{{ item.title }}</a>
                <span><i class="iconfont icon-pinglun1"></i> {{ item.reply_nums }}</span>
            </dd>
        {% endfor %}
        {% if hot_article.count() <= 0 %}
            <div class="fly-none">本周暂无热帖</div>
        {% endif %}
    </dl>
{% endif %}