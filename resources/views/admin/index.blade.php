@extends('admin.admin_master')
@section('admin')
<div class="row">
    <div class="col-md-7 equel-grid order-md-2">
        <div class="grid d-flex flex-column justify-content-between overflow-hidden">
            <div class="grid-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Sales Revenue</p>
                    <div class="chartjs-legend" id="sales-revenue-chart-legend"></div>
                </div>
                <div class="d-flex">
                    <p class="d-none d-xl-block">12.5% Growth compared to the last week</p>
                    <div class="ml-auto">
                        <h2 class="font-weight-medium text-gray"><i class="mdi mdi-menu-up text-success"></i><span
                                class="animated-count">25.04</span>%</h2>
                    </div>
                </div>
            </div>
            <canvas class="mt-4" id="sales-revenue-chart" height="245"></canvas>
        </div>
    </div>
    <div class="col-md-5 order-md-0">
        <div class="row">
            <div class="col-6 equel-grid">
                <div class="grid d-flex flex-column align-items-center justify-content-center">
                    <div class="grid-body text-center">
                        <div class="profile-img img-rounded bg-inverse-primary no-avatar component-flat mx-auto mb-4"><i
                                class="mdi mdi-account-group mdi-2x"></i></div>
                        <h2 class="font-weight-medium"><span class="animated-count">21.2</span>k</h2>
                        <small class="text-gray d-block mt-3">Total Followers</small>
                        <small class="font-weight-medium text-success"><i class="mdi mdi-menu-up"></i><span
                                class="animated-count">12.01</span>%</small>
                    </div>
                </div>
            </div>
            <div class="col-6 equel-grid">
                <div class="grid d-flex flex-column align-items-center justify-content-center">
                    <div class="grid-body text-center">
                        <div class="profile-img img-rounded bg-inverse-danger no-avatar component-flat mx-auto mb-4"><i
                                class="mdi mdi-airballoon mdi-2x"></i></div>
                        <h2 class="font-weight-medium"><span class="animated-count">1.6</span>k</h2>
                        <small class="text-gray d-block mt-3">Impression</small>
                        <small class="font-weight-medium text-danger"><i class="mdi mdi-menu-down"></i><span
                                class="animated-count">03.45</span>%</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 equel-grid">
                <div class="grid d-flex flex-column align-items-center justify-content-center">
                    <div class="grid-body text-center">
                        <div class="profile-img img-rounded bg-inverse-warning no-avatar component-flat mx-auto mb-4"><i
                                class="mdi mdi-fire mdi-2x"></i></div>
                        <h2 class="font-weight-medium animated-count">2363</h2>
                        <small class="text-gray d-block mt-3">Reach</small>
                        <small class="font-weight-medium text-danger"><i class="mdi mdi-menu-down"></i><span
                                class="animated-count">12.15</span>%</small>
                    </div>
                </div>
            </div>
            <div class="col-6 equel-grid">
                <div class="grid d-flex flex-column align-items-center justify-content-center">
                    <div class="grid-body text-center">
                        <div class="profile-img img-rounded bg-inverse-success no-avatar component-flat mx-auto mb-4"><i
                                class="mdi mdi-charity mdi-2x"></i></div>
                        <h2 class="font-weight-medium"><span class="animated-count">23.6</span>%</h2>
                        <small class="text-gray d-block mt-3">Engagement Rate</small>
                        <small class="font-weight-medium text-success"><i class="mdi mdi-menu-up"></i><span
                                class="animated-count">51.03</span>%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 equel-grid">
        <div class="grid">
            <div class="grid-body py-3">
                <p class="card-title ml-n1">Order History</p>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="solid-header">
                            <th colspan="2" class="pl-4">Customer</th>
                            <th>Order No</th>
                            <th>Purchased On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="pr-0 pl-4">
                                <img class="profile-img img-sm" src="http://www.placehold.it/50x50" alt="profile image">
                            </td>
                            <td class="pl-md-0">
                                <small class="text-black font-weight-medium d-block">Barbara Curtis</small>
                                <span>
                                    <span class="status-indicator rounded-indicator small bg-primary"></span>Account
                                    Deactivated </span>
                            </td>
                            <td>
                                <small>8523537435</small>
                            </td>
                            <td> Just Now </td>
                        </tr>
                        <tr>
                            <td class="pr-0 pl-4">
                                <img class="profile-img img-sm" src="http://www.placehold.it/50x50" alt="profile image">
                            </td>
                            <td class="pl-md-0">
                                <small class="text-black font-weight-medium d-block">Charlie Hawkins</small>
                                <span>
                                    <span class="status-indicator rounded-indicator small bg-success"></span>Email
                                    Verified </span>
                            </td>
                            <td>
                                <small>9537537436</small>
                            </td>
                            <td> Mar 04, 2018 11:37am </td>
                        </tr>
                        <tr>
                            <td class="pr-0 pl-4">
                                <img class="profile-img img-sm" src="http://www.placehold.it/50x50" alt="profile image">
                            </td>
                            <td class="pl-md-0">
                                <small class="text-black font-weight-medium d-block">Nina Bates</small>
                                <span>
                                    <span class="status-indicator rounded-indicator small bg-warning"></span>Payment On
                                    Hold </span>
                            </td>
                            <td>
                                <small>7533567437</small>
                            </td>
                            <td> Mar 13, 2018 9:41am </td>
                        </tr>
                        <tr>
                            <td class="pr-0 pl-4">
                                <img class="profile-img img-sm" src="http://www.placehold.it/50x50" alt="profile image">
                            </td>
                            <td class="pl-md-0">
                                <small class="text-black font-weight-medium d-block">Hester Richards</small>
                                <span>
                                    <span class="status-indicator rounded-indicator small bg-success"></span>Email
                                    Verified </span>
                            </td>
                            <td>
                                <small>5673467743</small>
                            </td>
                            <td> Feb 21, 2018 8:34am </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a class="border-top px-3 py-2 d-block text-gray" href="#"><small class="font-weight-medium"><i
                        class="mdi mdi-chevron-down mr-2"></i>View All Order History</small></a>
        </div>
    </div>
    <div class="col-md-4 equel-grid">
        <div class="row flex-grow">
            <div class="col-12 equel-grid">
                <div class="grid widget-revenue-card">
                    <div class="grid-body d-flex flex-column h-100">
                        <div class="split-header">
                            <p class="card-title">Server Load</p>
                            <div class="content-wrapper v-centered">
                                <small class="text-muted">2h ago</small>
                                <span class="btn action-btn btn-refresh btn-xs component-flat">
                                    <i class="mdi mdi-autorenew"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <h3 class="font-weight-medium mt-2">69.05%</h3>
                            <p class="text-gray">Storage is getting full</p>
                            <div class="d-flex justify-content-between text-muted mt-3">
                                <small>Usage</small>
                                <small>35.62 GB / 2 TB</small>
                            </div>
                            <div class="progress progress-slim mt-2">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 68%"
                                    aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 equel-grid">
                <div class="grid widget-sales-card d-flex flex-column">
                    <div class="grid-body pb-3">
                        <div class="wrapper d-flex">
                            <p class="card-title">Performance</p>
                            <div class="badge badge-success ml-auto">+ 12.42%</div>
                        </div>
                        <div class="wrapper mt-2">
                            <h3>321,212</h3>
                            <small class="text-gray">More traffic in this week</small>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <canvas class="w-100" id="sales-conversion" height="70"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-sm-6 equel-grid">
        <div class="grid deposit-balance-card">
            <div class="grid-body">
                <p class="card-title">Deposits</p>
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <div id="current-circle-progress">
                            <span class="circle-progress-value font-weight-medium text-primary h4"></span>
                        </div>
                    </div>
                    <div class="col-md-12 text-center mt-4">
                        <h4 class="font-weight-medium">$32,436</h4>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-sm btn-block mt-4 btn-primary">View Transactions</button>
                    </div>
                    <div class="deposit-balance-card-footer">
                        <div class="footer-col col">
                            <small>Goal: $100k</small>
                            <div class="progress progress-slim mt-2">
                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                    role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="footer-col col">
                            <small>Duration: 23 Days</small>
                            <div class="progress progress-slim mt-2">
                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                    role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 equel-grid">
        <div class="grid">
            <div class="grid-body pb-0">
                <p class="card-title">Your top countries</p>
                <small class="mt-4">Sales performance revenue based by country</small>
                <div class="table-responsive">
                    <table class="table mt-2">
                        <tbody>
                            <tr class="text-align-edge">
                                <td class="border-top-0"><i class="flag-icon flag-icon-at"></i></td>
                                <td class="border-top-0">Austria</td>
                                <td class="border-top-0 font-weight-bold">$3,434.10</td>
                            </tr>
                            <tr class="text-align-edge">
                                <td><i class="flag-icon flag-icon-br"></i></td>
                                <td>Brazil</td>
                                <td class="font-weight-bold">$3,233.20</td>
                            </tr>
                            <tr class="text-align-edge">
                                <td><i class="flag-icon flag-icon-de"></i></td>
                                <td>Germany</td>
                                <td class="font-weight-bold">$2,345.20</td>
                            </tr>
                            <tr class="text-align-edge">
                                <td><i class="flag-icon flag-icon-fr"></i></td>
                                <td>France</td>
                                <td class="font-weight-bold">$1,671.10</td>
                            </tr>
                            <tr class="text-align-edge">
                                <td><i class="flag-icon flag-icon-ca"></i></td>
                                <td>Canada</td>
                                <td class="font-weight-bold">$1,546.00</td>
                            </tr>
                            <tr class="text-align-edge">
                                <td><i class="flag-icon flag-icon-ch"></i></td>
                                <td>Switzerland</td>
                                <td class="font-weight-bold">$1,034.10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 equel-grid">
        <div class="grid">
            <div class="grid-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Activity Log</p>
                    <div class="btn-group">
                        <button type="button" class="btn btn-trasnparent btn-xs component-flat pr-0"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Expand View</a>
                            <a class="dropdown-item" href="#">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="vertical-timeline-wrapper">
                    <div class="timeline-vertical dashboard-timeline">
                        <div class="activity-log">
                            <p class="log-name">Agnes Holt</p>
                            <div class="log-details">Analytics dashboard has been created<span
                                    class="text-primary ml-1">#Slack</span></div>
                            <small class="log-time">8 mins Ago</small>
                        </div>
                        <div class="activity-log">
                            <p class="log-name">Ronald Edwards</p>
                            <div class="log-details">Report has been updated <div class="grouped-images mt-1">
                                    <img class="img-sm" src="http://www.placehold.it/50x50" alt="Profile Image">
                                    <img class="img-sm" src="http://www.placehold.it/50x50" alt="Profile Image">
                                    <img class="img-sm" src="http://www.placehold.it/50x50" alt="Profile Image">
                                    <img class="img-sm" src="http://www.placehold.it/50x50" alt="Profile Image">
                                    <span class="plus-text img-sm">+3</span>
                                </div>
                            </div>
                            <small class="log-time">3 Hours Ago</small>
                        </div>
                        <div class="activity-log">
                            <p class="log-name">Charlie Newton</p>
                            <div class="log-details"> Approved your request <div class="wrapper mt-1">
                                    <button type="button" class="btn btn-xs btn-primary">Approve</button>
                                    <button type="button" class="btn btn-xs btn-inverse-primary">Reject</button>
                                </div>
                            </div>
                            <small class="log-time">2 Hours Ago</small>
                        </div>
                        <div class="activity-log">
                            <p class="log-name">Gussie Page</p>
                            <div class="log-details">Added new task: Slack home page</div>
                            <small class="log-time">4 Hours Ago</small>
                        </div>
                        <div class="activity-log">
                            <p class="log-name">Ina Mendoza</p>
                            <div class="log-details">Added new images</div>
                            <small class="log-time">8 Hours Ago</small>
                        </div>
                    </div>
                </div>
            </div>
            <a class="border-top px-3 py-2 d-block text-gray" href="#"><small class="font-weight-medium"><i
                        class="mdi mdi-chevron-down mr-2"></i>View All</small></a>
        </div>
    </div>
</div>

@endsection
