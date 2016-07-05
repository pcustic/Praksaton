<?php

class StudentsController extends BaseController{
	public function index(){
		$is = new InternshipService();

		// Popuni template potrebnim podacima
		$this->registry->template->title = 'Popis svih praksi';
		$this->registry->template->internshipList = $is->getAllInternships();
		$this->registry->template->companiesList = $is->getAllCompanies();
    	$this->registry->template->show( 'students_index' );
	}

	public function loginForm(){
		$this->registry->template->title = 'Login!';
		$this->registry->template->show( 'login_form' );
	}

	public function registerForm(){
		$this->registry->template->title = 'Registracija!';
		$this->registry->template->show( 'register_form' );
	}

	public function register(){
		//funkcija koja obradjuje podatke za registraciju novog studenta i stvara novog studenta u bazi
		$is = new InternshipService();

		if(!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password'])){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da nedostaju neki podaci za registraciju. Molimo pokušajte se ponovno registrirati.';
			$this->registry->template->show('registration_error');
			exit();
		}

		//znaci sva polja su popunjena, testiramo ih
		if( !preg_match( '/^[a-zA-Z -ČĆŠĐŽčćžšđ]{1,50}$/', $_POST['name'] ) ){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da ime nije dobro unešeno. Molimo pokušajte se ponovno registrirati.';
			$this->registry->template->show('registration_error');
			exit();
		}

		if( filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) === false){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da email nije dobro unešen. Molimo pokušajte se ponovno registrirati.';
			$this->registry->template->show('registration_error');
			exit();
		}

		if( !preg_match( '/^[a-zA-Z -,.0-9ČĆŠĐŽčćžšđ]+$/', $_POST['password'] ) ){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da password nije dobro unešen. Molimo pokušajte se ponovno registrirati.';
			$this->registry->template->show('registration_error');
			exit();
		}

		//sva polja su dobro popunjena, mozemo sanitizirati podatke i spremiti ih u bazu
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL );
		$password = password_hash( $_POST['password'], PASSWORD_DEFAULT );

		if($is->createNewStudent($name, $email, $password)){
			$this->registry->template->title = 'Još samo jedan korak..';
			$this->registry->template->msg = 'Popuni što bolje svoj profil kako bi si povećao šansu za dobivanje prakse.';
			$this->registry->template->name = $name;
			$this->registry->template->email = $email;
			$this->registry->template->show('student_fillProfile');
		}
		else{
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Taj korisnik već postoji! Pokušajte se ponovno registrirati.';
			$this->registry->template->show('registration_error');
		}
	}


	public function login(){
		//funkcija koja obradjuje podatke za login i ulogirava novog korisnika
		$is = new InternshipService();
		if(!isset($_POST['email']) || !isset($_POST['password'])){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da nedostaju neki podaci za login. Molimo pokušajte ponovno.';
			$this->registry->template->show('registration_error');
			exit();
		}

		$email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL );
		if( filter_var( $email, FILTER_VALIDATE_EMAIL ) === false){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da email nije dobro unešen. Molimo pokušajte ponovno.';
			$this->registry->template->show('registration_error');
			exit();
		}

		//svi podaci postoje i nisu opasni, provjeri postoji li taj korisnik

		if($is->studentExist($email) && password_verify( $_POST['password' ], $is->getStudentPassword($email))){
			$_SESSION['sid'] = $is->getStudentId($email);
			$_SESSION['name'] = $is->getStudentName($_SESSION['sid']);
			$_SESSION['email'] = $email;

			$this->registry->template->title = 'Popis svih praksi';
			$this->registry->template->internshipList = $is->getAllInternships();
			$this->registry->template->companiesList = $is->getAllCompanies();
			$this->registry->template->name = $is->getStudentName($_SESSION['sid']);
	    	$this->registry->template->show( 'students_index' );
		}
		else{
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da taj korisnik ne postoji! Pokušajte ponovno.';
			$this->registry->template->show('registration_error');
		}
	}

	public function applications(){
		//funkcija koja prikazuje prakse na koje se student prijavio
		$is = new InternshipService();

		if(!isset($_SESSION['sid'])){
			//netko je petljao
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		$this->registry->template->title= 'Vaše prijave';
		$this->registry->template->internshipList = $is->searchInternshipsByStudent($_SESSION['sid']);
		$this->registry->template->applicationList = $is->searchApplicationsByStudent($_SESSION['sid']);
		$this->registry->template->show( 'students_applications' );
	}

	public function search(){
		//funkcija koja prikazuje rezultate pretrazivanja praksi
		$is = new InternshipService();

		if(!isset($_POST['query']) || !preg_match( '/^[a-zA-Z -,.0-9čćžšđ+#<>\/]{1,50}$/', $_POST['query'] )){
			//nesto je lose sa search queryem !!!!! promijeniti
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		//imamo query string, pretrazimo bazu
		$this->registry->template->title = "Rezultati pretrage: " . htmlentities($_POST['query'], ENT_QUOTES);
		$this->registry->template->companiesList = $is->getAllCompanies();

		$temp = $is->getAllInternships();
		$temp2 = array();
		$query = strtolower($_POST['query']);
		foreach ($temp as $internship) {
			if(strpos(strtolower($internship->title), $query) !== false){
				$temp2[] = new Internship($internship->iid, $internship->cid, $internship->title, $internship->description, $internship->requirements);
			}
		}
		$this->registry->template->internshipList = $temp2;
		$this->registry->template->search = 1;
		$this->registry->template->show( 'students_index' );
	}

	public function logoutForm(){
		//ispisuje logout formu
		$this->registry->template->title = "Log out?";
		$this->registry->template->show('students_logout');
	}

	public function logout(){
		//odjavi korisnika

		if(!isset($_POST['logout'])){
			//netko je rucno dosao do ovdje, preusmjeri na prakse
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		//logout polje postoji, unisti session
		session_unset();
		session_destroy();

		header( 'Location: ' . __SITE_URL );
		exit();
	}

	public function saveProfile(){
		//funkcija koja sprema podatke u profil studenta
		if(!isset($_POST['name']) || !isset($_POST['email'])){
			//netko je dosao tu rucno, vratimo ih na pocetak
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		$is = new InternshipService();
		//podatke provjerava javascript
		//ubacimo podatke u bazu, ako jos ne postoji taj profil stvori novi inace izmjeni postojeci

		$is->insertProfile($_POST['email'], $_POST['name'], $_POST['education'], $_POST['experience'], $_POST['projects'], $_POST['prizes']);

		$this->registry->template->title = 'Registracija gotova!';
		$this->registry->template->errorMsg = 'Čestitamo, uspješno ste se registrirali i ispunili svoj profil. Želimo Vam puno sreće u traženju prakse!';
		$this->registry->template->show('registration_error');
	}

	public function profile(){
		//funkcija koja dohvaca podatke iz profila za studenta i ispisuje formu za uredjivanje profila
		$is = new InternshipService();

		if(!isset($_SESSION['email'])){
			//netko je zatrazio profil tko nije ulogiran
			//vratimo ga na pocetak

			header( 'Location: ' . __SITE_URL );
			exit();
		}

		$this->registry->template->profile = $is->getStudentProfile($_SESSION['email']);
		$this->registry->template->title = 'Vaš profil';
		$this->registry->template->show('student_editProfile');
	}

	public function editProfile(){
		//funkcija koja sprema podatke u profil studenta
		if(!isset($_POST['name']) || !isset($_POST['email'])){
			//netko je dosao tu rucno, vratimo ih na pocetak
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		$is = new InternshipService();
		//podatke provjerava javascript
		//ubacimo podatke u bazu, ako jos ne postoji taj profil stvori novi inace izmjeni postojeci

		$is->insertProfile($_POST['email'], $_POST['name'], $_POST['education'], $_POST['experience'], $_POST['projects'], $_POST['prizes']);

		$this->registry->template->title = 'Popis svih praksi';
		$this->registry->template->internshipList = $is->getAllInternships();
		$this->registry->template->companiesList = $is->getAllCompanies();
    	$this->registry->template->show( 'students_index' );
	}
};

?>
