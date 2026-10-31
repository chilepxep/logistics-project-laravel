<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\DB;

class LocationCurrencyController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('id', 'desc')->get();
        $rates = ExchangeRate::orderBy('is_default', 'desc')->orderBy('id', 'desc')->get();

        return view('admin.location_currency.index', compact('countries', 'rates'));
    }

    // ================= XỬ LÝ QUỐC GIA =================
    public function storeCountry(Request $request)
    {
        $request->validate(['ten_quoc_gia' => 'required', 'ma_quoc_gia' => 'required', 'tien_te' => 'required']);
        Country::create($request->all());
        return back()->with('success', 'Thêm quốc gia thành công!')->with('active_tab', 'country');
    }

    public function updateCountry(Request $request, $id)
    {
        $request->validate(['ten_quoc_gia' => 'required', 'ma_quoc_gia' => 'required', 'tien_te' => 'required']);
        Country::findOrFail($id)->update($request->all());
        return back()->with('success', 'Cập nhật quốc gia thành công!')->with('active_tab', 'country');
    }

   public function destroyCountry($id)
    {
        $country = Country::findOrFail($id);
        
        // 1. Kiểm tra ràng buộc với Nhà cung cấp
        if ($country->suppliers()->count() > 0) {
            return back()->withErrors('Không thể xoá vì quốc gia này đang có Nhà cung cấp!')->with('active_tab', 'country');
        }

        // 2. Kiểm tra ràng buộc với Đơn Mua Hộ
        if ($country->orders()->count() > 0) {
            return back()->withErrors('Không thể xoá vì quốc gia này đang phát sinh Đơn Mua Hộ!')->with('active_tab', 'country');
        }

        // 3. Kiểm tra ràng buộc với Đơn Ký Gửi
        if ($country->consignmentOrders()->count() > 0) {
            return back()->withErrors('Không thể xoá vì quốc gia này đang phát sinh Đơn Ký Gửi!')->with('active_tab', 'country');
        }

        $country->delete();
        return back()->with('success', 'Đã xoá quốc gia thành công!')->with('active_tab', 'country');
    }

    // ================= XỬ LÝ TIỀN TỆ =================
    public function storeRate(Request $request)
    {
        $request->validate(['currency_code' => 'required|unique:exchange_rates', 'rate' => 'required|numeric']);
        $this->handleDefaultRate($request);
        ExchangeRate::create($request->all());
        return back()->with('success', 'Thêm loại tiền tệ thành công!')->with('active_tab', 'rate');
    }

    public function updateRate(Request $request, $id)
    {
        $request->validate(['currency_code' => 'required|unique:exchange_rates,currency_code,'.$id, 'rate' => 'required|numeric']);
        $this->handleDefaultRate($request);
        ExchangeRate::findOrFail($id)->update($request->all());
        return back()->with('success', 'Cập nhật tiền tệ thành công!')->with('active_tab', 'rate');
    }

    public function destroyRate($id)
    {
        ExchangeRate::findOrFail($id)->delete();
        return back()->with('success', 'Đã xoá tiền tệ!')->with('active_tab', 'rate');
    }

    // Hàm phụ trợ xử lý Logic Đặt Mặc Định
    private function handleDefaultRate(Request $request)
    {
        if ($request->has('is_default') && $request->is_default == 1) {
            // Đưa tất cả các tỷ giá khác về 0 trước khi lưu mới/sửa
            ExchangeRate::query()->update(['is_default' => 0]);
        } else {
            $request->merge(['is_default' => 0]);
        }
    }
}