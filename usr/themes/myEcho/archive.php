<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<?php $this->need('sidebar.php'); ?>

<div id="article-container">
	<div class="post" id="main" role="main">
        <?php if ($this->have()): ?>
        <h3 class="archive-title"><?php $this->archiveTitle(array(
            'category'  =>  _t('专题 <span>%s</span> 下的文章'),
            'search'    =>  _t('包含关键字 <span>%s</span> 的文章'),
            'tag'       =>  _t('标签 <span>%s</span> 下的文章'),
            'author'    =>  _t('<span>%s</span> 发布的文章')
        ), '', ''); ?></h3>
        
    	<?php while($this->next()): ?>
	    	
            <article>
            	<h1><a itemtype="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h1>
    			<div class="meta-top">
		            <span class="views-count"><?php $this->readNum('阅读0', '阅读1', '阅读%d'); ?></span>
		            <span class="comments-count"><?php $this->commentsNum('评论0', '评论1', '评论%d'); ?></span>
		            <span class="likes-count"><?php $this->likeNum('喜欢0', '喜欢1', '喜欢%d'); ?></span>
		        </div>
                <div class="post-content" itemprop="articleBody">
        			<?php $this->trimImgContents('- 阅读剩余部分 -'); ?>
                </div>
    		</article>
    	<?php endwhile; ?>
        <?php else: ?>
            <article class="post">
                <h2 class="post-title"><?php _e('没有找到内容'); ?></h2>
            </article>
        <?php endif; ?>

        <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    </div>
   <!-- end #main -->
 </div>


<?php $this->need('footer.php'); ?>
