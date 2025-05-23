<?php

use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\ExportsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AiapplicationController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ComponentpageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RoleandaccessController;
use App\Http\Controllers\CryptocurrencyController;


// Authentication
Route::prefix('authentication')->group(function () {
    Route::controller(AuthenticationController::class)->group(function () {
        Route::post('/signin', 'login')->name('signin');
        Route::get('/forgotpassword', 'forgotPassword')->name('forgotPassword');
        Route::get('/signup', 'signup')->name('signup');
        Route::post('/checkOtpCode', 'checkOtpCode')->name('checkOtpCode');
        Route::post('/sendOtpEmail', 'sendOtpEmail')->name('sendOtpEmail');

        Route::get('/login', 'signin')->name('login');
    });
});

Route::middleware('auth')->group(function () {


    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/api/sales-data', 'getSalesData')->name('index');
    });
    
    Route::controller(HomeController::class)->group(function () {
        Route::get('calendar','calendar')->name('calendar');
        Route::get('chatmessage','chatMessage')->name('chatMessage');
        Route::get('chatempty','chatempty')->name('chatempty');
        Route::get('email','email')->name('email');
        Route::get('error','error1')->name('error');
        Route::get('faq','faq')->name('faq');
        Route::get('gallery','gallery')->name('gallery');
        Route::get('kanban','kanban')->name('kanban');
        Route::get('pricing','pricing')->name('pricing');
        Route::get('termscondition','termsCondition')->name('termsCondition');
        Route::get('widgets','widgets')->name('widgets');
        Route::get('chatprofile','chatProfile')->name('chatProfile');
        Route::get('veiwdetails','veiwDetails')->name('veiwDetails');
        Route::get('blankPage','blankPage')->name('blankPage');
        Route::get('comingSoon','comingSoon')->name('comingSoon');
        Route::get('maintenance','maintenance')->name('maintenance');
        Route::get('starred','starred')->name('starred');
        Route::get('testimonials','testimonials')->name('testimonials');
        });
    
        // aiApplication
    Route::prefix('aiapplication')->group(function () {
        Route::controller(AiapplicationController::class)->group(function () {
            Route::get('/codegenerator', 'codeGenerator')->name('codeGenerator');
            Route::get('/codegeneratornew', 'codeGeneratorNew')->name('codeGeneratorNew');
            Route::get('/imagegenerator','imageGenerator')->name('imageGenerator');
            Route::get('/textgeneratornew','textGeneratorNew')->name('textGeneratorNew');
            Route::get('/textgenerator','textGenerator')->name('textGenerator');
            Route::get('/videogenerator','videoGenerator')->name('videoGenerator');
            Route::get('/voicegenerator','voiceGenerator')->name('voiceGenerator');
        });
    });
    
    // Authentication
    Route::prefix('authentication')->group(function () {
        Route::controller(AuthenticationController::class)->group(function () {
            Route::get('/logout', 'logout')->name('logout');
        });
    });
    
    
    // chart
    Route::prefix('chart')->group(function () {
        Route::controller(ChartController::class)->group(function () {
            Route::get('/columnchart', 'columnChart')->name('columnChart');
            Route::get('/linechart', 'lineChart')->name('lineChart');
            Route::get('/piechart', 'pieChart')->name('pieChart');
        });
    });
    
    // Componentpage
    Route::prefix('componentspage')->group(function () {
        Route::controller(ComponentpageController::class)->group(function () {
            Route::get('/alert', 'alert')->name('alert');
            Route::get('/avatar', 'avatar')->name('avatar');
            Route::get('/badges', 'badges')->name('badges');
            Route::get('/button', 'button')->name('button');
            Route::get('/calendar', 'calendar')->name('calendar');
            Route::get('/card', 'card')->name('card');
            Route::get('/carousel', 'carousel')->name('carousel');
            Route::get('/colors', 'colors')->name('colors');
            Route::get('/dropdown', 'dropdown')->name('dropdown');
            Route::get('/imageupload', 'imageUpload')->name('imageUpload');
            Route::get('/list', 'list')->name('list');
            Route::get('/pagination', 'pagination')->name('pagination');
            Route::get('/progress', 'progress')->name('progress');
            Route::get('/radio', 'radio')->name('radio');
            Route::get('/starrating', 'starRating')->name('starRating');
            Route::get('/switch', 'switch')->name('switch');
            Route::get('/tabs', 'tabs')->name('tabs');
            Route::get('/tags', 'tags')->name('tags');
            Route::get('/tooltip', 'tooltip')->name('tooltip');
            Route::get('/typography', 'typography')->name('typography');
            Route::get('/videos', 'videos')->name('videos');
        });
    });
    
    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/index', 'index')->name('index');
            Route::get('/index2', 'index2')->name('index2');
            Route::get('/index3', 'index3')->name('index3');
            Route::get('/index4', 'index4')->name('index4');
            Route::get('/index5','index5')->name('index5');
            Route::get('/index6','index6')->name('index6');
            Route::get('/index7','index7')->name('index7');
            Route::get('/index8','index8')->name('index8');
            Route::get('/index9','index9')->name('index9');
            Route::get('/index10','index10')->name('index10');
            Route::get('/wallet','wallet')->name('wallet');
        });
    });
    
    // Forms
    Route::prefix('forms')->group(function () {
        Route::controller(FormsController::class)->group(function () {
            Route::get('/form-layout', 'formLayout')->name('formLayout');
            Route::get('/form-validation', 'formValidation')->name('formValidation');
            Route::get('/form', 'form')->name('form');
            Route::get('/wizard', 'wizard')->name('wizard');
        });
    });
    
    // invoice/invoiceList
    Route::prefix('invoice')->group(function () {
        Route::controller(InvoiceController::class)->group(function () {
            Route::get('/invoice-add', 'invoiceAdd')->name('invoiceAdd');
            Route::get('/invoice-edit', 'invoiceEdit')->name('invoiceEdit');
            Route::get('/invoice-list', 'invoiceList')->name('invoiceList');
            Route::get('/invoice-preview', 'invoicePreview')->name('invoicePreview');
        });
    });
    
    // Settings
    Route::prefix('settings')->group(function () {
        Route::controller(SettingsController::class)->group(function () {
            Route::get('/company', 'company')->name('company');
            Route::get('/currencies', 'currencies')->name('currencies');
            Route::get('/language', 'language')->name('language');
            Route::get('/notification', 'notification')->name('notification');
            Route::get('/notification-alert', 'notificationAlert')->name('notificationAlert');
            Route::get('/payment-gateway', 'paymentGateway')->name('paymentGateway');
            Route::get('/theme', 'theme')->name('theme');
        });
    });
    
    // Table
    Route::prefix('table')->group(function () {
        Route::controller(TableController::class)->group(function () {
            Route::get('/tablebasic', 'tableBasic')->name('tableBasic');
            Route::get('/tabledata', 'tableData')->name('tableData');
        });
    });
    
    // Users
    Route::prefix('users')->group(function () {
        Route::controller(UsersController::class)->group(function () {
            Route::get('/add-user', 'addUser')->name('addUser');
            Route::get('/users-grid', 'usersGrid')->name('usersGrid');
            Route::get('/users-list', 'usersList')->name('usersList');
            Route::get('/users-hist-list', 'usersHistList')->name('usersHistList');
            Route::get('/users-roles-list', 'usersRoles')->name('usersRoles');
            Route::get('/view-profile', 'viewProfile')->name('viewProfile');

            Route::get('/users/search/{type}','usersSearch')->name('users.search');
            Route::get('/users/search/zero/{type}','usersSearchZero')->name('users.search.zero');
            //****************** */
            Route::get('/hist_login/search','histLoginSearch')->name('hist_login.search');
            Route::get('/hist_login/search/zero','histLoginSearchZero')->name('hist_login.search.zero');
    
            Route::get('users', 'show')->name('showUsers');
            Route::get('/roles/{id}/{roleType}/user', 'rolesAssigned')->name('user-roles');
    
            Route::post('/new-user', 'create')->name('new-user');
            Route::post('/update-user', 'update')->name('update-user');
            Route::post('/change-password', 'changePassword')->name('change-password');
            Route::delete('/delete', 'destroy')->name('delete');
        });
    });
    
    // Users
    Route::prefix('sales')->group(function () {
        Route::controller(SaleController::class)->group(function () {
            Route::get('/add-sale', 'addSale')->name('addSale');
            Route::get('/sales-list', 'SalesList')->name('salesList');

            Route::get('/sale/search','saleSearch')->name('sales.search');
            Route::get('/sale/search/zero','saleSearchZero')->name('sales.search.zero');
    
            Route::get('sale/{id}', 'showSale')->name('showSale');
    
            Route::post('/new-sale', 'store')->name('new-sale');
            Route::put('/update-sale/{id}', 'update')->name('update-sale');
            Route::delete('/delete-sale', 'destroy')->name('delete-sale');
        });
    });
    
    // Users
    Route::prefix('abonnements')->group(function () {
        Route::controller(AbonnementController::class)->group(function () {
            Route::get('/add-abonnements', 'addAb')->name('addAb');
            Route::get('/abonnements-list', 'adList')->name('adList');
    
            Route::get('abonnements/{id}', 'show')->name('showAb');
            Route::get('/recu/preview/{id}', 'previewPDF')->name('recu.preview');
            Route::get('/fetch-abonnements', 'fetchAbonnements');
    
            Route::post('/new-abonnement', 'store')->name('new-abonnement');
            Route::put('/rest-abonnement', 'completeRest')->name('rest-abonnement');
            Route::put('/update-abonnement/{id}', 'update')->name('update-abonnement');
            Route::get('/update-status/{id}/{status}', 'updateStatus')->name('update-status');
            Route::delete('/delete-abonnement', 'destroy')->name('delete-abonnement');
        });
    });
    
    // Users
    Route::prefix('transactions')->group(function () {
        Route::controller(TransactionController::class)->group(function () {
            Route::get('/add-tans', 'addTrans')->name('addTrans');
            Route::get('/transactions-list', 'transList')->name('transList');
            Route::get('/bilans', 'bilans')->name('bilans');


            Route::get('Transactions/export/', 'exportTransactions')->name('exportTrans');
    
            // Route::get('abonnements/{id}', 'show')->name('showAb');
            // Route::get('/fetch-abonnements', 'fetchAbonnements');
    
            Route::post('/new-transaction', 'store')->name('new-transaction');
            // Route::put('/rest-abonnement', 'completeRest')->name('rest-abonnement');
            // Route::put('/update-abonnement/{id}', 'update')->name('update-abonnement');
            // Route::get('/update-status/{id}/{status}', 'updateStatus')->name('update-status');
            // Route::delete('/delete-abonnement', 'destroy')->name('delete-abonnement');
        });
    });
    
    // Users
    Route::prefix('exports_data')->group(function () {
        Route::controller(ExportsController::class)->group(function () {
            Route::get('/export-bilan-pdf', 'exportBilanPdf')->name('bilan.export.pdf');
            Route::get('/export-rest-pdf', 'exportRestPayPdf')->name('rest.export.pdf');
        });
    });
    
    // Users
    Route::prefix('clients')->group(function () {
        Route::controller(ClientController::class)->group(function () {
            Route::get('/add-client', 'addClient')->name('addClient');
            Route::get('/clients-list', 'clientList')->name('clientsList');
            Route::get('/clients-list', 'clientList')->name('clientsList');

            Route::get('/client/search','clientSearch')->name('client.search');
            Route::get('/client/search/zero','clientSearchZero')->name('client.search.zero');
            
            // Route::get('users', 'show')->name('showUsers');
            
            Route::get('/view-client{id}', 'viewClient')->name('viewClient');
            Route::post('/new-client', 'create')->name('new-client');
            Route::put('/update-client', 'update')->name('update-client');
            Route::delete('/delete-client', 'destroy')->name('delete-client');
        });
    });
    
    // Users
    Route::prefix('products')->group(function () {
        Route::controller(ProductController::class)->group(function () {
            Route::get('/add-product', 'addProduct')->name('addProduct');
            Route::get('/products-list', 'productsList')->name('productsList');

            Route::get('/product/search','productSearch')->name('product.search');
            Route::get('/product/search/zero','productSearchZero')->name('product.search.zero');
            
            // Route::get('users', 'show')->name('showUsers');
            
            Route::get('/view-product{id}', 'viewProduct')->name('viewProduct');
            Route::post('/new-product', 'create')->name('new-product');
            Route::put('/update-product', 'update')->name('update-product');
            Route::delete('/delete-product', 'destroy')->name('delete-product');
        });
    });
    
    // Users
    Route::prefix('cours')->group(function () {
        Route::controller(CoursController::class)->group(function () {
    
            Route::get('/show-cours','show')->name('show-cours');
    
            Route::post('/new-cours', 'create')->name('new-cours');
            Route::put('/update-cours', 'update')->name('update-cours');
    
            Route::delete('/delete-cours', 'destroy')->name('delete-cours');
        });
    });
    
    // Users
    Route::prefix('service')->group(function () {
        Route::controller(AbonnementController::class)->group(function () {
    
            Route::get('/show-service','show_service')->name('show-service');
            Route::get('/abonnements/search','search')->name('abonnements.search');
            Route::get('/abonnements/search/zero','searchZero')->name('abonnements.search.zero');
    
            Route::post('/new-service', 'create_service')->name('new-service');
            Route::put('/update-service', 'update_service')->name('update-service');
    
            Route::delete('/delete-service', 'destroy_service')->name('delete-service');
        });
    });
    
    // Users
    Route::prefix('type')->group(function () {
        Route::controller(AbonnementController::class)->group(function () {
    
            Route::get('/show-type','show_type')->name('show-type');
    
            Route::post('/new-type', 'create_type')->name('new-type');
            Route::put('/update-type', 'update_type')->name('update-type');
    
            Route::delete('/delete-type', 'destroy_type')->name('delete-type');
        });
    });
    
    // Users
    Route::prefix('blog')->group(function () {
        Route::controller(BlogController::class)->group(function () {
            Route::get('/addBlog', 'addBlog')->name('addBlog');
            Route::get('/blog', 'blog')->name('blog');
            Route::get('/blogDetails', 'blogDetails')->name('blogDetails');
        });
    });
    
    // Users
    // Route::prefix('roleandaccess')->group(function () {
    //     Route::controller(RoleandaccessController::class)->group(function () {
    //         Route::get('/assignRole', 'assignRole')->name('assignRole');
    //         Route::get('/roleAaccess', 'roleAaccess')->name('roleAaccess');
    //     });
    // });
    
    // Users
    Route::prefix('cryptocurrency')->group(function () {
        Route::controller(CryptocurrencyController::class)->group(function () {
            Route::get('/marketplace', 'marketplace')->name('marketplace');
            Route::get('/marketplacedetails', 'marketplaceDetails')->name('marketplaceDetails');
            Route::get('/portfolio', 'portfolio')->name('portfolio');
            Route::get('/wallet', 'wallet')->name('wallet');
        });
    });

});

