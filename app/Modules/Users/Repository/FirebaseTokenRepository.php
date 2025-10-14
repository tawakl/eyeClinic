<?php

declare(strict_types = 1);

namespace App\Modules\Users\Repository;

use App\Modules\Users\User;

class FirebaseTokenRepository
{


    public function delete(User $user, array $data)
    {
        return $user->firebaseTokens()->where($data)->delete();
    }
}
