<?php 

namespace Src\Services;
use Slim\Http\Request;
use Slim\Http\Response;
use Src\DAO\UserDAO;

class EditProfileService extends Service {

    public function handlePost() {

        $fields = $this->input([
            'username',
            'email',
            'first_name',
            'last_name',
            'age',
            'biography',
            'interests',
            'sexual_preference',
            'city',
            'province',
            'country',
            'postal_code'
        ]);

        /**
         * Remove everything that is empty - we don't want to delete data
         */
        $fields = array_filter($fields, function($val) {
            return !empty($val);
        });

        $user = UserDAO::fetch([$_SESSION['user_id']]);
        $update_state = UserDAO::update($fields);

        return $this->render('profile.html', ['update_success' => $update_state, 'user' => $user]);

    }

}