<!--begin::Aside-->
<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Aside Toolbarl-->
    <div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
        <!--begin::User-->
        <div class="aside-user d-flex align-items-sm-center justify-content-center py-5">
            <!--begin::Symbol-->
            <div class="symbol symbol-50px">
                <img src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('assets/uploads/default/defaultProfile.webp') }}" alt="" />
            </div>
            <!--end::Symbol-->
            <!--begin::Wrapper-->
            <div class="aside-user-info flex-row-fluid flex-wrap ms-5">
                <!--begin::Section-->
                <div class="d-flex">
                    <!--begin::Info-->
                    <div class="flex-grow-1 me-2">
                        <!--begin::Username-->
                        <a href="#" class="text-white text-hover-primary fs-6 fw-bold">{{ auth()->user()->name }}</a>
                        <!--end::Username-->
                        <!--begin::Description-->
                        <span class="text-gray-600 fw-bold d-block fs-8 mb-1">{{ auth()->user()->role == 1 ? 'Super Admin' : 'Admin' }}</span>
                        <!--end::Description-->
                    </div>
                    <!--end::Info-->
                    @include("components/userMenu")
                </div>
                <!--end::Section-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::User-->
        <!--end::Aside user-->
    </div>
    <!--end::Aside Toolbarl-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y px-2 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
                <?php
                    $segment_1 = request()->segment(1) ?? 'dashboard';
                    $segment_2 = request()->segment(2) ?? 'dashboard';
                ?>
                <div class="menu-item">
                    <a class="menu-link {{ ($segment_1 == 'dashboard'  ? 'active': '') }}" href="/">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>
                {{-- start::Route Management --}}
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == 'route' ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fas fa-bus-alt"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">Route Management</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <?php
                        $routes = array('routes', 'routeAdd', 'routeEdit');
                    ?>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $routes) ? 'active' : '' }}" href="/route/routes">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Routes</span>
                            </a>
                        </div>
                        <?php
                            $stopages = array('stoppages', 'stoppageAdd', 'stoppageEdit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $stopages) ? 'active' : '' }}" href="/route/stoppages">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Stopages</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- end::Route Management --}}

                {{-- start::Our Employees --}}
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == 'employee' ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fa fa-id-card" aria-hidden="true"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">Our Employees</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <?php
                            $employees = array('employees', 'employeeAdd', 'employeeEdit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $employees) || (request()->segment(2) == 'employeeAdd') ? 'active' : '' }}" href="/employee/employees">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Employees</span>
                            </a>
                        </div>
                        <?php
                            $departments = array('departments', 'departmentAdd', 'departmentEdit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $departments) ? 'active' : '' }}" href="/employee/departments">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Departments</span>
                            </a>
                        </div>
                        <?php
                            $designations = array('designations', 'designationAdd', 'designationEdit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $designations) ? 'active' : '' }}" href="/employee/designations">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Designations</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- end::Our Employees --}}

                {{-- start::Vehicle Management --}}
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == 'vehicle' ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fas fa-bus-alt"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">Vehicle Management</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <?php
                            $vehicles = array('vehicles', 'vehicleAdd', 'vehicleEdit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_1 == 'vehicle' && $segment_2 == in_array($segment_2,  $vehicles) ? 'active' : '' }}" href="/vehicle/vehicles">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Vehicles</span>
                            </a>
                        </div>
                        <?php
                            $vehicleTypes = array('vehicleTypes', 'typeEdit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $vehicleTypes) ? 'active' : '' }}" href="/vehicle/vehicleTypes">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Vehicle Type</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- end::Vehicle Management --}}

                {{-- start::Vehicle Requisition Management--}}
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == 'requisition' || $segment_1 == 'trip' ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fas fa-bus"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">Vehicle Requisition</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <?php
                            $tripVehicles = array('vehicles', 'send', 'edit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_1 == 'requisition' && $segment_2 == in_array($segment_2,  $tripVehicles) ? 'active' : '' }}" href="/requisition/vehicles">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Vehicles</span>
                            </a>
                        </div>
                        <?php
                            $triphistory = array('history', 'vehicleTrips');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $triphistory) ? 'active' : '' }}" href="/trip/history">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Trip History</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- end::Vehicle Requisition --}}

                {{-- start::Fuel --}}
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == 'fuel' ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fas fa-gas-pump"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">Fuel</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <?php
                            $fuelVehicles = array('fuelVehicles', 'fuelAdd');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $fuelVehicles)  ? 'active' : '' }}" href="/fuel/fuelVehicles">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Vehicles</span>
                            </a>
                        </div>
                        <?php
                            $fuelRecords = array('fuelRecords', 'vehicleFuels', 'edit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $fuelRecords)  ? 'active' : '' }}" href="/fuel/fuelRecords">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Fuel Records</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- end::Fuel Requisition --}}
                {{-- start::Meter --}}
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == 'meter' ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fas fa-weight"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">Meter</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <?php
                            $meter_vehicles_segments = array('meterVehicles', 'meterEntryAdd');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{  $segment_2 == in_array($segment_2,  $meter_vehicles_segments) ? 'active' : '' }}" href="/meter/meterVehicles">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Vehicles</span>
                            </a>
                        </div>
                        <?php
                            $meter_entries_segments = array('meterEntries', 'vehicleMeterEntries', 'edit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{  $segment_2 == in_array($segment_2,  $meter_entries_segments) ? 'active' : '' }}" href="/meter/meterEntries">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Meter Entries</span>
                            </a>
                        </div>
                    </div>

                </div>
                {{-- end::VehiFuelcle Requisition --}}

                {{-- start::Maintenance Requisition --}}
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == 'maintenance' ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fas fa-money-bill"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">Maintenance</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <?php
                            $maintenance_vehicles = array('maintenanceVehicles', 'maintenanceAdd');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $maintenance_vehicles) ? 'active' : '' }}" href="/maintenance/maintenanceVehicles">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Vehicles</span>
                            </a>
                        </div>
                        <?php
                            $maintenance_records = array('maintenanceRecords', 'vehicleMaintenanceRecords', 'edit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $maintenance_records) ? 'active' : '' }}" href="/maintenance/maintenanceRecords">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Maintenance Records</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- end::Maintenance Requisition --}}

                 {{-- start::Maintenance Requisition --}}
                 <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == 'summery' ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fas fa-money-bill"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">Summery</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <?php
                            $summery_table = array('table', 'filter');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $summery_table) ? 'active' : '' }}" href="/summery/table">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Table</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- end::Maintenance Requisition --}}

                {{-- start::Reminder --}}
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == 'reminder' ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fas fa-bell"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">Reminder</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <?php
                            $reminders_segments = array('reminders', 'reminderAdd');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $reminders_segments) ? 'active' : '' }}" href="/reminder/reminders">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Reminders</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- end::Reminder --}}

                {{-- start::Notice & Schedule --}}
                <?php
                    $ns_segments = array('notice', 'schedule');
                ?>
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == in_array($segment_1,  $ns_segments) ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fas fa-bell"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">Notice & Schedule</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <?php
                            $notice_segments = array('notices', 'noticeAdd', 'noticeEdit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $notice_segments) ? 'active' : '' }}" href="/notice/notices">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Notices</span>
                            </a>
                        </div>
                        <?php
                            $schedule_segments = array('schedules', 'scheduleAdd', 'scheduleEdit');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $schedule_segments) ? 'active' : '' }}" href="/schedule/schedules">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Schedules</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- end::Notice & Schedule --}}

                {{-- start::Chat --}}
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == 'chat' ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fas fa-print"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">Chat</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <?php
                            $chats = array('chats', 'chatSearch');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $chats) ? 'active' : '' }}" href="/chat/chats">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Chats</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- end::Report --}}

                {{-- start::User Management --}}
                @if(auth()->user()->role == 1)
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $segment_1 == 'user' ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Icon-->
                            <i class="fas fa-user-edit"></i>
                            <!--end::Icon-->
                        </span>
                        <span class="menu-title">User's</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <?php
                            $users_segments = array('users', 'add');
                        ?>
                        <div class="menu-item">
                            <a class="menu-link {{ $segment_2 == in_array($segment_2,  $users_segments)  ? 'active' : '' }}" href="/user/users">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Users</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                {{-- end::Route Management --}}

                <div class="menu-item">
                    <div class="menu-content">
                        <div class="separator mx-1 my-4"></div>
                    </div>
                </div>
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->
    <!--begin::Footer-->
    <div class="aside-footer flex-column-auto py-5" id="kt_aside_footer">
        <a href="/logout" data-bs-toggle="modal" class="btn btn-custom btn-primary w-100" data-bs-target="#kt_modal_create_api_key" class="menu-link px-5">
            <span class="btn-label">Sign Out</span>
        </a>
    </div>
    <!--end::Footer-->
</div>
<!--end::Aside-->
