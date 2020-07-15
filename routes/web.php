<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@home']);

Route::get('faq', ['as' => 'faq', 'uses' => 'HomeController@faq']);

Route::get('contactUs', ['as' => 'contactUs', 'uses' => 'HomeController@contactUs']);

Route::get('rules', ['as' => 'rules', 'uses' => 'HomeController@rules']);



Route::group(['middleware' => ['notLogin']], function () {

    Route::get('login', ['as' => 'login', 'uses' => 'HomeController@login']);

    Route::post('doLogin', ['as' => 'doLogin', 'uses' => 'HomeController@doLogin']);

});

Route::group(['middleware' => ['auth', 'siteTime']], function () {

    Route::get('logout', ['as' => 'logout', 'uses' => 'HomeController@logout']);

    Route::get('choosePlan', ['as' => 'choosePlan', 'uses' => 'HomeController@choosePlan']);

    Route::get('profile', ['as' => 'profile', 'uses' => 'HomeController@profile']);

    Route::get('bookmarks/{mode}', ['as' => 'bookmarks', 'uses' => 'HomeController@bookmarks']);

    Route::post('bookmark', ['as' => 'bookmark', 'uses' => 'HomeController@bookmark']);

    Route::post('like', ['as' => 'like', 'uses' => 'HomeController@like']);

    Route::post("sendMsg", ["as" => "sendMsg", "uses" => "HomeController@sendMsg"]);

    Route::post("reloadMsgs", ["as" => "reloadMsgs", "uses" => "HomeController@reloadMsgs"]);



    Route::get('showAllServices', ['as' => 'showAllServices', 'uses' => 'HomeController@showAllServices']);

    Route::get('showService/{id}', ['as' => 'showService', 'uses' => 'HomeController@showService']);


    Route::get('showAllProjects', ['as' => 'showAllProjects', 'uses' => 'HomeController@showAllProjects']);

    Route::get('showProject/{id}', ['as' => 'showProject', 'uses' => 'HomeController@showProject']);



    Route::get('showProduct/{id}', ['as' => 'showProduct', 'uses' => 'HomeController@showProduct']);

    Route::get('showAllProducts', ['as' => 'showAllProducts', 'uses' => 'HomeController@showAllProducts']);



    Route::post('convertStarToCoin', ['as' => 'convertStarToCoin', 'uses' => 'HomeController@convertStarToCoin']);


    Route::post('buyProject', ['as' => 'buyProject', 'uses' => 'HomeController@buyProject']);

    Route::post('buyProduct', ['as' => 'buyProduct', 'uses' => 'HomeController@buyProduct']);

    Route::post('buyService', ['as' => 'buyService', 'uses' => 'HomeController@buyService']);


    Route::get('myProjects', ['as' => 'myProjects', 'uses' => 'HomeController@myProjects']);

    Route::get('myProducts', ['as' => 'myProducts', 'uses' => 'HomeController@myProducts']);

    Route::get('myServices', ['as' => 'myServices', 'uses' => 'HomeController@myServices']);
});

Route::group(['middleware' => ['auth', 'adminLevel']], function () {

    Route::get('config', ['as' => 'config', 'uses' => 'AdminController@config']);

    Route::post('doConfig', ['as' => 'doConfig', 'uses' => 'AdminController@doConfig']);

    Route::post('toggleStatusUser', ['as' => 'toggleStatusUser', 'uses' => 'AdminController@toggleStatusUser']);

    Route::post('toggleSuperStatusUser', ['as' => 'toggleSuperStatusUser', 'uses' => 'AdminController@toggleSuperStatusUser']);



    Route::get('userServices/{uId}', ['as' => 'userServices', 'uses' => 'ReportController@userServices']);

    Route::get('userProjects/{uId}', ['as' => 'userProjects', 'uses' => 'ReportController@userProjects']);

    Route::get('userBuys/{uId}', ['as' => 'userBuys', 'uses' => 'ReportController@userBuys']);



    Route::get('commonQuestionsPanel', ['as' => 'commonQuestionsPanel', 'uses' => 'AdminController@commonQuestionsPanel']);

    Route::post('addCommonQuestion', ['as' => 'addCommonQuestion', 'uses' => 'AdminController@addCommonQuestion']);

    Route::post('deleteCommonQuestion', ['as' => 'deleteCommonQuestion', 'uses' => 'AdminController@deleteCommonQuestion']);

    Route::get('faqCategories', ['as' => 'faqCategories', 'uses' => 'AdminController@faqCategories']);

    Route::post('addFaqCategory', ['as' => 'addFaqCategory', 'uses' => 'AdminController@addFaqCategory']);

    Route::post('deleteFaqCategory', ['as' => 'deleteFaqCategory', 'uses' => 'AdminController@deleteFaqCategory']);

    Route::post('editFaqCategory', ['as' => 'editFaqCategory', 'uses' => 'AdminController@editFaqCategory']);


    Route::get('grades', ['as' => 'grades', 'uses' => 'AdminController@grades']);

    Route::post('addGrade', ['as' => 'addGrade', 'uses' => 'AdminController@addGrade']);

    Route::post('deleteGrade', ['as' => 'deleteGrade', 'uses' => 'AdminController@deleteGrade']);

    Route::post('editGrade', ['as' => 'editGrade', 'uses' => 'AdminController@editGrade']);



    Route::get('tags', ['as' => 'tags', 'uses' => 'AdminController@tags']);

    Route::post('addTag', ['as' => 'addTag', 'uses' => 'AdminController@addTag']);

    Route::post('deleteTag', ['as' => 'deleteTag', 'uses' => 'AdminController@deleteTag']);

    Route::post('editTag', ['as' => 'editTag', 'uses' => 'AdminController@editTag']);



    Route::post('addUsers/{gradeId}', ['as' => 'addUsers', 'uses' => 'AdminController@addUsers']);

});

Route::group(['middleware' => ['auth', 'adminLevel']], function () {

    Route::get('usersReport/{gradeId?}', ['as' => 'usersReport', 'uses' => 'ReportController@usersReport']);

    Route::get('userBookmarks/{uId}', ['as' => 'userBookmarks', 'uses' => 'ReportController@userBookmarks']);

    Route::post('editMoney', ['as' => 'editMoney', 'uses' => 'AdminController@editMoney']);


});

Route::group(['middleware' => ['auth', 'operatorLevel']], function () {

    Route::get('products/{err?}', ['as' => 'products', 'uses' => 'OperatorController@products']);

    Route::post('addProduct', ['as' => 'addProduct', 'uses' => 'OperatorController@addProduct']);

    Route::post('editProduct', ['as' => 'editProduct', 'uses' => 'OperatorController@editProduct']);


    Route::get('services/{err?}', ['as' => 'services', 'uses' => 'OperatorController@services']);

    Route::post('addService', ['as' => 'addService', 'uses' => 'OperatorController@addService']);

    Route::post('editService', ['as' => 'editService', 'uses' => 'OperatorController@editService']);

    Route::post('doneService', ['as' => 'doneService', 'uses' => 'OperatorController@doneService']);


    Route::get('projects', ['as' => 'projects', 'uses' => 'OperatorController@projects']);

    Route::post('addProject', ['as' => 'addProject', 'uses' => 'OperatorController@addProject']);

    Route::get('editProject', ['as' => 'editProject', 'uses' => 'OperatorController@editProject']);

    Route::post('doEditProject', ['as' => 'doEditProject', 'uses' => 'OperatorController@doEditProject']);



    Route::post('deleteProduct', ['as' => 'deleteProduct', 'uses' => 'OperatorController@deleteProduct']);

    Route::post('deleteProject', ['as' => 'deleteProject', 'uses' => 'OperatorController@deleteProject']);

    Route::post('deleteService', ['as' => 'deleteService', 'uses' => 'OperatorController@deleteService']);


    Route::post('toggleHideProject', ['as' => 'toggleHideProject', 'uses' => 'OperatorController@toggleHideProject']);

    Route::post('toggleHideProduct', ['as' => 'toggleHideProduct', 'uses' => 'OperatorController@toggleHideProduct']);

    Route::post('toggleHideService', ['as' => 'toggleHideService', 'uses' => 'OperatorController@toggleHideService']);

    Route::post('getOpenProject', ['as' => 'getOpenProject', 'uses' => 'OperatorController@getOpenProject']);




    Route::post('addGradeProject', ['as' => 'addGradeProject', 'uses' => 'OperatorController@addGradeProject']);

    Route::post('deleteGradeProject', ['as' => 'deleteGradeProject', 'uses' => 'OperatorController@deleteGradeProject']);



    Route::post('addGradeService', ['as' => 'addGradeService', 'uses' => 'OperatorController@addGradeService']);

    Route::post('deleteGradeService', ['as' => 'deleteGradeService', 'uses' => 'OperatorController@deleteGradeService']);



    Route::post('addTagProject', ['as' => 'addTagProject', 'uses' => 'OperatorController@addTagProject']);

    Route::post('deleteTagProject', ['as' => 'deleteTagProject', 'uses' => 'OperatorController@deleteTagProject']);


    Route::get("msgs/{chatId}", ["as" => "msgs", "uses" => "OperatorController@msgs"]);

    Route::get("chats", ["as" => "chats", "uses" => "OperatorController@chats"]);

    Route::post("sendRes", ["as" => "sendRes", "uses" => "OperatorController@sendRes"]);


    Route::get("unDoneProjectsReport/{gradeId?}", ["as" => "unDoneProjectsReport", "uses" => "ReportController@unDoneProjectsReport"]);

    Route::get("productProjectReport/{gradeId?}", ["as" => "productProjectReport", "uses" => "ReportController@productProjectReport"]);

    Route::get("productsReport/{gradeId?}", ["as" => "productsReport", "uses" => "ReportController@productsReport"]);

});
