<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Pricing;
use App\Models\Settings;

class PricingControllers extends Controller
{
    public function __construct()
    {
        globalDashboardAssets();
    }

    public function index()
    {
        if (auth()->user()->role == 'user') {
            return redirect(route('home'));
        }

        addVendors(['datatables', 'pricing']);
        return view('dashboard.pricing-list', ['title' => 'Packages']);
    }


    public function PricingDetails(){
        addVendors(['pricing-details', 'checkout']);
        $arraySettings = Settings::latest()->first()->toArray();
        return view('dashboard.pricing-details', ['title' => 'Pricing' , 'ArPricing'=>  Pricing::latest()->get(), 'arraySettings'=> $arraySettings]);
    }


    public function PricingDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Pricing::latest()->get();
            return Datatables::of($data)->addIndexColumn()

                ->editColumn('price', function ($row) {
                    return '<span class="badge pt-2 bg-light-success">' . '$' . $row->price . '</span>';
                })

                ->addColumn('action', function ($row) {
                    $data = 'data-id="' . $row->id . '" data-name="' . $row->name . '" data-credit="' . $row->credit . '" data-price="' . $row->price . '" ';
                    return '<div class="btn-group btn-group-sm">
                                    <a href="JavaScript:void(0)" data-bs-toggle="modal" data-bs-target="#createEdit" ' . $data . ' class=" fw-normal p-1 px-2 bg-light-white border edit-button rounded">
                                    '.trans('site.curd-name.edit').' <i class="bi bi-pencil-square" ' . $data . '></i>
                                    </a>
                                    <button type="button" id="' . $row->id . '" class=" fw-normal bg-light-red border-0 data-delete p-1 px-2 ms-2 rounded">
                                    '.trans('site.curd-name.delete').' <i class="bi bi-trash-fill"></i>
                                    </button>
                            </div>';
                })

                ->rawColumns(['name', 'credit', 'price', 'action'])
                ->make(true);
        }
    }



    public function PricingCreateUpdate(Request $request)
    {
        $request = array_map('sanitizeInput', $request->all());
        $validator = Validator::make($request, [
            'name' => ['required', 'string'],
            'credit' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        $msg = $request['id'] == '' ? trans('site.msg.create') : trans('site.msg.update');

        Pricing::updateOrCreate(
            [
                'id'   => $request['id'] ?? '',
            ],
            [
                'name'     => $request['name'],
                'credit'     => $request['credit'],
                'price'     => $request['price'],
            ],
        );

        return response()->json(['status' => 200, 'msg' => $msg]);
    }


    public function Delete(Request $request)
    {
        Pricing::where('id', $request->id)->delete();
    }
}
