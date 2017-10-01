<script>

    @if (session('alert_success'))
$.notify({
        // success 1
        icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! session('title_success')!=null ?  session('title_success') : ' ' !!}",
        message: "{!! session('alert_success') !!}",
        url: '{!! session('route_success')!=null ?  Route(session('route_success')) : '' !!}',
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
        delay: 1000,
        timer: {!! session('timer_success')!=null ?  session('timer_success') : 5000 !!},
        mouse_over: 'pause',
        animate: {
            enter: 'animated wobble',
            exit: 'animated bounceOut'
        },
        icon_type: 'class'
    });

    @elseif(isset($alert_success))
$.notify({
        // success 2
        icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! $title_success or '' !!}",
        message: "{!! $alert_success !!}",
        url: '{!! isset($route_success) ?  Route($route_success) : '' !!}',
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
        delay: 1000,
        timer: {!! $timer_success or 5000 !!},
        mouse_over: 'pause',
        animate: {
            enter: 'animated wobble',
            exit: 'animated bounceOut'
        },
        icon_type: 'class'
    });
    @endif



    @if(session('alert_info'))
$.notify({
        // info 1
        icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! session('title_info')!=null ?  session('title_info') : ' ' !!}",
        message: "{!! session('alert_info') !!}",
        url: '{!! session('route_info')!=null ?  Route(session('route_info')) : '' !!}',
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
        delay: 1000,
        timer: {!! session('timer_info')!=null ?  session('timer_info') : 5000 !!},
        mouse_over: 'pause',
        animate: {
            enter: 'animated wobble',
            exit: 'animated bounceOut'
        },
        icon_type: 'class'
    });

    @elseif (isset($alert_info))
$.notify({
        // info 2
        icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! $title_success or '' !!}",
        message: "{!! $alert_info !!}",
        url: '{!! isset($route_info) ?  Route($route_info) : '' !!}',
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
        delay: 1000,
        timer: {!! $timer_info or 5000 !!},
        mouse_over: 'pause',
        animate: {
            enter: 'animated wobble',
            exit: 'animated bounceOut'
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
        url: '{!! session('route_warning')!=null ?  Route(session('route_warning')) : '' !!}',
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
            align: "{!! session('align_warning')!=null ?  session('align_warning') : 'center' !!}"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 1000,
        timer: {!! session('timer_warning')!=null ?  session('timer_warning') : 5000 !!},
        mouse_over: 'pause',
        animate: {
            enter: 'animated wobble',
            exit: 'animated bounceOut'
        },
        icon_type: 'class'
    });


    @elseif (isset($alert_warning))
$.notify({
        // warning 2
        icon: 'glyphicon glyphicon-warning-sign',
        title: "{!! $title_success or '' !!}",
        message: "{!! $alert_warning !!}",
        url: '{!! isset($routewarning) ?  Route($route_warning) : '' !!}',
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
            align: "{!! $align_warning or 'center' !!}"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 1000,
        timer: {!! $timer_warning or 5000 !!},
        mouse_over: 'pause',
        animate: {
            enter: 'animated wobble',
            exit: 'animated bounceOut'
        },
        icon_type: 'class'
    });
    @endif



    @if (session('alert_danger'))
$.notify({
        // danger1
        icon: 'glyphicon glyphicon-warning-sign',
        title: '{!! session('title_danger')!=null ?  session('title_danger') : ' ' !!}',
        message: "{!! session('alert_danger') !!}",
        url: '{!! session('route_danger')!=null ?  Route(session('route_danger')) : '' !!}',
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
            align: "{!! session('align_danger')!=null ?  session('align_danger') : 'center' !!}"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 1000,
        timer: {!! session('timer_danger')!=null ?  session('timer_danger') : 5000 !!},
        mouse_over: 'pause',
        animate: {
            enter: 'animated wobble',
            exit: 'animated bounceOut'
        },

        icon_type: 'class'
    });

    @elseif(isset($alert_danger))
$.notify({
        // danger2
        icon: 'glyphicon glyphicon-warning-sign',
        title: '{!! $title_success or '' !!}',
        message: "{!! $alert_danger !!}",
        url: '{!! isset($route_danger) ?  Route($route_danger) : '' !!}',
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
            align: "{!! $align_danger or 'center' !!}"
        },
        offset: 50,
        spacing: 10,
        z_index: 1031,
        delay: 1000,
        timer: {!! $timer_danger or 5000 !!},
        mouse_over: 'pause',
        animate: {
            enter: 'animated wobble',
            exit: 'animated bounceOut'
        },

        icon_type: 'class'
    });
    @endif


</script>

