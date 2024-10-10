<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directory Listing with Zoomed-Out Preview</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
        }
        .tile {
            border: solid #222 5px;
            background-color: #fff;
            margin: 10px;
            padding: 20px;
            text-align: center;
            width: 20%;
            height: 20%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.3s ease;
        }
        .tile:hover {
            transform: translateY(-5px);
        }
        .tile a {
            text-decoration: none;
            color: #333;
            display: block;
        }
        .tile a:hover {
            color: #007bff;
        }
        .preview {
            width: 100%;
            height: 100%;
            border: none;
            margin-bottom: 10px;
            pointer-events: none;
            transform: scale(1); 
            transform-origin: top left;
            overflow: hidden;
        }
        .tile strong {
            display: block;
            margin-top: 10px;
            font-size: 1.1em;
        }
        .tile .page-title {
            font-size: 1em;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    // Specify the directory to scan (current directory by default)
    $directory = './';

    // Function to get the title of a page
    function getPageTitle($filePath) {
        $content = file_get_contents($filePath);
        if (preg_match("/<title>(.*)<\/title>/i", $content, $matches)) {
            return $matches[1];  // Return the text inside <title>
        }
        return 'Untitled';  // Default title if <title> tag is not found
    }

    // Scan the directory
    $files = scandir($directory);

    // Loop through the files and directories
    foreach ($files as $file) {
        // Skip . and .. directories
        if ($file != '.' && $file != '..') {
            // Check if it's a directory
            if (is_dir($directory . $file)) {
                // Check if index.php or index.html exists inside the directory
                if (file_exists($directory . $file . '/index.php') || file_exists($directory . $file . '/index.html')) {
                    // Determine the index file
                    $indexFile = file_exists($directory . $file . '/index.php') ? 'index.php' : 'index.html';

                    // Get the page title
                    $pageTitle = getPageTitle($directory . $file . '/' . $indexFile);
                    
                    // Generate a clickable tile with a preview and the page title
                    echo '<div class="tile">';
                    echo '<div class="page-title">' . htmlspecialchars($pageTitle) . '</div>';
                    echo '<a href="' . $file . '/' . $indexFile . '" target="_blank">';
                    echo '<iframe class="preview" scrolling="no" src="' . $file . '/' . $indexFile . '" title="' . $file . ' preview"></iframe>';
                    
                    echo '<strong>' . $file . '</strong>';
                    echo '</a>';
                    echo '</div>';
                }
            }
        }
    }
    ?>
</div>

</body>
</html>
