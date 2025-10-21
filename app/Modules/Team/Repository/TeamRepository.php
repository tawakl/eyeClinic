<?php

declare(strict_types = 1);

namespace App\Modules\Team\Repository;

use App\Modules\Team\Team;


class TeamRepository
{
    private Team $team;

    public function __construct($team = null)
    {
        if ($team instanceof Team) {
            $this->team = $team;
        } else {
            $this->team = new Team();
        }
    }

    public function all()
    {
        return $this->team->latest()->paginate();
    }

    public function findOrFail(int $id): Team
    {
        return $this->team->findOrFail($id);
    }

    public function create(array $data): Team
    {
        return $this->team->create($data);
    }

    public function update(Team $team, array $data): Team
    {
        $team->update($data);
        return $team;
    }

    public function delete(Team $team): bool
    {
        return $team->delete();
    }
}
