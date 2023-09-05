<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>{{ $invoice->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="{{ config('app.url') }}/vendor/invoices/new_bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <style type="text/css">
        body {
            margin: 0;
            font-family: Roboto, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: .8125rem;
            font-weight: 400;
            line-height: 1.5385;
            color: #333;
            text-align: left;
            background-color: #eee;
        }

        .mt-50 {

            margin-top: 50px;
        }

        .mb-50 {

            margin-bottom: 50px;
        }



        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: .1875rem;
        }

        .card-img-actions {
            position: relative;
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
            text-align: center;
        }

        .card-title {
            margin-top: 10px;
            font-size: 17px;
        }


        .invoice-color {
            color: red !important;
        }

        .card-header {
            padding: .9375rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, .02);
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        a {

            text-decoration: none !important;
        }


        .btn-light {
            color: #333;
            background-color: #fafafa;
            border-color: #ddd;
        }

        .header-elements-inline {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap;
        }

        @media (min-width: 768px) {
            .wmin-md-400 {
                min-width: 400px !important;
            }
        }


        .btn-primary {
            color: #fff;
            background-color: #2196f3;
        }

        .btn-labeled>b {
            position: absolute;
            top: -1px;
            background-color: blue;
            display: block;
            line-height: 1;
            padding: .62503rem;
        }

        @page {
            margin: 0.3cm 0.2cm;
            size: A4;
            padding: 10px;
        }

        @media print {
            .noprint {
                display: none!important;
                visibility: hidden;
           }
        }
    </style>

</head>

<body class="snippet-body">
    <div class="container d-flex justify-content-center mt-50 mb-50">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-transparent header-elements-inline">
                        @if ($invoice->logo)
                            <img src="{{ $invoice->getLogo() }}" alt="logo" height="60">
                        @endif
                        <h6 class="card-title">
                            @if (\Request::route()->getName() == 'downloadtaxinvoice')
                                Tax Invoice
                            @else
                                <strong>{{ $invoice->name }}</strong>
                            @endif
                        </h6>
                        <div class="header-elements noprint">
                            {{-- <button type="button" class="btn btn-light btn-sm"><i class="fa fa-file mr-2"></i>
                                Save</button> --}}
                            <button type="button" onclick="window.print()" class="btn btn-light btn-sm ml-3 noprint"><i
                                    class="fa fa-print mr-2"></i>
                                Print</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-4 pull-left">
                                    @if ($invoice->seller->name)
                                        <h6>{{ $invoice->seller->name }}</h6>
                                    @endif
                                    <ul class="list list-unstyled mb-0 text-left">
                                        @if ($invoice->seller->address)
                                            <li>{{ __('invoices::invoice.address') }}: {{ $invoice->seller->address }}
                                            </li>
                                        @endif
                                        @if ($invoice->seller->code)
                                            <li>{{ __('invoices::invoice.code') }}: {{ $invoice->seller->code }}</li>
                                        @endif
                                        @if ($invoice->seller->vat)
                                            <li>{{ __('invoices::invoice.vat') }}: {{ $invoice->seller->vat }}</li>
                                        @endif
                                        @if ($invoice->seller->phone)
                                            <li>{{ __('invoices::invoice.phone') }}: {{ $invoice->seller->phone }}
                                            </li>
                                        @endif
                                        @foreach ($invoice->seller->custom_fields as $key => $value)
                                            <li>{{ ucfirst($key) }}: {{ $value }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-4 ">
                                    <div class="text-sm-right">
                                        <h4 class="invoice-color mb-2 mt-md-2">Invoice
                                            #{{ $invoice->buyer->custom_fields['Invoice Number'] }}</h4>
                                        <ul class="list list-unstyled mb-0">
                                            <li>Date: <span
                                                    class="font-weight-semibold">{{ $invoice->getDate() }}</span></li>
                                            {{-- <li>Due date: <span class="font-weight-semibold">March 30, 2020</span></li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-md-flex flex-md-wrap">
                            <div class="mb-4 mb-md-2 text-left">
                                <span class="text-muted">Invoice To:</span>
                                <ul class="list list-unstyled mb-0">
                                    @if ($invoice->buyer->name)
                                        <li>
                                            <h5 class="my-2">{{ $invoice->buyer->name }}</h5>
                                        </li>
                                    @endif
                                    @if ($invoice->buyer->billing_address)
                                        <li><span
                                                class="font-weight-semibold">{{ $invoice->buyer->billing_address }}</span>
                                        </li>
                                    @endif
                                    @if ($invoice->buyer->shipping_address)
                                        <li>{{ $invoice->buyer->shipping_address }}</li>
                                    @endif
                                    @if ($invoice->buyer->code)
                                        <li>{{ __('invoices::invoice.code') }}: {{ $invoice->buyer->code }}</li>
                                    @endif
                                    @if ($invoice->buyer->vat)
                                        <li>{{ __('invoices::invoice.vat') }}: {{ $invoice->buyer->vat }}</li>
                                    @endif
                                    @if ($invoice->buyer->phone)
                                        <li>{{ __('invoices::invoice.phone') }}: {{ $invoice->buyer->phone }}</li>
                                    @endif

                                    @foreach ($invoice->buyer->custom_fields as $key => $value)
                                        @if (!empty($value))
                                            <li>
                                                {{ ucfirst($key) }}: {{ $value }}
                                            </li>
                                        @endif
                                    @endforeach
                                    {{-- <li><a href="#" data-abc="true">tibco@samantha.com</a></li> --}}
                                </ul>
                            </div>

                            <div class="mb-2 ml-auto">
                                <span class="text-muted">Payment Details:</span>
                                <div class="d-flex flex-wrap wmin-md-400">
                                    <ul class="list list-unstyled mb-0 text-left">
                                        <li>
                                            <h5 class="my-2">Total Due:</h5>
                                        </li>
                                        {{-- <li>Bank name:</li>
                                        <li>Country:</li>
                                        <li>City:</li>
                                        <li>Address:</li>
                                        <li>IBAN:</li>
                                        <li>SWIFT code:</li> --}}
                                    </ul>

                                    <ul class="list list-unstyled text-right mb-0 ml-auto">
                                        <li>
                                            <h5 class="font-weight-semibold my-2">
                                                {{ $invoice->formatCurrency($invoice->ordervalue) }}</h5>
                                        </li>
                                        <li>
                                            <span class="font-weight-semibold">
                                                {{ $invoice->buyer->custom_fields['payment Method'] }}
                                            </span>
                                        </li>
                                        {{-- <li>Hong Kong</li>
                                        <li>Thurnung street, 21</li>
                                        <li>New standard</li>
                                        <li><span class="font-weight-semibold">98574959485</span></li>
                                        <li><span class="font-weight-semibold">BHDHD98273BER</span></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-lg">
                            <thead>
                                <tr>
                                    <th>{{ __('invoices::invoice.description') }}</th>
                                    @if ($invoice->hasItemUnits)
                                        <th>{{ __('invoices::invoice.units') }}</th>
                                    @endif
                                    <th>{{ __('invoices::invoice.quantity') }}</th>
                                    <th>{{ __('invoices::invoice.price') }}</th>
                                    @if (\Request::route()->getName() == 'downloadtaxinvoice')
                                        <th>{{ Config::get('icrm.tax.name') }}</th>
                                    @endif
                                    @if ($invoice->hasItemDiscount)
                                        <th>{{ __('invoices::invoice.discount') }}</th>
                                    @endif
                                    @if ($invoice->hasItemTax)
                                        <th>{{ __('invoices::invoice.tax') }}</th>
                                    @endif
                                    <th>{{ __('invoices::invoice.sub_total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->items as $item)
                                    <tr>
                                        <td>
                                            <h6 class="mb-0">{{ $item->title }}</h6>
                                            @if ($item->description)
                                                <span class="text-muted">{!! $item->description !!}</span>
                                            @endif
                                        </td>
                                        @if ($invoice->hasItemUnits)
                                            <td>{{ $item->units }}</td>
                                        @endif
                                        <td>{{ $item->quantity }}</td>
                                        <td>
                                            {{ $invoice->formatCurrency($item->price_per_unit) }}
                                        </td>
                                        @if (\Request::route()->getName() == 'downloadtaxinvoice')
                                            <td>
                                                {{ $invoice->formatCurrency($item->taxcharged) }}
                                            </td>
                                        @endif
                                        @if ($invoice->hasItemDiscount)
                                            <td>
                                                {{ $invoice->formatCurrency($item->discount) }}
                                            </td>
                                        @endif
                                        @if ($invoice->hasItemTax)
                                            <td>
                                                {{ $invoice->formatCurrency($item->tax) }}
                                            </td>
                                        @endif

                                        <td>
                                            @if ($item->sub_total_price > 0)
                                                <span
                                                    class="font-weight-semibold">{{ $invoice->formatCurrency($item->sub_total_price ?? 0) }}</span>
                                            @else
                                                <span
                                                    class="font-weight-semibold">{{ $invoice->formatCurrency($item->quantity * ($item->price_per_unit + $item->taxcharged)) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body">
                        <div class="d-md-flex flex-md-wrap">
                            <div class="pt-2 mb-3 wmin-md-400 ml-auto">
                                <h6 class="mb-3 text-left">Total due</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            @if ($invoice->ordervalue)
                                                <tr>
                                                    <th class="text-left">Order Value:
                                                        @if (Config::get('icrm.tax.fixedtax.perc') == 0)
                                                            <span style="color: green;">(inclusive of all taxes)</span>
                                                        @endif
                                                    </th>
                                                    <td class="text-right">
                                                        {{ $invoice->formatCurrency($invoice->ordervalue) }}</td>
                                                </tr>
                                            @endif

                                            @if ($invoice->total_discount > 0)
                                                @if ($invoice->hasItemOrInvoiceDiscount())
                                                    <tr>
                                                        <th class="text-left">Discount: </th>
                                                        <td class="text-right">-
                                                            {{ $invoice->formatCurrency($invoice->total_discount) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if ($invoice->shipping_amount)
                                                <tr>
                                                    @if ($invoice->ordertype == 'Showcase At Home')
                                                        <td class="text-right">Showcase At Home Refund</td>
                                                    @else
                                                        <td class="text-right">
                                                            {{ __('invoices::invoice.shipping') }}</td>
                                                    @endif
                                                    <td class="text-right" style="text-align: center;">
                                                        @if ($invoice->ordertype == 'Showcase At Home')
                                                            - {{ $invoice->formatCurrency($invoice->shipping_amount) }}
                                                        @else
                                                            + {{ $invoice->formatCurrency($invoice->shipping_amount) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td class="text-right">{{ __('invoices::invoice.shipping') }}
                                                    </td>
                                                    <td class="text-right" style="text-align: center;">
                                                        Free Shipping
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($invoice->subtotal)
                                                <tr>
                                                    <th class="text-left">{{ __('invoices::invoice.sub_total') }}:</th>
                                                    <td class="text-right text-primary">
                                                        <h5 class="font-weight-semibold">
                                                            {{ $invoice->formatCurrency($invoice->subtotal) }}</h5>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (Config::get('icrm.tax.type') == 'fixed')
                                                @if ($invoice->hasItemOrInvoiceTax())
                                                    @if ($invoice->total_taxes > 0)
                                                        <tr>
                                                            <th class="text-left">{{ Config::get('icrm.tax.name') }}
                                                                ({{ Config::get('icrm.tax.fixedtax.perc') }})%</th>
                                                            <td class="text-right text-primary">
                                                                <h5 class="font-weight-semibold">
                                                                    {{ $invoice->formatCurrency($invoice->total_taxes) }}
                                                                </h5>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endif

                                            @if ($invoice->finaltotal)
                                                <tr>
                                                    <th class="text-left">Total:</th>
                                                    <td class="text-right text-primary">
                                                        <h5 class="font-weight-semibold">
                                                            {{ $invoice->formatCurrency($invoice->finaltotal) }}</h5>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                {{-- <div class="text-right mt-3">
                                    <button type="button" class="btn btn-primary"><b><i
                                                class="fa fa-paper-plane-o mr-1"></i></b> Send invoice</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    @if ($invoice->notes)
                        <div class="card-footer">
                            <span class="text-muted">{{ trans('invoices::invoice.notes') }}:
                                {!! $invoice->notes !!}</span>
                        </div>
                    @endif

                    <p class="text-left mx-4">
                        {{ trans('invoices::invoice.amount_in_words') }}: {{ $invoice->getTotalAmountInWords() }}
                    </p>
                </div>
            </div>
        </div>
    </div>


    {{-- <script type="text/php">
        if (isset($pdf) && $PAGE_COUNT > 1) {
            $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width);
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script> --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script> --}}
</body>

</html>
