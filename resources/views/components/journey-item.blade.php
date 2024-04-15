

<div class="card mx-3 w-75 my-3">
    <div class="h-100 relative">
        <div class="card-body d-flex justify-content-between">
            <div class="trip-info relative">
                <div class="item-text d-flex align-items-center">
                    <div class="text-data mx-3">
                        <h6 class="desc-text text-muted">From: </h6>
                        <h4 class="main-text">{{  $journey->from  }}</h4>
                    </div>
                </div>
                <span class="connector"></span>
                <div class="item-text d-flex align-items-center mt-4">
                    <div class="text-data mx-3">
                        <h6 class="desc-text text-muted">To: </h6>
                        <h4 class="main-text"> {{ $journey->to  }}</h4>
                    </div>
                </div>
            </div>
            <div class="price-container">
                <h1>{{ $journey->price  }} RSD</h1>
            </div>
        </div>
    </div>
    <hr />
    <div class="user-info d-flex pb-2 px-4 justify-content-between gap-3">

        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-circle"></i>
            <h3>{{ $journey->user->name  }}</h3>
        </div>

        <div class="rating d-flex flex-column align-items-center justify-content-center">
            <i class="bi bi-star-fill"></i>
            <h4>{{ $journey->user->rating  }}</h4>
        </div>
    </div>

</div>

