<?php

require_once('connexion.php');

$request = "SELECT Affiche_slider FROM dn_objets WHERE Affiche_slider LIKE 'images/slider/%' ";

?>

<!DOCTYPE html>
<html>
    <head>
        <link href='css/style.css' rel='stylesheet'>
        <link href='css/accueil.css' rel='stylesheet'>
        <link href='css/header.css' rel='stylesheet'>
        <link href='css/footer.css' rel='stylesheet'>
        <title>Dixnez +</title>
    </head>
    <body>
    <header>
            <div class="wrap">
                <img src="images/icones/logo.svg">
                <nav>
                    <ul>
                        <li><a href="home.php"><img src="images/icones/accueil.svg"><p>ACCUEIL</p></a></li>
                        <li><a href="films.php"><img src="images/icones/films.svg"><p>FILMS</p></a></li>
                        <li><a href="livres.php"><img src="images/icones/livres.svg"><p>LIVRES</p></a></li>
                        <li><a href="musiques.php"><img src="images/icones/musiques.svg"><p>MUSIQUES</p></a></li>
                        <li><a href="multimedias.php"><img src="images/icones/multi.svg"><p>MULTIMÉDIAS</p></a></li>
                    </ul>
                </nav>
                <div class="ajout">
                    <ul>
                        <li><a href="gestion.php"><img src="images/icones/gestion.svg"><p>GESTION</p></a></li>
                        <li><a href="inscription.php"><img src="images/icones/inscription.svg"><p>INSCRIPTION</p></a></li>
                    </ul>
                </div>
            </div>
        </header>

        <main>
            <div class="wrap">
                <h2>Nouveautés</h2>
                <div class="img-slider">
                    <div class="slider--container">
                        <div class="prev-btn"><</div>
                        <div class="next-btn">></div>
                        <div class="slider--content" position="1" style="left:0%">
                        <?php if ($dn_objets = mysqli_query($CONNEXION, $request)): ?>
                            <?php foreach($dn_objets as $dn_objet): ?>
                                <img src="<?php echo $dn_objet['Affiche_slider'] ?>">
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <ul class="dots">
                        <?php for($i=0; $i < mysqli_num_rows($dn_objets); $i++): ?>
                            <li class="dot <?= $i === 0 ? 'current' : '' ?>" pos="<?= $i ?>"></li>
                        <?php endfor; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
            <div class="whoWeR">
                <h2>Qui sommes nous ?</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean lobortis euismod turpis vel efficitur. Praesent non orci justo. Fusce rhoncus ut magna non convallis. Phasellus vitae risus ut erat scelerisque efficitur. Nunc tempor velit ac lectus ultrices, sit amet scelerisque ligula ultricies. Cras tempor dui eget cursus feugiat. Morbi vulputate, neque vel posuere pharetra, est lectus tincidunt lacus, in laoreet leo erat a tortor. Sed pulvinar volutpat purus, id ornare nulla malesuada ultricies. Pellentesque in nibh eu eros auctor fringilla id id purus. Maecenas in dictum orci, et eleifend ipsum. Aliquam pellentesque magna in faucibus rutrum.
                </p>
            </div>
        </main>
        <footer>
            <img src="images/icones/logo2.svg">
            <p>Si vous avez des questions ou un problèmes, contactez-nous à l'adresse suivante :</p>
            <p><span>serviceclient@dixnez.com</span> ou au <span>06 10 11 12 13</span></p>
            <p>Le contenu et les plateformes disponibles peuvent varier selon la zone géographique.</p>
            <p>© 2023 Dixnez et ses sociétés affiliées. Tous droits réservés.</p>
        </footer>

        <script src="js/slider.js"></script>
    </body>
</html>