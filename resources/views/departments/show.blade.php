@if (isset($department->id))
    <div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Show {{ $department->department }} department.</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 style="font-weight: 300" class="mb-2">Name: {{ $department->department}}</h5>
                    <h6>Manager: {{ $department->user->first_name }} {{ $department->user->last_name}}</h6>
                    <h6>Assistant Manager: {{ $department->assistant }} </h6>
                    <p>Created At: {{ $department->created_at }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <a href="{{ route('departments.edit',$department->id) }}" class="btn btn-success waves-effect waves-light ">Edit department</a>
                </div>
            </div>
        </div>
    </div>
@endif
