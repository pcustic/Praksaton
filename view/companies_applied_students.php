<?php
//ako session postoji ispisi ime, button za logout,
	if(isset($_SESSION['cname'])){
		echo '<p class="osobno">' . $_SESSION['cname'] . '</p>';

?>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=companies/logoutForm"><button>Log out</button></a>

		<br/>

<?php
    }
?>

<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<?php
//ispisi popis praksi
	if($profileList == false){
		echo '<p>Još uvijek nema prijavljenih studenata za ovu praksu.</p>';
	}
	else{
        echo '<h2>' . $internship .'</h2>';
        echo '<table class="students">';
        echo '<tr><th>Ime studenta</th><th>Email</th><th>Obrazovanje</th><th>Iskustvo</th><th>Projekti</th><th>Nagrade</th><th>Status</th><th></th><th></th></tr>';
		foreach( $profileList as $profile ){
            //prvo nadjimo status studenta
            $sid = -1;
            $status = "";
            foreach ($studentList as $student) {
                if($student->email === $profile->email){
                    $sid = $student->sid;
                    break;
                }
            }

            foreach ($applicationList as $application) {
                if($application->sid === $sid){
                    $status = $application->status;
                    break;
                }
            }
?>
            <tr>
                <td><?php echo htmlentities($profile->name, ENT_QUOTES);?></td>

                <td><?php echo htmlentities($profile->email, ENT_QUOTES);?></td>

                <td><?php echo htmlentities($profile->education, ENT_QUOTES);?></td>

                <td><?php echo htmlentities($profile->experience, ENT_QUOTES);?></td>

                <td><?php echo htmlentities($profile->projects, ENT_QUOTES);?></td>

                <td><?php echo htmlentities($profile->prizes, ENT_QUOTES);?></td>

                <td class="status"><?php echo htmlentities($status, ENT_QUOTES);?></td>

                <td>
                    <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=internships/changeStatus" style='display:inline;'>
        	    		<input type="hidden" name="iid" value="<?php echo $internshipIid;?>"/>
                        <input type="hidden" name="sid" value="<?php echo $sid;?>"/>
                        <input type="hidden" name="status" value="primljen"/>
        	    		<button type="submit" class="primljen">Primljen</button>
        	    	</form>
                </td>

                <td>
                    <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=internships/changeStatus" style='display:inline;'>
        	    		<input type="hidden" name="iid" value="<?php echo $internshipIid;?>"/>
                        <input type="hidden" name="sid" value="<?php echo $sid;?>"/>
                        <input type="hidden" name="status" value="odbijen"/>
        	    		<button type="submit" class="odbijen">Odbijen</button>
        	    	</form>
                </td>
            </tr>
<?php
	    }
		echo "</table>";
	}
?>

<span>
	<a href="<?php echo __SITE_URL; ?>/index.php?rt=companies"><button class="svePrakse">Sve prakse</button></a>
</span>

<script type="text/javascript" src="<?php echo __SITE_URL; ?>/view/companies_applied_students.js"></script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
