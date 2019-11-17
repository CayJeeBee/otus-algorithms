<?php

declare(strict_types=1);

namespace OtusAlgorithms;


interface DynamicArray
{
    /**
     * Get max elements count for array
     *
     * @return int
     */
    public function size(): int;

    /**
     * Push item to the end of array
     *
     * @param mixed $item
     */
    public function push($item): void;

    /**
     * Add item to array by specified index
     *
     * @param mixed $item
     * @param int $index
     */
    public function add($item, int $index): void;

    /**
     * Get element from array by specified index
     *
     * @param int $index
     *
     * @return mixed
     */
    public function get(int $index);

    /**
     * Remove element from array by specified index
     *
     * @param int $index
     *
     * @return mixed
     */
    public function remove(int $index);
}