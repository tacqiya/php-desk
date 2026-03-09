<!-- 
| Feature              | Interface                | Abstract Class                         |
| -------------------- | ------------------------ | -------------------------------------- |
| Methods              | Only declarations        | Can have both abstract and implemented |
| Properties           | No properties            | Can have properties                    |
| Access Modifiers     | Public only              | Public, protected, private             |
| Multiple inheritance | Can implement multiple   | Can extend only one                    |
| Purpose              | Define behavior contract | Provide base functionality             | -->

<?php

// An Abstract Class is a base class that cannot be instantiated, but can contain both abstract methods and implemented methods.

// Key Characteristics
// Can contain abstract methods (without body) and normal methods (with body).
// Can have properties.
// Can use any access modifier (public, protected, private).
// A class can extend only one abstract class.

// Use Abstract Class → when you want to share common code between related classes

abstract class Animal {
    abstract public function makeSound();

    public function sleep() {
        echo "The animal is sleeping.\n";
    }
}

class Dog extends Animal {
    public function makeSound() {
        echo "Woof! Woof!\n";
    }
}

$dog = new Dog();
$dog->makeSound();
$dog->sleep();