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
				}
			);
			this.triggerEvent(uniqueFingerPrinter);
		
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
			})
		}
	}
	return Comments;
});