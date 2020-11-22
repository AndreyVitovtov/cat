<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopListController extends Controller {
    public function top() {
        return view('admin.topList.top', [
            'menuItem' => 'toplisttop'
        ]);
    }

    public function countries() {
        return view('admin.topList.countries', [
            'menuItem' => 'toplistcountry'
        ]);
    }

    public function categories() {
        return view('admin.topList.categories', [
            'menuItem' => 'toplistcategory'
        ]);
    }
}
