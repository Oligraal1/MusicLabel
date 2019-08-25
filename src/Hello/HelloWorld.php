<?php
//pas besoin de mettre de use car magnify est dans le meme namespace
namespace App\Hello;

class HelloWorld 
{
    private $prenom;
    private $magnify;

    function __construct(string $p, Magnify $m)
    {
        $this->prenom=$p;
        $this->magnify=$m;
    }
    function yo()
    {
        return "Salut, ".$this->prenom;
    }
    function yoUp()
    {
       return $this->magnify->upper($this->yo());
    }
}