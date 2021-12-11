<?php

// dingen
CONST MAX_IMAGE_SIZE = 1024 * 1024 * 1024;
CONST IMAGE_FOLDER = 'uploads/';


include('functions.php');

// niet vergeten CREATE.SQL uit te voeren in PhpMyAdmin
// anders werkt dit programma niet eens
// (XAMPP -> MySQL -> Admin button -> in de webbrowser SQl tab)
include('database/functions.php');

// het begin blabla
include('header.php');

// nieuw bestand enzo
if (isset($_FILES['image'])) {
    $result = processImageUpload($_POST['title'], $_FILES['image']);

    // toegevoegd omdat het ineens in een database moest...
    if ($result['succes']) {
        if (!saveImageToDatabase($result['title'], $result['filename'], $result['original_filename'])) {
            // niet goed gegaan, bestand kan ook de prullenbak in
            unlink(IMAGE_FOLDER . $result['filename']);

            $result['succes'] = false;
            $result['message'] = 'Er is iets mis gegaan tijdens het opslaan in de database';
        }
    }

    if ($result['succes']) {
        echo '<h3 class="ok">Afbeelding ' . $result['original_filename'] . ' opgeslagen als ' . $result['filename'] . '!</h3>';
    } else {
        echo '<h3 class="error">Er is een fout opgetreden: ' . $result['message'] . '.</h3>';
    }
}

// als $_GET['delete'] bestaat dan de afbeelding verwijderen met het id nummer in 'delete'
if (isset($_GET['delete'])) {
    echo '<h3 class="error">Dit werkt nog niet, sorry.</h3>';

    // opzoeken hoe het bestand van de afbeelding heet
    // $result = imageListFromDatabase($_GET['delete']);
    // $image = $result->fetch();
    // laat maar....TODO
    // print_r($images);
}
searchInFile('bla', 'xx');
include('form.php');

// oude versie zonder database
// $images = imageList();
$images = imageListFromDatabase();

echo '<h2>Afbeeldingen</h2>';
echo '<div class="list">';

foreach($images as $image) {
    echo '<div class="item">';
    echo '<a href="' . IMAGE_FOLDER . $image['filename'] . '" target="_blank">';
    echo $image['title'];
    echo '<img src="' . IMAGE_FOLDER . $image['filename'] . '" class="image"><br>';
    echo '</a>';
    echo '<a href="?delete=' . $image['id'] . '">verwijder</a>';
    echo '</div>';
}

echo '</div>';

// klaar! yeah
include('footer.php');
?>


