@extends('admin.layouts.master')

@push('css')

@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("Dashboard")])
@endsection

@section('content')
    <div class="dashboard-area">
        <div class="dashboard-item-area">
            <div class="row">
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Users") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$users }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Active") }} {{ @$activeUsers }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart6" data-percent="{{ ($users != 0) ? intval(($activeUsers/$users)*100) : '0' }}">
                                    <span>
                                        @if($users != 0)
                                            {{ intval(($activeUsers/$users)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Active Users") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count"> {{ @$activeUsers }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{ __("Total") }} {{ @$users }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart7" data-percent="{{ ($users != 0) ? intval(($activeUsers/$users)*100) : '0' }}">
                                    <span>
                                        @if($users != 0)
                                            {{ intval(($activeUsers/$users)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Verified Users") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$verifiedUsers }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{ __("Total") }} {{ @$users }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart8" data-percent="{{ ($users != 0) ? intval(($verifiedUsers/$users)*100) : '0' }}">
                                    <span>
                                        @if($users != 0)
                                            {{ intval(($verifiedUsers/$users)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Banned Users") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$bannedUsers }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{ __("Total") }} {{ @$users }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart9" data-percent="{{ ($users != 0) ? intval(($bannedUsers/$users)*100) : '0' }}">
                                    <span>
                                        @if($users != 0)
                                            {{ intval(($bannedUsers/$users)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Schedules") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$schedules }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--warning">{{ __("Active") }} {{ @$activeSchedules  }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart10" data-percent="{{ ($schedules != 0) ? intval(($activeSchedules/$schedules)*100) : '0' }}">
                                    <span>
                                        @if($schedules != 0)
                                            {{ intval(($activeSchedules/$schedules)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Active Schedules") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$activeSchedules  }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{ __("Total") }} {{ @$schedules }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart11" data-percent="{{ ($schedules != 0) ? intval(($activeSchedules/$schedules)*100) : '0' }}">
                                    <span>
                                        @if($schedules != 0)
                                            {{ intval(($activeSchedules/$schedules)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Banned Schedules") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$bannedSchedules }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{ __("Total") }} {{ @$schedules }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart12" data-percent="{{ ($schedules != 0) ? intval(($bannedSchedules/$schedules)*100) : '0' }}">
                                    <span>
                                        @if($schedules != 0)
                                            {{ intval(($bannedSchedules/$schedules)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Videos") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$videos }}</h2>
                                </div>
                            </div>
                            {{-- <div class="right">
                                <div class="chart" id="chart13" data-percent="75"><span>{{ __("100%") }}</span></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Announcements") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$announcements }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Active") }} {{ @$activeAnnouncements }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart14" data-percent="{{ ($announcements != 0) ? intval(($activeAnnouncements/$announcements)*100) : '0' }}">
                                    <span>
                                        @if($announcements != 0)
                                            {{ intval(($activeAnnouncements/$announcements)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Active Announcements") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$activeAnnouncements }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Total") }} {{ @$announcements }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart15" data-percent="{{ ($announcements != 0) ? intval(($activeAnnouncements/$announcements)*100) : '0' }}">
                                    <span>
                                        @if($announcements != 0)
                                            {{ intval(($activeAnnouncements/$announcements)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Banned Announcements") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$bannedAnnouncements }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Total") }} {{ @$announcements }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart16" data-percent="{{ ($announcements != 0) ? intval(($bannedAnnouncements/$announcements)*100) : '0' }}">
                                    <span>
                                        @if($announcements != 0)
                                            {{ intval(($bannedAnnouncements/$announcements)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Subscribers") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$subscribers }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--info">{{ __("This Month") }} {{ $currentMonthSubscribers }}</span>
                                    <span class="badge badge--warning">{{ __("This Year") }} {{ $currentYearSubscribers }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart17" data-percent="{{ ($subscribers != 0) ? intval(($currentMonthSubscribers/$subscribers)*100) : '0' }}">
                                    <span>
                                        @if($subscribers != 0)
                                            {{ intval(($currentMonthSubscribers/$subscribers)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Messages") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$messages }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Replied") }} {{ @$repliedMessages }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart18" data-percent="{{ ($messages != 0) ? intval(($repliedMessages/$messages)*100) : '0' }}">
                                    <span>
                                        @if ($messages != 0)
                                            {{ intval(($repliedMessages / $messages) * 100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Replied Messages") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$repliedMessages }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Total") }} {{ @$messages }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart19" data-percent="{{ ($messages != 0) ? intval(($repliedMessages/$messages)*100) : '0' }}">
                                    <span>
                                        @if ($messages != 0)
                                            {{ intval(($repliedMessages / $messages) * 100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Unanswered Messages") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ @$unansweredMessages }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Total") }} {{ @$messages }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart20" data-percent="{{ ($messages != 0) ? intval(($unansweredMessages/$messages)*100) : '0' }}">
                                    <span>
                                        @if($messages != 0)
                                            {{ intval(($unansweredMessages/$messages)*100) }}%
                                        @else
                                            0%
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Teams") }}</h6>
                                <div class="user-info">
                                    @if(isset($team->value->items))
                                        <h2 class="user-count">{{ count(get_object_vars($team->value->items)) }}</h2>
                                    @else
                                        <h2 class="user-count">0%</h2>
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="right">
                                <div class="chart" id="chart21" data-percent="75"><span>100%</span></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

@endpush
