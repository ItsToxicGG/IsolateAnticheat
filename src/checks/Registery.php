<?php

namespace Toxic\checks;

use Toxic\checks\movement\fly\{FlyA, FlyB};
use Toxic\checks\movement\motion\{MotionA};
use Toxic\checks\movement\speed\{SpeedA, SpeedB};
use Toxic\checks\world\scaffold\{ScaffoldA};

class Registery {

    public static function register(){
        $checks = [
            new FlyA(),
            new FlyB(),
            new SpeedA(),
            new SpeedB()
        ];

        foreach ($checks as $check){
            Check::add($check);
        }
    }
}