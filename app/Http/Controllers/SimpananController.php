<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SimpananController extends Controller
{

    public function index(Request $request)
    {
        $data = Simpanan::get();
        if ($request->ajax()) {
            $dataTable = DataTables::of($data)->addIndexColumn();
            $dataTable->addColumn('action', function ($row) {
                $btn = '';
                $btn = '<div class="d-flex">
                        <a href="' . route('simpanan.edit', [$row->id]) . '" title="Edit" class="btn btn-primary btn btn-dark">
                            Edit
                        </a>
                        <button type="submit" id="' . $row->id . '" title="Delete" class="delete btn btn-danger">
                            Hapus 
                        </button>
                    </div>';

                return $btn;
            });
            return $dataTable->rawColumns(['action', 'registrasi'])->make(true);
        }
        return view('admin.simpanan.index', compact('data'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Simpanan $simpanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Simpanan $simpanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Simpanan $simpanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Simpanan $simpanan)
    {
        //
    }
}
