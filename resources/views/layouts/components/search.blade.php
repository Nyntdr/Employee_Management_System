<div class="row mb-3">
    <div class="col-md-12">
        <form action="{{$route }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="{{$placeholder}}" value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Search</button>
            @if(request()->filled('search'))
                <a href="{{$route}}" class="btn btn-outline-secondary">Clear</a>
            @endif
        </form>
    </div>
</div>


