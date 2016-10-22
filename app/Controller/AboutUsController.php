<?php
class AboutUsController extends AppController {
	public $helpers = array('Html', 'Form');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('current_page', 'aboutus');
	}

	public function index() {
		$this->set('page', 'aboutus');
		$this->loadModel('WsHistory');
		$this -> set('posts', $this -> WsHistory -> find('all', array('order'=>'wb_idx DESC')));
	}

	public function Admins_index(){
		$this->layout='admin';
		$this->loadModel('WsHistory');

		if($this->request->is('post')){
			$this->WsHistory->save(array(
				'wb_content'=>$this->request->data['WsHistory']['wb_content'],
				'wb_date'=>date('Y-m-d H:i:s')
			));
		}

		$this -> set('posts', $this -> WsHistory -> find('all', array('order'=>'wb_idx DESC')));
	}
}
?>
