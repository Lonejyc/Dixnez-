<?php

require_once('connexion.php');

$request = "SELECT id, titre, date_sortie, duree, note_presse, note_public, affiche FROM films";

?>

<link href='style.css' rel='stylesheet'>
<?php if ($films = mysqli_query($CONNEXION, $request)): ?>
    <?php foreach($films as $film): ?>
        <div style='border: 1px solid black;'>
            <?php echo $film['id']; ?><br>
            <strong><?php echo $film['titre']; ?></strong><br>
            <?php echo $film['affiche']; ?><br>
            <span class='film_label'>Presse : </span><?php echo $film['note_presse']; ?><br>
            <span class='film_label'>Public : </span><?php echo $film['note_public']; ?><br>
        </div>
    <?php endforeach; ?>
<?php endif; ?>