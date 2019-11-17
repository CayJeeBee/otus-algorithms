<?php

declare(strict_types=1);


namespace OtusAlgorithms\DynamicArray;


use OtusAlgorithms\DynamicArray;
use OutOfBoundsException;
use SplFixedArray;

class VectorArray implements DynamicArray
{
    /**
     * @var SplFixedArray
     */
    private $array;

    /**
     * @var int
     */
    private $vector;

    /**
     * @var int
     */
    private $size;

    public function __construct()
    {
        $this->array  = new SplFixedArray(0);
        $this->vector = 17;
        $this->size   = 0;
    }

    public function size(): int
    {
        return $this->size;
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
            if ($this->isArrayExceeded()) {
                $this->increaseArraySize();
            }
        } else {
            $this->shiftArrayRight($index);
        }

        $this->array[$index] = $item;

        $this->size++;
    }

    public function get(int $index)
    {
        return $this->array[$index];
    }

    public function remove(int $index)
    {
        $maxAllowedIndex = $this->size() - 1;

        if ($index > $maxAllowedIndex) {
            throw new OutOfBoundsException();
        }

        $removedElement = $this->array[$index];

        if ($index < $maxAllowedIndex) {
            $this->copyArray($this->array, $index, $this->array, $index + 1, $this->array->getSize() - 1);
        }

        $this->array[$maxAllowedIndex] = null;

        $this->size--;

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
        return new SplFixedArray($this->array->getSize() + $this->vector);
    }

    private function shiftArrayRight(int $startIndex): void
    {
        if ($this->isArrayExceeded()) {
            $newArray = $this->createEnlargedArray();

            $this->copyArray($newArray, 0, $this->array, 0, $startIndex - 1);
            $this->copyArray($newArray, $startIndex + 1, $this->array, $startIndex, $this->size() - 1);

            $this->array = $newArray;
        } else {
            $arraySize = $this->array->getSize();

            $previousElement = $this->array[$startIndex];
            for ($i = $startIndex + 1; $i < $arraySize; $i++) {
                $currentElement = $this->array[$i];

                $this->array[$i] = $previousElement;

                $previousElement = $currentElement;
            }
        }
    }

    private function isArrayExceeded(): bool
    {
        return $this->size() === $this->array->getSize();
    }

    private function copyArray(
        SplFixedArray $toArray,
        int $toArrayStartIndex,
        SplFixedArray $fromArray,
        int $fromArrayStartIndex,
        int $fromArrayEndIndex
    ): void {
        $toArrayIndex = $toArrayStartIndex;
        for ($i = $fromArrayStartIndex; $i <= $fromArrayEndIndex; $i++) {
            $toArray[$toArrayIndex] = $fromArray[$i];

            $toArrayIndex++;
        }
    }
}
