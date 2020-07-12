# Virtual-chest
仮想インベントリのサンプル

## Example
<pre>
/**
 * @param BlockEntityVirtualChest $entity
 * @param Player $player
 */
$entity = new BlockEntityVirtualChest(); //BlockEntityVirtualChestオブジェクトを生成
$entity->sendBlock($player->asVector3(), $player); //仮想チェストをPlayerに送信
$entity->spawn($player); //インベントリ表示
</pre>
