<div class="sidebar">
    <ul class="navigation-menu">
        {{-- <li class="nav-category-divider">MAIN</li> --}}
        <li>
            <a class="c-sidebar-nav-link @if(request()->routeIs('home')) c-active @endif" href="{{route('home')}}">
                <span class="link-title">Dashboard</span>
                <i class="mdi mdi-gauge link-icon"></i>
            </a>

        </li>
        <li class="@if(request()->routeIs('leads.*')) c-show @endif">
            <a href="#sample-pages" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">Leads</span>
                <i class="mdi mdi-briefcase link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="sample-pages">
                @can('view all leads')
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.all_leads') }}"><span
                            class="c-sidebar-nav-icon"></span>All Leads</a></li>
                @endcan
                @can('view own leads')
                @cannot('view all leads')
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                        href="{{ route('leads.assigned_leads') }}"><span class="c-sidebar-nav-icon"></span>Assigned
                        Leads</a></li>
                @endcannot
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                        href="{{ route('leads.created_leads') }}"><span class="c-sidebar-nav-icon"></span>Created
                        Leads</a></li>
                @endcan
                @can('create leads')
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.create') }}"><span
                            class="c-sidebar-nav-icon"></span>Create Lead</a></li>
                @endcan
                @role('admin')
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.trashed') }}"><span
                            class="c-sidebar-nav-icon"></span>Trashed Leads</a></li>
                @endrole
                @if (auth()->user()->hasRole('client'))
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.index') }}"><span
                            class="c-sidebar-nav-icon"></span>All Leads</a></li>
                @endif
                @if (auth()->user()->hasAnyRole(['client agent', 'client manager', 'client broker']))
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('leads.index') }}"><span
                            class="c-sidebar-nav-icon"></span>Client Leads</a></li>
                @endif
                @if (auth()->user()->hasRole('client agent'))
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                        href="{{ route('leads.client_agent_leads') }}"><span class="c-sidebar-nav-icon"></span>My
                        Leads</a></li>
                @endif
            </ul>
        </li>

        @if(auth()->user()->hasRole(['call center', 'agent']))
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link @if(request()->routeIs('client.public-index')) c-active @endif" href="{{route('client.public-index')}}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{asset('svg_sprites/free.svg#cil-address-book')}}"></use>
                    </svg>
                    Client List
                </a>
            </li>
        @endif
        <li>
            <a href="#ui-elements" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">UI Elements</span>
                <i class="mdi mdi-bullseye link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="ui-elements">
                <li>
                    <a href="pages/ui-components/buttons.html">Buttons</a>
                </li>
                <li>
                    <a href="pages/ui-components/dropdowns.html">Dropdowns</a>
                </li>
                <li>
                    <a href="pages/ui-components/badges.html">Badges</a>
                </li>
                <li>
                    <a href="pages/ui-components/progress.html">Progress</a>
                </li>
                <li>
                    <a href="pages/ui-components/accordions.html">Accordion</a>
                </li>
                <li>
                    <a href="pages/ui-components/breadcrumbs.html">Breadcrumbs</a>
                </li>
                <li>
                    <a href="pages/ui-components/modals.html">Modals</a>
                </li>
                <li>
                    <a href="pages/ui-components/notifications.html">Notifications</a>
                </li>
                <li>
                    <a href="pages/ui-components/tables.html">Tables</a>
                </li>
                <li>
                    <a href="pages/ui-components/tabs.html">Tabs</a>
                </li>
                <li>
                    <a href="pages/ui-components/typography.html">Typography</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#forms" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">Forms</span>
                <i class="mdi mdi-clipboard-outline link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="forms">
                <li>
                    <a href="pages/forms/form-elements.html">Form Inputs</a>
                </li>
                <li>
                    <a href="pages/forms/form-validation.html">Validation</a>
                </li>
                <li>
                    <a href="pages/forms/editors.html">Editors</a>
                </li>
                <li>
                    <a href="pages/forms/wizard.html">Wizard</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#tables" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">Advanced Tables</span>
                <i class="mdi mdi-table-merge-cells link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="tables">
                <li>
                    <a href="pages/data-tables/basic-table.html">Basic Table</a>
                </li>
                <li>
                    <a href="pages/data-tables/complex-header.html">Complex Header</a>
                </li>
                <li>
                    <a href="pages/data-tables/scrolling-table.html">Scrolling Table</a>
                </li>
                <li>
                    <a href="pages/data-tables/ajax-table.html">Ajax Source</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#charts" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">Charts</span>
                <i class="mdi mdi-chart-donut link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="charts">
                <li>
                    <a href="pages/charts/apex-charts.html">Apex Chart</a>
                </li>
                <li>
                    <a href="pages/charts/c3.html">C3 Chart</a>
                </li>
                <li>
                    <a href="pages/charts/chartist.html">Chartist</a>
                </li>
                <li>
                    <a href="pages/charts/chartjs.html">Chart js</a>
                </li>
                <li>
                    <a href="pages/charts/morris.html">Morris</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#icons" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">Icons</span>
                <i class="mdi mdi-flower-tulip-outline link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="icons">
                <li>
                    <a href="pages/icons/font-awesome.html">Font Awesome</a>
                </li>
                <li>
                    <a href="pages/icons/simple-line.html">Simple Line</a>
                </li>
                <li>
                    <a href="pages/icons/material-icons.html">Material Icons</a>
                </li>
                <li>
                    <a href="pages/icons/flag-icons.html">Flag Icons</a>
                </li>
                <li>
                    <a href="pages/icons/themify-icons.html">Themify</a>
                </li>
            </ul>
        </li>
        <li class="nav-category-divider">APPS</li>
        <li>
            <a href="pages/apps/email.html">
                <span class="link-title">Email</span>
                <i class="mdi mdi-email-outline link-icon"></i>
            </a>
        </li>
        <li>
            <a href="pages/apps/kanban-board.html">
                <span class="link-title">Kanban Board</span>
                <i class="mdi mdi-folder-multiple-outline link-icon"></i>
            </a>
        </li>
        <li>
            <a href="#calendar-menu" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">Calendar</span>
                <i class="mdi mdi-calendar-check-outline link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="calendar-menu">
                <li>
                    <a href="pages/apps/calendar.html">List View</a>
                </li>
                <li>
                    <a href="pages/apps/calendar_2.html">Grid View</a>
                </li>
            </ul>
        </li>
        <li class="nav-category-divider">DOCS</li>
        <li>
            <a href="../docs/docs.html">
                <span class="link-title">Documentation</span>
                <i class="mdi mdi-asterisk link-icon"></i>
            </a>
        </li>
    </ul>
    <div class="sidebar_footer">
        <div class="user-account">
            {{-- <div class="user-profile-item-tittle">Switch User</div>
        <div class="user-profile-itemcategory">
          <a class="user-profile-item" href="#">
            <div class="avatar">
              <img class="profile-img img-rounded img-sm" src="http://www.placehold.it/50x50" alt="profile image"> Rodney Mann </div>
          </a>
          <a class="user-profile-item" href="#">
            <div class="avatar">
              <img class="profile-img img-rounded img-sm" src="http://www.placehold.it/50x50" alt="profile image"> Sally Stone </div>
          </a>
          <a class="user-profile-item" href="#">
            <div class="avatar">
              <img class="profile-img img-rounded img-sm" src="http://www.placehold.it/50x50" alt="profile image"> Olivia Collier </div>
          </a>
        </div> --}}
            <a class="user-profile-item" href="#"><i class="mdi mdi-account"></i> Profile</a>
            <a class="user-profile-item" href="#"><i class="mdi mdi-settings"></i> Account Settings</a>
            <a class="btn btn-primary btn-logout" href="{{ route('user.logout') }}">Logout</a>
        </div>
        <div class="btn-group admin-access-level">
            {{-- <div class="avatar">
          <img class="profile-img" src="http://www.placehold.it/50x50" alt="">
        </div> --}}
            <div class="user-type-wrapper">
                <p class="user_name">Allen Clark</p>
                <div class="d-flex align-items-center">
                    <div class="status-indicator small rounded-indicator bg-success"></div>
                    <small class="user_access_level">Admin</small>
                </div>
            </div>
            <i class="arrow mdi mdi-chevron-right"></i>
        </div>
    </div>
</div>
<div class="right-sidebar">
    <div class="sidebar-inner">
        <div class="right-sidebar-toggler"><i class="mdi mdi-format-color-fill"></i></div>
        <div class="theme-mode-wrapper">
            <a class="preview-image active" href="../demo_1/index.html" class="theme-mode">
                <img src="{{ asset('backend/assets/images/screenshots/light.png') }}" alt="Light Theme">
                <p>Light</p>
            </a>
            <a class="preview-image" href="../demo_2/index.html" class="theme-mode">
                <img src="{{ asset('backend/assets/images/screenshots/dark.png') }}" alt="Dark Theme">
                <p>Dark</p>
            </a>
        </div>
    </div>
</div>
