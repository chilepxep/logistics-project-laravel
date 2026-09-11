<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Country;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with(['country', 'contacts'])->orderByDesc('created_at')->paginate(15);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.suppliers.create', compact('countries'));
    }

    public function show($id)
    {
        $supplier = Supplier::with(['country', 'contacts'])->findOrFail($id);
        
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_ncc'     => 'required|unique:suppliers,ma_ncc|max:20',
            'ten_ncc'    => 'required|max:150',
            'country_id' => 'required|exists:countries,id',
            'hinh_thuc'  => 'required|in:online,offline',
            'contacts.*.loai'    => 'nullable|string',
            'contacts.*.gia_tri' => 'nullable|string',
        ]);

        // 1. Tạo Nhà cung cấp
        $supplier = Supplier::create($request->except('contacts'));

        // 2. Lưu danh bạ liên hệ (nếu có nhập)
        if ($request->has('contacts')) {
            foreach ($request->contacts as $contact) {
                if (!empty($contact['gia_tri'])) {
                    $supplier->contacts()->create($contact);
                }
            }
        }

        return redirect()->route('admin.suppliers.index')->with('success', 'Đã thêm Nhà cung cấp thành công!');
    }

    public function edit($id)
    {
        $supplier = Supplier::with('contacts')->findOrFail($id);
        $countries = Country::all();
        return view('admin.suppliers.edit', compact('supplier', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'ma_ncc'     => 'required|max:20|unique:suppliers,ma_ncc,' . $id,
            'ten_ncc'    => 'required|max:150',
            'country_id' => 'required|exists:countries,id',
            'hinh_thuc'  => 'required|in:online,offline',
        ]);

        // 1. Cập nhật thông tin chính
        $supplier->update($request->except('contacts'));

        // 2. Cập nhật Liên hệ
        $supplier->contacts()->delete();
        if ($request->has('contacts')) {
            foreach ($request->contacts as $contact) {
                if (!empty($contact['gia_tri'])) {
                    $supplier->contacts()->create($contact);
                }
            }
        }

        return redirect()->route('admin.suppliers.index')->with('success', 'Đã cập nhật Nhà cung cấp!');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa Nhà cung cấp!');
    }
}