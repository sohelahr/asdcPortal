@extends('layouts.admin.app')
@section('title')
    <title>Report | Beneficiary</title>
@endsection
@push('css')
<link rel="stylesheet" type="text/css" href="{{env('BACKEND_CDN_URL')}}/css/select2.css">
@endpush

@section('content')
    <style>
        .alignButton {
            display: flex;
            align-items: flex-end;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Reports</h3>
		@endslot
            <li class="breadcrumb-item active" aria-current="page">Report</li>
	@endcomponent

    <!-- Main content -->
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
	            <div class="card">
                    <div id="overlay" class="d-none">
                        <div style="height: 100%;width:100%;position: absolute;z-index:999;background: #00000154;" class="d-flex justify-content-center align-items-center"> 
                            <div> 
                                <div class="loader-box">
                                    <div class="loader-7"></div>
                                </div>              
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <h5 class="card-title p-0 mb-2">Select Record</h5>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Look for<sup class="text-danger">*</sup></label>
                                    <select class="form-control" style="width: 100%;" name="look_for" id="look_for">
                                        <option value="">Select Entity</option>
                                        @if(count($looking_for) > 0)
                                            @foreach($looking_for as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Columns (you can select multiple)<sup class="text-danger">*</sup></label>
                                    <select class="form-control" style="width: 100%;" name="columns[]" multiple="multiple" id="columns">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="d-flex justify-content-between">
                                <h5 class="card-title p-0">Apply Condition</h5>
                            <div>
                                <button type="button" class="btn btn-primary" id="add_conditions"><i class="fa fa-plus"></i> Add More Conditions</button>
                            </div>
                            
                        </div>
                        <div class="row" id="row_0">
                            <div class="col-md-3 operational_div">
                                <div class="form-group">
                                    <label>Where<sup class="text-danger">*</sup></label>
                                    <select class="form-control where_column" style="width: 100%;" name="where_column_0" id="where_column_0">
                                        <option value="">Select Column</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 operational_div">
                                <div class="form-group">
                                    <label>Condition<sup class="text-danger">*</sup></label>
                                    <select class="form-control where_condition" style="width: 100%;" name="where_condition_0" id="where_condition_0">
                                        <option value="">Select Condition</option>
                                        @if(count($conditional_operators) > 0)
                                            @foreach($conditional_operators as $key => $conditional_operator)
                                                <option value="{{$conditional_operator['key']}}">{{$conditional_operator['value']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 operational_div">
                                <div class="form-group">
                                    <label>Value<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control value" name="value_0" id="value_0"> 
                                </div>
                            </div>
                        </div>
                        <div id="dynamic_condition_div">

                        </div>
                        <hr>
                        <div style="position: relative;width:100%;height:25px">
                            <button type="button" class="btn btn-success" id="filter_report" style="position: absolute;right:0"><i class="fa fa-search"></i> Filter</button>
                        </div>
                        <div class="row" id="tableRow" style="display: none;margin-top:15px">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                                        
                                        <div class="row">
                                            <div class="col-12" style="position: relative;width:100%;">
                                                <button id="export_report" class="btn btn-success btn-sm float-right" style="position: absolute;right:0"><i class="fa fa-file-excel-o"></i> Export</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <!-- loader html start -->
                                        <div class="overlay-wrapper">
                                            <div class="overlay" style="display: none;">
                                                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                            </div>
                                        </div>
                                        <!-- loader html end -->

                                        <table id="report_table" class="table table-bordered table-hover">
                                            <tbody>
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

@endsection

@section('jcontent')
<script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>

<script src="{{env('BACKEND_CDN_URL')}}/js/select2/select2.full.min.js"></script>
<script src="{{env('BACKEND_CDN_URL')}}/js/select2/select2-custom.js"></script>
<script>
    var site_path = '{{url('/report')}}';
    var token = '{{ csrf_token() }}';
    let conditionCount = 1;
    let columnArr = [];
    var selectedEntity = "";
    var selectedColumns = [];
    var typeArr = [];
    var whereColumnArr = [];
    var whereConditionArr = [];
    var whereValueArr = [];
    let conditionArr = {!! json_encode($conditional_operators) !!};
    console.log(site_path);
    $(function () {
        $('#columns').select2({
            placeholder: "Select column",
            allowClear: true,
            allowHtml: true,
            closeOnSelect : false,
        });

        $('#look_for').change(function() {
            var selected_option = $(this).children("option:selected").val();
            if(selected_option) {
                fetchColumns(selected_option);
            } else {
                triggerColumnSelection("CLEAR");
            }
        });

        $('#columns').change(function() {
            let ele = $('#tableRow');
            if(ele.is(":visible")) {
                ele.hide();
                $('#report_table thead').html("");
                $('#report_table').html("");
            }
        });

        $('#add_conditions').click(function() {
            renderConditionalSection(conditionCount);
        });

        $('#filter_report').click(function() {
            typeArr = [];
            whereColumnArr = [];
            whereConditionArr = [];
            whereValueArr = [];
            selectedEntity = $('#look_for').children("option:selected").val();
            selectedColumns = $('#columns').val();

            $('.type_column').each(function(key, value) {
                typeArr.push($(value).children("option:selected").val());
            });

            $('.where_column').each(function(key, value){
                whereColumnArr.push($(value).children("option:selected").val());
            });

            $('.where_condition').each(function(key, _element) {
                whereConditionArr.push($(_element).children("option:selected").val());
            })

            $('.value').each(function(key, _element) {
                whereValueArr.push($(_element).val());
            });
            loadDataTable(selectedEntity, selectedColumns, typeArr, whereColumnArr, whereConditionArr, whereValueArr);
        });

        $('#export_report').click(function() {
            $.ajax({
                url: site_path+'/report/export',
                type: 'POST',
                //dataType: 'JSON',
                xhrFields: {
                    responseType: 'blob',
                },
                data: {
                    _token: token,
                    entity: selectedEntity,
                    select_arr: selectedColumns,
                    type_arr: typeArr,
                    where_column_arr: whereColumnArr,
                    where_condition_arr: whereConditionArr,
                    where_value_arr: whereValueArr
                },
                beforeSend: function () {
                    $('#overlay').removeClass('d-none');
                    $('#overlay').show();
                },
                success: function (result, status, xhr) {
                    var disposition = xhr.getResponseHeader('content-disposition');
                    var matches = /"([^"]*)"/.exec(disposition);
                    var filename = (matches != null && matches[1] ? matches[1] : `${selectedEntity}-report.xlsx`);

                    // The actual download
                    var blob = new Blob([result], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;

                    document.body.appendChild(link);

                    link.click();
                    document.body.removeChild(link);
                },
                error: function (xhr, httpStatusMessage, customErrorMessage) {

                },
                complete: function () {
                    $('#overlay').hide();
                }
            });
        });
    });

    //Function to render column selection dropdown
    function triggerColumnSelection(type, data) {
        $('#columns').val(null).trigger('change');
        if(type === "CLEAR") {
            $('#columns').html('<option value="">Select Columns</option>');
            $('#where_column').html('<option value="">Select Column</option>');
        } else {
            var option_html = '';
            $.each(data,function (key, col){
                option_html += `<option value="${col.actualVal}">${col.displayName}</option>`;
            });
            $('#columns').html(option_html);
            option_html = "";
            $.each(data,function (key, col){
                if(!col.actualVal.includes("_id")){
                    option_html += `<option value="${col.actualVal}">${col.displayName}</option>`;
                }
            })
            $('#where_column_0').html(option_html);
        }
        
    }

    //Function to fetch columns of selected table
    function fetchColumns(tableName) {
        $.ajax({
            url: site_path+'/get/columns/'+btoa(tableName),
            type: 'GET',
            dataType: 'JSON',
            beforeSend: function () {
                $('#overlay').removeClass('d-none');
                $('#overlay').show();
                triggerColumnSelection("CLEAR");
            },
            success: function (response) {
                if(response.length > 0)
                {
                    columnArr = response;
                    triggerColumnSelection("REFRESH", response);
                }
            },
            error: function (xhr, httpStatusMessage, customErrorMessage) {

            },
            complete: function () {
                $('#overlay').hide();
            }
        });
    }

    //Function to dynamically generate datatable headers
    function dataTableColumn(columns) {
        let dtColumn = [];
        //Creating dynamic column for datatable
        $.each(columns,(key, value) => {
            let obj = {
                data: value,
                name: value,
                title: (value == "User" || value == "Student") ? "Email" : value.charAt(0).toUpperCase() + value.slice(1).replace("_id","").replace("_"," "),
                "orderable": false
            }
            dtColumn.push(obj);
        });
        return dtColumn;
    }

    //Function to load dynamic datatable
    function loadDataTable(selectedEntity, selectArr, typeArr, whereColumnArr, whereConditionArr, whereValueArr) {
        //Init table
        $('#report_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            "autoWidth": false,
            "responsive": true,
            destroy: true,
            //bStateSave: true,
            ajax: {
                "url": site_path+'/fetch/data',
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token,
                    entity: selectedEntity,
                    select_arr: selectArr,
                    type_arr: typeArr,
                    where_column_arr: whereColumnArr,
                    where_condition_arr: whereConditionArr,
                    where_value_arr: whereValueArr
                }
                //"complete": afterRequestComplete
            },
            columnDefs: [{
                "defaultContent": "N/A",
                "targets": "_all"
            }],
            columns: dataTableColumn(selectArr),
            
        });
        $('#tableRow').show();
    }

    //Function to fetch data
    function fetchData(selectedEntity, selectArr, whereColumn, whereCondition) {
        $.ajax({
            url: site_path+'/fetch/data',
            type: 'POST',
            dataType: 'JSON',
            data:{
                "_token": token,
                entity: selectedEntity,
                select_arr: selectArr,
                whereColumn: whereColumn,
                whereCondition: whereCondition
            },
            beforeSend: function () {
                $('#overlay').removeClass('d-none');
                $('#overlay').show();
            },
            success: function (response) {
                if(response.data.length > 0)
                {
                    renderTable(selectArr, response.data);
                }
            },
            error: function (xhr, httpStatusMessage, customErrorMessage) {
                $('#overlay').hide();
            },
            complete: function () {
                $('#overlay').hide();
            }
        });
    }

    //Function to render dynamic table
    function renderTable(headerData, bodyData) {

        //Rendering table header
        var table_header_html = '<tr>';
        $.each(headerData,(key, value) => {
            table_header_html += `<th>${value}</th>`;
        });
        table_header_html += '</tr>';
        $('.tableColumn').html(table_header_html);

        //Rendering table body data
        var tableBodyHtml = '';
        $.each(bodyData,(key, value) => {
            tableBodyHtml += '<tr>';
            $.each(value,(innerKey, innerValue) => {
                tableBodyHtml += `<td>${innerValue}</td>`;
            });
            tableBodyHtml += '</tr>';
        });
        $('.tableBody').html(tableBodyHtml);
        $('#tableRow').show();
        $('#overlay').hide();
    }

    //Function to render conditional section
    function renderConditionalSection(index) {
        var html_content = '';
        html_content += `<div class="row" id="row_${index}">`;

        html_content += `<div class="col-md-2">`;
        html_content += `<div class="form-group">`;
        html_content += `<label>Type<sup class="text-danger">*</sup></label>`;
        html_content += `<select class="form-control type_column" style="width: 100%;" name="type_column_${index}" id="type_column_${index}">`;
        html_content += `<option value="">Select Type</option>`;
        html_content += `<option value="OR">OR</option>`;
        html_content += `<option value="AND">AND</option>`;
        html_content += `</select>`;
        html_content += `</div>`;
        html_content += `</div>`;

        html_content += `<div class="col-md-3">`;
        html_content += `<div class="form-group">`;
        html_content += `<label>Where<sup class="text-danger">*</sup></label>`;
        html_content += `<select class="form-control where_column" style="width: 100%;" name="where_column_${index}" id="where_column_${index}">`;
        html_content += `<option value="">Select Column</option>`;
        $.each(columnArr,function (key, col){
            if(!col.actualVal.includes("_id")){
                html_content += `<option value="${col.actualVal}">${col.displayName}</option>`;
            }
        });
        html_content += `</select>`;
        html_content += `</div>`;
        html_content += `</div>`;

        html_content += `<div class="col-md-3">`;
        html_content += `<div class="form-group">`;
        html_content += `<label>Condition<sup class="text-danger">*</sup></label>`;
        html_content += `<select class="form-control where_condition" style="width: 100%;" name="where_condition_${index}" id="where_condition_${index}">`;
        html_content += `<option value="">Select Condition</option>`;
        $.each(conditionArr,function (key, condition){
            html_content += `<option value="${condition.key}">${condition.value}</option>`;
        });
        html_content += `</select>`;
        html_content += `</div>`;
        html_content += `</div>`;

        html_content += `<div class="col-md-3">`;
        html_content += `<div class="form-group">`;
        html_content += `<label>Value<sup class="text-danger">*</sup></label>`;
        html_content += `<input type="text" class="form-control value" name="value_${index}" id="value_${index}">`;
        html_content += `</div>`;
        html_content += `</div>`;

        html_content += `<div class="col-md-1 alignButton">`;
        html_content += `<div class="form-group">`;
        html_content += `<button type="button" class="btn btn-danger" onclick="removeCondition(${index});"><i class="fa fa-trash"></i></button>`;
        html_content += `</div>`;
        html_content += `</div>`;

        html_content += `</div>`;
        $('#dynamic_condition_div').append(html_content);
        conditionCount++;
    }

    //Function to remove conditional section
    function removeCondition(position) {
        $(`#row_${position}`).remove();
    }

    
</script>
@endsection