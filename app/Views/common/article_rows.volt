<ul class="fly-list">
    <?php $show_tags = $this->commonConfig->tags->toArray();?>
    {% for index, item in article_list %}
        <li>
            <a href="{{ this.url.get('/user/home/detail/') }}{{ item.articleUserInfo.id }}" class="fly-avatar">
                <img src="{{ item.articleUserInfo.head_img }}"
                     alt="{{ item.articleUserInfo.nickname }}">
            </a>
            <h2>
                <a class="layui-badge{{ item.tag }}">{{ show_tags[item.tag] }}</a>
                <a href="{{ this.url.get('/forum/article/detail/') }}{{ item.id }}">{{ item.title }}</a>
            </h2>
            <div class="fly-list-info">
                <a href="{{ this.url.get('/user/home/detail/') }}{{ item.articleUserInfo.id }}" link>
                    <cite>{{ item.articleUserInfo.nickname }}</cite>
                    {% if item.articleUserInfo.verify_type %}
                        <i class="iconfont icon-renzheng" title="认证信息：{{ item.articleUserInfo.verify_type }}"></i>
                    {% endif %}
                    <?php if(!empty($verify_title[$item->articleUserInfo->verify_type])){?>
                    <i class="layui-badge fly-badge-vip">{{ verify_title[item.articleUserInfo.verify_type] }}</i>
                    <?php }else{?>
                    <i class="layui-badge fly-badge-vip" style="background-color: #1E9FFF">会员</i>
                    <?php }?>
                </a>
                <span>发布于: <?php echo timeCompute($item->created_time) ;?></span>

                <span class="fly-list-kiss layui-hide-xs" title="查看数量" style="color: #999">
                    <i class="iconfont" title="人气">&#xe60b;</i> {{ item.view_nums }}
                </span>
                <span class="fly-list-nums">
                    <i class="iconfont icon-pinglun1" title="回答"></i> {{ item.reply_nums }}
                </span>
            </div>
            <div class="fly-list-badge">
                {% if item.is_top %}
                    <span class="layui-badge layui-bg-orange">置顶</span>
                {% endif %}
                {% if item.is_essence %}
                    <span class="layui-badge layui-bg-red">精华</span>
                {% endif %}
            </div>
        </li>
    {% endfor %}
</ul>