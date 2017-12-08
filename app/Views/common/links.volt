{% if status %}
    <div class="fly-panel fly-link">
        <h3 class="fly-panel-title"><a href="javascript:;">友情链接</a></h3>
        <dl class="fly-panel-main" style="text-align: center">
            {% for index, item in coop_link %}
            <dd style="width: 80%;padding: 5px;">
                <a href="{{ item.url }}" target="_blank">{{ item.name }}</a>
            <dd>
            {% endfor %}
        </dl>
    </div>
{% endif %}