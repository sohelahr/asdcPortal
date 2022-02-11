<script src="{{env('BACKEND_CDN_URL')}}/js/jquery-3.5.1.min.js"></script>
<!-- feather icon js-->
<script src="{{env('BACKEND_CDN_URL')}}/js/icons/feather-icon/feather.min.js"></script>
<script src="{{env('BACKEND_CDN_URL')}}/js/icons/feather-icon/feather-icon.js"></script>
<!-- Sidebar jquery-->
<script src="{{env('BACKEND_CDN_URL')}}/js/sidebar-menu.js"></script>
<script src="{{env('BACKEND_CDN_URL')}}/js/config.js"></script>
<!-- Bootstrap js-->
<script src="{{env('BACKEND_CDN_URL')}}/js/bootstrap/popper.min.js"></script>
<script src="{{env('BACKEND_CDN_URL')}}/js/bootstrap/bootstrap.min.js"></script>

{{-- Swaal --}}
<script src="{{env('BACKEND_CDN_URL')}}/js/sweet-alert/sweetalert.min.js"></script>
{{-- Notify --}}
<script src="{{env('BACKEND_CDN_URL')}}/js/notify/bootstrap-notify.min.js"></script>

{{-- DataTable --}}
<script src="{{ env('BACKEND_CDN_URL')}}/js/datatable/datatables/jquery.dataTables.min.js"></script>

<!-- jquery-validation -->
<script src="{{env('BACKEND_CDN_URL')}}/js/jquery-validation/jquery.validate.min.js"></script>
<script src="{{env('BACKEND_CDN_URL')}}/js/jquery-validation/additional-methods.min.js"></script>

<script src="{{ env('BACKEND_CDN_URL')}}/js/datepicker/date-picker/datepicker.js"></script>
<script src="{{ env('BACKEND_CDN_URL')}}/js/datepicker/date-picker/datepicker.en.js"></script>
<!-- Plugins JS start-->
@stack('scripts')
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{env('BACKEND_CDN_URL')}}/js/script.js"></script>

{{-- 
<script src="{{env('BACKEND_CDN_URL')}}/js/theme-customizer/customizer.js"></script> --}}
<!-- Plugin used-->