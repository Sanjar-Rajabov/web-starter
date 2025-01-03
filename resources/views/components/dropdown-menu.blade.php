<div>
    <button class="btn btn-sm btn-icon" data-toggle="dropdown" id="{{ $id }}"><i class="feather icon-more-vertical"></i>
    </button>
    <div class="dropdown-menu" aria-labelledby="{{ $id }}" x-placement="bottom-start">
        {{ $slot }}
    </div>
</div>
