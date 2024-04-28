<?php

namespace Toxic\utils;
use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\entity\Location;
use pocketmine\world\World;

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

    /**
 * Checks if the given location is under a block of specified types.
 *
 * @param Location $location The location to check.
 * @param array $blockTypes An array of block types to check against.
 * @param int $down The distance below the location to check for blocks.
 * @return bool True if the location is under a block of specified types, false otherwise.
 */
public static function isUnderBlock(Location $location, array $blockTypes, int $down): bool {
    $posX = $location->getX();
    $posZ = $location->getZ();
    
    // Calculate fractional parts of X and Z coordinates
    $fracX = abs(fmod($posX, 1.0));
    $fracZ = abs(fmod($posZ, 1.0));

    $world = $location->getWorld();
    
    // Check directly below the location
    if (self::checkBlockBelow($world, $posX, $location->getY() - $down, $posZ, $blockTypes)) {
        return true;
    }

    // Check adjacent blocks based on fractional parts of X and Z coordinates
    if ($fracX < 0.3) {
        if ($fracZ < 0.3) {
            if (self::checkAdjacentBlocks($world, $posX, $location->getY() - $down, $posZ, $blockTypes, -1, -1)) {
                return true;
            }
        } elseif ($fracZ > 0.7) {
            if (self::checkAdjacentBlocks($world, $posX, $location->getY() - $down, $posZ, $blockTypes, -1, 1)) {
                return true;
            }
        }
    } elseif ($fracX > 0.7) {
        if ($fracZ < 0.3) {
            if (self::checkAdjacentBlocks($world, $posX, $location->getY() - $down, $posZ, $blockTypes, 1, -1)) {
                return true;
            }
        } elseif ($fracZ > 0.7) {
            if (self::checkAdjacentBlocks($world, $posX, $location->getY() - $down, $posZ, $blockTypes, 1, 1)) {
                return true;
            }
        }
    }

    return false;
}

/**
 * Checks if there is a block of specified types directly below the given coordinates.
 */
private static function checkBlockBelow(World $world, float $x, float $y, float $z, array $blockTypeIds): bool {
    return in_array($world->getBlock(new Vector3($x, $y, $z))->getTypeId(), $blockTypeIds, true);
}

/**
 * Checks adjacent blocks based on offsets from the given coordinates.
 */
private static function checkAdjacentBlocks(World $world, float $x, float $y, float $z, array $blockTypes, int $xOffset, int $zOffset): bool {
    $blockX = $x + $xOffset;
    $blockZ = $z + $zOffset;
    return self::checkBlockBelow($world, $blockX, $y, $blockZ, $blockTypes);
}

public static function isOnStairs(Location $location, int $down){
    $skip = [
        BlockTypeIds::STONE_STAIRS,
        BlockTypeIds::OAK_STAIRS,
        BlockTypeIds::BIRCH_STAIRS,
        BlockTypeIds::BRICK_STAIRS,
        BlockTypeIds::STONE_BRICK_STAIRS,
        BlockTypeIds::ACACIA_STAIRS,
        BlockTypeIds::JUNGLE_STAIRS,
        BlockTypeIds::PURPUR_STAIRS,
        BlockTypeIds::QUARTZ_STAIRS,
        BlockTypeIds::SPRUCE_STAIRS,
        BlockTypeIds::DIORITE_STAIRS,
        BlockTypeIds::GRANITE_STAIRS,
        BlockTypeIds::ANDESITE_STAIRS,
        BlockTypeIds::DARK_OAK_STAIRS,
        BlockTypeIds::END_STONE_BRICKS,
        BlockTypeIds::SANDSTONE_STAIRS,
        BlockTypeIds::PRISMARINE_STAIRS,
        BlockTypeIds::COBBLESTONE_STAIRS,
        BlockTypeIds::NETHER_BRICK_STAIRS,
        BlockTypeIds::RED_SANDSTONE_STAIRS,
        BlockTypeIds::SMOOTH_QUARTZ_STAIRS,
        BlockTypeIds::DARK_PRISMARINE_STAIRS,
        BlockTypeIds::POLISHED_DIORITE_STAIRS,
        BlockTypeIds::POLISHED_GRANITE_STAIRS,
        BlockTypeIds::RED_NETHER_BRICK_STAIRS,
        BlockTypeIds::SMOOTH_SANDSTONE_STAIRS,
        BlockTypeIds::MOSSY_COBBLESTONE_STAIRS,
        BlockTypeIds::MOSSY_STONE_BRICK_STAIRS,
        BlockTypeIds::POLISHED_ANDESITE_STAIRS,
        BlockTypeIds::PRISMARINE_BRICKS_STAIRS,
        BlockTypeIds::SMOOTH_RED_SANDSTONE_STAIRS
    ];

    return self::isUnderBlock($location, $skip, $down);
}

}