<?php

// php 5.3 test

class A {
    private $a = false;

    public function __construct($a)
    {
        $this->setA($a);
    }

    public function setA($a)
    {
        $this->a = $a;
    }
}

class B {
    private $a = array();

    public function __construct()
    {
    }

    public function add(A $a)
    {
        $this->a[] = $a;

        return $this;
    }
}


$b = new B();

$b
    ->add(new A('1'))
    ->add(new A('2'))
    ;
$b->add(
    (new A('2'))
        ->setA('3')
    );

var_dump($b);

?>
