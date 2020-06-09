<?php

//namespace省略

use pocketmine\Player;

use pocketmine\math\Vector3;

use pocketmine\inventory\InventoryHolder;
use pocketmine\inventory\ContainerInventory;

use pocketmine\network\mcpe\protocol\types\WindowTypes;

class VirtualChestInventory extends ContainerInventory {

	public function __construct(InventoryHolder $tile){
		parent::__construct($tile);
	}

	public function getNetworkType() : int{
		return WindowTypes::CONTAINER;
	}

	public function getName() : string{
		return "VirtualChest";
	}

	public function getDefaultSize() : int{
		return 27;
	}

	public function onClose(Player $who) : void {

		parent::onClose($who);

		$holder = $this->getHolder();
		$level = $who->getLevel();
		$blocks = [];
		$blocks[] = $level->getBlock(new Vector3((int) $holder->x, (int) $holder->y, (int) $holder->z));
		$level->sendBlocks(array($who), $blocks);

		$holder->closed = true;
		
	}

}
