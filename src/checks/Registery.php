<?php

namespace Toxic\checks;

use Toxic\checks\movement\fly\{FlyA, FlyB};
use Toxic\checks\movement\motion\{MotionA};
use Toxic\checks\movement\speed\{SpeedA, SpeedB};
use Toxic\checks\world\scaffold\{ScaffoldA, TowerA};
use Toxic\checks\movement\noslow\{NoSlowA};
use Toxic\checks\packet\badpackets\{BadPacketsA, BadPacketsB};

class Registery {

    public static function register(){
        $checks = [
            new FlyA(),
            new FlyB(),
            new SpeedA(),
            new SpeedB(),
            new ScaffoldA(),
            new TowerA(),
            new NoSlowA(),
            new BadPacketsA(),
            new BadPacketsB()
        ];

        foreach ($checks as $check){
            Check::add($check);
        }
    }
}