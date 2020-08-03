<?php

namespace Src\Services;

use Slim\Http\Request;
use Slim\Http\Response;
use Src\Utils\Validator;
use Src\Utils\DB;
use Src\DAO\UserDAO;
use Src\DAO\BlocksDAO;

class BrowseService extends Service 
{
	/**
	 * Just render the browse page
	 */
	public function viewPage()
	{

		$origin = UserDAO::fetch([$_SESSION['user_id']], 'ID');
		//get blocks
		$blockedUsers = BlocksDAO::getAllBlockedUsersForOrigin($origin);

		$allNotBlockedUsers = "";

		foreach($blockedUsers as $blockedUser) {
			$allNotBlockedUsers .= $blockedUser->getTarget_id() . ",";
		}

		$allNotBlockedUsers = rtrim($allNotBlockedUsers, ',');

		//get all users (not blocked ones)
		if(strlen($allNotBlockedUsers > 0)) {
			$users = UserDAO::getAllWhere("id NOT IN(" . $allNotBlockedUsers . ")");
		} else {
			$users = UserDAO::getAll();
		}

		$params = [ 'users' => $users ];
		return $this->render('browse.html', $params);
	}

	public function search() {
		$fields = $this->input([
			'selectAgeRange',
			'selectFameRatingGap',
			'city',
			'province',
			'country',
			'interests'
		]);

		$origin = UserDAO::fetch([$_SESSION['user_id']], 'ID');

		$q = "";
		foreach($fields as $field => $val) {
			if(!empty($val) && $val != 'Select Age Range' && $val != 'Select Fame Rating Gap') {
				if($field == 'selectAgeRange') {
					$str = str_replace(' years', '', $val);
					if(strpos($str, '-') !== false) {
						$age = explode('-', $str);
						$q .= " age BETWEEN " . ($origin->getAge() + $age[0]) . " AND " . ($origin->getAge() + $age[1]);
					}

					else if(is_numeric($str)) {
						$q .= " age >= " . ($origin->getAge() + $str);
					} 
					else {
						$str = str_replace(' year', '', $val);
						$q .= " age >= " . ($origin->getAge() + $str);
					}

				}
				if($field == 'selectFameRatingGap') {
					if(strpos($val, '+')) {
						$fame = str_replace('+', '', $val);
						if(empty($q)) {
							$q .= " fame_rating >= " . $origin->getFame_rating() + $fame;
						} else {
							$q .= " AND fame_rating >= " . $origin->getFame_rating() + $fame;
						}
					}
					else {
						$fame = explode('-', $val);
						if(empty($q)) {
							$q .= " fame_rating BETWEEN " . $origin->getFame_rating() + $fame[0] . " AND " . $origin->getFame_rating() + $fame[1];
						} else {
							$q .= " AND fame_rating BETWEEN " . ($origin->getFame_rating() + $fame[0]) . " AND " . ($origin->getFame_rating() + $fame[1]);
						}
					}
				}


				if($field == 'city' && !empty($val)) {
					if(empty($q)) {
						$q .= " city = '" . $val . "'";
					} else {
						$q .= " AND city = '" . $val . "'";
					}
				}

				if($field == 'province'  && !empty($val)) {
					if(empty($q)) {
						$q .= " province = '" . $val . "'";
					} else {
						$q .= " AND province = '" . $val ."'";
					}
				}

				if($field == 'country'  && !empty($val)) {
					if(empty($q)) {
						$q .= " country = '" . $val . "'";
					} else {
						$q .= " AND country = '" . $val . "'";
					}
				}

				if($field == 'interests'  && !empty($val)) {
					if(empty($q)) {
						$q .= " interests LIKE \"%" . $val . "%\"";
					} else {
						$q .= " AND interests LIKE \"%" . $val . "%\"";
					}
				}
			}
		}
		echo $q;

		$origin = UserDAO::fetch([$_SESSION['user_id']], 'ID');
		//get blocks
		$blockedUsers = BlocksDAO::getAllBlockedUsersForOrigin($origin);

		$allNotBlockedUsers = "";

		foreach($blockedUsers as $blockedUser) {
			$allNotBlockedUsers .= $blockedUser->getTarget_id() . ",";
		}

		$allNotBlockedUsers = rtrim($allNotBlockedUsers, ',');

		if(strlen($allNotBlockedUsers > 0)) {
			$users = UserDAO::getAllWhere("id NOT IN(" . $allNotBlockedUsers . ")");
		} else {
			$users = UserDAO::getAllWhere($q);
		}

		$params = [ 'users' => $users ];
		return $this->render('browse.html', $params);
	}
}