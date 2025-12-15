<?php

namespace App\Policies;

use App\Models\User as UserModel;

class UserPolicy
{
    public function update(UserModel $user, UserModel $userUpdate)
    {
        return $user->role === UserModel::ROLE_ADMIN_ID;
    }
}
