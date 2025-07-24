<?php
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

include_once('db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>UK Lyrical Songs</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            padding: 30px;
            margin: 0;
        }

        .heading-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .uk-heading {
            font-size: 40px;
            font-weight: 700;
        }

        .white-letter {
            color: white;
            text-shadow: 0 0 4px #000;
        }

        .red-letter {
            color: red;
            text-shadow: 0 0 4px #000;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: #fff;
            padding: 6px 10px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.07);
            height: 36px;
        }

        .search-bar input[type="text"] {
            border: none;
            outline: none;
            padding: 6px 8px;
            font-size: 14px;
            border-radius: 8px;
            width: 160px;
        }

        .search-icon {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-left: 5px;
            color: #0d47a1;
        }

        /* New Grid Layout */
       .song-list {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* exactly 4 per row */
    gap: 20px;
      }

        @media (max-width: 1024px) {
    .song-list {
        grid-template-columns: repeat(3, 1fr); /* 3 per row on medium screens */
      }
         }

         @media (max-width: 768px) {
    .song-list {
        grid-template-columns: repeat(2, 1fr); /* 2 per row on tablets */
    }
         }

         @media (max-width: 480px) {
        .song-list {
         grid-template-columns: 1fr; /* 1 per row on phones */
             }
          }


        .song-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .song-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .song-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .song-card a {
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #0d47a1;
            text-decoration: none;
        }

        .song-card small {
            color: #666;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="heading-container">
    <h1 class="uk-heading">
        <span class="white-letter">U</span><span class="red-letter">K</span> Lyrical Songs
    </h1>

    <!-- Search Form -->
    <form class="search-bar" method="GET" action="">
        <input type="text" name="search" placeholder="Search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="search-icon">&#128269;</button>
    </form>
</div>

<div class="song-list">
    <?php
    // Search functionality
    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $conn->real_escape_string($_GET['search']);
        $sql = "SELECT * FROM songs WHERE title LIKE '%$search%' OR artist LIKE '%$search%' ORDER BY created_at DESC";
    } else {
        $sql = "SELECT * FROM songs ORDER BY created_at DESC";
    }

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='song-card'>";
            echo "<img src='uploads/" . htmlspecialchars($row['cover_image']) . "' alt='Cover'>";
            echo "<a href='lyrics2.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a>";
            echo "<small>" . htmlspecialchars($row['artist']) . "</small>";
            echo "</div>";
        }
    } else {
        echo "<p>No songs found.</p>";
    }
    ?>
</div>

</body>
</html>
