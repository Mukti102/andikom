<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tools = Tool::all();
        return view('pages.admin.tools.index', compact('tools'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Tool::create($request->all());
        return back()->with('success', 'Software berhasil ditambah');
    }

    public function update(Request $request, Tool $tool)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $tool->update($request->all());
        return back()->with('success', 'Software berhasil diupdate');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();
        return back()->with('success', 'Software berhasil dihapus');
    }
}
