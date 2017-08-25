define(['jQuery'], function(jQuery){
	//根据article id 初始化评论数据
	var Comments = {
		'ajaxUrl': siteUrl + 'index.php/my_ajax',
		'init': function(uniqueFingerPrinter, aid, mid){
			$.post(this.ajaxUrl, 
				{
					action: 'getArticleLike', 
					aid: aid, 
					mid: mid,
					uniqueFingerPrinter: uniqueFingerPrinter
				}, 
				function(res){
					if(res.likeNum){
						$('#like-note').parent().parent().addClass('note-liked');
						$('#like-note').find('fa').removeClass('fa-heart-o').addClass('fa-heart');
					}
					$('#cat-like').html(res.mlikeNum);
					$('#comment-num').html(res.commentsNum);
					var comments = '';
					if(res.comments.length){
					    for(var i=0; i<res.comments.length; i++){
                            comments += '<div class="note-comment clearfix" coid="' + res.comments[i].coid + '">';
                            comments += '    <div class="content">';
                            comments += '        <div class="meta-top">';
                            comments += '            <a class="avatar" href="javascript:void(0)">';
                            comments += '            <img src="' + res.comments[i].url + '" alt="100">';
                            comments += '            </a>';
                            comments += '            <p>';
                            comments += '            <a class="author-name" href="javascript:void(0)">' + res.comments[i].author + '</a>';
                            comments += '            </p>';
                            comments += '            <span class="reply-time">';
                            comments += '            <small>' + (i+1) + ' 楼 ·</small>';
                            comments += '            <a href="javascript:void(0)">' + res.comments[i].created + '</a>';
                            comments += '            </span>';
                            comments += '        </div>';
                            comments += '        <p>' + res.comments[i].text + '</p>';
                            comments += '        <div class="comment-footer clearfix text-right">';
                            comments += '            <a coid="' + res.comments[i].coid + '" data-nickname="' + res.comments[i].author + '" class="reply" href="javascript:void(0)">回复</a>';
                            comments += '        </div>';
                            comments += '        <div class="child-comment-list">';
                            if(res.comments[i].sub.length){
                                for(var j=0; j<res.comments[i].sub.length; j++){
                                    comments += '            <div class="child-comment" coid="' + res.comments[i].coid + '">';
                                    comments += '                <p>';
                                    comments += '                <a class="blue-link" href="javascript:void(0)">' + res.comments[i].sub[j].author + '</a>：';
                                    //comments += '                <a href="javascript:void(0)" class="maleskine-author" target="_blank" data-user-slug="3d8fda802ae5" data-original-title="" title="">@折腾是一种PIN格</a>';
                                    comments += res.comments[i].sub[j].text;
                                    comments += '                </p>';
                                    comments += '                <div class="child-comment-footer text-right clearfix">';
                                    comments += '                    <a coid="' + res.comments[i].sub[j].coid + '" data-nickname="' + res.comments[i].sub[j].author + '" class="reply" href="javascript:void(null)">回复</a>';
                                    comments += '                    <span class="reply-time pull-left">';
                                    comments += '                    <a href="javascript:void(0)">' + res.comments[i].sub[j].created + '</a>';
                                    comments += '                    </span>';
                                    comments += '                </div>';
                                    comments += '            </div>';
                                }
                            }
                            comments += '        </div>';
                            comments += '    </div>';
                            comments += '</div>';
                        }
                    }
                    $('#comments-list').html(comments);
				}
			);
			this.triggerEvent(uniqueFingerPrinter);
		    if(getCookie('from_login')){
                $('body').animate({scrollTop:$('#comment_content').offset().top + 'px'});
                $('#comment_content').focus();
                setCookie('from_login', 0, -1);
            }
		},
		
		'triggerEvent': function(uniqueFingerPrinter){
			var ajaxUrl = this.ajaxUrl;
			$('#like-note').on('click', function(){
				var aid = $(this).attr('aid');
				var mid = $('#cat-like').attr('mid');
				if($(this).parent().parent().hasClass('note-liked')){
					return ;
				}
				$.post(ajaxUrl, {
					action: 'addArticleLike', 
					aid: aid, 
					mid: mid,
					uniqueFingerPrinter: uniqueFingerPrinter
				}, function(res){
					if(res.isLiked == 1){
						$('#like-note').parent().parent().addClass('note-liked');
						$('#like-note').find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
						var likeCount = parseInt($('#likes-count').html());
						var mlikeCount = parseInt($('#cat-like').html());
						likeCount++;mlikeCount++;
						$('#cat-like').html(mlikeCount);
						$('#likes-count').html(likeCount);
					}
				})
			});
			$('.goto-comment').on('click', function(){
				if(!getCookie('oauth_id')){
                    $(".coverBg").height($(window).height()).width($(window).width());//使遮罩的背景覆盖整个页面
                    $(".coverBg").show();
                    $(".coverCont").show();
                    showDiv();
				}else{
                    setTimeout(function() {
                        $('#comment_content').focus();
                    }, 0);
				}
			});
			$(document).on('click', 'input[name="commit"]', function(){
				if($(this).hasClass('loading'))
					return false;
				//$(this).addClass('loading').val($(this).attr('data-disable-with'));
				var pa = $(this).parent().parent();
				if(pa.find('textarea').val() == ''){
				    return false;
                }
				var pid = pa.parent().attr('pid') || null;
                $.post(ajaxUrl, {
                    action: 'addComment',
                    cid: pa.parent().attr('cid'),
                    parent_id: pid,
					comment: pa.find('textarea').val()
                }, function(res){
                    $(this).removeClass('loading').val('发 表');
                    if(res.status == 0){
                        pa.find('textarea').val('');
                        $(this).siblings('.waring').hide()
						var comment = '';
						if(pid){
							comment += '<div class="child-comment" coid="' + res.data.coid + '">';
							comment += '<p>';
							comment += '<a class="blue-link" href="javascript:void(0)">' + res.data.author + '</a>：';
							comment += res.data.text;
							comment += '</p>';
							comment += '<div class="child-comment-footer text-right clearfix">';
							comment += '<a data-nickname="' + res.data.author + '" class="reply" href="javascript:void(null)">回复</a>';
							comment += '<span class="reply-time pull-left">';
							comment += '<a href="javascript:void(0)">' + res.data.created + '</a>';
							comment += '</span>';
							comment += '</div>';
							comment += '</div>';
                            pa.parent().parent().append(comment);
                            $('#comments-list').find('form').remove();
                        }else{
                            comment += '<div class="note-comment clearfix" coid="' + res.data.coid + '">';
                            comment += '<div class="content">';
                            comment += '<div class="meta-top">';
                            comment += '<a class="avatar" href="javascript:void(0)">';
                            comment += '<img src="' + res.data.url + '" alt="100">';
                            comment += '</a>';
                            comment += '<p>';
                            comment += '<a class="author-name" href="javascript:void(0)">' + res.data.author + '</a>';
                            comment += '</p>';
                            comment += '<span class="reply-time">';
                            comment += '<a href="javascript:void(0)">' + res.data.created + '</a>';
                            comment += '</span>';
                            comment += '</div>';
                            comment += '<p>' + res.data.text + '</p>';
                            comment += '<div class="comment-footer clearfix text-right">';
                            comment += '<a coid="' + res.data.coid + '" data-nickname="' + res.data.author + '" class="reply" href="javascript:void(0)">回复</a> ';
                            comment += '</div>';
                            comment += '<div class="child-comment-list"></div>';
                            comment += '</div>';
                            comment += '</div>';
                            $('#comments-list').append(comment);
						}

                    }else{
                    	$(this).siblings('.waring').show().find('.waring-text').val(res.reason);
					}
                })
			});
			$(document).on('click', '#comments-list .reply', function(){
				var pa = $(this).parent().parent();
				var cid = $('#new_comment').attr('cid');
				var nickname = $(this).attr('data-nickname');
				$('#comments-list form').remove();
				if(pa.hasClass('child-comment')){
					var pid = pa.parent().parent().parent().attr('coid');
                    var form = '<form class="new-child-comment" cid="'+cid+'" pid="'+pid+'" data-type="json" method="post">';
                    form += '<div class="comment-text">';
                    form += '<textarea maxlength="2000" placeholder="写下你的评论…" class="mousetrap" name="comment[content]"></textarea>';
                    form += '<div>';
                    form += '<input type="button" name="commit" value="发 表" class="btn-info" data-disable-with="提交中...">';
                    form += '<span class="warning" style="display: none"><i class="fa fa-exclamation-circle"></i><span class="warning-text"></span></span>';
                    form += '</div>';
                    form += '</div>';
                    form += '</form>';
                    if(!pa.parent().find('form').length)
						pa.parent().append(form);
				}else{
					var pid = pa.parent().attr('coid');
                    var form = '<form class="new-child-comment" cid="'+cid+'" pid="'+pid+'" data-type="json" method="post">';
                    form += '<div class="comment-text">';
                    form += '<textarea maxlength="2000" placeholder="写下你的评论…" class="mousetrap" name="comment[content]"></textarea>';
                    form += '<div>';
                    form += '<input type="button" name="commit" value="发 表" class="btn-info" data-disable-with="提交中...">';
                    form += '<span class="warning" style="display: none"><i class="fa fa-exclamation-circle"></i><span class="warning-text"></span></span>';
                    form += '</div>';
                    form += '</div>';
                    form += '</form>';
                    if(!pa.parent().find('.child-comment-list').find('form').length)
                    	pa.parent().find('.child-comment-list').append(form);
				}
                $('#comments-list').find('form textarea').val('@'+nickname).focus();
			})
            $(document).on('focus', 'textarea', function(){
                var that = $(this);
                if(!getCookie('oauth_id')){
                    $(".coverBg").height($(window).height()).width($(window).width());//使遮罩的背景覆盖整个页面
                    $(".coverBg").show();
                    $(".coverCont").show();
                    showDiv();
                }else{
                     that.focus();
                }
            })
		}
	};
	function showDiv(){
		var coverContTop=($(window).height()-$(".coverCont").height())/2;  //计算弹出的框距离页面顶部的距离
		var coverContWidth=($(window).width()-$(".coverCont").width())/2;  //计算弹出的框距离页面左边的距离
		$(".coverCont").css({
			"top": coverContTop,
			"left": coverContWidth
		});
	}
	return Comments;
});