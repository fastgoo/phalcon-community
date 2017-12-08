/**

 @Name: Fly社区主入口

 */


layui.define(['layer', 'laytpl', 'form', 'element', 'upload', 'util'], function (exports) {

    var $ = layui.jquery
        , layer = layui.layer
        , laytpl = layui.laytpl
        , form = layui.form
        , element = layui.element
        , upload = layui.upload
        , util = layui.util
        , device = layui.device()

        , DISABLED = 'layui-btn-disabled';
    //阻止IE7以下访问
    if (device.ie && device.ie < 8) {
        layer.alert('如果您非得使用 IE 浏览器访问Fly社区，那么请使用 IE8+');
    }

    layui.focusInsert = function (obj, str) {
        var result, val = obj.value;
        obj.focus();
        if (document.selection) { //ie
            result = document.selection.createRange();
            document.selection.empty();
            result.text = str;
        } else {
            result = [val.substring(0, obj.selectionStart), str, val.substr(obj.selectionEnd)];
            obj.focus();
            obj.value = result.join('');
        }
    };


    //数字前置补零
    layui.laytpl.digit = function (num, length, end) {
        var str = '';
        num = String(num);
        length = length || 2;
        for (var i = num.length; i < length; i++) {
            str += '0';
        }
        return num < Math.pow(10, length) ? str + (num | 0) : num;
    };

    var fly = {

        //Ajax
        json: function (url, data, success, options) {
            var that = this, type = typeof data === 'function';

            if (type) {
                options = success
                success = data;
                data = {};
            }

            options = options || {};

            return $.ajax({
                type: options.type || 'post',
                dataType: options.dataType || 'json',
                data: data,
                url: url,
                success: function (res) {
                    if (res.code === 1) {
                        success && success(res);
                    } else if (res.code === -401) {
                        $('.login-header').click();
                    } else {
                        layer.msg(res.msg || res.code, {shift: 6});
                        options.error && options.error();
                    }
                }, error: function (e) {
                    layer.msg('请求异常，请重试', {shift: 6});
                    options.error && options.error(e);
                }
            });
        }

        //计算字符长度
        , charLen: function (val) {
            var arr = val.split(''), len = 0;
            for (var i = 0; i < val.length; i++) {
                arr[i].charCodeAt(0) < 299 ? len++ : len += 2;
            }
            return len;
        }

        , form: {}

        //简易编辑器
        , layEditor: function (options) {
            var html = ['<div class="layui-unselect fly-edit">'
                , '<span type="face" title="插入表情"><i class="iconfont icon-yxj-expression" style="top: 1px;"></i></span>'
                , '<span type="picture" title="插入图片：img[src]"><i class="iconfont icon-tupian"></i></span>'
                , '<span type="href" title="超链接格式：a(href)[text]"><i class="iconfont icon-lianjie"></i></span>'
                , '<span type="code" title="插入代码或引用"><i class="iconfont icon-emwdaima" style="top: 1px;"></i></span>'
                , '<span type="hr" title="插入水平线">hr</span>'
                , '<span type="yulan" title="预览"><i class="iconfont icon-yulan1"></i></span>'
                , '</div>'].join('');

            var log = {}, mod = {
                face: function (editor, self) { //插入表情
                    var str = '', ul, face = fly.faces;
                    for (var key in face) {
                        str += '<li title="' + key + '"><img src="' + face[key] + '"></li>';
                    }
                    str = '<ul id="LAY-editface" class="layui-clear">' + str + '</ul>';
                    layer.tips(str, self, {
                        tips: 3
                        , time: 0
                        , skin: 'layui-edit-face'
                    });
                    $(document).on('click', function () {
                        layer.closeAll('tips');
                    });
                    $('#LAY-editface li').on('click', function () {
                        var title = $(this).attr('title') + ' ';
                        layui.focusInsert(editor[0], 'face' + title);
                    });
                }
                , picture: function (editor) { //插入图片
                    layer.open({
                        type: 1
                        , id: 'fly-jie-upload'
                        , title: '插入图片'
                        , area: 'auto'
                        , shade: false
                        , area: '465px'
                        , fixed: false
                        , offset: [
                            editor.offset().top - $(window).scrollTop() + 'px'
                            , editor.offset().left + 'px'
                        ]
                        , skin: 'layui-layer-border'
                        , content: ['<ul class="layui-form layui-form-pane" style="margin: 20px;">'
                            , '<li class="layui-form-item">'
                            , '<label class="layui-form-label">URL</label>'
                            , '<div class="layui-input-inline">'
                            , '<input required name="image" placeholder="支持直接粘贴远程图片地址" value="" class="layui-input">'
                            , '</div>'
                            , '<button type="button" class="layui-btn layui-btn-primary" id="uploadImg"><i class="layui-icon">&#xe67c;</i>上传图片</button>'
                            , '</li>'
                            , '<li class="layui-form-item" style="text-align: center;">'
                            , '<button type="button" lay-submit lay-filter="uploadImages" class="layui-btn">确认</button>'
                            , '</li>'
                            , '</ul>'].join('')
                        , success: function (layero, index) {
                            var image = layero.find('input[name="image"]');

                            //执行上传实例
                            upload.render({
                                elem: '#uploadImg'
                                , url: '/base.api/file/upload'
                                , size: 200
                                , done: function (res) {
                                    if (res.code == 1) {
                                        image.val(res.data.url);
                                    } else {
                                        layer.msg(res.msg, {icon: 5});
                                    }
                                }
                            });

                            form.on('submit(uploadImages)', function (data) {
                                var field = data.field;
                                if (!field.image) return image.focus();
                                layui.focusInsert(editor[0], 'img[' + field.image + '] ');
                                layer.close(index);
                            });
                        }
                    });
                }
                , href: function (editor) { //超链接
                    layer.prompt({
                        title: '请输入合法链接'
                        , shade: false
                        , fixed: false
                        , id: 'LAY_flyedit_href'
                        , offset: [
                            editor.offset().top - $(window).scrollTop() + 'px'
                            , editor.offset().left + 'px'
                        ]
                    }, function (val, index, elem) {
                        if (!/^http(s*):\/\/[\S]/.test(val)) {
                            layer.tips('这根本不是个链接，不要骗我。', elem, {tips: 1})
                            return;
                        }
                        layui.focusInsert(editor[0], ' a(' + val + ')[' + val + '] ');
                        layer.close(index);
                    });
                }
                , code: function (editor) { //插入代码
                    layer.prompt({
                        title: '请贴入代码或任意文本'
                        , formType: 2
                        , maxlength: 10000
                        , shade: false
                        , id: 'LAY_flyedit_code'
                        , area: ['800px', '360px']
                    }, function (val, index, elem) {
                        layui.focusInsert(editor[0], '[pre]\n' + val + '\n[/pre]');
                        layer.close(index);
                    });
                }
                , hr: function (editor) { //插入水平分割线
                    layui.focusInsert(editor[0], '[hr]');
                }
                , yulan: function (editor) { //预览
                    var content = editor.val();

                    content = /^\{html\}/.test(content)
                        ? content.replace(/^\{html\}/, '')
                        : fly.content(content);

                    layer.open({
                        type: 1
                        , title: '预览'
                        , shade: false
                        , area: ['100%', '100%']
                        , scrollbar: false
                        , content: '<div class="detail-body" style="margin:20px;">' + content + '</div>'
                    });
                }
            };

            layui.use('face', function (face) {
                options = options || {};
                fly.faces = face;
                $(options.elem).each(function (index) {
                    var that = this, othis = $(that), parent = othis.parent();
                    parent.prepend(html);
                    parent.find('.fly-edit span').on('click', function (event) {
                        var type = $(this).attr('type');
                        mod[type].call(that, othis, this);
                        if (type === 'face') {
                            event.stopPropagation()
                        }
                    });
                });
            });

        }

        , escape: function (html) {
            return String(html || '').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
                .replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&#39;').replace(/"/g, '&quot;');
        }

        //内容转义
        , content: function (content) {
            //支持的html标签
            var html = function (end) {
                return new RegExp('\\n*\\[' + (end || '') + '(pre|hr|div|span|p|table|thead|th|tbody|tr|td|ul|li|ol|li|dl|dt|dd|h2|h3|h4|h5)([\\s\\S]*?)\\]\\n*', 'g');
            };
            content = fly.escape(content || '') //XSS
                .replace(/img\[([^\s]+?)\]/g, function (img) {  //转义图片
                    return '<img src="' + img.replace(/(^img\[)|(\]$)/g, '') + '">';
                }).replace(/face\[([^\s\[\]]+?)\]/g, function (face) {  //转义表情
                    var alt = face.replace(/^face/g, '');
                    return '<img alt="' + alt + '" title="' + alt + '" src="' + fly.faces[alt] + '">';
                }).replace(/a\([\s\S]+?\)\[[\s\S]*?\]/g, function (str) { //转义链接
                    var href = (str.match(/a\(([\s\S]+?)\)\[/) || [])[1];
                    var text = (str.match(/\)\[([\s\S]*?)\]/) || [])[1];
                    if (!href) return str;
                    var rel = /^(http(s)*:\/\/)\b(?!(\w+\.)*(sentsin.com|layui.com))\b/.test(href.replace(/\s/g, ''));
                    return '<a href="' + href + '" target="_blank"' + (rel ? ' rel="nofollow"' : '') + '>' + (text || href) + '</a>';
                }).replace(html(), '\<$1 $2\>').replace(html('/'), '\</$1\>') //转移HTML代码
                .replace(/\n/g, '<br>') //转义换行
            return content;
        }

        //新消息通知
        , newmsg: function () {
            var elemUser = $('.fly-nav-user');
            if (layui.cache.user.uid !== -1 && elemUser[0]) {
                fly.json('/message/nums/', {
                    _: new Date().getTime()
                }, function (res) {
                    if (res.status === 0 && res.count > 0) {
                        var msg = $('<a class="fly-nav-msg" href="javascript:;">' + res.count + '</a>');
                        elemUser.append(msg);
                        msg.on('click', function () {
                            fly.json('/message/read', {}, function (res) {
                                if (res.status === 0) {
                                    location.href = '/user/message/';
                                }
                            });
                        });
                        layer.tips('你有 ' + res.count + ' 条未读消息', msg, {
                            tips: 3
                            , tipsMore: true
                            , fixed: true
                        });
                        msg.on('mouseenter', function () {
                            layer.closeAll('tips');
                        })
                    }
                });
            }
            return arguments.callee;
        }

    };

    //签到
    var tplSignin = ['{{# if(d.signed){ }}'
        , '<button class="layui-btn layui-btn-disabled">今日已签到</button>'
        , '<span>获得了<cite>{{ d.experience }}</cite>飞吻</span>'
        , '{{# } else { }}'
        , '<button class="layui-btn layui-btn-danger" id="LAY_signin">今日签到</button>'
        , '<span>可获得<cite>{{ d.experience }}</cite>飞吻</span>'
        , '{{# } }}'].join('')
        , tplSigninDay = '已连续签到<cite>{{ d.days }}</cite>天'

        , signRender = function (data) {
        laytpl(tplSignin).render(data, function (html) {
            elemSigninMain.html(html);
        });
        laytpl(tplSigninDay).render(data, function (html) {
            elemSigninDays.html(html);
        });
    }

        , elemSigninHelp = $('#LAY_signinHelp')
        , elemSigninTop = $('#LAY_signinTop')
        , elemSigninMain = $('.fly-signin-main')
        , elemSigninDays = $('.fly-signin-days');

    if (elemSigninMain[0]) {
        /*
         fly.json('/sign/status', function(res){
         if(!res.data) return;
         signRender.token = res.data.token;
         signRender(res.data);
         });
         */
    }
    $('body').on('click', '#LAY_signin', function () {
        var othis = $(this);
        if (othis.hasClass(DISABLED)) return;

        fly.json('/sign/in', {
            token: signRender.token || 1
        }, function (res) {
            signRender(res.data);
        }, {
            error: function () {
                othis.removeClass(DISABLED);
            }
        });

        othis.addClass(DISABLED);
    });

    //签到说明
    elemSigninHelp.on('click', function () {
        layer.open({
            type: 1
            , title: '签到说明'
            , area: '300px'
            , shade: 0.8
            , shadeClose: true
            , content: ['<div class="layui-text" style="padding: 20px;">'
                , '<blockquote class="layui-elem-quote">“签到”可获得社区飞吻，规则如下</blockquote>'
                , '<table class="layui-table">'
                , '<thead>'
                , '<tr><th>连续签到天数</th><th>每天可获飞吻</th></tr>'
                , '</thead>'
                , '<tbody>'
                , '<tr><td>＜5</td><td>5</td></tr>'
                , '<tr><td>≥5</td><td>10</td></tr>'
                , '<tr><td>≥15</td><td>15</td></tr>'
                , '<tr><td>≥30</td><td>20</td></tr>'
                , '</tbody>'
                , '</table>'
                , '<ul>'
                , '<li>中间若有间隔，则连续天数重新计算</li>'
                , '<li style="color: #FF5722;">不可利用程序自动签到，否则飞吻清零</li>'
                , '</ul>'
                , '</div>'].join('')
        });
    });

    //签到活跃榜
    var tplSigninTop = ['{{# layui.each(d.data, function(index, item){ }}'
        , '<li>'
        , '<a href="/u/{{item.uid}}" target="_blank">'
        , '<img src="{{item.user.avatar}}">'
        , '<cite class="fly-link">{{item.user.username}}</cite>'
        , '</a>'
        , '{{# var date = new Date(item.time); if(d.index < 2){ }}'
        , '<span class="fly-grey">签到于 {{ layui.laytpl.digit(date.getHours()) + ":" + layui.laytpl.digit(date.getMinutes()) + ":" + layui.laytpl.digit(date.getSeconds()) }}</span>'
        , '{{# } else { }}'
        , '<span class="fly-grey">已连续签到 <i>{{ item.days }}</i> 天</span>'
        , '{{# } }}'
        , '</li>'
        , '{{# }); }}'
        , '{{# if(d.data.length === 0) { }}'
        , '{{# if(d.index < 2) { }}'
        , '<li class="fly-none fly-grey">今天还没有人签到</li>'
        , '{{# } else { }}'
        , '<li class="fly-none fly-grey">还没有签到记录</li>'
        , '{{# } }}'
        , '{{# } }}'].join('');

    elemSigninTop.on('click', function () {
        var loadIndex = layer.load(1, {shade: 0.8});
        fly.json('../json/signin.js', function (res) { //实际使用，请将 url 改为真实接口
            var tpl = $(['<div class="layui-tab layui-tab-brief" style="margin: 5px 0 0;">'
                , '<ul class="layui-tab-title">'
                , '<li class="layui-this">最新签到</li>'
                , '<li>今日最快</li>'
                , '<li>总签到榜</li>'
                , '</ul>'
                , '<div class="layui-tab-content fly-signin-list" id="LAY_signin_list">'
                , '<ul class="layui-tab-item layui-show"></ul>'
                , '<ul class="layui-tab-item">2</ul>'
                , '<ul class="layui-tab-item">3</ul>'
                , '</div>'
                , '</div>'].join(''))
                , signinItems = tpl.find('.layui-tab-item');

            layer.close(loadIndex);

            layui.each(signinItems, function (index, item) {
                var html = laytpl(tplSigninTop).render({
                    data: res.data[index]
                    , index: index
                });
                $(item).html(html);
            });

            layer.open({
                type: 1
                , title: '签到活跃榜 - TOP 20'
                , area: '300px'
                , shade: 0.8
                , shadeClose: true
                , id: 'layer-pop-signintop'
                , content: tpl.prop('outerHTML')
            });

        }, {type: 'get'});
    });


    //回帖榜
    var tplReply = ['{{# layui.each(d.data, function(index, item){ }}'
        , '<dd>'
        , '<a href="/u/{{item.uid}}">'
        , '<img src="{{item.user.avatar}}">'
        , '<cite>{{item.user.username}}</cite>'
        , '<i>{{item["count(*)"]}}次回答</i>'
        , '</a>'
        , '</dd>'
        , '{{# }); }}'].join('')
        , elemReply = $('#LAY_replyRank');

    if (elemReply[0]) {
        /*
         fly.json('/top/reply/', {
         limit: 20
         }, function(res){
         var html = laytpl(tplReply).render(res);
         elemReply.find('dl').html(html);
         });
         */
    }
    ;

    //相册
    if ($(window).width() > 750) {
        layer.photos({
            photos: '.photos'
            , zIndex: 9999999999
            , anim: -1
        });
    } else {
        $('body').on('click', '.photos img', function () {
            window.open(this.src);
        });
    }


    //搜索
    $('.fly-search').on('click', function () {
        layer.open({
            type: 1
            , title: false
            , closeBtn: false
            //,shade: [0.1, '#fff']
            , shadeClose: true
            , maxWidth: 10000
            , skin: 'fly-layer-search'
            , content: ['<form action="http://cn.bing.com/search">'
                , '<input autocomplete="off" placeholder="搜索内容，回车跳转" type="text" name="q">'
                , '</form>'].join('')
            , success: function (layero) {
                var input = layero.find('input');
                input.focus();

                layero.find('form').submit(function () {
                    var val = input.val();
                    if (val.replace(/\s/g, '') === '') {
                        return false;
                    }
                    input.val('site:layui.com ' + input.val());
                });
            }
        })
    });

    //新消息通知
    fly.newmsg();

    //发送激活邮件
    fly.activate = function (email) {
        fly.json('/api/activate/', {}, function (res) {
            if (res.status === 0) {
                layer.alert('已成功将激活链接发送到了您的邮箱，接受可能会稍有延迟，请注意查收。', {
                    icon: 1
                });
            }
            ;
        });
    };
    $('#LAY-activate').on('click', function () {
        fly.activate($(this).attr('email'));
    });

    //表单提交
    form.on('submit(*)', function (data) {
        var action = $(data.form).attr('action'), button = $(data.elem);
        if (data.field.html_content) {
            data.field.html_content = fly.content(data.field.html_content);
        }
        fly.json(action, data.field, function (res) {
            var end = function () {
                if (res.action) {
                    location.href = res.action;
                } else {
                    fly.form[action || button.attr('key')](data.field, data.form);
                }

            };
            if (res.code == 0) {
                button.attr('alert') ? layer.alert(res.msg, {
                    icon: 1,
                    time: 10 * 1000,
                    end: end
                }) : end();
            }
            ;
        });
        return false;
    });

    //加载特定模块
    if (layui.cache.page && layui.cache.page !== 'index') {
        var extend = {};
        extend[layui.cache.page] = layui.cache.page;
        layui.extend(extend);
        layui.use(layui.cache.page);
    }

    //加载IM
    if (!device.android && !device.ios) {
        //layui.use('im');
    }

    //加载编辑器
    fly.layEditor({
        elem: '.fly-editor'
    });

    //手机设备的简单适配
    var treeMobile = $('.site-tree-mobile')
        , shadeMobile = $('.site-mobile-shade')

    treeMobile.on('click', function () {
        $('body').addClass('site-mobile');
    });

    shadeMobile.on('click', function () {
        $('body').removeClass('site-mobile');
    });

    //获取统计数据
    $('.fly-handles').each(function () {
        var othis = $(this);
        $.get('/api/handle?alias=' + othis.data('alias'), function (res) {
            othis.html('（下载量：' + res.number + '）');
        })
    });

    //点击登录按钮弹出窗体
    $('.login-header').on("click", function () {
        //layer.tips('只想提示地精准些', '.login-header');return;

        layer.open({
            type: 1
            , title: '选择登录方式'
            , area: '300px'
            , shade: 0.8
            , scrollbar: false
            , shadeClose: true

            , content: [
                '<div style="padding: 20px; text-align: center">',
                '<a href="/auth/github/auth?redirectUrl=' + window.location.href + '" title="github登录"><icon style="padding: 20px;"><svg t="1512481507116" class="icon" style="" viewBox="0 0 1028 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1907" xmlns:xlink="http://www.w3.org/1999/xlink" width="48.1875" height="48"><defs><style type="text/css"></style></defs><path d="M316.806387 841.06986q0-9.197605 9.197605-9.197605t9.197605 9.197605-9.197605 9.197605-9.197605-9.197605zM274.906188 830.850299q0-9.197605 9.197605-9.197605 10.219561 0 10.219561 9.197605 0 10.219561-10.219561 10.219561-9.197605 0-9.197605-10.219561zM509.956088 0q106.283433 0 199.792415 40.367265t163.001996 109.860279 109.860279 163.001996 40.367265 199.792415q0 82.778443-25.037924 158.914172t-69.493014 138.986028-106.794411 110.371257-135.92016 74.091816q-11.241517 2.043912-25.548902 1.021956t-17.373253-18.39521q-2.043912-12.263473-3.576846-32.702595t-2.043912-41.9002-1.021956-40.878244-0.510978-28.61477-3.576846-23.50499-8.175649-27.592814-9.197605-24.015968-6.642715-13.796407q-2.043912-2.043912 14.307385-4.598802t41.389222-9.708583 54.674651-20.439122 55.185629-35.257485 42.411178-54.163673 16.862275-78.179641q0-69.493014-8.175649-108.327345t-17.373253-58.251497q-11.241517-22.483034-25.548902-28.61477 6.131737-33.724551 9.197605-61.317365 2.043912-23.50499 0.510978-44.966068t-12.774451-27.592814q-11.241517-5.10978-33.213573 2.043912t-45.477046 18.39521q-26.570858 13.285429-57.229541 32.702595-15.329341-5.10978-33.724551-9.197605-16.351297-4.087824-38.834331-7.153693t-50.075848-3.065868-52.630739 3.065868-44.45509 6.131737q-22.483034 4.087824-41.9002 9.197605-30.658683-17.373253-57.229541-29.636727-23.50499-11.241517-45.988024-18.39521t-32.702595-3.065868q-11.241517 5.10978-13.796407 26.05988t-1.532934 45.477046q1.021956 28.61477 5.10978 63.361277-14.307385 15.329341-25.548902 36.790419-10.219561 18.39521-17.884232 44.966068t-7.664671 59.273453q0 47.00998 9.708583 82.778443t26.05988 61.828343 37.301397 43.944112 42.411178 29.125749q51.097804 26.570858 116.502994 30.658683-8.175649 9.197605-14.307385 17.373253-5.10978 7.153693-9.197605 13.796407t-4.087824 9.708583-0.510978 7.664671-1.532934 9.708583l-2.043912 10.219561q-10.219561 4.087824-21.461078 7.153693-9.197605 3.065868-20.439122 5.10978t-22.483034 2.043912-27.592814-11.752495-33.213573-27.081836-30.658683-30.147705-19.928144-20.9501q-6.131737-5.10978-16.351297-8.686627t-20.439122-5.620758-18.39521-2.55489-11.241517 0.510978q-6.131737 3.065868-9.197605 8.686627t5.10978 8.686627q4.087824 2.043912 11.752495 7.664671t15.840319 13.285429 15.329341 15.329341 10.219561 12.774451 9.197605 22.483034 19.928144 35.768463 36.790419 32.702595 61.828343 14.307385q26.570858 0 40.367265-0.510978t20.9501-1.532934l0 78.690619q0 6.131737-1.532934 13.796407t-5.620758 13.285429-11.241517 8.175649-18.39521-0.510978q-2.043912-1.021956-6.131737-1.021956-74.602794-26.570858-136.942116-74.091816t-107.816367-110.882236-71.025948-139.497006-25.548902-159.936128q0-106.283433 40.367265-199.792415t109.860279-163.001996 163.512974-109.860279 200.303393-40.367265zM380.167665 878.882236q4.087824 1.021956 6.131737 2.043912 5.10978 3.065868-6.131737 4.087824l0-6.131737zM359.728543 833.916168q0-10.219561 9.197605-10.219561t9.197605 10.219561q0 9.197605-9.197605 9.197605t-9.197605-9.197605zM177.820359 731.720559q0-6.131737 7.153693-6.131737t7.153693 6.131737q0 7.153693-7.153693 7.153693t-7.153693-7.153693zM246.291417 809.389222q0-9.197605 9.197605-9.197605t9.197605 9.197605q0 10.219561-9.197605 10.219561t-9.197605-10.219561zM207.457086 747.0499q7.153693 0 7.153693 7.153693t-7.153693 7.153693-7.153693-7.153693 7.153693-7.153693zM217.676647 780.774451q0-9.197605 9.197605-9.197605t9.197605 9.197605q0 10.219561-9.197605 10.219561t-9.197605-10.219561z" p-id="1908"></path></svg></icon></a>',
                '<a href="/auth/qq/auth?redirectUrl=' + window.location.href + '" title="qq登录"><icon style="padding: 10px;"><svg t="1512481295461" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1009" xmlns:xlink="http://www.w3.org/1999/xlink" width="48" height="48"><defs><style type="text/css"></style></defs><path d="M511.99383 0C229.233194 0 0.018511 229.251705 0.018511 512s229.214683 511.987659 511.975319 511.987659 511.987659-229.202343 511.987659-511.987659S794.766806 0 511.99383 0z m281.835089 671.576562c-13.229145 12.34062-35.923546-1.098315-57.741763-31.295813a330.444793 330.444793 0 0 1-36.046953 70.255152c30.851551 11.106558 50.596544 28.260021 50.596544 47.659476 0 33.504784-59.234978 60.617127-132.464219 60.617128-43.414303 0-81.768951-9.477596-106.00593-24.24932-24.027188 14.808744-62.591627 24.249319-106.005929 24.24932-73.167538 0-132.464219-27.149365-132.464219-60.617128 0-19.177324 19.831377-36.58994 50.695268-47.610113a320.498253 320.498253 0 0 1-36.145677-70.341537c-21.818217 29.975367-44.524958 43.636434-57.741763 31.295814-18.066668-16.968353-11.242305-76.919087 15.647907-133.784666a268.470197 268.470197 0 0 1 19.609246-34.825231c3.702186-165.364313 112.620502-297.988961 246.183036-297.988961h0.518306c133.562535 0 242.431488 132.464219 246.183037 297.988961a268.556581 268.556581 0 0 1 19.596905 34.837571c26.692762 56.89026 33.714575 116.840994 15.586204 133.809347z" p-id="1010"></path></svg></icon></a>',
                '<a href="/auth/wechat/auth?redirectUrl=' + window.location.href + '" title="微信登录"><icon style="padding: 20px;"><svg t="1512481633260" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2591" xmlns:xlink="http://www.w3.org/1999/xlink" width="48" height="48"><defs><style type="text/css"></style></defs><path d="M579.52785 511.55671a24.676479 24.676479 0 0 0-23.346609 24.233189 24.233189 24.233189 0 0 0 23.346609 21.721212c17.583838 0 29.55267-10.786724 29.552669-21.721212a27.040693 27.040693 0 0 0-29.552669-24.233189zM502.395382 398.961039a27.779509 27.779509 0 0 0 29.55267-29.55267 27.336219 27.336219 0 0 0-29.55267-29.552669 31.32583 31.32583 0 0 0-34.133333 29.552669A31.916883 31.916883 0 0 0 502.395382 398.961039z" fill="" p-id="2592"></path><path d="M512 0A512 512 0 1 0 1024 512 512 512 0 0 0 512 0zM415.215007 641.736219a275.87417 275.87417 0 0 1-82.599711-13.298701l-84.225108 42.555844 24.233189-71.665223c-59.105339-41.669264-94.273016-94.273016-94.273016-158.550073 0-113.482251 106.8329-200.219336 236.421356-200.219336 115.107648 0 217.655411 68.41443 237.751227 165.199423a116.141991 116.141991 0 0 0-22.460029-2.511977C517.171717 403.098413 429.400289 487.619048 429.400289 591.053391a200.958153 200.958153 0 0 0 6.64935 50.091775 174.508514 174.508514 0 0 1-20.834632 0.88658zM763.049928 724.040404l16.697258 59.105339-63.390476-35.463203a359.508225 359.508225 0 0 1-71.665224 12.559884c-111.709091 0-200.219336-76.689177-200.219336-171.848773s88.658009-171.848773 200.219336-171.848774c105.94632 0 200.958153 76.689177 200.958153 171.848774 0 53.342569-35.906494 100.922367-82.599711 135.203463z" fill="" p-id="2593"></path><path d="M337.63925 339.8557a32.951227 32.951227 0 0 0-35.906494 29.552669 33.54228 33.54228 0 0 0 35.906494 29.55267 28.666089 28.666089 0 0 0 29.552669-29.55267 28.222799 28.222799 0 0 0-29.552669-29.552669zM710.446176 511.55671a24.085426 24.085426 0 0 0-23.346609 24.233189 23.642136 23.642136 0 0 0 23.346609 21.721212 26.745166 26.745166 0 0 0 29.55267-21.721212 26.745166 26.745166 0 0 0-29.55267-24.233189z" fill="" p-id="2594"></path></svg></icon></a>'
                , '</div>'
            ].join('')
        });
    });

    //固定Bar
    util.fixbar({
        bar1: '&#xe642;'
        , bgcolor: '#5d6477'
        , click: function (type) {
            if (type === 'bar1') {
                if ($("#local_user").val() == 1) {
                    location.href = '/forum/article/add';
                } else {
                    //layer.msg('请先登录');
                    $('.login-header').click();
                    //location.href = '/forum/article/add';
                }
            }
        }
    });

    //总页数大于页码总数
    layui.laypage.render({
        elem: 'pagination'
        , count: $("#page_count").val()
        , limit: 15
        , curr: $("#current_page").val()
        , jump: function (obj) {
            if (obj.curr != $("#current_page").val()) {
                location.href = $("#page_link").val() + obj.curr + (obj.curr > 1 ? '#flyReply' : '')
            }
        }
    });

    $(".jieda-zan").on("click", function () {
        var status = $(this).data('status')
            , reply_id = $(this).data('id');
        if (status) {
            return;
        }

        fly.json('/forum/reply/doPraise', {
            reply_id: reply_id,
            article_id: $("input[name='article_id']").val()
        }, function (res) {
            if (res.code == 1) {
                layer.msg(res.msg);
                $(this).addClass('zanok');
            }
        }, {
            error: function () {
                //$(this).removeClass('zanok');
            }
        });
    });

    //点击@
    $('body').on('click', '.fly-aite', function () {
        var othis = $(this), text = othis.text();
        if (othis.attr('href') !== 'javascript:;') {
            return;
        }
        text = text.replace(/^@|（[\s\S]+?）/g, '');
        othis.attr({
            href: '/user/home/detail?nickname=' + text
            , target: '_blank'
        });
    });

    $(".jieda-accept").on("click", function () {
        var reply_id = $(this).data('id');

        layer.confirm('设为最佳答案？', {icon: 3, title: '提示'}, function (index) {
            fly.json('/forum/reply/chooseAnswer', {
                reply_id: reply_id,
                article_id: $("input[name='article_id']").val()
            }, function (res) {
                layer.msg('点赞成功！');
                $(this).addClass('zanok');
            });
            layer.close(index);
        });
    });
    $("._reply").on("click", function () {
        $("textarea[name='html_content']").val('@' + $(this).data('nickname') + ' ' + $("textarea[name='html_content']").val());
    })

    form.on('submit(reply)', function (data) {
        var action = $(data.form).attr('action'), button = $(data.elem);
        if (data.field.html_content) {
            data.field.html_content = fly.content(data.field.html_content);
        }
        fly.json(action, data.field, function (res) {
            var end = function () {
                location.reload();
            };
            if (res.code == 1) {
                button.attr('alert') ? layer.alert(res.msg, {
                    icon: 1,
                    time: 3 * 1000,
                    end: end
                }) : end();
            }
            ;
        });
        return false;
    });


    exports('fly', fly);

});

