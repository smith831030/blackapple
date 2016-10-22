<?php
class AdminsController extends AppController {
	public $helpers = array('Html', 'Form');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout='admin';
	}

	public function index() {
		if(!$this->Auth->loggedIn()){
			return $this->redirect('/Admins/login/login');
		}else{
			return $this->redirect('/Admins/Posts/list');
		}
	}

}
?>
