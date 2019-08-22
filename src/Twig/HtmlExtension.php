<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class HtmlExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('figure', [$this, 'figureFilter']),
        ];
    }
    public function figureFilter($path, $legend,$width, $height, $alt)
    {
        return "<figure><img src='$path' alt='$alt' style=width:$width;height:$height><figcapion>$legend</figcaption></figure>";
    }
}
