<div id="sidebar">
	<div class="navbar navbar-homepage expanded">
	  <div class="dropdown">
	      <a class="nav-userinfo logo" title="J's Blog">
	        <b>J</b><i class="fa fa-home"></i><span class="title">首页</span>
		  </a>      
		  <a class="nav-topic" title="专题">
	        <i class="fa fa-th"></i><span class="title">专题</span>
		  </a> 
		  <a class="nav-archive" title="归档">
		      <i class="fa fa-folder"></i><span class="title">归档</span>
		  </a>   
		  <a class="nav-gallary" title="摄影">
		      <i class="fa fa-camera"></i><span class="title">相册</span>
		  </a>
	  </div>
	  <div class="nav-user">
	  		<!-- 
	      <a class="signin" data-signin-link="true" data-toggle="modal" data-placement="right" data-original-title="登录" data-container="div.expanded" href="/sign_in">
	        <i class="fa fa-user"></i><span class="title">登录</span>
		  </a>    
		   -->
	  </div>
	</div>
	<!-- end .navbar -->
	
	<!-- begin navdetail 相册 个人介绍 归档 专题 js动态切换 -->
	<div class="navdetail">
		<div id="userinfo">	
			<div class="overlay"></div>
			<div class="intrude-less">
			<header id="header" class="inner">
			<a href="/" class="profilepic">
	
			<img src="http://tva3.sinaimg.cn/crop.0.0.180.180.180/5eeebb12jw1e8qgp5bmzyj2050050aa8.jpg" class="js-avatar">
	
			</a>
	
			<h1 class="header-author">
				<a href="/">沙鱼</a>
				
			</h1>
			<div id="wb_button"><wb:follow-button uid="1592703762" type="gray_2" width="136" height="24" ></wb:follow-button></div>
	
			<p class="header-subtitle"><?php $this->options->description() ?></p>

			<nav class="header-nav">
				<div class="social">
		
					<a class="github" target="_blank" href="https://github.com/yayoec" title="github">
					
					<i class="fa fa-github"></i>
					
					</a>
			
					<a class="weibo" target="_blank" href="http://weibo.com/1592703762" title="weibo">
					<i class="fa fa-weibo"></i>
					</a>
			
					<a class="rss" target="_blank" href="<?php $this->options->feedUrl(); ?>" title="rss">
					<i class="fa fa-rss"></i>
					</a>
		
				</div>
			</nav>
			</header>		
			</div>
		</div>
		
		<div id="topic">
			<ul class="mcd-menu">
			<?php 
				$cats = $this->allCategory();
				if (!empty($cats)):
					for ($i = 0; $i < count($cats); $i++):
						$pathInfo = Typecho_Router::url('category', $cats[$i]);
						$permalLink = Typecho_Common::url($pathInfo, $this->options->index);
						?>
				<li>
					<a href="<?php echo $permalLink?>">
						<i class="fa fa-codepen"></i>
						<strong><?php echo $cats[$i]['name'];?></strong>
						<small><?php echo $cats[$i]['description']?></small>
					</a>
				</li>
				<?php endfor;?>
			<?php endif;?>
			</ul>
			
		</div>
		<div id="archive">
			<h3 class="widget-title"><?php _e('归档'); ?></h3>
	        <ul class="mcd-menu">
	            <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y/m')
	            ->parse('<li><a href="{permalink}"><strong>{date}</strong></a></li>'); ?>
	        </ul>
		</div>
		<div id="gallary">
		</div>
		 
	</div>
	
</div>

<ul class="container" id="top-menu">
    <li class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" aria-expanded="true">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </li>
    <li class="navbar-collapse collapse in" id="menu" aria-expanded="true" style="">
        <ul class="nav navbar-nav">
            <li class="active">
                <a href="/">
                    <span class="menu-text">HOME</span><i class="iconfont ic-navigation-discover menu-icon"></i>
                </a>
            </li>
            <?php
            $cats = $this->allCategory();
            if (!empty($cats)):
                for ($i = 0; $i < count($cats); $i++):
                    $pathInfo = Typecho_Router::url('category', $cats[$i]);
                    $permalLink = Typecho_Common::url($pathInfo, $this->options->index);
                    ?>
                    <li>
                        <a href="<?php echo $permalLink?>">
                            <span class="menu-text"><?php echo $cats[$i]['name'];?></span><i class="iconfont ic-navigation-discover menu-icon"></i>
                        </a>
                    </li>
                <?php endfor;?>
            <?php endif;?>

            <li class="search">
                <form target="_blank" action="/search" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                    <input type="text" name="q" id="q" value="" autocomplete="off" placeholder="搜索" class="search-input" data-mounted="1">
                    <a class="search-btn" href="javascript:void(null)"><i class="fa fa-search"></i></a>
                </form>
            </li>
        </ul>
    </li>
</ul>

<!-- end #sidebar -->
