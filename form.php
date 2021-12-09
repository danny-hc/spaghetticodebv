<h2>Nieuwe afbeelding</h2>

<form method="post" enctype="multipart/form-data" >
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_IMAGE_SIZE; ?>">

    <label for="title">Titel: </label>
    <input type="text" name="title" id="title"><br><br>
    <label for="image">Afbeelding: </label>
    <input type="file" name="image" id="image"><br><br>
    <input type="submit" value="uploaden">
</form>