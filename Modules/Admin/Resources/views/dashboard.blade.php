@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Dashboard</h3>
		@endslot
	@endcomponent
    {{-- <div class="float-right">
                <a href="{{url("admin/import-index")}}" class="btn btn-outline-primary" >Import Registrations<a>
            </div> --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="user-plus"></i></div>
                            <div class="media-body">
                                <span class="m-0">Total Registrations</span>
                                <h4 class="mb-0 counter">{{$data['total_registrations']}}</h4>
                                <i class="icon-bg" data-feather="user-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-secondary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="user-check"></i></div>
                            <div class="media-body">
                                <span class="m-0">Admissions</span>
                                <h4 class="mb-0 counter">{{$data['total_admissions']}}</h4>
                                <i class="icon-bg" data-feather="user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="trending-up"></i></div>
                            <div class="media-body">
                                <span class="m-0">Batches | Slots</span>
                                <h4 class="mb-0 counter">{{$data['total_batches']}} | {{$data['total_slots']}}</h4>
                                <i class="icon-bg" data-feather="trending-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="briefcase"></i></div>
                            <div class="media-body">
                                <span class="m-0">Employed</span>
                                <h4 class="mb-0 counter">{{$data['total_employments']}}</h4>
                                <i class="icon-bg" data-feather="briefcase"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 xl-100 box-col-12">
                <div class="card">
                    <div id="get-top-courses-loader" class="d-none">
                        <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                            <div> 
                                <div class="loader-box">
                                    <div class="loader-7"></div>
                                </div>              
                            </div>    
                        </div>
                    </div>
                    <div class="cal-date-widget card-body">
                        <div class="row">
                            <div class="col-xl-6 col-xs-12 col-md-6 col-sm-6">
                                <div class="cal-info text-center">
                                    <div>
                                        <h2>{{date('d',time())}}</h2>
                                        <div class="d-inline-block">
                                            <span class="b-r-dark pe-3">{{date('F',time())}}</span>
                                            <span class="ps-3">{{date('Y',time())}}</span>
                                        </div>
                                        <p class="f-16">There is no minimum donation, any sum is appreciated.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-xs-12 col-md-6 col-sm-6">
                                <div class="cal-datepicker">
                                    <div class="custom-box p-4 float-sm-end" data-language="en">
                                        <div class="card-header p-0 pb-1">
                                            <h6 class="txt-primary ">Top 5 Applied Courses</h6>
                                            <hr />
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordernone">
                                                <tbody id="top-courses-table">
                                                    <tr>
                                                        <td style="width: 220px" class="bd-t-none u-s-tb">
                                                            <div class="align-middle image-sm-size">
                                                                <div class="d-inline-block">
                                                                    <h6>John Deo</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="width: 120px">
                                                                <div class="progress" style="height: 8px;">
                                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                        </td>
                                                        <td>
                                                            20%
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bd-t-none u-s-tb">
                                                            <div class="align-middle image-sm-size d-flex align-items-center">
                                                                <div class="d-inline-block">
                                                                    <h6>Holio Mako</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="progress-showcase">
                                                                <div class="progress" style="height: 8px;">
                                                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 70%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            20%
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bd-t-none u-s-tb">
                                                            <div class="align-middle image-sm-size">
                                                                <div class="d-inline-block">
                                                                    <h6>Mohsib lara</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="progress-showcase">
                                                                <div class="progress" style="height: 8px;">
                                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 60%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            60%
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bd-t-none u-s-tb">
                                                            <div class="align-middle image-sm-size">
                                                                <div class="d-inline-block">
                                                                    <h6>Hileri Soli</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="progress-showcase">
                                                                <div class="progress" style="height: 8px;">
                                                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            40%
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bd-t-none u-s-tb">
                                                            <div class="align-middle image-sm-size">
                                                                <div class="d-inline-block">
                                                                    <h6>Pusiz bia</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="progress-showcase">
                                                                <div class="progress" style="height: 8px;">
                                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 90%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            80%
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	    <div class="row">
	        <div class="col-sm-12">
                <div class="row">
                    {{-- <div class="row grid-margin">
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
                                                @if($user_stats['type'] == 1)
                                                    <label class="badge badge-outline-success badge-pill">{{$user_stats['percent']}}% increase</label>
                                                @elseif($user_stats['type'] == -1)
                                                    <label class="badge badge-outline-danger badge-pill">{{$user_stats['percent']}}% decrease</label>
                                                @endif
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> --}}
                    <div class="col-xl-12">
                        <div class="card o-hidden custom-box">
                            <div id="registrations-loader" class="d-none">
                                <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                                    <div> 
                                        <div class="loader-box">
                                            <div class="loader-7"></div>
                                        </div>              
                                    </div>    
                                </div>
                            </div>
                            <div class="card-header pb-0">
                                <h5>Registrations</h5>
                            </div>
                            <div class="bar-chart-widget">
                                <div class="top-content bg-primary"></div>
                                <div class="bottom-content card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <canvas id="total_registrations" height="60px"></canvas>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-12">
                        <div class="card o-hidden custom-box">
                            <div id="all-admissions-loader" class="d-none">
                                <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                                    <div> 
                                        <div class="loader-box">
                                            <div class="loader-7"></div>
                                        </div>              
                                    </div>    
                                </div>
                            </div>
                            <div class="card-header pb-0">
                                <h5>Admissions by status per course</h5>
                            </div>
                            <div class="bar-chart-widget">
                                <div class="top-content bg-primary"></div>
                                <div class="bottom-content card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <canvas id="course_wise_employements" height="120px"></canvas>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card o-hidden custom-box">
                            <div id="course-wise-admissions-loader" class="d-none">
                                <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                                    <div> 
                                        <div class="loader-box">
                                            <div class="loader-7"></div>
                                        </div>              
                                    </div>    
                                </div>
                            </div>
                            <div class="card-header pb-0">
                                <h5>Admissions by course</h5>
                            </div>
                            <div class="bar-chart-widget">
                                <div class="top-content bg-primary"></div>
                                <div class="bottom-content card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <canvas id="course_wise_admissions"></canvas>                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card o-hidden custom-box">
                            <div id="students-by-loader" class="d-none">
                                <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                                    <div> 
                                        <div class="loader-box">
                                            <div class="loader-7"></div>
                                        </div>              
                                    </div>    
                                </div>
                            </div>
                            <div class="card-header pb-0">
                                <h5>Students by Source</h5>
                            </div>
                            <div class="bar-chart-widget">
                                <div class="top-content bg-primary"></div>
                                <div class="bottom-content card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <canvas id="reach_source"></canvas>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card o-hidden custom-box">
                            <div id="admissions-by-batches-loader" class="d-none">
                                <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                                    <div> 
                                        <div class="loader-box">
                                            <div class="loader-7"></div>
                                        </div>              
                                    </div>    
                                </div>
                            </div>
                            <div class="card-header pb-0">
                                <div class="d-flex flex-md-row justify-content-between align-items-center">
                                
                                    <h5>Admissions By Batches</h5>
                                    <div class="float-end">
                                        <select class="form-control" id="change_admission_by_batch">
                                            @foreach ($courses as $course)
                                                <option value="{{$course->id}}">{{$course->name}}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control" id="course_batch">
                                            @foreach ($firstbatches as $item)
                                                <option value="{{$item->id}}">{{$item->batch_identifier}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="bar-chart-widget">
                                <div class="top-content bg-primary"></div>
                                <div class="bottom-content card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="admission_by_batch_container"> 
                                                <canvas id="admission_by_batch"></canvas>                                  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card o-hidden custom-box">
                            <div id="feedback-by-status-loader" class="d-none">
                                    <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                                        <div> 
                                            <div class="loader-box">
                                                <div class="loader-7"></div>
                                            </div>              
                                        </div>    
                                    </div>
                                </div>
                            <div class="card-header pb-0">
                                <h5>Feedbacks by status</h5>
                            </div>
                            <div class="bar-chart-widget">
                                <div class="top-content bg-primary"></div>
                                <div class="bottom-content card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h2 class="text-success"><marquee>Coming Soon! :)</marquee></h2> 
                                            <canvas></canvas>                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card o-hidden custom-box">
                            <div id="gauge-loader" class="d-none">
                                    <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                                        <div> 
                                            <div class="loader-box">
                                                <div class="loader-7"></div>
                                            </div>              
                                        </div>    
                                    </div>
                                </div>
                            <div class="card-header pb-0">
                                <div class="d-flex flex-md-row justify-content-between align-items-center">
                                
                                    <h5>Capacity by slots (Current Batch)</h5>
                                    <div class="float-end">
                                        <select class="form-control" id="change_gauge">
                                            @foreach ($courses as $course)
                                                <option value="{{$course->id}}">{{$course->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="bar-chart-widget">
                                <div class="top-content bg-primary"></div>
                                <div class="bottom-content card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="course_gauges_container" class="row justify-content-center align-items-center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jcontent')
<script src="{{ env('BACKEND_CDN_URL')}}/js/just-gauge/raphael-2.1.4.min.js"></script>

<script src="{{ env('BACKEND_CDN_URL')}}/js/just-gauge/justgage.js"></script>
<script src="{{ env('BACKEND_CDN_URL')}}/js/chart/chartjs/chart.min.js"></script>

<script>
    let admissionChart;
    $(document).ready(function () {
        getTopCourses();
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
                    backgroundColor: '#1c4f46',//success
                    // backgroundColor: 'rgba(36, 105, 92, 0.4)',
                },    
                {
                    type: 'bar',
                    label: 'Not Employed',
                    data: bardata.not_employed_admissions_counts,              
                    backgroundColor: '#717171',//info
                    // backgroundColor: 'rgba(113, 113, 113, 0.2)',
                },
                {
                    type: 'bar',
                    label: 'Employed',
                    data: bardata.employed_admissions_counts,                
                    backgroundColor: '#bf9168',//secondary
                    // backgroundColor: 'rgba(186, 137, 93, 0.4)',
                },
                {
                    type: 'bar',
                    label: 'Cancelled',
                    data: bardata.cancelled_counts,                
                    backgroundColor: '#d43545',//warning
                    // backgroundColor: 'rgb(228, 202, 67,0.4)',
                },
                {
                    type: 'bar',
                    label: 'Terminated',
                    data: bardata.terminated_counts,                
                    backgroundColor: '#e4ca43',//red
                    // backgroundColor: 'rgba(0,0,0,.4)',
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
                fill:true,
                backgroundColor: "rgba(36, 105, 92, 0.4)",
                borderColor:'#1c4f46',
                label: 'Registrations',
                data: linedata.count,
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
                                stepSize:200,
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
                        <div id="gauge_${transaction.id}" class='col-md-4 col-12' >
                            
                        <div>
                `);
                
                let courseslot = gaugedata['course_slots'].filter((element)=>{
                    return element.id == transaction.slot_id;
                })
                let gauge =  new JustGage({
                        id: "gauge_"+transaction.id, // the id of the html element
                        value: transaction.total_capacity - transaction.current_capacity,
                        min: 0,
                        max: transaction.total_capacity,
                        valueFontColor:'#1c4f46',
                        gaugeWidthScale: 0.6,
                        label: courseslot[0].name,
                        labelFontColor:'#1c4f46',
                        levelColors:['#1c4f46','#e4ca43','#d43545']
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

    function getTopCourses(){
        $.ajax({
            type: "get",
            url: `{{url('admin/get-top-courses')}}`,
            beforeSend: function (){
                $('#get-top-courses-loader').removeClass('d-none');
            },
            success: function (response) {
                let data = JSON.parse(response);
                console.log(data);
                
                if(data.count.length){
                    $('#top-courses-table').html('');
                    data.count.map((item,index) => {
                        var perc = Math.ceil((item/data.total_reg)*100);
                        $('#top-courses-table').append(`
                            <tr>
                                <td style="width: 220px;vertical-align:center" class="bd-t-none u-s-tb">
                                    <div class="align-middle image-sm-size">
                                        <div class="d-inline-block">
                                            <h6>${data.labels[index]}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 120px;vertical-align:center">
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar" role="progressbar" style="width: ${perc}%;background-color: ${data.colors[index]}" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                </td>
                                <td style="vertical-align:center">
                                    ${perc}%
                                </td>
                        </tr>`);
                    });

                }
                else{
                    $('#top-courses-table').html(`<div class="my-5">No Registrations Yet</div>`);
                }
            },
            complete: function(){
                $('#get-top-courses-loader').addClass('d-none');
            }
        });
    }
    
</script>
@endsection
