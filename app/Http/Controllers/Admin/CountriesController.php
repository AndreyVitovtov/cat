<?php

namespace App\Http\Controllers\Admin;

use App\models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountriesController extends Controller {
    public function index() {
        return view('admin.countries.index', [
            'countries' => Country::paginate(25),
            'menuItem' => 'countrieslist'
        ]);
    }

    public function add() {
        return view('admin.countries.add', [
            'menuItem' => 'countriesadd'
        ]);
    }

    public function addSave(Request $request) {
        $data = $request->post();
        $country = new Country();
        $country->name = $data['name'];
        $country->save();

        if(isset($data['more'])) {
            return redirect()->to(route('countries-add'));
        }
        else {
            return redirect()->to(route('countries'));
        }
    }

    public function delete(Request $request) {
        Country::where('id', $request->post('id'))->delete();
        return redirect()->to(route('countries'));
    }

    public function edit(Request $request) {
        return view('admin.countries.edit', [
            'menuItem' => 'countrieslist',
            'country' => Country::find($request->post('id'))
        ]);
    }

    public function editSave(Request $request) {
        $country = Country::find($request->post('id'));
        $country->name = $request->post('name');
        $country->save();
        return redirect()->to(route('countries'));
    }
}
