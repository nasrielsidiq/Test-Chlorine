<?php

namespace App\Http\Controllers;

use App\Jobs\Notification;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryApiController extends Controller
{


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:categories'],
            'is_publish' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'Invalid',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::guard('api')->user();


        $category = new Category();
        $category->name = $request->name;
        $category->is_publish = $request->is_publish;
        $category->save();
        Notification::dispatch([
            'type' => 'category',
            'email' => $user->email,
            'title' => 'Created New categories',
            'name' => $request->name,
            'is_publish'=> $request->is_publish? "true": "false",
            'message' => 'Created success'
        ]);

        return response()->json([
            'status' => 'Success',
            'category' => $category
        ], 200);

    }

    public function get(Request $request)
    {
        if ($request->search) {
            $data['category'] = Category::where('name', 'LIKE', '%' . $request->search . '%')->get();
        } else {
            $data['category'] = Category::get();
        }
        $data['count'] = $data['category']->count();
        return response()->json([
            'status' => 'Success',
            'lenght' => $data['count'],
            'categories' => $data['category']
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:categories'],
            'is_publish' => ['required', 'boolean']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Invalid',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::guard('api')->user();

        Notification::dispatch([
            'type' => 'category',
            'email' => $user->email,
            'title' => 'Update categories',
            'name' => $request->name,
            'is_publish'=> $request->is_publish? "true": "false",
            'message' => 'Update success'
        ]);



        $category = Category::where('id', $id)->update([
            'name' => $request->name,
            'is_publish' => $request->is_publish,
        ]);
        // if ($category) {
            return response()->json([
                'status' => 'Success',
                'category' => $category
            ], 200);
        // }
    }

    public function delete($id)
    {
        $category = Category::where('id', $id)->first();
        $user = Auth::guard('api')->user();
        Notification::dispatch([
            'type' => 'category',
            'email' => $user->email,
            'title' => 'Update categories',
            'name' => $category->name,
            'is_publish'=> $category->is_publish? "true": "false",
            'message' => 'Update success'
        ]);

        $category->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Category deleted'
        ], 200);
    }
}
