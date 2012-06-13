<?php

namespace PivotX\Component\Views;

class ArrayView extends AbstractView
{
    protected $array = null;

    public function __construct(array $array, $name, $group = 'Ungrouped', $description = null)
    {
        $this->setArray($array);

        $this->name        = $name;
        $this->group       = $group;
        $this->description = $description;
    }

    public function setIndexedArray(array $array)
    {
        if (count($array) == 0) {
            $this->array = $array;
            return;
        }

        if (is_array($array[0]) || is_object($array[0])) {
            $this->array = $array;

            return;
        }

        // @todo why value/title....
        $this->array = array();
        foreach($array as $title) {
            $this->array[] = array(
                'value' => count($this->array),
                'title' => $title
            );
        }
    }

    public function setAssociativeArray(array $array)
    {
        // @todo why value/title....
        $this->array = array();
        foreach($array as $value => $title) {
            $this->array[] = array(
                'value' => $value,
                'title' => $title
            );
        }
    }

    public function setArray(array $array)
    {
        // @todo find the best way to find associative or not array
        if (array_values($array) === $array) {
            return $this->setIndexedArray($array);
        }

        return $this->setAssociativeArray($array);
    }

    public function getResult()
    {
        return $this->array;
    }

    public function getLength()
    {
        return count($this->array);
    }
}
