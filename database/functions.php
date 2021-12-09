<?php


function connectToDatabase() {
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=social', 'root', '');
    } catch (PDOException $e) {
        return false;
    }

    return $dbh;
}

function saveImageToDatabase($title, $filename, $original_filename) {
    $dbh = connectToDatabase();

    if (!$dbh) {
        echo 'wut';
        return false;
    }

    $query = "INSERT INTO images (title, filename, original_filename) VALUES (?, ?, ?)";

    $st = $dbh->prepare($query);

    if (!$st->execute(Array($title, $filename, $original_filename))) {
        echo 'wow';
        print_r($dbh->errorInfo());
        return false;
    }

    return $dbh->lastInsertId();
}

function imageListFromDatabase($id = null) {
    $dbh = connectToDatabase();

    if (!$dbh) {
        return false;
    }

    $sql = "SELECT * FROM images";

    if ($id) {
        $sql .= " WHERE id=" . $dbh->quote($id);
    }

    return $dbh->query($sql, PDO::FETCH_ASSOC);
}

function deleteImageFromDatabase($id) {
    // todo
}

?>