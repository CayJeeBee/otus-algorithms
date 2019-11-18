<?php

declare(strict_types=1);


namespace OtusAlgorithms\PriorityQueue;


class Node
{

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var Node|null
     */
    private $nextNode;

    public function __construct($value, ?self $nextNode)
    {
        $this->value = $value;

        $this->nextNode = $nextNode;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getNextNode(): ?self
    {
        return $this->nextNode;
    }

    public function setNextNode(self $nextNode): void
    {
        $this->nextNode = $nextNode;
    }

}
