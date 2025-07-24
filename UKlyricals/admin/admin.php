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

<?php
// Add song

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $lyrics = $_POST['lyrics'];
    $language = $_POST['language'];
    $genre = $_POST['genre'];
    $tags = $_POST['tags'];

    // Upload cover image
    $cover_image = $_FILES['cover_image']['name'];
    $cover_target = "uploads/" . basename($cover_image);
    move_uploaded_file($_FILES['cover_image']['tmp_name'], $cover_target);

    // Upload song file
    $song_file = $_FILES['song_file']['name'];
    $song_target = "songs/" . basename($song_file);
    move_uploaded_file($_FILES['song_file']['tmp_name'], $song_target);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO songs (title, artist, album, lyrics, language, genre, tags, cover_image, song_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $title, $artist, $album, $lyrics, $language, $genre, $tags, $cover_image, $song_file);
    
    if ($stmt->execute()) {
        $success = "✅ Song added successfully!";
    } else {
        $error = "❌ Failed to add song: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Add New Song</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            padding: 40px;
        }

        h1 {
            color: #0d47a1;
        }

        form {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            max-width: 600px;
            margin-top: 20px;
        }

        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        input[type="submit"] {
            background-color: #0d47a1;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #1565c0;
        }

        .message {
            margin: 15px 0;
            font-weight: bold;
        }

        .message.success { color: green; }
        .message.error { color: red; }
    </style>
</head>
<body>

<h1>Add a New Song 🎵</h1>

<?php if (isset($success)) echo "<div class='message success'>$success</div>"; ?>
<?php if (isset($error)) echo "<div class='message error'>$error</div>"; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Title:</label>
    <input type="text" name="title" required>

    <label>Artist Name:</label>
    <input type="text" name="artist" required>

    <label>Album Name:</label>
    <input type="text" name="album">

    <label>Lyrics:</label>
    <textarea name="lyrics" rows="6" required></textarea>

    <label>Language:</label>
    <input type="text" name="language">

    <label>Genre:</label>
    <input type="text" name="genre">

    <label>Tags (comma separated):</label>
    <input type="text" name="tags">

    <label>Cover Image:</label>
    <input type="file" name="cover_image" accept="image/*" required>

    <label>Song File (MP3, WAV etc):</label>
    <input type="file" name="song_file" accept="audio/*" required>

    <input type="submit" value="Add Song">
</form>

</body>
</html>
