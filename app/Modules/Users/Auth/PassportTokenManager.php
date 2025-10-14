<?php

declare(strict_types = 1);

namespace App\Modules\Users\Auth;

use App\Modules\Users\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Laravel\Passport\TokenRepository;

class PassportTokenManager
{

    /**
     * @param string $identifier
     * @return string
     */
    public function createAuthToken(string $identifier): string
    {
        return $this->createUserToken($identifier, auth()->user());
    }

    /**
     * @param string $identifier
     * @param User $user
     * @return string
     */
    public function createUserToken(string $identifier, User $user): string
    {
        return $user->createToken($identifier)->accessToken;
    }

    public function revokeAuthAccessToken(): void
    {
        $user = Auth::guard('api')->user();
        if ($user && $user->token()) {
            $this->revokeAccessToken($user->token()->id);
        } else {
            throw new \Exception('User is not authenticated or does not have a token.');
        }
    }

    public function revokeAccessToken(string $tokenIdentifier): void
    {
        $tokenRepository = new TokenRepository();
        $tokenRepository->revokeAccessToken($tokenIdentifier);
    }
}
