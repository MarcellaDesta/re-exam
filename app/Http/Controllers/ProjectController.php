<?php

namespace App\Http\Controllers;
use App\Models\Project;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('project-user',[
            'projects' => $projects,
        ]);
    }


    public function create() {
        $projects = Project::findOrFail();
        return view('project-user', compact('project'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'category' => 'required'
        // ],[
        //     'name.required' => 'Nama Wajib Diisi....',
        //     'description.required' => 'Deskripsi wajib disii....',
        //     'status.required' => 'Status wajib diisi....',
        //     'category.required' => 'Kategori wajib diisi....'
        ]);
        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'category' => $validated['category'],
            'user_id' => auth()->id(),

        ]);
        // dd($project);
        return redirect()->route('project-user')->with('success', '🎉Data Berhasil Ditambahkan!');
    }

    public function destroy($id){
        $projects = Project::find($id);
        $projects -> delete();
        return redirect()->route('project-user')->with('success', '🎉Data Berhasil Dihapus!');
    }

    public function edit($id){
        $project = Project::findOrFail($id);
        return view('project-update', compact('project'));
    }

    public function update(Request $request, $id){
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Archived,Pending,Published',
            'category' => 'required|in:Desktop,Website,Mobile',
            'description' => 'required|string',
        ]);

        // Cari proyek berdasarkan ID
        $projects = Project::findOrFail($id);

        // Update data
        $projects->update($request->only(['name', 'status', 'category', 'description']));

        // Redirect dengan pesan sukses
        return redirect()->route('project-user')->with('success', '🎉Project berhasil diperbarui.');
    }

}
