<?php

namespace App\Repository;

use App\Models\Order;
use App\Models\PaymentLog;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentRepository {
    public static function requestSnapToken($params) {
        try {
            $validator = \Validator::make($params , [
                "invoice"   => "required"
            ]);
            if($validator->fails()) {
                return responseCustom(collect($validator->messages()->first())->implode(","));
            }

            $findInvoice = Order::where([
                ["invoice_no" , $params["invoice"]],
                ["status_paid", "NOT PAID"]
            ])
                ->first();

            if(!$findInvoice) {
                return responseCustom("Invoice Not found, please register again");
            }

            $invoicePayment = $findInvoice->invoice_no . '-' . date("Ymdhis");
            $paymentLog = new PaymentLog();
            $paymentLog->order_id = $findInvoice->id;
            $paymentLog->payment_id = $invoicePayment;
            $paymentLog->total_amount = $findInvoice->total_amount;
            $paymentLog->save();

            return responseCustom("Token" , ["access_token" => (new MidtransService())->getSnapToken($paymentLog->order_id, $paymentLog->total_amount)], true);
        } catch (\Throwable $th) {
            return responseCustom($th->getMessage());
        }
    }

    public static function saveInfoPayment($invoiceNo) {
        try {
            $order = Order::where("invoice_no", $invoiceNo)
                ->first();

            if($order) {
                $order->dump_payment = json_encode(request()->all());
                $order->save();
            }

            return responseCustom("Success Save payment Info", [], true , 200);
        } catch (\Throwable $th) {
            return responseCustom($th->getMessage());
        }
    }

    public static function paymentCallback() {
        try {
            Log::info("Payment Callback", ["data" => json_encode(request()->all())]);
            $orderId = request()->get("order_id");

            $paymentLog = PaymentLog::where("payment_id" , $orderId)
                ->first();

            DB::beginTransaction();

            if(!$paymentLog) {
                Log::error("Payment not found", ["data" => json_encode(request()->all())]);
                DB::rollback();

                return responseCustom("payment not found");
            }

            if(!is_null($paymentLog->paid_at) && !is_null($paymentLog->order->paid_at)) {
                Log::error("invoice already paid", ["data" => json_encode(request()->all())]);
                DB::rollback();

                return responseCustom("invoice already paid", [], true, 200);
            }

            $checkNotification = (new MidtransService())->notification(request());
            if(!$checkNotification["status"]) {
                Log::error($checkNotification["message"], ["data"   => json_encode($checkNotification)]);
                return responseCustom($checkNotification);
            }

            if($checkNotification['status_server'] == 'success') {
                $paymentLog->status     = "PAID";
                $paymentLog->paid_at    = now();
                $paymentLog->save();

                $paymentLog->order->update([
                    "status_paid"   => "PAID",
                    "paid_at"       => now(),
                    "dump_payment"  => json_encode(request()->all())
                ]);
            }

            DB::commit();

            Log::error("Success update information", json_encode(["data" => json_encode(request()->all())]));
            return responseCustom("already Paid", [] ,true, 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ["data"    => json_encode(request()->all())]);
            return responseCustom($e->getMessage());
        }
    }
}
