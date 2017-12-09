{% if status %}
    <div class="fly-panel">

        <div class="fly-home fly-panel">
            <img src="{{ article.articleUserInfo.head_img }}">
            <i class="iconfont icon-renzheng" title="认证信息：{{ article.articleUserInfo.verify_type }}"></i>
            <h3 style="margin-top: 10px;">
                {{ article.articleUserInfo.nickname }}
                <i class="layui-badge fly-badge-vip">VIP3</i></h3>
            <p class="fly-home-info" style="margin-top: 10px;">
                <i class="iconfont icon-shijian"></i>
                <span>{{ date("Y-m-d",article.articleUserInfo.created_time) }} 加入</span>
                <i class="iconfont icon-chengshi"></i><span>来自中国 {{ article.articleUserInfo.city }}</span>
            </p>
            <p class="fly-home-sign">{{ article.articleUserInfo.sign ? article.articleUserInfo.sign : '（这个人懒得留下签名）' }}</p>
        </div>
        <ul class="fly-panel-main fly-list-static" style="text-align: center">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layui-btn-radius layui-btn-primary" id="attention_user"
                        data-user_id="{{ article.user_id }}">关注用户
                </button>
                <button class="layui-btn layui-btn-radius layui-btn-primary" id="collection_article"
                        data-article_id="{{ article.id }}">收藏文章
                </button>
            </div>
        </ul>
    </div>
{% endif %}