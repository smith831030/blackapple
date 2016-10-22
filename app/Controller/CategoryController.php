<?php
App::uses('CakeTime', 'Utility');
class CategoryController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Text');
	public $components = array('Paginator', 'RequestHandler');

	public function beforeFilter() {
		parent::beforeFilter();
    $this->layout='admin';
		$this->loadModel('BaPostCategory');

		if(!$this->Auth->loggedIn()){
			$this->redirect(array('controller'=>'Login', 'action'=>'login'));
		}
	}


	public function Admins_index() {
		if($this->request->is('post')){
			$this->Admins_add();
		}

    $categories=$this->get_list();
    $this->set(compact('categories'));
  }

	private function Admins_add(){
		if($this->BaPostCategory->save($this->request->data)){
			$this->Session->setFlash('Success to save');
		}else{
			$this->Session->setFlash('Failed to save');
		}
	}

	public function Admins_modify(){
		if($this->BaPostCategory->save($this->request->data)){
			$this->Session->setFlash('Success to update');
		}else{
			$this->Session->setFlash('Failed to update');
		}
		return $this->redirect(array('action'=>'Admins_index'));
	}

	public function Admins_delete($id){
		if($this->BaPostCategory->delete($id)){
			$this->Session->setFlash('Success to delete');
		}else{
			$this->Session->setFlash('Failed to delete');
		}
		return $this->redirect(array('action'=>'Admins_index'));
	}

	/* list */
	public function get_list(){
		$this->loadModel('BaPostCategory');
    $categories=$this->BaPostCategory->find('all', array('order'=>'category_order asc'));
		return $categories;
	}
}
?>
