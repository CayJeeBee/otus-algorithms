<?php

declare(strict_types=1);


namespace OtusAlgorithms\DynamicArray;


use SplFixedArray;
use OtusAlgorithms\DynamicArray;
use OutOfBoundsException;

class SingleArray implements DynamicArray
{
    /**
     * @var SplFixedArray
     */
    private $array;

    public function __construct()
    {
        $this->array = new SplFixedArray(0);
    }

    public function size(): int
    {
        return $this->array->getSize();
    }

    public function push($item): void
    {
        $this->add($item, $this->size());
    }

    public function add($item, int $index): void
    {
        if ($index > $this->size()) {
            throw new OutOfBoundsException();
        }

        if ($index === $this->size()) {
            $this->increaseArraySize();
        } else {
            $this->shiftArrayRight($index);
        }

        $this->array[$index] = $item;
    }

    public function get(int $index)
    {
        return $this->array[$index];
    }

    public function remove(int $index)
    {
        $removedElement = $this->array[$index];

        $newArray = $this->createReducedArray();

        $this->copyArray($newArray, 0, $this->array, 0, $index - 1);
        $this->copyArray($newArray, $index, $this->array, $index + 1, $this->array->getSize() - 1);

        $this->array = $newArray;

        return $removedElement;
    }

    private function increaseArraySize(): void
    {
        $newArray = $this->createEnlargedArray();

        $this->copyArray($newArray, 0, $this->array, 0, $this->array->getSize() - 1);

        $this->array = $newArray;
    }

    private function createEnlargedArray(): SplFixedArray
    {
        return new SplFixedArray($this->array->getSize() + 1);
    }

    private function shiftArrayRight(int $startIndex): void
    {
        $newArray = $this->createEnlargedArray();

        $this->copyArray($newArray, 0, $this->array, 0, $startIndex - 1);
        $this->copyArray($newArray, $startIndex + 1, $this->array, $startIndex, $this->size() - 1);

        $this->array = $newArray;
    }

    private function isArrayExceeded(): bool
    {
        return true;
    }

    private function createReducedArray(): SplFixedArray
    {
        return new SplFixedArray($this->array->getSize() - 1);
    }

    private function copyArray(
        SplFixedArray $toArray,
        int $toArrayStartIndex,
        SplFixedArray $fromArray,
        int $fromArrayStartIndex,
        int $fromArrayEndIndex
    )
    {
        $toArrayIndex = $toArrayStartIndex;
        for ($i = $fromArrayStartIndex; $i <= $fromArrayEndIndex; $i++) {
            $toArray[$toArrayIndex] = $fromArray[$i];

            $toArrayIndex++;
        }
    }
}
