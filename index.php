<?php
// Sprawdzanie, czy użytkownik jest zalogowany jako administrator
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
}

// Sprawdzanie, czy formularz został wysłany
if (isset($_POST['submit'])) {
    // Łączenie z bazą danych
    include 'dbconfig.php';

    // Pobieranie danych z formularza
    $title = $_POST['title'];
    $content = $_POST['content'];
    $type = $_POST['type'];

    // Walidacja danych
    if (empty($title) || empty($content) || empty($type)) {
        $error = 'Proszę wypełnić wszystkie pola.';
    } else {
        // Dodawanie artykułu lub poradnika do bazy danych
        $stmt = $pdo->prepare("INSERT INTO articles (title, content, type) VALUES (?, ?, ?)");
        $stmt->execute([$title, $content, $type]);

        // Przekierowanie do strony głównej
        header('Location: index.php');
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dodaj artykuł lub poradnik - Panel administratora</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Dodaj artykuł lub poradnik</h1>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <form method="post">
            <label>Tytuł:</label>
            <input type="text" name="title">
            <br>
            <label>Treść:</label>
            <textarea name="content"></textarea>
            <br>
            <label>Typ:</label>
            <select name="type">
                <option value="">Wybierz typ</option>
                <option value="artykuł">Artykuł</option>
                <option value="poradnik">Poradnik</option>
            </select>
            <br>
            <input type="submit" name="submit" value="Dodaj">
        </form>
        <a href="logout.php">Wyloguj się</a>
    </div>
</body>
</html>
