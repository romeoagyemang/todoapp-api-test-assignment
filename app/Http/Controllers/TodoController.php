<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $todos = Todo::query();

        // Filtering by status
        if ($request->filled('status')) {
            $todos->where('status', $request->status);
        }

        // Sorting
        if ($request->filled('sort_by')) {
            $todos->orderBy($request->sort_by, $request->get('order', 'asc'));
        }

        // Pagination
        return response()->json($todos->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'nullable|string',
            'status' => 'nullable|in:not_started,in_progress,completed',
        ]);

        $todo = Todo::create($validated);
        return response()->json($todo, 201);
    }

    public function show(Todo $todo)
    {
        return response()->json($todo);
    }

    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'details' => 'nullable|string',
            'status' => 'nullable|in:not_started,in_progress,completed',
        ]);

        $todo->update($validated);
        return response()->json($todo);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(['message' => 'Todo deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = $request->get('query', '');

        $todos = Todo::where('title', 'like', "%{$query}%")
            ->orWhere('details', 'like', "%{$query}%")
            ->paginate(10);

        return response()->json($todos);
    }
}
