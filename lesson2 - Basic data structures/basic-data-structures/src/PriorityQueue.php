<?php

declare(strict_types=1);


namespace OtusAlgorithms;


interface PriorityQueue
{
    /**
     * Add item to queue
     *
     * @param int $priority
     * @param mixed $item
     *
     * @return void
     */
    public function enqueue(int $priority, $item): void;

    /**
     * Get item from queue
     *
     * @param int $priority
     *
     * @return mixed
     */
    public function dequeue(int $priority);
}
