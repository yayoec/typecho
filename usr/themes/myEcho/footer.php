	<script>
	var themeUrl = "<?php $this->options->themeUrl()?>";
	var siteUrl = "<?php $this->options->siteUrl()?>";
	var pathInfo = getPathInfo();
	function getPathInfo(){
		var url = location.href;
		var result = url.match(/index.php(\/?[a-zA-Z0-9\/]+)/);
		if(result)
			return result[0]
		return '/';
	}
    /** functions **/
    //set cookie
    function setCookie(cname, cvalue, exdays) {
        'use strict';
        var d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        var expires = 'expires=' + d.toUTCString();
        document.cookie = cname + '=' + cvalue + '; ' + expires + '; path=/';
    }

    //get cookie
    function getCookie(cname) {
        'use strict';
        var name = cname + '=';
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return '';
    }
	</script>
	<script src="//cdn.bootcss.com/require.js/2.1.20/require.min.js" type="text/javascript"></script>
  	<script src="<?php $this->options->themeUrl(); ?>js/main.js" type="text/javascript" ></script>
<?php $this->footer(); ?>
<section class="coverBg"></section>
<section class="coverCont">
    <ul>
        <li><a class="weibo" target="_self" title="微博" href="http://inectu.com/index.php/oauth/weibo"><i class="fa fa-weibo"></i><span></span></a></li>
        <li><a class="weixin" target="_self" title="微信" href="http://inectu.com/index.php/oauth/wechat"><i class="fa fa-wechat"></i></a></li>
    </ul>
</section>
</body>
</html>
