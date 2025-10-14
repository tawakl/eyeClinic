<?php

declare(strict_types = 1);

namespace App\Modules\Gallery\Repository;

use App\Modules\Gallery\Gallery;


class GalleryRepository
{
    private Gallery $gallery;

    public function __construct($gallery = null)
    {
        if ($gallery instanceof Gallery) {
            $this->gallery = $gallery;
        } else {
            $this->gallery = new Gallery();
        }
    }

    public function all()
    {
        return Gallery::latest()->get();
    }

    public function findOrFail(int $id): Gallery
    {
        return Gallery::findOrFail($id);
    }

    public function create(array $data): Gallery
    {
        return Gallery::create($data);
    }

    public function update(Gallery $gallery, array $data): Gallery
    {
        $gallery->update($data);
        return $gallery;
    }

    public function delete(Gallery $gallery): bool
    {
        return $gallery->delete();
    }
}
