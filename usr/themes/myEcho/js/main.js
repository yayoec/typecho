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
	pathInfo = pathInfo.replace('index.php', '');
	$('.mcd-menu li a').on('mouseover mouseout', function(event){
		if(event.type == "mouseover"){
			$(this).addClass('active');
		 }else if(event.type == "mouseout"){
			if($(this).attr('href').indexOf(pathInfo) == -1)
				$(this).removeClass('active');
		 }
		
	});
	if(pathInfo.indexOf('category') > -1){
		$('#sidebar .nav-topic').addClass('active');
        animateMode('topic');
        $('#topic a').each(function(){
        	if($(this).attr('href').indexOf(pathInfo) > -1){
        		$(this).addClass('active');
			}
		})
	}else if(pathInfo.match(/\d{2,4}\/\d{2,4}/)){
        $('#sidebar .nav-archive').addClass('active');
        animateMode('archive');
        $('#archive a').each(function(){
            if($(this).attr('href').indexOf(pathInfo) > -1){
                $(this).addClass('active');
            }
        })
	}else if(pathInfo.indexOf('gallery') > -1){
        $('#sidebar .nav-gallery').addClass('active');
	}else{
        $('#sidebar .nav-userinfo').addClass('active');
        animateMode('userinfo');
	}
	$('.dropdown>a').on('click', function(e){
		e.stopPropagation();e.preventDefault();
		$('.dropdown>a').removeClass('active');
		$(this).addClass('active');
		var mod = $(this).attr('class').match(/nav-([a-z]+)/)[1];
		$('.navdetail>div').animate({'left': '-350px'}, 250, 'swing');
		animateMode(mod);
	})
    $('button.navbar-toggle').on('click', function(){
        $('#menu').slideToggle();
	})
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
});