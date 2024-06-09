<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlanceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpDetailController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpProcessController;
use App\Http\Controllers\ExpSetupController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OthersIncomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PdfGeneratorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\ExpenseController as UserExpenseController;
use App\Http\Controllers\User\ExpSetupController as UserExpSetupController;
use App\Http\Controllers\User\FlatController as UserFlatController;
use App\Http\Controllers\User\IncomeController as UserIncomeController;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\User\VendoreController as UserVendoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendoreController;
use App\Http\Controllers\VoucherController;
use App\Models\Category;
use App\Models\OthersIncome;
use Illuminate\Support\Facades\Route;

/*---------------- Admin route start here ------------------*/
// admin login route start here 

Route::get('/admin/login', [AdminController::class, 'Index'])->name('login_form');
Route::post('/admin/login/owner', [AdminController::class, 'Login'])->name('admin.login');

// admin register route start here 
Route::get('/admin/register', [AdminController::class, 'AdminRegister'])->name('register_form');
Route::post('/admin/register/store', [AdminController::class, 'Store'])->name('admin.store');
Route::get('/admin/register-verify', [AdminController::class, 'Verify'])->name('admin.verfy');
Route::post('/admin/register-verify/store', [AdminController::class, 'VerifyStore'])->name('admin.verfy.store');
Route::get('/admin/register-verified', [AdminController::class, 'Verified'])->name('admin.verfied');
// admin register route ends here 

// Customer Forgate password route start here 
Route::get('/admin/forgot-password', [AdminController::class, 'Forgot'])->name('admin.forgot-password');
Route::post('/admin/forgot-password/create', [AdminController::class, 'ForgotPassword'])->name('admin.forgot-password.create');
Route::get('/admin/reset/{token}', [AdminController::class, 'reset']);
Route::post('/admin/reset/{token}', [AdminController::class, 'PostReset']);
// Customer Forgate password route ends here 

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard');
    Route::get('/get-transaction/{date}', [AdminController::class, 'GetTransaction']); // get current transaction for Dashboard

    // client show 
    Route::get('/clients', [AdminController::class, 'Client'])->name('client.all');
    Route::get('/client/edit/{id}', [AdminController::class, 'ClientEdit'])->name('client.edit');
    Route::post('/client/update', [AdminController::class, 'ClientUpdate'])->name('client.update');
    // client data deleted 
    Route::get('/clients/all', [AdminController::class, 'ClientAll'])->name('client.index');
    Route::post('/client/delete', [AdminController::class, 'ClientDataDelete'])->name('client.data.delete');

    // admin login route start here 
    Route::post('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

    //    Category route 
    Route::get('/category', [CategoryController::class, 'Index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'Create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'Store'])->name('category.store');
    // Route::get('/category/edit/{id}', [CategoryController::class, 'Edit'])->name('category.edit');
    // Route::post('/category/update', [CategoryController::class, 'Update'])->name('category.update');
    Route::get('/category/delete/{id}', [CategoryController::class, 'Destroy'])->name('category.delete');

    // Packages route  
    Route::get('/packages', [PackageController::class, 'Index'])->name('package.all');
    Route::get('/package/create', [PackageController::class, 'Create'])->name('package.create');
    Route::post('/package/store', [PackageController::class, 'Store'])->name('package.store');
    Route::get('/package/edit/{id}', [PackageController::class, 'Edit'])->name('package.edit');
    Route::post('/package/update', [PackageController::class, 'Update'])->name('package.update');
    Route::get('/package/delete/{id}', [PackageController::class, 'Delete'])->name('package.delete');


});

/*---------------- Admin route ends here ------------------*/
/*---------------- Customer route start here ------------------*/
Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    // Flat setup route 
    Route::get('/manage-flat', [FlatController::class, 'Index'])->name('flat.index');
    Route::get('/manage-flat/create', [FlatController::class, 'Create'])->name('flat.create');
    Route::post('/manage-flat/store', [FlatController::class, 'Store'])->name('flat.store');
    Route::get('/manage-flat/single-create', [FlatController::class, 'SingleCreate'])->name('flat.singlecreate');
    Route::post('/manage-flat/single-store', [FlatController::class, 'SingleStore'])->name('flat.singlestore');

    // users route 
    Route::get('/users', [UserController::class, 'Index'])->name('users.index');
    // Route::get('/users/create', [UserController::class, 'Create'])->name('users.create');
    // Route::post('/users/store', [UserController::class, 'Store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'Edit']);
    Route::post('/users/update', [UserController::class, 'Update'])->name('users.update');
    Route::post('/users/delete', [UserController::class, 'Destroy'])->name('users.delete');

    // single users route
    Route::get('/user/create', [UserController::class, 'SingleCreate'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'SingleStore'])->name('user.store');

    // Expense-details route 
    Route::get('/expense/create', [ExpenseController::class, 'Create'])->name('expense.create');
    Route::post('/expense/store', [ExpenseController::class, 'Store'])->name('expense.store');
    Route::get('/expense/edit/{id}', [ExpenseController::class, 'Edit']);
    Route::post('/expense/update', [ExpenseController::class, 'Update'])->name('expense.update');
    Route::get('/expense/delate/{id}', [ExpenseController::class, 'Delate'])->name('expense.delate');

    Route::get('/expense-summary', [ExpenseController::class, 'Index'])->name('expense-summary.index');

    // Expense setup route 
    Route::get('/expense-setup', [ExpSetupController::class, 'ExpenseSetupIndex'])->name('expense.setup');
    Route::post('/expense-setup/create', [ExpSetupController::class, 'ExpenseSetupCreate'])->name('expense.setup.create');
    Route::get('/expense-setup/edit/{id}', [ExpSetupController::class, 'ExpenseSetupEdit'])->name('expense.setup.edit');
    Route::post('/expense-setup/update', [ExpSetupController::class, 'ExpenseSetupUpdate'])->name('expense.setup.update');

    // setup history route 
    Route::get('/expense-setup/history', [ExpSetupController::class, 'ExpenseSetupHistory'])->name('expense.setup.history');
    Route::get('/expense-setup/history/all/{exp_id}', [ExpSetupController::class, 'ExpenseSetupHistoryAll']);

    // Vendore route 
    Route::get('/vendor-all', [VendoreController::class, 'VendorIndex'])->name('vendor.all');
    Route::get('/vendor/create', [VendoreController::class, 'VendorCreate'])->name('vendor.create');
    Route::post('/vendor/store', [VendoreController::class, 'VendorStore'])->name('vendor.store');
    Route::get('/vendor/edit/{id}', [VendoreController::class, 'VendorEdit'])->name('vendor.edit');
    Route::post('/vendor/update', [VendoreController::class, 'VendorUpdate'])->name('vendor.update');


    // report route start here 
    // Route::get('/expenses/all', [ExpProcessController::class, 'Index'])->name('expenses.process');
    Route::get('/expenses/month', [ExpDetailController::class, 'MonthlyExpense'])->name('expenses.month');

    // account route start here 
    Route::get('/ledger-posting', [ExpenseController::class, 'Index'])->name('ledgerPosting.index');
    Route::get('/ledger-posting/store', [ExpProcessController::class, 'Store'])->name('ledger-posting.store');
    // Route::get('/expense-process/store', [ExpProcessController::class, 'Store'])->name('expense_process.store');
    Route::get('/opening-balance/create', [BlanceController::class, 'OpeningBalance'])->name('opening.balance.create');
    Route::post('/opening-balance/store', [BlanceController::class, 'OpeningBalanceStore'])->name('opening.balance.store');
    // account route ends here 

    //    Expense process route 
    // Route::get('/expense.process', [ExpProcessController::class, 'Index'])->name('expenses.index');
    // // Route::get('/expense-process/store', [ExpProcessController::class, 'Store'])->name('expense_process.store');

    //    income route  
    Route::get('/income', [IncomeController::class, 'Create'])->name('income.create');
    Route::post('/income/store', [IncomeController::class, 'Store'])->name('income.store');
    Route::get('/income/collection', [IncomeController::class, 'Collection'])->name('income.collection');
    Route::post('/income/collection/store/', [IncomeController::class, 'StoreCollection'])->name('income.collection.store');


    /*------------------------- Expense voucher route srtart here-------------------------*/
    // Expense Management 
    Route::get('/expense/create-voucher/{id}', [PdfGeneratorController::class, 'CreateVoucher'])->name('expense.voucher.create');
    Route::post('/expense/create-voucher/store', [PdfGeneratorController::class, 'CreateVoucherStore'])->name('expense.voucher.store');
    Route::post('/expense/generate-voucher', [PdfGeneratorController::class, 'GenerateVoucher'])->name('expense.voucher.generate');
    Route::get('/expense/generate-voucher-all', [PdfGeneratorController::class, 'GenerateVoucherAll'])->name('expense.voucher.generateall');
    // Expense Accounts 
    Route::post('/account/expense-voucher-all', [PdfGeneratorController::class, 'GenerateExpenseVoucherAll'])->name('account.expense.voucher.generateall');
    /*------------------------- expense voucher route srtart here-------------------------*/

    /*------------------------- income voucher route start here-------------------------*/
    Route::get('/income/generate-voucher/{id}', [PdfGeneratorController::class, 'GenerateIncomeVoucher'])->name('income.voucher.generate');
    Route::post('/income/generate-voucher-all', [PdfGeneratorController::class, 'GenerateIncomeVoucherAll'])->name('income.voucher.generateall');
    /*------------------------- income voucher route ends here-------------------------*/

    /*--------------- Accounts voucher route start here ------------------*/
    // collection
    Route::get('/income/collection-voucher', [VoucherController::class, 'Index'])->name('income.collection.index');
    Route::post('/income/collection-all', [VoucherController::class, 'CollectionAll'])->name('income.collection.all');
    //expense
    Route::get('/account/expense-voucher', [VoucherController::class, 'ExpenseIndex'])->name('account.expense.index');
    Route::post('/account/expense-all', [VoucherController::class, 'ExpenseAll'])->name('account.expense.all');
    //Balance sheet
    Route::get('/account/balance', [VoucherController::class, 'balanceSheetIndex'])->name('account.balancesheet');
    Route::get('/account/balance-sheet/{year}/{month}', [VoucherController::class, 'balanceSheet'])->name('account.allbalancesheet');

    Route::get('/income-statement', [VoucherController::class, 'Incomes'])->name('income.statement');
    /*--------------- Accounts voucher route ends here ------------------*/

    /*--------------- Report route start here ------------------*/
    Route::get('/expenses/month', [ReportController::class, 'MonthlyExpense'])->name('expenses.month');
    Route::post('/expenses-all/month', [ReportController::class, 'MonthlyAllExpense'])->name('expensesall.month');
    Route::get('/expenses/yearly', [ReportController::class, 'YearlyExpense'])->name('expenses.year');
    Route::post('/expenses-all/year', [ReportController::class, 'YearlyAllExpense'])->name('expensesall.year');

    Route::get('/incomes/month', [ReportController::class, 'MonthlyIncome'])->name('incomes.month');
    Route::post('/incomes-all/month', [ReportController::class, 'MonthlyAllIncome'])->name('incomesall.month');
    Route::get('/incomes/yearly', [ReportController::class, 'YearlyIncome'])->name('incomes.year');
    Route::post('/incomes-all/yearly', [ReportController::class, 'YearlyAllIncome'])->name('incomesall.year');

    /*--------------- Report route ends here ------------------*/

    /*--------------- Others Income route start here ------------------*/
    Route::get('/others-income/create', [OthersIncomeController::class, 'OthersIncomeCreate'])->name('others.income.create');
    Route::post('/others-income/store', [OthersIncomeController::class, 'OthersIncomeStore'])->name('others.income.store');
    /*--------------- Others Income route ends here ------------------*/

    //    Balance route 
    // Route::get('/balance/month', [BlanceController::class, 'Monthly'])->name('monthly.blance.index');
    // Route::get('/balance/year', [BlanceController::class, 'Yearly'])->name('yearly.blance.index');


    //    Report route 
    Route::get('/balance-sheet', [BlanceController::class, 'BalanceSheet'])->name('blance.index');
    // Route::get('/all-expenses', [BlanceController::class, 'Expenses'])->name('expense-all.index');

     // Guest Manage 
     Route::get('/guest-book/all', [GuestController::class, 'Index'])->name('guestBook.index');
     Route::get('/guest-book/create', [GuestController::class, 'Create'])->name('guestBook.create');
     Route::post('/guest-book/store', [GuestController::class, 'Store'])->name('guestBook.store');
     Route::get('/guest-book/{id}', [GuestController::class, 'Edit'])->name('guestBook.edit');
     Route::post('/guest-book/update', [GuestController::class, 'Update'])->name('guestBook.update');
     Route::get('/guest-book/history', [GuestController::class, 'ShowHistory'])->name('guestBook.history');
    
});

/*---------------- Customer route ends here ------------------*/

/*---------------- User route start here ------------------*/
Route::get('/user-login', [UserController::class, 'LoginForm'])->name('user.login_form');
Route::post('/user-login/owner', [UserController::class, 'Login'])->name('user.login');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'Profile'])->name('user.Profile');
    Route::get('/get-transaction/{date}', [UserController::class, 'GetTransaction']); // get current transaction for Dashboard
    // admin login route start here 
    Route::post('/user/logout', [AccountController::class, 'AdminLogout'])->name('manager.logout');
    /*---------------- Manager route start here ------------------*/
    // Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard');

    // flat route start here 
    Route::get('/manage-flat', [UserFlatController::class, 'Index'])->name('manager.flat.index');
    Route::get('/manage-flat/single-create', [UserFlatController::class, 'SingleCreate'])->name('manager.flat.singlecreate');
    Route::post('/manager/manage-flat/single-store', [UserFlatController::class, 'SingleStore'])->name('manager.flat.singlestore');
    // flat route start here 

    //    users route 
    Route::get('/users', [UserFlatController::class, 'UserIndex'])->name('manager.users.index');
    Route::get('/users/edit/{id}', [UserFlatController::class, 'Edit']);
    Route::post('/users/update', [UserFlatController::class, 'Update'])->name('manager.users.update');

    //    Expense-details route 
    Route::get('/expense/create', [UserExpenseController::class, 'Create'])->name('manager.expense.create');
    Route::post('/expense/store', [UserExpenseController::class, 'Store'])->name('manager.expense.store');
    Route::get('/expense-details/edit/{id}', [UserExpenseController::class, 'Edit']);
    Route::post('/expense-details/update', [UserExpenseController::class, 'Update'])->name('manager.expense-details.update');
    Route::get('/expense-details/delate/{id}', [UserExpenseController::class, 'Delate'])->name('manager.expense-details.delate');

    Route::get('/expense-summary', [UserExpenseController::class, 'Index'])->name('manager.expense-summary.index');
    Route::get('/expenses/month', [UserExpenseController::class, 'MonthlyExpense'])->name('manager.expenses.month');

    // Expense Management 
    Route::get('/expense/create-voucher/{id}', [UserExpenseController::class, 'CreateVoucher'])->name('manager.expense.voucher.create');
    Route::post('/expense/create-voucher/store', [UserExpenseController::class, 'CreateVoucherStore'])->name('manager.expense.voucher.store');
    Route::post('/expense/generate/voucher', [UserExpenseController::class, 'GenerateVoucher'])->name('manager.expense.voucher.generate');
    Route::get('/expense/generate-voucher-all', [UserExpenseController::class, 'GenerateVoucherAll'])->name('manager.expense.voucher.generateall');

    //    income route  
    Route::get('/income', [UserIncomeController::class, 'Create'])->name('manager.income.create');
    Route::post('/income/store', [UserIncomeController::class, 'Store'])->name('manager.income.store');
    Route::get('/income/collection', [UserIncomeController::class, 'Collection'])->name('manager.income.collection');
    Route::post('/income/collection/store/', [UserIncomeController::class, 'StoreCollection'])->name('manager.income.collection.store');

    Route::get('/income/collection-voucher', [UserIncomeController::class, 'Index'])->name('manager.income.collection.index');
    Route::post('/income/collection-all', [UserIncomeController::class, 'CollectionAll'])->name('manager.income.collection.all');

    /*------------------------- income voucher route start here-------------------------*/
    Route::get('/income/generate-voucher/{id}', [UserIncomeController::class, 'GenerateIncomeVoucher'])->name('manager.income.voucher.generate');
    Route::post('/income/generate-voucher-all', [UserIncomeController::class, 'GenerateIncomeVoucherAll'])->name('manager.income.voucher.generateall');
    /*------------------------- income voucher route ends here-------------------------*/

    // account route start here 
    Route::get('/ledger-posting', [AccountController::class, 'Index'])->name('manager.ledgerPosting.index');
    Route::get('/ledger-posting/store', [AccountController::class, 'Store'])->name('manager.ledger-posting.store');

    /*--------------- Accounts voucher route start here ------------------*/
    // collection
    // Route::get('/income/collection-voucher', [AccountController::class, 'IndexCollection'])->name('manager.income.collection.index');
    // Route::post('/income/collection-all', [AccountController::class, 'CollectionAll'])->name('manager.income.collection.all');
    //expense
    Route::get('/account/expense-voucher', [AccountController::class, 'ExpenseIndex'])->name('manager.account.expense.index');
    Route::post('/account/expense-all', [AccountController::class, 'ExpenseAll'])->name('manager.account.expense.all');
    Route::post('/account/expense-voucher-all', [AccountController::class, 'GenerateExpenseVoucherAll'])->name('manager.account.expense.voucher.generateall');
    //Balance sheet
    // Route::get('/account/balance', [AccountController::class, 'BalanceSheet'])->name('manager.account.balancesheet');
    // Route::post('/account/balance-all', [AccountController::class, 'AllBalanceSheet'])->name('manager.account.allbalancesheet');
    //Balance sheet
    Route::get('/account/balance', [AccountController::class, 'balanceSheetIndex'])->name('manager.account.balancesheet');
    Route::get('/account/balance-sheet/{year}/{month}', [AccountController::class, 'balanceSheet'])->name('manager.account.allbalancesheet');


    Route::get('/income-statement', [AccountController::class, 'Incomes'])->name('manager.income.statement');

    /*--------------- Accounts voucher route ends here ------------------*/

    /*--------------- Report route start here ------------------*/
    Route::get('/expenses/month', [UserReportController::class, 'MonthlyExpense'])->name('manager.expenses.month');
    Route::post('/expenses-all/month', [UserReportController::class, 'MonthlyAllExpense'])->name('manager.expensesall.month');
    Route::get('/expenses/yearly', [UserReportController::class, 'YearlyExpense'])->name('manager.expenses.year');
    Route::post('/expenses-all/year', [UserReportController::class, 'YearlyAllExpense'])->name('manager.expensesall.year');

    Route::get('/incomes/month', [UserReportController::class, 'MonthlyIncome'])->name('manager.incomes.month');
    Route::post('/incomes-all/month', [UserReportController::class, 'MonthlyAllIncome'])->name('manager.incomesall.month');
    Route::get('/incomes/yearly', [UserReportController::class, 'YearlyIncome'])->name('manager.incomes.year');
    Route::post('/incomes-all/yearly', [UserReportController::class, 'YearlyAllIncome'])->name('manager.incomesall.year');

    Route::get('/balance-sheet', [UserReportController::class, 'BalanceSheet'])->name('manager.blance.index');
    /*--------------- Report route ends here ------------------*/

    // Expense setup route 
    Route::get('/manager/expense-setup', [UserExpSetupController::class, 'ExpenseSetupIndex'])->name('manager.expense.setup');
    Route::post('/manager/expense-setup/create', [UserExpSetupController::class, 'ExpenseSetupCreate'])->name('manager.expense.setup.create');
    Route::get('/manager/expense-setup/edit/{id}', [UserExpSetupController::class, 'ExpenseSetupEdit'])->name('manager.expense.setup.edit');
    Route::post('/manager/expense-setup/update', [UserExpSetupController::class, 'ExpenseSetupUpdate'])->name('manager.expense.setup.update');

    // setup history route 
    Route::get('/manager/expense-setup/history', [UserExpSetupController::class, 'ExpenseSetupHistory'])->name('manager.expense.setup.history');
    Route::get('/manager/expense-setup/history/all/{exp_id}', [UserExpSetupController::class, 'ExpenseSetupHistoryAll']);


    // Vendore route 
    Route::get('/manager/vendor-all', [UserVendoreController::class, 'VendorIndex'])->name('manager.vendor.all');
    Route::get('/manager/vendor/create', [UserVendoreController::class, 'VendorCreate'])->name('manager.vendor.create');
    Route::post('/manager/vendor/store', [UserVendoreController::class, 'VendorStore'])->name('manager.vendor.store');
    Route::get('/manager/vendor/edit/{id}', [UserVendoreController::class, 'VendorEdit'])->name('manager.vendor.edit');
    Route::post('/manager/vendor/update', [UserVendoreController::class, 'VendorUpdate'])->name('manager.vendor.update');

    /*---------------- Manager route ends here ------------------*/

    /*---------------- user route start here ------------------*/
    Route::get('/single-user/paid', [UserIncomeController::class, 'SingleUserPaid'])->name('singleUser.paid');
    Route::get('/single-user/due', [UserIncomeController::class, 'SingleUserDue'])->name('singleUser.due');
    Route::get('/user/reset-password', [UserIncomeController::class, 'PasswordReset'])->name('user.password.reset');
    Route::Post('/user/reset-password', [UserIncomeController::class, 'PasswordResetStore'])->name('user.password.reset.store');
    /*---------------- user route ends here ------------------*/

    /*---------------- User route ends here ------------------*/
});



Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
