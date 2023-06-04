<?php
// Récupère les données saisies par l'utilisateur
if(isset($_POST['action'])) {
    if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mail'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];

        // Connexion à la base de données
        $connect = mysqli_connect('localhost', 'root', '', 'dixnez');

        // Vérifie si la connexion a réussi
        if (!$connect) {
            die('Erreur de connexion : ' . mysqli_connect_error());
        }

        // Prépare la requête SQL pour insérer les données dans la table "utilisateurs"
        $request = "INSERT INTO dn_client (Nom, Prenom, Mail) VALUES ('$nom', '$prenom', '$mail')";

        // Exécute la requête SQL
        if (mysqli_query($connect, $request)) {
            $succes = "Votre compte a été créé avec succès";
        } else {
            echo "Erreur : " . mysqli_error($connect);
        }

        // Ferme la connexion à la base de données
        mysqli_close($connect);
    } else $erreur = "Veuillez remplir tout les champs";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="css/style.css" rel="stylesheet">
        <title>Dixnez +</title>
    </head>
    <body>
        <header>
            <img src="images/icones/logo.svg">
            <nav>
                <ul>
                    <li><a href="home.php"><img src="images/icones/accueil.svg">ACCUEIL</a></li>
                    <li><a href="films.php"><img src="images/icones/films.svg">FILMS</a></li>
                    <li><a href="livres.php"><img src="images/icones/livres.svg">LIVRES</a></li>
                    <li><a href="musiques.php"><img src="images/icones/musiques.svg">MUSIQUES</a></li>
                    <li><a href="multimedias.php"><img src="images/icones/multi.svg">MULTIMÉDIAS</a></li>
                </ul>
            </nav>
            <div class="ajout">
                <a href="ajout.php"><img src="images/icones/ajout.svg">AJOUT</a>
                <a href="inscription.php"><img src="images/icones/">INSCRIPTION</a>
            </div>
        </header>
        <main>
            <div class="wrap">
            <?php if(isset($succes)) {?>
                <span class="succes"><?php echo $succes ?></span>
            <?php } if(isset($erreur)) {?>
                <span class="erreur" ><?php echo $erreur ?></span>
            <?php } ?>
                <form method="POST" action="#">
                    <input type="text" name="nom" placeholder="Nom">
                    <input type="text" name="prenom" placeholder="Prénom">
                    <input type="text" name="mail" placeholder="Mail">
                    <button type="submit" name="action" value="Emprunter">S'inscrire</button>
                </form>
            </div>
        </main>
        <footer>
        <img src="images/icones/logo2.svg">
            <p>Si vous avez des questions ou un problèmes, contactez-nous à l'adresse suivante :</p>
            <p><span>serviceclient@dixnez.com</span> ou au <span>06 10 11 12 13</span></p>
            <p>Le contenu et les plateformes disponibles peuvent varier selon la zone géographique.</p>
            <p>© 2023 Dixnez et ses sociétés affiliées. Tous droits réservés.</p>
        </footer>
    </body>
</html>