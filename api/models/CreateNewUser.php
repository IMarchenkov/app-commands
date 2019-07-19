<?php

namespace api\models;

use common\models\User;

class CreateNewUser
{
    /**
     * Creation new user
     *
     * @param RegistrationUser $user
     *
     * @return User|null
     */
    public static function createUser($user)
    {
        $newUser = new User([
            'login' => $user->login,
            'email' => $user->email
        ]);

        $newUser->setPassword($user->password);
        $newUser->generateAuthKey();
        $newUser->generateEmailVerificationToken();
        $newUser->generateAccessToken();

        return $newUser->save() ? $newUser : null;
    }
}