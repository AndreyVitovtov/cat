<?php

namespace App\Http\Controllers\Admin;

use App\models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller {
    public function index() {
        return view('admin.categories.index', [
            'menuItem' => 'categorieslist',
            'categories' => Category::paginate(25)
        ]);
    }

    public function add() {
        return view('admin.categories.add', [
            'menuItem' => 'categoriesadd'
        ]);
    }

    public function addSave(Request $request) {
        $data = $request->post();
        $category = new Category();
        $category->name = $data['name'];
        $category->save();

        if(isset($data['more'])) {
            return redirect()->to(route('categories-add'));
        }
        else {
            return redirect()->to(route('categories'));
        }
    }

    public function delete(Request $request) {
        Category::where('id', $request->post('id'))->delete();
        return redirect()->to(route('categories'));
    }

    public function edit(Request $request) {
        return view('admin.categories.edit', [
            'category' => Category::find($request->post('id')),
            'menuItem' => 'categorieslist'
        ]);
    }

    public function editSave(Request $request) {
        $category = Category::find($request->post('id'));
        $category->name = $request->post('name');
        $category->save();
        return redirect()->to(route('categories'));
    }
}
