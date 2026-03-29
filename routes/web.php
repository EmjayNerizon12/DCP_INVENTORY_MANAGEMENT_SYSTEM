<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminDcpLookupController;
use App\Http\Controllers\AdminDCPProductController;
use App\Http\Controllers\AdminEmployeeLookupController;
use App\Http\Controllers\AdminIspLookupController;
use App\Http\Controllers\AdminSchoolEquipmentLookupController;
use App\Http\Controllers\CameraScanController;
use App\Http\Controllers\DCPBatchApprovalController;
use App\Http\Controllers\DCPBatchController;
use App\Http\Controllers\DCPBatchItemController;
use App\Http\Controllers\DCPItemTypesController;
use App\Http\Controllers\DCPPackageTypeController;
use App\Http\Controllers\DCPSchoolsInventoryController;
use App\Http\Controllers\EmpCauseOfSeparationController;
use App\Http\Controllers\EmpPositionController;
use App\Http\Controllers\EmpROOfficeController;
use App\Http\Controllers\EmpSDOOfficeController;
use App\Http\Controllers\EmpSourceOfFundController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ISPController;
use App\Http\Controllers\ISPInfo\ISPInfoController;
use App\Http\Controllers\ISPQ\ISPAnswerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PackagesInformationController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SchoolAccountController;
use App\Http\Controllers\SchoolDashboardController;
use App\Http\Controllers\SchoolDCPBatchController;
use App\Http\Controllers\SchoolDetailsController;
use App\Http\Controllers\SchoolEmployeeController;
use App\Http\Controllers\SchoolEquipment\SchoolEquipmentAccountabiltyController;
use App\Http\Controllers\SchoolEquipment\SchoolEquipmentConditionController;
use App\Http\Controllers\SchoolEquipment\SchoolEquipmentController;
use App\Http\Controllers\SchoolEquipment\SchoolEquipmentDispositionController;
use App\Http\Controllers\SchoolEquipment\SchoolEquipmentDocumentController;
use App\Http\Controllers\SchoolEquipment\SchoolEquipmentDocumentTypeController;
use App\Http\Controllers\SchoolEquipment\SchoolEquipmentReceiverTypeController;
use App\Http\Controllers\SchoolEquipment\SchoolEquipmentStatusController;
use App\Http\Controllers\SchoolEquipment\SchoolEquipmentTransactionTypeController;
use App\Http\Controllers\SchoolEquipmentContoller;
use App\Http\Controllers\SchoolInventoryController;
use App\Http\Controllers\SchoolISPController;
use App\Http\Controllers\SchoolItemConditionController;
use App\Http\Controllers\SchoolNonDCPItemController;
use App\Http\Controllers\SchoolOfficialController;
use App\Http\Controllers\SchoolReportController;
use App\Models\Equipment\EquipmentBiometricDetails;
use App\Models\Equipment\EquipmentBiometricType;
use App\Models\Equipment\EquipmentBrand;
use App\Models\Equipment\EquipmentCCTVDetails;
use App\Models\Equipment\EquipmentCCTVType;
use App\Models\Equipment\EquipmentIncharge;
use App\Models\Equipment\EquipmentInstaller;
use App\Models\Equipment\EquipmentLocation;
use App\Models\Equipment\EquipmentPowerSource;
use App\Models\Equipment\EquipmentType;
use App\Models\SchoolData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login')->middleware('loginMW');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('login-submit', [LoginController::class, 'login'])->name('submit-login');
Route::get('Admin/Dashboard/index', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/Admin/Dashboard/api/asset-deprecation-value', [AdminDashboardController::class, 'getAssetAndDeprecationValue'])->name('admin.dashboard.api');
Route::get('/Admin/SchoolUser/search', [SchoolDetailsController::class, 'search'])->name('user.search');
Route::get('Admin/Product/Show/{code}', [AdminDCPProductController::class, 'showItem'])->name('index.product.view');
Route::get('Admin/Product/Search', [AdminDCPProductController::class, 'searchPage'])->name('index.page.search');
Route::post('Admin/Product/Api/search-product', [AdminDCPProductController::class, 'findItem'])->name('index.api.search');
Route::get('Admin/SchoolsInventory/inventory', [DCPSchoolsInventoryController::class, 'inventory'])->name('index.SchoolsInventory');
Route::get('Admin/SchoolsInventory/{code}', [DCPSchoolsInventoryController::class, 'showItems'])->name('show.SchoolsInventory');
Route::get('Admin/DCPBatch/search', [DCPBatchController::class, 'search'])->name('search.batch');
Route::get('Admin/DCPBatch/index', [DCPBatchController::class, 'index'])->name('index.batch')->middleware('adminRoleOnly');
Route::get('Admin/DCPBatch/list-json', [DCPBatchController::class, 'listJson'])->name('batch.list.json')->middleware('adminRoleOnly');
Route::post('Admin/DCPBatch/store', [DCPBatchController::class, 'store'])->name('store.batch');
Route::put('Admin/DCPBatch/update', [DCPBatchController::class, 'update'])->name('update.batch');
Route::post('Admin/DCPBatch/{id}/approve', [DCPBatchController::class, 'approve'])->name('approve.batch');
Route::delete('Admin/DCPBatch/{batchId}/delete', [DCPBatchController::class, 'destroy'])->name('destroy.batch');
Route::delete('Admin/DCPBatch/{batchId}/items/clear', [DCPBatchItemController::class, 'clear'])->name('clear.batch');
Route::get('/Admin/DCPBatch/{batch}/items/json', [DCPBatchItemController::class, 'itemsJson']);

Route::get('Admin/DCPBatch/Items/{batch}', [DCPBatchItemController::class, 'index'])->name('dcpbatch.items.show')->middleware('adminRoleOnly');

Route::post('Admin/DCPBatch/Items/store{batch}', [DCPBatchItemController::class, 'store'])->name('store.items');

Route::post('/School/submit-schooldata', [SchoolDetailsController::class, 'store_data'])->name('school.submit.schooldata');
Route::put('/School/update-schooldata', [SchoolDetailsController::class, 'updateSchoolDataForm'])->name('school.update.schooldata');
Route::get('/School/delete-school-data/{id}', [SchoolDetailsController::class, 'delete_school_data'])->name('school.delete.schooldata');

Route::get('Admin/School/Accounts/index', [SchoolDetailsController::class, 'user'])->name('user.schools')->middleware('adminRoleOnly');
Route::get('Admin/School/Accounts/api-get-accounts', [SchoolAccountController::class, 'showAccounts'])->name('user.schools.list.account')->middleware('adminRoleOnly');

Route::get('/Admin/School/index', [SchoolDetailsController::class, 'index'])->name('index.schools')->middleware('adminRoleOnly');
Route::post('Admin/School/post', [SchoolDetailsController::class, 'store'])->name('store.schools');

Route::get('/schools/{SchoolID}/edit', [SchoolDetailsController::class, 'edit'])->name('schools.edit');
Route::delete('/schools/{SchoolID}', [SchoolDetailsController::class, 'destroy'])->name('schools.destroy');
Route::get('/schools/{SchoolID}', [SchoolDetailsController::class, 'show'])->name('schools.show');
Route::post('/update-school/{SchoolID}', [SchoolDetailsController::class, 'updateSchool'])->name('schools.update');
Route::get('/Admin/schools/search', [SchoolDetailsController::class, 'search_school'])->name('search.schools');
Route::post('/School/upload-school-logo', [SchoolDetailsController::class, 'uploadSchoolImage'])->name('school.upload.logo');
Route::get('/Admin/Employee/', [AdminEmployeeLookupController::class, 'index'])->name('employee.index');
Route::post('/Admin/Employee/store', [AdminEmployeeLookupController::class, 'store'])->name('employee.store');
Route::put('/Admin/Employee/update', [AdminEmployeeLookupController::class, 'update'])->name('employee.update');
Route::delete('/Admin/Employee/delete/{id}/{type}', [AdminEmployeeLookupController::class, 'destroy'])->name('employee.delete');

Route::get('/api/package-items/{id}', [DCPPackageTypeController::class, 'getItems']);

Route::get('/Admin/Package/index', [DCPPackageTypeController::class, 'index'])->name('index.dcp.package')->middleware('adminRoleOnly');
Route::get('/Admin/Package/list-json', [DCPPackageTypeController::class, 'packagesJson'])->name('dcp.package.list.json')->middleware('adminRoleOnly');
Route::post('/Admin/Package/store', [DCPPackageTypeController::class, 'store'])->name('store.dcp.package');
Route::delete('/Admin/Package/delete/{id}', [DCPPackageTypeController::class, 'destroy'])->name('delete.dcp.package');
Route::put('/Admin/Package/update', [DCPPackageTypeController::class, 'update'])->name('update.dcp.package');

Route::post('/insert-package-item', [DCPPackageTypeController::class, 'insertPackageItem'])->name('insert.package_item');
Route::delete('/package-item/{id}', [DCPPackageTypeController::class, 'deletePackageItem'])->name('delete.package_item');

Route::get('/Admin/DCP/Items/index', [DCPItemTypesController::class, 'index'])->name('index.dcp.items')->middleware('adminRoleOnly');
Route::post('/Admin/DCP/Items/store', [DCPItemTypesController::class, 'store'])->name('store.dcp.items');
Route::get('/Admin/DCP/Items/search', [DCPItemTypesController::class, 'search_item_type'])->name('search.dcp.items');
Route::delete('Admin/DCP/Items/delete/{id}', [DCPItemTypesController::class, 'destroy'])->name('delete.dcp.items');
Route::post('/Admin/DCP/Items/update/{id}', [DCPItemTypesController::class, 'update'])->name('update.dcp.items');

Route::post('/delivery-mode/submit', [DCPItemTypesController::class, 'storeDeliveryMode'])->name('store.delivery_mode');

Route::post('/delivery-condition/submit', [DCPItemTypesController::class, 'storeDeliveryCondition'])->name('store.delivery_condition');
Route::post('/current-condition/submit', [DCPItemTypesController::class, 'storeCurrentCondition'])->name('store.current_condition');
Route::post('/assigned_user_type/submit', [DCPItemTypesController::class, 'storeAssignedUserType'])->name('store.assigned_user_type');
Route::post('/assigned_location/submit', [DCPItemTypesController::class, 'storeAssignedLocation'])->name('store.assigned_location');

Route::post('/supplier/submit', [DCPItemTypesController::class, 'storeSupplier'])->name('store.supplier');
Route::post('/brand/submit', [DCPItemTypesController::class, 'storeBrand'])->name('store.brand');
Route::post('/delivery-type/edit/{id}', [DCPItemTypesController::class, 'editDeliveryMode'])->name('edit.delivery_mode');
Route::post('/delivery-condition/edit/{id}', [DCPItemTypesController::class, 'editDeliveryCondition'])->name('edit.delivery_condition');
Route::post('/current-condition/edit/{id}', [DCPItemTypesController::class, 'editCurrentCondition'])->name('edit.current_condition');
Route::post('/assigned_user_type/edit/{id}', [DCPItemTypesController::class, 'editAssignedUserType'])->name('edit.assigned_user_type');
Route::post('/assigned_location/edit/{id}', [DCPItemTypesController::class, 'editAssignedLocation'])->name('edit.assigned_location');

Route::post('/supplier/edit/{id}', [DCPItemTypesController::class, 'editSupplier'])->name('edit.supplier');
Route::post('/brand/edit/{id}', [DCPItemTypesController::class, 'editBrand'])->name('edit.brand');
Route::delete('/delivery-mode/delete/{id}', [DCPItemTypesController::class, 'deleteDeliveryMode'])->name('delete.delivery_mode');
Route::delete('/delivery-condition/delete/{id}', [DCPItemTypesController::class, 'deleteDeliveryCondition'])->name('delete.delivery_condition');
Route::delete('/current-condition/delete/{id}', [DCPItemTypesController::class, 'deleteCurrentCondition'])->name('delete.current_condition');
Route::delete('/assigned_user_type/delete/{id}', [DCPItemTypesController::class, 'deleteAssignedUserType'])->name('delete.assigned_user_type');
Route::delete('/assigned_location/delete/{id}', [DCPItemTypesController::class, 'deleteAssignedLocation'])->name('delete.assigned_location');

Route::delete('/supplier/delete/{id}', [DCPItemTypesController::class, 'deleteSupplier'])->name('delete.supplier');
Route::delete('/brand/delete/{id}', [DCPItemTypesController::class, 'deleteBrand'])->name('delete.brand');
Route::get('/Admin/Product', [AdminDcpLookupController::class, 'index'])->name('index.crud');
Route::post('/Admin/Product/store', [AdminDcpLookupController::class, 'store'])->name('admin.crud.store');
Route::put('/Admin/Product/update', [AdminDcpLookupController::class, 'update'])->name('admin.crud.update');
Route::delete('/Admin/Product/delete/{id}/{type}', [AdminDcpLookupController::class, 'destroy'])->name('admin.crud.delete');

Route::get('/Admin/Internet/', [AdminIspLookupController::class, 'index'])->name('isp.index.list');
Route::post('/Admin/Internet/store', [AdminIspLookupController::class, 'store'])->name('admin.isp.store');
Route::put('/Admin/Internet/update', [AdminIspLookupController::class, 'update'])->name('admin.isp.update');
Route::delete('/Admin/Internet/delete/{id}/{type}', [AdminIspLookupController::class, 'destroy'])->name('admin.isp.delete');

Route::post('/Admin/ISP/submit-list', [ISPController::class, 'storeISPList'])->name('isp.submit.list');
Route::put('/Admin/ISP/update-list', [ISPController::class, 'updateISPList'])->name('isp.update.list');
Route::delete('/Admin/ISP/delete-list/{isp_list_id}', [ISPController::class, 'deleteISPList'])->name('isp.delete.list');
Route::post('/Admin/ISP/submit-quality', [ISPController::class, 'storeISPQuality'])->name('isp.submit.quality');
Route::put('/Admin/ISP/update-quality', [ISPController::class, 'updateISPQuality'])->name('isp.update.quality');
Route::delete('/Admin/ISP/delete-quality/{isp_quality_id}', [ISPController::class, 'deleteISPQuality'])->name('isp.delete.quality');
Route::post('/Admin/ISP/submit-connection', [ISPController::class, 'storeConnectionType'])->name('isp.submit.connection_type');
Route::put('/Admin/ISP/update-connection', [ISPController::class, 'updateConnectionType'])->name('isp.update.connection_type');
Route::delete('/Admin/ISP/delete-connection/{isp_connection_id}', [ISPController::class, 'deleteConnectionType'])->name('isp.delete.connection_type');
Route::get('Admin/show-isp', [ISPController::class, 'show']);
Route::get('Admin/ISP/search', [ISPController::class, 'search']);

Route::post('/Admin/ISP/submit-area', [ISPController::class, 'storeArea'])->name('isp.submit.area');
Route::put('/Admin/ISP/update-area', [ISPController::class, 'updateArea'])->name('isp.update.area');
Route::delete('/Admin/ISP/delete-area/{isp_area_id}', [ISPController::class, 'deleteArea'])->name('isp.delete.area');

Route::get('Admin/CCTV-Biometrics', [EquipmentController::class, 'index'])->name('equipment.index.list');
Route::post('Admin/CCTV-Biometrics/submit', [EquipmentController::class, 'store'])->name('equipment.store');
Route::put('Admin/CCTV-Biometrics/update', [EquipmentController::class, 'update'])->name('equipment.update');
Route::delete('Admin/CCTV-Biometrics/delete/{id}/{type}', [EquipmentController::class, 'destroy'])->name('equipment.delete');
Route::get('Admin/Account', [AdminController::class, 'account'])->name('admin.account.index');
Route::put('Admin/change-username', [AdminController::class, 'change_username'])->name('admin.change.username');
Route::put('Admin/reset-school-user-password', [SchoolAccountController::class, 'reset_password'])->name('admin.reset.school_user.password');
Route::put('Admin/change-password', [AdminController::class, 'change_password'])->name('admin.change.password');

Route::get('Admin/Dashboard/api/item-conditions', [AdminDashboardController::class, 'get_current_condition_of_item']);
Route::get('Admin/Dashboard/api/item-categories', [AdminDashboardController::class, 'get_item_categories']);
Route::get('Admin/Dashboard/api/package-categories', [AdminDashboardController::class, 'get_package_categories']);
Route::get('Admin/Dashboard/api/school-categories', [AdminDashboardController::class, 'get_schools_dcp_count']);
Route::get('Admin/api/count-equipment', [AdminDashboardController::class, 'school_with_isp']);

Route::get('Admin/Equipment/Biometrics/index', [EquipmentController::class, 'showBiometrics'])->name('equipment.biometrics.index');
Route::get('Admin/ItemConditions/{id}', [AdminDashboardController::class, 'showItemCondition'])->name('admin.item_conditions.show');
Route::get('Admin/ItemConditions/Report/{id}', [AdminDashboardController::class, 'itemReport'])->name('admin.item.report');
Route::get('Admin/Camera', function () {
    return view('AdminSide.Camera.index');
})->name('admin.scan.monitor');
Route::post('Admin/update-record-status-of-item', [CameraScanController::class, 'updateStatus']);
Route::get('Admin/Reports', [ReportsController::class, 'index'])->name('admin.reports.index');
Route::get('Admin/api/Reports', [ReportsController::class, 'generateReport'])->name('api.reports');
Route::get('Admin/api/schools-with-packages', [DCPBatchController::class, 'getSchoolsWithPackages'])->name('api.schools.with.packages');
Route::get('Admin/api/cost', [ReportsController::class, 'totalCost'])->name('api.reports.cost');
Route::get('Admin/schoolEquipment', [AdminSchoolEquipmentLookupController::class, 'index'])->name('admin.schoolEquipment.index');
Route::post('Admin/schoolEquipment/store', [AdminSchoolEquipmentLookupController::class, 'store'])->name('admin.schoolEquipment.store');
Route::put('Admin/schoolEquipment/update', [AdminSchoolEquipmentLookupController::class, 'update'])->name('admin.schoolEquipment.update');
Route::delete('Admin/schoolEquipment/delete/{id}/{type}', [AdminSchoolEquipmentLookupController::class, 'destroy'])->name('admin.schoolEquipment.delete');

Route::resource('emp-cause-of-separation', EmpCauseOfSeparationController::class);
Route::resource('emp-source-of-fund', EmpSourceOfFundController::class);
Route::resource('emp-position', EmpPositionController::class);
Route::resource('emp-sdo-office', EmpSDOOfficeController::class);
Route::resource('emp-ro-office', EmpROOfficeController::class);

// School dashboard update routes
Route::middleware(['web', 'auth:school'])->prefix('School')->group(function () {
    Route::resource('schoolOfficials', SchoolOfficialController::class);

    Route::get('/get-current-conditions', [SchoolDashboardController::class, 'getItemConditionCounts'])->name('schools.get.current_conditions');
    Route::get('/dashboard', [SchoolDashboardController::class, 'index'])->name('school.dashboard');

    // DASHBOARD API
    Route::get('/Dashboard/api/api-get-dcp-information', [SchoolDashboardController::class, 'getDashboardDCPInformation'])->name('schools.dashboard.DCP-information');
    Route::get('/Dashboard/api/api-get-information', [SchoolDashboardController::class, 'getDashboardInfomation'])->name('schools.dashboard.information');
    Route::get('/packages-info/{id}', [PackagesInformationController::class, 'index'])->name('schools.packages.info');
    Route::get('items-condition/{id}', [SchoolItemConditionController::class, 'index'])->name('schools.item.condition');
    Route::post('item-condition', [SchoolItemConditionController::class, 'comboSearch'])->name('schools.item.condition.combo');
    Route::get('/profile', function () {

        $school = Auth::guard('school')->user()->school;
        $schoolData = SchoolData::where('pk_school_id', $school->pk_school_id)
            ->orderByRaw("FIELD(GradeLevelID, 'K', '1', '2', '3', '4', '5', '6', 'JHS', 'SHS')")
            ->get();
        $submittedGradeLevels = $schoolData->pluck('GradeLevelID')->toArray();

        return view('SchoolSide.SchoolsInfo.index', compact('schoolData', 'submittedGradeLevels'));
    })->name('school.profile');
    Route::get('/dcp-service-report', function () {
        return view('SchoolSide.DCPServiceReport');
    })->name('school.dcp_service_report');

    Route::get('/DCPInventory', function () {

        $batch_items = DB::table('dcp_batches')
            ->join('dcp_batch_items', 'dcp_batches.pk_dcp_batches_id', '=', 'dcp_batch_items.dcp_batch_id')
            ->where('dcp_batches.school_id', Auth::guard('school')->user()->school->pk_school_id)
            ->select('dcp_batches.*', 'dcp_batch_items.*') // or specific columns
            ->orderBy('dcp_batches.created_at', 'desc')
            ->get();

        return view('SchoolSide.DCPInventory.DCPInventory', compact('batch_items'));
    })->name('school.dcp_inventory');

    Route::get('DCPInventory/{item_id}', [SchoolDCPBatchController::class, 'showItems'])->name('school.dcp_inventory.items');

    Route::get('/dcp-batch', [SchoolDCPBatchController::class, 'index'])->name('school.dcp_batch');
    Route::get('/dcp-batch-items-list', [SchoolDCPBatchController::class, 'batch_item_list'])->name('school.dcp_batch_item_list');

    Route::get('/dcp-batch/{batch}/items', [SchoolDCPBatchController::class, 'items'])->name('school.dcp_items');
    Route::get('/dcp-batch/{batch}/item-status', [SchoolDCPBatchController::class, 'itemStatus'])->name('school.dcp_item_status');
    Route::get('/dcp-batch/{batchId}/item-status/search/{searchTerm?}', [SchoolDCPBatchController::class, 'searchProductFromStatus'])->name('school.dcp_item_status.search');

    Route::get('/dcp-batch/{item}/warranty', [SchoolDCPBatchController::class, 'warranty'])->name('school.dcp_item_warranty');
    Route::put('/dcp-batch/{item}', [SchoolDCPBatchController::class, 'updateItem'])->name('school.dcp_items.update');
    Route::post('update-batch-status/{batchId}', [SchoolDCPBatchController::class, 'updateBatchStatus'])->name('school.update.batch_status');
    Route::put('batch-status/{batchId}', [SchoolDCPBatchController::class, 'editUpdateBatchStatus'])->name('batch_status.update');
    Route::get('index-batch-status/{batchId}', [SchoolDCPBatchController::class, 'batch_status'])->name('school.index.batch_status');
    // Unified update route
    Route::post('/update-details', [SchoolDetailsController::class, 'updateAllDetails'])->name('school.details.update');
    Route::post('/upload-logo', [AdminController::class, 'upload_school_logo'])->name('school.update.logo');
    // Route::post('/update-officials', [AdminController::class, 'updateSchoolOfficials'])->name('school.update.officials');
    Route::post('assignment/items', [SchoolDCPBatchController::class, 'assigned_for_items'])->name('school.assignment.items');
    Route::get('/batch-items/search', [SchoolInventoryController::class, 'searchBatchItems']);
    Route::post('/submit-dcp-batch', [DCPBatchApprovalController::class, 'submit'])->name('submit.dcp_batch');
    Route::get('/ISP/index', [SchoolISPController::class, 'index'])->name('schools.isp.index');
    Route::post('/ISP/store', [SchoolISPController::class, 'storeData'])->name('schools.isp.store');
    Route::put('/ISP/update-area', [SchoolISPController::class, 'updateArea'])->name('schools.isp.update.area');
    Route::delete('/ISP/delete-area/{isp_details_id}/{isp_area_available_id}', [SchoolISPController::class, 'deleteArea'])->name('schools.isp.delete.area');
    Route::put('/ISP/update', [SchoolISPController::class, 'updateData'])->name('schools.isp.update');
    Route::delete('/ISP/delete/{isp_list_details_id}', [SchoolISPController::class, 'deleteISP'])->name('schools.isp.delete');
    Route::post('/ISP/add-area', [SchoolISPController::class, 'insertNewArea'])->name('schools.isp.add.area');
    Route::get('/Equipment/index', [SchoolEquipmentContoller::class, 'index'])->name('schools.equipment.index');
    Route::post('/Equipment/store', [SchoolEquipmentContoller::class, 'store'])->name('schools.equipment.store');
    Route::put('/Equipment/update', [SchoolEquipmentContoller::class, 'update'])->name('schools.equipment.update');
    Route::delete('/Equipment/delete/{equipment_id}/{type}', [SchoolEquipmentContoller::class, 'destroy'])->name('schools.equipment.delete');
    Route::get('/CCTV/index', function () {
        $equipment_type = EquipmentType::all();
        $equipment_brand_model = EquipmentBrand::all();
        $equipment_installer = EquipmentInstaller::all();
        $equipment_incharge = EquipmentIncharge::all();
        $equipment_location = EquipmentLocation::all();
        $equipment_power_source = EquipmentPowerSource::all();
        $cctv_type = EquipmentCCTVType::all();
        $cctv_info = EquipmentCCTVDetails::where('school_id', Auth::guard('school')->user()->school->pk_school_id)
            ->with(['equipment_details.equipmentType', 'equipment_details.incharge'])
            ->get();

        return view('SchoolSide.CCTV.index', compact('cctv_type', 'cctv_info', 'equipment_type', 'equipment_brand_model', 'equipment_installer', 'equipment_incharge', 'equipment_location', 'equipment_power_source'));
    })->name('schools.cctv.index');
    Route::get('/Biometrics/index', function () {
        $equipment_type = EquipmentType::all();
        $equipment_brand_model = EquipmentBrand::all();
        $equipment_installer = EquipmentInstaller::all();
        $equipment_incharge = EquipmentIncharge::all();
        $equipment_location = EquipmentLocation::all();
        $equipment_power_source = EquipmentPowerSource::all();
        $biometric_type = EquipmentBiometricType::all();
        $biometric_info = EquipmentBiometricDetails::where('school_id', Auth::guard('school')->user()->school->pk_school_id)->get();

        return view('SchoolSide.Biometrics.index', compact(
            'biometric_info',
            'biometric_type',
            'equipment_type',
            'equipment_brand_model',
            'equipment_installer',
            'equipment_incharge',
            'equipment_location',
            'equipment_power_source'
        ));
    })->name('schools.biometrics.index');
    Route::get('Report/index', [SchoolReportController::class, 'index'])->name('schools.report.index');
    Route::get('Report/condition', [SchoolReportController::class, 'condition'])->name('schools.report.condition');
    Route::get('Report/api/condition/{condition_id}', [SchoolReportController::class, 'condition_report'])->name('schools.report.api.condition');
    Route::get('Employee/index', [SchoolEmployeeController::class, 'index'])->name('schools.employee.index');
    Route::post('Employee/submit', [SchoolEmployeeController::class, 'store'])->name('schools.employee.store');
    Route::put('Employee/update', [SchoolEmployeeController::class, 'update'])->name('schools.employee.update');
    Route::delete('Employee/delete/{id}', [SchoolEmployeeController::class, 'destroy'])->name('schools.employee.destroy');
    Route::get('Employee/search-school-employee-list/{searchTerm?}', [SchoolEmployeeController::class, 'searchEmployee'])->name('school.employee.list');

    Route::get('Account/index', [SchoolAccountController::class, 'index'])->name('schools.account.index');
    Route::post('Account/change-password', [SchoolAccountController::class, 'change_password'])->name('schools.account.change-password');
    Route::get('NonDCPItem/index', [SchoolNonDCPItemController::class, 'index'])->name('schools.nondcpitem.index');
    Route::post('NonDCPItem/store', [SchoolNonDCPItemController::class, 'store'])->name('schools.nondcpitem.store');
    Route::put('NonDCPItem/update', [SchoolNonDCPItemController::class, 'update'])->name('schools.nondcpitem.update');
    Route::delete('NonDCPItem/delete/{id}', [SchoolNonDCPItemController::class, 'delete'])->name('schools.nondcpitem.delete');
    Route::resource('SchoolEquipment', SchoolEquipmentController::class);
    Route::resource('school-equipment-document-type', SchoolEquipmentDocumentTypeController::class);
    Route::resource('school-equipment-document', SchoolEquipmentDocumentController::class);
    Route::resource('school-equipment-accountability', SchoolEquipmentAccountabiltyController::class);
    Route::resource('school-equipment-status', SchoolEquipmentStatusController::class);
    Route::resource('school-equipment-condition', SchoolEquipmentConditionController::class);
    Route::resource('school-equipment-disposition', SchoolEquipmentDispositionController::class);
    Route::resource('school-equipment-transaction-type', SchoolEquipmentTransactionTypeController::class)
        ->parameters([
            'school-equipment-transaction-type' => 'transactionType',
        ]);

    Route::resource('school-equipment-accountability-receiver-type', SchoolEquipmentReceiverTypeController::class)
        ->parameters([
            'school-equipment-accountability-receiver-type' => 'receiverType',
        ]);
    Route::resource('ISP-Question', ISPAnswerController::class);
    Route::resource('ISP-Info', ISPInfoController::class);
    Route::put('ISP-Question', [ISPAnswerController::class, 'update'])
        ->name('ISP-Question.update');
    Route::get('school-employee-list', [SchoolEmployeeController::class, 'showSchoolEmployees'])->name('school.employee.list');
    Route::get('Employee/get-data', [SchoolEmployeeController::class, 'get_data']);
    // END OF PREFIX SCHOOL
});

Route::post('/send-mail/{id}', [MailController::class, 'sendEmail'])->name('notify.school');
