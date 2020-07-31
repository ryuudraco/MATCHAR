<?php 

namespace Src\DAO;
use Src\Utils\DB;
use Src\Beans\UserBean;
use Src\Utils\Crypt;
use Src\DAO\UserDAO;
use Src\Beans\BlocksBean;

class BlocksDAO extends DB {

    public static function countAllUserReceivedBlocks(UserBean $user): int {
        $count = parent::select("SELECT count(id) as count FROM blocks WHERE target_id = ?", [$user->getId()]);
        return $count[0]['count'];
    }

    public static function getAllTotals() {
        $count = parent::selectQuery("SELECT count(target_id) as total, target_id from blocks group by target_id", BlocksBean::class);
        print_r($count);
        return $count;
    }

    public static function getBlock(UserBean $target, UserBean $origin): Array {
        $blocks = parent::select("SELECT * FROM Blocks WHERE target_id = ? AND origin_id = ?", [$target->getId(), $origin->getId()]);
        return $blocks;
    }

    public static function blockUnblockProfile(UserBean $target, UserBean $origin) {
        
        $block = self::getBlock($target, $origin);

        //guess we didn't liked that user yet
        if(empty($block)) {
            $sql = "INSERT INTO blocks (origin_id, target_id) VALUES (:origin, :target)";
        } else {
            $sql = "DELETE FROM blocks WHERE origin_id = :origin AND target_id = :target";
        }

        $values = [
            'origin' => $origin->getId(),
            'target' => $target->getId()
        ];
        parent::execute($sql, $values);
    }
}