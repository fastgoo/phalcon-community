<div style="text-align: center;margin-top: 20px;padding-bottom: 10px;">

    <input type="hidden" id="current_page" value="{{ pagination['current_page'] }}"/>
    <input type="hidden" id="page_count" value="{{ pagination['count'] }}"/>
    <input type="hidden" id="page_link" value="{{ pagination['link'] }}"/>
    {% if pagination['max_page'] > 1 %}
        <div id="pagination"></div>
    {% endif %}
</div>
