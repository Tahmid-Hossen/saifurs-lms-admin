<!-- PURE JS Constants -->
<script>
    /**
     * Default Global Constants
     */
    const APP_URL = '{{ url('/') }}';
    const PREVIOUS_URL = '{{ \URL::previous() }}';
    const BRANCH_URL = '{{ route('branches.get-branch-list') }}';
    const CSRF_TOKEN = '{{ csrf_token() }}';
    const USERNAME_FIND_URL = '{{ route('users.find-user-name') }}';
    const USERNAME_HAVE_FIND_URL = '{{ route('users.find-user-name-have') }}';
    const EMAIL_FIND_URL = '{{ route('users.findHaveEmail') }}';
    const MOBILE_NUMBER_FIND_URL = '{{ route('users.find-user-mobile-number') }}';
    const STATE_URL = '{{ route('states.get-state-list') }}';
    const CITY_URL = '{{ route('cities.get-city-list') }}';
    const CATEGORY_URL = '{{route('course-categories.get-course-category-list')}}';
    const SUB_CATEGORY_URL = '{{route('course-sub-categories.get-course-sub-category-list')}}';
    const CHILD_CATEGORY_URL = '{{route('course-child-categories.get-course-child-category-list')}}';
    const TOGGLE_URL = '{{ route('common-update.update') }}';
    const USER_DETAIL_LIST_URL = '{{ route('user-details.get-user-detail-list') }}';
    /**
     * Form & Validation Object
     */
    var formObject = null;
    var formValidator = null;
</script>

<!-- jQuery 3 -->
<script src="{!! asset('assets/js/jquery/dist/jquery.min.js') !!}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{!! asset('assets/js/jquery-ui/jquery-ui.min.js') !!}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{!! asset('assets/js/bootstrap.min.js') !!}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Form Validator -->
<script src="{!! asset('assets/js/jquery-validation/jquery.validate.js') !!}"></script>
<script src="{!! asset('assets/js/jquery-validation/additional-methods.js') !!}"></script>
<script src="{!! asset('assets/js/jquery-validation/validation-config.js') !!}"></script>

{{-- //chart.JS
<script src="{!! asset('assets/js/chart.js/chart.min.js') !!}"></script>
--}}
<!-- daterangepicker -->
<script src="{!! asset('assets/js/moment/min/moment.min.js') !!}"></script>
<script src="{!! asset('assets/js/bootstrap-daterangepicker/daterangepicker.js') !!}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{!! asset('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') !!}"></script>
<!--timepicker -->
<script src="{{ asset('assets/js/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<!--Bootstrap 3 toggle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"
        integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Copy Link -->
<script src="{{ asset('assets/js/plugins/clipboard.js-master/dist/clipboard.min.js') }}"></script>
<!-- FastClick -->
<script src="{!! asset('assets/js/fastclick/lib/fastclick.js') !!}"></script>
<!--jquery steps -->
<script src="{{ asset('assets/js/jquery.steps/jquery.steps.js') }}"></script>
<!-- AdminLTE App -->
<script src="{!! asset('assets/js/adminlte.min.js') !!}"></script>
<!-- app JS -->
<script src="{!! asset('assets/js/app.js') !!}"></script>

{{-- For Latest--}}
@stack('scripts')

{{-- For Old Compitibality --}}
@yield('scripts')

