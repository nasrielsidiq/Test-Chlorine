<?php

namespace App\Http\Controllers;

use App\Jobs\Notification;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function categories()
    {
        $data['categories'] = Category::get();
        $data['count'] = $data['categories']->count();
        return view('category-table', $data);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:categories'],
            'is_publish' => 'required'
        ]);
        if ($validator->fails()) {
            Session::flash('errors', 'Categories has already taken');
        } else {

            Category::create([
                'name' => $request->name,
                'is_publish' => $request->is_publish
            ]);

            $user = Auth::user();

            Notification::dispatch([
                'type' => 'category',
                'email' => $user->email,
                'title' => 'Create new categories',
                'name' => $request->name,
                'is_publish' => $request->is_publish ? "true" : "false",
                'message' => 'Create success'
            ]);
            Session::flash('message', 'Created Success');
        }

        return redirect('/categories');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:categories'],
            'is_publish' => 'required'
        ]);
        if ($validator->fails()) {
            Session::flash('errors', 'Categories has already taken');
        } else {

            Category::where('id', $id)->update([
                'name' => $request->name,
                'is_publish' => $request->is_publish
            ]);

            $user = Auth::user();

            Notification::dispatch([
                'type' => 'category',
                'email' => $user->email,
                'title' => 'Update categories',
                'name' => $request->name,
                'is_publish' => $request->is_publish ? "true" : "false",
                'message' => 'Update success'
            ]);

            Session::flash('message', 'Created Success');
        }

        return redirect('/categories');
    }
    public function delete($id)
    {
        $data = Category::where('id', $id)->first();

        $user = Auth::user();

        Notification::dispatch([
            'type' => 'category',
            'email' => $user->email,
            'title' => 'Delete categories',
            'name' => $data->name,
            'is_publish'=> $data->is_publish? "true": "false",
            'message' => 'Delete success'
        ]);

        if (!$data->delete()) {
            Session::flash('errors', 'Delete failed');
        }else{
            Session::flash('message', 'Delete success');
        }
        return redirect('/categories');
    }
}
