@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('users.all-admin-users') }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')
<!-- Custom styles for this page -->
<link href="/admin/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('users.all-admin-users') }}</h1>
@if(session()->has('message-type'))
@include('admin.layout.partials.notification-message')
@endif
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('users.users-details') }}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="users" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Active</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @if( count($users) > 0 )
                    @foreach($users as $value)
                    <tr>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->email }}</td>
                        <td class="text-center">
                            @if($value->active == 1)
                            <a href="{{ route('users.changestatus', ['user' => $value->id]) }}" class="btn btn-sm btn-success text-white">{{ __('users.active') }}</a>
                            @else
                            <a href="{{ route('users.changestatus', ['user' => $value->id]) }}" class="btn btn-sm btn-danger text-white">{{ __('users.inactive') }}</a>
                            @endif
                        </td>
                        <td>{{ $value->phone }}</td>
                        <td>{{ $value->address }}</td>
                        <td>{{ ucfirst($value->role) }}</td>
                        <td class="text-center">
                            <a href="{{ route('users.edit', ['user' => $value->id]) }}" class="btn btn-sm btn-primary text-white tooltip-custom" data-placement="top" title="Edit user">{{ __('users.edit') }}</a>
                            <a href="{{ route('users.changepassword', ['user' => $value->id]) }}" class="btn btn-sm btn-success text-white tooltip-custom" data-placement="top" title="Change password"><i class="fas fa-lock fa-sm fa-fw"></i></a>
                            <a data-name='{{ $value->name }}' data-toggle="modal" data-target="#deleteModal" data-href="{{ route('users.delete', ['user' => $value->id]) }}" class="btn btn-sm btn-danger text-white tooltip-custom" data-placement="top" title="Delete user {{ $value->name }}">{{ __('users.delete') }}</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLongTitle">{{ __('users.delete-user') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure that you want to delete user <span id="name-on-modal"></span> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('users.cancel') }}</button>
                <a id="delete-button-on-modal" class="btn btn-danger">{{ __('users.delete') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection


@section('custom-js')
<!-- Page level plugins -->
<script src="/admin/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#users').DataTable({
            "columnDefs": [{
                    "orderable": false,
                    "targets": [6]
                },
                {
                    "searchable": false,
                    "targets": [6]
                },
            ],
            "language": {

                // "sEmptyTable": "Nema podataka u tabeli",
                // "sInfo": "Prikaz _START_ do _END_ od ukupno _TOTAL_ zapisa",
                // "sInfoEmpty": "Prikaz 0 do 0 od ukupno 0 zapisa",
                // "sInfoFiltered": "(filtrirano od ukupno _MAX_ zapisa)",
                // "sInfoPostFix": "",
                // "sInfoThousands": ".",
                // "sLengthMenu": "Prikaži _MENU_ zapisa",
                // "sLoadingRecords": "Učitavanje...",
                // "sProcessing": "Obrada...",
                // "sSearch": "Pretraga:",
                // "sZeroRecords": "Nisu pronađeni odgovarajući zapisi",
                // "oPaginate": {
                //     "sFirst": "Početna",
                //     "sLast": "Poslednja",
                //     "sNext": "Sledeća",
                //     "sPrevious": "Predhodna"
                // },
                // "oAria": {
                //     "sSortAscending": ": aktivirajte da sortirate kolonu uzlazno",
                //     "sSortDescending": ": aktivirajte da sortirate kolonu silazno"
                // }
                // PREVOD NA SPSKI
            }
        });
    });

    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var userName = button.data('name');
        var userDeleteUrl = button.data('href');

        $("#name-on-modal").html("<b>" + userName + "</b>");
        $("#delete-button-on-modal").attr('href', userDeleteUrl);
    });

    $(function() {
        $('.tooltip-custom').tooltip()
    })
</script>
@endsection