<!-- Alerts script -->
<script>
    @if (session('alert_success'))
$.notify({
        // options
        //icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! session('title_success')!=null ?  session('title_success') : ' ' !!}",
        message: "{!! session('alert_success') !!}",
        url: '{!! session('route_success')!=null ?  session('route_success') : '' !!}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "success",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{!! session('from_success')!=null ?  session('from_success') : 'top' !!}",
            align: "{!! session('align_success')!=null ?  session('align_success') : 'center' !!}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: {!! session('timer_success')!=null ?  session('timer_success') : 5000 !!},
        timer: 1000,{{-- session('timer_success')!=null ?  session('timer_success') : 5000 --}}
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },
        icon_type: 'class'
    });

    @elseif(isset($alert_success))
$.notify({
        // options
        //icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! $title_success or '' !!}",
        message: "{!! $alert_success !!}",
        url: '{!! isset($route_success) ?  $route_success : '' !!}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "success",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{!!  $from_success or 'top' !!}",
            align: "{!! $align_success or 'center' !!}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: {!! $timer_success or 5000 !!},
        timer: 1000{{-- $timer_success or 5000 --}},
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },
        icon_type: 'class'
    });
    @endif

    @if(session('alert_info'))
$.notify({
        // options
        //icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! session('title_info')!=null ?  session('title_info') : ' ' !!}",
        message: "{!! session('alert_info') !!}",
        url: '{!! session('route_info')!=null ?  session('route_info') : '' !!}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "info",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{!! session('from_info')!=null ?  session('from_info') : 'top' !!}",
            align: "{!! session('align_info')!=null ?  session('align_info') : 'center' !!}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: {!! session('timer_info')!=null ?  session('timer_info') : 5000 !!},
        timer: 1000,{{-- session('timer_info')!=null ?  session('timer_info') : 5000 --}}
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },
        icon_type: 'class'
    });

    @elseif (isset($alert_info))
$.notify({
        // options
        //icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! $title_info or '' !!}",
        message: "{!! $alert_info !!}",
        url: '{!! isset($route_info) ?  $route_info : '' !!}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "info",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{!!  $from_info or 'top' !!}",
            align: "{!! $align_info or 'center' !!}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: {!! $timer_info or 5000 !!},
        timer: 1000,{{-- $timer_info or 5000  --}}
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },
        icon_type: 'class'
    });

    @endif




    @if (session('alert_warning'))
$.notify({
        // warning 1
        icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! session('title_warning')!=null ?  session('title_warning') : ' ' !!}",
        message: "{!! session('alert_warning') !!}",
        url: '{!! session('route_warning')!=null ?  session('route_warning') : '' !!}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "warning",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{!! session('from_warning')!=null ?  session('from_warning') : 'top' !!}",
            align: "{!! session('align_warning')!=null ?  session('align_warning') : 'center' !!}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 0, {{-- session('timer_warning')!=null ?  session('timer_warning') : 2000 --}}
        timer: 1000, {{--!! session('timer_warning')!=null ?  session('timer_warning') : 2000 !!--}}
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },
        icon_type: 'class',
    });


    @elseif (isset($alert_warning))
$.notify({
        // warning 2
        icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! $title_warning or '' !!}",
        message: "{!! $alert_warning !!}",
        url: '{!! isset($routewarning) ?  $route_warning : '' !!}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "warning",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{!!  $from_warning or 'top' !!}",
            align: "{!! $align_warning or 'center' !!}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 0, {{-- $timer_warning or 3000 --}}
        timer: 1000, {{-- $timer_warning or 3000 --}}
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },
        icon_type: 'class'
    });
    @endif



    @if (session('alert_danger'))
$.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! session('title_danger')!=null ?  session('title_danger') : ' ' !!}",
        message: "{!! session('alert_danger') !!}",
        url: '{!! session('route_danger')!=null ?  session('route_danger') : '' !!}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "danger",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{!! session('from_danger')!=null ?  session('from_danger') : 'top' !!}",
            align: "{!! session('align_danger')!=null ?  session('align_danger') : 'center' !!}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 0, {{-- session('timer_danger')!=null ?  session('timer_danger') : 5000 --}}
        timer: 1000, {{-- session('timer_danger')!=null ?  session('timer_danger') : 5000 --}}
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },

        icon_type: 'class'
    });

    @elseif(isset($alert_danger))
$.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! $title_danger or '' !!}",
        message: "{!! $alert_danger !!}",
        url: '{!! isset($route_danger) ?  $route_danger : '' !!}',
        target: '_blank'
    }, {
        // settings
        element: 'body',
        position: null,
        type: "danger",
        allow_dismiss: true,
        newest_on_top: true,
        showProgressbar: false,
        placement: {
            from: "{!!  $from_danger or 'top' !!}",
            align: "{!! $align_danger or 'center' !!}" //align: "center"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 0{{-- $timer_danger or 5000 --}},
        timer: 1000{{-- $timer_danger or 5000 --}},
        mouse_over: 'pause',
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },

        icon_type: 'class',
    });
    @endif
</script>

<!-- / Alerts script -->


{{-- **************Alerts**************  }}
<div class="row">
<div class="col-lg-2"></div>
<div class="col-lg-8">

    @if (session('alert_success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                &times;
            </button> {!! session('alert_success') !!}
        </div>
    @endif
    @if (session('alert_info'))
    @section('scripts')
        <script>
            $.notify({
                // options
                icon: 'glyphicon glyphicon-warning-sign',
                title: '{{ $title or '' }}',
                message: '{!! session('alert_info') !!}',
                url: '{{ session('route') ?  Route(session('route')) : ' ' }}',
                target: '_blank'
            },{
                // settings
                element: 'body',
                position: null,
                type: "info",
                allow_dismiss: true,
                newest_on_top: true,
                showProgressbar: false,
                placement: {
                    from: "{{ $from or 'top' }}",//from: "top",
                    align: "{{ $align or 'center' }}" //align: "center"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 5000,
                timer: 0,
                mouse_over: null,
                animate: {
                    enter: 'animated zoomInDown',
                    exit: 'animated zoomOutDown'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
            });
        </script>
    @endsection
    @endif
    @if (session('alert_warning'))
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                &times;
            </button> {!! session('alert_warning') !!}
        </div>
    @endif

    @if (session('alert_danger'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                &times;
            </button> {!! session('alert_danger') !!}
        </div>
    @endif

</div>
<div class="col-lg-2"></div>
</div>
{{-- **************endAlerts**************  --}}