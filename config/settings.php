<?php

return [
    'THEME_ASSETS' => [
        'global'  => [
            'css' => [
                'custom.css',
            ],
            'js'  => [
                'custom.js',
            ],
        ],
    ],


    # Theme Vendors
    'THEME_VENDORS' => [
        'global-dashboard-assets' => [
            'css' => [
                'assets/compiled/css/app.css',
                'assets/compiled/css/app-dark.css'
            ],

            'js' => [
                'assets/static/js/components/dark.js',
                'assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js',
                'assets/compiled/js/app.js',
            ]
        ],

        'auth' => [
            'css' => [
                'assets/compiled/css/app.css',
                'assets/compiled/css/app-dark.css',
                'assets/compiled/css/auth.css',
            ],

            'js' => [
                'assets/static/js/initTheme.js',
                'assets/compiled/js/app.js',
            ]
        ],

        'login-register' => [
            'js' => [
                'js/login-register.js',
                'js/verify-email-address.js',
            ]
        ],

        'datatables' => [
            'css' => [
                'assets/dataTables.bootstrap5.min.css',
            ],

            'js' => [
                'assets/extensions/cdndatatable/datatables.min.js',
            ]
        ],

        'email-upload' => [
            'js' => [
                'js/email-upload.js',
            ]
        ],

        'finishedView' => [
            'js' => [
                'js/finished-view.js',
            ]
        ],

        'downloadCsv' => [
            'js' => [
                'js/npm_chart.js',
                'js/download-csv.js',
            ]
        ],

        'settings' => [
            'js' => [
                'js/settings.js',
            ]
        ],

        'smtp-settings' => [
            'js' => [
                'js/smtp-settings.js',
            ]
        ],

        'pricing' => [
            'js' => [
                'js/pricing.js',
            ]
        ],

        'pricing-details' => [
            'js' => [
                'js/pricing-details.js',
            ]
        ],

        'users' => [
            'js' => [
                'js/users.js',
            ]
        ],

        'checkout' => [
            'js' => [
                'https://checkout.razorpay.com/v1/checkout.js',
                'js/checkout.js',
            ]
        ],

        'payment-history' => [
            'js' => [
                'js/payment-history.js',
            ]
        ],

        'responders' => [
            'js' => [
                'js/responders.js',
            ]
        ],

        'responder-settings' => [
            'js' => [
                'js/responder-settings.js'
            ]
        ],

        'Timezone' => [
            'js' => [
                'js/timezone.js'
            ]
        ],

        'invoice' => [
            'js' => [
                'js/invoice.js'
            ]
        ],

        'terms-conditions' => [
            'css' => [
                'assets/extensions/summernote/summernote-lite.css',
                'assets/compiled/css/form-editor-summernote.css'
            ],
            'js' => [
                'assets/extensions/summernote/summernote-lite.min.js',
                'assets/static/js/pages/summernote.js',
                'js/terms-and-conditions.js'
            ]
        ]


    ],

];
