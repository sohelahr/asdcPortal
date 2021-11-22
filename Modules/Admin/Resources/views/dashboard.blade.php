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
            <div class="float-right">
                <a href="{{url("admin/import-index")}}" class="btn btn-outline-primary" >Import Registrations<a>
            </div>
        </div>
        <div class="row grid-margin">
            <div class="col-12">
                <div class="card">
                        
                    <div class="card-body">
                        
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-2 col-md-4 col-sm-6 align-items-center">
                                    <div class="counter">
                                        <div class="counter-icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <span class="counter-value">{{$user_stats['new_count']}}</span>
                                        <h3>Weekly New Users</h3>
                                        
                                    </div>
                                    <div>
                                    {{-- @if($user_stats['type'] == 1)
                                        <label class="badge badge-outline-success badge-pill">{{$user_stats['percent']}}% increase</label>
                                    @elseif($user_stats['type'] == -1)
                                        <label class="badge badge-outline-danger badge-pill">{{$user_stats['percent']}}% decrease</label>
                                    @endif --}}
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <div class="counter second">
                                        <div class="counter-icon">
                                            <i class="	fas fa-file-alt"></i>
                                        </div>
                                        <span class="counter-value">{{$data['total_registrations']}}</span>
                                        <h3>Registrations</h3>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 align-items-center">
                                    <div class="counter third">
                                        <div class="counter-icon">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                        <span class="counter-value">{{$data['total_admissions']}}</span>
                                        <h3>Admissions</h3>
                                        
                                    </div>
                                    <div>
                                    {{-- @if($user_stats['type'] == 1)
                                        <label class="badge badge-outline-success badge-pill">{{$user_stats['percent']}}% increase</label>
                                    @elseif($user_stats['type'] == -1)
                                        <label class="badge badge-outline-danger badge-pill">{{$user_stats['percent']}}% decrease</label>
                                    @endif --}}
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <div class="counter fourth">
                                        <div class="counter-icon">
                                            <i class="fas fa-hourglass"></i>
                                        </div>
                                        <span class="counter-value">{{$data['total_batches']}}</span>
                                        /
                                        <span class="counter-value"> {{$data['total_slots']}}</span>
                                        
                                        <h3>Batches / Active Slots</h3>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 align-items-center">
                                    <div class="counter fifth">
                                        <div class="counter-icon">
                                            <i class="fas fa-user-alt-slash"></i>
                                        </div>
                                        <span class="counter-value">{{$data['total_cancellations']}} </span>
                                        / <span class="counter-value">{{$data['total_terminations']}}</span>
                                        <h3>Cancellation / Termination</h3>
                                        
                                    </div>
                                    <div>
                                    {{-- @if($user_stats['type'] == 1)
                                        <label class="badge badge-outline-success badge-pill">{{$user_stats['percent']}}% increase</label>
                                    @elseif($user_stats['type'] == -1)
                                        <label class="badge badge-outline-danger badge-pill">{{$user_stats['percent']}}% decrease</label>
                                    @endif --}}
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <div class="counter sixth">
                                        <div class="counter-icon">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <span class="counter-value">{{$data['total_employments']}}</span>
                                        <h3>Total Employments</h3> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="gauge-loader" class="d-none">
                        <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                            <div class="bar-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>    
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-md-row justify-content-between align-items-center">
                            <div>
                            <h4 class="card-title mb-0">Capacity by slots (Current Batch)</h4>
                            </div>
                            <div class="col-3">
                                <select class="form-control" id="change_gauge">
                                    @foreach ($courses as $course)
                                        <option value="{{$course->id}}">{{$course->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="course_gauges_container" class="row justify-content-center align-items-center">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="all-admissions-loader" class="d-none">
                        <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                            <div class="bar-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>    
                        </div>
                    </div>
                    <div class="card-body" > 
                        <h4 class="card-title">Admissions by status per course</h4>
                        <div style="position: relative;">
                            <canvas id="course_wise_employements" height="120px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div id="course-wise-admissions-loader" class="d-none">
                        <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                            <div class="bar-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>    
                        </div>
                    </div>
                    <div class="card-body" style="position: relative;">
                        <h4 class="card-title">Admissions by course</h4>
                        <canvas id="course_wise_admissions"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div id="students-by-loader" class="d-none">
                        <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                            <div class="bar-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>    
                        </div>
                    </div>
                    <div class="card-body" style="position: relative;">
                        <h4 class="card-title">Students by Source</h4>
                        <canvas id="reach_source"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div id="admissions-by-batches-loader" class="d-none">
                        <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                            <div class="bar-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>    
                        </div>
                    </div>
                    <div class="card-body" style="position: relative;">
                        <div class="d-flex flex-md-row justify-content-between align-items-center">
                            <div>
                            <h4 class="card-title mb-0">Admissions By Batches</h4>
                            </div>
                            <div class="col-4">
                                <select class="form-control" id="change_admission_by_batch">
                                    @foreach ($courses as $course)
                                        <option value="{{$course->id}}">{{$course->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <select class="form-control" id="course_batch">
                                    @foreach ($firstbatches as $item)
                                        <option value="{{$item->id}}">{{$item->batch_identifier}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="admission_by_batch_container"> 
                        <canvas id="admission_by_batch">
                        </canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    
                    <div id="feedback-by-status-loader" class="d-none">
                        <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                            <div class="bar-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>    
                        </div>
                    </div>
                    <div class="card-body" style="position: relative;">
                        <h4 class="card-title">Feedbacks by status</h4>
                        <div class="d-flex justify-content-center">
                            <h2 class="text-success"><marquee>Coming Soon! :)</marquee></h2>
                        </div>
                        <canvas id="some_id">
                        </canvas>
                    </div>
                </div>
            </div>        
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="registrations-loader" class="d-none">
                        <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                            <div class="bar-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>    
                        </div>
                    </div>
                    <div class="card-body" style="position: relative;">
                        <h4 class="card-title">Registrations</h4>
                        <canvas id="total_registrations" height="60px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jcontent')
<script>
    let admissionChart;
    $(document).ready(function () {
        $('.counter-value').each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            },{
                duration: 3500,
                easing: 'swing',
                step: function (now){
                    $(this).text(Math.ceil(now));
                }
            });
        });
        //Initial gauge
        $.ajax({
            type: "get",
            url: `{{url('admin/get-gauge/1')}}`,
            beforeSend: function (){
                $('#gauge-loader').removeClass('d-none');
            },
            success: function (response) {
                let gaugedata = JSON.parse(response);
                generateGauges(gaugedata);
            },
            complete: function(){
                $('#gauge-loader').addClass('d-none');
            }
        });
        //Pie Chart Ajax
        $.ajax({
            type: "get",
            url: `{{url('admin/get-course-wise-admissions')}}`,
            beforeSend: function (){
                $('#course-wise-admissions-loader').removeClass('d-none');
            },
            success: function (response) {
                let piedata = JSON.parse(response);
                generatePieChart(piedata);

            },
            complete: function(){
                $('#course-wise-admissions-loader').addClass('d-none');
            }
        });
        //Doughnut Data
        
        $.ajax({
            type: "get",
            url: `{{url('admin/get-user-reach')}}`,
            beforeSend: function (){
                $('#students-by-loader').removeClass('d-none');
            },
            success: function (response) {
                let doughnutdata = JSON.parse(response);
                generateDoughnutChart(doughnutdata);
            },
            complete: function(){
                $('#students-by-loader').addClass('d-none');
            }
        });

        //Bar chart
        $.ajax({
            type: "get",
            url: `{{url('admin/get-course-wise-employments')}}`,
            beforeSend: function (){
                $('#all-admissions-loader').removeClass('d-none');
            },
            success: function (response) {
                let bardata = JSON.parse(response);
                generateBarChart(bardata);
            },
            complete: function(){
                $('#all-admissions-loader').addClass('d-none');
            }
        });
        //linedata
        $.ajax({
            type: "get",
            url: `{{url('admin/get-registration-counts')}}`,
            beforeSend: function (){
                $('#registrations-loader').removeClass('d-none');
            },
            success: function (response) {
                let linedata = JSON.parse(response);
                generateLineChart(linedata);
            },
            complete: function(){
                $('#registrations-loader').addClass('d-none');
            }
        });
        let firstbatch = '{{$firstbatches[0]->id}}';
        //initial batch wise admission
        $.ajax({
            type: "get",
            url: `{{url('admin/get-admission-by-batch/${firstbatch}')}}`,
            beforeSend: function (){
                $('#admissions-by-batches-loader').removeClass('d-none');
            },
            success: function (response) {
                let data = JSON.parse(response);
                generatePieChartForBatchAdmissions(data);
            },
            complete: function(){
                $('#admissions-by-batches-loader').addClass('d-none');
            }
        });

    });

    $('#change_gauge').on('change',function(){
        let id = $('#change_gauge').val();
        $.ajax({
            type: "get",
            url: `{{url('admin/get-gauge/${id}')}}`,
            beforeSend: function (){
                $('#gauge-loader').removeClass('d-none');
            },
            success: function (response) {
                let gaugedata = JSON.parse(response);
                generateGauges(gaugedata);
            },
            complete: function(){
                $('#gauge-loader').addClass('d-none');
            }
        });
    });

    $('#change_admission_by_batch').on('change',function(){
        let id = $('#change_admission_by_batch').val();
        $.ajax({
            type: "get",
            url: `{{url('admin/get-batches/${id}')}}`,
            beforeSend: function (){
                $('#admissions-by-batches-loader').removeClass('d-none');
            },
            success: function (response) {
                response = JSON.parse(response)
                //let piedata = JSON.parse(response);
                $("#course_batch").empty();
                if(response.coursebatch.length > 0){
                    $.each(response.coursebatch, function (index, element) {
                            if(element.status){
                                $("#course_batch").append(`
                                    <option value="${element.id}"${element.is_current?'selected':''}>${element.batch_identifier}</option>
                                `);
                            }
                    });
                    $.ajax({
                        type: "get",
                        url: `{{url('admin/get-admission-by-batch/${response.coursebatch[0].id}')}}`,
                        beforeSend: function (){
                            $('#admissions-by-batches-loader').removeClass('d-none');
                        },
                        success: function (response) {
                            let data = JSON.parse(response);
                            generatePieChartForBatchAdmissions(data);
                        },
                        complete: function(){
                            $('#admissions-by-batches-loader').addClass('d-none');
                        }
                    });
                }
                else
                {
                    $("#course_batch").append(`
                            <option value="">Not Found</option>
                        `);
                }
                /* 
                generateDoughnutChartForBatchAdmissions(piedata); */
            },
            complete: function(){
                $('#admissions-by-batches-loader').addClass('d-none');
            }
        });
    });

    $('#course_batch').on('change',function(){
        let id = $('#course_batch').val();
        $.ajax({
            type: "get",
            url: `{{url('admin/get-admission-by-batch/${id}')}}`,
            beforeSend: function (){
                $('#admissions-by-batches-loader').removeClass('d-none');
            },
            success: function (response) {
                let data = JSON.parse(response);
                generatePieChartForBatchAdmissions(data);
            },
            complete: function(){
                $('#admissions-by-batches-loader').addClass('d-none');
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
                    responsive:true,
                    legend : {
                        display:false,
                        position:'bottom',
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
                    responsive:true,
                    legend : {
                        display:false,
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

        //set the highest step in bar chart
        let highest = Math.ceil(bardata.highest_count/20)

        const data = {
                datasets: [
                {
                    type: 'bar',
                    label: 'Currently Studying',
                    data: bardata.admitted_counts,              
                    borderColor: '#36a2eb',
                    backgroundColor: '#36a2eb',
                },    
                {
                    type: 'bar',
                    label: 'Not Employed',
                    data: bardata.not_employed_admissions_counts,              
                    borderColor: '#ff6384',
                    backgroundColor: '#ff6384',
                },
                {
                    type: 'bar',
                    label: 'Employed',
                    data: bardata.employed_admissions_counts,                
                    borderColor: '#4bc0c0',
                    backgroundColor: '#4bc0c0',
                },
                {
                    type: 'bar',
                    label: 'Cancelled',
                    data: bardata.cancelled_counts,                
                    borderColor: '#ffcd56',
                    backgroundColor: '#ffcd56',
                },
                {
                    type: 'bar',
                    label: 'Terminated',
                    data: bardata.terminated_counts,                
                    borderColor: '#ffa449',
                    backgroundColor: '#ffa449',
                },
            ],
                labels:  bardata.labels,
        };
        
        const config = {
            type: 'bar',
            data: data,
            options:{
                responsive:true,
                lineWidth: 0.1,
                legend : {
                    display:false,
                    position:'right',
                    align:'start',
                    labels:{
                        boxWidth:10,
                    }
                },
                scales: {
                    yAxes: [{
                        stacked:true,
                        ticks: {
                            min: 0,
                            stepSize:highest,
                        }
                    }],
                    xAxes: [{
                        stacked:true,
                        barPercentage: 0.8,
                        ticks: {
                            fontSize: 8,
                            autoSkip:false,
                        },
                         gridLines: {
                            offsetGridLines : true,
                        }
                    }]
                },
                /* tooltips: {
                    mode: 'label',
                    callbacks: {
                        afterTitle: function() {
                            window.total = 0;
                        },
                        label: function(tooltipItem, data) {
                            var corporation = data.datasets[tooltipItem.datasetIndex].label;
                            var valor = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            window.total += valor;
                            return corporation + ": " + valor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");             
                        },
                        footer: function() {
                            return "TOTAL: " + window.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                        }
                    }
                } */
            }
        };
        const someChart = new Chart(
            document.getElementById('course_wise_employements'),
            config
        );
    }

    function generateLineChart(linedata){
        const data = {
            labels: linedata.labels,
            datasets: [{
                fill: false,
                borderColor:'#392C70',
                label: 'Registrations',
                data: linedata.count,
                backgroundColor: 'transparent',
                hoverOffset: 4
            }],
            
        };
        const options = {
                    responsive: true,
                    legend : {
                        display:false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize:40,
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
        $('#course_gauges_container').empty();
        if(gaugedata['slot_transaction'].length > 0){
            gaugedata['slot_transaction'].map((transaction)=>{
                $('#course_gauges_container').append(`
                        <div id="gauge_${transaction.id}" class='col-md-4 col-12' ><div>
                `);
                
                let courseslot = gaugedata['course_slots'].filter((element)=>{
                    return element.id == transaction.slot_id;
                })
                let gauge =  new JustGage({
                        id: "gauge_"+transaction.id, // the id of the html element
                        value: transaction.total_capacity - transaction.current_capacity,
                        min: 0,
                        max: transaction.total_capacity,
                        gaugeWidthScale: 0.6,
                        label: courseslot[0].name,
                        labelFontColor:'black',
                    });
                gauges.push(gauge);
            }) 
        }
        else{
          $('#course_gauges_container').append(`
                <h2 class="text-warning">No Slots found :(<h2>
        `);  
        }
    }

    function generatePieChartForBatchAdmissions(piebatchdata) {
        console.log(piebatchdata)
        if(piebatchdata.count.length == 0){
            return $('#admission_by_batch_container').append(` <h2 class="text-warning">No Data found :(<h2>`);
        }
        if(admissionChart)
            admissionChart.destroy();        
        
            const data = {
            labels: piebatchdata.labels,
            datasets: [{
                label: 'Admission By Batch',
                data: piebatchdata.count,
                backgroundColor: piebatchdata.colors,
                hoverOffset: 4
            }],
            
        };
        const options = {
                    responsive:true,
                    legend : {
                        display:false,
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
        
        admissionChart = new Chart(
            document.getElementById('admission_by_batch'),
            config
        );
       

    }
</script>
@endsection
