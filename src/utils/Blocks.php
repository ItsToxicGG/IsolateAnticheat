<?php

namespace Toxic\utils;
use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class Blocks {

    /**
     * @param Player $player
     * @return Block|null
     */
    public static function getBlockBelow(Player $player): ?Block
    {
       return $player->getWorld()->getBlock($player->getPosition()->getSide(Facing::DOWN));
    }

	    /**
     * @param Player $player
     * @return Block|null
     */
    public static function getBlockDirectlyBelow2(Player $player): ?Block
    {
	   $position = $player->getPosition()->add(0, -2.0, 0);
       return $player->getWorld()->getBlock($position->getSide(Facing::DOWN));
    }

    /**
     * @param Player $player
     * @return Block|null
     */
    public static function getBlockAbove(Player $player): ?Block
    {
        $position = $player->getPosition()->add(0, 1.0, 0);
        return $player->getWorld()->getBlock($position->getSide(Facing::UP));
    }

		    /**
     * @param Player $player
     * @return Block|null
     */
    public static function getBlockDirectlyAbove2(Player $player): ?Block
    {
	   $position = $player->getPosition()->add(0, 2.0, 0);
       return $player->getWorld()->getBlock($position->getSide(Facing::UP));
    }

/**
 * @param Player $player
 * @return Block|null
 */
public static function getBlockOnTheRight(Player $player): ?Block
{
    $position = $player->getPosition()->add(1.0, 0, 0);
    return $player->getWorld()->getBlock($position->getSide(Facing::EAST));
}

/**
 * @param Player $player
 * @return Block|null
 */
public static function getBlockOnTheLeft(Player $player): ?Block
{
    $position = $player->getPosition()->add(-1.0, 0, 0);
    return $player->getWorld()->getBlock($position->getSide(Facing::WEST));
}

/**
 * @param Player $player
 * @return Block|null
 */
public static function getBlockInFront(Player $player): ?Block
{
    $position = $player->getPosition()->add(0, 0, -1.0);
    return $player->getWorld()->getBlock($position->getSide(Facing::NORTH));
}

public static function isCurrentChunkThatPlayerisInLoaded(Player $player) : bool {
    return $player->getWorld()->isInLoadedTerrain($player->getLocation());
}

public static function isInAir(Player $player): bool{
    if ($player->isOnGround()){
        return false;
    }

    if ($player->getInAirTicks() > 25){
        return true;
    }

    if (self::getBlockBelow($player)->getTypeId() == BlockTypeIds::AIR){
        return true;
    }

    return false;
}	

    /**
     * @param Player $player
     * @return bool
     */
    public static function isInBlock(Player $player, Block $block): bool
    {

        $World = $player->getWorld();
        $blockPos = new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ());

        for ($side = 1; $side < 6; $side++){
            if ($World->getBlock($blockPos->getSide($side)) instanceof $block){
                return true;
            }
        }

        if (self::getBlockBelow($player) instanceof $block){
            return true;
        }

        if (self::getBlockAbove($player) instanceof $block){
            return true;
        }

        return false;
    }

        /**
	 * 
     * @param Player $player
     * @return bool
     */
    public static function isOnClimbable(Player $player): bool
    {

        $World = $player->getWorld();

        $minX = $player->getBoundingBox()->minX;
        $maxX = $player->getBoundingBox()->maxX;
        $minY = $player->getBoundingBox()->minY;
        $maxY = $player->getBoundingBox()->maxY;
        $minZ = $player->getBoundingBox()->minZ;
        $maxZ = $player->getBoundingBox()->maxZ;

        for ($x = $minX; $x < $maxX; $x++){
            for ($y = $minY; $y < $maxY; $y++){
                for ($z = $minZ; $z < $maxZ; $z++){
                    $blockPos = new Vector3($x, $y, $z);
                    $block = $World->getBlock($blockPos);

                    $blockBelow = self::getBlockBelow($player);
                    $blockAbove = self::getBlockAbove($player);

                    if (($block instanceof Ladder || $block instanceof Vine)){
                        return true;
                    }

                    if (($blockBelow instanceof Ladder || $blockBelow instanceof Vine)){
                        return true;
                    }

                    if (($blockAbove instanceof Ladder || $blockAbove instanceof Vine)){
                        return true;
                    }
                }
            }
        }
        return false;
    }
}