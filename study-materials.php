<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("homepage.php"); // Make sure this includes your database connection

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the uploaded file
    $file = $_FILES['material'];

    // Check if the file is uploaded successfully
    if ($file['error'] === 0) {
        // Get the file details
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileType = $file['type'];

        // Get the file extension
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        // Define the allowed file extensions
        $allowedExtensions = array('jpg', 'jpeg', 'pdf', 'doc', 'docx');

        // Check if the file extension is allowed
        if (in_array($fileActualExt, $allowedExtensions)) {
            // Check if the file size is within the limit (1MB)
            if ($fileSize < 1000000) {
                // Generate a unique file name
                $fileNameNew = uniqid('', true) . '.' . $fileActualExt;

                // Define the upload directory
                $uploadDir = 'uploads/study-materials/';
                
                // Create the upload directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Define the file destination
                $fileDestination = $uploadDir . $fileNameNew;

                // Move the uploaded file to the destination
                if (move_uploaded_file($file['tmp_name'], $fileDestination)) {
                    // Store the file path in the database (assuming you have a 'materials' table)
                    $query = "INSERT INTO materials (file_path) VALUES ('$fileDestination')";
                    if (mysqli_query($conn, $query)) {
                        // Redirect to the success page
                        header("Location: index.php?uploadsuccess");
                        exit;
                    } else {
                        echo "Failed to save the file path in the database.";
                    }
                } else {
                    echo "Failed to upload the file.";
                }
            } else {
                echo "The file size exceeds the limit of 1MB.";
            }
        } else {
            echo "You cannot upload files of this type.";
        }
    } else {
        echo "There was an error uploading your file.";
    }
}

// Fetch materials for display
$materialsQuery = mysqli_query($conn, "SELECT * FROM materials");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Materials</title>
</head>
<body>
    <h1>Upload Study Materials</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="material">Choose a file (PDF, DOC, DOCX, JPG, JPEG):</label>
        <input type="file" name="material" id="material" required>
        <input type="submit" name="submit" value="Upload">
    </form>

    <h2>Uploaded Materials</h2>
    <ul>
        <?php while ($row = mysqli_fetch_array($materialsQuery)): ?>
            <li>
                <a href="<?php echo $row['file_path']; ?>" target="_blank"><?php echo basename($row['file_path']); ?></a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
