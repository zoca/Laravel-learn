@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('pages.all-pages') }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')
<!-- Custom styles for this page -->
<!-- <link href="/admin/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('pages.pages') }}</h1>
<div id="errors-wrapper">
@if(session()->has('message-type'))
@include('admin.layout.partials.notification-message')
@endif
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <a href="{{ route('pages.index') }}">Root</a>
            @if(!is_null($page))
            {{ $page->breadcrumbs() }}
            @endif
            <!-- @if(!is_null($page) && $page->page_id != 0)
        {{ config('app.seo-separator') }} -->
            <!--  title od roditelja -->
            <!-- <a href="{{ route('pages.index', ['page' => $page->page_id]) }}">{{ $page->page->title }}</a> 
        @endif

        @if(!is_null($page))
        {{ config('app.seo-separator') }}
        <a>{{ $page->title }}</a>
        @endif -->
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="rows" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="order-col d-none">#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Active</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    @if( count($rows) > 0 )
                    @foreach($rows as $value)
                    <tr id="{{ $value->id }}">
                        <td class="order-col d-none">{{ $value->order_num }}</td>
                        <td>
                            <img class="mb-3" src="{{  $value->getImage('s') }}" alt="">
                        </td>
                        <td>{{ $value->title }}</td>
                        <td class="text-center">
                            @if($value->active == 1)
                            <a href="{{ route('pages.changestatus', ['page' => $value->id]) }}" class="btn btn-sm btn-success text-white">{{ __('pages.active') }}</a>
                            @else
                            <a href="{{ route('pages.changestatus', ['page' => $value->id]) }}" class="btn btn-sm btn-danger text-white">{{ __('pages.inactive') }}</a>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(in_array($value->id ,$pagesIds))
                            <a data-placement="top" title="{{ __('pages.show-pages') }}" href="{{ route('pages.index', ['page' => $value->id]) }}" class="btn btn-sm btn-info text-white tooltip-custom"><i class="far fa-eye fa-sm fa-fw"></i> ({{count($value->pages)}})</a>
                            @else
                            <a data-placement="top" title="{{ __('pages.no-show-pages') }}" class="btn btn-sm btn-info text-white tooltip-custom" disabled><i class="far fa-eye fa-sm fa-fw"></i></a>
                            @endif
                            <a data-placement="top" title="{{ __('pages.edit-page') }}" href="{{ route('pages.edit', ['page' => $value->id]) }}" class="btn btn-sm btn-primary text-white tooltip-custom">{{ __('pages.edit') }}</a>
                            <a data-placement="top" title="{{ __('pages.preview-page') }}" href="{{ route('pages.show', ['page' => $value->id, 'slug'=> Str::slug($value->title, '-') ] ) }}" class="btn btn-sm btn-success text-white tooltip-custom"><i class="fas fa-eye fa-sm fa-fw"></i></a>
                            <a data-placement="top" title="{{ __('pages.delete-page') . $value->title }}" data-name='{{ $value->title }}' data-toggle="modal" data-target="#deleteModal" data-href="{{ route('pages.delete', ['page' => $value->id]) }}" class="btn btn-sm btn-danger text-white tooltip-custom">{{ __('pages.delete') }}</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div id="form-state" class="d-none">
            <form action="{{ route('pages.neworder') }}" class="text-right" method="post">
                @csrf

                @if(!is_null($page))
                <input type="hidden" name="page_id" value="{{ $page->id }}">
                @else
                <input type="hidden" name="page_id" value="0">
                @endif
                
                <input type="hidden" value="" id="input-new-order-state" name="neworder">
                <button class="btn btn-success">Change pages order</button>
            </form>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLongTitle">{{ __('pages.delete-page') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure that you want to delete page <span id="name-on-modal"></span> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('pages.cancel') }}</button>
                <a id="delete-button-on-modal" class="btn btn-danger">{{ __('pages.delete') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection


@section('custom-js')
<!-- Page level plugins -->
<!-- <script src="/admin/assets/vendor/datatables/jquery.dataTables.min.js"></script> -->
<!-- <script src="/admin/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Page level custom scripts -->
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        // $('#rows').DataTable({
        //     "order": [
        //         [1, "asc"]
        //     ],
        //     "columnDefs": [{
        //             "orderable": false,
        //             "targets": [0, 2, 3]
        //         },
        //         {
        //             "searchable": false,
        //             "targets": [0, 3]
        //         },
        //     ],
        //     "language": {

        //         // "sEmptyTable": "Nema podataka u tabeli",
        //         // "sInfo": "Prikaz _START_ do _END_ od ukupno _TOTAL_ zapisa",
        //         // "sInfoEmpty": "Prikaz 0 do 0 od ukupno 0 zapisa",
        //         // "sInfoFiltered": "(filtrirano od ukupno _MAX_ zapisa)",
        //         // "sInfoPostFix": "",
        //         // "sInfoThousands": ".",
        //         // "sLengthMenu": "Prikaži _MENU_ zapisa",
        //         // "sLoadingRecords": "Učitavanje...",
        //         // "sProcessing": "Obrada...",
        //         // "sSearch": "Pretraga:",
        //         // "sZeroRecords": "Nisu pronađeni odgovarajući zapisi",
        //         // "oPaginate": {
        //         //     "sFirst": "Početna",
        //         //     "sLast": "Poslednja",
        //         //     "sNext": "Sledeća",
        //         //     "sPrevious": "Predhodna"
        //         // },
        //         // "oAria": {
        //         //     "sSortAscending": ": aktivirajte da sortirate kolonu uzlazno",
        //         //     "sSortDescending": ": aktivirajte da sortirate kolonu silazno"
        //         // }
        //         // PREVOD NA SPSKI
        //     }
        // });
    });

    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var name = button.data('name');
        var DeleteUrl = button.data('href');

        $("#name-on-modal").html("<b>" + name + "</b>");
        $("#delete-button-on-modal").attr('href', DeleteUrl);
    });

    $(function() {
        $('.tooltip-custom').tooltip()
    });

    $(function() {
        $("#sortable").sortable({
            update: function(event, ui) {
                //alert($('#sortable').sortable('toArray'));
                //$('#sortable').sortable('toArray');
                $('#input-new-order-state').val($('#sortable').sortable('toArray'));
                $('#form-state').removeClass('d-none');
                $('.order-col').removeClass('d-none');
            }
        });
        $("#sortable").disableSelection();
    });

    $(document).ready(function(){
        $('#form-state button').on('click', function(e){
            e.preventDefault();
            $.ajax({
                url: "{{ route('pages.neworder')}}",
                type: "post",
                data: {
                    'page_id': $('form [name=page_id]').val(),
                    'neworder': $('#input-new-order-state').val(),
                    '_token': $('form [name=_token]').val(),
                },
                dataType: 'html'
            }).done(function(data){
                $('#errors-wrapper').html(data);
            }).fail(function(jqXHR, error, message){
                alert(message);
            })
        });
    });
</script>
@endsection