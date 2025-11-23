<?php

echo $_SERVER["REQUEST_METHOD"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $car = trim($_POST["car"]);
    $year = trim($_POST["year"]);
    $service = trim($_POST["service"]);
    $date = trim($_POST["date"]);
    $msg = trim($_POST["message"]);

    $errors = [];

    if (empty($name) || strlen($name) < 2) {
        $errors[] = "Имя должно содержать минимум 2 символа.";
    }

    if (!empty($errors)) {
        echo "<h3>Ошибки:</h3><ul>";
        foreach ($errors as $err) {
            echo "<li>$err</li>";
        }
        echo "</ul><a href='index.html'>Назад</a>";
        exit;
    }

    echo "<h2>Данные успешно приняты:</h2>";
    echo "<p><strong>Имя:</strong> $name</p>";
    echo "<p><strong>Телефон:</strong> $phone</p>";
    echo "<p><strong>Авто:</strong> $car ($year)</p>";
    echo "<p><strong>Услуга:</strong> $service</p>";
    echo "<p><strong>Дата:</strong> $date</p>";
    echo "<p><strong>Комментарий:</strong><br>$msg</p>";

    echo "<br><a href='index.html'>Назад</a>";

} else {
    echo "Ошибка: неверный метод отправки.";
}
