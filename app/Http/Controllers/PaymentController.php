<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $item_id = $request->input('item_id'); // Lấy item_id từ request
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('detailspage', ['id' => $item_id]);

        $vnp_TmnCode = "K9B5TH7O"; //Mã website tại VNPAY
        $vnp_HashSecret = "5LBSAZYRJ2V5KWGB2064VBXDYAQENX46"; //Chuỗi bí mật
        //$vnp_TxnRef = $request->input('auction_id');
        $vnp_TxnRef = rand(00, 9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Auction Payment";
        $vnp_OrderType = "Bill Payment";

        $item_price = $request->input('starting_price');
        $amount = $request->input('item_bid');
        // Điều kiện tính phần trăm dựa trên giá trị của item_price
        if ($item_price < 500) {
            $amount = $item_price * 0.25; // 25% nếu dưới 500.000
        } elseif ($item_price <= 1000) {
            $amount = $item_price * 0.20; // 20% nếu từ 500.000 đến 1.000.000
        } else {
            $amount = $item_price * 0.15; // 15% nếu trên 1.000.000
        }

        // Chuyển đổi sang VND (VNPAY yêu cầu số tiền phải là đơn vị nhỏ nhất)
        $vnp_Amount = $amount * 100;
        $vnp_Locale = "VN";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,

        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            // Thay vì trả về JSON, chuyển hướng đến VNPay
            return redirect()->away($vnp_Url);
        }
    }

    public function processPayment(Request $request)
    {
        // Lấy tất cả dữ liệu gửi từ form
        $item_id = $request->input('item_id');
        $item_title = $request->input('item_title');
        $item_image = $request->input('item_image');
        $item_description = $request->input('item_description');
        $category_name = $request->input('category_name');
        $starting_price = $request->input('starting_price');
        $end_price = $request->input('end_price');
        $step = $request->input('step');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $auction_status = $request->input('auction_status');

        // Bạn có thể thêm logic thanh toán tại đây
        // Ví dụ: Chuyển dữ liệu sang trang thanh toán hoặc xử lý với VNPAY

        // Trả về trang xác nhận hoặc kết quả thanh toán
        return view('pages.paymentpage', compact(
            'item_image', 'item_id', 'item_title', 'item_description', 'category_name', 'starting_price',
            'end_price', 'step', 'start_date', 'end_date', 'auction_status'
        ));
    }

    public function paymentCallback(Request $request, $item_id)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TransactionStatus = $request->input('vnp_TransactionStatus');

        if ($vnp_ResponseCode == '00' && $vnp_TransactionStatus == '00') {
            // Giao dịch thành công, đính kèm trạng thái vào URL
            return redirect()->route('detailspage', ['id' => $item_id, 'status' => 'success']);
        } else {
            // Giao dịch thất bại, đính kèm trạng thái vào URL
            return redirect()->route('detailspage', ['id' => $item_id, 'status' => 'fail']);
        }
    }

}
