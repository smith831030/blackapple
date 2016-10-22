<?php
class WorksController extends AppController {
	public $helpers = array('Html', 'Form');
	
	public function index() {
		$this->set('page', 'works');
	}
	
	public function GamiChicken() {
		$this->set('page', 'works');
	}
	
	public function TheFighters() {
		$this->set('page', 'works');
	}
	
	public function CitySpecial() {
		$this->set('page', 'works');
	}
	
	public function HelloAustralia($no=null) {
		$this->set('page', 'works');
		$this->set('no', $no);
	}
	
	public function DoorEp1() {
		$this->set('page', 'works');
	}
	public function DoorEp2($no=null) {
		$this->set('page', 'works');
		$this->set('no', $no);
	}
	public function DoorEp3($no=null) {
		$this->set('page', 'works');
		$this->set('no', $no);
	}
	
	public function InkAndWhite() {
		$this->set('page', 'works');
	}
	
}
?>