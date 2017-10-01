<?php


Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/e', function () {

    Notification::send(\App\Models\User::first(),
        new \App\Notifications\DeleteMagasinNotification("amine.laghlabi@gmail.com"));
});


Route::get('/session', function () {
    dump(session()->all());
});

/***************************************
 * Admin routes protected by adminMiddleware
 ****************************************/
Route::group(['middleware' => 'admin'], function () {

    //Afficher la page d'accueil ==> Admin
    Route::get('/admin', 'AdminController@home')->name('admin.home');


    //Profile ----------------------------------------------------------------------------------------------------------
    Route::get('/admin/profile', 'AdminController@profile')->name('admin.profile');
    Route::get('/admin/updatePassword', 'AdminController@updatePassword')->name('admin.updatePassword');
    Route::post('/admin/submitUpdateProfile', 'AdminController@submitUpdateProfile')->name('admin.submitUpdateProfile');
    Route::post('/admin/submitUpdatePassword', 'AdminController@submitUpdatePassword')->name('admin.submitUpdatePassword');
    //------------------------------------------------------------------------------------------------------------------
    //Users-------------------------------------------------------------------------------------------------------------
    Route::get('/admin/users', 'AdminController@users')->name('admin.users');
    Route::get('/admin/user/{p_id}', 'AdminController@user')->name('admin.user');
    Route::get('/admin/addUser', 'AdminController@addUser')->name('admin.addUser');
    Route::post('/admin/submitAddUser', 'AdminController@submitAddUser')->name('admin.submitAddUser');
    Route::post('/admin/submitUpdateUser', 'AdminController@submitUpdateUser')->name('admin.submitUpdateUser');
    Route::get('/admin/updateUserPassword/{p_id}', 'AdminController@updateUserPassword')->name('admin.updateUserPassword');
    Route::post('/admin/submitUpdateUserPassword', 'AdminController@submitUpdateUserPassword')->name('admin.submitUpdateUserPassword');
    //------------------------------------------------------------------------------------------------------------------

    //Article ----------------------------------------------------------------------------------------------------------
    Route::get('/admin/articles', 'AdminController@articles')->name('admin.articles');
    Route::get('/admin/article/{p_id}', 'AdminController@article')->name('admin.article');
    Route::get('/admin/articles_v', 'AdminController@articles_v')->name('admin.articles_v');
    Route::get('/admin/articles_nv', 'AdminController@articles_nv')->name('admin.articles_nv');

    Route::post('/admin/submitArticlesValide', 'AdminController@submitArticlesValide')->name('admin.submitArticlesValide');

    //Route::get('/admin/article/{p_id}', 'AdminController@article_nv')->name('admin.article');

    Route::get('/admin/addArticle', 'AddController@addArticle')->name('admin.addArticle');
    Route::post('/admin/submitUpdateArticle', 'AdminController@submitUpdateArticle')->name('admin.submitUpdateArticle');
    //------------------------------------------------------------------------------------------------------------------
    //Promotion --------------------------------------------------------------------------------------------------------
    Route::get('/admin/promotions', 'AdminController@promotions')->name('admin.promotions');
    Route::get('/admin/promotion/{p_id}', 'AdminController@promotion')->name('admin.promotion');

    Route::get('/admin/addPromotions', 'AddController@addPromotions')->name('admin.addPromotions');
    Route::post('/admin/submitAddPromotions', 'AddController@submitAddPromotions')->name('admin.submitAddPromotions');
    Route::post('/admin/submitUpdatePromotion', 'UpdateController@submitUpdatePromotion')->name('admin.submitUpdatePromotion');
    //------------------------------------------------------------------------------------------------------------------
    //magasin ----------------------------------------------------------------------------------------------------------
    Route::get('/admin/magasins', 'AdminController@magasins')->name('admin.magasins');
    Route::get('/admin/magasin/{id_magasin}', 'AdminController@magasin')->name('admin.magasin');
    Route::post('/admin/submitUpdateMagasin', 'UpdateController@submitUpdateMagasin')->name('admin.submitUpdateMagasin');
    Route::get('/admin/addMagasin', 'AddController@addMagasinAdmin')->name('admin.addMagasinAdmin');
    Route::post('/admin/submitAddMagasin', 'AddController@submitAddMagasin')->name('admin.submitAddMagasin');

    //Stock
    Route::get('/admin/stocks/{p_id}', 'AdminController@stocks')->name('admin.stocks');
    Route::get('/admin/stock/{p_id}', 'AdminController@stock')->name('admin.stock');

    //Transactions
    Route::get('/admin/entrees', 'AdminController@entrees')->name('admin.entrees');
    Route::get('/admin/entree/{p_id}', 'AdminController@entree')->name('admin.entree');

    Route::get('/admin/sorties', 'AdminController@sorties')->name('admin.sorties');
    Route::get('/admin/sortie/{p_id}', 'AdminController@sortie')->name('admin.sortie');

    Route::get('/admin/transfertINs', 'AdminController@transfertINs')->name('admin.transfertINs');
    Route::get('/admin/transfertOUTs', 'AdminController@transfertOUTs')->name('admin.transfertOUTs');

    Route::get('/admin/transfertIN/{p_id}', 'AdminController@transfertIN')->name('admin.transfertIN');
    Route::get('/admin/transfertOUT/{p_id}', 'AdminController@transfertOUT')->name('admin.transfertOUT');

    Route::get('/admin/ventes', 'AdminController@ventes')->name('admin.ventes');
    Route::get('/admin/vente/{p_id}', 'AdminController@vente')->name('admin.vente');

    //article
    Route::get('/admin/article/{id_article}', 'AdminController@article')->name('admin.article');
    Route::post('/admin/submitUpdateArticle', 'AdminController@submitUpdateArticle')->name('admin.submitUpdateArticle');
    //------------------------------------------------------------------------------------------------------------------

    //Delete -----------------------------------------------------------------------------------------------------------
    Route::delete('admin/user/{id}', 'DeleteController@adminUser')->name('admin.deleteUser');
    Route::delete('admin/article/{id}', 'DeleteController@adminArticle')->name('admin.deleteArticle');

    Route::delete('admin/promotion/{id}', 'DeleteController@adminPromotion')->name('admin.deletePromotion');
    Route::delete('admin/magasin/{id}', 'DeleteController@adminMagasin')->name('admin.deleteMagasin');
    //------------------------------------------------------------------------------------------------------------------
});


/***************************************
 * Magas routes protected by magasMiddleware
 ****************************************/
Route::group(['middleware' => 'magas'], function () {

    Route::get('/magas', 'MagasController@home')->name('magas.home');

    //Profil magasinier
    Route::get('/magas/profile', 'MagasController@profile')->name('magas.profile');
    Route::get('/magas/updatePassword', 'MagasController@updatePassword')->name('magas.updatePassword');
    Route::post('/magas/submitUpdateProfile', 'MagasController@submitUpdateProfile')->name('magas.submitUpdateProfile');
    Route::post('/magas/submitUpdatePassword', 'MagasController@submitUpdatePassword')->name('magas.submitUpdatePassword');

    //Magasin ----------------------------------------------------------------------------------------------------------
    Route::get('/magas/magasins', 'MagasController@magasins')->name('magas.magasins');
    Route::get('/magas/magasin', 'MagasController@main_magasin')->name('magas.main_magasin');
    Route::get('/magas/magasin/{p_id?}', 'MagasController@magasin')->name('magas.magasin');
    Route::get('/magas/addMagasin', 'AddController@addMagasin')->name('magas.addMagasin');
    Route::post('/magas/submitAddMagasin', 'AddController@submitAddMagasin')->name('magas.submitAddMagasin');
    Route::post('/magas/submitUpdateMagasin', 'UpdateController@submitUpdateMagasin')->name('magas.submitUpdateMagasin');
    //------------------------------------------------------------------------------------------------------------------
    //Main-Magasin -----------------------------------------------------------------------------------------------------
    //afficher le stock du magasin principal
    Route::get('/magas/stocks', 'StockController@main_stocks')->name('magas.main_stocks');
    Route::get('/magas/stocks/{p_id?}', 'StockController@stocks')->name('magas.stocks');

    //afficher un article du stock en detail
    Route::get('/magas/stock/{p_id}', 'StockController@stock')->name('magas.stock');

    //creer le stock....................................................................................................
    Route::get('/magas/addStock/{p_id}', 'StockController@addStock')->name('magas.addStock');
    Route::post('/magas/submitAddStock', 'StockController@submitAddStock')->name('magas.submitAddStock');
    //..................................................................................................................

    //main magasin stock IN et OUT .....................................................................................
    Route::get('/magas/addStockIN', 'StockController@addStockIN')->name('magas.addStockIN');
    Route::get('/magas/addStockOUT', 'StockController@addStockOUT')->name('magas.addStockOUT');
    Route::post('/magas/submitAddStockIN', 'StockController@submitAddStockIN')->name('magas.submitAddStockIN');
    Route::post('/magas/submitAddStockOUT', 'StockController@submitAddStockOUT')->name('magas.submitAddStockOUT');
    //..................................................................................................................

    //Transferer stock .................................................................................................
    Route::get('/magas/addStockTransfertOUT', 'StockController@addStockTransfertOUTall')->name('magas.addStockTransfertOUT');//transfert out vers any magasin
    Route::get('/magas/addStockTransfertIN/{p_id_magasin_source}', 'StockController@addStockTransfertIN')->name('magas.addStockTransfertIN');//Transfert IN depuis un magasin X
    Route::get('/magas/addStockTransfertOUT/{p_id_magasin_destination?}', 'StockController@addStockTransfertOUT')->name('magas.addStockTransfertOUT');//transfert out vers un magasin X
    Route::post('/magas/submitAddStockTransfertIN', 'StockController@submitAddStockTransfertIN')->name('magas.submitAddStockTransfertIN');
    Route::post('/magas/submitAddStockTransfertOUT', 'StockController@submitAddStockTransfertOUT')->name('magas.submitAddStockTransfertOUT');
    //..................................................................................................................

    //Transactions .....................................................................................................
    Route::get('/magas/entrees', 'TransactionController@entrees')->name('magas.entrees');
    Route::get('/magas/entree/{p_id}', 'TransactionController@entree')->name('magas.entree');
    Route::get('/magas/sorties', 'TransactionController@sorties')->name('magas.sorties');
    Route::get('/magas/sortie/{p_id}', 'TransactionController@sortie')->name('magas.sortie');

    Route::get('/magas/transfertINs', 'TransactionController@transfertINs')->name('magas.transfertINs');
    Route::get('/magas/transfertIN/{p_id}', 'TransactionController@transfertIN')->name('magas.transfertIN');

    Route::get('/magas/transfertOUTs', 'TransactionController@transfertOUTs')->name('magas.transfertOUTs');
    Route::get('/magas/transfertOUT/{p_id}', 'TransactionController@transfertOUT')->name('magas.transfertOUT');
    //..................................................................................................................
    //------------------------------------------------------------------------------------------------------------------

    //Promotions -------------------------------------------------------------------------------------------------------
    Route::get('/magas/promotions', 'MagasController@promotions')->name('magas.promotions');
    Route::get('/magas/promotion', 'MagasController@promotion')->name('magas.promotion');
    //------------------------------------------------------------------------------------------------------------------

    //Vente ------------------------------------------------------------------------------------------------------------
    Route::get('/magas/ventes', 'VenteController@ventes')->name('magas.ventes');
    Route::get('/magas/vente/{p_id}', 'VenteController@vente')->name('magas.vente');
    Route::get('/magas/addVente', 'MagasController@addVente')->name('magas.addVente');
    Route::post('/magas/submitAddVente', 'VenteController@submitAddVente')->name('magas.submitAddVente');

    //Client ...........................................................................................................
    Route::get('/magas/clients', 'MagasController@clients')->name('magas.clients');
    Route::get('/magas/client/{p_id}', 'MagasController@client')->name('magas.client');
    Route::get('/magas/addClient', 'AddController@addClient')->name('magas.addClient');
    Route::post('/magas/submitAddClient', 'AddController@submitAddClient')->name('magas.submitAddClient');
    Route::post('/magas/submitUpdateClient', 'UpdateController@submitUpdateClient')->name('magas.submitUpdateClient');
    //------------------------------------------------------------------------------------------------------------------

    //Promotion --------------------------------------------------------------------------------------------------------
    Route::get('/magas/promotions', 'MagasController@promotions')->name('magas.promotions');
    Route::get('/magas/promotion/{p_id}', 'MagasController@promotion')->name('magas.promotion');
    Route::get('/magas/addPromotion', 'AddController@addPromotion')->name('magas.addPromotion');
    Route::post('/magas/submitAddPromotion', 'AddController@submitAddPromotion')->name('magas.submitAddPromotion');
    Route::post('/magas/submitUpdatePromotion', 'UpdateController@submitUpdatePromotion')->name('magas.submitUpdatePromotion');
    //------------------------------------------------------------------------------------------------------------------
    //Marque -----------------------------------------------------------------------------------------------------------
    Route::get('/magas/marques', 'MagasController@marques')->name('magas.marques');
    Route::get('/magas/marque/{p_id}', 'MagasController@marque')->name('magas.marque');
    Route::get('/magas/addMarque', 'AddController@addMarque')->name('magas.addMarque');
    Route::post('/magas/submitAddMarque', 'AddController@submitAddMarque')->name('magas.submitAddMarque');
    Route::post('/magas/submitUpdateMarque', 'UpdateController@submitUpdateMarque')->name('magas.submitUpdateMarque');
    //------------------------------------------------------------------------------------------------------------------
    //Categorie --------------------------------------------------------------------------------------------------------
    Route::get('/magas/categories', 'MagasController@categories')->name('magas.categories');
    Route::get('/magas/categorie/{p_id}', 'MagasController@categorie')->name('magas.categorie');
    Route::get('/magas/addCategorie', 'AddController@addCategorie')->name('magas.addCategorie');
    Route::post('/magas/submitAddCategorie', 'AddController@submitAddCategorie')->name('magas.submitAddCategorie');
    Route::post('/magas/submitUpdateCategorie', 'UpdateController@submitUpdateCategorie')->name('magas.submitUpdateCategorie');
    //------------------------------------------------------------------------------------------------------------------
    //Fournisseur ------------------------------------------------------------------------------------------------------
    Route::get('/magas/fournisseurs', 'MagasController@fournisseurs')->name('magas.fournisseurs');
    Route::get('/magas/fournisseur/{p_id}', 'MagasController@fournisseur')->name('magas.fournisseur');
    Route::get('/magas/addFournisseur', 'AddController@addFournisseur')->name('magas.addFournisseur');
    Route::get('/magas/addAgentFournisseur/{p_id}', 'AddController@addAgentFournisseur')->name('magas.addAgentFournisseur');

    Route::post('/magas/submitAddAgent', 'AddController@submitAddAgent')->name('magas.submitAddAgent');
    Route::post('/magas/submitAddFournisseur', 'AddController@submitAddFournisseur')->name('magas.submitAddFournisseur');
    Route::post('/magas/submitUpdateFournisseurAgents', 'UpdateController@submitUpdateFournisseurAgents')->name('magas.submitUpdateFournisseurAgents');
    //------------------------------------------------------------------------------------------------------------------
    //Agent ------------------------------------------------------------------------------------------------------------
    //Route::get('/magas/agents', 'MagasController@agents')->name('magas.agents');
    Route::get('/magas/agent/{p_id}', 'MagasController@agent')->name('magas.agent');
    //Route::get('/magas/addAgent', 'AddController@addAgent')->name('magas.addAgent');
    //Route::post('/magas/submitUpdateAgent', 'UpdateController@submitUpdateAgent')->name('magas.submitUpdateAgent');
    //------------------------------------------------------------------------------------------------------------------
    //Article ----------------------------------------------------------------------------------------------------------
    Route::get('/magas/articles', 'MagasController@articles')->name('magas.articles');
    Route::get('/magas/article/{p_id}', 'MagasController@article')->name('magas.article');
    Route::get('/magas/addArticle', 'AddController@addArticle')->name('magas.addArticle');
    Route::post('/magas/submitAddArticle', 'AddController@submitAddArticle')->name('magas.submitAddArticle');
    Route::post('/magas/submitUpdateArticle', 'UpdateController@submitUpdateArticle')->name('magas.submitUpdateArticle');
    //------------------------------------------------------------------------------------------------------------------

    //Delete -----------------------------------------------------------------------------------------------------------
    Route::delete('magas/article/{id}', 'DeleteController@magasArticle')->name('magas.deleteArticle');
    Route::delete('magas/marque/{id}', 'DeleteController@magasMarque')->name('magas.deleteMarque');
    //Route::delete('magas/magasin/{id}', 'DeleteController@magasMagasin')->name('magas.deleteMagasin');
    Route::delete('magas/categorie/{id}', 'DeleteController@magasCategorie')->name('magas.deleteCategorie');
    Route::delete('magas/fournisseur/{id}', 'DeleteController@magasFournisseur')->name('magas.deleteFournisseur');
    Route::delete('magas/client/{id}', 'DeleteController@magasClient')->name('magas.deleteClient');
    //....
    //------------------------------------------------------------------------------------------------------------------

});


/***************************************
 * Vend routes protected by vendMiddleware
 ****************************************/
Route::group(['middleware' => 'vend'], function () {
    Route::get('/vend', 'VendeurController@home')->name('vend.home');
    Route::get('/vend/profile', 'VendeurController@profile')->name('vend.profile');

    //afficher le stock du magasin principal
    Route::get('/vend/stocks', 'VendeurController@stocks_V')->name('vend.main_stocks');
    Route::get('/vend/stocks/{p_id?}', 'StockController@stocks_V')->name('vend.stocks');

    //afficher un article du stock en detail
    Route::get('/vend/stock/{p_id}', 'StockController@stock')->name('vend.stock');
    //Vente
    Route::get('/vend/ventes', 'VendeurController@ventes')->name('vend.ventes');
    Route::get('/vend/vente/{p_id}', 'VendeurController@vente')->name('vend.vente');
    Route::get('/vend/addVenteSimple', 'VendeurController@addVenteSimpleV')->name('vend.addVenteSimple');
    Route::get('/vend/addVenteGros', 'VendeurController@addVenteGrosV')->name('vend.addVenteGros');
    Route::post('/vend/submitAddVente', 'VendeurController@submitAddVente')->name('vend.submitAddVente');

    //Clients
    Route::get('/vend/clients', 'VendeurController@clients')->name('vend.clients');
    Route::get('/vend/client/{p_id}', 'VendeurController@client')->name('vend.client');
    //Promotions
    Route::get('/vend/promotions', 'VendeurController@promotions')->name('vend.promotions');
    Route::get('/vend/promotion/{p_id}', 'VendeurController@promotion')->name('vend.promotion');
});


/**
 * Authentification
 **/
Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@submitLogin')->name('submitLogin');
Route::get('/logout', 'AuthController@logout')->name('logout');
/*********************************************************************************/


/**
 * Routes Delete
 **/
//Route::get('/magas/delete/{p_table}/{p_id}', 'DeleteController@delete')->name('magas.delete');
/******************************************************************************/

/**
 * Routes Excel:
 **/
Route::get('/export/{p_table}', 'ExcelController@export')->name('export');
/*********************************************************************************/


/***************************************
 * Direct routes protected by directMiddleware
 ***************************************
 * Route::group(['middleware' => 'direct'], function () {
 * Route::get('/direct', 'DirectController@home')->name('direct.home');
 * });*/
