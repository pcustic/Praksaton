<?php

class Internship{
	protected $iid, $cid, $title, $description, $requirements;

	function __construct( $iid, $cid, $title, $description, $requirements ){
		$this->iid = $iid;
		$this->cid = $cid;
		$this->title = $title;
		$this->description = $description;
		$this->requirements = $requirements;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
