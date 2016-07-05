<?php

class InternshipsController extends BaseController{
	public function index(){
		header( 'Location: ' . __SITE_URL );
		exit();
	}

	public function preview(){
		//funkcija koja priprema podatke i prikazuje opis pojedinog internshipa
		$is = new InternshipService();

		if(!isset($_POST['iid'])){
			//ne znamo koji internship prikazati
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		$this->registry->template->internship = $is->searchInternshipsById($_POST['iid']);
		$this->registry->template->title = $is->getInternshipTitle($_POST['iid']);
		$this->registry->template->companiesList = $is->getAllCompanies();
		$this->registry->template->show('internship_preview');
	}

	public function companyPreview(){
		//slicno kao preview ali samo za internshipe pojedine tvrtke
		$is = new InternshipService();

		if(!isset($_SESSION['cid'])){
			//tvrtka nije ulogirana
			header( 'Location: ' . __SITE_URL);
			exit();
		}

		if(!isset($_POST['iid'])){
			//ne znamo koji internship prikazati
			header( 'Location: ' . __SITE_URL . '/index.php?rt=companies');
			exit();
		}

		$this->registry->template->internship = $is->searchInternshipsById($_POST['iid']);
		$this->registry->template->title = $is->getInternshipTitle($_POST['iid']);
		$this->registry->template->show('companies_internship_preview');
	}

	public function applyForm(){
		//funkcija koja prikazuje formu za prijavu na internship
		$is = new InternshipService();
		if(!isset($_POST['iid']) || !isset($_SESSION['sid'])){
			//ne znamo koji internship prikazati
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		$this->registry->template->title = 'Prijava na praksu';
		$this->registry->template->internshipTitle = $is->getInternshipTitle($_POST['iid']);
		$this->registry->template->show('internship_applyForm');
	}

	public function apply(){
		//funkcija koja prijavljuje studenta na praksu
		$is = new InternshipService();
		if(!isset($_POST['iid']) || !isset($_SESSION['sid'])){
			//ne znamo koji internship prikazati
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		if($is->createNewApplication($_POST['iid'], $_SESSION['sid']) === 1){
			//prijava je uspjela
			$this->registry->template->title = 'Prijava je uspjela!';
		}
		else{
			//vec se prijavio
			$this->registry->template->title = "Ups..";
			$this->registry->template->msg = "Čini se da ste se već prijavili na tu praksu!";
		}

		$this->registry->template->show('internship_apply');
	}

	public function add(){
		//sprema novu praksu u bazu
		$is = new InternshipService();
		if(!isset($_SESSION['cid'])){
			//netko je dosao rucno tu a tvrtka nije ulogirana
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		if(!isset($_POST['cid']) || !isset($_POST['title']) || !isset($_POST['description']) || !isset($_POST['requirements'])){
			//nedostaju neki podaci
			$this->registry->template->title = "Ups..";
			$this->registry->template->msg = "Čini se da nedostaju neki podaci.";
			$this->registry->template->show('companies_error');
		}

		if($is->createNewInternship($_POST['cid'], $_POST['title'], $_POST['description'], $_POST['requirements'])){
			//stvorili smo novu praksu, vrati na popis
			$this->registry->template->internshipList = $is->searchInternshipsByCompany($_SESSION['cid']);
            $this->registry->template->title = 'Popis praksi';
            $this->registry->template->show('companies_index');
		}
	}

	public function delete(){
		//brise odabranu praksu
		$is = new InternshipService();

		if(!isset($_SESSION['cid'])){
			//netko je izvana pokusao obrisati praksu
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		if(!isset($_POST['iid'])){
			//ne znamo koju praksu izbrisati
			header( 'Location: ' . __SITE_URL . '/index.php?rt=companies' );
			exit();
		}

		//znamo tko brise i sto brise:
		$is->deleteInternship($_POST['iid']);

		//vrati se na popis praksi
		$this->registry->template->internshipList = $is->searchInternshipsByCompany($_SESSION['cid']);
		$this->registry->template->title = 'Popis praksi';
		$this->registry->template->show('companies_index');
	}

	public function appliedStudents(){
		//prikazuje studente prijavljene (primljene i na cekanju) za odabranu praksu
		$is = new InternshipService();

		if(!isset($_SESSION['cid'])){
			//netko je izvana pokusao pristupiti
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		if(!isset($_POST['iid'])){
			//ne znamo koja praksa je odabrana
			header( 'Location: ' . __SITE_URL . '/index.php?rt=companies' );
			exit();
		}
		//dohvatimo listu profila studenata koji su se prijavili na tu praksu
		$this->registry->template->profileList = $is->getProfilesByIid($_POST['iid']);

		//dohvatimo listu prijava za tu praksu
		$this->registry->template->applicationList = $is->searchApplicationsByInternship($_POST['iid']);

		//dohvatimo listu studenata prijavljenih na tu praksu
		//treba nam zbog odredjivanja sid-a studenta (u profilima je ime i email)
		$this->registry->template->studentList =  $is->getStudentsByIid($_POST['iid']);

		$this->registry->template->title = 'Popis prijavljenih studenata';
		$this->registry->template->internship = $is->getInternshipTitle($_POST['iid']);
		$this->registry->template->internshipIid = $_POST['iid'];
		$this->registry->template->show('companies_applied_students');
	}

	public function changeStatus(){
		//primi/odbije studenta na praksu
		$is = new InternshipService();

		if(!isset($_SESSION['cid'])){
			//netko je izvana pokusao pristupiti
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		if(!isset($_POST['iid']) || !isset($_POST['sid']) || !isset($_POST['status'])){
			//netko je direktno dosao ovdje
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		if($_POST['status'] != 'primljen' && $_POST['status'] != 'odbijen'){
			//krivi status je poslan, vrati na pocetnu
			header( 'Location: ' . __SITE_URL );
			exit();
		}

		//sve je u redu, promijeni status prijave
		$is->updateStatus($_POST['iid'], $_POST['sid'], $_POST['status']);

		//ponovno prikazi profile prijavljenih studenata
		$this->registry->template->profileList = $is->getProfilesByIid($_POST['iid']);

		//dohvatimo listu prijava za tu praksu
		$this->registry->template->applicationList = $is->searchApplicationsByInternship($_POST['iid']);

		//dohvatimo listu studenata prijavljenih na tu praksu
		//treba nam zbog odredjivanja sid-a studenta (u profilima je ime i email)
		$this->registry->template->studentList =  $is->getStudentsByIid($_POST['iid']);

		$this->registry->template->title = 'Popis prijavljenih studenata';
		$this->registry->template->internship = $is->getInternshipTitle($_POST['iid']);
		$this->registry->template->internshipIid = $_POST['iid'];
		$this->registry->template->show('companies_applied_students');
	}
};

?>
