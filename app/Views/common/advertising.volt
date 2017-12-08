{% if status %}
    {% for index, item in advertsing %}
        <div class="fly-panel">
            <div class="fly-panel-title">
                <a href="{{ item.url ? item.url : 'javascript:;' }}" target="_blank">{{ item.title }}</a>
            </div>
            <div class="fly-panel-main" style="text-align: center">
                {{ item.desc }}
                {% if item.image %}
                    <img src="{{ item.image }}" width="220px" height="220px">
                {% endif %}
            </div>
        </div>
    {% endfor %}
{% endif %}