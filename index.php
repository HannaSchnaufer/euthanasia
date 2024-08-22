<?php
// sambung ke database
$servername = "localhost";
$username = "root"; // username slalu root
$password = ""; // kosongin klo ga pake
$dbname = "deathbrain"; // databse yang dipake

// connectkemysqli <- absolutely have no clue
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize an empty search query
$searchQuery = "";
if (isset($_POST['search'])) {
    $searchQuery = $conn->real_escape_string($_POST['search']);
}

// Build the SQL query
$sql = "SELECT * FROM howtosleep WHERE 
        title LIKE '%$searchQuery%' OR 
        description LIKE '%$searchQuery%' OR 
        url LIKE '%$searchQuery%'";

// Execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<head>
    <title>Nike Data Search</title>
</head>
<body>

<div class="search-container">
    <h2>Search Nike Data</h2>
    <form method="POST" action="">
        <input type="text" name="search" placeholder="search..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit">Search</button>
    </form>
</div>

<div class="results">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="result-item">';
            echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
            echo '<p><a href="' . htmlspecialchars($row['url']) . '" target="_blank">' . htmlspecialchars($row['url']) . '</a></p>';
            echo '<p>' . htmlspecialchars($row['description']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No results found.</p>';
    }
    ?>
</div>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
