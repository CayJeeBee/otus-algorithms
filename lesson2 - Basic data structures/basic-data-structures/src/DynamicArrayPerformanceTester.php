<?php

declare(strict_types=1);


namespace OtusAlgorithms;


use dekor\ArrayToTextTable;
use OtusAlgorithms\DynamicArray\ArrayList;
use OtusAlgorithms\DynamicArray\FactorArray;
use OtusAlgorithms\DynamicArray\SingleArray;
use OtusAlgorithms\DynamicArray\VectorArray;

class DynamicArrayPerformanceTester
{
    private const ARRAY_TYPES = [
        SingleArray::class,
        VectorArray::class,
        FactorArray::class,
        ArrayList::class
    ];

    private const OPERATIONS = [
        "Заполнение массива" => "testArrayFilling",
        "Удаление первого элемента" => "testDeletingByKeyStart",
        "Удаление последнего элемента" => "testDeletingByKeyEnd",
        "Удаление элемента из середины" => "testDeletingByKeyMiddle",
        "Вставка в начало" => "testInsertByKeyStart",
        "Вставка в конец" => "testInsertByKeyEnd",
        "Вставка в середину" => "testInsertByKeyMiddle",
    ];

    public function testArrayFilling(DynamicArray $array, int $elementsCount): float
    {
        $start = \microtime(true);

        $this->fillArray($array, $elementsCount);

        $timeSpentInMilliseconds = (\microtime(true) - $start) * 1000;

        return $timeSpentInMilliseconds;
    }

    public function testDeletingByKeyStart(DynamicArray $array, int $elementsCount): float
    {
        $this->fillArray($array, $elementsCount);

        $start = \microtime(true);

        $array->remove(0);

        $timeSpentInMilliseconds = (\microtime(true) - $start) * 1000;

        return $timeSpentInMilliseconds;
    }

    public function testDeletingByKeyEnd(DynamicArray $array, int $elementsCount): float
    {
        $this->fillArray($array, $elementsCount);

        $start = \microtime(true);

        $array->remove($array->size() - 1);

        $timeSpentInMilliseconds = (\microtime(true) - $start) * 1000;

        return $timeSpentInMilliseconds;
    }

    public function testDeletingByKeyMiddle(DynamicArray $array, int $elementsCount): float
    {
        $this->fillArray($array, $elementsCount);

        $middleIndex = (int) ($array->size() / 2);

        $start = \microtime(true);

        $array->remove($middleIndex);

        $timeSpentInMilliseconds = (\microtime(true) - $start) * 1000;

        return $timeSpentInMilliseconds;
    }

    public function testInsertByKeyStart(DynamicArray $array, int $elementsCount): float
    {
        $this->fillArray($array, $elementsCount);

        $start = \microtime(true);

        $array->add(0, 0);

        $timeSpentInMilliseconds = (\microtime(true) - $start) * 1000;

        return $timeSpentInMilliseconds;
    }

    public function testInsertByKeyEnd(DynamicArray $array, int $elementsCount): float
    {
        $this->fillArray($array, $elementsCount);

        $start = \microtime(true);

        $array->add(0, $array->size());

        $timeSpentInMilliseconds = (\microtime(true) - $start) * 1000;

        return $timeSpentInMilliseconds;
    }

    public function testInsertByKeyMiddle(DynamicArray $array, int $elementsCount): float
    {
        $this->fillArray($array, $elementsCount);

        $middleIndex = (int) ($array->size() / 2);

        $start = \microtime(true);

        $array->add(0, $middleIndex);

        $timeSpentInMilliseconds = (\microtime(true) - $start) * 1000;

        return $timeSpentInMilliseconds;
    }

    public function renderTestResultsTable(): string
    {
        $resultString = "";

        foreach (self::OPERATIONS as $operation => $testerFunction) {
            $resultString .= "{$operation}\n";

            $performanceData = [];
            foreach (self::ARRAY_TYPES as $array) {
                $performanceData[] = [
                    "Тип массива" => str_replace("OtusAlgorithms\\DynamicArray\\", "", $array),
                    "10 элементов" => \sprintf("%.5f ms", $this->$testerFunction(new $array(), 10)),
                    "100 элементов" => \sprintf("%.5f ms", $this->$testerFunction(new $array(), 100)),
                    "1000 элементов" => \sprintf("%.5f ms", $this->$testerFunction(new $array(), 1000)),
                    "10000 элементов" => \sprintf("%.5f ms", $this->$testerFunction(new $array(), 10000)),
                    "100000 элементов" => \sprintf("%.5f ms", $this->$testerFunction(new $array(), 100000)),
                ];
            }

            $resultString .= (new ArrayToTextTable($performanceData))->render() . "\n\n";
        }

        return $resultString;
    }

    private function fillArray(DynamicArray $array, int $elementsCount): void
    {
        for ($i = 0; $i < $elementsCount; $i++) {
            $array->add($i, $i);
        }
    }

    private function deleteElementsFromArray(DynamicArray $array): void
    {
        while ($array->size() > 0) {
            $array->remove(0);
        }
    }
}
