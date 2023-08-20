<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categoreis = Category::all();

        return view('category.index', compact('categoreis'));


    }



    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate(Category::rules());

        $category = new Category();
        $category->name = $request->post('name');
        $category->slug = Str::slug($request->post('name'));
        $category->description = $request->post('description');

        $category->status = $request->post('status');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uplodes/Category', [
                'disk' => 'public'
            ]);
            $category->image = $path;
        }
        $category->save();
        return response()->json([
            'status' => 'success'
        ]);

    }
    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'min:3', 'max:255' . $request->up_id],
            'description' => ['required', 'string', 'min:5'],
            'status' => ['required', 'string', 'in:active,archived'],
            'image' => ['nullable']
        ]);

        $id = $request->id;
        $category = Category::find($id);

        $category->name = $request->input('name');
        $category->slug = Str::slug($category->name);
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $oldeImage = $category->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uplodes/Category/', [
                'disk' => 'public'
            ]);
            $category->image = $path;
            Storage::disk('public')->delete($oldeImage);
        }
        $category->save();
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->category_id);
        $category->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }


    public function search(Request $request)
    {
        $output = "";
        $search = $request->search;
        $categoreis = Category::where('name', 'LIKE', '%' . $search . '%')->get();
        foreach ($categoreis as $category) {
            $output .=
                '   <tr>
                        <td>' . $category->name . '</td>
                        <td>' . $category->description . '</td>
                        <td>' . $category->status . '</td>
                        <td><img  width="30" alt="testImage"></td>
                          <td>' 
                          .'<a href="" id="updateBtn" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                              data-bs-target="#updateeModal" data-id='.$category->id.' "
                              data-name='.$category->name .' data-description='.$category->description.'
                              data-status='.$category->status.'">Edit</a>
                           <a href="#" class="btn btn-danger btn-sm" id="deleteId"
                            data-id='.$category->id .'><i class="fas fa-trash"></i>
                         ' . '  </td>
                 </tr>
            ';
        }
        return response($output);
    }
}

// <td>
// <a href="" id="updateBtn" class="btn btn-sm btn-primary" data-bs-toggle="modal"
//     data-bs-target="#updateeModal" data-id="{{ $category->id }}"
//     data-name="{{ $category->name }}" data-description="{{ $category->description }}"
//     data-status="{{ $category->status }}">Edit</a>
// <a href="#" class="btn btn-danger btn-sm" id="deleteId"
//     data-id="{{ $category->id }}"><i class="fas fa-trash"></i>
// </a>
// </td>