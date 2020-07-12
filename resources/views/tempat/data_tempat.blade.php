@extends("tem.template")

@section("content")
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Tempat Rapat</h5>

            </div>
            <div class="ibox-content">
                <button class="btn btn-info ml-auto" id="createNewtempat">Tambah Tempat Rapat</button>
                <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th>Tempat Rapat</th>
                            <th>Status</th>
                            <th width="140px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>



<div class="modal inmodal" id="ajaxModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Tempat Rapat</h4>
            </div>
            <form id="tempatForm" name="tempatForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id_tempat" id="id_tempat">
                    <div class="form-group">
                        <label for="nama_tempat" class="control-label">Tempat Rapat</label>
                        <input type="text" class="form-control" id="nama_tempat" name="nama_tempat" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Status</label>
                        <select name="status_tempat" class="form-control" id="status_tempat" required="">
                            <option value="1">Aktif</option>
                            <option value="2">Non Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // datatable
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('tempat') }}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_tempat', name: 'nama_tempat'},
            {data: 'status_tempat', name: 'status_tempat'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new tempat
        $('#createNewtempat').click(function () {
            $('#saveBtn').html("Simpan");
            $('#tempat_id').val('');
            $('#tempatForm').trigger("reset");
            $('#modelHeading').html("Tambah Tempat Rapat");
            $('#ajaxModel').modal('show');
        });

        // create or update tempat
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Menyimpan..');

            $.ajax({
                data: $('#tempatForm').serialize(),
                url: "{{ url('tempat') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#tempatForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    $('#saveBtn').html('Simpan');
                    swal({
                        title: "Berhasil!",
                        text: "",
                        type: "success"
                    });
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Simpan');
                }
            });
        });

        // edit tempat
        $('body').on('click', '.edittempat', function () {
            var id_tempat = $(this).data('id_tempat');
            $.get("{{ url('tempat') }}" + '/' + id_tempat + '/edit', function (data) {
                $('#modelHeading').html("Edit Tempat Rapat");
                $('#saveBtn').html('Perbaharui');
                $('#ajaxModel').modal('show');
                $('#id_tempat').val(data.id_tempat);
                $('#nama_tempat').val(data.nama_tempat);
                $('#status_tempat').val(data.status_tempat);
            })
        });

        $('body').on('click', '.deletetempat', function () {

            var id_tempat = $(this).data("id_tempat");
            swal({
                title: "Yakin hapus data ini?",
                text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus Data!",
                cancelButtonText: "Batal!",
                closeOnConfirm: false,
                closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('tempat') }}" + '/' + id_tempat,
                            success: function (data) {
                                table.draw();
                                swal("Deleted!", "Data Berhasil Dihapus...!", "success");
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });

                    } else {
                        swal("Cancelled", "Hapus data dibatalkan...! :)", "error");
                    }
                });
        });

        // delete tempat
        // $('body').on('click', '.deletetempat', function () {
        //     var id_tempat = $(this).data("id_tempat");
        //     confirm("Apakah yakin menghapus data ini?");

        //     $.ajax({
        //         type: "DELETE",
        //         url: "{{ url('tempat') }}" + '/' + id_tempat,
        //         success: function (data) {
        //             table.draw();
        //         },
        //         error: function (data) {
        //             console.log('Error:', data);
        //         }
        //     });
        // });

    });
</script>          
@endsection