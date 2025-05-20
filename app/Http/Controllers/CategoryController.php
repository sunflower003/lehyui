<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
{
    $query = Category::query();

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $categories = $query->paginate(5)->appends($request->query());
    
    return view('admin_dashboard.categories.index', compact('categories'));
}

    public function create()
    {
        return view('admin_dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin_dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id
        ]);

        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name]);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xoá danh mục thành công.');
    }
    public function showAllCategories()
    {
        $categories = Category::withCount('posts')
                      ->orderBy('created_at', 'asc') // sắp xếp theo thứ tự cũ -> mới
                      ->get();

        $user = auth()->check() ? auth()->user() : null;

        return view('pages.allcategories', [
            'categories' => $categories,
            'user' => $user,
        ]);
    }

}
