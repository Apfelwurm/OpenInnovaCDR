<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganisationUnit;

class OrganisationUnitsController extends Controller
{
    public function index()
    {
        return OrganisationUnit::all();
    }

    public function show(OrganisationUnit $organisationUnit)
    {
        return $organisationUnit;
    }

    public function store(Request $request)
    {
        $organisationUnit = OrganisationUnit::create($request->all());

        return response()->json($organisationUnit, 201);
    }

    public function update(Request $request, OrganisationUnit $organisationUnit)
    {
        $organisationUnit->update($request->all());

        return response()->json($organisationUnit, 200);
    }

    public function delete(OrganisationUnit $organisationUnit)
    {
        $organisationUnit->delete();

        return response()->json(null, 204);
    }
}
