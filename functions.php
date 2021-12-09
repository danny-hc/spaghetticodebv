<?php

function processImageUpload($title, $upload_data) {
    $file_upload_errors = array(
        1 => 'De afbeelding is groter dan de upload_max_filesize instelling in php.ini',
        2 => 'De afbeelding is groter dan de MAX_FILE_SIZE optie in het HTML form',
        3 => 'De afbeelding is maar deels geupload',
        4 => 'Geen afbeelding geupload',
        6 => 'Tijdelijke map ontbreekt',
        7 => 'Fout opgetreden tijdens het wegschrijven van de afbeelding',
        8 => 'Een PHP extensie blokkeert het uploaden',
    );

    $allowed_extensions = array(
      'jpg', 'gif'
    );

    // wat doet dit?
    if (empty($title)) {
        return array(
            'succes' => false,
            'message' => 'Geen titel opgegeven'
        );
    }

    // .....?
    if (!is_dir(IMAGE_FOLDER) && !mkdir(IMAGE_FOLDER)) {
        return array(
            'succes' => false,
            'message' => 'De upload map "' . IMAGE_FOLDER . '" bestaat niet en kan ook niet worden aangemaakt'
        );
    }

    if ($upload_data['error'] != 0) {
        return array(
            'succes' => false,
            'message' => $file_upload_errors[$upload_data['error']]
        );
    }

    if ($upload_data['size'] > MAX_IMAGE_SIZE) {
        return array(
            'succes' => false,
            'message' => 'Het afbeeldingsbestand is te groot'
        );
    }

    if (!getimagesize($upload_data["tmp_name"])) {
        return array(
            'succes' => false,
            'message' => 'Het bestand is geen afbeelding'
        );
    }

    $image_filename_parts = explode('.', $upload_data['name']);

    $image_extension = array_pop($image_filename_parts);
    $image_extension = strtolower($image_extension);

    if (!in_array($image_extension, $allowed_extensions)) {
        return array(
            'succes' => false,
            'message' => 'Ongeldige type, toegestaan: jpg of gif'
        );
    }

    $original_filename = basename($upload_data['name']);

    do {
        $safe_filename = bin2hex(random_bytes(4)) . '.' . $image_extension;
    } while (file_exists($safe_filename));

    if (!move_uploaded_file($upload_data['tmp_name'], IMAGE_FOLDER . $safe_filename)) {
        $result = array(
            'succes' => false,
            'message' => 'Er is een onbekende fout opgetreden'
        );
    }

    return array(
        'succes' => true,
        'message' => 'OK',
        'title' => $title,
        'filename' => $safe_filename,
        'original_filename' => $original_filename
    );
}


function imageList() {
    $list = [];

    $handle = opendir(IMAGE_FOLDER);

    do {
        $file = readdir($handle);

        if ($file != false && $file != '.' && $file != '..') {
            $list[] = Array(
                'title' => $file,
                'filename' => $file
            );
        }
    } while($file);

    closedir($handle);

    return $list;
}


?>