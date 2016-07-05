<?php

// Manualno inicijaliziramo bazu ako već nije.
require_once '../../model/db.class.php';

$db = DB::getConnection();

//stvori tablicu studenata
try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS students (' .
		'sid int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'name varchar(50) NOT NULL,' .
		'email varchar(50) NOT NULL,' .
		'password varchar(255) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #1: " . $e->getMessage() ); }

echo "Napravio tablicu students.<br />";



//stvori tablicu kompanija
try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS companies (' .
		'cid int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'name varchar(50) NOT NULL,' .
		'email varchar(50) NOT NULL,' .
		'password varchar(255) NOT NULL,' .
		'description varchar(1000) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #2: " . $e->getMessage() ); }

echo "Napravio tablicu companies.<br />";



//stvori tablicu praksi
try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS internships (' .
		'iid int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'cid INT NOT NULL,' .
		'title varchar(100) NOT NULL,' .
		'description varchar(5000) NOT NULL,' .
		'requirements varchar(5000) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #3: " . $e->getMessage() ); }

echo "Napravio tablicu internships.<br />";



// stvori tablicu prijava na prakse
try{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS applications (' .
		'iid int NOT NULL,' .
		'sid int NOT NULL,' .
		'status varchar(50),' .
		'PRIMARY KEY (iid, sid))'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #2: " . $e->getMessage() ); }

echo "Napravio tablicu applications.<br />";



// Ubaci neke studente unutra
try{
	$st = $db->prepare( 'INSERT INTO students(name, email, password) VALUES (:name, :email, :password)' );

	$st->execute( array( 'name' => 'Pero', 'email' => 'pero@student.math.hr', 'password' => password_hash( 'perinasifra', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'name' => 'Mirko', 'email' => 'mirko@gstudent.math.hr', 'password' => password_hash( 'mirkovasifra', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'name' => 'Slavko', 'email' => 'slavko@student.math.hr', 'password' => password_hash( 'slavkovasifra', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'name' => 'Ana', 'email' => 'ana@student.math.hr', 'password' => password_hash( 'aninasifra', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'name' => 'Maja', 'email' => 'maja@student.math.hr', 'password' => password_hash( 'majinasifra', PASSWORD_DEFAULT ) ) );
}
catch( PDOException $e ) { exit( "PDO error #4: " . $e->getMessage() ); }

echo "Ubacio korisnike u tablicu students.<br />";



// Ubaci neke firme unutra
try{
	$st = $db->prepare( 'INSERT INTO companies(name, email, password, description) VALUES (:name, :email, :password, :description)' );

	$st->execute( array( 'name' => 'Bdacta', 'email' => 'bdacta@gmail.com', 'password' => password_hash( 'bdactasifra', PASSWORD_DEFAULT ), 'description' => 'Description od Bdacta' ) );
	$st->execute( array( 'name' => 'PhotoPhysics', 'email' => 'PhotoPhysics@gmail', 'password' => password_hash( 'PhotoPhysicssifra', PASSWORD_DEFAULT ), 'description' => 'Description od PhotoPhysics' ) );
	$st->execute( array( 'name' => 'Six', 'email' => 'six@gmail.com', 'password' => password_hash( 'sixsifra', PASSWORD_DEFAULT ), 'description' => 'Six description' ) );
}
catch( PDOException $e ) { exit( "PDO error #4: " . $e->getMessage() ); }

echo "Ubacio korisnike u tablicu companies.<br />";



// Ubaci neke internshipe unutra
try{
	$st = $db->prepare( 'INSERT INTO internships(cid, title, description, requirements) VALUES (:cid, :title, :description, :requirements)' );

	$st->execute( array( 'cid' => 1, 'title' => 'PHP programer', 'description' => 'Trazimo studenta koji bi radio kao PHP programer. Minimalno trajanje 3 mjeseca.', 'requirements' => 'Barem jedan veci projekt u PHP-u.' ) );
	$st->execute( array( 'cid' => 1, 'title' => 'System administrator', 'description' => 'Trazimo studenta koji bi radio kao SysAdmin. Nudimo dobru placu, ugodno radno mjesto, priliku za ucenje.', 'requirements' => 'Iskustvo sa linuxom. Osnove programiranja.' ) );
	$st->execute( array( 'cid' => 2, 'title' => 'Java programer', 'description' => 'Trazimo studenta koji bi radio kao Java programer. Minimalno trajanje 2 mjeseca.', 'requirements' => 'Barem jedan veci projekt u Javi' ) );
	$st->execute( array( 'cid' => 2, 'title' => 'Junior Ruby developer', 'description' => 'Trazimo studenta koji bi radio kao Ruby on Rails developer. Pocetno 3 mjeseca s mogucnoscu produzenja te stalnog zaposlenja', 'requirements' => 'Nekoliko vecih projekta u RoR-u ili slicnom MVC frameworku.' ) );
	$st->execute( array( 'cid' => 2, 'title' => 'C++ programer', 'description' => 'Trazimo studenta koji bi se pridruzio nasem glavnom timu za razvoj. Zeljan ucenja i izazovnih projekata.', 'requirements' => 'Dobro poznavanje algoritama i naprednih struktura podataka.' ) );
	$st->execute( array( 'cid' => 3, 'title' => 'ASP.NET programer', 'description' => 'Trazimo studenta ASP.NET carobnjaka.', 'requirements' => 'Barem 2 veca i nekoliko manjih projekata u ASP.NET tehnologiji.' ) );
	$st->execute( array( 'cid' => 3, 'title' => 'Python/Django', 'description' => 'Trazimo studenta za rad na nasim Django projektima.', 'requirements' => 'Dobro poznavanje Pythona i barem jednog MVC web frameworka.' ) );
}
catch( PDOException $e ) { exit( "PDO error #4: " . $e->getMessage() ); }

echo "Ubacio prakse u tablicu internships.<br />";


// ubaci neke prijave unutra
try{
	$st = $db->prepare( 'INSERT INTO applications(iid, sid, status) VALUES (:iid, :sid, :status)' );

	$st->execute( array( 'iid' => 1, 'sid' => 1, 'status' => 'cekanje') );
	$st->execute( array( 'iid' => 2, 'sid' => 1, 'status' => 'cekanje') );
	$st->execute( array( 'iid' => 4, 'sid' => 2, 'status' => 'cekanje') );
	$st->execute( array( 'iid' => 6, 'sid' => 2, 'status' => 'primljen') );
	$st->execute( array( 'iid' => 7, 'sid' => 3, 'status' => 'odbijen') );
	$st->execute( array( 'iid' => 3, 'sid' => 4, 'status' => 'cekanje') );
	$st->execute( array( 'iid' => 3, 'sid' => 5, 'status' => 'odbijen') );
	$st->execute( array( 'iid' => 5, 'sid' => 5, 'status' => 'primljen') );

}
catch( PDOException $e ) { exit( "PDO error #4: " . $e->getMessage() ); }

echo "Ubacio prijave u tablicu applications.<br />";


try{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS profiles (' .
		'name varchar(50) NOT NULL,' .
		'email varchar(50) NOT NULL,' .
		'education varchar(5000),' .
		'experience varchar(5000),' .
		'projects varchar(5000),' .
		'prizes varchar(5000),' .
		'PRIMARY KEY (email))'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #2: " . $e->getMessage() ); }

echo "Napravio tablicu profiles.<br />";


try{
	$st = $db->prepare( 'INSERT INTO profiles(email, name, education, experience, projects, prizes) VALUES (:email, :name, :education, :experience, :projects, :prizes)' );

	$st->execute( array( 'email' => 'pero@student.math.hr', 'name' => 'Pero', 'education' => 'Magistar matematike i računarstva, PMF-MO (2012-2017)', 'experience' => '', 'projects' => '', 'prizes' => '') );
	$st->execute( array( 'email' => 'mirko@gstudent.math.hr', 'name' => 'Mirko', 'education' => 'Diplomski studij računarstva i matematike na PMF-u, 1.godina. Prosjek ocjena 4.92.', 'experience' => 'Facebook Software engineer intern - Summer 2015', 'projects' => '', 'prizes' => '') );
	$st->execute( array( 'email' => 'slavko@student.math.hr', 'name' => 'Slavko', 'education' => 'Diplomski studij računarstva i matematike na PMF-u, 1.godina.', 'experience' => 'Ericsson Nikola Tesla Summer Camp - ljetna praksa u trajanju od mjesec dana.', 'projects' => 'Concept parametrisation - projekt kojeg sam radio u sklopu ljetne prakse u Ericssonu. ', 'prizes' => '') );
	$st->execute( array( 'email' => 'ana@student.math.hr', 'name' => 'Ana', 'education' => 'Diplomski studij računarstva i matematike na PMF-u, 2.godina.', 'experience' => 'Google Software engineer intern 2013. Facebook Software engineer intern 2014. Dropbox Software engineer intern 2015.', 'projects' => '', 'prizes' => 'Google CodeJam Finalist 2015') );
	$st->execute( array( 'email' => 'maja@student.math.hr', 'name' => 'Maja', 'education' => 'Diplomski studij računarstva i matematike na PMF-u, 2.godina. Preddiplomski studij računarstva, FER.', 'experience' => '', 'projects' => 'iToilet - mobilna aplikacija koja prikazuje gdje se nalazi najbliži javni WC.', 'prizes' => 'Nagrada Grada Zagreba za najinovativnije Smart City rješenje - iToilet.') );

}
catch( PDOException $e ) { exit( "PDO error #4: " . $e->getMessage() ); }

echo "Ubacio prijave u tablicu profiles.<br />";
?>
