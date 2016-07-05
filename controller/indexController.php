<?php

class IndexController extends BaseController{
	public function index() {
		$this->registry->template->title = 'Praksaton';
		$this->registry->template->show( 'home' );
	}
};

?>
