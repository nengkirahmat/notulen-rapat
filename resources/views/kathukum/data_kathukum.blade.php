@extends("tem.template")

@section("content")
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
                     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
                    <style>
                         .select2-close-mask{
    z-index: 2099;
}
.select2-dropdown{
    z-index: 3051;
}
.select2-container {
    width: 100% !important;
    padding: 0;
}
                     </style>                    
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Kategori Hukum</h5>

            </div>
            <div class="ibox-content">
                <button class="btn btn-info ml-auto" id="createNewkategori"><i class="fa fa-plus"></i> Tambah Kategori Hukum</button>
                <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th>Nama Kategori Hukum</th>
                            <th>Kelompok Hukum</th>
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



<div class="modal inmodal" id="ajaxModel" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Kategori Hukum</h4>
            </div>
            <form id="kategoriForm" name="kategoriForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id_kat" id="id_kat">
                    <div class="form-group">
                        <label for="kelompok" class="col-sm-3 control-label">Kelompok Hukum</label>
                        <div class="col-sm-9">
                            <select name="kelompok" id="kelompok" class="form-control select2">
                                <option value="">Pilih Kelompok Hukum</option>
                                @foreach($kelompok as $kel)
                                    <option value="{{$kel->id_kel}}">{{$kel->nama_kel}}</option>
                                @endforeach
                            </select>         
                        </div>
                     </div>
                    <div class="form-group">
                        <label for="nama_kat" class="col-sm-3 control-label">Nama Kategori Hukum</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_kat" name="nama_kat" required="">
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

        $(".select2").select2();

        // datatable
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "scrollX": true,
           ajax: {
            url: "{{ url('kathukumtable') }}",
            type: "POST"
        },
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_kat', name: 'nama_kat'},
            {data: 'nama_kel', name: 'nama_kel'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new kategori
        $('#createNewkategori').click(function () {
            $('#saveBtn').html("Simpan");
            $('#id_kat').val('');
            $('#kategoriForm').trigger("reset");
            $('#modelHeading').html("Tambah Jenis Rapat");
            $('#ajaxModel').modal('show');
        });

        // create or update kategori
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Menyimpan..');

            $( "#canvasloading" ).show();
            $( "#loading" ).show();
            $.ajax({
                data: $('#kategoriForm').serialize(),
                url: "{{ url('kathukum') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('.select2').val(null).trigger('change');
                    $('#kategoriForm').trigger("reset");
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

        // edit kategori
        $('body').on('click', '.editkategori', function () {
            
            var id_kat = $(this).data('id_kat');
            $.get("{{ url('kathukum') }}" + '/' + id_kat + '/edit', function (data) {
                $('#modelHeading').html("Edit Jenis Rapat");
                $('#saveBtn').html('Perbaharui');
                $('#ajaxModel').modal('show');
                $('#id_kat').val(data.id_kat);
                $('#nama_kat').val(data.nama_kat);
                $('#kelompok').val(data.kelompok);
                $('.select2').val(data.kelompok);
                })
            
        });

        $('body').on('click', '.deletekategori', function () {

            var id_kat = $(this).data("id_kat");
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
                            url: "{{ url('kathukum') }}" + '/' + id_kat,
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




        // delete kategori
        // $('body').on('click', '.deletekategori', function () {
        //     var id_kategori = $(this).data("id_kategori");
        //     confirm("Apakah yakin menghapus data ini?");

        //     $.ajax({
        //         type: "DELETE",
        //         url: "{{ url('kategori') }}" + '/' + id_kategori,
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