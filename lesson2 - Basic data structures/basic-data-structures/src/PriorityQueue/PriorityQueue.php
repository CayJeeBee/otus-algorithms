<?php

declare(strict_types=1);


namespace OtusAlgorithms\PriorityQueue;


use LogicException;
use OtusAlgorithms\DynamicArray\FactorArray;
use OtusAlgorithms\PriorityQueue as PriorityQueueInterface;

class PriorityQueue implements PriorityQueueInterface
{

    /**
     * @var FactorArray
     */
    private $priorities;

    /**
     * @var FactorArray
     */
    private $queues;

    public function __construct()
    {
        $this->priorities = new FactorArray();
        $this->queues     = new FactorArray();
    }

    public function enqueue(int $priority, $item): void
    {
        $this->createQueueIfNotExists($priority);

        $this->requireQueue($priority)
            ->enqueue($item);
    }

    public function dequeue(int $priority)
    {
        return $this->requireQueue($priority)
            ->dequeue();
    }

    private function createQueueIfNotExists(int $priority):void
    {
        if (!$this->hasQueue($priority)) {
            $this->createQueue($priority);
        }
    }

    private function createQueue(int $priority)
    {
        $this->queues->add(new Queue(), $this->priorities->size());
        $this->priorities->add($priority, $this->priorities->size());
    }

    private function requireQueue(int $priority): Queue
    {
        $queue = $this->findQueue($priority);

        if (!$queue) {
            throw new LogicException();
        }

        return $queue;
    }

    private function hasQueue(int $priority): bool
    {
        return ($this->findQueue($priority) !== null);
    }

    private function findQueue(int $priority): ?Queue
    {
        $result = null;

        $prioritiesCount = $this->priorities->size();

        for ($i = 0; $i < $prioritiesCount; $i++) {
            if ($this->priorities->get($i) === $priority) {
                $result = $this->queues->get($i);
                break;
            }
        }

        return $result;
    }
}
