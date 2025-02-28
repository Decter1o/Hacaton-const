<?php
    // Путь к вашему CSV файлу
    $csvFile = 'data.csv';

    // Функция для чтения CSV файла
    function readCSV($csvFile) {
        $file = fopen($csvFile, 'r');
        $data = [];
        while (($row = fgetcsv($file)) !== FALSE) {
            $data[] = $row;
        }
        fclose($file);
        return $data;
    }

    // Функция для записи данных обратно в CSV файл
    function writeCSV($csvFile, $data) {
        $file = fopen($csvFile, 'w');
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }

    // Поиск данных по ФИО
    if (isset($_GET['search'])) {
        $fio = htmlspecialchars($_GET['search']);
        $data = readCSV($csvFile);

        foreach ($data as $row) {
            if ($row[0] == $fio) {
                // Возвращаем данные в JSON формате для заполнения формы
                echo json_encode([
                    "success" => true,
                    "fioOwner" => $row[0],
                    "checkDate" => $row[1],
                    "address" => $row[2],
                    "housingType" => $row[3],
                    "inspectorName" => $row[4],
                    "inspectorId" => $row[5],
                    "phoneOwner" => $row[6],
                    "hasChildren" => $row[7],
                    "childrenCount" => $row[8],
                    "citizenCategory" => $row[9],
                    "additionalInfo" => $row[10]
                ]);
                exit;
            }
        }

        echo json_encode(["success" => false]);
        exit;
    }

    // Обновление данных в CSV
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = readCSV($csvFile);

        // Получаем данные из формы
        $fioOwner = htmlspecialchars($_POST['fio-owner']);
        $checkDate = htmlspecialchars($_POST['check-date']);
        $address = htmlspecialchars($_POST['address']);
        $housingType = htmlspecialchars($_POST['housing-type']);
        $inspectorName = htmlspecialchars($_POST['inspector-name']);
        $inspectorId = htmlspecialchars($_POST['inspector-id']);
        $phoneOwner = htmlspecialchars($_POST['phone-owner']);
        $hasChildren = htmlspecialchars($_POST['has-children']);
        $childrenCount = htmlspecialchars($_POST['children-count']);
        $citizenCategory = htmlspecialchars($_POST['citizen-category']);
        $additionalInfo = htmlspecialchars($_POST['additional-info']);

        // Обновляем данные в CSV (поиск по имени владельца)
        foreach ($data as $key => $row) {
            if ($row[0] == $fioOwner) {
                $data[$key] = [
                    $fioOwner, $checkDate, $address, $housingType, $inspectorName,
                    $inspectorId, $phoneOwner, $hasChildren, $childrenCount, $citizenCategory, $additionalInfo
                ];
            }
        }

        // Перезаписываем CSV
        writeCSV($csvFile, $data);

        echo "<script>alert('Данные успешно обновлены!');</script>";
    }
?>
