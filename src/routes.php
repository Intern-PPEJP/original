<?php

namespace PHPMaker2021\ppejp_web;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // w_users
    $app->any('/wuserslist[/{user_id}]', WUsersController::class . ':list')->add(PermissionMiddleware::class)->setName('wuserslist-w_users-list'); // list
    $app->any('/wusersadd[/{user_id}]', WUsersController::class . ':add')->add(PermissionMiddleware::class)->setName('wusersadd-w_users-add'); // add
    $app->any('/wusersedit[/{user_id}]', WUsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('wusersedit-w_users-edit'); // edit
    $app->group(
        '/w_users',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{user_id}]', WUsersController::class . ':list')->add(PermissionMiddleware::class)->setName('w_users/list-w_users-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{user_id}]', WUsersController::class . ':add')->add(PermissionMiddleware::class)->setName('w_users/add-w_users-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{user_id}]', WUsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('w_users/edit-w_users-edit-2'); // edit
        }
    );

    // home
    $app->any('/home[/{params:.*}]', HomeController::class)->add(PermissionMiddleware::class)->setName('home-home-custom'); // custom

    // w_pages
    $app->any('/wpageslist[/{page_id}]', WPagesController::class . ':list')->add(PermissionMiddleware::class)->setName('wpageslist-w_pages-list'); // list
    $app->any('/wpagesadd[/{page_id}]', WPagesController::class . ':add')->add(PermissionMiddleware::class)->setName('wpagesadd-w_pages-add'); // add
    $app->any('/wpagesview[/{page_id}]', WPagesController::class . ':view')->add(PermissionMiddleware::class)->setName('wpagesview-w_pages-view'); // view
    $app->any('/wpagesedit[/{page_id}]', WPagesController::class . ':edit')->add(PermissionMiddleware::class)->setName('wpagesedit-w_pages-edit'); // edit
    $app->any('/wpagesdelete[/{page_id}]', WPagesController::class . ':delete')->add(PermissionMiddleware::class)->setName('wpagesdelete-w_pages-delete'); // delete
    $app->group(
        '/w_pages',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{page_id}]', WPagesController::class . ':list')->add(PermissionMiddleware::class)->setName('w_pages/list-w_pages-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{page_id}]', WPagesController::class . ':add')->add(PermissionMiddleware::class)->setName('w_pages/add-w_pages-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{page_id}]', WPagesController::class . ':view')->add(PermissionMiddleware::class)->setName('w_pages/view-w_pages-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{page_id}]', WPagesController::class . ':edit')->add(PermissionMiddleware::class)->setName('w_pages/edit-w_pages-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{page_id}]', WPagesController::class . ':delete')->add(PermissionMiddleware::class)->setName('w_pages/delete-w_pages-delete-2'); // delete
        }
    );

    // pelatihan
    $app->any('/pelatihan[/{params:.*}]', PelatihanController::class)->add(PermissionMiddleware::class)->setName('pelatihan-pelatihan-custom'); // custom

    // exportcoachingprogram
    $app->any('/exportcoachingprogram[/{params:.*}]', ExportcoachingprogramController::class)->add(PermissionMiddleware::class)->setName('exportcoachingprogram-exportcoachingprogram-custom'); // custom

    // obrolanekspor
    $app->any('/obrolanekspor[/{params:.*}]', ObrolaneksporController::class)->add(PermissionMiddleware::class)->setName('obrolanekspor-obrolanekspor-custom'); // custom

    // webinar
    $app->any('/webinar[/{params:.*}]', WebinarController::class)->add(PermissionMiddleware::class)->setName('webinar-webinar-custom'); // custom

    // berita
    $app->any('/berita[/{params:.*}]', BeritaController::class)->add(PermissionMiddleware::class)->setName('berita-berita-custom'); // custom

    // tentangkami
    $app->any('/tentangkami[/{params:.*}]', TentangkamiController::class)->add(PermissionMiddleware::class)->setName('tentangkami-tentangkami-custom'); // custom

    // tentangbpmjp
    $app->any('/tentangbpmjp[/{params:.*}]', TentangbpmjpController::class)->add(PermissionMiddleware::class)->setName('tentangbpmjp-tentangbpmjp-custom'); // custom

    // informasipelatihan
    $app->any('/informasipelatihan[/{params:.*}]', InformasipelatihanController::class)->add(PermissionMiddleware::class)->setName('informasipelatihan-informasipelatihan-custom'); // custom

    // kerjasama
    $app->any('/kerjasama[/{params:.*}]', KerjasamaController::class)->add(PermissionMiddleware::class)->setName('kerjasama-kerjasama-custom'); // custom

    // halaman
    $app->any('/halaman[/{params:.*}]', HalamanController::class)->add(PermissionMiddleware::class)->setName('halaman-halaman-custom'); // custom

    // kudagang
    $app->any('/kudagang[/{params:.*}]', KudagangController::class)->add(PermissionMiddleware::class)->setName('kudagang-kudagang-custom'); // custom

    // akun
    $app->any('/akun[/{params:.*}]', AkunController::class)->add(PermissionMiddleware::class)->setName('akun-akun-custom'); // custom

    // w_pelatihan
    $app->any('/wpelatihanlist[/{pelatihan_id}]', WPelatihanController::class . ':list')->add(PermissionMiddleware::class)->setName('wpelatihanlist-w_pelatihan-list'); // list
    $app->any('/wpelatihanadd[/{pelatihan_id}]', WPelatihanController::class . ':add')->add(PermissionMiddleware::class)->setName('wpelatihanadd-w_pelatihan-add'); // add
    $app->any('/wpelatihanview[/{pelatihan_id}]', WPelatihanController::class . ':view')->add(PermissionMiddleware::class)->setName('wpelatihanview-w_pelatihan-view'); // view
    $app->any('/wpelatihanedit[/{pelatihan_id}]', WPelatihanController::class . ':edit')->add(PermissionMiddleware::class)->setName('wpelatihanedit-w_pelatihan-edit'); // edit
    $app->any('/wpelatihandelete[/{pelatihan_id}]', WPelatihanController::class . ':delete')->add(PermissionMiddleware::class)->setName('wpelatihandelete-w_pelatihan-delete'); // delete
    $app->group(
        '/w_pelatihan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{pelatihan_id}]', WPelatihanController::class . ':list')->add(PermissionMiddleware::class)->setName('w_pelatihan/list-w_pelatihan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{pelatihan_id}]', WPelatihanController::class . ':add')->add(PermissionMiddleware::class)->setName('w_pelatihan/add-w_pelatihan-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{pelatihan_id}]', WPelatihanController::class . ':view')->add(PermissionMiddleware::class)->setName('w_pelatihan/view-w_pelatihan-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{pelatihan_id}]', WPelatihanController::class . ':edit')->add(PermissionMiddleware::class)->setName('w_pelatihan/edit-w_pelatihan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{pelatihan_id}]', WPelatihanController::class . ':delete')->add(PermissionMiddleware::class)->setName('w_pelatihan/delete-w_pelatihan-delete-2'); // delete
        }
    );

    // w_orders
    $app->any('/worderslist[/{order_id}]', WOrdersController::class . ':list')->add(PermissionMiddleware::class)->setName('worderslist-w_orders-list'); // list
    $app->any('/wordersadd[/{order_id}]', WOrdersController::class . ':add')->add(PermissionMiddleware::class)->setName('wordersadd-w_orders-add'); // add
    $app->group(
        '/w_orders',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{order_id}]', WOrdersController::class . ':list')->add(PermissionMiddleware::class)->setName('w_orders/list-w_orders-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{order_id}]', WOrdersController::class . ':add')->add(PermissionMiddleware::class)->setName('w_orders/add-w_orders-add-2'); // add
        }
    );

    // konfimasi_pembayaran
    $app->any('/konfimasipembayaranlist[/{order_id}]', KonfimasiPembayaranController::class . ':list')->add(PermissionMiddleware::class)->setName('konfimasipembayaranlist-konfimasi_pembayaran-list'); // list
    $app->any('/konfimasipembayaranview[/{order_id}]', KonfimasiPembayaranController::class . ':view')->add(PermissionMiddleware::class)->setName('konfimasipembayaranview-konfimasi_pembayaran-view'); // view
    $app->any('/konfimasipembayaranedit[/{order_id}]', KonfimasiPembayaranController::class . ':edit')->add(PermissionMiddleware::class)->setName('konfimasipembayaranedit-konfimasi_pembayaran-edit'); // edit
    $app->group(
        '/konfimasi_pembayaran',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{order_id}]', KonfimasiPembayaranController::class . ':list')->add(PermissionMiddleware::class)->setName('konfimasi_pembayaran/list-konfimasi_pembayaran-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{order_id}]', KonfimasiPembayaranController::class . ':view')->add(PermissionMiddleware::class)->setName('konfimasi_pembayaran/view-konfimasi_pembayaran-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{order_id}]', KonfimasiPembayaranController::class . ':edit')->add(PermissionMiddleware::class)->setName('konfimasi_pembayaran/edit-konfimasi_pembayaran-edit-2'); // edit
        }
    );

    // akunku
    $app->any('/akunkulist[/{user_id}]', AkunkuController::class . ':list')->add(PermissionMiddleware::class)->setName('akunkulist-akunku-list'); // list
    $app->any('/akunkuview[/{user_id}]', AkunkuController::class . ':view')->add(PermissionMiddleware::class)->setName('akunkuview-akunku-view'); // view
    $app->any('/akunkuedit[/{user_id}]', AkunkuController::class . ':edit')->add(PermissionMiddleware::class)->setName('akunkuedit-akunku-edit'); // edit
    $app->group(
        '/akunku',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{user_id}]', AkunkuController::class . ':list')->add(PermissionMiddleware::class)->setName('akunku/list-akunku-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{user_id}]', AkunkuController::class . ':view')->add(PermissionMiddleware::class)->setName('akunku/view-akunku-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{user_id}]', AkunkuController::class . ':edit')->add(PermissionMiddleware::class)->setName('akunku/edit-akunku-edit-2'); // edit
        }
    );

    // pelatihanekspor
    $app->any('/pelatihanekspor[/{params:.*}]', PelatihaneksporController::class)->add(PermissionMiddleware::class)->setName('pelatihanekspor-pelatihanekspor-custom'); // custom

    // pelatihanmetrologi
    $app->any('/pelatihanmetrologi[/{params:.*}]', PelatihanmetrologiController::class)->add(PermissionMiddleware::class)->setName('pelatihanmetrologi-pelatihanmetrologi-custom'); // custom

    // pelatihanmutu
    $app->any('/pelatihanmutu[/{params:.*}]', PelatihanmutuController::class)->add(PermissionMiddleware::class)->setName('pelatihanmutu-pelatihanmutu-custom'); // custom

    // w_berita
    $app->any('/wberitalist[/{id}]', WBeritaController::class . ':list')->add(PermissionMiddleware::class)->setName('wberitalist-w_berita-list'); // list
    $app->any('/wberitaadd[/{id}]', WBeritaController::class . ':add')->add(PermissionMiddleware::class)->setName('wberitaadd-w_berita-add'); // add
    $app->any('/wberitaedit[/{id}]', WBeritaController::class . ':edit')->add(PermissionMiddleware::class)->setName('wberitaedit-w_berita-edit'); // edit
    $app->any('/wberitadelete[/{id}]', WBeritaController::class . ':delete')->add(PermissionMiddleware::class)->setName('wberitadelete-w_berita-delete'); // delete
    $app->group(
        '/w_berita',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', WBeritaController::class . ':list')->add(PermissionMiddleware::class)->setName('w_berita/list-w_berita-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', WBeritaController::class . ':add')->add(PermissionMiddleware::class)->setName('w_berita/add-w_berita-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', WBeritaController::class . ':edit')->add(PermissionMiddleware::class)->setName('w_berita/edit-w_berita-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', WBeritaController::class . ':delete')->add(PermissionMiddleware::class)->setName('w_berita/delete-w_berita-delete-2'); // delete
        }
    );

    // w_kat_berita
    $app->any('/wkatberitalist[/{id}]', WKatBeritaController::class . ':list')->add(PermissionMiddleware::class)->setName('wkatberitalist-w_kat_berita-list'); // list
    $app->any('/wkatberitaadd[/{id}]', WKatBeritaController::class . ':add')->add(PermissionMiddleware::class)->setName('wkatberitaadd-w_kat_berita-add'); // add
    $app->any('/wkatberitaaddopt', WKatBeritaController::class . ':addopt')->add(PermissionMiddleware::class)->setName('wkatberitaaddopt-w_kat_berita-addopt'); // addopt
    $app->any('/wkatberitaedit[/{id}]', WKatBeritaController::class . ':edit')->add(PermissionMiddleware::class)->setName('wkatberitaedit-w_kat_berita-edit'); // edit
    $app->any('/wkatberitadelete[/{id}]', WKatBeritaController::class . ':delete')->add(PermissionMiddleware::class)->setName('wkatberitadelete-w_kat_berita-delete'); // delete
    $app->group(
        '/w_kat_berita',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', WKatBeritaController::class . ':list')->add(PermissionMiddleware::class)->setName('w_kat_berita/list-w_kat_berita-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', WKatBeritaController::class . ':add')->add(PermissionMiddleware::class)->setName('w_kat_berita/add-w_kat_berita-add-2'); // add
            $group->any('/' . Config("ADDOPT_ACTION") . '', WKatBeritaController::class . ':addopt')->add(PermissionMiddleware::class)->setName('w_kat_berita/addopt-w_kat_berita-addopt-2'); // addopt
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', WKatBeritaController::class . ':edit')->add(PermissionMiddleware::class)->setName('w_kat_berita/edit-w_kat_berita-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', WKatBeritaController::class . ':delete')->add(PermissionMiddleware::class)->setName('w_kat_berita/delete-w_kat_berita-delete-2'); // delete
        }
    );

    // pelatihanjasaperdagangan
    $app->any('/pelatihanjasaperdagangan[/{params:.*}]', PelatihanjasaperdaganganController::class)->add(PermissionMiddleware::class)->setName('pelatihanjasaperdagangan-pelatihanjasaperdagangan-custom'); // custom

    // lspppejp
    $app->any('/lspppejp[/{params:.*}]', LspppejpController::class)->add(PermissionMiddleware::class)->setName('lspppejp-lspppejp-custom'); // custom

    // lspbpmjp
    $app->any('/lspbpmjp[/{params:.*}]', LspbpmjpController::class)->add(PermissionMiddleware::class)->setName('lspbpmjp-lspbpmjp-custom'); // custom

    // w_settings
    $app->any('/wsettingslist[/{ID}]', WSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('wsettingslist-w_settings-list'); // list
    $app->any('/wsettingsedit[/{ID}]', WSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('wsettingsedit-w_settings-edit'); // edit
    $app->group(
        '/w_settings',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ID}]', WSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('w_settings/list-w_settings-list-2'); // list
            $group->any('/' . Config("EDIT_ACTION") . '[/{ID}]', WSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('w_settings/edit-w_settings-edit-2'); // edit
        }
    );

    // w_userlevelpermissions
    $app->any('/wuserlevelpermissionslist[/{userlevelid}/{_tablename}]', WUserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('wuserlevelpermissionslist-w_userlevelpermissions-list'); // list
    $app->any('/wuserlevelpermissionsadd[/{userlevelid}/{_tablename}]', WUserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('wuserlevelpermissionsadd-w_userlevelpermissions-add'); // add
    $app->any('/wuserlevelpermissionsedit[/{userlevelid}/{_tablename}]', WUserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('wuserlevelpermissionsedit-w_userlevelpermissions-edit'); // edit
    $app->group(
        '/w_userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}/{_tablename}]', WUserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('w_userlevelpermissions/list-w_userlevelpermissions-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}/{_tablename}]', WUserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('w_userlevelpermissions/add-w_userlevelpermissions-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}/{_tablename}]', WUserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('w_userlevelpermissions/edit-w_userlevelpermissions-edit-2'); // edit
        }
    );

    // w_userlevels
    $app->any('/wuserlevelslist[/{userlevelid}]', WUserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('wuserlevelslist-w_userlevels-list'); // list
    $app->any('/wuserlevelsadd[/{userlevelid}]', WUserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('wuserlevelsadd-w_userlevels-add'); // add
    $app->any('/wuserlevelsedit[/{userlevelid}]', WUserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('wuserlevelsedit-w_userlevels-edit'); // edit
    $app->group(
        '/w_userlevels',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}]', WUserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('w_userlevels/list-w_userlevels-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}]', WUserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('w_userlevels/add-w_userlevels-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}]', WUserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('w_userlevels/edit-w_userlevels-edit-2'); // edit
        }
    );

    // formpendaftaran
    $app->any('/formpendaftaran[/{params:.*}]', FormpendaftaranController::class)->add(PermissionMiddleware::class)->setName('formpendaftaran-formpendaftaran-custom'); // custom

    // sertifikasikompetensi
    $app->any('/sertifikasikompetensi[/{params:.*}]', SertifikasikompetensiController::class)->add(PermissionMiddleware::class)->setName('sertifikasikompetensi-sertifikasikompetensi-custom'); // custom

    // w_testimoni
    $app->any('/wtestimonilist[/{testimoni_id}]', WTestimoniController::class . ':list')->add(PermissionMiddleware::class)->setName('wtestimonilist-w_testimoni-list'); // list
    $app->any('/wtestimoniadd[/{testimoni_id}]', WTestimoniController::class . ':add')->add(PermissionMiddleware::class)->setName('wtestimoniadd-w_testimoni-add'); // add
    $app->any('/wtestimoniedit[/{testimoni_id}]', WTestimoniController::class . ':edit')->add(PermissionMiddleware::class)->setName('wtestimoniedit-w_testimoni-edit'); // edit
    $app->any('/wtestimonidelete[/{testimoni_id}]', WTestimoniController::class . ':delete')->add(PermissionMiddleware::class)->setName('wtestimonidelete-w_testimoni-delete'); // delete
    $app->group(
        '/w_testimoni',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{testimoni_id}]', WTestimoniController::class . ':list')->add(PermissionMiddleware::class)->setName('w_testimoni/list-w_testimoni-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{testimoni_id}]', WTestimoniController::class . ':add')->add(PermissionMiddleware::class)->setName('w_testimoni/add-w_testimoni-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{testimoni_id}]', WTestimoniController::class . ':edit')->add(PermissionMiddleware::class)->setName('w_testimoni/edit-w_testimoni-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{testimoni_id}]', WTestimoniController::class . ':delete')->add(PermissionMiddleware::class)->setName('w_testimoni/delete-w_testimoni-delete-2'); // delete
        }
    );

    // faq
    $app->any('/faq[/{params:.*}]', FaqController::class)->add(PermissionMiddleware::class)->setName('faq-faq-custom'); // custom

    // caridata
    $app->any('/caridatalist', CaridataController::class . ':list')->add(PermissionMiddleware::class)->setName('caridatalist-caridata-list'); // list
    $app->group(
        '/caridata',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', CaridataController::class . ':list')->add(PermissionMiddleware::class)->setName('caridata/list-caridata-list-2'); // list
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // change_password
    $app->any('/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // register
    $app->any('/register', OthersController::class . ':register')->add(PermissionMiddleware::class)->setName('register');

    // userpriv
    $app->any('/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
