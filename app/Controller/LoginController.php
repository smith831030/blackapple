<?php
class LoginController extends AppController {
	public $helpers = array('Html', 'Form');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout='admin';
	}

	public function Admins_add() {
			$this->loadModel('BaMember');

			if ($this->request->is('post')) {
				$this->BaMember->create();
				if ($this->BaMember->save($this->request->data)) {
					$this->Session->setFlash(__('The user has been saved'));
					return $this->redirect('/Admins');
				}
				$this->Session->setFlash(
					__('The user could not be saved. Please, try again.')
				);
			}

	}

	public function Admins_login(){
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect('/Admins');
			} else {
				$this->Session->setFlash(
				__('Username or password is incorrect'),
				'default',
				array(),
				'auth'
				);
			}
		}
	}

	public function Admins_logout()
	{
		$this->Auth->logout();
		$this->redirect("/");
	}
}
?>
