<?php 

namespace Src\DAO;
use Src\Utils\DB;
use Src\Beans\UserBean;
use Src\Utils\Crypt;
use Src\DAO\UserDAO;
use Src\Beans\Bean;
use Src\Beans\FameBean;

class FameDAO extends DB {

    public static function insertFame(UserBean $rating) {
        
        $sql = "INSERT INTO users (fame_rating) VALUES (:rating)";

        $values = [
            'rating' => $rating->getId(),
        ];
        parent::execute($sql, $values);
    }

    public static function getFame(UserBean $rating): Array {
        $fame = parent::selectQuery("SELECT * FROM users WHERE fame_rating = ?", UserBean::class, getFame());
        return $fame;
    }

    public static function addFame(UserBean $rating, UserBean $user, UserBean $likes) {
        $fame = UserBean::getFame($rating);

        if ($user )
    }

}