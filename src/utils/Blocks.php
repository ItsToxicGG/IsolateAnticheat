<?php

namespace Toxic\utils;
use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\math\Facing;
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

}