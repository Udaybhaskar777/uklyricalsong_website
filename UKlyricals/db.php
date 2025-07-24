<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'songs';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!.. copy this query in your phpmyadmin 

  CREATE TABLE songs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    artist VARCHAR(255) NOT NULL,
    album VARCHAR(255),
    lyrics TEXT NOT NULL,
    language VARCHAR(100),
    genre VARCHAR(100),
    tags VARCHAR(255),
    cover_image VARCHAR(255) NOT NULL,
    song_file VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

>
