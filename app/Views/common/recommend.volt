{% if status %}
    <div class="fly-panel">
        <h3 class="fly-panel-title">推荐资源</h3>
        <ul class="fly-panel-main fly-list-static">
            {% for index, item in recommend_resource %}
                <li data-id="{{ item.id }}">
                    <a href="{{ item.url }}" target="_blank">{{ item.title }}</a>
                </li>
            {% endfor %}
        </ul>
    </div>
{% endif %}