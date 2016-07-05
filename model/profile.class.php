<?php

class Profile{
	protected $email, $name, $education, $experience, $projects, $prizes;

	function __construct( $email, $name, $education, $experience, $projects, $prizes ){
		$this->email = $email;
		$this->name = $name;
		$this->education = $education;
		$this->experience = $experience;
        $this->projects = $projects;
        $this->prizes = $prizes;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
