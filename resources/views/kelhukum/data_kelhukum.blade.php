@extends("tem.template")

@section("content")
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Kelompok Hukum</h5>

            </div>
            <div class="ibox-content">
                <button class="btn btn-info ml-auto" id="createNewkelompok"><i class="fa fa-plus"></i> Tambah Kelompok Hukum</button>
                <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th>Nama Kelompok Hukum</th>
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
                <h4 class="modal-title">Kelompok Hukum</h4>
            </div>
            <form id="kelompokForm" name="kelompokForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id_kel" id="id_kel">
                    <div class="form-group">
                        <label for="nama_kel" class="col-sm-3 control-label">Nama Kelompok Hukum</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_kel" name="nama_kel" required="">
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
    $(document).ready(function(){
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
            responsive: true,
            "scrollX": true,
           ajax: {
            url: "{{ url('kelhukumtable') }}",
            type: "POST"
        },
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_kel', name: 'nama_kel'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new kelompok
        $('#createNewkelompok').click(function () {
            $('#saveBtn').html("Simpan");
            $('#id_kel').val('');
            $('#kelompokForm').trigger("reset");
            $('#modelHeading').html("Tambah Jenis Rapat");
            $('#ajaxModel').modal('show');
        });

        // create or update kelompok
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Menyimpan..');

            $( "#canvasloading" ).show();
            $( "#loading" ).show();
            $.ajax({
                data: $('#kelompokForm').serialize(),
                url: "{{ url('kelhukum') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#kelompokForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    $('#saveBtn').html('Simpan');
                    $( "#canvasloading" ).hide();
                $( "#loading" ).hide();
                    swal({
                        title: "Berhasil!",
                        text: "",
                        type: "success"
                    });
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Simpan');
                    $( "#canvasloading" ).hide();
                $( "#loading" ).hide();
                }
            });
        });

        // edit kelompok
        $('body').on('click', '.editkelompok', function () {
            
            var id_kel = $(this).data('id_kel');
            $.get("{{ url('kelhukum') }}" + '/' + id_kel + '/edit', function (data) {
                $('#modelHeading').html("Edit Jenis Rapat");
                $('#saveBtn').html('Perbaharui');
                $('#ajaxModel').modal('show');
                $('#id_kel').val(data.id_kel);
                $('#nama_kel').val(data.nama_kel);
                })
            
        });

        $('body').on('click', '.deletekelompok', function () {

            var id_kel = $(this).data("id_kel");
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
                        $( "#canvasloading" ).show();
            $( "#loading" ).show();
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('kelhukum') }}" + '/' + id_kel,
                            success: function (data) {
                                table.draw();
                                $( "#canvasloading" ).hide();
                $( "#loading" ).hide();
                                swal("Deleted!", "Data Berhasil Dihapus...!", "success");
                            },
                            error: function (data) {
                                console.log('Error:', data);
                                $( "#canvasloading" ).hide();
                $( "#loading" ).hide();
                            }
                        });

                    } else {
                        $( "#canvasloading" ).hide();
                $( "#loading" ).hide();
                        swal("Cancelled", "Hapus data dibatalkan...! :)", "error");
                    }
                });
        });

        // delete kelompok
        // $('body').on('click', '.deletekelompok', function () {
        //     var id_kelompok = $(this).data("id_kelompok");
        //     confirm("Apakah yakin menghapus data ini?");

        //     $.ajax({
        //         type: "DELETE",
        //         url: "{{ url('kelompok') }}" + '/' + id_kelompok,
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