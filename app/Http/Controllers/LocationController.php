<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LocationController extends Controller
{
  public function index()
  {
    $this->authorize('viewAll', Location::class);

    return Inertia::render('Master/Locations/Index', [
      'locations' => Location::with('warehouse:id,name')->get()
    ]);
  }

  public function create()
  {
    $this->authorize('create', Location::class);
    return Inertia::render('Master/Locations/Create');
  }

  public function store(Request $request)
  {
    $this->authorize('create', Location::class);

    $validated = $request->validate([
      'name' => 'required|unique:locations,name',
      'type' => 'required',
      'warehouse' => 'required|exists:warehouses,name',
      'section' => 'required',
    ]);

    $warehouse = Warehouse::where('name', $request->warehouse)->first();
    $location = new Location($validated);
    $location->warehouse()->associate($warehouse);
    $location->save();

    return Redirect::route('master.locations.index');
  }

  public function show($id)
  {
    $this->authorize('view', Location::class);

    return Inertia::render('Master/Locations/Create', [
      "location" => Location::with('warehouse:id,name')->where("id", $id)->first()
    ]);
  }

  public function update(Request $request, Location $location)
  {
    $this->authorize('update', Location::class);

    $validated = $request->validate([
      'name' => 'required|unique:locations,name,' . $location->id,
      'type' => 'required',
      'warehouse' => 'required|exists:warehouses,name',
      'section' => 'required',
    ]);
    $warehouse = Warehouse::where('name', $request->warehouse)->first();
    $location->warehouse()->associate($warehouse);
    $location->update($validated);

    return Redirect::route('master.locations.index');
  }

  public function destroy($id)
  {
    $this->authorize('delete', Location::class);

    $ids = explode(',', $id);
    Location::whereIn('id', $ids)->delete();
    return Redirect::route('master.locations.index');
  }
}
