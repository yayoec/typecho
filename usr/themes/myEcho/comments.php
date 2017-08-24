<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div id="comments" class="comment-list">


<div class="comment-head clearfix">
    <span id="comment-num">0</span>条评论
<!--        <span class="order">-->
<!--        （-->
<!--        <a data-order="desc" class="active" href="javascript:void(0)">按时间排序</a>·-->
<!--        <a data-order="likes_count" href="javascript:void(0)">按喜欢排序</a>-->
<!--        ）-->
<!--        </span>-->
        <a class="goto-comment pull-right"  href="javascript:void(null)">
            <i class="fa fa-pencil"></i>添加新评论
        </a>        
    </div>
    <div id="comments-list">

    </div>
    
    <form class="new_comment" id="new_comment" cid="<?php echo $this->cid?>" data-type="json" accept-charset="UTF-8" data-remote="true" method="post">
        <input name="utf8" type="hidden" value="✓">
        <div class="comment-text">
            <textarea maxlength="2000" placeholder="写下你的评论…" class="mousetrap" name="comment[content]" id="comment_content"></textarea>
            <div>
            <input type="button" name="commit" value="发 表" class="btn btn-info" data-disable-with="提交中...">
            

            <span class="warning" style="display: none"><i class="fa fa-exclamation-circle"></i><span class="warning-text"></span></span>
            </div>
        </div>
    </form>
</div>
