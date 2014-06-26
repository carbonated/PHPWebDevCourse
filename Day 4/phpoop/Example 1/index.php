<?php
include 'Animals.php';
include 'Dog.php';
include 'Cat.php';

$animal = new Animals('red', 1);


$dog = new Dog('sivo', 5);
$dog->Eat();
$dog->bark();
echo $dog->legs;

$cat = new Cat('jylt', 2);
$cat->meow();