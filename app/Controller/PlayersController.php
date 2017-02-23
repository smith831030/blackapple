<?php
App::uses('CakeTime', 'Utility');
class PlayersController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Facebook.Facebook');
	public $components = array('Paginator', 'RequestHandler', 'Facebook.Connect');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('current_page', 'players');
        $this->layout='admin';
        $this->loadModel('BaPlayer');

        if(!$this->Auth->loggedIn()){
			$this->redirect(array('controller'=>'Login', 'action'=>'login'));
		}
	}

	/* list */
	public function Admins_index() {
    	/* player lists */
		$paginate = array(
			'limit' => 15,
			'order' => array(
				'BaPlayer.id' => 'DESC'
			)
		);

		/* total */
		$this->set('total', $this->BaPlayer->find('count'));

		$this->Paginator->settings = $paginate;
		$data = $this->Paginator->paginate('BaPlayer');

		$this->set('players', $data);
	}

    public function Admins_status($player_id, $status){
        if($this->BaPlayer->save(array('id'=>$player_id, 'p_status'=>$status))){
            $this->Session->setFlash('Success to update');
		}else{
			$this->Session->setFlash('Failed to update');
		}
		return $this->redirect(array('action'=>'Admins_index'));
    }

    public function Admins_add(){
        if($this->request->is('post')){
            if($this->BaPlayer->save($this->request->data)){
                $this->Session->setFlash('Success to save');
            }else{
                $this->Session->setFlash('Failed to save');
            }
            return $this->redirect(array('action'=>'Admins_index'));
        }
    }

    public function Admins_modify($player_id=null){
        if($this->request->data){
            if($this->BaPlayer->save($this->request->data)){
                $this->Session->setFlash('Success to update');
            }else{
                $this->Session->setFlash('Failed to update');
            }
            return $this->redirect(array('action'=>'Admins_index'));
        }else{
            $player = $this->BaPlayer->findById($player_id);
            $this->request->data = $player;
        }
    }
}
?>
