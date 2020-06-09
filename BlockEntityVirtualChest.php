<?php

//namespace省略

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;

use pocketmine\block\BlockFactory;

use pocketmine\inventory\InventoryHolder;

use pocketmine\math\Vector3;

use pocketmine\nbt\NetworkLittleEndianNBTStream;

use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\CompoundTag;

use pocketmine\network\mcpe\protocol\UpdateBlockPacket;
use pocketmine\network\mcpe\protocol\BlockActorDataPacket;
use zerosan96\Main;

class BlockEntityVirtualChest extends Vector3 implements InventoryHolder {

	protected $inventory;

	public function __construct() {
		$this->inventory = new VirtualChestInventory($this);
	}

	/**
	 * @return VirtualChestInventory
	 */
	public function getInventory() : VirtualChestInventory {
		return $this->inventory;
	}

	public function spawn(Player $player) : void {

		$player->addWindow($this->getInventory());

		$inventory = $this->getInventory();

	}


	public function sendBlock(Vector3 $pos, Player $player) : void {

		$this->x = (int) $pos->x;
		$this->y = (int) $pos->y - 2;
		$this->z = (int) $pos->z;

		$pk = new UpdateBlockPacket();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->blockRuntimeId = BlockFactory::toStaticRuntimeId(54, 3);

		$pk->flags = 0x02;
		$player->dataPacket($pk);

		$custom = "チェストの名前";
		$nbt = new CompoundTag("", [
			new StringTag("id", "Chest"),
			new IntTag("x", $this->x),
			new IntTag("y", $this->y),
			new IntTag("z", $this->z),
			new StringTag("CustomName", $custom)
		]);
		$stream = new NetworkLittleEndianNBTStream();
		$pk = new BlockActorDataPacket();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->namedtag = $stream->write($nbt);
		$player->dataPacket($pk);

	}

}
