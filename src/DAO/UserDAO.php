<?php 

namespace Src\DAO;
use Src\Utils\DB;
use Src\Beans\UserBean;

class UserDAO extends DB {

    public static function getAll(): Array {
        $users = parent::selectQuery("SELECT * FROM users", UserBean::class);
        return $users;
    }

    public static function fetch(Array $param, String $field): ?UserBean {
        
        $sql = "SELECT * FROM users WHERE $field = ?";
        $users = parent::selectQuery($sql, UserBean::class, $param);
        if(count($users) > 0 ) {
            return $users[0];
        }
        return null;
    }

    public static function getAllWhere(String $whereClause): Array {
        $users = parent::selectQuery("SELECT * FROM users WHERE $whereClause", UserBean::class);
        return $users;
    }

    public static function update(Array $data) {
        //PDO execute returns true or false, extra check for exception does not hurt
        try {
            if(self::isDirty($data)) {
                $userId = $_SESSION['user_id'];
                $query = "UPDATE users SET";
                $values = [];
                foreach($data as $name => $value) {
                    //this will concatinate string and will produce 
                    //e.g. UPDATE users SET city = :city (:city is replaced by pdo on prepare statement)
                    $query .= ' ' .$name . ' = :' . $name . ',';
                    $values[':'.$name] = $value;
                }
                
                $query = substr($query, 0, -1).' ';
                // we are assuming that we are only updating our own profile
                $query .= "WHERE id = $userId;";
                parent::execute($query, $values);
                return true;
            }
        } catch (Exception $e) {
            //TODO: set up logger and log the exceptions (file or db)
            return false;
        }
    }


	/**
     * Dirty compares if there are any changes to the object that are not yet saved
     * This is quite simplified solution
     */

	private static function isDirty(Array $data) {
        $usrId = $_SESSION['user_id'];
        $usr = self::fetch([$usrId], 'ID');

        foreach($data as $field => $value) {
            $get = "get" . ucfirst($field);
            if($usr->$get() !== $value) {
                return true;
            }
        }
        return false;
	}
}