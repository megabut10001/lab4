<?php
namespace lr1\LinkedList;
require_once "LinkedListNode.php";

interface ILinkedList {

    public function prepend(mixed $value) : ILinkedList;

    public function append(mixed $value) : ILinkedList;

    public function delete(mixed $value) : ?LinkedListNode;

    public function find(mixed $value) : ?LinkedListNode;

    public function deleteTail() : ?LinkedListNode;

    public function deleteHead() : ?LinkedListNode;

    public static function fromArray(array $array) : ILinkedList;

    public function toArray() : array;

    public function toString(?callable $callback) : string;
    
    public function reverse() : self;
}