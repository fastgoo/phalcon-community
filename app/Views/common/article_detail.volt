<div class="layui-col-md8 content detail">
    <div class="fly-panel detail-box">
        <h1>{{ article.title }}</h1>
        <div class="fly-detail-info">
            <!-- <span class="layui-badge">审核中</span> -->
            {% if article.tag_name == '求助' %}
                {% if article.adoption_reply_id %}
                    <span class="layui-badge" style="background-color: #529942;">已解决</span>
                {% else %}
                    <span class="layui-badge" style="background-color: #999;">未解决</span>
                {% endif %}
            {% else %}
                <span class="layui-badge layui-bg-green fly-detail-column">{{ article.tag_name }}</span>
            {% endif %}

            {% if article.is_top %}
                <span class="layui-badge layui-bg-black">置顶</span>
            {% endif %}
            {% if article.is_essence %}
                <span class="layui-badge layui-bg-red">精帖</span>
            {% endif %}

            {#<div class="fly-admin-box" data-id="{{ article.id }}">
                <span class="layui-btn layui-btn-xs jie-admin" type="del">删除</span>

                <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="1">置顶</span>
                <!-- <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="0" style="background-color:#ccc;">取消置顶</span> -->

                <span class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="1">加精</span>
                <!-- <span class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="0" style="background-color:#ccc;">取消加精</span> -->
            </div>#}

            <span class="fly-list-nums">
            <a href="#comment"><i class="iconfont" title="回答">&#xe60c;</i> {{ article.reply_nums }}</a>
            <i class="iconfont" title="人气">&#xe60b;</i> {{ article.view_nums }}
          </span>
        </div>
        <div class="detail-about">
            <a class="fly-avatar" href="/user/home/detail/{{ article.userInfo.id }}">
                <img src="{{ article.articleUserInfo.head_img }}" alt="{{ article.articleUserInfo.nickname }}">
            </a>
            <div class="fly-detail-user">
                <a href="/user/home/detail/{{ article.articleUserInfo.id }}" class="fly-link">
                    <cite>{{ article.articleUserInfo.nickname }}</cite>
                    <i class="iconfont icon-renzheng" title="认证信息：{{ article.articleUserInfo.verify_type }}"></i>
                    <i class="layui-badge fly-badge-vip">VIP3</i>
                </a>
                <span>发布于：{{ article.format_time }}</span>
            </div>
            <div class="detail-hits" id="LAY_jieAdmin" data-id="123">
                <span style="padding-right: 10px; color: #FF7200">悬赏：60飞吻</span>
                <span class="layui-btn layui-btn-xs jie-admin" type="edit"><a href="add.html">编辑此贴</a></span>
            </div>
        </div>
        <div class="detail-body">
            {{ article.content }}
        </div>
    </div>

    <div class="fly-panel detail-box" id="flyReply">
        <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
            <legend>回帖</legend>
        </fieldset>
        <ul class="jieda" id="jieda">
            {% if reply.count() > 0 %}
                {% for index, item in reply %}

                    <li id="hash-{{ item.id }}" class="jieda-daan">
                        <a name="item-{{ item.created_time }}"></a>
                        <div class="detail-about detail-about-reply">
                            <a class="fly-avatar">
                                <img src="{{ item.userInfo.head_img }}">
                            </a>
                            <div class="fly-detail-user">
                                <a href="" class="fly-link">
                                    <cite>{{ item.userInfo.nickname }}</cite>
                                    {% if item.userInfo.verify_type %}
                                        <i class="iconfont icon-renzheng"
                                           title="认证信息：{{ item.userInfo.verify_type }}"></i>
                                    {% endif %}
                                    <i class="layui-badge fly-badge-vip">VIP3</i>
                                </a>
                                {% if item.userInfo.id == article.user_id %}
                                    <span>(楼主)</span>
                                {% endif %}

                                {#<span style="color:#5FB878">(管理员)</span>
                                <span style="color:#FF9E3F">（社区之光）</span>
                                <span style="color:#999">（该号已被封）</span>#}

                            </div>

                            <div class="detail-hits">
                                <span><?=timeCompute($item->created_time);?></span>
                            </div>
                            {% if item.is_adoption %}
                                <i class="iconfont icon-caina" title="最佳答案"></i>
                            {% endif %}
                        </div>
                        <div class="detail-body jieda-body photos">
                            {{ item.content }}
                        </div>
                        <?php $has_zan = \App\Models\ForumArticleReplyPraise::findFirst(["conditions" => "user_id =
                        :user_id:
                        AND reply_id = :reply_id:","bind" => ['user_id' => $local_user['id'],'reply_id' =>
                        $item->id]]);?>
                        <div class="jieda-reply">
                      <span class="jieda-zan<?php echo !empty($has_zan->id) ? ' zanok' : '' ;?>" type="zan"
                            data-status="<?php echo !empty($has_zan->id) ? 1 : 0 ;?>" data-id="{{ item.id }}">
                        <i class="iconfont icon-zan"></i>
                            <em>{{ item.praise_nums }}</em>
                      </span>
                            {% if item.userInfo.id != local_user['id'] %}
                            <span type="reply" class="_reply" data-id="{{ item.id }}"
                                  data-nickname="{{ item.userInfo.nickname }}" data-user_id="{{ item.userInfo.id }}">
                        <i class="iconfont icon-svgmoban53"></i>回复
                                {% endif %}
                    </span>
                            <div class="jieda-admin">
                                <?php  if($article->tag_name == '求助' && !$article->adoption_reply_id &&
                                $article->user_id == $local_user['id']){?>
                                <span class="jieda-accept" type="accept" data-id="{{ item.id }}">采纳</span>
                                <?php }?>
                                {#<span type="edit">编辑</span>#}
                                {#<span type="del">删除</span>#}
                                <!-- <span class="jieda-accept" type="accept">采纳</span> -->
                            </div>
                        </div>
                    </li>
                {% endfor %}
            {% else %}
                <li class="fly-none">消灭零回复</li>
            {% endif %}
        </ul>
        {{ partial("common/pagination",['status': true]) }}

        <div class="layui-form layui-form-pane">
            <form action="/forum/reply/save" method="post">
                <input type="hidden" name="article_id" value="{{ article.id }}">
                <div class="layui-form-item layui-form-text">
                    <a name="comment"></a>
                    <div class="layui-input-block">
                        <textarea id="L_content" name="html_content" required lay-verify="required" placeholder="请输入内容"
                                  class="layui-textarea fly-editor" style="height: 150px;"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn" lay-filter="reply" lay-submit alert="回复成功">提交回复</button>
                </div>
            </form>
        </div>
    </div>
</div>