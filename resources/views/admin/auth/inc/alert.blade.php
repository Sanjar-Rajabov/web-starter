@if(session()->has('error'))
    <div class="alert alert-danger form-group">
        <i class="feather icon-alert-circle"></i> {{ session('error') }}
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger form-group">
        <ul style="list-style: none">
            @foreach ($errors->all() as $error)
                <li><i class="feather icon-alert-circle"></i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session()->has('success'))
    <div class="alert alert-success form-group">
        <i class="feather icon-check-circle"></i> {{ session('success') }}
    </div>
@endif
