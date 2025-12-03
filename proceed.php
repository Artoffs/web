<?php

$name = trim($_POST["name"] ?? '');
$phone = trim($_POST["phone"] ?? '');
$car = trim($_POST["car"] ?? '');
$year = trim($_POST["year"] ?? '');
$service = trim($_POST["service"] ?? '');
$date = trim($_POST["date"] ?? '');
$msg = trim($_POST["message"] ?? '');

echo "5. Очищенные данные:<br>";
echo "Имя: '$name'<br>";
echo "Телефон: '$phone'<br>";
echo "Авто: '$car'<br>";
echo "Год: '$year'<br>";
echo "Услуга: '$service'<br>";
echo "Дата: '$date'<br>";
echo "Сообщение: '$msg'<br>";

$errors = [];
if (empty($name) || strlen($name) < 2) $errors[] = "Имя должно содержать минимум 2 символа.";
if (empty($phone)) $errors[] = "Телефон обязателен.";
if (empty($car)) $errors[] = "Укажите модель авто.";
if (empty($service)) $errors[] = "Выберите услугу.";
if (empty($date)) $errors[] = "Выберите дату.";

if (!empty($errors)) {
    echo "<h3>❌ Ошибки валидации:</h3><ul>";
    foreach ($errors as $err) echo "<li>$err</li>";
    echo "</ul>";
    echo "<a href='index.html'>Назад</a>";
    exit;
}

try {
    $sql = "INSERT INTO appointment (client_name, phone, car_model, service_date, service_type, description) 
            VALUES (:client_name, :phone, :car_model, :service_date, :service_type, :description)";
    
    echo "SQL запрос:<br><code>" . htmlspecialchars($sql) . "</code><br>";
    
    echo "Параметры:<br>";
    echo "client_name: '$name'<br>";
    echo "phone: '$phone'<br>";
    echo "car_model: '$car'<br>";
    echo "car_year: " . ($year ? "'$year'" : "NULL") . "<br>";
    echo "service_date: '$date'<br>";
    echo "service_type: '$service'<br>";
    echo "problem_description: '$msg'<br>";
    
    $stmt = $pdo->prepare($sql);
    
    
    $stmt->bindParam(':client_name', $name);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':car_model', $car);
    $stmt->bindParam(':service_date', $date);
    $stmt->bindParam(':service_type', $service);
    $stmt->bindParam(':description', $msg);
    
    $result = $stmt->execute();
    
    if ($result) {
        $last_id = $pdo->lastInsertId();
        echo "ID новой записи: $last_id<br><br>";
        
        $check = $pdo->query("SELECT COUNT(*) FROM appointment WHERE id = $last_id");
        $exists = $check->fetchColumn();
        
        if ($exists) {
            echo "<h1 style='color: green;'>🎉 ЗАПИСЬ УСПЕШНО ДОБАВЛЕНА!</h1>";
            echo "<h2>Спасибо, $name!</h2>";
            echo "<p>Ваша заявка на $date принята.</p>";
            echo "<p>Мы свяжемся с вами по номеру $phone для подтверждения.</p>";
        } else {
            echo "⚠️ Запись с ID $last_id не найдена после вставки<br>";
        }
    } else {
        echo "❌ execute() вернул false<br>";
    }
    
} catch (PDOException $e) {
    
    
} finally {
    echo "<hr>";
    echo "<p><a href='index.html'>← Вернуться к форме</a></p>";
}
?>