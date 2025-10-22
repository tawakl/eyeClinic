<?php

declare(strict_types = 1);

namespace App\Modules\Publications\Repository;



use App\Modules\Publications\Publication;

class PublicationRepository
{
    private Publication $publication;

    public function __construct($publication = null)
    {
        if ($publication instanceof Publication) {
            $this->publication = $publication;
        } else {
            $this->publication = new Publication();
        }
    }

    public function all()
    {
        return $this->publication->latest()->paginate(10);
    }

    public function findOrFail(int $id): Publication
    {
        return $this->publication->findOrFail($id);
    }

    public function create(array $data): Publication
    {
        return $this->publication->create($data);
    }

    public function update(Publication $publication, array $data): Publication
    {
        $publication->update($data);
        return $publication;
    }

    public function delete(Publication $publication): bool
    {
        return $publication->delete();
    }
}
