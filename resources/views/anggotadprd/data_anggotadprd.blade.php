@extends("tem.template")

@section("content")
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Anggota DPRD</h5>

            </div>
            <div class="ibox-content">
                <button class="btn btn-info ml-auto" id="createNewanggotadprd"><i class="fa fa-plus"></i> Tambah Anggota DPRD</button>
                <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th>Nama Lengkap</th>
                            <th>Jabatan</th>
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
                <h4 class="modal-title">Anggota DPRD</h4>
            </div>
            <form id="anggotadprdForm" name="anggotadprdForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id_anggotadprd" id="id_anggotadprd">
                    <div class="form-group">
                        <label for="nama_anggotadprd" class="col-sm-3 control-label">Nama Anggota DPRD</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_anggotadprd" name="nama_anggotadprd" required="">
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="jabatan_anggotadprd" class="col-sm-3 control-label">Jabatan Anggota DPRD</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="jabatan_anggotadprd" name="jabatan_anggotadprd" required="">
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
            url: "{{ url('anggotadprdtable') }}",
            type: "POST"
        },
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_anggotadprd', name: 'nama_anggotadprd'},
            {data: 'jabatan_anggotadprd', name: 'jabatan_anggotadprd'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new anggotadprd
        $('#createNewanggotadprd').click(function () {
            $('#saveBtn').html("Simpan");
            $('#id_anggotadprd').val('');
            $('#anggotadprdForm').trigger("reset");
            $('#modelHeading').html("Tambah Anggota DPRD");
            $('#ajaxModel').modal('show');
        });

        // create or update anggotadprd
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Menyimpan..');

            $( "#canvasloading" ).show();
            $( "#loading" ).show();
            $.ajax({
                data: $('#anggotadprdForm').serialize(),
                url: "{{ url('anggotadprd') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#anggotadprdForm').trigger("reset");
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

        // edit anggotadprd
        $('body').on('click', '.editanggotadprd', function () {
            
            var id_anggotadprd = $(this).data('id_anggotadprd');
            $.get("{{ url('anggotadprd') }}" + '/' + id_anggotadprd + '/edit', function (data) {
                $('#modelHeading').html("Edit Anggotadprd Rapat");
                $('#saveBtn').html('Perbaharui');
                $('#ajaxModel').modal('show');
                $('#id_anggotadprd').val(data.id_anggotadprd);
                $('#nama_anggotadprd').val(data.nama_anggotadprd);
                $('#jabatan_anggotadprd').val(data.jabatan_anggotadprd);
            })
            
        });

        $('body').on('click', '.deleteanggotadprd', function () {

            var id_anggotadprd = $(this).data("id_anggotadprd");
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
                            url: "{{ url('anggotadprd') }}" + '/' + id_anggotadprd,
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

        // delete anggotadprd
        // $('body').on('click', '.deleteanggotadprd', function () {
        //     var id_anggotadprd = $(this).data("id_anggotadprd");
        //     confirm("Apakah yakin menghapus data ini?");

        //     $.ajax({
        //         type: "DELETE",
        //         url: "{{ url('anggotadprd') }}" + '/' + id_anggotadprd,
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