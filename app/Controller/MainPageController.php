<?php
class MainPageController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Text');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('current_page', 'main');
	}

	public function index() {
		$this->set('page', 'main');

		/*category lists */
		$this->loadModel('BaPostCategory');
		$this->set('categories', $this->BaPostCategory->find('all', array('order'=>'BaPostCategory.category_order ASC')));

		/* post lists */
		$options = array(
			'fields' => array('BaPost.id', 'BaPost.title', 'BaPost.created', 'BaPost.body', 'BaPost.tags', 'BaPost.img', 'BaPost.comment_total', 'BaPost.category_id', 'BaPostCategory.category_title'),
			'limit' => 4,
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

		$this->loadModel('BaPost');

		/* total */
		$this->set('total', $this->BaPost->find('count'));

		$data = $this->BaPost->find('all', $options);

		//$this->set('title_for_layout', $data[0]['BaPost']['title']);
		$this->set('posts', $data);
	}
}
?>
