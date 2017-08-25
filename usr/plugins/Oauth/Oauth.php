<?php 
/**
 * MyRoute
 * @package Oauth
 * @author 沙鱼
 * @version 1.0.0
 * @link http://blog.inectu.com
 */

class Oauth_Oauth extends Widget_Abstract_Options implements Widget_Interface_Do
{
    private $_actions = array();

    public function execute()
    {

    }

    public function action()
    {

    }

    /**
     * 微博登录
     * @param null
     * return void
     */
    public function getWeiboLogin()
    {
        $http_refferr = $_SERVER['HTTP_REFERER'] ?? 'http://www.inectu.com';
        Typecho_Cookie::set('http_refferr', $http_refferr, time() + 3600*24);
        $o = new Typecho_SaeTOAuthV2(WEIBO_APP_KEY, WEIBO_APP_SECRET);
        $code_url = $o->getAuthorizeURL(WEIBO_CALLBACK);
        header("Location: " . $code_url);
        die;
    }

    /**
     * 微信callback
     */
    public function weiboCallback()
    {
        $o = new Typecho_SaeTOAuthV2(WEIBO_APP_KEY, WEIBO_APP_SECRET);
        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = WEIBO_CALLBACK;
            try {
                $token = $o->getAccessToken('code', $keys);
            } catch (OAuthException $e) {
            }
        }
        if ($token) {
//            array(
//                'access_token' => '2.003ApmjBG7bx5E3f86b3cd0duEPEpD',
//                'remind_in' => '157679999',
//                'expires_in' => 157679999,
//                'uid' => '1592703762',
//            )
            $_SESSION['token'] = $token;
            $saeClient = new Typecho_SaeTClientV2(WEIBO_APP_KEY, WEIBO_APP_SECRET, $token['access_token']);
            //$saeClient->set_debug(true);
            $userinfo = $saeClient->show_user_by_id($token['uid']);
            $hasRecord = $this->db->fetchRow($this->db->select()->from('table.oauth')->where(
                'table.oauth.oauth_id = ?', $userinfo['id']));
            if(!$hasRecord){
                //添加登录记录
                //oauth_type weibo => 1, weixin => 2, qq => 3
                $table = array(
                    'oauth_id' => $userinfo['id'],
                    'oauth_name' => $userinfo['screen_name'],
                    'oauth_type' => 1,
                    'avatar' => $userinfo['avatar_large'],
                    'ip' => $this->request->getIp(),
                    'access_token' => $token['access_token']
                );
                $this->db->query($this->db->insert('table.oauth')->rows($table));
            }
            setcookie('oauth_id', $userinfo['id'], time() + 3600*24*30, '/');
            setcookie('avatar', $userinfo['avatar_large'], time() + 3600*24*30, '/');
            setcookie('nickname', $userinfo['screen_name'], time() + 3600*24*30, '/');
        }
        header("Location: " . Typecho_Cookie::get('http_refferr'));
        die;
    }
}