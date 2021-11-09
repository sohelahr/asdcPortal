@extends('layouts.admin.app')
@section('title')
    <title>Dashboard</title>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                Dashboard
            </h3>
        </div>
        <div class="row grid-margin">
            <div class="col-12">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <div class="statistics-item">
                                <p>
                                    <i class="icon-sm fa fa-user mr-2"></i>
                                    New users this week
                                </p>
                                <div class="text-center">
                                <h2>{{$data['new_users']}}</h2>
                                </div>
                                <label class="badge badge-outline-success badge-pill">{{$data['new_user_percent']}}% increase</label>
                            </div>
                            <div class="statistics-item">
                                <p>
                                    <i class="icon-sm fas fa-hourglass-half mr-2"></i>
                                    Avg Time
                                </p>
                                <h2>123.50</h2>
                                <label class="badge badge-outline-danger badge-pill">30% decrease</label>
                            </div>
                            <div class="statistics-item">
                                <p>
                                    <i class="icon-sm fas fa-cloud-download-alt mr-2"></i>
                                    Total Registration
                                </p>
                                <h2>{{$data['total_registration']}}</h2>
                                <label class="badge badge-outline-success badge-pill">{{$data['new_reg_percent']}}% increase</label>
                            </div>
                            <div class="statistics-item">
                                <p>
                                    <i class="icon-sm fas fa-check-circle mr-2"></i>
                                    Update
                                </p>
                                <h2>7500</h2>
                                <label class="badge badge-outline-success badge-pill">57% increase</label>
                            </div>
                            <div class="statistics-item">
                                <p>
                                    <i class="icon-sm fas fa-chart-line mr-2"></i>
                                    Sales
                                </p>
                                <h2>9000</h2>
                                <label class="badge badge-outline-success badge-pill">10% increase</label>
                            </div>
                            <div class="statistics-item">
                                <p>
                                    <i class="icon-sm fas fa-circle-notch mr-2"></i>
                                    Pending
                                </p>
                                <h2>7500</h2>
                                <label class="badge badge-outline-danger badge-pill">16% decrease</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                  <h4 class="card-title">
                    <i class="fas fa-chart-line"></i>
                    Users
                  </h4>
                  <h2 class="mb-5">{{$data['total_users']}} <span class="text-muted h4 font-weight-normal">Users</span></h2>
                  <canvas id="reg_admission_chart" width="368" height="183" style="display: block; height: 147px; width: 295px;" class="chartjs-render-monitor">
                    </canvas>
                </div>
              </div>
            </div>
        <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                  <h4 class="card-title">Pie chart</h4>
                  <canvas id="pieChart" width="391" height="195" style="display: block; height: 156px; width: 313px;" class="chartjs-render-monitor"></canvas>
                </div>
              </div>
            </div>
        
    </div>
@endsection
@section('jcontent')
<script>
    const labels = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        ];
    const data = {
        labels: labels,
        datasets: [{
            label: 'Users',
            borderColor: '#392c70',
            data: [0, 10, 5, 2, 20, 30, 45],
            tension: 0.1
        }]
    };
    const config = {
        type: 'line',
        data: data,
        options: {
            plugins:{
                legend:{
                    display:false,
                }
            }
        }
    };
    const myChart = new Chart(
        document.getElementById('reg_admission_chart'),
        config
    );

</script>
@endsection
