<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => env('APP_NAME'),
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => env('APP_NAME'),
    'logo_img' => 'self/dark-logo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Project Agro',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => true,
        'img' => [
            'path' => 'self/light-logo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'img' => [
            'path' => 'self/light-logo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-info',
    'usermenu_image' => true,
    'usermenu_desc' => false,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => true,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'admin',
    'logout_url' => 'admin/logout',
    'login_url' => 'admin/login',
    'register_url' => false,
    'password_reset_url' => 'admin/password/reset',
    'password_email_url' => 'admin/password/email',
    'profile_url' => 'admin/profile',

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:

        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],
        [
            'text' => 'language',
            'topnav_right' => true,
            'icon' => 'fas fa-language',
            'submenu' => [
                [
                    'text'=>'bangla',
                    'icon' => 'flag-icon flag-icon-us',
                    'url'=> 'command/lang/bn'
                ],
                [
                    'text'=>'english',
                    'icon' => 'flag-icon flag-icon-kh',
                    'url'=> 'command/lang/en'
                ]
            ]
        ],

        // Sidebar items:

        [
            'text' => 'dashboard',
            'url' => 'admin',
            'icon' => 'fas fa-tachometer-alt',
        ],
        ['header' => 'cattle_management'],
        [
            'text' => 'cattle_management',
            'can' => 'cattle_manage',
            'icon' => 'fa fa-hippo',
            'submenu' => [
                [
                    'text' => 'cattle',
                    'url' => 'admin/cattles',
                    'can' => 'cattle_manage',
                ],
                [
                    'text' => 'breeds',
                    'url' => 'admin/breeds',
                    'can' => 'breed_manage',
                ],
                [
                    'text' => 'cattle_type',
                    'url' => 'admin/cattle-types',
                    'can' => 'cattle_type_manage',
                ],
                [
                    'text' => 'batches',
                    'url' => 'admin/batches',
                    'can' => 'batch_manage',
                ],
                [
                    'text' => 'session_year',
                    'url' => 'admin/session-years',
                    'can' => 'session_year_manage',
                ],
            ]
        ],
        [
            'text' => 'feeding_management',
            'can' => 'feeding_manage',
            'icon' => 'fas fa-utensils',
            'submenu' => [
                [
                    'text' => 'feeding',
                    'url' => 'admin/feedings',
                    'can' => 'feeding_manage',
                ],
                [
                    'text' => 'feeding_group',
                    'url' => 'admin/feeding-groups',
                    'can' => 'feeding_group_manage',
                ],
                [
                    'text' => 'feeding_moment',
                    'url' => 'admin/feeding-moments',
                    'can' => 'feeding_moment_manage',
                ],
                [
                    'text' => 'feeding_category',
                    'url' => 'admin/feeding-categories',
                    'can' => 'feeding_category_manage',
                ],
            ]
        ],
        [
            'text' => 'fattening',
            'url' => 'admin/fattenings',
            'can' => 'fattening_manage',
            'icon' => 'fas fa-weight',
        ],
        [
            'text' => 'dewormer',
            'url' => 'admin/dewormers',
            'can' => 'dewormer_manage',
            'icon' => 'fas fa-pills',
        ],
        [
            'text' => 'vaccine',
            'url' => 'admin/vaccines',
            'can' => 'vaccine_manage',
            'icon' => 'fas fa-syringe',
        ],
        [
            'text' => 'treatment',
            'url' => 'admin/treatments',
            'can' => 'treatment_manage',
            'icon' => 'fas fa-hand-holding-medical',
        ],
        ['header' => 'global'],

        [
            'text' => 'staff',
            'url' => 'admin/staffs',
            'can' => 'staff_manage',
            'icon' => 'fas fa-user-ninja',
        ],
        [
            'text' => 'farm',
            'url' => 'admin/farms',
            'can' => 'farm_manage',
            'icon' => 'fas fa-igloo',
        ],
        [
            'text' => 'supplier',
            'url' => 'admin/suppliers',
            'can' => 'supplier_manage',
            'icon' => 'fas fa-user-friends',
        ],
        [
            'text' => 'party',
            'url' => 'admin/parties',
            'can' => 'party_manage',
            'icon' => 'fas fa-users',
        ],
        [
            'text'    => 'sales',
            'icon'    => 'fas fa-shopping-cart',
            'icon_color' => 'green',
            'can' => ['cattle_sale_manage','milk_sale_manage'],
            'submenu' => [
                [
                    'text' => 'cattle_sale',
                    'can' => 'cattle_sale_manage',
                    'url' => 'admin/cattle-sales'
                ],
                [
                    'text' => 'bulk_cattle_sale',
                    'can' => 'bulk_cattle_sale_manage',
                    'url' => 'admin/bulk-cattle-sales'
                ],
                [
                    'text' => 'milk_sale',
                    'can' => 'milk_sale_manage',
                    'url' => 'admin/milk-sales'
                ],
            ]
        ],
        ['header' => 'inventory_management'],
        [
            'text'    => 'inventory_management',
            'icon'    => 'fas fa-warehouse',
            'can' => ['inventory_manage'],
            'submenu' => [
                [
                    'text' => 'stock_report',
                    'can' => 'stock_manage',
                    'url' => 'admin/stock'
                ],
                [
                    'text' => 'purchase',
                    'can' => 'purchase_manage',
                    'url' => 'admin/purchases'
                ],
                [
                    'text' => 'product',
                    'can' => 'product_manage',
                    'url' => 'admin/products'
                ],
                [
                    'text' => 'unit',
                    'can' => 'unit_manage',
                    'url' => 'admin/units'
                ],
                [
                    'text' => 'tax',
                    'can' => 'tax_manage',
                    'url' => 'admin/taxes'
                ],
            ]
        ],
        ['header' => 'expense_management'],
        [
            'text'    => 'expense_management',
            'icon'    => 'fas fa-credit-card',
            'icon_color' => 'red',
            'can' => ['expense_manage','expense_category','cattle_death_manage'],
            'submenu' => [
                [
                    'text' => 'expenses',
                    'can' => 'expense_manage',
                    'url' => 'admin/expenses'
                ],
                [
                    'text' => 'cattle_deaths',
                    'can' => 'cattle_death_manage',
                    'url' => 'admin/cattle-deaths'
                ],
                [
                    'text' => 'expense_category',
                    'can' => 'expense_category_manage',
                    'url' => 'admin/expense-categories'
                ],
            ]
        ],
        ['header' => 'accounting'],
        [
            'text'    => 'accounting',
            'icon'    => 'fas fa-wallet',
            'can' => ['account_manage','opening_balance_manage','balance_transfer_manage','supplier_payment_manage','party_received_manage'],
            'submenu' => [
                [
                    'text' => 'asset',
                    'can' => 'asset_manage',
                    'url' => 'admin/assets'
                ],
                [
                    'text' => 'accounts',
                    'can' => 'account_manage',
                    'url' => 'admin/accounts'
                ],
                [
                    'text' => 'opening_balance',
                    'can' => 'opening_balance_manage',
                    'url' => 'admin/opening-balances'
                ],
                [
                    'text' => 'balance_transfer',
                    'can' => 'balance_transfer_manage',
                    'url' => 'admin/balance-transfers'
                ],
                [
                    'text' => 'supplier_payment',
                    'can' => 'supplier_payment_manage',
                    'url' => 'admin/supplier-payments'
                ],
                [
                    'text' => 'party_receive',
                    'can' => 'party_receive_manage',
                    'url' => 'admin/party-receives'
                ],
            ]
        ],
        ['header' => 'settings'],
        [
            'text'    => 'global_settings',
            'icon'    => 'fas fa-cogs',
            'can' => ['global_setting_manage'],
            'submenu' => [
                [
                    'text' => 'global_setting',
                    'can' => 'global_setting_manage',
                    'url' => 'admin/global-setting'
                ],
            ]
        ],
        [
            'text'    => 'commands',
            'icon'    => 'fas fa-thumbs-up',
            'can'  => 'commands_manage',
            'submenu' => [
                [
                    'text' => 'clear_cache',
                    'can'  => 'command_cache_clear',
                    'url' => 'command/clear-cache'
                ],
                [
                    'text' => 'clear_config',
                    'can'  => 'command_config_clear',
                    'url' => 'command/clear-config'
                ],
                [
                    'text' => 'clear_route',
                    'can'  => 'command_route_clear',
                    'url' => 'command/clear-route'
                ],
                [
                    'text' => 'optimize',
                    'can'  => 'command_optimize',
                    'url' => 'command/optimize'
                ],
                [
                    'text' => 'seed',
                    'can'  => 'command_seed',
                    'url' => 'command/seed'
                ],
                [
                    'text' => 'migrate',
                    'can'  => 'command_migrate',
                    'url' => 'command/migrate'
                ],
                [
                    'text' => 'fresh_migrate',
                    'can'  => 'command_migrate_fresh',
                    'url' => 'command/migrate-fresh'
                ],
                [
                    'text' => 'fresh_migrate_seed',
                    'can'  => 'command_migrate_fresh_seed',
                    'url' => 'command/migrate-fresh-seed'
                ],



            ],

        ],
        [
            'text' => 'secure_area',
            'url'  => '',
            'icon_color' => 'red',
            'icon' => 'fas fa-lock',
            'can'  => ['role_manage','permission_manage','user_manage','admin_manage'],
            'submenu'=>[
                ['header' => 'roles_permissions'],
                [
                    'text'        => 'roles',
                    'url'         => 'admin/roles',
                    'icon'        => 'fas fa-lock',
                    'can'         =>  'role_manage',
                ],
                [
                    'text'        => 'permissions',
                    'url'         => 'admin/permissions',
                    'icon'        => 'fas fa-key',
                    'can'         => 'permission_manage',
                ],
                ['header' => 'users_admins'],
                [
                    'text'        => 'admins',
                    'url'         => 'admin/admins',
                    'icon'        => 'fas fa-user-lock',
                    'can'         => 'admin_manage',
                ],
                [
                    'text' => 'profile',
                    'url'  => 'admin/profile',
                    'icon' => 'fas fa-fw fa-user',
                ],

            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'datatablesPlugins' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => env('app_url').'/vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => env('app_url').'/vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => env('app_url').'/vendor/datatables-plugins/buttons/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => env('app_url').'/vendor/datatables-plugins/buttons/js/buttons.print.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => env('app_url').'/vendor/datatables-plugins/buttons/js/buttons.colVis.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => env('app_url').'/vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css',
                ],
            ],
        ],
        'jquery-ui' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => env('app_url').'/vendor/jquery-ui/jquery-ui.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => env('app_url').'/vendor/jquery-ui/jquery-ui.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Summernote' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' =>env('app_url').'/vendor/summernote/summernote-bs5.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' =>env('app_url').'/vendor/summernote/summernote-bs5.css',
                ],
            ],
        ],
        'moment' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => env('app_url').'/vendor/moment/moment.min.js',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
