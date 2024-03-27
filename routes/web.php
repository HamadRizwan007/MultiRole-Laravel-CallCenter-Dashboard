<?php

use App\Http\Controllers\CallCenterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ClientAgentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientBrokerController;
use App\Http\Controllers\ClientManagerController;
use App\Http\Controllers\ClientTimetableController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SupportTicketController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth', 'check-status'])->group(function () {
    /**
     * Non Destructive Artisan Calls
     */
    Route::get('/artisan/migrate', function(){
        return Artisan::call('migrate');
    })->middleware('role:admin');

    Route::get('/artisan/clear-cache', function(){
        return Artisan::call('optimize:clear');
    })->middleware('role:admin');

    Route::get('/artisan/custom', function(){
        // return Artisan::call('');
    })->middleware('role:admin');

    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::post('/request-profile-change', [ProfileController::class, 'request_profile_change'])->name('request-profile-change');
    });

    Route::prefix('notification')->name('notification.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');
        Route::post('/read-all', [NotificationController::class, 'read_all'])->name('read-all');
        Route::get('/{notification}/read', [NotificationController::class, 'read'])->name('read');
    });

    Route::prefix('state')->name('state.')->group(function(){
        Route::get('/', [StateController::class, 'index'])->name('index')->middleware('role:admin');
        Route::get('/create', [StateController::class, 'create'])->name('create')->middleware('role:admin');
        Route::post('/store', [StateController::class, 'store'])->name('store')->middleware('role:admin');
        Route::delete('/destroy/{state}', [StateController::class, 'destroy'])->name('destroy')->middleware('role:admin');
    });

    Route::prefix('analytics')->name('analytics.')->middleware(['role:admin'])->group(function(){
        Route::get('/', [AnalyticsController::class, 'index'])->name('index');
    });

    Route::prefix('leads')->name('leads.')->group(function(){
        Route::get('/', [LeadController::class, 'index'])->name('index');
        Route::get('/trashed', [LeadController::class, 'trashed'])->name('trashed')->middleware('role:admin');
        Route::get('/all_leads', [LeadController::class, 'all_leads'])->name('all_leads')->middleware('can:view all leads');
        Route::get('/get_all_leads', [LeadController::class, 'get_all_leads'])->name('get_all_leads');
        Route::get('/assigned-leads', [LeadController::class, 'assigned_leads'])->name('assigned_leads')->middleware('can:view own leads');
        Route::get('/created-leads', [LeadController::class, 'created_leads'])->name('created_leads')->middleware('can:view own leads');
        Route::get('/call-center-leads', [LeadController::class, 'call_center_leads'])->name('call_center_leads')->middleware('can:view own leads');
        Route::get('/attached', [LeadController::class, 'client_agent_leads'])->name('client_agent_leads')->middleware('role:client agent');
        Route::get('/{lead}/show', [LeadController::class, 'show'])->name('show');
        Route::post('/{lead}/attach-client', [LeadController::class, 'attach_client'])->name('attach-client');
        Route::get('/{lead}/remove-client', [LeadController::class, 'remove_client'])->name('remove_client')->middleware('role:admin');
        Route::post('/{lead}/attach-client-agent', [LeadController::class, 'attach_client_agent'])->name('attach-client-agent');
        Route::get('/{lead}/attach-self-as-client_agent', [LeadController::class, 'attach_self_as_client_agent'])->name('attach-self-as-client_agent')->middleware('role:client agent');
        Route::get('/{lead}/remove-client-agent', [LeadController::class, 'remove_client_agent'])->name('remove_client_agent');
        Route::get('/create', [LeadController::class, 'create'])->name('create')->middleware('can:create leads');
        Route::post('/store', [LeadController::class, 'store'])->name('store')->middleware('can:create leads');
        Route::get('/{lead}/edit', [LeadController::class, 'edit'])->name('edit')->middleware('can:update leads');
        Route::put('/{lead}/update', [LeadController::class, 'update'])->name('update')->middleware('can:update leads');
        Route::delete('/{lead}/delete', [LeadController::class, 'destroy'])->name('destroy')->middleware('can:delete leads');
        Route::patch('/{lead}/update/status', [LeadController::class, 'update_status'])->name('update_status')->middleware('role:admin');
        Route::patch('/{lead}/update/payment-status', [LeadController::class, 'update_payment_status'])->name('update_payment_status')->middleware('role:admin');
    });

    Route::prefix('call-center')->name('call-center.')->group(function(){
        Route::get('/{call_center}/show', [CallCenterController::class, 'show'])->name('show');
        Route::get('/create', [CallCenterController::class, 'create'])->name('create')->middleware('can:create centers');
        Route::post('/store', [CallCenterController::class, 'store'])->name('store')->middleware('can:create centers');
        Route::get('/{status?}', [CallCenterController::class, 'index'])->name('index')->middleware('can:create centers');
        Route::get('/{call_center}/edit', [CallCenterController::class, 'edit'])->name('edit')->middleware('can:update center info');
        Route::put('/{call_center}/update', [CallCenterController::class, 'update'])->name('update')->middleware('can:update center info');
        Route::patch('/{call_center}/status/update', [CallCenterController::class, 'update_status'])->name('update-status')->middleware('can:update center info');
        Route::patch('/{call_center}/update-center', [CallCenterController::class, 'update_center'])->name('update-center')->middleware('can:update center info');
        Route::patch('/{call_center}/attach-agent', [CallCenterController::class, 'attach_agent'])->name('attach-agent')->middleware('can:update center info');
        Route::patch('/{agent}/remove-agent', [CallCenterController::class, 'remove_agent'])->name('remove-agent')->middleware('can:update center info');
    });

    Route::prefix('agent')->name('agent.')->group(function(){
        Route::get('/{agent}/show', [AgentController::class, 'show'])->name('show');
        Route::get('/create', [AgentController::class, 'create'])->name('create')->middleware('can:create agents');
        Route::post('/store', [AgentController::class, 'store'])->name('store')->middleware('can:create agents');
        Route::get('/{status?}', [AgentController::class, 'index'])->name('index')->middleware('can:create agents');
        Route::get('/{agent}/edit', [AgentController::class, 'edit'])->name('edit')->middleware('can:update agent info');
        Route::put('/{agent}/update', [AgentController::class, 'update'])->name('update')->middleware('can:update agent info');
        Route::patch('/{agent}/status/update', [AgentController::class, 'update_status'])->name('update-status')->middleware('can:update agent info');
        Route::patch('/{agent}/update-center', [AgentController::class, 'update_center'])->name('update-center')->middleware('can:update agent center');
    });

    Route::prefix('client')->name('client.')->group(function(){
        Route::prefix('/{client}/campaign')->name('campaign.')->middleware('role:admin')->group(function(){
            Route::get('create', [CampaignController::class, 'create'])->name('create');
            Route::post('/', [CampaignController::class, 'store'])->name('store');
            Route::get('/{campaign}/edit', [CampaignController::class, 'edit'])->name('edit');
            Route::put('/{campaign}', [CampaignController::class, 'update'])->name('update');
            Route::delete('/{campaign}', [CampaignController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/{client}/timetable')->name('timetable.')->middleware('role:admin')->group(function(){
            Route::post('/', [ClientTimetableController::class, 'store'])->name('store');
            Route::patch('/{timetable}', [ClientTimetableController::class, 'update'])->name('update');
        });

        Route::get('/index', [ClientController::class, 'public_index'])->name('public-index');
        Route::get('/{client}/leads', [ClientController::class, 'leads'])->name('leads')->middleware('role:admin');
        Route::get('/{client}/show', [ClientController::class, 'show'])->name('show')->middleware('can:create clients');
        Route::get('/create', [ClientController::class, 'create'])->name('create')->middleware('can:create clients');
        Route::post('/store', [ClientController::class, 'store'])->name('store')->middleware('can:create clients');
        Route::get('/{status?}', [ClientController::class, 'index'])->name('index')->middleware('can:create clients');
        Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('edit')->middleware('can:update client info');
        Route::put('/{client}/update', [ClientController::class, 'update'])->name('update')->middleware('can:update client info');
        Route::patch('/bulk-update', [ClientController::class, 'bulk_update'])->name('bulk_update')->middleware('can:update client info');
        Route::patch('/{client}/status/update', [ClientController::class, 'update_status'])->name('update-status')->middleware('can:update client info');
        Route::patch('/{client}/lead-accept-status/update', [ClientController::class, 'update_lead_accept_status'])->name('update-lead-accept-status');
        Route::post('/generate-invoice', [ClientController::class, 'generate_invoice'])->name('generate_invoice')->middleware('can:create clients');
        Route::post('/{client}/generate-invoice', [ClientController::class, 'generate_invoice'])->name('generate_invoice')->middleware('can:create clients');

    });

    Route::prefix('client-broker')->name('client-broker.')->group(function(){
        Route::get('/{client_broker}/leads', [ClientBrokerController::class, 'leads'])->name('leads')->middleware('role:admin');
        Route::get('/{client_broker}/show', [ClientBrokerController::class, 'show'])->name('show')->middleware('can:create client broker');
        Route::get('/create', [ClientBrokerController::class, 'create'])->name('create')->middleware('can:create client broker');
        Route::post('/store', [ClientBrokerController::class, 'store'])->name('store')->middleware('can:create client broker');
        Route::get('/{status?}', [ClientBrokerController::class, 'index'])->name('index')->middleware('can:create client broker');
        Route::get('/{client_broker}/edit', [ClientBrokerController::class, 'edit'])->name('edit')->middleware('can:update client broker info');
        Route::put('/{client_broker}/update', [ClientBrokerController::class, 'update'])->name('update')->middleware('can:update client broker info');
        Route::patch('/{client_broker}/status/update', [ClientBrokerController::class, 'update_status'])->name('update-status')->middleware('can:update client broker info');
        Route::patch('/{client_broker}/attach-client', [ClientBrokerController::class, 'attach_client'])->name('attach-client')->middleware('can:update client broker info');
        Route::patch('/{client}/remove-client', [ClientBrokerController::class, 'remove_client'])->name('remove-client')->middleware('can:update client broker info');
    });

    Route::prefix('client-agent')->name('client-agent.')->group(function(){
        Route::get('/{client_agent}/show', [ClientAgentController::class, 'show'])->name('show')->middleware('can:create client agents');
        Route::get('/create', [ClientAgentController::class, 'create'])->name('create')->middleware('can:create client agents');
        Route::post('/store', [ClientAgentController::class, 'store'])->name('store')->middleware('can:create client agents');
        Route::get('/{status?}', [ClientAgentController::class, 'index'])->name('index')->middleware('can:create client agents');
        Route::get('/{client_agent}/edit', [ClientAgentController::class, 'edit'])->name('edit')->middleware('can:update client agent info');
        Route::put('/{client_agent}/update', [ClientAgentController::class, 'update'])->name('update')->middleware('can:update client agent info');
        Route::patch('/{client_agent}/status/update', [ClientAgentController::class, 'update_status'])->name('update-status')->middleware('can:update client agent info');
        Route::patch('/{client_agent}/update-client', [ClientAgentController::class, 'update_client'])->name('update-client')->middleware('can:update client agent client');
    });

    Route::prefix('client-manager')->name('client-manager.')->group(function(){
        Route::get('/{client_manager}/show', [ClientManagerController::class, 'show'])->name('show')->middleware('can:create client managers');
        Route::get('/create', [ClientManagerController::class, 'create'])->name('create')->middleware('can:create client managers');
        Route::post('/store', [ClientManagerController::class, 'store'])->name('store')->middleware('can:create client managers');
        Route::get('/{status?}', [ClientManagerController::class, 'index'])->name('index')->middleware('can:create client agents');
        Route::get('/{client_manager}/edit', [ClientManagerController::class, 'edit'])->name('edit')->middleware('can:update client manager info');
        Route::put('/{client_manager}/update', [ClientManagerController::class, 'update'])->name('update')->middleware('can:update client manager info');
        Route::patch('/{client_manager}/status/update', [ClientManagerController::class, 'update_status'])->name('update-status')->middleware('can:update client manager info');
        Route::patch('/{client_manager}/update-client', [ClientManagerController::class, 'update_client'])->name('update-client')->middleware('can:update client manager client');
    });

    Route::prefix('agreements')->name('agreement.')->group(function(){
        Route::get('/', [AgreementController::class, 'index'])->name('index')->middleware('can:view all agreement');
        Route::get('/shared', [AgreementController::class, 'shared'])->name('shared')->middleware('can:view shared agreement');
        Route::get('/create', [AgreementController::class, 'create'])->name('create')->middleware('can:create agreement');
        Route::post('/store', [AgreementController::class, 'store'])->name('store')->middleware('can:create agreement');
        Route::post('/{agreement}/download', [AgreementController::class, 'download'])->name('download')->middleware('can:download agreement');
        Route::patch('/{agreement}/accept', [AgreementController::class, 'accept'])->name('accept')->middleware('can:accept agreement');
        Route::delete('/{agreement}/delete', [AgreementController::class, 'destroy'])->name('destroy')->middleware('can:delete agreement');
    });

    Route::prefix('documents')->name('document.')->group(function(){
        Route::get('/', [DocumentController::class, 'index'])->name('index')->middleware('can:view all document');
        Route::get('/personal', [DocumentController::class, 'personal'])->name('personal')->middleware('can:view personal document');
        Route::get('/create', [DocumentController::class, 'create'])->name('create')->middleware('can:create document');
        Route::post('/store', [DocumentController::class, 'store'])->name('store')->middleware('can:create document');
        Route::post('/{document}/download', [DocumentController::class, 'download'])->name('download')->middleware('can:download document');
        Route::delete('/{document}/delete', [DocumentController::class, 'destroy'])->name('destroy')->middleware('can:delete document');
    });

    Route::prefix('support-tickets')->name('tickets.')->group(function(){
        Route::get('/', [SupportTicketController::class, 'index'])->name('index')->middleware('can:view all tickets');
        Route::get('/my-tickets', [SupportTicketController::class, 'my_tickets'])->name('my-tickets')->middleware('can:view own tickets');
        Route::get('/create', [SupportTicketController::class, 'create'])->name('create')->middleware('can:create tickets');
        Route::post('/store', [SupportTicketController::class, 'store'])->name('store')->middleware('can:create tickets');
        Route::patch('/{ticket}/update-status', [SupportTicketController::class, 'update_status'])->name('update-status')->middleware('can:update tickets');
        Route::delete('/{ticket}/delete', [SupportTicketController::class, 'destroy'])->name('destroy')->middleware('can:delete tickets');
    });
});

Route::get('/logout', [UserController::class, 'user_logout'])->name('user.logout');
