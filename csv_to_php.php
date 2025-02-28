<?php
    // Подключаем библиотеку для работы с Excel, например PhpSpreadsheet
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Путь к вашему CSV файлу
        $csvFile = 'inspection_data.csv';

        // Читаем CSV файл
        $rows = array_map('str_getcsv', file($csvFile));
        $header = array_shift($rows); // Извлекаем заголовки колонок

        // Создаем новый Excel файл
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Если пользователь запросил полный файл
        if (isset($_POST['full-file'])) {
            // Записываем заголовки
            $sheet->fromArray($header, NULL, 'A1');
            // Записываем данные
            $sheet->fromArray($rows, NULL, 'A2');

            // Генерация файла Excel
            $writer = new Xlsx($spreadsheet);
            $fileName = 'full_data.xlsx';
        }

        // Если пользователь запросил файл по диапазону дат
        if (isset($_POST['range-file']) && isset($_POST['start-date']) && isset($_POST['end-date'])) {
            $startDate = $_POST['start-date'];
            $endDate = $_POST['end-date'];

            // Фильтруем строки по диапазону дат (предполагается, что первый столбец содержит даты)
            $filteredRows = array_filter($rows, function($row) use ($startDate, $endDate) {
                $rowDate = $row[0]; // Замените 0 на индекс колонки с датой
                return $rowDate >= $startDate && $rowDate <= $endDate;
            });

            // Записываем заголовки
            $sheet->fromArray($header, NULL, 'A1');
            // Записываем отфильтрованные данные
            $sheet->fromArray($filteredRows, NULL, 'A2');

            // Генерация файла Excel
            $writer = new Xlsx($spreadsheet);
            $fileName = 'filtered_data_' . $startDate . '_to_' . $endDate . '.xlsx';
        }

        // Скачивание файла Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. $fileName .'"');
        $writer->save("php://output");
        exit;
    }
?>
