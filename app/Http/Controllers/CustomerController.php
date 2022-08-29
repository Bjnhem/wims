<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends Controller
{
  public function index()
  {
    $this->authorize('viewAll', Customer::class);

    return Inertia::render('Master/Customers/Index', [
      'customers' => Customer::all()
    ]);
  }

  public function create()
  {
    $this->authorize('create', Customer::class);

    return Inertia::render('Master/Customers/Create');
  }

  public function store(Request $request)
  {
    $this->authorize('create', Customer::class);

    $validated = $request->validate([
      'name' => 'required|unique:customers,name',
      'description' => 'nullable',
      'address' => 'required',
      'address2' => 'nullable',
      'city' => 'required',
      'postalCode' => 'string|required',
      'phone' => 'string|nullable',
    ]);
    Customer::create($validated);

    return Redirect::route('master.customers.index');
  }

  public function show($id)
  {
    $this->authorize('view', Customer::class);

    return Inertia::render('Master/Customers/Create', [
      "customer" => Customer::where("id", $id)->first()
    ]);
  }

  public function update(Request $request, Customer $customer)
  {
    $this->authorize('update', Customer::class);

    $validated = $request->validate([
      'name' => 'required|unique:customers,name,' . $customer->id,
      'description' => 'nullable',
      'address' => 'required',
      'address2' => 'nullable',
      'city' => 'required',
      'postalCode' => 'string|required',
      'phone' => 'string|nullable',
    ]);

    $customer->update($validated);

    return Redirect::route('master.customers.index');
  }

  public function destroy($id)
  {
    $this->authorize('delete', Customer::class);

    $ids = explode(',', $id);
    Customer::whereIn('id', $ids)->delete();
    return Redirect::route('master.customers.index');
  }
}
