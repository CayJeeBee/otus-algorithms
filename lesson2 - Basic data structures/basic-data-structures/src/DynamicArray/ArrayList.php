<?php

declare(strict_types=1);


namespace OtusAlgorithms\DynamicArray;


use OtusAlgorithms\DynamicArray;
use SplDoublyLinkedList;

class ArrayList implements DynamicArray
{

    /**
     * @var SplDoublyLinkedList
     */
    private $array;

    public function __construct()
    {
        $this->array = new SplDoublyLinkedList();
    }

    public function size(): int
    {
        return $this->array->count();
    }

    public function push($item): void
    {
        $this->array->push($item);
    }

    public function add($item, int $index): void
    {
        $this->array->add($index, $item);
    }

    public function get(int $index)
    {
        return $this->array[$index];
    }

    public function remove(int $index)
    {
        $removedElement = $this->array[$index];

        $this->array->offsetUnset($index);

        return $removedElement;
    }
}
