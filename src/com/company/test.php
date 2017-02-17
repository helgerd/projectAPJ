<?php
class Musician {

    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name . "<br>";
    }

    final public function ballin()
    {
        return $this->name . " is the greatest ever!<br>"; /*
                                                             This is a multiple-lines comment block
                                                             that spans over multiple
                                                             lines
                                                            */
    }

}

class Guitarist extends Musician {

#Single-line comment 3

    public function getName()
    {
        return "My name is " . $this->name . "<br>";
    }

}

$musician = new Musician('Slash');
$guitarist = new Guitarist('Stevie Ray Vaughan');
echo $musician->getName();
echo $musician->ballin();
echo $guitarist->getName();
echo $guitarist->ballin();
?>


<?php
class Foo {
    public static function aStaticMethod() {
        // Single-line comment 1
    }
}

Foo::aStaticMethod();
$classname = 'Foo';
$classname::aStaticMethod(); // Single-line comment 2
?>
