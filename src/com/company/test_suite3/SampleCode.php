<?php
/**
 * Define MyClass
 */
class MyClass
{
    // Declare a public constructor
    public function __construct() { }
    // Declare a public method
    public function MyPublic() { }
    // Declare a protected method
    protected function MyProtected() { }
    // Declare a private method
    private function MyPrivate() { }
    // This is public

    function Foo()
    {
        $this = MyPublic();
    }

    var $bar = 'I am bar.';
    var $arr = array('I am A.', 'I am B.', 'I am C.');
    var $r   = 'I am r.';

    private $priv = 'I am a private attribute';
}

?>
