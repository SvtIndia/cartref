<?php

namespace App\Actions;

use App\Order;
use TCG\Voyager\Actions\AbstractAction;

class DownloadLabel extends AbstractAction
{
    public function getTitle()
    {
        return 'Shipping Label';
    }

    public function getIcon()
    {
        return 'voyager-file-text';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        // return route('downloadlabel');
        return route('downloadlabel', array("id"=>$this->data->{$this->data->getKeyName()}));
    }


    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'orders';
    }

    public function shouldActionDisplayOnRow($row)
    {
        return $row->shipping_label != null;
    }


}