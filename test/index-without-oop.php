<?php

// Performance Statistics
$countRecursionCalls = 0;
$countForeachIterations = 0;

/**
 * Рекурсивная функция для создания многомерного массива из 
 * связанных между собой родительских и дочерних элементов,
 * операясь на текущий уровень вложенности элемента и его родителя.
 * 
 * @param array $data Операции проводятся всегда над однми и тем же массивом $data, который рекурсивно передается по ссылке
 * @param integer $level Уровень вложенности элементов
 * @param integer $parent ID родительского элемента
 * @param boolean $isArrayGenerate Сгенерировать правильный массив данных с группированием по уровням и родителям
 * 
 * @return array $result Многомерный массив
 */
function levelParentRecursion(array &$data, $level = 0, $parent = FALSE, $isArrayGenerate = TRUE) {
    global $countRecursionCalls;
    global $countForeachIterations;
    $countRecursionCalls++; // Подсчет количества рекурсивных вызовов
    
    /* Генерирование правильного массива данных для удобного перебора по уровням и по родителям */
    if ($isArrayGenerate === TRUE) {
        $generatedArray = array();
        foreach ($data as $id => $item) {
            $generatedArray['levels'][ $item['level'] ][ $id ] = $item;
            $generatedArray['parents'][ $item['parent'] ][ $id ] = $item;
        }
        unset($data);
        $data =& $generatedArray;
    }
    
    /* Определение способа перебора элементов в зависимости от условий */
    // Если не было передано родителя
    if ($parent === FALSE) {
        // то выполнять перебор элементов по уровням
        $items =& $data['levels'][$level];
    } else {
        // иначе выполнять перебор дочерних элементов переданного родителя
        $items =& $data['parents'][$parent];
    }
    
    /* Формирование многомерного массива */
    foreach ($items as $id => $item) {
        $countForeachIterations++; // Подсчет количества итераций цикла foreach
        // Занести текущий элемент в результирующий массив
        $result[$id]['current'] = $item;
        // Если существуют дочерние элементы у текущего элемента
        if (isset($data['parents'][$item['id']])) {
            // то выполнить рекурсивный вызов для перебора его дочерних элементов
            $result[$id]['children'] = levelParentRecursion($data, $level + 1, $item['id'], FALSE);
        }
    }
    
    return $result;
}