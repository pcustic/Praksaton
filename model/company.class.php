<?php

class Company{
	protected $cid, $name, $email, $password, $description;

	function __construct( $cid, $name, $email, $password, $description ){
		$this->cid = $cid;
		$this->name = $name;
		$this->email = $email;
		$this->password = $password;
        $this->description = $description;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
