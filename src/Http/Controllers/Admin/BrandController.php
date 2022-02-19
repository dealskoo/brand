<?php

namespace Dealskoo\Brand\Http\Controllers\Admin;

use Carbon\Carbon;
use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Dealskoo\Brand\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends AdminController
{
    public function index(Request $request)
    {
        abort_if(!$request->user()->canDo('brands.index'), 403);
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('brand::admin.brand.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'name', 'slug', 'website', 'score', 'country_id', 'seller_id', 'approved', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Brand::query();
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
        $can_view = $request->user()->canDo('brands.show');
        $can_edit = $request->user()->canDo('brands.edit');
        $can_destroy = $request->user()->canDo('brands.destroy');
        foreach ($brands as $brand) {
            $row = [];
            $row[] = $brand->id;
            $row[] = '<img src="' . $brand->logo_url . '" alt="' . $brand->name . '" title="' . $brand->name . '" class="me-1"><p class="m-0 d-inline-block align-middle font-16">' . $brand->name . '</p>';
            $row[] = $brand->slug;
            $row[] = $brand->website;
            $row[] = $brand->score;
            $row[] = $brand->country->name;
            $row[] = '<a href="' . route('admin.sellers.show', $brand->seller) . '">' . $brand->seller->name . '</a>';
            $row[] = $brand->approved;
            $row[] = Carbon::parse($brand->created_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($brand->updated_at)->format('Y-m-d H:i:s');
            $view_link = '';
            if ($can_view) {
                $view_link = '<a href="' . route('admin.brands.show', $brand) . '" class="action-icon"><i class="mdi mdi-eye"></i></a>';
            }

            $edit_link = '';
            if ($can_edit) {
                $edit_link = '<a href="' . route('admin.brands.edit', $brand) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $destroy_link = '';
            if ($can_destroy) {
                $destroy_link = '<a href="javascript:void(0);" class="action-icon delete-btn" data-table="brands_table" data-url="' . route('admin.brands.destroy', $brand) . '"> <i class="mdi mdi-delete"></i></a>';
            }
            $row[] = $view_link . $edit_link . $destroy_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function show(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('brands.show'), 403);
        $brand = Brand::query()->findOrFail($id);
        return view('brand::admin.brand.show', ['brand' => $brand]);
    }

    public function edit(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('brands.edit'), 403);
        $brand = Brand::query()->findOrFail($id);
        return view('brand::admin.brand.show', ['brand' => $brand]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('brands.edit'), 403);
        $request->validate([
            'approved' => ['required', 'boolean'],
        ]);
        $brand = Brand::query()->findOrFail($id);
        $brand->fill($request->only([
            'approved',
        ]));
        $brand->save();
        return back()->with('success', __('admin::admin.update_success'));
    }

    public function destroy(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('brands.destroy'), 403);
        return ['status' => Brand::destroy($id)];
    }
}
