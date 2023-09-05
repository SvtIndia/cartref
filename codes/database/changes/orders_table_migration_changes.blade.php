invoice_url
order_awb
shipping_id

shipping_provider
shiprocket_order_id
shiprocket_shipment_id
shiprocket_awb_code
shiprocket_label_url
shiprocket_manifest_url
tax_invoice
shipping_label
exp_delivery_date
order_status
order_substatus
tracking_url

replace order_id to order_number

{{-- now according to the new database structure we can have benefits of below features --}}

{{-- 1. Admin can split order into multiple shipping packages/awb --}}



id
order_id
order_number
order_status
    1. New order
    2. Under manufacturing
    3. Under processing
    4. Ready to dispatch
    5. Shipped
    6. RTO
    7. Delivered
    8. NDR
shipping_provider
shipping_status
shipping_substatus
{{-- order id is sent by the shipping partner --}}
shipping_order_id
{{-- Shipment id is for individual item which is sent by the shipping partner --}}
shipping_shipment_id 

shipping_awb_code
shipping_tracking_url
shipping_label_url
shipping_manifest_url
shipping_invoice_url
shipping_exp_delivery_date




