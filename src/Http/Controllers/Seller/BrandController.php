<?php

namespace Dealskoo\Brand\Http\Controllers\Seller;

use Carbon\Carbon;
use Dealskoo\Brand\Models\Brand;
use Dealskoo\Seller\Http\Controllers\Controller as SellerController;
use Illuminate\Http\Request;

class BrandController extends SellerController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('brand::seller.brand.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'name', 'slug', 'website', 'score', 'country_id', 'approved', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Brand::where('seller_id', $request->user()->id);
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
            $query->orWhere('slug', 'like', '%' . $keyword . '%');
            $query->orWhere('website', 'like', '%' . $keyword . '%');
            $query->orWhere('description', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $brands = $query->skip($start)->take($limit)->get();
        $rows = [];
        foreach ($brands as $brand) {
            $row = [];
            $row[] = $brand->id;
            $row[] = '<img src="' . $brand->logo_url . '" alt="' . $brand->name . '" title="' . $brand->name . '" class="me-1"><p class="m-0 d-inline-block align-middle font-16">' . $brand->name . '</p>';
            $row[] = $brand->slug;
            $row[] = $brand->website;
            $row[] = $brand->score;
            $row[] = $brand->country->name;
            $row[] = $brand->approved;
            $row[] = Carbon::parse($brand->created_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($brand->updated_at)->format('Y-m-d H:i:s');

            $edit_link = '';
            if (!$brand->approved) {
                $edit_link = '<a href="' . route('seller.brands.edit', $brand) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $destroy_link = '';
            if (!$brand->approved) {
                $destroy_link = '<a href="javascript:void(0);" class="action-icon delete-btn" data-table="brands_table" data-url="' . route('seller.brands.destroy', $brand) . '"> <i class="mdi mdi-delete"></i></a>';
            }
            $row[] = $edit_link . $destroy_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function create(Request $request)
    {
        return view('brand::seller.brand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image'],
            'name' => ['required'],
            'website' => ['required'],
        ]);
        $brand = new Brand($request->only(['name', 'website', 'description']));
        $image = $request->file('logo');
        $seller = $request->user();
        $brand->seller_id = $seller->id;
        $brand->country_id = $seller->country->id;
        $brand->save();
        $filename = $brand->id . '.' . $image->guessExtension();
        $path = $image->storeAs('brands', $filename);
        $brand->logo = $path;
        $brand->save();
        return redirect(route('seller.brands.index'));
    }

    public function edit(Request $request, $id)
    {
        $brand = Brand::where('seller_id', $request->user()->id)->findOrFail($id);
        return view('brand::seller.brand.edit', ['brand' => $brand]);
    }

    public function update(Request $request, $id)
    {
        if ($request->has('logo')) {
            $request->validate([
                'logo' => ['required', 'image'],
                'name' => ['required'],
                'website' => ['required'],
            ]);
        } else {
            $request->validate([
                'name' => ['required'],
                'website' => ['required'],
            ]);
        }
        $brand = Brand::where('seller_id', $request->user()->id)->findOrFail($id);
        $brand->fill($request->only(['name', 'website', 'description']));
        if ($request->has('logo')) {
            $image = $request->file('logo');
            $filename = $brand->id . '.' . $image->guessExtension();
            $path = $image->storeAs('brands', $filename);
            $brand->logo = $path;
        }
        $brand->save();
        return redirect(route('seller.brands.index'));
    }

    public function destroy(Request $request, $id)
    {
        return ['status' => Brand::where('seller_id', $request->user()->id)->where('approved', false)->delete($id)];
    }
}
