<?php

namespace App\Services;

class MidtransService {

    protected $midtransProd, $serverKey;

    public function __construct()
    {
        $this->midtransProd = env("APP_ENV") != "production" ? false : true;
        $this->serverKey    = env("MIDTRANS_SERVER_KEY", "SB-Mid-server-jV2c34fnF4FyjVP-9uvDhK5R");
    }

    public function getSnapToken($invoiceNo, $amount) {
        \Veritrans_Config::$serverKey = $this->serverKey;
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Veritrans_Config::$isProduction = $this->midtransProd;

        // Set sanitization on (default)
        \Veritrans_Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Veritrans_Config::$is3ds = true;

        $snap_token = \Veritrans_Snap::getSnapToken([
            "transaction_details" => [
                "order_id"      => $invoiceNo,
                "gross_amount"  => (int) $amount + 4400 // amount + fee midtrans
            ],
            [
                "id"            => "Bill-" . $invoiceNo,
                "price"         => (int)$amount,
                "quantity"      => 1,
                "name"          => "Bill Invoice Pembayaran " . $invoiceNo,
                "category"      => "Invoice",
                "merchant_name" => "Oke Shop"
            ],
            [
                "id"            => "TRX-" . $invoiceNo,
                "price"         => 4400,
                "quantity"      => 1,
                "name"          => "Biaya per Transaksi Pembayaran",
                "category"      => "Invoice",
                "merchant_name" => "Midtrans.com"
            ],
            "enabled_payments"   => ["bca_va", "bni_va", "other_va"]
            // "enabled_payments"   => ["bca_va", "bni_va", "other_va", "echannel", "gci", "credit_card", "gopay"]

        ]);

        return $snap_token;
    }

    public function notification($request = null) {
        \Veritrans_Config::$isProduction    = $this->midtransProd;
        \Veritrans_Config::$serverKey       = $this->serverKey;

        try {
            $notif = \Veritrans_Transaction::status($request->get("order_id"));
        } catch (\Exception $e) {
            return [
                'status'    => false,
                'orderId'   => null,
                'type'      => '',
                'message'   => 'Something error',
                'status_server' => '',
                'payment_type'  => '',
                'va_bank'       => '',
                'dump'      => json_encode([])
            ];
        }
        $transaction    = $notif->transaction_status;
        $type           = $notif->payment_type;
        $order_id       = $notif->order_id;
        $fraud          = $notif->fraud_status;
        $status         = 'failed'; // default
        $paymentType    = !empty($request->payment_type) ? $request->payment_type : '';
        $vaBank         = ($paymentType == 'bank_transfer' AND !empty($request->va_numbers) AND !empty($request->va_numbers[0]->bank)) ? $request->va_numbers[0]->bank : '';
        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    // echo "Transaction order_id: " . $order_id ." is challenged by FDS";
                    $status = 'success';
                    return [
                        'status'    => true,
                        'orderId'   => $order_id,
                        'type'      => $type,
                        'message'   => '',
                        'status_server' => $status,
                        'payment_type'  => $paymentType,
                        'va_bank'       => $vaBank,
                        'dump'      => json_encode($notif)
                    ];
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    // echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
                    $status = 'success';
                    return [
                        'status'    => true,
                        'orderId'   => $order_id,
                        'type'      => $type,
                        'message'   => '',
                        'status_server' => $status,
                        'payment_type'  => $paymentType,
                        'va_bank'       => $vaBank,
                        'dump'      => json_encode($notif)
                    ];
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            //echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
            $status = 'success';
            return [
                'status'    => true,
                'orderId'   => $order_id,
                'type'      => $type,
                'message'   => '',
                'status_server' => $status,
                'payment_type'  => $paymentType,
                'va_bank'       => $vaBank,
                'dump'      => json_encode($notif)
            ];
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            // echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
            $status = 'pending';
            return [
                'status'    => false,
                'orderId'   => $order_id,
                'type'      => $type,
                'message'   => '',
                'status_server' => $status,
                'payment_type'  => $paymentType,
                'va_bank'       => $vaBank,
                'dump'      => json_encode($notif)
            ];
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            //echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
            $status = 'deny';
            return [
                'status'    => false,
                'orderId'   => $order_id,
                'type'      => $type,
                'message'   => '',
                'status_server' => $status,
                'payment_type'  => $paymentType,
                'va_bank'       => $vaBank,
                'dump'      => json_encode($notif)
            ];
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
            $status = 'expire';
            return [
                'status'    => false,
                'orderId'   => $order_id,
                'type'      => $type,
                'message'   => '',
                'status_server' => $status,
                'payment_type'  => $paymentType,
                'va_bank'       => $vaBank,
                'dump'      => json_encode($notif)
            ];
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
            $status = 'cancel';
            return [
                'status'    => false,
                'orderId'   => $order_id,
                'type'      => $type,
                'message'   => '',
                'status_server' => $status,
                'payment_type'  => $paymentType,
                'va_bank'       => $vaBank,
                'dump'      => json_encode($notif)
            ];
        }

        return [
            'status'    => false,
            'orderId'   => $order_id,
            'type'      => $type,
            'message'   => 'Not Found',
            'status_server' => $status,
            'payment_type'  => $paymentType,
            'va_bank'       => $vaBank,
            'dump'      => json_encode($notif)
        ];

    }
}
