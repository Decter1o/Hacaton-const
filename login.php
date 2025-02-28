<?php
// Предопределённые логины, пароли и роли пользователей
$users = [
    "admin" => ["password" => "adminPass", "role" => "admin"],
    "employee" => ["password" => "employeePass", "role" => "employee"],
    "client1" => ["password" => "clientPass1", "role" => "client"],
    "client2" => ["password" => "clientPass2", "role" => "client"]
];

// Если форма отправлена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Проверяем, существует ли пользователь и совпадает ли пароль
    if (array_key_exists($username, $users) && $users[$username]['password'] == $password) {
        // Получаем роль пользователя
        $role = $users[$username]['role'];

        // Перенаправляем пользователя на соответствующую страницу (HTML или PHP)
        switch ($role) {
            case 'admin':
                echo "<script>alert('Добро пожаловать, админ!'); window.location.href = 'admin.html';</script>";
                exit;
            case 'employee':
                echo "<script>alert('Добро пожаловать, сотрудник!'); window.location.href = 'employee.html';</script>";
                exit;
            case 'client':
                echo "<script>alert('Добро пожаловать, клиент!'); window.location.href = 'client.html';</script>";
                exit;
            default:
                echo "<script>alert('Неизвестная роль.');</script>";
                break;
        }
    } else {
        // Ошибка авторизации
        echo "<script>alert('Неверный логин или пароль.'); window.location.href = 'login.html';</script></script>";
    }
} else {
    // Если форма не была отправлена
    echo "<script>alert('Пожалуйста, заполните форму для входа.');</script>";
}
?>
