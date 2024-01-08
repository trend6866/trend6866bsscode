{{-- @extends('layouts.app')

@section('page-title', __('Dashboard'))

@section('action-button')
@endsection

@section('breadcrumb')
@endsection

@section('content')    
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-6">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-home"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Total Products') }}</p>
                                    <h6 class="mb-3">Users</h6>
                                    <h3 class="mb-0">930 <span class="text-success text-sm">
                                        <i class="ti ti-arrow-narrow-up"></i> +55%</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-click"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Total Sales') }}</p>
                                    <h6 class="mb-3">New Users</h6>
                                    <h3 class="mb-0">744 <span class="text-danger text-sm"><i
                                                class="ti ti-arrow-narrow-down"></i> +55%</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Total Orders') }}</p>
                                    <h6 class="mb-3">Sessions</h6>
                                    <h3 class="mb-0">1,414 <span class="text-success text-sm"><i
                                                class="ti ti-arrow-narrow-up"></i> +55%</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-danger">
                                        <i class="ti ti-thumb-up"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">Statistics</p>
                                    <h6 class="mb-3">Page/Sessions</h6>
                                    <h3 class="mb-0">1.76 <span class="text-danger text-sm"><i
                                                class="ti ti-arrow-narrow-down"></i> +55%</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5>Sales by Country</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/pages/flag.svg') }}" class="wid-25"
                                                        alt="images">
                                                    <div class="ms-3">
                                                        <small class="text-muted">Country:</small>
                                                        <h6 class="m-0">United States</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">Sales:</small>
                                                <h6 class="m-0">2500</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Value:</small>
                                                <h6 class="m-0">$230,900</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Bounce:</small>
                                                <h6 class="m-0">29.9%</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/pages/flag.svg') }}" class="wid-25"
                                                        alt="images">
                                                    <div class="ms-3">
                                                        <small class="text-muted">Country:</small>
                                                        <h6 class="m-0">United States</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">Sales:</small>
                                                <h6 class="m-0">2500</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Value:</small>
                                                <h6 class="m-0">$230,900</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Bounce:</small>
                                                <h6 class="m-0">29.9%</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/pages/flag.svg') }}" class="wid-25"
                                                        alt="images">
                                                    <div class="ms-3">
                                                        <small class="text-muted">Country:</small>
                                                        <h6 class="m-0">United States</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">Sales:</small>
                                                <h6 class="m-0">2500</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Value:</small>
                                                <h6 class="m-0">$230,900</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Bounce:</small>
                                                <h6 class="m-0">29.9%</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/pages/flag.svg') }}" class="wid-25"
                                                        alt="images">
                                                    <div class="ms-3">
                                                        <small class="text-muted">Country:</small>
                                                        <h6 class="m-0">United States</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">Sales:</small>
                                                <h6 class="m-0">2500</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Value:</small>
                                                <h6 class="m-0">$230,900</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Bounce:</small>
                                                <h6 class="m-0">29.9%</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/pages/flag.svg') }}"
                                                        class="wid-25" alt="images">
                                                    <div class="ms-3">
                                                        <small class="text-muted">Country:</small>
                                                        <h6 class="m-0">United States</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">Sales:</small>
                                                <h6 class="m-0">2500</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Value:</small>
                                                <h6 class="m-0">$230,900</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Bounce:</small>
                                                <h6 class="m-0">29.9%</h6>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Traffic channels</h5>
                        </div>
                        <div class="card-body">
                            <div id="traffic-chart"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="bg-primary rounded p-3">
                                <div id="user-chart"></div>
                            </div>
                            <h4 class="mt-4 mb-0">Active Users</h4>
                            <span class="text-sm text-muted">(+23%) than last week</span>
                            <div class="row mt-4">

                                <div class="col-md-3 col-6 my-2">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-home"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">Clicks</p>
                                            <h4 class="mb-0 text-primary">2m</h4>
                                            <div class="progress mb-0">
                                                <div class="progress-bar bg-primary" style="width: 58%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 my-2">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-info">
                                            <i class="ti ti-home"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">Users</p>
                                            <h4 class="mb-0 text-info">36K</h4>
                                            <div class="progress mb-0">
                                                <div class="progress-bar bg-info" style="width: 78%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 my-2">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-warning">
                                            <i class="ti ti-home"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">Items</p>
                                            <h4 class="mb-0 text-warning">43</h4>
                                            <div class="progress mb-0">
                                                <div class="progress-bar bg-warning" style="width: 40%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 my-2">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-danger">
                                            <i class="ti ti-home"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">Sales</p>
                                            <h4 class="mb-0 text-danger">435$</h4>
                                            <div class="progress mb-0">
                                                <div class="progress-bar bg-danger" style="width: 30%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- [ sample-page ] end -->
    {{-- </div>
@endsection

@push('custom-script')
    <script>
        (function() {
            var options = {
                chart: {
                    height: 150,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Refferal',
                    data: [20, 50, 30, 60, 40, 50, 40]
                }, {
                    name: 'Organic search',
                    data: [40, 20, 60, 15, 50, 65, 20]
                }],
                xaxis: {
                    categories: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                },
                colors: ['#ffa21d', '#FF3A6E'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                markers: {
                    size: 4,
                    colors: ['#ffa21d', '#FF3A6E'],
                    opacity: 0.9,
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                yaxis: {
                    tickAmount: 3,
                    min: 10,
                    max: 70,
                }
            };
            var chart = new ApexCharts(document.querySelector("#traffic-chart"), options);
            chart.render();
        })();
        (function() {
            var options = {
                chart: {
                    type: 'bar',
                    height: 140,
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                colors: ["#fff"],
                plotOptions: {
                    bar: {
                        color: '#fff',
                        columnWidth: '20%',
                    }
                },
                fill: {
                    type: 'solid',
                    opacity: 1,
                },
                series: [{
                    data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 25, 44, 12]
                }],
                xaxis: {
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                    crosshairs: {
                        width: 0
                    },
                    labels: {
                        show: false,
                    },
                },
                yaxis: {
                    tickAmount: 3,
                    labels: {
                        style: {
                            colors: "#fff"
                        }
                    },
                },
                grid: {
                    borderColor: '#ffffff00',
                    padding: {
                        bottom: 0,
                        left: 10,
                    }
                },
                tooltip: {
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function(seriesName) {
                                return 'Total Earnings'
                            }
                        }
                    },
                    marker: {
                        show: false
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#user-chart"), options);
            chart.render();
        })();
    </script>
@endpush --}}

@extends('layouts.app')

@section('page-title', __('Dashboard'))

@section('action-button')
@endsection

@section('breadcrumb')
@endsection

@section('content')    
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-6">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-home"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Total Products') }}</p>
                                    <h6 class="mb-3">Users</h6>
                                    <h3 class="mb-0">930 <span class="text-success text-sm">
                                        <i class="ti ti-arrow-narrow-up"></i> +55%</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-info">
                                        <i class="ti ti-click"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Total Sales') }}</p>
                                    <h6 class="mb-3">New Users</h6>
                                    <h3 class="mb-0">744 <span class="text-danger text-sm"><i
                                                class="ti ti-arrow-narrow-down"></i> +55%</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Total Orders') }}</p>
                                    <h6 class="mb-3">Sessions</h6>
                                    <h3 class="mb-0">1,414 <span class="text-success text-sm"><i
                                                class="ti ti-arrow-narrow-up"></i> +55%</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="theme-avtar bg-danger">
                                        <i class="ti ti-thumb-up"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">Statistics</p>
                                    <h6 class="mb-3">Page/Sessions</h6>
                                    <h3 class="mb-0">1.76 <span class="text-danger text-sm"><i
                                                class="ti ti-arrow-narrow-down"></i> +55%</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5>Sales by Country</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/pages/flag.svg') }}" class="wid-25"
                                                        alt="images">
                                                    <div class="ms-3">
                                                        <small class="text-muted">Country:</small>
                                                        <h6 class="m-0">United States</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">Sales:</small>
                                                <h6 class="m-0">2500</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Value:</small>
                                                <h6 class="m-0">$230,900</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Bounce:</small>
                                                <h6 class="m-0">29.9%</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/pages/flag.svg') }}" class="wid-25"
                                                        alt="images">
                                                    <div class="ms-3">
                                                        <small class="text-muted">Country:</small>
                                                        <h6 class="m-0">United States</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">Sales:</small>
                                                <h6 class="m-0">2500</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Value:</small>
                                                <h6 class="m-0">$230,900</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Bounce:</small>
                                                <h6 class="m-0">29.9%</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/pages/flag.svg') }}" class="wid-25"
                                                        alt="images">
                                                    <div class="ms-3">
                                                        <small class="text-muted">Country:</small>
                                                        <h6 class="m-0">United States</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">Sales:</small>
                                                <h6 class="m-0">2500</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Value:</small>
                                                <h6 class="m-0">$230,900</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Bounce:</small>
                                                <h6 class="m-0">29.9%</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/pages/flag.svg') }}" class="wid-25"
                                                        alt="images">
                                                    <div class="ms-3">
                                                        <small class="text-muted">Country:</small>
                                                        <h6 class="m-0">United States</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">Sales:</small>
                                                <h6 class="m-0">2500</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Value:</small>
                                                <h6 class="m-0">$230,900</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Bounce:</small>
                                                <h6 class="m-0">29.9%</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/pages/flag.svg') }}"
                                                        class="wid-25" alt="images">
                                                    <div class="ms-3">
                                                        <small class="text-muted">Country:</small>
                                                        <h6 class="m-0">United States</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">Sales:</small>
                                                <h6 class="m-0">2500</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Value:</small>
                                                <h6 class="m-0">$230,900</h6>
                                            </td>
                                            <td>
                                                <small class="text-muted">Bounce:</small>
                                                <h6 class="m-0">29.9%</h6>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Traffic channels</h5>
                        </div>
                        <div class="card-body">
                            <div id="traffic-chart"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="bg-primary rounded p-3">
                                <div id="user-chart"></div>
                            </div>
                            <h4 class="mt-4 mb-0">Active Users</h4>
                            <span class="text-sm text-muted">(+23%) than last week</span>
                            <div class="row mt-4">

                                <div class="col-md-3 col-6 my-2">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-home"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">Clicks</p>
                                            <h4 class="mb-0 text-primary">2m</h4>
                                            <div class="progress mb-0">
                                                <div class="progress-bar bg-primary" style="width: 58%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 my-2">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-info">
                                            <i class="ti ti-home"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">Users</p>
                                            <h4 class="mb-0 text-info">36K</h4>
                                            <div class="progress mb-0">
                                                <div class="progress-bar bg-info" style="width: 78%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 my-2">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-warning">
                                            <i class="ti ti-home"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">Items</p>
                                            <h4 class="mb-0 text-warning">43</h4>
                                            <div class="progress mb-0">
                                                <div class="progress-bar bg-warning" style="width: 40%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 my-2">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-danger">
                                            <i class="ti ti-home"></i>
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">Sales</p>
                                            <h4 class="mb-0 text-danger">435$</h4>
                                            <div class="progress mb-0">
                                                <div class="progress-bar bg-danger" style="width: 30%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- [ sample-page ] end -->
    </div>
@endsection
