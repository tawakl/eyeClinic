<?php

declare(strict_types=1);

namespace App\Modules\Gallery\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Modules\Gallery\Admin\Requests\GalleryRequest;
use App\Modules\Gallery\Repository\GalleryRepository;

class GalleryController extends Controller
{
    private string $module;
    private string $title;
    private GalleryRepository $galleryRepo;

    public function __construct(GalleryRepository $galleryRepo)
    {
        $this->module = 'gallery';
        $this->title = trans('gallery.gallery');
        $this->galleryRepo = $galleryRepo;
    }

    public function index()
    {
        $data['page_title'] = trans('app.List') . ' ' . $this->title;
        $data['rows'] = $this->galleryRepo->all();

        return view('admin.' . $this->module . '.index', $data);
    }

    public function create()
    {
        $data['page_title'] = trans('gallery.add_image');
        $data['breadcrumb'] = [$this->title => route('admin.gallery.index')];

        return view('admin.' . $this->module . '.create', $data);
    }

    public function store(GalleryRequest $request)
    {
        $path = $request->file('image')->store('gallery', 'public');

        $this->galleryRepo->create([
            'image' => $path,
            'caption' => $request->caption,
        ]);

        flash(trans('gallery.Image added successfully.'))->success();

        return redirect()->route('admin.gallery.index');
    }

    public function edit(int $id)
    {
        $data['page_title'] = trans('gallery.edit_image');
        $data['breadcrumb'] = [$this->title => route('admin.gallery.index')];
        $data['row'] = $this->galleryRepo->findOrFail($id);

        return view('admin.' . $this->module . '.edit', $data);
    }

    public function update(GalleryRequest $request, int $id)
    {
        $gallery = $this->galleryRepo->findOrFail($id);
        $data = ['caption' => $request->caption];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image);
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $this->galleryRepo->update($gallery, $data);

        flash(trans('gallery.Image updated successfully.'))->success();

        return redirect()->route('admin.gallery.index');
    }

    public function destroy(int $id)
    {
        $gallery = $this->galleryRepo->findOrFail($id);
        Storage::disk('public')->delete($gallery->image);
        $this->galleryRepo->delete($gallery);

        flash(trans('gallery.Image deleted successfully.'))->success();

        return redirect()->route('admin.gallery.index');
    }
}
