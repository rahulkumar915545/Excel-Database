<?php
require 'vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\IOFactory;


$host = 'localhost:4306';
$dbname = 'excel_db';
$username = 'root';
$password = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excelFile'])) {
    
    $fileTmpPath = $_FILES['excelFile']['tmp_name'];
    $fileName = $_FILES['excelFile']['name'];
    $fileSize = $_FILES['excelFile']['size'];
    $fileType = $_FILES['excelFile']['type'];

    
    $allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
    if (!in_array($fileType, $allowedTypes)) {
        die('Invalid file type. Please upload an Excel file.');
    }

    
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadPath = $uploadDir . $fileName;
    move_uploaded_file($fileTmpPath, $uploadPath);

    try {
        
        $spreadsheet = IOFactory::load($uploadPath);
        $sheet = $spreadsheet->getActiveSheet();

        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    
        $stmt = $pdo->prepare("INSERT INTO marksheets (roll, name, English, Hindi, Maths) VALUES (?, ?, ?, ?, ?)");

        
        foreach ($sheet->getRowIterator() as $index => $row) {
            if ($index === 1) continue; 

            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getFormattedValue(); 
            }

            $stmt->execute($rowData);
        }

        echo "<div class='alert success'>Data successfully imported into the database!</div>";
    } catch (Exception $e) {
        echo "<div class='alert error'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel File</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 30px;
        }

        label {
            font-size: 16px;
            margin-bottom: 10px;
            display: inline-block;
        }

        input[type="file"] {
            font-size: 16px;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: block;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .alert {
            padding: 15px;
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Upload Excel File to Import into Database</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="excelFile">Choose an Excel file:</label>
            <input type="file" name="excelFile" id="excelFile" required>
            <input type="submit" value="Upload and Import">
        </form>
    </div>

</body>
</html>
