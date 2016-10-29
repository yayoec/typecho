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
	</script>
	<script src="//cdn.bootcss.com/require.js/2.1.20/require.min.js" type="text/javascript"></script>
  	<script src="<?php $this->options->themeUrl(); ?>js/main.js" type="text/javascript" ></script>
<?php $this->footer(); ?>
</body>
</html>
