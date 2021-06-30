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


Route::get('/', ['as' => 'home', 'uses' => 'HomeController@choosePlan']);

Route::get('faq', ['as' => 'faq', 'uses' => 'HomeController@faq']);

Route::get('contactUs', ['as' => 'contactUs', 'uses' => 'HomeController@contactUs']);

Route::get('rules', ['as' => 'rules', 'uses' => 'HomeController@rules']);

Route::get('choosePlan', ['as' => 'choosePlan', 'uses' => 'HomeController@choosePlan']);

Route::get('showAllServices/{grade?}', ['as' => 'showAllServices', 'uses' => 'HomeController@showAllServices']);

Route::get('showAllProjects/{grade?}', ['as' => 'showAllProjects', 'uses' => 'HomeController@showAllProjects']);

Route::get('showAllCitizens/{grade?}', ['as' => 'showAllCitizens', 'uses' => 'HomeController@showAllCitizens']);

Route::get('showAllProducts/{grade?}', ['as' => 'showAllProducts', 'uses' => 'HomeController@showAllProducts']);

Route::get('showAllProductsInner/{projectId}/{gradeId}', ['as' => 'showAllProductsInner', 'uses' => 'HomeController@showAllProductsInner']);

Route::get('showService/{id}', ['as' => 'showService', 'uses' => 'HomeController@showService']);

Route::get('showProject/{id}', ['as' => 'showProject', 'uses' => 'HomeController@showProject']);

Route::get('showCitizen/{id}', ['as' => 'showCitizen', 'uses' => 'HomeController@showCitizen']);

Route::get('showProduct/{id}', ['as' => 'showProduct', 'uses' => 'HomeController@showProduct']);

Route::get("showTutorial/{id}", ['as' => 'showTutorial', 'uses' => 'HomeController@showTutorial']);

Route::group(['middleware' => ['notLogin']], function () {

    Route::get('login', ['as' => 'login', 'uses' => 'HomeController@login']);

    Route::post('doLogin', ['as' => 'doLogin', 'uses' => 'HomeController@doLogin']);

});


Route::group(['middleware' => ['auth', 'siteTime']], function () {

    Route::get('logout', ['as' => 'logout', 'uses' => 'HomeController@logout']);

});

Route::group(['middleware' => ['auth', 'siteTime']], function () {

    Route::post('getMyCitizenPoints', ['as' => 'getMyCitizenPoints', 'uses' => 'StudentController@getMyCitizenPoints']);

    Route::post('addAdv', ['as' => 'addAdv', 'uses' => 'StudentController@addAdv']);

    Route::post('addFile', ['as' => 'addFile', 'uses' => 'StudentController@addFile']);

    Route::get('profile', ['as' => 'profile', 'uses' => 'HomeController@profile']);

    Route::post("sendMsg", ["as" => "sendMsg", "uses" => "HomeController@sendMsg"]);

    Route::post("reloadMsgs", ["as" => "reloadMsgs", "uses" => "HomeController@reloadMsgs"]);



    Route::get("downloadAllProjectAttaches/{pId}", ["as" => "downloadAllProjectAttaches", "uses" => "HomeController@downloadAllProjectAttaches"]);

    Route::get("downloadAllCitizenAttaches/{pId}", ["as" => "downloadAllCitizenAttaches", "uses" => "HomeController@downloadAllCitizenAttaches"]);

    Route::post('convertStarToCoin', ['as' => 'convertStarToCoin', 'uses' => 'HomeController@convertStarToCoin']);

    Route::post('buyUnPhysicalProduct', ['as' => 'buyUnPhysicalProduct', 'uses' => 'HomeController@buyUnPhysicalProduct']);

    Route::post('buyProject', ['as' => 'buyProject', 'uses' => 'HomeController@buyProject']);

    Route::post('buyCitizen', ['as' => 'buyCitizen', 'uses' => 'HomeController@buyCitizen']);

    Route::post('buyProduct', ['as' => 'buyProduct', 'uses' => 'HomeController@buyProduct']);

    Route::post('buyService', ['as' => 'buyService', 'uses' => 'HomeController@buyService']);


    Route::get('myProjects', ['as' => 'myProjects', 'uses' => 'HomeController@myProjects']);

    Route::get('myProducts', ['as' => 'myProducts', 'uses' => 'HomeController@myProducts']);

    Route::get('myServices', ['as' => 'myServices', 'uses' => 'HomeController@myServices']);
});

Route::group(['middleware' => ['auth', 'adminLevel']], function () {


    Route::get("admin", function () {
        return view('adminProfile');
    });

    Route::get('tutorials', ['as' => 'tutorials', 'uses' => 'AdminController@tutorials']);

    Route::get('editTutorial/{id}', ['as' => 'editTutorial', 'uses' => 'AdminController@editTutorial']);

    Route::post('doEditTutorial/{id}', ['as' => 'doEditTutorial', 'uses' => 'AdminController@doEditTutorial']);

    Route::delete('tutorial/{id}', ['as' => 'deleteTutorial', 'uses' => 'AdminController@deleteTutorial']);

    Route::post('addTutorial', ['as' => 'addTutorial', 'uses' => 'AdminController@addTutorial']);


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

    Route::post('addOperators', ['as' => 'addOperators', 'uses' => 'AdminController@addOperators']);


});

Route::group(['middleware' => ['auth', 'adminLevel']], function () {

    Route::get('usersReport/{gradeId?}', ['as' => 'usersReport', 'uses' => 'ReportController@usersReport']);

    Route::get('usersReportExcel/{gradeId}', ['as' => 'usersReportExcel', 'uses' => 'ReportController@usersReportExcel']);


    Route::post("assignProjectToUser", ["as" => "assignProjectToUser", "uses" => "OperatorController@assignProjectToUser"]);

    Route::post("assignServiceToUser", ["as" => "assignServiceToUser", "uses" => "OperatorController@assignServiceToUser"]);

    Route::post("assignProductToUser", ["as" => "assignProductToUser", "uses" => "OperatorController@assignProductToUser"]);



    Route::post('cancelAllSuperActivation', ['as' => 'cancelAllSuperActivation', 'uses' => 'AdminController@cancelAllSuperActivation']);

    Route::post('onAllSuperActivation', ['as' => 'onAllSuperActivation', 'uses' => 'AdminController@onAllSuperActivation']);



    Route::get('userBookmarks/{uId}', ['as' => 'userBookmarks', 'uses' => 'ReportController@userBookmarks']);

    Route::post('editMoney', ['as' => 'editMoney', 'uses' => 'AdminController@editMoney']);



    Route::post('addTagProject', ['as' => 'addTagProject', 'uses' => 'OperatorController@addTagProject']);

    Route::post('deleteTagProject', ['as' => 'deleteTagProject', 'uses' => 'OperatorController@deleteTagProject']);



    Route::get('services/{err?}', ['as' => 'services', 'uses' => 'OperatorController@services']);

    Route::post('addService', ['as' => 'addService', 'uses' => 'OperatorController@addService']);


    Route::get('editService/{id}', ['as' => 'editService', 'uses' => 'OperatorController@editService']);

    Route::post('doEditService/{id}', ['as' => 'doEditService', 'uses' => 'OperatorController@doEditService']);



    Route::get('projects', ['as' => 'projects', 'uses' => 'OperatorController@projects']);

    Route::post('addProject', ['as' => 'addProject', 'uses' => 'OperatorController@addProject']);

    Route::get('editProject/{id}', ['as' => 'editProject', 'uses' => 'OperatorController@editProject']);

    Route::post('doEditProject/{id}', ['as' => 'doEditProject', 'uses' => 'OperatorController@doEditProject']);

    Route::post('deleteProject', ['as' => 'deleteProject', 'uses' => 'OperatorController@deleteProject']);



    Route::get('citizens', ['as' => 'citizens', 'uses' => 'OperatorController@citizens']);

    Route::post('addCitizen', ['as' => 'addCitizen', 'uses' => 'OperatorController@addCitizen']);

    Route::get('editCitizen/{id}', ['as' => 'editCitizen', 'uses' => 'OperatorController@editCitizen']);

    Route::post('doEditCitizen/{id}', ['as' => 'doEditCitizen', 'uses' => 'OperatorController@doEditCitizen']);

    Route::post('deleteCitizen', ['as' => 'deleteCitizen', 'uses' => 'OperatorController@deleteCitizen']);



    Route::post('deleteService', ['as' => 'deleteService', 'uses' => 'OperatorController@deleteService']);


    Route::post('toggleHideProject', ['as' => 'toggleHideProject', 'uses' => 'OperatorController@toggleHideProject']);

    Route::post('toggleHideCitizen', ['as' => 'toggleHideCitizen', 'uses' => 'OperatorController@toggleHideCitizen']);


    Route::post('toggleHideService', ['as' => 'toggleHideService', 'uses' => 'OperatorController@toggleHideService']);



    Route::post('addGradeProject', ['as' => 'addGradeProject', 'uses' => 'OperatorController@addGradeProject']);

    Route::post('deleteGradeProject', ['as' => 'deleteGradeProject', 'uses' => 'OperatorController@deleteGradeProject']);


    Route::post('addGradeCitizen', ['as' => 'addGradeCitizen', 'uses' => 'OperatorController@addGradeCitizen']);

    Route::post('deleteGradeCitizen', ['as' => 'deleteGradeCitizen', 'uses' => 'OperatorController@deleteGradeCitizen']);



    Route::post('addGradeService', ['as' => 'addGradeService', 'uses' => 'OperatorController@addGradeService']);

    Route::post('deleteGradeService', ['as' => 'deleteGradeService', 'uses' => 'OperatorController@deleteGradeService']);



    Route::get("operators", ["as" => "operators", 'uses' => "ReportController@operators"]);


    Route::get("msgs/{chatId}", ["as" => "msgs", "uses" => "OperatorController@msgs"]);

    Route::get("chats", ["as" => "chats", "uses" => "OperatorController@chats"]);

    Route::post("sendRes", ["as" => "sendRes", "uses" => "OperatorController@sendRes"]);

});

Route::group(['middleware' => ['auth', 'operatorLevel']], function () {

    Route::post('getOpenProjects', ['as' => 'getOpenProjects', 'uses' => 'OperatorController@getOpenProject']);

    Route::post('setAdvStatus', ['as' => 'setAdvStatus', 'uses' => 'OperatorController@setAdvStatus']);

    Route::post('setFileStatus', ['as' => 'setFileStatus', 'uses' => 'OperatorController@setFileStatus']);

    Route::post('deleteBuyProject', ['as' => 'deleteBuyProject', 'uses' => 'AdminController@deleteBuyProject']);

    Route::post('changePoint', ['as' => 'changePoint', 'uses' => 'OperatorController@changePoint']);

    Route::get('products/{err?}', ['as' => 'products', 'uses' => 'OperatorController@products']);

    Route::post('addProduct', ['as' => 'addProduct', 'uses' => 'OperatorController@addProduct']);


    Route::get('citizensReport', ['as' => 'citizensReport', 'uses' => 'OperatorController@citizensReport']);

    Route::get('healthReport/{gradeId?}', ['as' => 'healthReport', 'uses' => 'OperatorController@healthReport']);



    Route::get('editProduct/{id}', ['as' => 'editProduct', 'uses' => 'OperatorController@editProduct']);

    Route::post('doEditProduct/{id}', ['as' => 'doEditProduct', 'uses' => 'OperatorController@doEditProduct']);



    Route::post('deleteProduct', ['as' => 'deleteProduct', 'uses' => 'OperatorController@deleteProduct']);

    Route::post('toggleHideProduct', ['as' => 'toggleHideProduct', 'uses' => 'OperatorController@toggleHideProduct']);


    Route::post('physicalReportAPI', ['as' => 'physicalReportAPI', 'uses' => 'ReportController@physicalReportAPI']);

    Route::get("physicalReport/{gradeId?}", ["as" => "physicalReport", "uses" => "ReportController@physicalReport"]);

    Route::get("unDoneProjectsReport/{gradeId?}/{pre?}", ["as" => "unDoneProjectsReport", "uses" => "ReportController@unDoneProjectsReport"]);

    Route::get("unDoneProjectsReportExcel/{gradeId}", ["as" => "unDoneProjectsReportExcel", "uses" => "ReportController@unDoneProjectsReportExcel"]);



    Route::get("productProjectReport/{gradeId?}", ["as" => "productProjectReport", "uses" => "ReportController@productProjectReport"]);

    Route::get("productProjectReportExcel/{gradeId}", ["as" => "productProjectReportExcel", "uses" => "ReportController@productProjectReportExcel"]);


    Route::get("productsReport/{gradeId?}", ["as" => "productsReport", "uses" => "ReportController@productsReport"]);

    Route::get("productsReportExcel/{gradeId}", ["as" => "productsReportExcel", "uses" => "ReportController@productsReportExcel"]);



    Route::get("serviceBuyers/{id}", ['as' => 'serviceBuyers', 'uses' => 'ReportController@serviceBuyers']);

    Route::get("serviceBuyersExcel/{id}", ['as' => 'serviceBuyersExcel', 'uses' => 'ReportController@serviceBuyersExcel']);

    Route::get('serviceReport', ['as' => 'serviceReport', 'uses' => 'ReportController@serviceReport']);



    Route::post('doneService', ['as' => 'doneService', 'uses' => 'OperatorController@doneService']);


    Route::get("reminderProducts/{gradeId?}", ["as" => "reminderProducts", "uses" => "ReportController@reminderProducts"]);

    Route::post('deleteTransaction', ['as' => 'deleteTransaction', 'uses' => 'OperatorController@deleteTransaction']);

    Route::post('deleteJob', ['as' => 'deleteJob', 'uses' => 'OperatorController@deleteJob']);
});
