
<?php
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'songs';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if ID is passed
if (!isset($_GET['id'])) {
    echo "⚠️ No song selected. Please go back to the song list.";
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM songs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "❌ Song not found.";
    exit;
}

$song = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($song['title']) ?> - Lyrics</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            padding: 40px;
            margin: 0;
        }

        .uk-heading {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .uk-heading .u {
            color: white;
            background: #000;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .uk-heading .k {
            color: red;
        }

        .lyrics-container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        img.cover {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        h1 {
            color: #0d47a1;
            margin: 10px 0;
        }

        .info {
            color: #555;
            font-size: 15px;
            margin-bottom: 20px;
        }

        .lyrics {
            text-align: left;
            white-space: pre-line;
            line-height: 1.6;
            font-size: 17px;
            background: #fdfdfd;
            padding: 20px;
            border-left: 5px solid #007BFF;
            border-radius: 8px;
        }

        a.back-link {
            display: inline-block;
            margin-top: 25px;
            color: #007BFF;
            text-decoration: none;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Styled Heading -->
<div class="uk-heading">
    <span class="u">U</span><span class="k">K</span> Lyrical Songs
</div>

<div class="lyrics-container">
    <!-- Cover Image -->
    <img class="cover" src="uploads/<?= htmlspecialchars($song['cover_image']) ?>" alt="Cover Image">

    <br>
    <!-- Audio Player -->
    <audio controls>
    <source src="songs/<?= $song['song_file'] ?>" type="audio/mpeg">
    </audio>
    <br>


    <!-- Song Info -->
    <h1><?= htmlspecialchars($song['title']) ?></h1>
    <div class="info">
        Artist: <?= htmlspecialchars($song['artist']) ?><br>
        Album: <?= htmlspecialchars($song['album']) ?>
    </div>

    <!-- Lyrics -->
    <div class="lyrics">
        <?= nl2br(htmlspecialchars($song['lyrics'])) ?>
    </div>

    <!-- Back Button -->
    <a href="index1.php" class="back-link">⬅️ Back to Songs List</a>
</div>

</body>
</html>
