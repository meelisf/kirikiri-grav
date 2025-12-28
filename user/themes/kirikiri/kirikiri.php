<?php
namespace Grav\Theme;

use Grav\Common\Theme;

class Kirikiri extends Theme
{
    // Access plugin events in this class
    public static function getCurrentDate()
    {
        return date('d-m-Y H:i');
    }
}
