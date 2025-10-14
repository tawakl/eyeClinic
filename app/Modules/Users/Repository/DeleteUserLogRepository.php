<?php

declare(strict_types = 1);

namespace App\Modules\Users\Repository;

use App\Modules\Users\Models\DeleteUserLog;

class DeleteUserLogRepository
{
    private DeleteUserLog $deleteUserLog;

    public function __construct($deleteUserLog = null)
    {
        if ($deleteUserLog instanceof DeleteUserLog) {
            $this->deleteUserLog = $deleteUserLog;
        } else {
            $this->deleteUserLog = new DeleteUserLog();
        }
    }

    public function logUserDeletion(int $userId, string $deletedBy): void
    {
        $this->deleteUserLog->create(
            [
            'user_id' => $userId,
            'deleted_by' => $deletedBy,
            ]
        );
    }
}
