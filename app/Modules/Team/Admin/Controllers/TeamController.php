<?php

namespace App\Modules\Team\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Team\Admin\Requests\TeamRequest;
use App\Modules\Team\Repository\TeamRepository;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    private string $module = 'team';
    private string $title = 'Team Members';
    private TeamRepository $teamRepo;

    public function __construct(TeamRepository $teamRepo)
    {
        $this->teamRepo = $teamRepo;
    }

    public function index()
    {
        $data['page_title'] = 'List ' . $this->title;
        $data['rows'] = $this->teamRepo->all();
        return view('admin.' . $this->module . '.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Team Member';
        return view('admin.' . $this->module . '.create', $data);
    }

    public function store(TeamRequest $request)
    {
        $path = $request->file('image')->store('team', 'public');

        $this->teamRepo->create([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'is_active' => $request->boolean('is_active'),
        ]);

        flash('Team member added successfully.')->success();
        return redirect()->route('admin.team.index');
    }

    public function edit(int $id)
    {
        $data['page_title'] = 'Edit Team Member';
        $data['row'] = $this->teamRepo->findOrFail($id);
        return view('admin.' . $this->module . '.edit', $data);
    }

    public function update(TeamRequest $request, int $id)
    {
        $team = $this->teamRepo->findOrFail($id);
        $data = $request->only(['name', 'title', 'description', 'is_active']);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($team->image);
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $this->teamRepo->update($team, $data);
        flash('Team member updated successfully.')->success();
        return redirect()->route('admin.team.index');
    }

    public function destroy(int $id)
    {
        $team = $this->teamRepo->findOrFail($id);
        Storage::disk('public')->delete($team->image);
        $this->teamRepo->delete($team);

        flash('Team member deleted successfully.')->success();
        return redirect()->route('admin.team.index');
    }
}
