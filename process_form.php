<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Получаем данные из формы
        $ownerName = htmlspecialchars($_POST['owner-name'] ?? ''); // ФИО владельца
        $inspectionDate = htmlspecialchars($_POST['check-date'] ?? ''); // Дата проверки
        $address = htmlspecialchars($_POST['address'] ?? ''); // Адрес объекта
        $housingType = htmlspecialchars($_POST['property-type'] ?? ''); // Тип жилья
        $inspectorName = htmlspecialchars($_POST['inspector-name'] ?? ''); // ФИО инспектора
        $inspectorID = htmlspecialchars($_POST['inspector-id'] ?? ''); // Номер удостоверения инспектора
        $ownerPhone = htmlspecialchars($_POST['owner-phone'] ?? ''); // Контактный телефон владельца
        $childrenPresence = htmlspecialchars($_POST['children'] ?? ''); // Есть ли дети
        $childrenCount = htmlspecialchars($_POST['children-count'] ?? ''); // Численность детей
        $citizenCategory = htmlspecialchars($_POST['citizen-category'] ?? ''); // Категория граждан
        $additionalInfo = htmlspecialchars($_POST['additional-info'] ?? ''); // Дополнительная информация

        // Проверка обязательных полей (если требуется)
        if (empty($ownerName) || empty($inspectionDate) || empty($address) || empty($ownerPhone) || empty($additionalInfo)) {
            echo "Please fill in all required fields.";
            exit;
        }

        // Путь к CSV-файлу
        $filePath = "inspection_data.csv";

        // Открываем CSV-файл для добавления данных
        $file = fopen($filePath, "a");

        // Если файл открыт успешно
        if ($file !== false) {
            // Запись данных в CSV-файл
            $data = [
                $ownerName,
                $inspectionDate,
                $address,
                $housingType,
                $inspectorName,
                $inspectorID,
                $ownerPhone,
                $childrenPresence,
                $childrenCount,
                $citizenCategory,
                $additionalInfo
            ];

            // Записываем строку в файл
            fputcsv($file, $data);

            // Закрываем файл
            fclose($file);

            echo "<script>alert('Данные успешно сохранены в CSV файл.'); window.location.href = 'employee.html';</script>";
        } else {
            echo "<script>alert('Ошибка при открытии файла.'); window.location.href = 'employee.html';</script>";
        }
    }
?>
