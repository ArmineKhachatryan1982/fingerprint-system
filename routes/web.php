<?php

use App\Events\testingEvent;
use App\Http\Controllers\Absence\AbsenceController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\AttendansSheetEnterTimeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChangeStatusController;
use App\Http\Controllers\Component\ClientComponentController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\DeleteItemController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\EntryCode\EntryCodeCreateController;
use App\Http\Controllers\EntryCode\EntryCodeEditController;
use App\Http\Controllers\EntryCode\EntryCodeListController;
use App\Http\Controllers\EntryCode\EntryCodeStoreController;
use App\Http\Controllers\EntryCode\EntryCodeUpdateController;
use App\Http\Controllers\ExpertPersonDayScheduleController;
use App\Http\Controllers\GetCalendarDataController;
use App\Http\Controllers\GetDayReservationsController;
use App\Http\Controllers\People\PeopleController;
use App\Http\Controllers\People\PeoplelistController;
use App\Http\Controllers\PersonPermission\PersonPermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportEnterExitController;
use App\Http\Controllers\ReportEnterExitExportController;
use App\Http\Controllers\ReportFilterController;
use App\Http\Controllers\ReportFilterExportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Schedule\ScheduleController;
use App\Http\Controllers\Schedule\ScheduleDetailsController;
use App\Http\Controllers\Supervised\SupervicedController;
use App\Http\Controllers\UserController;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::controller(ActionController::class)->group(function () {
//     // Route::get('/', 'index')->name('reaction.index');
//     Route::post('/action', 'action')->name('reaction.action');
// });

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    // Route::post('store-user', [UserController::class,'store']);
    Route::resource('products', ProductController::class);

    Route::group(['prefix'=>'entry-code'],function(){

        Route::get('/list', [EntryCodeListController::class,'index'])->name('entry-codes-list');
        Route::get('/create',EntryCodeCreateController::class)->name('entry-codes-create');
        Route::post('/store', [EntryCodeStoreController::class,'store'])->name('entry-codes-store');
        Route::get('/edit/{id}',[EntryCodeEditController::class,'edit'])->name('entry-codes-edit');
        Route::put('/update/{id}',[EntryCodeUpdateController::class,'update'])->name('entry_codes-update');
        Route::get('/test',function(){
            event(new testingEvent('Hello Armine'));
            return 'done';
        });


    });
    Route::post('/change-status', [ChangeStatusController::class, 'change_status'])->name('change_status');
    Route::post('/change-person-permission-entry-code',[PersonPermissionController::class,'changeEntryCode']);

    Route::post('/client-component', [ClientComponentController::class, 'component'])->name('client.component');
    // =======Calendar=======================
    Route::get('/calendar/{id}',CalendarController::class)->name('calendar');
    Route::get('calendar-data/{id}', GetCalendarDataController::class);
    Route::get('get-day-reservations/{person}/{date}', GetDayReservationsController::class);


    // ========People==========================
    Route::resource('people', PeopleController::class);
    Route::get('delete-item/{tb_name}/{id}', [DeleteItemController::class, 'index'])->name('delete_item');
    Route::get('report-list',[ReportController::class,'index'])->name('reportList');
    Route::get('report-list-armobile',[ReportController::class,'index_armobile'])->name('reportListArmobile');

    // ====ARMOBILE=============hatuk
    Route::post('supervised',[SupervicedController::class,'superviced_person']);
    Route::get('supervised-staff',[SupervicedController:: class,'supervised_staff'])->name('supervisedStaff');
    Route::post('delete-superviced',[SupervicedController::class,'delete']);

    // =====schedule============
    Route::group(['prefix'=>'schedule'],function(){
        Route::get('list',[ScheduleController::class,'index'])->name('schedule.list');
        Route::get('createNew',[ScheduleController::class,'createScheduleNameNew'])->name('schedule.createNew');
        Route::get('create',[ScheduleController::class,'createScheduleName'])->name('schedule.create');
        Route::post('store',[ScheduleController::class,'storeScheduleName'])->name('schedule.store');
        Route::get('{id}/edit/',[ScheduleController::class,'edit'])->name('schedule.edit');
        Route::put('{id}/',[ScheduleController::class,'update'])->name('schedule.update');
    });
    Route::group(['prefix'=>'schedule_details'],function(){
        Route::put('{id}/',[ScheduleDetailsController::class,'update'])->name('schedule_details.update');

    });
    // ====== Հարգելի բացակա ==========
    Route::group(['prefix'=>'person'],function(){

        Route::get('{person}/absent',[AbsenceController::class,'index'])->name('absence.list');
        // === Ստեղծել ցույց տալ
        Route::get('{person}/absence_type',[AbsenceController::class,'show'])->name('create.person.absence');
        Route::post('store',[AbsenceController::class,'store'])->name('absence.store');

    });
    Route::group(['prefix'=>'absence'],function(){
       Route::get('{id}/edit',[AbsenceController::class,'edit'])->name('absence.edit');
       Route::put('{id}/',[AbsenceController::class,'update'])->name('absence.update');
    });


    Route::group(['prefix'=>'department'],function(){

        Route::get('list', [DepartmentController::class,'index'])->name('department.list');
        Route::get('create', [DepartmentController::class,'create'])->name('department.create');
        Route::post('store', [DepartmentController::class,'store'])->name('department.store');
        Route::get('{id}/edit/',[DepartmentController::class,'edit'])->name('department.edit');
        Route::put('{id}/',[DepartmentController::class,'update'])->name('department.update');
    });
        //======== report =======================================
    Route::get('report',ReportFilterController::class)->name('reportFilter.list'); //1
    Route::get('report-enter-exit',ReportEnterExitController::class)->name('report-enter-exit.list');//2
    Route::get('/enter-time/{tb_name}/{person_id}/{client_id}/{direction}/{date}/{day}/{time}/{existingTime}',AttendansSheetEnterTimeController::class);


    // =================export-xlsx===================
    Route::get('export-person-day-schedule/{date}/{personId}',ExpertPersonDayScheduleController::class)->name('export-person-day-schedule');// օրեկան
    // Route::get('/report/export',[ReportController::class,'export'])->name('export-xlsx');
    Route::get('/report/export',ReportFilterExportController::class)->name('export-xlsx');//1
    Route::get('/report/export/enter-exit',ReportEnterExitExportController::class)->name('export-enter-exit-xlsx');//2


});

Route::get('get-file', [FileUploadService::class, 'get_file'])->name('get-file');
Route::get('cron-job',[CronJobController::class,'index']);

// =====================coment=====================================
// ========================================================
// ==========================
// ========================
// =========
// ===========
// ======
// ==
