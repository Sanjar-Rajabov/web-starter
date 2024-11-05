@section('modal')
    <div class="modal fade" id="confirm">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body py-4 px-md-4 px-3 text-center">
                    <button class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>

                    <h4 class="mt-4 font-weight-bold">@yield('text')</h4>
                    <div class="mt-5">
                        <a data-dismiss="modal" class="btn btn-primary mr-5" style="color:#fff;">Нет</a>
                        <a href="#" id="delete" class="btn btn-danger ml-5">Да</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.delete').click(function () {
            var id = $(this).attr('id')
            $('#confirm').modal('show')
            $('#confirm #delete').prop('href', '@yield('url')/delete/' + id)
        })
    </script>
@endsection
