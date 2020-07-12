@extends("tem.template")

@section("content")
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Jenis Rapat</h5>

            </div>
            <div class="ibox-content">
                <button class="btn btn-info ml-auto" id="createNewjenis">Tambah Jenis Rapat</button>
                <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th>Jenis Rapat</th>
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
                <h4 class="modal-title">Jenis Rapat</h4>
            </div>
            <form id="jenisForm" name="jenisForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id_jenis" id="id_jenis">
                    <div class="form-group">
                        <label for="nama_jenis" class="col-sm-3 control-label">Jenis Rapat</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" required="">
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-9">
                        <select name="status_jenis" class="form-control" id="status_jenis" required="">
                            <option value="1">Aktif</option>
                            <option value="2">Non Aktif</option>
                        </select>
                    </div>
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
           ajax: {
            url: "{{ url('jenistable') }}",
            type: "POST"
        },
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_jenis', name: 'nama_jenis'},
            {data: 'status_jenis', name: 'status_jenis'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new jenis
        $('#createNewjenis').click(function () {
            $('#saveBtn').html("Simpan");
            $('#jenis_id').val('');
            $('#jenisForm').trigger("reset");
            $('#modelHeading').html("Tambah Jenis Rapat");
            $('#ajaxModel').modal('show');
        });

        // create or update jenis
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Menyimpan..');

            $.ajax({
                data: $('#jenisForm').serialize(),
                url: "{{ url('jenis') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#jenisForm').trigger("reset");
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

        // edit jenis
        $('body').on('click', '.editjenis', function () {
            var id_jenis = $(this).data('id_jenis');
            $.get("{{ url('jenis') }}" + '/' + id_jenis + '/edit', function (data) {
                $('#modelHeading').html("Edit Jenis Rapat");
                $('#saveBtn').html('Perbaharui');
                $('#ajaxModel').modal('show');
                $('#id_jenis').val(data.id_jenis);
                $('#nama_jenis').val(data.nama_jenis);
                $('#status_jenis').val(data.status_jenis);
            })
        });

        $('body').on('click', '.deletejenis', function () {

            var id_jenis = $(this).data("id_jenis");
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
                            url: "{{ url('jenis') }}" + '/' + id_jenis,
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

        // delete jenis
        // $('body').on('click', '.deletejenis', function () {
        //     var id_jenis = $(this).data("id_jenis");
        //     confirm("Apakah yakin menghapus data ini?");

        //     $.ajax({
        //         type: "DELETE",
        //         url: "{{ url('jenis') }}" + '/' + id_jenis,
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