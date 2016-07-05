<?php

class Application{
	protected $iid, $sid, $status;

	function __construct( $iid, $sid, $status){
		$this->iid = $iid;
		$this->sid = $sid;
		$this->status = $status;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
