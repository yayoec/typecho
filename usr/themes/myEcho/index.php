<?php
/**
 * 这是 Typecho 0.9 系统的一套默认皮肤
 * 
 * @package Typecho myEcho Theme 
 * @author Joe
 * @version 1.0
 * @link http://blog.inectu.com
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
 $this->need('sidebar.php');
?>

<!-- index content -->
<div id="right-container">
    <div class="page-title">
        <ul class="recommened-nav navigation clearfix">
            <li class="active">
            <a data-pjax="true" href="/">HOME</a>
            </li>
            <!-- 
            <li class="bonus">
            <a href="/zodiac/2015"><i class="fa fa-bars"></i> 2015精选</a>
            </li>
            -->
            
            <li class="search">
                <form class="search-form" target="_blank" action="/search" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                <input type="search" name="q" id="q" placeholder="搜索" class="input-medium search-query">
                <span class="search_trigger" onclick="$('form.search-form').submit();"><i class="fa fa-search"></i></span>
                </form>
            </li>
        </ul>
    </div>

    <div id="list-container">

        <ul class="sort-nav" id="tags-nav" data-js-module="collection-tags" data-fetch-url="">

        	<?php while($this->next()): ?>
        		<li><?php $this->tags()?>
        	<?php endwhile;?>

        </ul>
        
        <ul class="article-list thumbnails clearfix">
			<?php while($this->next()):?>
            <li class="<?php if($this->contentImg()):?>have-img<?php endif;?>">

                <div>
                
                    <p class="list-top">
                        <?php $this->category();?>
                        <em>·</em>
                        <span class="time" data-shared-at="<?php $this->date('c'); ?>"><?php $this->date('m.d.Y')?></span>
                    </p>
                    <h4 class="title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h4>
                    <?php if($this->contentImg()):?>
                        <a class="wrap-img" href="javascript:void(0);"><img src="<?php echo $this->contentImg()?>" alt="300"></a>
                    <?php endif;?>
                    <div class="post-content" itemprop="articleBody">
		    			<?php $this->trimImgContents('- 阅读剩余部分 -'); ?>
		            </div>
                    <div class="list-footer">
                        <span>
                        <?php $this->readNum('阅读 0', '阅读 1', '阅读 %d'); ?>
                        </span>        
                        <span> · 
                        <?php $this->commentsNum('评论 0', '评论 1', '评论 %d'); ?>
                        
                        </span>        
                        <span> · <?php $this->likeNum('喜欢 0', '喜欢 1', '喜欢 %d'); ?></span>

                    </div>
                    
                </div>
            </li>
            <?php endwhile;?>
	        
		</ul>
		
		<!--
	    <div class="load-more"><button class="ladda-button " data-style="slide-left" data-type="script" data-remote="" data-size="medium" data-url="/top/daily?note_ids%5B%5D=6227346&amp;note_ids%5B%5D=6289172&amp;note_ids%5B%5D=6300432&amp;note_ids%5B%5D=6295059&amp;note_ids%5B%5D=6296966&amp;note_ids%5B%5D=6296805&amp;note_ids%5B%5D=6296170&amp;note_ids%5B%5D=6290414&amp;note_ids%5B%5D=6295531&amp;note_ids%5B%5D=5948743&amp;note_ids%5B%5D=6300458&amp;note_ids%5B%5D=6193462&amp;note_ids%5B%5D=6070807&amp;note_ids%5B%5D=6237712&amp;note_ids%5B%5D=6267848&amp;note_ids%5B%5D=6283858&amp;note_ids%5B%5D=6296299&amp;note_ids%5B%5D=6276428&amp;note_ids%5B%5D=6281166&amp;note_ids%5B%5D=6303314&amp;page=2" data-color="maleskine" data-method="get">
	    <span class="ladda-label">点击查看更多</span>
	    <span class="ladda-spinner"></span></button></div>
     	-->
		<?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    </div>
    
</div>

 <?php $this->need('footer.php');?>


