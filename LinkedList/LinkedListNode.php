<?php
namespace lr1\LinkedList;

class LinkedListNode {
    private mixed $value;
    private ?LinkedListNode $next;

    public function __construct(mixed $value, ?LinkedListNode $next) {
        $this->value = $value;
        $this->next = $next;
    }

    public function __toString() : string
    {
        return (string)$this->value;
    }

    public function getNext() : ?LinkedListNode {
        return $this->next;
    }
    
    public function setNext(?LinkedListNode $next) : void {
         $this->next = $next;
    }

    public function hasNext() : bool {
        return isset($this->next);
    }

    public function getValue() : mixed {
        return $this->value;
    }

    public function setValue(mixed $value) : void {
        $this->value = $value;
    }
}