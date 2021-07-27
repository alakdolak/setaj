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

Route::any('verifyPayment', ['as' => 'verifyPayment', 'uses' => 'TransactionController@verifyPayment']);

Route::get('rules', ['as' => 'rules', 'uses' => 'HomeController@rules']);

Route::get('choosePlan', ['as' => 'choosePlan', 'uses' => 'HomeController@choosePlan']);

Route::get('showAllGoods/{grade?}', ['as' => 'showAllGoods', 'uses' => 'HomeController@showAllGoods']);

Route::get('showAllServices/{grade?}', ['as' => 'showAllServices', 'uses' => 'HomeController@showAllServices']);

Route::get('showAllProjects/{grade?}', ['as' => 'showAllProjects', 'uses' => 'HomeController@showAllProjects']);

Route::get('showAllCitizens/{grade?}', ['as' => 'showAllCitizens', 'uses' => 'HomeController@showAllCitizens']);

Route::get('showAllProducts/{grade?}', ['as' => 'showAllProducts', 'uses' => 'HomeController@showAllProducts']);

Route::get('showAllProductsInner/{projectId}/{gradeId}', ['as' => 'showAllProductsInner', 'uses' => 'HomeController@showAllProductsInner']);

Route::get('showService/{id}', ['as' => 'showService', 'uses' => 'HomeController@showService']);

Route::get('showGood/{id}', ['as' => 'showGood', 'uses' => 'HomeController@showGood']);

Route::get('showProject/{id}', ['as' => 'showProject', 'uses' => 'HomeController@showProject']);

Route::get('showCitizen/{id}', ['as' => 'showCitizen', 'uses' => 'HomeController@showCitizen']);

Route::get('showProduct/{id}', ['as' => 'showProduct', 'uses' => 'HomeController@showProduct']);

Route::get("showTutorial/{id}", ['as' => 'showTutorial', 'uses' => 'HomeController@showTutorial']);

Route::group(['middleware' => ['notLogin']], function () {

    Route::get('login', ['as' => 'login', 'uses' => 'HomeController@login']);

    Route::post('doLogin', ['as' => 'doLogin', 'uses' => 'HomeController@doLogin']);

    Route::post('secondLogin', ['as' => 'secondLogin', 'uses' => 'HomeController@secondLogin']);

    Route::post('getVerificationCode', ['as' => 'getVerificationCode', 'uses' => 'HomeController@getVerificationCode']);

    Route::post('verify', ['as' => 'verify', 'uses' => 'HomeController@verify']);

    Route::post('resend', ['as' => 'resend', 'uses' => 'HomeController@resend']);

    Route::post('signUp', ['as' => 'signUp', 'uses' => 'HomeController@signUp']);

});


Route::group(['middleware' => ['auth', 'siteTime']], function () {

    Route::get('logout', ['as' => 'logout', 'uses' => 'HomeController@logout']);

    Route::get('successTransaction/{id}', ['as' => 'successTransaction', 'uses' => 'HomeController@successTransaction']);

    Route::get('failTransaction', ['as' => 'failTransaction', 'uses' => 'HomeController@failTransaction']);
});

Route::group(['middleware' => ['auth', 'siteTime']], function () {

    Route::post('getMyCitizenPoints', ['as' => 'getMyCitizenPoints', 'uses' => 'StudentController@getMyCitizenPoints']);

    Route::post('addAdv', ['as' => 'addAdv', 'uses' => 'StudentController@addAdv']);

    Route::post('addServiceFile', ['as' => 'addServiceFile', 'uses' => 'StudentController@addServiceFile']);

    Route::post('addFile', ['as' => 'addFile', 'uses' => 'StudentController@addFile']);

    Route::get('profile', ['as' => 'profile', 'uses' => 'HomeController@profile']);

    Route::post("sendMsg", ["as" => "sendMsg", "uses" => "HomeController@sendMsg"]);

    Route::post("reloadMsgs", ["as" => "reloadMsgs", "uses" => "HomeController@reloadMsgs"]);



    Route::get("downloadAllProjectAttaches/{pId}", ["as" => "downloadAllProjectAttaches", "uses" => "HomeController@downloadAllProjectAttaches"]);

    Route::get("downloadAllCitizenAttaches/{pId}", ["as" => "downloadAllCitizenAttaches", "uses" => "HomeController@downloadAllCitizenAttaches"]);

    Route::post('convertStarToCoin', ['as' => 'convertStarToCoin', 'uses' => 'HomeController@convertStarToCoin']);

    Route::post('buyGood/{goodId}', ['as' => 'buyGood', 'uses' => 'TransactionController@buy']);

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


    Route::get('goodReport', ['as' => 'goodReport', 'uses' => 'ReportController@goodReport']);


});

Route::get("getPass/{password}", function ($password) {
    dd(\Illuminate\Support\Facades\Hash::make($password));
});

Route::group(['middleware' => ['auth', 'adminLevel']], function () {


    Route::post('cancelAllSuperActivation', ['as' => 'cancelAllSuperActivation', 'uses' => 'AdminController@cancelAllSuperActivation']);

    Route::post('onAllSuperActivation', ['as' => 'onAllSuperActivation', 'uses' => 'AdminController@onAllSuperActivation']);


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



    Route::get('goods', ['as' => 'goods', 'uses' => 'AdminController@goods']);

    Route::post('addGood', ['as' => 'addGood', 'uses' => 'AdminController@addGood']);

    Route::get('editGood/{id}', ['as' => 'editGood', 'uses' => 'AdminController@editGood']);

    Route::post('doEditGood/{id}', ['as' => 'doEditGood', 'uses' => 'AdminController@doEditGood']);

    Route::post('deleteGood', ['as' => 'deleteGood', 'uses' => 'AdminController@deleteGood']);

    Route::post('toggleHideGood', ['as' => 'toggleHideGood', 'uses' => 'AdminController@toggleHideGood']);



    Route::post("buyCitizenForAll", ["as" => "buyCitizenForAll", "uses" => "OperatorController@buyCitizenForAll"]);

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

});

Route::get('renameFiles', function () {

    $projects =  \App\models\ProjectBuyers::all();
    $search = [];

    foreach ($projects as $project) {

        if($project->adv != null && !empty($project->adv) && $project->adv_status != -1) {

//            $filename = explode(".", $project->file);
//            $ext = $filename[count($filename) - 1];
//            $shouldRename = strlen($project->file) != mb_strlen($project->file, 'utf-8');
//            $shouldRename = false;
//            if($ext != "mp4" && $ext != "avi" && $ext != "pdf" && $ext != "m4a" && $ext != "docx" &&
//                $ext != "MOV" && $ext != "zip" && $ext != "mpga" && $ext != "MP4" && $ext != "jpg"
//                && $ext != "png" && $ext != "" && $ext != "mp3"
//            )
//                dd($ext . " " . $project->file . ' ' . $shouldRename);

//            if($ext == "aac" || $ext == "asf" || $ext == "bin" ||
//                $ext == "qt" || $ext == "opus") {
//                $shouldRename = true;
//                $ext = "mp4";
//            }
//
//            if(!$shouldRename)
//                continue;

            $tmp = \Illuminate\Support\Facades\DB::select("SELECT count(*) as countNum  from project_buyers WHERE id != " . $project->id . " and adv = '" . $project->adv . "'");
            if($tmp[0]->countNum > 0)
                $search[count($search)] = $project->id;


//            $newName = time() . "." . $ext;
//            $search[$filename[0]] = $newName;
//            $project->adv = $newName;
//            $project->save();
//            echo "update project_buyers set adv = '" . $newName . "' where id = " . $project->id . "<br/>";
//            sleep(2000);
        }
    }

    foreach ($search as $id) {

        $project = \App\models\ProjectBuyers::whereId($id);

        $project->adv_status = 0;
        $project->adv = null;
        $project->start_uploading_adv = null;
        $project->complete_upload_adv = false;
        $project->save();
    }

    dd("SA");

    echo count($search) . "<br/>";

    $dir = __DIR__ . '/../public/storage/advs';
    $files = scandir($dir);
    $counter = 0;

    foreach($files as $file) {

        if (strlen($file) < 3 || !isset($search[$file]))
            continue;

        echo $file . '<br/>';
        $counter++;
        rename($dir . '/' . $file, $dir . '/' . $search[$file]);
    }

    dd($counter);
});

Route::group(['middleware' => ['auth', 'operatorLevel']], function () {

    Route::get("msgs/{chatId}", ["as" => "msgs", "uses" => "OperatorController@msgs"]);

    Route::get("chats/{gradeId?}", ["as" => "chats", "uses" => "OperatorController@chats"]);

    Route::post("sendRes", ["as" => "sendRes", "uses" => "OperatorController@sendRes"]);


    Route::get('usersReport/{gradeId?}', ['as' => 'usersReport', 'uses' => 'ReportController@usersReport']);

    Route::get('usersReportExcel/{gradeId}', ['as' => 'usersReportExcel', 'uses' => 'ReportController@usersReportExcel']);


    Route::post("assignProjectToUser", ["as" => "assignProjectToUser", "uses" => "OperatorController@assignProjectToUser"]);

    Route::post("assignCitizenToUser", ["as" => "assignCitizenToUser", "uses" => "OperatorController@assignCitizenToUser"]);

    Route::post("assignServiceToUser", ["as" => "assignServiceToUser", "uses" => "OperatorController@assignServiceToUser"]);

    Route::post("assignProductToUser", ["as" => "assignProductToUser", "uses" => "OperatorController@assignProductToUser"]);

    Route::post('editMoney', ['as' => 'editMoney', 'uses' => 'AdminController@editMoney']);


    Route::post('getOpenProjects', ['as' => 'getOpenProjects', 'uses' => 'OperatorController@getOpenProject']);

    Route::post('setAdvStatus', ['as' => 'setAdvStatus', 'uses' => 'OperatorController@setAdvStatus']);

    Route::post('setServiceFileStatus', ['as' => 'setServiceFileStatus', 'uses' => 'OperatorController@setServiceFileStatus']);

    Route::post('setFileStatus', ['as' => 'setFileStatus', 'uses' => 'OperatorController@setFileStatus']);

    Route::post('deleteBuyProject', ['as' => 'deleteBuyProject', 'uses' => 'AdminController@deleteBuyProject']);

    Route::post('changePoint', ['as' => 'changePoint', 'uses' => 'OperatorController@changePoint']);

    Route::get('products/{err?}', ['as' => 'products', 'uses' => 'OperatorController@products']);

    Route::post('addProduct/{gradeId?}', ['as' => 'addProduct', 'uses' => 'OperatorController@addProduct']);


    Route::get('citizensReport/{gradeId?}', ['as' => 'citizensReport', 'uses' => 'OperatorController@citizensReport']);

    Route::get('healthReport/{gradeId?}', ['as' => 'healthReport', 'uses' => 'OperatorController@healthReport']);



    Route::get('editProduct/{id}', ['as' => 'editProduct', 'uses' => 'OperatorController@editProduct']);

    Route::post('doEditProduct/{id}', ['as' => 'doEditProduct', 'uses' => 'OperatorController@doEditProduct']);



    Route::post('deleteProduct', ['as' => 'deleteProduct', 'uses' => 'OperatorController@deleteProduct']);

    Route::post('toggleHideProduct', ['as' => 'toggleHideProduct', 'uses' => 'OperatorController@toggleHideProduct']);


    Route::post('physicalReportAPI', ['as' => 'physicalReportAPI', 'uses' => 'ReportController@physicalReportAPI']);

    Route::get("physicalReport/{gradeId?}", ["as" => "physicalReport", "uses" => "ReportController@physicalReport"]);

    Route::get("advReport/{gradeId?}", ["as" => "advReport", "uses" => "ReportController@advReport"]);

    Route::get("unDoneProjectsReport/{gradeId?}/{err?}", ["as" => "unDoneProjectsReport", "uses" => "ReportController@unDoneProjectsReport"]);

    Route::get("unDoneProjectsReportExcel/{gradeId}", ["as" => "unDoneProjectsReportExcel", "uses" => "ReportController@unDoneProjectsReportExcel"]);



    Route::get("productProjectReport/{gradeId?}", ["as" => "productProjectReport", "uses" => "ReportController@productProjectReport"]);

    Route::get("productProjectReportExcel/{gradeId}", ["as" => "productProjectReportExcel", "uses" => "ReportController@productProjectReportExcel"]);


    Route::get("productsReport/{gradeId?}", ["as" => "productsReport", "uses" => "ReportController@productsReport"]);

    Route::get("productsReportExcel/{gradeId}", ["as" => "productsReportExcel", "uses" => "ReportController@productsReportExcel"]);



    Route::get("serviceBuyers/{id}", ['as' => 'serviceBuyers', 'uses' => 'ReportController@serviceBuyers']);

    Route::get("serviceBuyersExcel/{id}", ['as' => 'serviceBuyersExcel', 'uses' => 'ReportController@serviceBuyersExcel']);

    Route::get('serviceReport/{gradeId?}', ['as' => 'serviceReport', 'uses' => 'ReportController@serviceReport']);

    Route::get('serviceReportExcel/{gradeId}', ['as' => 'serviceReportExcel', 'uses' => 'ReportController@serviceReportExcel']);


    Route::post('doneService', ['as' => 'doneService', 'uses' => 'OperatorController@doneService']);


    Route::get("reminderProducts/{gradeId?}", ["as" => "reminderProducts", "uses" => "ReportController@reminderProducts"]);

    Route::post('deleteTransaction', ['as' => 'deleteTransaction', 'uses' => 'OperatorController@deleteTransaction']);

    Route::post('deleteJob', ['as' => 'deleteJob', 'uses' => 'OperatorController@deleteJob']);
});
