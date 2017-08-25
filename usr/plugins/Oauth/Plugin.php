<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * AjaxOperator
 * 
 * @package Oauth
 * @author 沙鱼
 * @version 1.0.0
 * @link http://blog.inectu.com
 */
class Oauth_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Helper::addRoute("oauth_weibo", "/oauth/weibo", "Oauth_Oauth", "getWeiboLogin");
        Helper::addRoute("weibo_callback", "/weibo/callback", "Oauth_Oauth", "weiboCallback");
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){
    	Helper::removeRoute('oauth_weibo');
        Helper::removeRoute('weibo_callback');
    }
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        /** 分类名称 */
//         $name = new Typecho_Widget_Helper_Form_Element_Text('word', NULL, 'Hello World', _t('说点什么'));
//         $form->addInput($name);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function render()
    {
        echo '<span class="message success">'
            . htmlspecialchars(Typecho_Widget::widget('Widget_Options')->plugin('HelloWorld')->word)
            . '</span>';
    }
}
