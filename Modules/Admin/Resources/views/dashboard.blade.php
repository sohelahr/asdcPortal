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
                                    Weekly New Users
                                </p>
                                <h2>{{$user_stats['new_count']}}</h2>
                                @if($user_stats['type'] == 1)
                                    <label class="badge badge-outline-success badge-pill">{{$user_stats['percent']}}% increase</label>
                                @elseif($user_stats['type'] == -1)
                                    <label class="badge badge-outline-danger badge-pill">{{$user_stats['percent']}}% decrease</label>
                                @endif
                            </div>
                            <div class="statistics-item">
                                <p>
                                    <i class="icon-sm fas fa-hourglass-half mr-2"></i>
                                    Registrations
                                </p>
                                <h2>{{$data['total_registrations']}}</h2>
                                <label class="badge badge-outline-primary badge-pill">-----------</label>
                            </div>
                            <div class="statistics-item">
                                <p>
                                    <i class="icon-sm fas fa-cloud-download-alt mr-2"></i>
                                    Admissions
                                </p>
                                <h2>{{$data['total_admissions']}}</h2>
                                <label class="badge badge-outline-primary badge-pill">-----------</label>
                            </div>
                            <div class="statistics-item">
                                <p>
                                    <i class="icon-sm fas fa-check-circle mr-2"></i>
                                    Batches/Active Slots
                                </p>
                                <h2>{{$data['total_batches']}} / {{$data['total_slots']}}</h2>
                                <label class="badge badge-outline-primary badge-pill">-----------</label>
                            </div>
                            <div class="statistics-item">
                                <p>
                                    <i class="icon-sm fas fa-chart-line mr-2"></i>
                                    Cancellations/Terminations
                                </p>
                                <h2>{{$data['total_cancellations']}} / {{$data['total_terminations']}}</h2>
                                <label class="badge badge-outline-primary badge-pill">-----------</label>
                            </div>
                            <div class="statistics-item">
                                <p>
                                    <i class="icon-sm fas fa-circle-notch mr-2"></i>
                                    Total Employments
                                </p>
                                <h2>{{$data['total_employments']}}</h2>
                                <label class="badge badge-outline-primary badge-pill">-----------</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        {{-- <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                  <h4 class="card-title">
                    <i class="fas fa-chart-line"></i>
                    Users
                  </h4>
                  <canvas id="reg_admission_chart" width="368" height="183" style="display: block; height: 147px; width: 295px;" class="chartjs-render-monitor">
                    </canvas>
                </div>
              </div>
            </div> --}}
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Total Registrations</h4>
                        <canvas id="total_registrations"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Course Wise Admissions</h4>
                        <canvas id="course_wise_admissions"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">How did Students reach us</h4>
                        <canvas id="reach_source"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Course Wise Employments</h4>
                        <canvas id="course_wise_employements"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-md-row justify-content-between align-items-center">
                            <div>
                            <h4 class="card-title mb-0">Course Wise Capacities</h4>
                            </div>
                            <div class="col-4">
                                <select class="form-control" id="change_gauge">
                                    @foreach ($courses as $course)
                                        <option value="{{$course->id}}">{{$course->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="course_gauges_container" class="d-flex justiy-content-center">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jcontent')
<script>
    let piedata = JSON.parse('{!! $course_wise_admissions_graphs !!}');
    let doughtnutdata = JSON.parse('{!! $reach_graphs !!}');
    let linedata = JSON.parse('{!! $registration_graphs !!}');
    let gaugedata = JSON.parse('{!! $initial_gauges !!}');

    $(document).ready(function () {
        generatePieChart(piedata);
        generateDoughnutChart(doughtnutdata);
        generateBarChart(piedata);
        generateLineChart(linedata);
        generateGauges(gaugedata);
    });

    $('#change_gauge').on('change',function(){
        let id = $('#change_gauge').val();
        $.ajax({
            type: "get",
            url: `{{url('admin/get-gauge/${id}')}}`,
            success: function (response) {
                let gaugedata = JSON.parse(response);
                generateGauges(gaugedata);
            }
        });
    });

    function generatePieChart(piedata){
        const data = {
            labels: piedata.labels,
            datasets: [{
                label: 'Course Wise Admission',
                data: piedata.count,
                backgroundColor: piedata.colors,
                hoverOffset: 4
            }],
            
        };
        const options = {
                    legend : {
                        position:'right',
                        align:'start',
                        labels:{
                            boxWidth:10,
                        }
                    },
                    
                }
        const config = {
            type: 'pie',
            data: data,
            options: options,
        };
        const myChart = new Chart(
            document.getElementById('course_wise_admissions'),
            config
        );
    }

    function generateDoughnutChart(doughtnutdata) {
        console.log(doughtnutdata);
         const data = {
            labels: doughtnutdata.labels,
            datasets: [{
                label: 'Course Wise Admission',
                data: doughtnutdata.count,
                backgroundColor: doughtnutdata.colors,
                hoverOffset: 4
            }],
            
        };
        const options = {
                    legend : {
                        position:'right',
                        align:'start',
                        labels:{
                            boxWidth:10,
                        }
                    },
                    
                }
        const config = {
            type: 'doughnut',
            data: data,
            options: options,
        };
        const myChart = new Chart(
            document.getElementById('reach_source'),
            config
        );   
    }

    
    function generateBarChart(bardata) {
        const data = {
            labels: piedata.labels,
            data: {
                datasets: [{
                    type: 'bar',
                    label: 'Bar Dataset',
                    data: piedata.count,
                }, {
                    type: 'bar',
                    label: 'Line Dataset',
                    data: piedata.count,
                }],
                minBarLength: 2,
                labels:  piedata.labels,
            },
        };
        
        const config = {
            type: 'bar',
            data: data,
            options:{
                scales: {
                    barValueSpacing: 20,
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontSize: 8,
                            callback: function(value, index, values) {
                                return  value.split(" ").join("\n")
                            }
                        },
                        align:'center',
                    }]
                }
            }
        };
        const someChart = new Chart(
            document.getElementById('course_wise_employements'),
            config
        );
    }

    function generateLineChart(linedata){
        console.log('line data ',linedata)
        const data = {
            labels: linedata.labels,
            datasets: [{
                fill: false,
                borderColor:'#392C70',
                label: 'Course Wise Admission',
                data: linedata.count,
                backgroundColor: 'transparent',
                hoverOffset: 4
            }],
            
        };
        const options = {
                    legend : {
                        display:false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }              
                }
        const config = {
            type: 'line',
            data: data,
            options: options,
        };
        const myChart = new Chart(
            document.getElementById('total_registrations'),
            config
        );
    }

    function generateGauges(gaugedata){
        var gauges = [];
        console.log(gaugedata)
        $('#course_gauges_container').empty();
        gaugedata.map((courseslot)=>{
            $('#course_gauges_container').append(`
                    <div id="gauge_${courseslot.id}"><div>
            `);
            let gauge =  new JustGage({
                    id: "gauge_"+courseslot.id, // the id of the html element
                    value: courseslot.TotalCapacity - courseslot.CurrentCapacity,
                    min: 0,
                    max: courseslot.TotalCapacity,
                    gaugeWidthScale: 0.6,
                    label:courseslot.name,
                    labelFontColor:'black'
                });
            gauges.push(gauge);
        }) 
    }
</script>
@endsection
