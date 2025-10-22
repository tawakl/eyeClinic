<?php

namespace App\Modules\Publications\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Publications\Admin\Requests\PublicationRequest;
use App\Modules\Publications\Repository\PublicationRepository;

class PublicationController extends Controller
{
    private string $module;
    private string $title;
    private PublicationRepository $publicationRepo;

    public function __construct(PublicationRepository $publicationRepo)
    {
        $this->module = 'publication';
        $this->publicationRepo = $publicationRepo;
        $this->title = trans('publication.Publication');
    }

    public function index()
    {
        $data['page_title'] = trans('publication.List_Publication');
        $data['rows'] = $this->publicationRepo->all();
        return view('admin.' . $this->module . '.index', $data);
    }

    public function create()
    {
        $data['page_title'] = trans('publication.Add_Publication');
        return view('admin.' . $this->module . '.create', $data);
    }

    public function store(PublicationRequest $request)
    {
        $data = $request->validated();

        if (!empty($data['published_year'])) {
            $data['published_year'] = date('Y', strtotime($data['published_year']));
        }

        $this->publicationRepo->create($data);

        flash(trans('publication.publication added successfully.'))->success();
        return redirect()->route('admin.publication.index');
    }

    public function edit(int $id)
    {
        $data['page_title'] = trans('publication.Edit_Publication');
        $data['row'] = $this->publicationRepo->findOrFail($id);
        return view('admin.' . $this->module . '.edit', $data);
    }

    public function update(PublicationRequest $request, int $id)
    {
        $publication = $this->publicationRepo->findOrFail($id);
        $data = $request->validated();

        if (!empty($data['published_year'])) {
            $data['published_year'] = date('Y', strtotime($data['published_year']));
        }

        $this->publicationRepo->update($publication, $data);

        flash(trans('publication.publication updated successfully.'))->success();
        return redirect()->route('admin.publication.index');
    }

    public function destroy(int $id)
    {
        $publication = $this->publicationRepo->findOrFail($id);
        $this->publicationRepo->delete($publication);

        flash(trans('publication.publication deleted successfully.'))->success();
        return redirect()->route('admin.publication.index');
    }
}
