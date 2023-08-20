<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta  name="author" content="Sadick Sessah-Odai">
    
    <title>@yield('title')</title>
    <x-favicon />

    <link rel="stylesheet" href="{{ asset('/fontawesome-free/css/6-all.min.css') }}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('dashboard/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link href="{{asset('plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datepicker/jquery.datetimepicker.min.css') }}"/ >
    @yield('styles')
    <link rel="stylesheet" href="{{asset('dashboard/css/styles.css')}}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.partials.nav')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Control Sidebar -->
        @include('admin.partials.control-sidebar')

        <!-- Main Footer -->
        @include('admin.partials.footer')
    </div>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}" type="text/javascript" ></script>
    <script src="{{asset('plugins/bootstrap@4/js/bootstrap.bundle.min.js')}}"></script>

    <!-- DataTables -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

    <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- MSSSHOP App -->
    <script src="{{asset('dashboard/dist/js/adminlte.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    {{-- toastr --}}
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    {{-- select2 --}}
    <script src="{{asset('plugins/select2/js/select2.min.js') }}"></script>
    {{-- datepicker --}}
    <script src="{{ asset('plugins/datepicker/jquery.datetimepicker.full.min.js') }}"></script>

    

    <script src="{{asset('dashboard/js/script.js')}}"></script>

    @yield('scripts')

    <script>
        $(function () {
            $('#productsTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                // "ordering": true,
                "info": true,
                "autoWidth": true,
                "columnDefs": [
                    { "orderable": false, "targets": 0 }
                    ]
            });

            $('.editor').summernote(
            {
                placeholder: 'Start writing...',
                tabsize: 2,
                height: 350
            }
            );

            $('.select2').select2();
            $('#order_date').datetimepicker();

            // fetch customers on orders page
            $('.customer').select2({
                placeholder: 'Please enter 1 or more charactors',
                minimumInputLength: 1,
                ajax: {
                    url: '/fetch-customers',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });


            // products
            $(document).on('click', '.add_product_field', function(){

                var new_row = $(".product_row:first").clone();
                $(".product_box").append(new_row);

                $(new_row).find(".select2-container").remove();
                var product = $(new_row).find(".product");
                var quantity = $(new_row).find(".product_quantity").val('');
                
                product.val('');
                quantity.val('');

                product.select2({
                    placeholder: 'Please enter 2 or more charactors',
                    minimumInputLength: 2,
                    ajax: {
                        url: '/fetch-products',
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.product_name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });

                initSelect();
            })


            initSelect();

            function initSelect(){
                 // fetch products
             $('.product').select2({
                placeholder: 'Please enter 2 or more charactors',
                minimumInputLength: 2,
                ajax: {
                    url: '/fetch-products',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.product_name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
         }

     });


         // alerts
        @if(session()->has('success'))
        toastr.success('{{session()->get('success')}}');
        @endif
        @if(session()->has('info'))
        toastr.info('{{session()->get('info')}}');
        @endif
        @if(session()->has('warning'))
        toastr.warning('{{session()->get('warning')}}');
        @endif
        @if(session()->has('error'))
        toastr.error('{{session()->get('error')}}');
        @endif
    </script>
</body>

</html>