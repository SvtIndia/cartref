<?php

return [

    /**
     * Admin panel
     */

    'admin_panel' => [
        'prefix' => 'seller',
        'icrmbranding' => 'false',
    ],
    
    
    /**
     * Backup
     */

    'backup' => [
        'mailto' => 'akash.sethi@icrmsoftware.com',
    ],

    /**
     * Redirect logic
     */
    'redirect' => [
        // where to redirect after add to cart?
        'afteraddtocart' => 'back',
    ],

    /**
     * Product SKU fields to manage stock
     */

    'product_sku' => [
        'size' => '1',
        'color' => '1',
        
        // does this platform offers separate dimensions for each sku?
        'dimensions' => true,
    ],
    
    /**
     * SEO Plugin
     */

    'seo' => [
        'feature' => true,
    ],


    'stock_management' => [
        'feature' => '1',
        /**
         * If inventory is enabled then dont show option to edit available stock on the product edit page
         * Else show option to edit available stock on the product edit page
         */
        'inventory' => '0',
        'default_stock' => '0',
    ],

    /**
     * Site Package
     */

    'site_package' => [
        'singel_brand_store' => '0',
        'multi_brand_store' => '0',
        'multi_vendor_store' => '1',
    ],
    
    
    /**
     * Site rights
     */

    'site_rights' => [
        /**
         * Can users add address?
         */
        'address' => true,
    ],

    /*
        Currency
    */
    'currency' => [
        'name' => 'Rs',
        'icon' => '₹',
    ],


    /*
        Platform tax logic
    */

    'tax' => [
        'name' => 'GST',
        
        /**
         * There are two types 1. fixed and 2. subcategory
         * If the platform offers subcategory wise tax then if it will take dynamic values
         */
        'type' => 'fixed',
        

        // if the platform offers fixed tax
        'fixedtax' => [
            'perc' =>  '0'
        ],
        
    ],

    

    /**
     * What all filters allowed in your platform
    */

    'filters' => [
        'category' => '1',
        'subcategory' => '1',
        'price' => '1',
        'size' => '1',
        'color' => '1',

        'gender' => '1',
        'style' => '1',

        // 'type' => '1',
        // 'mount' => '1',
        // 'model' => '1',
        // 'voltage' => '1',
        // 'interface' => '1',

        'brand' => '1',
    ],




    /*
        Do you have multi color products?
    */

    'multi_color_products' => [
        'feature' => '1',
        // do you want to select by default first color product?
        'select_first_color_by_default' => '1',
    ],
       
        
    /**
     * Product Approval Feature
     * Product will only show if the admin approves
     */

    'product_approval' => [
        'feature' => '1',
    ],





    /**
     * Order options
     */

    'order_options' => [
        // maximum qty per product
        'max_qty_per_product' => '5',
        'max_qty_per_order' => '20',
    ],


    
    /**
     * Delivery Charges
    */

    'delivery_charges' => [
        // do you charge for delivery?
        'feature' => '1',

        // If shiprocket is not in use, then how much do you charge for delivery per item?
        'fixedcharges' => '50',

        'shiprocket' => [
            // do you want to add additional amount to the delivery?
            'feature' => 1,
            'additional_amount' => '50',
        ]

    ],


        
    /**
     * Delivery Options
     */

    'delivery_options' => [
        // do you offer users to check delivery availability?
        'feature' => '1',
        'pincodelen' => '6',
    ],
    


    /**
     * Shipping provider
     * At a time only one can be enabled
    */

    'shipping_provider' => [
        'shiprocket' => '1',
        'dtdc' => '0',
        // calculate shipping from shipping partner?
        'calculatefrompartner' => '1',
        // do you have fixed charges?
        'fixed' => [
            'feature' => '0',
            // on subtotal how to do you calculate in perc or amount?
            'where' => 'subtotal',
            'type' => 'perc',
            'value' => '2',
        ],
        'additional_charges_perc' => '20',

        // if expected delivery is not offer by shipping partner then how many buffer days to add?
        'buffer_days' => '0',
    ],







     /**
      * Frontend Design
    */

    'frontend' => [
        
        // Dynamic menu
        'menu' => [
            'dynamic_category' => '1',
        ],

        'header' => [
            'genderwise' => '1',
        ],

        // coupon notifications on header
        'couponnotifications' => [
            'feature' => '1',
        ],

        
        // 2 column components
        'twocolumncomponent' => [
            'feature' => '1',
            // 'title' => setting('2-column-collection.title'),
            // 'description' => setting('2-column-collection.description'),
        ],

        // 3 column components
        'threecolumncomponent' => [
            'feature' => '1',
            // 'title' => setting('3-column-collection.title'),
            // 'description' => setting('3-column-collection.description'),
        ],


        // 5 column free rows components
        'fivecolumnfreerowscomponent' => [
            'feature' => '1',
            // 'title' => setting('5-column-description.title'),
            // 'description' => setting('5-column-description.description'),
        ],



        // flash sale
        'flashsale' => [
            'feature' => '1',
            'count' => '20'
        ],

        // Out of stock
        'outofstock' => [
            'name' => 'Sold Out',
        ],

        // 2 column components
        '2columncomponent' => [
            'feature' => '1',
        ],

        // trending products
        'trendingproducts' => [
            'feature' => '1',
            'count' => '20'
        ],

        // blogs
        'blogs' => [
            'feature' => '1',
        ],

        // recentlyviewed
        'recentlyviewed' => [
            'feature' => '1',
            'count' => '20'
        ],

        // newsletter signup
        'newslettersignup' => [
            'feature' => '1',
            'description' => 'It only takes a second to find out about our latest news
            and promotions...',
        ],

        // social page links
        'socialpagelinks' => [
            'feature' => '1',
            'facebook' => 'https://icrmsoftware.com',
            'instagram' => 'https://icrmsoftware.com',
            'twitter' => 'https://icrmsoftware.com',
            'linkedin' => 'https://icrmsoftware.com',
            'googleplus' => 'https://icrmsoftware.com',
            'youtube' => 'https://icrmsoftware.com',
        ],

        // product badges
        'badge' => [
            // 
            'new_product' => [
                'feature' => '1',
                // for how many days you want to showcase product under new label
                'days' => '30',
            ],
        ],

        // product catalog filter
        'catalog' => [
            'pagination_count' => '12'
        ],

        // do you offer this feature?
        'quick_view' => [
            'feature' => '1'
        ],


        // wishlist
        'wishlist' => [
            // do you want customers to authenticate before they wishlist product?
            'auth' => false,
        ],


        // Product Review & Rating
        'product_rating' => [
            
            // do you offer this feature?
            'feature' => '1',
            
            // how many reviews to show
            'count' => '20',
            
            // per page pagination
            'pagination' => '4',
        ],


        'brochure' => [
            'name' => 'brochure',
        ],




    ],










    /**
     * Order methods
     */

    'order_methods' => [
        'prepaid' => '1',
        'cod' => '1',
    ],

        

    
    

    
    
    
    
    
    
    
    
    
    /**
     * Authentication for users
     */

    'auth' => [

        // do you offer email verification?
        'email_verification' => '1',

        // do you offer mobile otp verification?
        'otp_verification' => false,

        // do you offer deactivate account feature
        'deactivate' => '1',

        // you can only control field which are optional accourding to basic registration process
        'fields' => [
            'companyinfo' => false,
        ],
    ],
    
    


    /**
     * Social auths
     */

    'social_auth' => [
        'google' => true,
        'facebook' => true,
    ],


    /**
     * For Vendors
     */

    'vendor' => [
        // can multiple vendors be registered on the platform?
        'multiple_vendors' => '1',
        
        // Can vendors signup on your platform
        'signup' => '1',

    ],









    /*
        Customize product settings
    */

    'customize' => [
        // do you offer product customization?
        'feature' => '0',

        // your media
        'your_media' => '0',
    ],

    







    
    /*
        Showcase at home settings
    */
    'showcase_at_home' => [
        // do you offer showcase at home?
        'feature' => '1',

        // how many products customer can showcase at home once?
        'order_limit' => '5',

        // what are the delivery charges for customers who request showcase at home within a city?
        'delivery_charges' => '150',

        // what is you delivery tat in minute, hour, day, week, month?
        'delivery_tat' => '3',
        'delivery_tat_name' => 'hours',

        // do you offer dicount of deliver charges when customer purchase any product?
        'dicount_delivery_charges_feature' => '1',
        'dicount_delivery_charges' => '150',


        'showcase_initiated_email' => '1',
        'showcase_purchased_email' => '1',

        // how many active showcase orders customers can place?
        'active_orders' => '1',
    ],


    'sms' => [
        'msg91' => [
            'feature' => '0',
            'welcome_flow_id' => '62541b4b9714fc5c2420a659',
            'order_placed_flow_id' => '6299a83cf6c04443d01ac582',
        ],
    ],

    'cart' => [
        'name' => 'bag',
    ],


    'order_lifecycle' => [

        'undermanufacturing' => [
            'feature' => '0',
        ],

        'return' => [
            'feature' => '1',
            'refund' => '1',
            'exchange' => '0',
            'tat_days' => '7'
        ],

    ],
    
    
    
    'sticky_footer' => [
        'cataloge' => 'Browse',
    ],

    'products' => [
        'feature' => true,
        'catalog' => [

            /**
             * Buttons name
             */
            'buttons' => [
                // add to cart button - done
                'cart' => [
                    'feature' => false,
                    'icon' => 'd-icon-bag',
                    'name' => 'Add to Bag',
                ],

                // rent product
                'rent' => [
                    'feature' => true,
                    'icon' => 'fa fa-calendar-alt',
                    'name' => 'Rent Now',
                ],

            ],


        ]
    ],

    'services' => [
        'feature' => false,
        'name' => 'lab',
        'filters' => [
            'category' => true,
            'subcategory' => true,
            'price' => true,
            'location' => true,
        ],
        'catalog' => [

            /**
             * Result per page
             * 12, 24, 36
             */
            'per_page' => 12,

            /**
             * list or box view?
            * list-mode or box-mode
             */
            'mode' => 'list-mode',

            /**
             * Columns for desktop, tablet, mobile
             * Tablet and mobile needs to work
             */
            'box-columns-desktop' => 3,
            'list-columns-desktop' => 1,

            /**
             * Buttons name
             */
            'buttons' => [
                // view service page
                'view' => [
                    'feature' => true,
                    'icon' => 'fa fa-eye',
                    'name' => 'View',
                ],

                // book service - popup form
                'book' => [
                    'feature' => true,
                    'icon' => 'fa fa-calendar-alt',
                    'name' => 'Rent Now',
                ],
            ],


            /**
             * Badges
             */

            'badges' => [

                'discount' => [
                    'feature' => true,
                ],
                
                'new' => [
                    'feature' => true,
                    'days' => 30,
                ],
            ],
        ]
    ]

    
];