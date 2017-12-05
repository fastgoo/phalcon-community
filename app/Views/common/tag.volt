<div class="fly-panel-title fly-filter">
    {% for key, item in this.commonConfig.tag_list %}
        {% if key > 0 %}
            <span class="fly-mid"></span>
        {% endif %}
        <a href="<?= $key > 0 ? '/forum/home/index/'.$key : '/forum/home/index' ;?>"
           class="{{ choose_tag == key ? 'layui-this':'' }}">{{ item.name }}
            {% if item.has_new > 0 %}
                <span class="layui-badge-dot"></span>
            {% endif %}
        </a>
    {% endfor %}
</div>