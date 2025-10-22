<?php

namespace App\Modules\Team\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Team\Admin\Requests\TeamRequest;
use App\Modules\Team\Repository\TeamRepository;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    private  $module;
    private  $title ;
    private  $teamRepo;

    public function __construct(TeamRepository $teamRepo)
    {
        $this->module = 'team';
        $this->teamRepo = $teamRepo;
        $this->title = trans('team.Team_Members');

    }

    public function index()
    {
        $data['page_title'] = trans('team.List_team_members');
        $data['rows'] = $this->teamRepo->all();
        return view('admin.' . $this->module . '.index', $data);
    }

    public function create()
    {
        $data['page_title'] = trans('team.Add_Team_Member');
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
        flash(trans('team.Team member added successfully.'))->success();
        return redirect()->route('admin.team.index');
    }

    public function edit(int $id)
    {
        $data['page_title'] = trans('team.Edit_Team_Member');
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
        flash(trans('team.Team member updated successfully.'))->success();
        return redirect()->route('admin.team.index');
    }

    public function destroy(int $id)
    {
        $team = $this->teamRepo->findOrFail($id);
        Storage::disk('public')->delete($team->image);
        $this->teamRepo->delete($team);
        flash(trans('team.Team member deleted successfully.'))->success();
        return redirect()->route('admin.team.index');
    }
}
