<form action="{{ $href }}" method="post">
    @method('delete')
    @csrf
    <button class="btn btn-danger btn-icon btn-sm btn-delete" type="submit">
        <i class="feather icon-trash"></i>
    </button>
</form>

