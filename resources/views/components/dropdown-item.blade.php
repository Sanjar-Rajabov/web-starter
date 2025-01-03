@php use App\Enums\DropdownItemTypeEnum; @endphp
<div>
    @if ($type === DropdownItemTypeEnum::Default)
        <a href="{{ $href }}" class="dropdown-item">
            {{ $slot }}
            <i class="feather icon-{{ $icon }}"></i>
        </a>
    @else
        <form action="{{ $href }}" method="post">
            @method('delete')
            @csrf
            <button class="btn-delete dropdown-item danger" type="submit">
                {{ $slot }}
                <i class="feather icon-{{ $icon }}"></i>
            </button>
        </form>
    @endif
</div>
