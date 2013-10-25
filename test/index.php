<?php

include __DIR__ .'/data.php'; // Подключение массива данных
include __DIR__ .'/../recursive.php'; // Подключение рекурсивной функции

//print_r($items); die;

// Вызов рекурсивной функции
$recursion = new \BW\Helpers\Recursion;
$result = $recursion->levelParentRecursion($data);

/* Dump */
echo '<pre>';
echo 'Performance:' ."\n";
echo 'Количество рекурсивных вызовов. . '. $recursion->getCountRecursionCalls() ."\n";
echo 'Количество итераций цикла . . . . '. $recursion->getCountForeachIterations() ."\n";
echo 'Использование памяти. . . . . . . '. memory_get_usage() ."\n";
print_r($result);
echo '</pre>';