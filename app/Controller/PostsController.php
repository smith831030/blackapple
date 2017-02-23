<?php
App::uses('CakeTime', 'Utility');
class PostsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Facebook.Facebook');
	public $components = array('Paginator', 'RequestHandler', 'Facebook.Connect');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('current_page', 'post');
	}

	/* list */
	public function index($category_id=null) {
		/* RSS */
		 if ($this->RequestHandler->isRss() ) {
			$this->loadModel('BaPost');
			$posts = $this->BaPost->find(
				'all',
				array('limit' => 20, 'order' => 'BaPost.id DESC')
			);
			return $this->set(compact('posts'));
		}

		$this->set('page', 'post');
		$this->set('category_id', $category_id);

		/*category lists */
		$this->loadModel('BaPostCategory');
		$this->set('categories', $this->BaPostCategory->find('all', array('order'=>'BaPostCategory.category_order ASC')));

		/* post lists */
		$paginate = array(
			'fields' => array('BaPost.id', 'BaPost.title', 'BaPost.created', 'BaPost.body', 'BaPost.tags', 'BaPost.img', 'BaPost.comment_total', 'BaPostCategory.category_title'),
			'limit' => 36,
			'order' => array(
				'BaPost.id' => 'DESC'
			),
			//'conditions' => array(CakeTime::daysAsSql('Jan 01, '.CakeTime::format(time(), '%Y'), 'Dec 31, '.CakeTime::format(time(), '%Y'), 'BaPost.created')),
			'joins' => array(
				array('table' => 'ba_post_categories',
					'alias' => 'BaPostCategory',
					'type' => 'inner',
					'conditions' => array(
						'BaPostCategory.id = BaPost.category_id',
					)
				)
			)
		);

		/* sort category */
		if($category_id && $category_id!="all"){
			$paginate['conditions'] = array('BaPost.category_id'=>$category_id);
		}

		$this->loadModel('BaPost');

		/* total */
		$this->set('total', $this->BaPost->find('count'));

		$this->Paginator->settings = $paginate;
		$data = $this->Paginator->paginate('BaPost');
		//$data = $this->BaPost->find('all', $paginate);

		//$this->set('title_for_layout', $data[0]['BaPost']['title']);
		$this->set('posts', $data);
	}

	/* post lists by year */
	public function listsByYear($year=null){
		$this->layout='ajax';

		$this->loadModel('BaPost');
		$fields=array('BaPost.id', 'BaPost.title', 'BaPost.created', 'BaPost.body', 'BaPost.tags', 'BaPost.img', 'BaPost.comment_total', 'BaPostCategory.category_title');
		$joins=array(
				array(
					'table'=>'ba_post_categories',
					'alias'=>'BaPostCategory',
					'type'=>'INNER',
					'conditions'=>array('BaPost.category_id=BaPostCategory.id')
				)
			);
		$posts=$this->BaPost->find('all', array('fields'=>$fields, 'joins'=>$joins, 'conditions'=>array(CakeTime::daysAsSql('Jan 01, '.$year, 'Dec 31, '.$year, 'BaPost.created')), 'order' => array('BaPost.id' => 'DESC')));
		$this->set('posts', $posts);
	}

	/* view */
	public function view($post_id) {
		$this->set('page', 'post');
		$this->set('post_id', $post_id);

		$this->loadModel('BaPost');

		$data = $this->BaPost->find('first', array(
			'fields' => array('BaPost.id', 'BaPost.title', 'BaPost.created', 'BaPost.body', 'BaPost.tags', 'BaPost.img', 'BaPost.comment_total', 'BaPost.category_id', 'BaPostCategory.category_title'),
			'joins' => array(
				array('table' => 'ba_post_categories',
					'alias' => 'BaPostCategory',
					'type' => 'inner',
					'conditions' => array(
						'BaPostCategory.id = BaPost.category_id',
					)
				)
			),
			'conditions'=>array('BaPost.id'=>$post_id)
		));

		/* meta tag:og */
		$home_url='http://blackapple.kr';
		$this->set('og_img', $home_url.'/upload/'.$data['BaPost']['img']);
		$this->set('og_title', $data['BaPost']['title']);
		$this->set('og_url', $home_url.'/Posts/View/'.$data['BaPost']['id']);
		$this->set('og_description', mb_strimwidth(h(strip_tags($data['BaPost']['body'])), 0, 400, "...","utf-8"));

		$this->set('title_for_layout', $data['BaPost']['title']);
		$this->set('view', $data);

		/* post lists */
		$paginate = array(
			'fields' => array('BaPost.id', 'BaPost.title', 'BaPost.created', 'BaPost.body', 'BaPost.tags', 'BaPost.img', 'BaPost.comment_total', 'BaPostCategory.category_title'),
			'limit' => 5,
			'order' => array(
				'BaPost.id' => 'DESC'
			),
			'conditions' => array(),
			'joins' => array(
				array('table' => 'ba_post_categories',
					'alias' => 'BaPostCategory',
					'type' => 'inner',
					'conditions' => array(
						'BaPostCategory.id = BaPost.category_id',
					)
				)
			)
		);

		/* total */
		$this->set('total', $this->BaPost->find('count'));

		$this->Paginator->settings = $paginate;
		$list = $this->Paginator->paginate('BaPost');
		$this->set('posts', $list);
	}

	/* ajax list */
	public function lists($page=1, $post_id=null){
		$pagesize=5;
		$this->set('post_id', $post_id);
		$this->set('page', $page);
		$this->set('pagesize', $pagesize);
		$this->set('start', ($page-1)*$pagesize);

		$this->layout = 'ajax';
		$this->loadModel('BaPost');

		/* total */
		$this->set('total', $this->BaPost->find('count'));

		$this->Paginator->settings = array(
				'fields' => array('BaPost.id', 'BaPost.title', 'BaPost.created', 'BaPost.comment_total', 'BaPostCategory.category_title'),
				'limit' => $pagesize,
				'page' => $page,
				'order' => array(
					'BaPost.id' => 'DESC'
				),
				'joins' => array(
					array('table' => 'ba_post_categories',
						'alias' => 'BaPostCategory',
						'type' => 'inner',
						'conditions' => array(
							'BaPostCategory.id = BaPost.category_id',
						)
					)
				)
			);

		$data = $this->Paginator->paginate('BaPost');
		$this->set('posts', $data);
	}

	/* comment */
	public function comment($post_id=null, $comment_id=null){
		$this->layout = 'ajax';
		$this->loadModel('BaPostComment');
		$this->set('post_id', $post_id);
		$this->set('comment_id', $comment_id);

		if($this->Connect->user('id')=="100000924274679"){
			$facebook_id="501671759858991";
		}else{
			$facebook_id=$this->Connect->user('id');
		}
		$this->set('facebook_id', $facebook_id);

		$this->set('comments', $this->BaPostComment->find('all', array(
					'conditions' => array('BaPostComment.post_id' => $post_id, 'BaPostComment.depth' => $comment_id, 'BaPostComment.status' => 1),
					'order'=>'BaPostComment.id ASC'
				)));
	}

	public function commentAdd(){
		$this->layout = 'ajax';

		if ($this->request->is('post')) {
			$this->loadModel('BaPost');
			$this->loadModel('BaPostComment');
            $this->BaPostComment->create();
            if ($this->BaPostComment->save($this->request->data)) {
				/* UPDATE comment total */
				$this->BaPost->query("
							UPDATE ba_posts SET
								comment_total=comment_total+1
							WHERE id=".$this->request->data['BaPostComment']['post_id']
						);
				/* UPDATE comment reply total */
				if($this->request->data['BaPostComment']['depth']>0){
					$this->BaPostComment->query("
							UPDATE ba_post_comments SET
								reply_total=reply_total+1
							WHERE id=".$this->request->data['BaPostComment']['depth']
						);
				}
				$this->Session->setFlash(__('Your post has been saved.'));
            }
            $this->Session->setFlash(__('Unable to add your post.'));
			$this->set('result', 1);
        }else{
			$this->set('result', -1);
		}
	}

	public function commentDel(){
		$this->layout = 'ajax';

		if ($this->request->is('post')) {
			/* Check Facebook ID */
			if($this->Connect->user('id')=="100000924274679"){
				$facebook_id="501671759858991";
			}else{
				$facebook_id=$this->Connect->user('id');
			}
			if($this->request->data['BaPostComment']['user_id']!=$facebook_id){
				$this->set('result', -2);
				$this->set('count_reply', 0);
			}else{
				$this->loadModel('BaPost');
				$this->loadModel('BaPostComment');

				/* counting reply */
				if($this->request->data['BaPostComment']['depth']==0){
					$count_reply = $this->BaPostComment->find('count', array(
										'conditions'=>array('BaPostComment.depth'=>$this->request->data['BaPostComment']['comment_id']
															,'BaPostComment.status'=>1
														)
										));
				}else{
					$count_reply = 0;
				}
				$this->set('count_reply', $count_reply);

				/* UPDATE comment status */
				$this->BaPostComment->query("
							UPDATE ba_post_comments SET
								status=0
							WHERE id=".$this->request->data['BaPostComment']['comment_id']
						);

				/* UPDATE comment total */
				$this->BaPost->query("
							UPDATE ba_posts SET
								comment_total=comment_total-(1+".$count_reply.")
							WHERE id=".$this->request->data['BaPostComment']['post_id']
						);
				/* UPDATE comment reply total */
				if($this->request->data['BaPostComment']['depth']>0){
					$this->BaPostComment->query("
							UPDATE ba_post_comments SET
								reply_total=reply_total-1
							WHERE id=".$this->request->data['BaPostComment']['depth']
						);
				}
				$this->Session->setFlash(__('Your post has been deleted.'));

				$this->set('result', 1);
			}
        }else{
			$this->set('result', -1);
		}
	}
	//$this->Connect->user('id')

	/* Admin */
	public function Admins_list($cate_id=null) {
		$this->layout='admin';
		$this->set('page', 'post');
		if(!$this->Auth->loggedIn()){
			return $this->redirect(array('controller'=>'Login', 'action' => 'Admins_login'));
		}else{
			$settings=array(
				'fields' => array('BaPost.id', 'BaPost.title', 'BaPost.img', 'BaPost.created', 'BaPost.comment_total', 'BaPostCategory.category_title'),
				'limit' => 20,
				'order' => array(
					'BaPost.id' => 'DESC'
				),
				'joins' => array(
					array('table' => 'ba_post_categories',
						'alias' => 'BaPostCategory',
						'type' => 'inner',
						'conditions' => array(
							'BaPostCategory.id = BaPost.category_id',
						)
					)
				)
			);

			if(!empty($cate_id)){
				$settings['conditions']=array('BaPost.category_id'=>$cate_id);
			}

			$this->Paginator->settings = $settings;
			$this->loadModel('BaPost');

			$data = $this->Paginator->paginate('BaPost');
			$this->set('posts', $data);
		}
	}

	public function Admins_view($idx = null) {
		$this->layout='admin';
		$this->set('page', 'post');
		if(!$this->Auth->loggedIn()){
			return $this->redirect(array('controller'=>'Login', 'action' => 'Admins_login'));
		}else{
			$this->loadModel('BaPost');

			if (!$idx) {
				throw new NotFoundException(__('Invalid post'));
			}

			$post = $this->BaPost->find('first', array(
						'fields' => array('BaPost.id', 'BaPost.title', 'BaPost.body', 'BaPost.created', 'BaPost.tags', 'BaPost.comment_total', 'BaPostCategory.category_title'),
						'conditions' => array('BaPost.id'=>$idx),
						'joins' => array(
							array('table' => 'ba_post_categories',
								'alias' => 'BaPostCategory',
								'type' => 'inner',
								'conditions' => array(
									'BaPostCategory.id = BaPost.category_id',
								)
							)
						)
					));
			if (!$post) {
				throw new NotFoundException(__('Invalid post'));
			}
			$this->set('post', $post);

			$players = $this->get_players($idx);
			$this->set('players', $players);

			/* comment lists */
			// $this->loadModel('BaPostComment');
			// $this->set('comments', $this->BaPostComment->find('all', array(
			// 				'conditions' => array('BaPostComment.post_id' => $post['BaPost']['id']),
			// 				'order'=>'BaPostComment.id ASC'
			// 			)));
		}
    }

	public function Admins_add() {
		$this->layout='admin';
		$this->set('page', 'post');
		if(!$this->Auth->loggedIn()){
			return $this->redirect(array('controller'=>'Login', 'action' => 'Admins_login'));
		}else{
			/* post */
			$this->loadModel('BaPost');
			$this->loadModel('BaPlayer');
			$this->loadModel('BaPostsPlayer');

			if ($this->request->is('post')) {
				$this->BaPost->create();
				if ($this->BaPost->save($this->request->data)) {
					$post_id=$this->BaPost->id;
					$data=array();
					if($this->request->data['player'] && sizeof($this->request->data['player'])>0){
						foreach($this->request->data['player'] as $player_id){
							$data[]=array('post_id'=>$post_id, 'player_id'=>$player_id);
						}

						$this->BaPostsPlayer->saveall($data);
					}
					$this->Session->setFlash(__('Your post has been saved.'));
					return $this->redirect(array('action' => 'Admins_list'));
				}
				$this->Session->setFlash(__('Unable to add your post.'));
			}else{
				/*category lists */
				$this->loadModel('BaPostCategory');
				$this->set('players', $this->BaPlayer->find('all', array('order'=>'BaPlayer.id ASC')));
				$this->set('categories', $this->BaPostCategory->find('all', array('order'=>'BaPostCategory.category_order ASC')));
			}
		}
	}

	public function Admins_edit($id = null) {
		$this->layout='admin';
		$this->set('page', 'post');
		if(!$this->Auth->loggedIn()){
			return $this->redirect(array('controller'=>'Login', 'action' => 'Admins_login'));
		}else{
			$this->loadModel('BaPost');
			$this->loadModel('BaPlayer');
			$this->loadModel('BaPostsPlayer');

			if (!$id) {
				throw new NotFoundException(__('Invalid post'));
			}

			$post = $this->BaPost->findById($id);
			if (!$post) {
				throw new NotFoundException(__('Invalid post'));
			}

			if ($this->request->is(array('post', 'put'))) {
				$this->BaPost->id = $id;
				if ($this->BaPost->save($this->request->data)) {
					$this->BaPostsPlayer->deleteAll(array('post_id'=>$id));
					$data=array();
					if($this->request->data['player'] && sizeof($this->request->data['player'])>0){
						foreach($this->request->data['player'] as $player_id){
							$data[]=array('post_id'=>$id, 'player_id'=>$player_id);
						}

						$this->BaPostsPlayer->saveall($data);
					}

					$this->Session->setFlash(__('Your post has been updated.'));
					return $this->redirect(array('action' => 'Admins_list'));
				}
				$this->Session->setFlash(__('Unable to update your post.'));
			}else{
				/*category lists */
				$this->loadModel('BaPostCategory');
				$this->set('players', $this->BaPlayer->find('all', array('order'=>'BaPlayer.id ASC')));
				$this->set('categories', $this->BaPostCategory->find('all', array('order'=>'BaPostCategory.category_order ASC')));

				$p_players=$this->get_players($id);
				$this->set('p_players', $p_players);
			}

			if (!$this->request->data) {
				$this->request->data = $post;
			}
		}
	}

	public function Admins_delete($id) {
		$this->layout='admin';
		$this->set('page', 'post');
		$this->loadModel('BaPost');
		$this->loadModel('BaPostsPlayer');

		if(!$this->Auth->loggedIn()){
			return $this->redirect(array('controller'=>'Login', 'action' => 'Admins_login'));
		}else{
			if ($this->request->is('get')) {
				throw new MethodNotAllowedException();
			}

			if ($this->BaPost->delete($id)) {
				if($this->BaPostsPlayer->deleteAll(array('post_id'=>$id))){
					$this->Session->setFlash(
						__('The post with id: %s has been deleted.', h($id))
					);
				}
				return $this->redirect(array('action' => 'Admins_list'));
			}
		}
	}

	public function Admins_changeCategory(){
		$this->loadModel('BaPost');
		if($this->BaPost->updateAll(array('category_id'=>$this->request->data['category_id']), array('id'=>$this->request->data['id']))){
			return $this->redirect(array('action'=>'Admins_list'));
		}
	}

	private function get_players($post_id){
		$this->loadModel('BaPostsPlayer');
		return $this->BaPostsPlayer->find('all', array(
				'fields'=>array('BaPostsPlayer.*, BaPlayer.*'),
				'joins' => array(
					array('table' => 'ba_players',
						'alias' => 'BaPlayer',
						'type' => 'inner',
						'conditions' => array(
							'BaPostsPlayer.player_id = BaPlayer.id',
						)
					)
				),
				'conditions'=>array('BaPostsPlayer.post_id'=>$post_id)
		));
	}
}
?>
