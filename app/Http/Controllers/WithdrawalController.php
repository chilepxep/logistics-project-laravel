<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Lấy số dư hiện tại từ giao dịch mới nhất 
        $latestTransaction = Transaction::where('user_id', $userId)->orderBy('thoi_gian', 'desc')->first();
        $soDu = $latestTransaction ? $latestTransaction->so_du_hien_tai : 0;

        // Lấy lịch sử các lần yêu cầu rút tiền
        $withdrawals = Withdrawal::where('user_id', $userId)
                                 ->orderBy('ngay_yeu_cau', 'desc')
                                 ->get();

        return view('user.withdrawal', compact('soDu', 'withdrawals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'so_tien' => 'required|numeric|min:50000', 
            'ngan_hang' => 'required|string|max:100',
            'thong_tin_chuyen_khoan' => 'required|string|max:255',
        ], [
            'so_tien.min' => 'Số tiền rút tối thiểu là 50.000 VNĐ.'
        ]);

        $userId = Auth::id();
        $latestTransaction = Transaction::where('user_id', $userId)->orderBy('thoi_gian', 'desc')->first();
        $soDu = $latestTransaction ? $latestTransaction->so_du_hien_tai : 0;

        // Kiểm tra xem số dư có đủ để rút không
        if ($request->so_tien > $soDu) {
            return back()->withErrors('Số dư của bạn không đủ để thực hiện yêu cầu này.')->withInput();
        }

        try {
            Withdrawal::create([
                'user_id' => $userId,
                'so_tien' => $request->so_tien,
                'ngan_hang' => $request->ngan_hang,
                'thong_tin_chuyen_khoan' => $request->thong_tin_chuyen_khoan,
                'ngay_yeu_cau' => now(),
                'tinh_trang' => 'cho_duyet' 
            ]);
            return redirect()->back()->with('success', 'Gửi yêu cầu rút tiền thành công! Vui lòng chờ kế toán xử lý.');
        } catch (\Exception $e) {
            return back()->withErrors('Lỗi hệ thống: ' . $e->getMessage())->withInput();
        }
    }
}