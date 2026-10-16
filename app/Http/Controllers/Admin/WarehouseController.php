<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Country;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $query = Warehouse::query();
        $countries = Country::all();
        if ($request->filled('loai_kho')) {
            $query->where('loai_kho', $request->loai_kho);
        }

        $warehouses = $query->orderBy('loai_kho')->paginate(15)->appends($request->all());

        return view('admin.warehouses.index', compact('warehouses', 'countries'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.warehouses.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'loai_kho'      => 'required|string|max:10',
            'ma_kho'        => 'required|string|max:50|unique:warehouses,ma_kho',
            'ten_kho'       => 'required|string|max:255',
            'dia_chi'       => 'required|string|max:255',
            'so_dien_thoai' => 'nullable|string|max:50',  
            'ma_buu_dien'   => 'nullable|string|max:20',  
            'ghi_chu'       => 'nullable|string',         
        ], [
            'ma_kho.unique' => 'Mã kho này đã tồn tại trên hệ thống.'
        ]);

        $prefix = $request->loai_kho . '-';
        if (!str_starts_with($request->ma_kho, $prefix)) {
            return back()->withErrors(['ma_kho' => 'Mã kho phải bắt đầu bằng ' . $prefix])->withInput();
        }

        Warehouse::create($data);
        return redirect()->route('admin.warehouses.index')->with('success', 'Đã thêm kho mới thành công!');
    }

    public function edit(Warehouse $warehouse)
    {
        $countries = Country::all();
        return view('admin.warehouses.edit', compact('warehouse','countries'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $data = $request->validate([
            'loai_kho'      => 'required|string|max:10',
            'ma_kho'        => 'required|string|max:50|unique:warehouses,ma_kho,' . $warehouse->id,
            'ten_kho'       => 'required|string|max:255',
            'dia_chi'       => 'required|string|max:255',
            'so_dien_thoai' => 'nullable|string|max:50',  
            'ma_buu_dien'   => 'nullable|string|max:20',  
            'ghi_chu'       => 'nullable|string',         
        ], [
            'ma_kho.unique' => 'Mã kho này đã tồn tại.'
        ]);

        $prefix = $request->loai_kho . '-';
        if (!str_starts_with($request->ma_kho, $prefix)) {
            return back()->withErrors(['ma_kho' => 'Mã kho phải bắt đầu bằng ' . $prefix])->withInput();
        }

        $warehouse->update($data);
        return redirect()->route('admin.warehouses.index')->with('success', 'Đã cập nhật kho thành công!');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('admin.warehouses.index')->with('success', 'Đã xóa kho khỏi hệ thống!');
    }
}