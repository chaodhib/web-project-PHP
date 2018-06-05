<?php
include_once(__DIR__ . '/../config.php');
include_once (APP_ROOT."/accueil.php");
?>
<?php 	if(isset($warning) && !empty($warning)){ ?>

	        <div class="alert alert-warning alert-dismissable">
	            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	            <strong>Warning!</strong> <?php echo $warning; ?>
	        </div>
<?php 	}else if(isset($alert) && $alert){?>
			<div class="alert alert-success alert-dismissable">
  				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  				<strong>Success!</strong> Billet crée.
			</div>
<?php 	}?>

<div class="row banderolCreationBillet" style="margin-bottom:80px">
	<div class="col-md-12 tchatBoxDroit">
		Ajouter un nouveau billet :
	</div>
	
</div>


<form class="form-horizontal" method="post" action="">
	<div class="form-group">
	    <label class="control-label col-sm-2" for="titre">Titre :</label>
	    <div class="col-sm-10">
	    	<input type="texte" class="form-control" id="titre" name="titre" placeholder="Titre">
	    </div>
  	</div>

  	<div class="form-group">
    	<label class="control-label col-sm-2" for="texte">Texte :</label>
    	<div class="col-sm-10">
      		<textarea class="form-control" rows="5" id="texte" name="texte" placeholder="Texte"></textarea>
    	</div>
  	</div>

  	<input type="hidden" name="hiden" value="h1">

  	<div class="form-group">
    	<div class="col-sm-offset-2 col-sm-10">
      		<button type="submit" class="btn btn-default">Submit</button>
    	</div>
  	</div>
</form> 

<?php

if(isset($_POST) && !empty($_POST['texte']) && !empty($_POST['titre'])) {
    extract($_POST);
    $_query1 = "insert into post(titre_bil,texte_bil,dateCreation_bil,id_membre) values (?,?,?,?)";

    try {
        $bdd = getDatabase();
        $req = $bdd->prepare($_query1) or die (print_r($bdd->errorinfo()));
        $today = date("Y-m-d");
        $uni = $req->execute(array($_POST["texte"], $_POST["titre"], $today, 1));

        //si $uni content false alors il ya violation de la contrainte unique
        if (!$uni) {
            throw new Exception("Violation de containt Unique : Changer le Titre du billet ");
        }

        header("Location: /accueil.php");

    } catch (Exception $e) {
        throw ($e);
    }
}
?>