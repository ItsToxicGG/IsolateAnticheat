<?php

namespace Toxic\utils;

use pocketmine\math\Vector3;
use pocketmine\player\Player;

class Maths {

/**
 * Calculate player speed
 * @param Player $player
 * @param Vector3 $prevPos
 * @return float
 */
public static function getSpeed(Player $player, Vector3 $prevPos): float {
    $currentPos = $player->getLocation();
    $distance = $currentPos->distance($prevPos);
    $speed = $distance / 0.1;
    return round($speed, 2);
}
    /**
     * Find every possible coordinate between two sets of Vector3's
     * @param Vector3 $pos1
     * @param Vector3 $pos2
     * @return Vector3[]
     */
    public static function getBlocksBetween(Vector3 $pos1, Vector3 $pos2): array {
        $minX = $pos1->x;
        $minY = $pos1->y;
        $minZ = $pos1->z;
        $maxX = $pos2->x;
        $maxY = $pos2->y;
        $maxZ = $pos2->z;

        $coordinates = [];

        for ($x = $minX; $x <= $maxX; $x++) {
            for ($y = $minY; $y <= $maxY; $y++) {
                for ($z = $minZ; $z <= $maxZ; $z++) {
                    $coordinates[] = new Vector3($x, $y, $z);
                }
            }
        }

        return $coordinates;
    }

    /**
     * Calculate angle between player and entity hit
     * @param Player $player
     * @param Player $entityHit
     * @return float
     */
    public static function angleCalc(Player $player, Player $entityHit): float {
        $pos1 = $player->getLocation();
        $pos2 = $entityHit->getLocation();
        $angle = atan2(($pos2->z - $pos1->z), ($pos2->x - $pos1->x)) * 180 / M_PI - $player->getLocation()->getYaw() - 90;
        if ($angle <= -180) $angle += 360;
        $angle = abs($angle);
        return $angle;
    }

    /**
     * Calculate player horizontal velocity
     * @param Player $player
     * @param Vector3 $prevPos
     * @param float $deltaTime
     * @return float
     */
    public static function hVelocity(Player $player, Vector3 $prevPos, float $deltaTime): float {
        $currentPos = $player->getLocation();
        $deltaX = $currentPos->x - $prevPos->x;
        $deltaZ = $currentPos->z - $prevPos->z;
        $hVelocity = sqrt($deltaX ** 2 + $deltaZ ** 2) / $deltaTime;
        return round($hVelocity, 2);
    }

    /**
     * Calculates the absolute greatest common divisor of two numbers
     * @param float $current
     * @param float $last
     * @return float
     */
    public static function getAbsoluteGcd(float $current, float $last): float {
        $EXPANDER = 1.6777216E7;

        $currentExpanded = floor($current * $EXPANDER);
        $lastExpanded = floor($last * $EXPANDER);

        return self::gcd($currentExpanded, $lastExpanded);
    }

    /**
     * Recursive implementation of greatest common divisor (GCD) calculation
     * @param float $a
     * @param float $b
     * @return float
     */
    private static function gcd(float $a, float $b): float {
        if (!$b) {
            return $a;
        }

        return self::gcd($b, $a % $b);
    }
}