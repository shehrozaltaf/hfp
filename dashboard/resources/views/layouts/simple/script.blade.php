<script src="{{asset(config('global.asset_path').'/js/jquery-3.5.1.min.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{asset(config('global.asset_path').'/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<!-- feather icon js-->
<script src="{{asset(config('global.asset_path').'/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- scrollbar js-->
<script src="{{asset(config('global.asset_path').'/js/scrollbar/simplebar.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/scrollbar/custom.js')}}"></script>


<script src="{{asset(config('global.asset_path').'/js/range-slider/ion.rangeSlider.min.js')}}"></script> 

<!-- Sidebar jquery-->
<script src="{{asset(config('global.asset_path').'/js/config.js')}}"></script>
<!-- Plugins JS start-->
<script id="menu" src="{{asset(config('global.asset_path').'/js/sidebar-menu.js')}}"></script>
@yield('script')

@if(Route::current()->getName() != 'popover')
	<script src="{{asset(config('global.asset_path').'/js/tooltip-init.js')}}"></script>
@endif

<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{asset(config('global.asset_path').'/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>

<script src="{{asset(config('global.asset_path').'/js/datatable/datatable-extension/datatables.buttons.min.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/datatable/datatable-extension/pdfmake.min.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/datatable/datatable-extension/vfs_fonts.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/datatable/datatable-extension/buttons.html5.min.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/datatable/datatable-extension/buttons.print.min.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/datatable/datatable-extension/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/datatable/datatable-extension/datatables.bootstrap4.min.js')}}"></script>



<script src="{{asset(config('global.asset_path').'/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/notify/notify-script.js')}}"></script>


<script src="{{asset(config('global.asset_path').'/js/script.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/core.js')}}"></script>
<script src="{{asset(config('global.asset_path').'/js/theme-customizer/customizer.js')}}"></script>



{{-- @if(Route::current()->getName() == 'index')
	<script src="{{asset(config('global.asset_path').'/js/layout-change.js')}}"></script>
@endif --}}
