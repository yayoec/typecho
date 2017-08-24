<?php 
/**
 * MyRoute
 * @package MyAjax
 * @author 沙鱼
 * @version 1.0.0
 * @link http://blog.inectu.com
 */

class AjaxOperator_MyAjax extends Widget_Abstract_Options implements Widget_Interface_Do {
	private $_actions = array(
		'getArticleLike',
		'addArticleLike',
        'addComment'
	);
	public function execute() {
		
	}
	
	public function action(){
		$action = $this->request->action;
		if(in_array($action, $this->_actions)){
			switch ($action){
				case 'getArticleLike':
					$this->getArticleLike();
					break;
				case 'addArticleLike':
					$this->addArticleLike();
					break;
                case 'addComment':
                    $this->addComment();
                    break;
				default:
					break;
				
			}
		}
	}

	public function addComment(){
        $cid = $this->request->cid;
        $comment_content = $this->request->comment;
        $ip = $this->request->getIp();
        $agent = $this->request->getAgent();
        $parent_id = $this->request->parent_id ?? '';
        $owner_id = $_COOKIE['oauth_id'];
        if (!$owner_id)
            $this->response->throwJson(['status' => -1, 'reason' => '需要使用第三方登录']);
        $oauth_info = $this->db->fetchRow($this->db->select()->from('table.oauth')->where(
            'table.oauth.oauth_id = ?', $owner_id));
        if (empty($oauth_info)) {
            $this->response->throwJson(['status' => -1, 'reason' => '未获取到用户信息']);
        }
        $comment = array(
            'cid' => $cid,
            'agent' => $agent,
            'ip' => $ip,
            'ownerId' => $owner_id,
            'type' => 'comment',
            'author' => $oauth_info['oauth_name'],
            'url' => $oauth_info['avatar'],
            'parent' => $parent_id,
            'text' => $comment_content,
            'status' => 'approved',
            'created' => date('Y-m-d H:i:s', time())
        );
        if($coid = $this->db->query($this->db->insert('table.comments')->rows($comment))){
            $comment['coid'] = $coid;
            $this->response->throwJson(['status' => 0, 'reason' => '', 'data' => $comment]);
        }
        $this->response->throwJson(['status' => -1, 'reason' => '评论失败']);
    }

    /**
     * @param $cid 文章id 同aid
     */
    public function getComments($cid){
        $all = $this->db->fetchAll($this->db->select()->from('table.comments')->where(
            'table.comments.cid = ? and parent = 0', $cid));
        $coids = array();$countNum = 0;
        foreach ($all as $row){
            array_push($coids, $row['coid']);
        }
        if (count($coids) != 0){
            $allSub = $this->db->fetchAll($this->db->select()->from('table.comments')->where(
                'table.comments.parent in ?', $coids));
            $countNum = count($all) + count($allSub);
        }
        for ($i = 0; $i < count($all); $i++){
            $all[$i]['sub'] = array();
            foreach ($allSub as $subRow){
                if ($subRow['parent'] == $all[$i]['coid'])
                    array_push($all[$i]['sub'], $subRow);
            }
        }
        return [$all, $countNum];
    }
	
	/**
	 * 获取文章文章喜欢数
	 * @param null
	 * return void
	 */
	public function getArticleLike(){
		$isLiked = $this->db->fetchRow($this->db->select()->from('table.like_record')->where(
				'table.like_record.article_id = ?', $this->request->aid)
				->where('table.like_record.user_unique_id=?', $this->request->uniqueFingerPrinter));
		$ret = array('likeNum' => 1, 'mlikeNum' => 0);
		if(empty($isLiked)){
			//添加阅读记录
			$isreaded = $this->db->fetchRow($this->db->select()->from('table.read_record')->where(
					'table.read_record.article_id = ? and table.read_record.user_unique_id = ?', $this->request->aid,
					$this->request->uniqueFingerPrinter));
			if(!$isreaded){
				$readRecord = array(
                    'user_unique_id' => $this->request->uniqueFingerPrinter,
                    'article_id' => $this->request->aid,
                    'ip' => $this->request->getIp(),
				);
				if($this->db->query($this->db->insert('table.read_record')->rows($readRecord))){
					$this->increField($this->request->aid, 'readNum', 1);
				}
			}
			$ret['likeNum'] = 0;
		}
		$mlikeNum = $this->db->fetchRow($this->db->select('count(*)')->from('table.like_record')->where(
				'table.like_record.category_id = ?', $this->request->mid));
		$ret['mlikeNum'] = $mlikeNum['count(*)'];
        $comments = $this->getComments($this->request->aid);
        $ret['comments'] = $comments[0];
        $ret['commentsNum'] = $comments[1];
		$this->response->throwJson($ret);
	}
	
	/**
	 * 添加文章喜欢
	 * @param null
	 * return void
	 */
	public function addArticleLike(){
		if($this->request->aid == 0){
			$this->response->throwJson(array('isLiked' => 0));
		}
		$isLiked = $this->db->fetchRow($this->db->select()->from('table.like_record')->where(
				'table.like_record.article_id = ?', $this->request->aid)
				->where('table.like_record.user_unique_id=?', $this->request->uniqueFingerPrinter));
		if($isLiked){
			$ret = 2;
		}else{
			//添加喜欢记录
			$table = array(
				'user_unique_id' => $this->request->uniqueFingerPrinter,
				'article_id' => $this->request->aid,
				'category_id' => $this->request->mid,
				'ip' => $this->request->getIp(),
			);
			if($this->db->query($this->db->insert('table.like_record')->rows($table))){
				$this->increField($this->request->aid, 'likeNum', 1);
				$ret = 1;
			}else {
				$ret = 0;
			}
			
		}
		$this->response->throwJson(array('isLiked' => $ret));
	}
	
	/**
	 * contents表某个字段自增
	 * @param unknown $aid 		article_id
	 * @param unknown $field	字段名
	 * @param unknown $value	自增值
	 */
	public function increField($aid, $field, $value){
		$this->db->query($this->db->update('table.contents')
				->rows(array())
				->expression($field, $field  . ($value >= 0 ? '+' : '') . $value)
				->where('cid = ?', $aid));
	}
}
