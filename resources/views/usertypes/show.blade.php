@if (isset($type->id))
        <div class="modal fade" id="usertype-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Show {{ $type->type }} user type.</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 style="font-weight: 300" class="mb-2">Name: {{ $type->type}}</h5>
                    <h6 class="mt-2">Description </h6>
                    <p> {{ $type->description }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <a href="{{ route('usertypes.edit',$type->id) }}" class="btn btn-success waves-effect waves-light ">Edit type</a>
                </div>
            </div>
        </div>
    </div>
@endif
