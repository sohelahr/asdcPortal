@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Assessment Lines</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/assessment')}}">Assessment</a></li>
            <li class="breadcrumb-item active" aria-current="page">Assessment Line</li>
	@endcomponent
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div id="overlay-loader" class="d-none">
                        <div style="height: 100%;width:100%;background:rgba(121, 121, 121, 0.11);position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
                            <div> 
                                <div class="loader-box">
                                    <div class="loader-7"></div>
                                </div>              
                            </div>
                        </div>
                    </div>
                    <div class="d-flex p-1 m-0 border header-buttons">
                        <div>
                            <button class="btn bg-white" type="button" >
                                Name : {{$assessment_header->assessment_name}}
                            </button>
                        </div>
                        <div>
                            <button class="btn bg-white" type="button" >
                                Course : {{$course}}
                            </button>
                        </div>
                        <div>
                            <button class="btn bg-white" type="button" >
                                Batch : {{$coursebatch}}
                            </button>
                        </div>
                        <div>
                            <button class="btn bg-white" type="button" >
                                Timings : {{$courseslot}}
                            </button>
                        </div>
                        <div>
                            <button class="btn bg-white" type="button" >
                                Held On : {{$assessment_header->held_on}}
                            </button>
                        </div>
                    </div>
                    <div class="d-flex p-1 m-0 border header-buttons">
                        @if($assessment_header->is_language_assesment)
                            <div>
                                <button class="btn bg-white text-danger" type="button" >
                                    Language : {{$language}}
                                </button>
                            </div>
                        @endif
                        <div>
                            <button class="btn bg-white" type="button" >
                                Instructor  : {{$instructor}}
                            </button>
                        </div>
                        <div>
                            <button class="btn bg-white" type="button" >
                                Created By : {{$created_by}}
                            </button>
                        </div>
                        <div>
                            <button class="btn bg-white" type="button" >
                                Theory Marks : {{$assessment_header->max_theory}}
                            </button>
                        </div>
                        <div>
                            <button class="btn bg-white" type="button" >
                                Practical Marks : {{$assessment_header->max_practical ? $assessment_header->max_practical : 0 }}
                            </button>
                        </div>
                        <div>
                            <button class="btn bg-white" type="button" >
                                Total Marks : {{$assessment_header->total_marks }}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display datatables" id="admission_table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>Roll No</th>
                                        <th>Name</th>
                                        <th>Theory Marks</th>
                                        <th>Practical Marks</th>
                                        <th>Total Marks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jcontent')
    <script>
        var id = {{$assessment_header->id}}
        var all_url =  `{{url('assessment/get-all-admissions-per-assessment-header/${id}')}}`;
        getAdmission(all_url);
        
        function Notify(title,msg,status){
            $.notify({
                    title:title,
                    message:msg
                },
                {
                    type:status,
                    allow_dismiss:true,
                    newest_on_top:false ,
                    mouse_over:true,
                    showProgressbar:false,
                    spacing:10,
                    timer:2000,
                    placement:{
                        from:'top',
                        align:'center'
                    },
                    offset:{
                        x:30,
                        y:30
                    },
                    delay:1000 ,
                    z_index:10000,
                    animate:{
                        enter:'animated pulse',
                        exit:'animated bounce'
                    }
            });
        }


        function saveAssessmentLine(admission_id,total_marks,max_theory,max_practical,student_id){
            let theory = $(`#theory-marks-${admission_id}`).val();
            let practical = $(`#practical-marks-${admission_id}`).val();
            let calculated_total = $(`#total-marks-${admission_id}`).text();
            if(theory > max_theory || practical > max_practical ){
                swal({
                    title: "Warning",
                    text: 'Please enter proper marks for theory and practical!',
                    icon:'warning',
                })
                return ''
            }

            if(total_marks < calculated_total){
                swal({
                    title: "Warning",
                    text: 'Entered marks exceed total marks!',
                    icon:'warning',
                })
                return ''
            }

            $.ajax({
                type: "post",
                url: `{{url('assessment/save-line/${id}')}}`,
                data:{
                    _token: "{{csrf_token()}}",
                    total_marks:calculated_total,
                    theory, 
                    practical,
                    admission_id,
                    student_id
                },
                beforeSend: function () {
                    $('#overlay-loader').removeClass('d-none');
                    $('#overlay-loader').show();
                },
                success: function (response) {
                    res = JSON.parse(response);
                    console.log(res)
                    if(res.status){
                        Notify('Success',res.data.success_message,'success');
                    }
                    else{
                        Notify('Danger',res.data.error_message,'danger');
                    }
                    getAdmission(all_url);
                },
                complete: function () {
                    $('#overlay-loader').hide();
                },
            });

        }

        @if(\Illuminate\ Support\ Facades\ Session::has('created'))
        Notify('Created','Assessment Header was successfully created','success')
        @elseif(\Illuminate\Support\Facades\Session::has('updated'))
            Notify('Updated','Assessment Header Was Successfully Update','info')
        @elseif(\Illuminate\Support\Facades\Session::has('deleted'))
            Notify('Deleted','Assessment Header Was Successfully Deleted','warning')
        @elseif(\Illuminate\Support\Facades\Session::has('prohibited'))
            Notify('Cannot Delete','This Assessment already has submissions','warning')
        @elseif(\Illuminate\ Support\ Facades\ Session::has('error'))
            Notify('Danger','Something Went Wrong ','danger')
        @endif


        $(document).on('change','.inputs',function(){
            let admission_id = $(this).data('id')
            let theory = $(`#theory-marks-${admission_id}`).val();
            let practical = $(`#practical-marks-${admission_id}`).val();
            console.log(admission_id)
            $(`#total-marks-${admission_id}`).text(parseInt(theory) + parseInt(practical));
        })


        function getAdmission(url){
            
            let courseid = 0;
            $('#admission_table').DataTable({
                processing: true,
                serverSide: true,
                searching:false,
                "pageLength": 200,
                "bDestroy": true,
                "bPaginate": false,
                "bLengthChange": false,
                "info": false,
                ajax: {
                    "url":url,
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columnDefs": [
                    {"className": "text-center", "targets": [0,2,3,4,5]}
                ],
                columns: [
                    {
                        data:'roll_no',
                        name:'roll_no'
                    },    
                    {
                        data:'name',
                        name:'name'
                    },
                    {
                        data:'theory_marks',
                        render:function(data,type,row){
                            return `
                                <div>
                                    <input type="number" class="inputs" data-id="${row.admission_id}" id="theory-marks-${row.admission_id}" min=0 max=${row.header_info.max_theory} value="${data}" /> / ${row.header_info.max_theory || 0}
                                </div>
                                `;
                        },
                        name:'theory_marks'
                    },    
                    {
                        data:'practical_marks',
                        render:function(data,type,row){
                            return `
                                <div>
                                    <input type="number" class="inputs" data-id="${row.admission_id}" id="practical-marks-${row.admission_id}" min=0 max=${row.header_info.max_practical} ${row.header_info.max_practical ? '' : 'disabled'} value="${data}" /> / ${row.header_info.max_practical || 0}
                                </div>
                                `;
                        },
                        name:'practical_marks'
                    },
                    {
                        data:'total_marks',
                        render:function(data,type,row){
                            return `
                                <div>
                                    <span id="total-marks-${row.admission_id}" >${data}</span> / ${row.header_info.total_marks}
                                </div>
                                `;
                        },
                        name:'total_marks'
                    },
                    {
                        data:'action',
                        render:function(data,type,row){
                            return `
                                <div>
                                    <button class="form-btn form-btn-success ms-4 me-2" onclick="saveAssessmentLine(${row.admission_id},${row.header_info.total_marks},${row.header_info.max_theory},${row.header_info.max_practical},${row.student_id})" >
                                        <i class="fa fa-save"></i>
                                    </button>
                                </div>
                                `;
                        },
                        name:'admission_id',orderable:false
                    }
                ]
            });

            
        }
    </script>
@endsection