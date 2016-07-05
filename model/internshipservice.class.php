<?php

class InternshipService{
	function getAllInternships(){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT iid, cid, title, requirements, description FROM internships ORDER BY iid DESC' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() ){
			$arr[] = new Internship( $row['iid'], $row['cid'], $row['title'], $row['requirements'], $row['description'] );
		}

		return $arr;
	}


	function getAllCompanies(){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT cid, name, email, password, description FROM companies' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() ){
			$arr[] = new Company( $row['cid'], $row['name'], $row['email'], $row['password'], $row['description'] );
		}

		return $arr;
	}


	function searchInternshipsByTitle( $query ){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( "SELECT iid, cid, title, requirements, description FROM internships WHERE LOWER(title) LIKE '%:query%'" );
			$st->execute(array( 'query' => $query));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() ){
			$arr[] = new Internship( $row['iid'], $row['cid'], $row['title'], $row['requirements'], $row['description'] );
		}

		return $arr;
	}


	function searchInternshipsById( $iid ){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( "SELECT iid, cid, title, requirements, description FROM internships WHERE iid=:iid" );
			$st->execute(array( 'iid' => $iid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		$temp = new Internship( $row['iid'], $row['cid'], $row['title'], $row['description'], $row['requirements'] );

		return $temp;
	}


	function searchInternshipsByCompany( $cid ){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT iid, cid, title, requirements, description FROM internships WHERE cid=:cid' );
			$st->execute(array( 'cid' => $cid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() ){
			$arr[] = new Internship( $row['iid'], $row['cid'], $row['title'], $row['requirements'], $row['description'] );
		}

		return $arr;
	}


	function searchApplicationsByInternship( $iid ){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT iid, sid, status FROM applications WHERE iid=:iid' );
			$st->execute(array( 'iid' => $iid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() ){
			$arr[] = new Application( $row['iid'], $row['sid'], $row['status']);
		}

		return $arr;
	}


	function searchApplicationsByStudent( $sid ){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT iid, sid, status FROM applications WHERE sid=:sid' );
			$st->execute(array( 'sid' => $sid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() ){
			$arr[] = new Application( $row['iid'], $row['sid'], $row['status']);
		}

		return $arr;
	}


	function searchInternshipsByStudent($sid){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT internships.iid, internships.cid, internships.title, internships.requirements, internships.description FROM internships, applications WHERE applications.sid=:sid AND internships.iid=applications.iid' );
			$st->execute(array( 'sid' => $sid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 0 )
			return 0;

		$arr = array();
		while( $row = $st->fetch() ){
			$arr[] = new Internship( $row['iid'], $row['cid'], $row['title'], $row['requirements'], $row['description']);
		}

		return $arr;
	}


	function createNewStudent( $name, $email, $password){
		// prvo provjeriti postoji li taj student
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT sid FROM students WHERE email=:email' );
			$st->execute(array( 'email' => $email));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() !== 0 )
			return 0;

		//znaci student ne postoji:
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO students (name, email, password) VALUES(:name, :email, :password)' );
			$st->execute(array( 'name' => $name, 'email' => $email, 'password' => $password));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		return 1;
	}


	function createNewCompany($name, $email, $password, $description){
		// prvo provjeriti postoji li ta tvrtka
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT cid FROM companies WHERE name=:name' );
			$st->execute(array( 'name' => $name));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() !== 0 )
			return 0;

		//znaci tvrtka jos ne postoji:
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO companies (name, email, password, description) VALUES(:name, :email, :password, :description)' );
			$st->execute(array( 'name' => $name, 'email' => $email, 'password' => $password, 'description' => $description));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		return 1;
	}


	function createNewInternship($cid, $title, $description, $requirements){
		// prvo provjeriti postoji li taj internship
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT iid FROM internships WHERE cid=:cid AND title=:title' );
			$st->execute(array( 'cid' => $cid, 'title' => $title));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() !== 0 )
			return 0;
		//znaci internship ne postoji:
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO internships (cid, title, description, requirements) VALUES(:cid, :title, :description, :requirements)' );
			$st->execute(array( 'cid' => $cid, 'title' => $title, 'description' => $description, 'requirements' => $requirements));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		return 1;
	}


	function createNewApplication($iid, $sid){
		//prvo provjeriti je li se vec taj student prijavio na tu praksu
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT iid, sid FROM applications WHERE iid=:iid AND sid=:sid' );
			$st->execute(array( 'iid' => $iid, 'sid' => $sid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() !== 0 )
			return 0;

		//znaci student ne postoji:
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO applications (iid, sid, status) VALUES(:iid, :sid, :status)' );
			$st->execute(array( 'iid' => $iid, 'sid' => $sid, 'status' => 'čekanje'));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		return 1;
	}


	function studentExist($email){
		//provjerava postoji li student sa zadani emailom
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT sid FROM students WHERE email=:email' );
			$st->execute(array( 'email' => $email));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 1 ){
			return 1;
		}
		else
			return 0;
	}


	function companyExist($email){
		//provjerava postoji li tvrtka sa zadanim emailom
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT cid FROM companies WHERE email=:email' );
			$st->execute(array( 'email' => $email));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 1 ){
			return 1;
		}
		else
			return 0;
	}


	function getStudentPassword($email){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT password FROM students WHERE email=:email' );
			$st->execute(array( 'email' => $email));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 1 ){
			$row = $st->fetch();
			return $row['password'];
		}
		else
			return 0;
	}


	function getCompanyPassword($email){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT password FROM companies WHERE email=:email' );
			$st->execute(array( 'email' => $email));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 1 ){
			$row = $st->fetch();
			return $row['password'];
		}
		else
			return 0;
	}


	function getStudentId($email){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT sid FROM students WHERE email=:email' );
			$st->execute(array( 'email' => $email));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 1 ){
			$row = $st->fetch();
			return $row['sid'];
		}
		else
			return 0;
	}


	function getCompanyId($email){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT cid FROM companies WHERE email=:email' );
			$st->execute(array( 'email' => $email));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 1 ){
			$row = $st->fetch();
			return $row['cid'];
		}
		else
			return 0;
	}


	function getStudentName($sid){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT name FROM students WHERE sid=:sid' );
			$st->execute(array( 'sid' => $sid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 1 ){
			$row = $st->fetch();
			return $row['name'];
		}
		else
			return 0;
	}


	function getCompanyName($cid){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT name FROM companies WHERE cid=:cid' );
			$st->execute(array( 'cid' => $cid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 1 ){
			$row = $st->fetch();
			return $row['name'];
		}
		else
			return 0;
	}


	function getInternshipTitle($iid){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT title FROM internships WHERE iid=:iid' );
			$st->execute(array( 'iid' => $iid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 1 ){
			$row = $st->fetch();
			return $row['title'];
		}
		else
			return 0;
	}


	function insertProfile($email, $name, $education, $experience, $projects, $prizes){
		//prvo provjerimo postoji li vec taj profil
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT email FROM profiles WHERE email=:email' );
			$st->execute(array( 'email' => $email));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 1 ){
			//ako postoji UPDATE-amo ga
			try{
				$db = DB::getConnection();
				$st = $db->prepare( 'UPDATE profiles SET education=:education, experience=:experience, projects=:projects, prizes=:prizes WHERE email=:email' );
				$st->execute(array( 'email' => $email, 'education' => $education, 'experience' => $experience, 'projects' => $projects, 'prizes' => $prizes));
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		}
		else{
			//inace unesimo novi profil u bazu
			try{
				$st = $db->prepare( 'INSERT INTO profiles(email, name, education, experience, projects, prizes) VALUES (:email, :name, :education, :experience, :projects, :prizes)' );

				$st->execute(array( 'email' => $email, 'name' => $name, 'education' => $education, 'experience' => $experience, 'projects' => $projects, 'prizes' => $prizes));

			}
			catch( PDOException $e ) { exit( "PDO error #4: " . $e->getMessage() ); }

		}
	}


	function getStudentProfile($email){
		//ako jos nema tog profila posaljemo prazan profila

		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT email FROM profiles WHERE email=:email' );
			$st->execute(array( 'email' => $email));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 0 ){
			//posaljemo prazan Profile
			$temp = new Profile($email, $_SESSION['name'], '','','','');
			return $temp;
		}

		//postoji taj profil, posalji ga
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT email, name, education, experience, projects, prizes FROM profiles WHERE email=:email' );
			$st->execute(array( 'email' => $email));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		$temp = new Profile($email, $row['name'], $row['education'], $row['experience'], $row['projects'], $row['prizes']);
		return $temp;
	}


	function deleteInternship($iid){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'DELETE FROM internships WHERE iid=:iid' );
			$st->execute(array( 'iid' => $iid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		//izbrisali smo praksu
		//moramo svim studentima prijavljenim na tu praksu staviti status "odbijen"

		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE applications SET status="odbijen" WHERE iid=:iid' );
			$st->execute(array( 'iid' => $iid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}


	function getProfilesByIid($iid){
		//vraca sve profile svih studenata prijavljenih na praksu iid
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT profiles.name, profiles.email, profiles.education, profiles.experience, profiles.projects, profiles.prizes FROM profiles, applications, students WHERE applications.iid=:iid AND applications.sid=students.sid AND students.email=profiles.email AND applications.status!="odbijen"' );
			$st->execute(array( 'iid' => $iid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 0 ){
			return 0;
		}

		$arr = array();
		while( $row = $st->fetch() ){
			$arr[] = new Profile( $row['email'], $row['name'], $row['education'], $row['experience'], $row['projects'], $row['prizes']);
		}

		return $arr;
	}


	function getStudentsByIid($iid){
		//vraca studente koji su prijavljeni na praksu iid
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT students.sid, students.name, students.email, students.password FROM students, applications WHERE applications.iid=:iid AND applications.sid=students.sid' );
			$st->execute(array( 'iid' => $iid));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if( $st->rowCount() === 0 ){
			return 0;
		}

		$arr = array();
		while( $row = $st->fetch() ){
			$arr[] = new Student( $row['sid'], $row['name'], $row['email'], $row['password']);
		}

		return $arr;
	}

	function updateStatus($iid, $sid, $status){
		//promijeni status prijavi studenta sid na praksu iid
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE applications SET status=:status WHERE iid=:iid AND sid=:sid');
			$st->execute(array( 'iid' => $iid, 'sid' => $sid, 'status' => $status));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}
};

?>
