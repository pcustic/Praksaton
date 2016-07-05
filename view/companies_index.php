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

<div class="internship"><table>

<?php
//ispisi popis praksi
	if($internshipList == false){
		echo '<p>Još niste stvorili niti jednu praksu. Požurite stvoriti novu praksu kao bi mogli što prije odabrati pravog studenta.</p>';
	}
	else{
		foreach( $internshipList as $internship ){
			echo '<tr><td>' .
				'<h2 style="display:inline;">' .
				$internship->title .
				'</h2></td>';
	?>
	        <td>
	    	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=internships/companyPreview" style='display:inline;'>
	    		<input type="hidden" name="iid" value="<?php echo $internship->iid;?>"/>
	    		<button type="submit">Pregledaj</button>
	    	</form>
	        </td>

	        <td>
	        <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=internships/appliedStudents" style='display:inline;'>
	    		<input type="hidden" name="iid" value="<?php echo $internship->iid;?>"/>
	    		<button type="submit">Prijavljeni studenti</button>
	    	</form>
	        </td>

	        <td>
	        <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=internships/delete" style='display:inline;'>
	    		<input type="hidden" name="iid" value="<?php echo $internship->iid;?>"/>
	    		<button type="submit">Ukloni</button>
	    	</form>
	        </td></tr>
<?php
	    }
		echo "</table></div>";
	}
?>

	<a href="<?php echo __SITE_URL; ?>/index.php?rt=companies/newInternship"><button class="novaPraksa">Stvori novu praksu</button></a>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
