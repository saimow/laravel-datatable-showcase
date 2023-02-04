@extends('layouts.app')

@section('content')

<div class="">
    <div class="mb-4 d-flex">
        <a href="{{route('posts.create')}}" class="btn btn-primary btn-lg rounded-0 text-white ms-auto">Create Post</a>
    </div>
    <table class="table table-striped mb-3 border border-1" id=datatable>
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Content</th>
            <th scope="col">Created_at</th>
            <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table> 
    
</div>

<div class="modal fade" id="delete-confirmation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h1 class="modal-title fs-5">Delete confirmation</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                {{-- <form action="{{route('posts.destroy')}}" class="d-inline" method="post">
                    @method('DELETE')
                    @csrf --}}
                <input name="id" id="record-id" type="text" hidden>
                <button type="submit" class="btn btn-danger delete-record" data-bs-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    
</script>
<script>
    let datatable = $('#datatable').DataTable({
        "order": [3, 'desc'],
        "processing": true,
        "language": {
            processing: '<div class="spinner-border text-primary text-lg" style="width: 2.6rem; height: 2.6rem;" role="status"><span class="visually-hidden">Loading...</span></div>'
        },
        "serverSide": true,
        "searchDelay":1500,
        "ajax": "{{ route('posts.data') }}",
        "columnDefs": [
            { target:[0,3,4], className: 'align-middle' },
        ],
        "columns": [
            { data: 'id', name: 'id', searchable: true },
            { data: 'title', name: 'title', searchable: true },
            { data: 'content', name: 'content', searchable: true },
            { data: 'created_at', name: 'created_at', searchable: false },
            { data: 'actions', name: 'actions', searchable: false, orderable: false},
        ]
    });

    $(document).on('click','.delete-confirmation',function(){
        let id = $(this).attr('data-id');
        $('#record-id').val(id);
    });

    $(document).on('click', '.delete-record', function() {
        let id = $('#record-id').val();
        $.ajax({
            url: '/api/posts/delete/' + id,
            type: 'DELETE',
            success: function (data) {
                if (data.success) {
                    datatable.ajax.reload(null, false); // no pagination reset
                }
            }
    });
});
    
</script>

@endpush

@push('style')
<style>

</style>
@endpush