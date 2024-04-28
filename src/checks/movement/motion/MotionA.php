<?php

namespace Toxic\checks\movement\motion;
use Toxic\checks\Check;

class MotionA extends Check {
    public function getId(): int{
        return 3;
    }

    public function getName(): string{
        return "Motion";
    }

    public function getMaxViolations(): int{
        return 5;
    }

    public function getSubtype(): string{
        return "A";
    }

    public function getType(): string{
        return "Movement";
    }

    public function kick(): bool{
        return false;
    }

    // TODO
}