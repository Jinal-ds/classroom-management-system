<?php
if (isset($_POST['submit'])) { // Correct 'sumbit' to 'submit'
    $file = $_FILES['file']; // Change 'files' to 'file' to match the input name
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    // Get the file extension
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    // Allowed file types
    $allowed = array('jpg', 'jpeg', 'pdf');

    // Check if the file extension is allowed
    if (in_array($fileActualExt, $allowed)) {
        // Check for any upload errors
        if ($fileError === 0) {
            // Check the file size
            if ($fileSize < 1000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $fileNameNew;

                // Move the uploaded file to the specified destination
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    header("Location: index.php?uploadsuccess");
                    exit(); // It's good practice to call exit after a header redirect
                } else {
                    echo "<p class='error'>There was an error moving the uploaded file.</p>";
                }
            } else {
                echo "<p class='error'>Your file is too large.</p>"; // Corrected error message
            }
        } else {
            echo "<p class='error'>There was an error uploading your file.</p>"; // Corrected error message
        }
    } else {
        echo "<p class='error'>You cannot upload files of this type.</p>"; // Corrected error message
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .upload-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 300px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        input[type="file"] {
            margin: 20px 0;
            padding: 10px;
            border: 2px dashed #4CAF50;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        input[type="file"]:hover {
            border-color: #45a049;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h1>Upload Homework</h1> <!-- Changed to "Upload Homework" -->
        <form action="homework.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <button type="submit" name="submit">UPLOAD</button>
        </form>
    </div>
</body>
</html>
