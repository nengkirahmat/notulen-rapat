@extends("tem.template")

@section("content")
<div class="row">
    <div class="col-lg-12">
<div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Form Produk Hukum</h5>
                        </div>
                        <div class="ibox-content">
                            @if ($errors->any())
    <div class="alert alert-danger" style="padding: 5px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                            <form id="hukumForm" action="produkhukum" name="hukumForm" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                @CSRF
                    <input type="hidden" name="id_hukum" id="id_hukum">
                    <div class="form-group">
                        <label for="kelompok" class="col-sm-3 control-label">Kelompok Hukum</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="kelompok" name="id_kel" required="">
                                <option value="">Pilih Kelompok</option>
                                @foreach($kelompok as $kel)
                                <option value="{{$kel->id_kel}}">{{$kel->nama_kel}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kelompok" class="col-sm-3 control-label">Kategori Hukum</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="kategori" name="id_kat" required="">
                                <option value="">Pilih Kelompok Terlebih Dahulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_hukum" class="col-sm-3 control-label">Judul</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_hukum" name="nama_hukum" required="">
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="tentang" class="col-sm-3 control-label">Tentang</label>
                        <div class="col-sm-9">
                        <textarea name="tentang" id="tentang" rows="3" class="form-control" required=""></textarea>
                    </div>
                    </div>
                    <div class="form-group">
                         <label for="tgl_hukum" class="col-sm-3 control-label">Tahun</label>
                                   <div class="col-sm-9">
                            <select name="tgl_hukum" class="form-control">
                                <option value="">Pilih Tahun</option>
                                <?php
                                for($i=2020;$i>=1945;$i--){
                                    ?>
                                    <option value="{{$i}}">{{$i}}</option>
                                    <?php
                                }
                                ?>
                            </select>
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-9">
                        <select name="status_hukum" class="form-control" id="status_hukum" required="">
                            <option value="1">Aktif</option>
                            <option value="2">Non Aktif</option>
                        </select>
                    </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="file_hukum" class="col-sm-3 control-label">Unggah Berkas</label>
                        <div class="col-sm-9">
                        <input type="file" class="" id="file_hukum" name="file_hukum" required="">
                    </div>
                    </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-white">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
                        </div>
                    </div>



        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Daftar Produk Hukum</h5>

            </div>
            <div class="ibox-content">
              <!--   <button class="btn btn-info ml-auto" id="createNewhukum"><i class="fa fa-plus"></i> Tambah Jenis</button> -->
                <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th>Nama Produk Hukum</th>
                            <th>Kelompok</th>
                            <th>Kategori</th>
                            <th>File Upload</th>
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


<script type="text/javascript">
    $(document).ready(function(){
        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

          $('.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'yyyy-mm-dd',
        });

        // datatable
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "scrollX": true,
           ajax: {
            url: "{{ url('hukumtable') }}",
            type: "POST"
        },
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_hukum', name: 'nama_hukum'},
            {data: 'nama_kel', name: 'nama_kel'},
            {data: 'nama_kat', name: 'nama_kat'},
            {data: 'file_hukum', name: 'file_hukum'},
            {data: 'status_hukum', name: 'status_hukum'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // // create new hukum
        // $('#createNewhukum').click(function () {
        //     $('#saveBtn').html("Simpan");
        //     $('#id_hukum').val('');
        //     $('#hukumForm').trigger("reset");
        //     $('#modelHeading').html("Tambah Jenis Rapat");
        //     $('#ajaxModel').modal('show');
        // });

        // // create or update hukum
        // $('#saveBtn').click(function (e) {
        //     e.preventDefault();
        //     $(this).html('Menyimpan..');

        //     $( "#canvasloading" ).show();
        //     $( "#loading" ).show();
        //     $.ajax({
        //         data: $('#hukumForm').serialize(),
        //         url: "{{ url('hukum') }}",
        //         type: "POST",
        //         dataType: 'json',
        //         success: function (data) {
        //             $('#hukumForm').trigger("reset");
        //             $('#ajaxModel').modal('hide');
        //             table.draw();
        //             $('#saveBtn').html('Simpan');
        //             $( "#canvasloading" ).hide();
        //         $( "#loading" ).hide();
        //             swal({
        //                 title: "Berhasil!",
        //                 text: "",
        //                 type: "success"
        //             });
        //         },
        //         error: function (data) {
        //             console.log('Error:', data);
        //             $('#saveBtn').html('Simpan');
        //             $( "#canvasloading" ).hide();
        //         $( "#loading" ).hide();
        //         }
        //     });
        // });

        // edit hukum
        $('body').on('click', '.edithukum', function () {
            
            var id_hukum = $(this).data('id_hukum');
            $.get("{{ url('produkhukum') }}" + '/' + id_hukum + '/edit', function (data) {
                $('#id_hukum').val(data.id_hukum);
                $('#nama_hukum').val(data.nama_hukum);
                $('#kelompok').val(data.kelompok);
                $('#kategori').val(data.kategori);
                $('#tentang').val(data.tentang);
                $('#tgl_hukum').val(data.tgl_hukum);
                $('#status_hukum').val(data.status_hukum);
            })
            
        });

        $('body').on('click', '.deletehukum', function () {

            var id_hukum = $(this).data("id_hukum");
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
                            url: "{{ url('produkhukum') }}" + '/' + id_hukum,
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

        // delete hukum
        // $('body').on('click', '.deletehukum', function () {
        //     var id_hukum = $(this).data("id_hukum");
        //     confirm("Apakah yakin menghapus data ini?");

        //     $.ajax({
        //         type: "DELETE",
        //         url: "{{ url('hukum') }}" + '/' + id_hukum,
        //         success: function (data) {
        //             table.draw();
        //         },
        //         error: function (data) {
        //             console.log('Error:', data);
        //         }
        //     });
        // });

        $(document).on("change","#kelompok",function(){
            var id_kel=$(this).val();
            if (id_kel==''){
                
            }else{
                $('#kategori').load("{{url('getkategori/')}}"+ '/' +id_kel);
            }
        });

    });
</script>          
@endsection