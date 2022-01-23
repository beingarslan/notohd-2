<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;

class CategoryController extends Controller
{
    public function manage(Request $request)
    {
        // categoris not having any parent
        $categories = Category::whereNull('parent_id')->get();
        return view('categories.manage', compact('categories'));
    }

    public function categories(Request $request)
    {

        $totalData = Category::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = 'id';
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $categories = Category::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $categories =  Category::where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->leftJoin('categories', 'parent_id', 'categories.id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->with(['parent', 'child'])
                ->get();

            $totalFiltered = Category::where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $show =  ('edituser/' . $category->id);
                $edit =  ('edituser/' . $category->id);

                $nestedData['id'] = $category->id;
                $nestedData['title'] = $category->title;
                $nestedData['slug'] = Str::slug($category->title);
                $nestedData['status'] = $category->status;
                $nestedData['parent'] = $category->parent ? $category->parent->title : '-';
                $nestedData['child'] = count($category->child) > 0 ? count($category->child) : 0;
                $nestedData['action'] = '<a href="/admin/categories/edit/' . $category->id . '" class="btn btn-sm btn-primary">Edit</a>';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    // save category info
    public function save(Request $request){
        $validated = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($validated->fails()) {
            foreach ($validated->errors()->all() as $error) {
                Toastr::error($error, 'Error');
            }
            return redirect()->back()->withInput();
        }

        try {
            $category = new Category();
            $category->title = $request->title;
            $category->description = $request->description;
            $category->status = $request->status;
            $category->parent_id = $request->parent_id;
            $category->save();

            Toastr::success('Category added successfully', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            Toastr::error('Something went wrong!', 'Error');
            return redirect()->back()->withInput();
        }
    }
}
