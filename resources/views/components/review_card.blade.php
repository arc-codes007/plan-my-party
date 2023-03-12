<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                <div class="d-flex justify-content-center p-3 w-100">
                    <div class="d-flex justify-content-center align-items-center" style="width:100px;height:100px" alt="Avatar">
                        <i class="fas fa-user-alt fa-3x text-info"></i>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card-title h4 fw-bold">{{$reviewer_name}} 
                    @if ($user_type == 'guest')
                        <span class="badge bg-danger">
                            Guest
                        </span>            
                    @else
                        <span class="badge bg-danger">
                            PMP User
                        </span>            
                    @endif
                </div>
                <div class="card-subtitle h5">{{$rating}} <i class="text-warning fa-solid fa-star"></i></div>
                <div class="card-text mt-3 h5">
                    {!! $review !!}
                </div>
            </div>
        </div>
    </div>
</div>