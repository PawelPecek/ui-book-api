<?php
$API_DATA = file_get_contents("https://wolnelektury.pl/api/books/");
$API_DATA = json_decode($API_DATA);

function itemTemplate($title = "", $author = "", $genre = "", $coverUrl = "", $link = "") {
    echo('
        <div data-title="' . $title . '" data-author="' . $author . '" data-genre="' . $genre . '" data-coverUrl="' . $coverUrl . '" data-link="' . $link . '" class="item">
            <img src="' . $coverUrl . '" alt="">
            <div class="right-col">
                <span class="title">' . $title . '</span>
                <span class="author">' . $author . '</span>
                <span class="genre">' . $genre . '</span>
                <a href="' . $link . '">Zobacz więcej</a>
            </div>
        </div>
    ');
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WolneLektury API</title>
    <link rel="Stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <h1>Search</h1>
    <div class="form">
        <form action="./list.php" method="POST">
        <?php 
            if (isset($_POST["searchString"]) && ($_POST["searchString"] != "")) {
                echo '<input name="searchString" type="text" value="' . $_POST["searchString"] . '">';
            } else {
                echo '<input name="searchString" type="text" value="">';
            }
        ?>
        <button type="submit" class="button">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        </form>
    </div>
    <div class="container">
        <?php
            if (isset($_POST["searchString"]) && ($_POST["searchString"] != "")) {
                for ($i = 0; $i < count($API_DATA); $i++) {
                    $title = ((array)$API_DATA[$i])["title"];
                    $author = ((array)$API_DATA[$i])["author"];
                    $genre = ((array)$API_DATA[$i])["genre"];
                    $img = ((array)$API_DATA[$i])["simple_thumb"];
                    $url = ((array)$API_DATA[$i])["url"];
                    $needle = $_POST["searchString"];
                    if (str_contains(strtolower($title), strtolower($needle)) || str_contains(strtolower($author), strtolower($needle)) || str_contains(strtolower($genre), strtolower($needle))) {
                        itemTemplate($title, $author, $genre, $img, $url);
                    }
                }
            } else {
                for ($i = 0; $i < count($API_DATA); $i++) {
                    $title = ((array)$API_DATA[$i])["title"];
                    $author = ((array)$API_DATA[$i])["author"];
                    $genre = ((array)$API_DATA[$i])["genre"];
                    $img = ((array)$API_DATA[$i])["simple_thumb"];
                    $url = ((array)$API_DATA[$i])["url"];
                    itemTemplate($title, $author, $genre, $img, $url);
                }
            }
        ?>
    </div>
</body>
</html>