<?php

class Student{
	protected $sid, $name, $email, $password;

	function __construct( $sid, $name, $email, $password ){
		$this->sid = $sid;
		$this->name = $name;
		$this->email = $email;
		$this->password = $password;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
