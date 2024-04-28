<?php

namespace Toxic\checks;

use Toxic\checks\movement\fly\{FlyA};
use Toxic\checks\movement\speed\{MotionA};
use Toxic\checks\movement\speed\{SpeedA};
use Toxic\checks\movement\speed\{ScaffoldA};

class Registery {

    public static function register(){
        $checks = [
            new FlyA(),
        ];

        foreach ($checks as $check){
            Check::add($check);
        }
    }
}