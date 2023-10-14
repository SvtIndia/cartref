<?php

namespace App\Actions\Showcases;

use App\Order;
use App\Showcase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Actions\AbstractAction;
use Illuminate\Support\Facades\Response;

class MarkAsShowcased extends AbstractAction
{
    public function getId()
    {
        return 'markasshowcased';
    }

    public function getConfirmationContent()
    {
        return 'Are you sure you want to mark as handovered';
    }

    public function getNoRowContent()
    {
        return "You haven't selected any order to mark as handovered";
    }

    public function getColor()
    {
        return 'success';
    }

    public function getTitle()
    {
        return 'Mark as Handover';
    }

    public function getIcon()
    {
        return 'voyager-home';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-warning',
        ];
    }

    public function getDefaultRoute()
    {
        return route('welcome');
    }

    public function shouldActionDisplayOnDataType()
    {
        if(auth()->user()->hasRole(['Delivery Boy']))
        {
            if(request('order_id'))
            {
                $showcase = Showcase::where('order_id', request('order_id'))->whereIn('order_status', ['Out For Showcase'])->count();

                if($showcase > 0)
                {
                    return $this->dataType->slug == 'showcases';
                }
            }
        }

    }


    public function massAction($ids, $comingFrom)
    {
        // Do something with the IDs

        /**
         * Check if the order is selected
         */

        if($ids[0] == 0)
        {
            return redirect($comingFrom)->with([
                'message' => "You haven't selected any order to mark as handovered",
                'alert-type' => 'warning',
            ]);
        }


        /**
         * move to under manufacturing
        */

        $this->markasshowcased($ids, $comingFrom);


        // return redirect($comingFrom);
        return redirect('/'.Config::get('icrm.admin_panel.prefix').'/showcases?label=Showcased');

    }


    private function markasshowcased($ids, $comingFrom)
    {
        $orders = Showcase::whereIn('id', $ids)
                        ->whereIn('order_status', ['Out For Showcase'])
                        ->get();

        /**
         * Check if order exists
         */
        if(count($orders) == 0)
        {
            return redirect($comingFrom)->with([
                'message' => "You can only mark out for showcase orders as handovered",
                'alert-type' => 'error',
            ]);
        }


        Showcase::whereIn('id', $ids)
                ->whereIn('order_status', ['Out For Showcase'])
                ->update([
                    'order_status' => 'Showcased',
                    'showcase_timer' => Carbon::now()->addMinutes($orders->count() * 5)
                ]);

        return redirect($comingFrom)->with([
            'message' => "Selected orders successfully marked as handovered",
            'alert-type' => 'success',
        ]);

    }



}
