<?php

namespace api\models;

use common\models\Board;
use common\models\User;

class InitBoardUser
{
    private const NAME_FIRST_USER_BOARD = 'Личная доска';

    /**
     * Initialization new user's board 
     *
     * @param User $user
     *
     * @return bool whether the initialization succeeded
     */
    public static function initBoard($user)
    {
        $board = new Board([
            'name' => self::NAME_FIRST_USER_BOARD,
            'user_id' => $user->id,
        ]);

        return $board->save();
    }
}
