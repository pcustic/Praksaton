<?php

class CompaniesController extends BaseController{
	public function index(){
        //ako tvrtka nije ulogirana ispisi login formu, inace popis praksi
        if(!isset($_SESSION['cid'])){
            $this->registry->template->title = 'Login';
            $this->registry->template->show('companies_loginForm');
        }
        else{
            //inace dobavi sve prakse te tvrtke i prikazi pocetnu
            $is = new InternshipService();
            $this->registry->template->internshipList = $is->searchInternshipsByCompany($_SESSION['cid']);
            $this->registry->template->title = 'Popis praksi';
            $this->registry->template->show('companies_index');
        }
	}

    public function registerForm(){
        //prikazi formu za registraciju
        if(isset($_SESSION['cid'])){
            //ako je tvrtka vec ulogirana pokazi im pocetnu
            header( 'Location: ' . __SITE_URL . '/index.php?rt=companies');
			exit();
        }

        $this->registry->template->title = 'Registracija';
        $this->registry->template->show('companies_registerForm');
    }

    public function login(){
		//funkcija koja obradjuje podatke za login i ulogirava tvrtku
		$is = new InternshipService();
		if(!isset($_POST['email']) || !isset($_POST['password'])){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da nedostaju neki podaci za login. Molimo pokušajte ponovno.';
			$this->registry->template->show('companies_registration_error');
			exit();
		}

		$email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL );
		if( filter_var( $email, FILTER_VALIDATE_EMAIL ) === false){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da email nije dobro unešen. Molimo pokušajte ponovno.';
			$this->registry->template->show('companies_registration_error');
			exit();
		}

		//svi podaci postoje i nisu opasni, provjeri postoji li taj korisnik

		if($is->companyExist($email) && password_verify( $_POST['password' ], $is->getCompanyPassword($email))){
			$_SESSION['cid'] = $is->getCompanyId($email);
			$_SESSION['cname'] = $is->getCompanyName($_SESSION['cid']);
			$_SESSION['cemail'] = $email;

			$this->registry->template->title = 'Popis praksi';
			$this->registry->template->internshipList = $is->searchInternshipsByCompany($_SESSION['cid']);
	    	$this->registry->template->show( 'companies_index' );
		}
		else if(!$is->companyExist($email)){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da taj korisnik ne postoji! Pokušajte ponovno.';
			$this->registry->template->show('companies_registration_error');
		}
		else{
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da ste unijeli pogrešnu lozinku! Pokušajte ponovno.';
			$this->registry->template->show('companies_registration_error');
		}
	}

    public function register(){
		//funkcija koja obradjuje podatke za registraciju nove tvrtke i stvara novu tvrtku u bazi
		$is = new InternshipService();

		if(!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['description'])){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da nedostaju neki podaci za registraciju. Molimo pokušajte se ponovno registrirati.';
			$this->registry->template->show('companies_registration_error');
			exit();
		}

		//znaci sva polja su popunjena, testiramo ih
		if( !preg_match( '/^[a-zA-Z -ČĆŠĐŽčćžšđ#+]{1,50}$/', $_POST['name'] ) ){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da ime nije dobro unešeno. Molimo pokušajte se ponovno registrirati.';
			$this->registry->template->show('companies_registration_error');
			exit();
		}

		if( filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) === false){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da email nije dobro unešen. Molimo pokušajte se ponovno registrirati.';
			$this->registry->template->show('companies_registration_error');
			exit();
		}

		if( !preg_match( '/^[a-zA-Z -,.0-9ČĆŠĐŽčćžšđ]+$/', $_POST['password'] ) ){
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Čini se da password nije dobro unešen. Molimo pokušajte se ponovno registrirati.';
			$this->registry->template->show('companies_registration_error');
			exit();
		}

		//sva polja su dobro popunjena, mozemo sanitizirati podatke i spremiti ih u bazu
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL );
		$password = password_hash( $_POST['password'], PASSWORD_DEFAULT );

		if($is->createNewCompany($name, $email, $password, $_POST['description'])){
            //registracija je uspjela
            $this->registry->template->title = 'Čestitamo!';
            $this->registry->template->errorMsg = 'Uspješno ste se registrirali!';
            $this->registry->template->show('companies_registration_error');
		}
		else{
			$this->registry->template->title = 'Ups!';
			$this->registry->template->errorMsg = 'Ta tvrtka već postoji! Pokušajte se ponovno registrirati.';
			$this->registry->template->show('companies_registration_error');
		}
	}

    public function logoutForm(){
		//ispisuje logout formu
		$this->registry->template->title = "Log out?";
		$this->registry->template->show('companies_logout');
	}

    public function logout(){
        //odjava tvrtke
        if(!isset($_POST['logout'])){
            //netko je rucno dosao do ovdje, preusmjeri na pocetnu
            header( 'Location: ' . __SITE_URL );
            exit();
        }

        //logout polje postoji, unisti session
        session_unset();
        session_destroy();

        header( 'Location: ' . __SITE_URL );
        exit();
    }

    public function newInternship(){
        if(!isset($_SESSION['cid'])){
            //netko je dosao rucno tu a tvrtka nije ulogirana
            header( 'Location: ' . __SITE_URL );
            exit();
        }

        $this->registry->template->title = 'Stvorite novu praksu';
        $this->registry->template->show('companies_newInternship');
    }

};

?>
