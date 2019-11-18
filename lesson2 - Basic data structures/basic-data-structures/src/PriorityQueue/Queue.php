<?php

declare(strict_types=1);


namespace OtusAlgorithms\PriorityQueue;


class Queue
{

    /**
     * @var Node|null
     */
    private $tail;

    /**
     * @var Node|null
     */
    private $head;

    public function enqueue($item): void
    {
        $newNode = new Node($item, null);

        if ($this->tail) {
            $this->tail->setNextNode($newNode);
        }

        $this->tail = $newNode;

        if (!$this->head) {
            $this->head = $this->tail;
        }
    }

    /**
     * @return mixed|null
     */
    public function dequeue()
    {
        if ($this->head) {
            $value    = $this->head->getValue();
            $nextNode = $this->head->getNextNode();

            if (!$nextNode) {
                $this->tail = $nextNode;
            }

            $this->head = $nextNode;
        } else {
            $value = $this->head;
        }

        return $value;
    }
}
