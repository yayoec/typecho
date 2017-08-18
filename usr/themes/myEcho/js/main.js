requirejs.config({
	baseUrl: themeUrl + 'js/',
	paths: {
		'jQuery': '//cdn.bootcss.com/jquery/2.1.4/jquery.min',
		'fingerPrint2': '//cdn.bootcss.com/fingerprintjs2/1.4.1/fingerprint2.min',
		'Comments': 'comment',
	}
})
require(['jQuery', 'fingerPrint2', 'Comments'], function(jQuery, Fingerprint2, Comments){
	if(pathInfo.match('archive')){
		//文章页 加载文章初始化组件
		new Fingerprint2().get(function(result, component){
			var aid = $('#like-note').attr('aid') || 0;
			var mid = $('#cat-like').attr('mid') || 0;
			Comments.init(result, aid, mid);
		});
	}
	$('.mcd-menu li a').on('mouseover mouseout', function(event){
		if(event.type == "mouseover"){
			$(this).addClass('active');
		 }else if(event.type == "mouseout"){
			$(this).removeClass('active');
		 }
		
	})
	$('.dropdown>a').on('click', function(e){
		e.stopPropagation();e.preventDefault();
		$('.dropdown>a').removeClass('active');
		$(this).addClass('active');
		var mod = $(this).attr('class').match(/nav-([a-z]+)/)[1];
		$('.navdetail>div').animate({'left': '-350px'}, 250, 'swing');
		animateMode(mod);
		function animateMode(mod){
			// if(pathInfo == '/'){
				if(mod != 'gallary')
					$('#'+mod).animate({'left': '45px'}, 250, 'swing');
				else
					alert('相册功能暂未开放');return false;
			// }else{
			// 	location.href = siteUrl;
			// }
		}
	})
    $('button.navbar-toggle').on('click', function(){
        $('#menu').slideToggle();
	})
});