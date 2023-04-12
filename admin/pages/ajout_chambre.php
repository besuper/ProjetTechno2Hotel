<?php

$errors = [];

if (isset($_POST["submit"])) {
	extract($_POST);

	if (empty($nom)) {
		$errors["nom"] = "Le champ nom ne peut pas être vide!";
	}

	if (empty($prix)) {
		$errors["prix"] = "Le prix ne peut pas être vide!";
	}

	if (empty($lits)) {
		$errors["lits"] = "Iniquez le nombre de lits";
	}

	if (empty($description)) {
		$errors["description"] = "La description ne peut pas être vide!";
	}

	$check = getimagesize($_FILES["image"]["tmp_name"]);

	if (!$check) {
		$errors["image"] = "Erreur lors de l'upload de l'image";
	}

	$target_dir = "./images/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);

	if (file_exists($target_file)) {
		$errors["image"] = "Cette image éxiste déjà";
	}

	if (empty($errors)) {
		// tout les champs sont vérifié

		$cnx = Connexion::getInstance($dsn, $user, $pass);

		$fl = new ChambreBD($cnx);
		$fl->hydrate(array(
			"nom" => $nom,
            "prix" => $prix,
            "lit" => $lits,
            "description" => $description,
            "image" => $_FILES["image"]["name"]
		));

		$executed = $fl->insert();

        if($executed) {
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				// tout est ok
                header("Location: ./index.php?page=chambres.php");
			} else {
				$errors["global"] = "Impossible d'upload l'image";
			}
        }else {
            $errors["global"] = "Impossible d'ajouter la nouvelle chambre";
        }
	}
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Ajout chambre</title>
</head>
<body>
<div class="container-fluid">
    <h1>Ajout d'une chambre</h1>

    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-6">
                <label for="nom" class="form-label">Nom de chambre</label>
                <input type="text" class="form-control" id="nom" name="nom">

                <div id="error" class="form-text text-danger"><?php echo isset($errors["nom"]) ? $errors["nom"] : ''; ?></div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="number" min="0" class="form-control" id="prix" name="prix">

                <div id="error" class="form-text text-danger"><?php echo isset($errors["prix"]) ? $errors["prix"] : ''; ?></div>
            </div>

            <div class="col-3">
                <label for="lits" class="form-label">Nombre de lits</label>
                <input type="number" min="0" class="form-control" id="lits" name="lits">

                <div id="error" class="form-text text-danger"><?php echo isset($errors["lits"]) ? $errors["lits"] : ''; ?></div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-6">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" placeholder="Description de la chambre" name="description"
                          id="description" style="height: 100px"></textarea>

                <div id="error" class="form-text text-danger"><?php echo isset($errors["description"]) ? $errors["description"] : ''; ?></div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-4">
                <label for="image" class="form-label">Image</label>
                <input class="form-control" type="file" name="image" id="image">

                <div id="error" class="form-text text-danger"><?php echo isset($errors["image"]) ? $errors["image"] : ''; ?></div>
            </div>
        </div>

        <div id="error" class="form-text text-danger mt-4"><?php echo isset($errors["global"]) ? $errors["global"] : ''; ?></div>

        <button type="submit" class="btn btn-primary mt-4" name="submit">Ajouter</button>
    </form>
</div>
</body>
</html>
