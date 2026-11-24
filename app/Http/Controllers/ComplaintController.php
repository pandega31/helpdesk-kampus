<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $complaints = Ticket::select(['id', 'user_id', 'category_id', 'judul', 'status', 'created_at'])
            ->with('category:id,nama')
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('nama')->get();

        return view('complaints.index', compact('complaints', 'categories'));
    }
}