<?php

//singleton klasa za spajanje na bazu
class DB
{
	private static $db = null;

	private function __construct() { }
	private function __clone() { }

	public static function getConnection()
	{
		if( DB::$db === null )
	    {
	    	try
	    	{
		    	DB::$db = new PDO( "mysql: host=rp2.studenti.math.hr; dbname=IME_BAZE; charset=utf8", USERNAME, SIFRA );
		    	DB::$db-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
		    catch( PDOException $e ) { exit( 'PDO Error: ' . $e->getMessage() ); }
	    }
		return DB::$db;
	}
}

?>
