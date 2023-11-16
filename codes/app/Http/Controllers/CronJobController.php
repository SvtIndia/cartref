<?php

namespace App\Http\Controllers;

use App\Notifications\ShowcaseDelayAcceptanceToCustomer;
use App\Notifications\ShowcasePurchasedEmail;
use App\Showcase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Mockery\Exception;

class CronJobController extends Controller
{
    /*
     *  5 minutes
        Order Status => Delay Acceptance
    */
    public function showcaseOrderFiveMin()
    {
        $count = Showcase::where([
            'is_order_accepted' => 0,
            'order_status' => 'New Order'
        ])
            ->where('created_at', '<=', now()->subMinute(5))
            ->update([
                'order_status' => 'Delay Acceptance'
            ]);

        return response()->json(['success' => true, 'affectedRows' => $count]);
    }

    /*
     *  15 minutes
        Mail sent to customer + WhatsApp  Notify
    */
    public function showcaseOrderFifteenMin()
    {
        $showcases = Showcase::where([
            'is_order_accepted' => 0,
            'order_status' => 'Delay Acceptance'
        ])
            ->where('created_at', '<=', now()->subMinute(15))
            ->where('created_at', '>', now()->subMinute(30))
            ->get();

        try {
            $mailCount = 0;
            foreach ($showcases as $showcase) {
                if (isset($showcase->customer_email)) {
                    Notification::route('mail', $showcase->customer_email)->notify(new ShowcaseDelayAcceptanceToCustomer($showcase));
                    $mailCount++;
                }
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'msg' => 'Something went wrong!', 'err' => $e->getMessage()]);
        }

        return response()->json(['success' => true, 'total_orders' => $showcases->count(), 'total_mail_sent' => $mailCount]);
    }

    /*
     *  30 minutes
        Order Cancelled => Negative order
    */
    public function showcaseOrderThirtyMin()
    {
        $count = Showcase::where([
            'is_order_accepted' => 0,
            'order_status' => 'Delay Acceptance'
        ])
            ->where('created_at', '<=', now()->subMinute(30))
            ->update([
                'order_status' => 'Non Acceptance'
            ]);

        return response()->json(['success' => true, 'affectedRows' => $count]);
    }
}
