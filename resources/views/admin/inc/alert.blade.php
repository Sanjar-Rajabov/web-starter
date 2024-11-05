@if(session()->has('error'))
    <div class="card alert-danger">
        <div class="card-body">
            <i class="feather icon-alert-circle"></i> {{ session('error') }}
        </div>
    </div>
@endif
@if($errors->any())
    <div class="card alert-danger">
        <div class="card-body">
            <ul style="list-style: none">
                @foreach ($errors->all() as $error)
                    <li><i class="feather icon-alert-circle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
@if(session()->has('success'))
    <div class="card alert-success">
        <div class="card-body">
            <i class="feather icon-check-circle"></i> {{ session('success') }}
        </div>
    </div>
@endif
