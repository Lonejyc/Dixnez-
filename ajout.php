<!DOCTYPE html>
<html>
    <head>
        <?php
        require_once('connexion.php');
        ?>
        <link href='css/style.css' rel='stylesheet'>
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
                <div class="top">
                    <h1>Ajout</h1>
                        <p>Veuillez choisir la catégorie de l'objet à ajouter</p>
                        <select name="select" id="select" onchange="this.form.submit();">
                            <option value="cat" <?php echo ($select_value == "cat" ? 'selected' : ''); ?>>Vinyle</option>
                            <option value="date_up" <?php echo ($select_value == "date_up" ? 'selected' : ''); ?>>CD</option>
                            <option value="date_down" <?php echo ($select_value == "date_down" ? 'selected' : ''); ?>>Manga</option>
                            <option value="disp_yes" <?php echo ($select_value == "disp_yes" ? 'selected' : ''); ?>>Roman</option>
                            <option value="disp_no" <?php echo ($select_value == "disp_no" ? 'selected' : ''); ?>>BD</option>
                            <option value="disp_no" <?php echo ($select_value == "disp_no" ? 'selected' : ''); ?>>E-Book</option>
                            <option value="disp_no" <?php echo ($select_value == "disp_no" ? 'selected' : ''); ?>>DVD</option>
                            <option value="disp_no" <?php echo ($select_value == "disp_no" ? 'selected' : ''); ?>>Blu-ray</option>
                            <option value="disp_no" <?php echo ($select_value == "disp_no" ? 'selected' : ''); ?>>Multimediay</option>
                        </select>
                </div>
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