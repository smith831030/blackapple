<?php
class GuestBbsController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Paginator');
	
	public $paginate = array(
        'limit' => 10,
        'order' => array(
            'WsComment.wb_idx' => 'DESC'
        )
    );
	
	public function index() {
		$this->set('page', 'guestbbs');
		$this->Paginator->settings = $this->paginate;
		$this->loadModel('WsComment');

		$data = $this->Paginator->paginate('WsComment');
		$this->set('posts', $data);
		
		//ADD
		if ($this->request->is('post')) {
            $this->WsComment->create();
            if ($this->WsComment->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add your post.'));
        }
	}
	
	public function comment($wb_idx=null) {
		$this->layout = 'ajax';
		$this->loadModel('WsCommentComment');
		
		$this->set('wb_idx', $wb_idx);
		$this->set('posts', $this->WsCommentComment->find('all', array('conditions' => array('WsCommentComment.wb_idx' => $wb_idx), 'order'=>'WsCommentComment.wbc_idx ASC')));
		
		//ADD
		if ($this->request->is('post')) {
            $this->WsComment->create();
            if ($this->WsComment->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add your post.'));
        }
	}
}
?>