<?php
/**
 * MainPageController
 *
 * @author		Smith.Seo(smith831030@gmail.com)
 * @created		16/05/2015
 *
 */
class MainPageController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Text');
	
	public function hiddenMemberAddPage() {
		$this->layout = 'signin';
		$this->loadModel('Member');
		
		if ($this->request->is('post')) {
			$this->Member->create();
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				//return $this->redirect('/');
			}else{
				$this->Session->setFlash(
					__('The user could not be saved. Please, try again.')
				);
			}
		}
		$this->loadModel('Shop');
		$this->set('shops', $this->Shop->find('all', array('fields'=>'Shop.shop_idx, Shop.shop_title', 'order'=>'Shop.shop_idx ASC')));

	}
	
	public function index() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				//log
				$detail=array('mem_id'=>$this->Auth->user('mem_id'));
				$this->addLog('login', $detail);
				
				$this->level_check_redirection();
			} else {
				$this->layout = 'signin';
				
				$this->set('login',0);
				$this->Session->setFlash(
				__('Username or password is incorrect'),
				'default',
				array(),
				'auth'
				);
			}
		}elseif(!$this->Auth->loggedIn()){
			$this->layout = 'signin';
			$this->set('login',0);
		}else{
			$this->level_check_redirection();
		}
	}
	
	private function level_check_redirection(){
		if($this->Auth->user('mem_level')==10){
			return $this->redirect('/Managers');
		}elseif($this->Auth->user('mem_level')==20){
			return $this->redirect('/Franchises');
		}
	}
	
	public function Logout() {
		//log
		$detail=array('mem_id'=>$this->Auth->user('mem_id'));
		$this->addLog('logout', $detail);
		
		$this->Auth->logout();
		$this->redirect("/");
	}
}
?>