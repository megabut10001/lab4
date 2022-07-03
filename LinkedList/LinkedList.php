<?php
namespace lr1\LinkedList;

require_once "ILinkedList.php";

class LinkedList implements ILinkedList, \ArrayAccess, \Countable, \IteratorAggregate {
    private ?LinkedListNode $head, $tail;

    public function __construct() {
        $this->head = $this->tail = null;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->toArray());
    }

    public function count(): int
    {
        $count = 0;

        for($el = $this->head; isset($el); $el = $el->getNext()){
            $count++;
        }

        return $count;
    }

    public function offsetExists($offset): bool
    {
        if(is_int($offset)) {
            return $this->get($offset) !== null;
        }
        return false;
    } 

    public function offsetGet(mixed $offset): mixed
    {
        if(is_int($offset)) {
            return $this->get($offset);
        }
        return null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->append($value);
            return;
        }
        if(is_int($offset)) {
            $el = $this->head;
            for($i = 0; $i < $offset; $i++) {
                if(!$el->hasNext()) {
                    return;
                }
                $el = $el->getNext();
            }
            if(isset($el)) {
                $el->setValue($value);
            }
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        if(is_int($offset)) {
            $el = $this->head;
            for($i = 0; $i < $offset - 1; $i++) {
                if(!$el->hasNext()) {
                    return;
                }
                $el = $el->getNext();
            }
            if($el->hasNext()) {
                $el->setNext($el->getNext()->getNext());
            }
        }
    }

    private function get(int $index) : mixed {
        $el = $this->head;
        for($i = 0; $i < $index; $i++) {
            if(!$el->hasNext()) {
                return null;
            }
            $el = $el->getNext();
        }
        return $el?->getValue();
    }

    public function prepend(mixed $value) : LinkedList {
        $this->head = new LinkedListNode($value, $this->head);
        if(!isset($this->tail)) {
            $this->tail = $this->head;
        }
        return $this;
    }

    public function append(mixed $value) : LinkedList {
        $oldTail = $this->tail;
        $this->tail = new LinkedListNode($value, null);
        $oldTail?->setNext($this->tail);
        if(!isset($this->head)) {
            $this->head = $this->tail;
        }
        return $this;
    }

    public function delete(mixed $value) : ?LinkedListNode {
        while (isset($this->head) && $this->head->getValue() == $value) {
            $this->deleteHead();
        }
        $prev = $this->head;

        for ($el = $prev->getNext(); $el?->hasNext(); $el = $el->getNext()) {
            if($el->getValue() == $value){
                $deletedNode = $el;
                if(isset($prev))
                    $prev->setNext($el->getNext());
            } else {
                $prev = $el;
            }
        }

        if($this->tail?->getValue() == $value)
            $deletedNode = $this->deleteTail();
        
        return $deletedNode;
    }

    public function find(mixed $value) : ?LinkedListNode {
        for ($el = $this->head; isset($el); $el = $el->getNext()) {
            if($el->getValue() == $value)
                return $el;
        }
        return null;
    }

    public function deleteTail() : ?LinkedListNode {
        $deletedNode = $this->tail;
        if($this->tail === $this->head) {
            $element = $this->tail;
            $this->head = $this->tail = null;
            return $element;
        }
        for ($el = $this->head; $el->getNext()->hasNext(); $el = $el->getNext());
        $el->setNext(null);
        $this->tail = $el;
        return $deletedNode;
    }

    public function deleteHead() : ?LinkedListNode {
        $deletedNode = $this->head;
        if($this->tail === $this->head)   
            $this->head = $this->tail = null;
        $this->head = $this->head?->getNext();
        return $deletedNode;
    }

    public function isEmpty() : bool {
        return !(isset($this->tail) || isset($this->head));
    } 

    public static function fromArray(array $array) : LinkedList {
        $newList = new LinkedList;

        foreach($array as $element) {
            $newList->append($element);
        }

        return $newList;
    }

    public static function copyList(LinkedList $list) : LinkedList {
        $newList = new LinkedList;
        $i = 0;
        do {
            $newList->append($list->get($i));
        }while($list->get(++$i) != null);
        return $newList;
    }

    public function toArray() : array {
        $result = [];
        for ($el = $this->head; isset($el); $el = $el->getNext()) {
            $result[] = $el->getValue();
        }
        return $result;
    }

    public function toString(?callable $callback = null) : string {
        if(!isset($callback))
            $callback = fn($el) => (string)$el;
        $result = '';
        for ($el = $this->head; isset($el); $el = $el->getNext()) {
            $result .= $callback($el);
        }
        return $result;
    }

    public function reverse() : LinkedList {
        $reversedList = new LinkedList;

        for ($el = $this->head; isset($el); $el = $el->getNext()) {
            $reversedList->prepend($el->getValue());
        }

        return $reversedList;
    }
}

