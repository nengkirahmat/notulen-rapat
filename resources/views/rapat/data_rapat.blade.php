@extends("tem.template")

@section("content")
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Data Rapat</h5>

            </div>
            <div class="ibox-content">
                <button class="btn btn-info ml-auto" id="createNewrapat">Tambah Rapat</button>
                <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th>Jenis Rapat</th>
                            <th>Hari / Tanggal</th>
                            <th>Waktu Rapat</th>
                            <th>Tempat</th>
                            <th>Judul Rapat</th>
                            <th>Pimpinan Rapat</th>
                            <th>Sifat Rapat</th>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Tambah Data Rapat</h4>
            </div>
            <form id="rapatForm" name="rapatForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id_rapat" id="id_rapat">
 <div class="row">
        <div class="col-sm-6 b-r">                
                  <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label">Jenis Rapat</label>
                        <select name="id_jenis" class="form-control" id="id_jenis" required="">
                            <option value="">Pilih</option>
                            @foreach($jenis as $j)
                            <option value="{{$j->id_jenis}}">{{$j->nama_jenis}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Hari Rapat</label>
                        <select name="hari" class="form-control" id="hari" required="">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jum'at">Jum'at</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                     <div class="form-group">
                        <div class="col-sm-12">
                        <label for="tgl_rapat" class="control-label">Tanggal Rapat</label>
                       <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="tgl_rapat" id="tgl_rapat" class="form-control" value="{{date('Y-m-d')}}">
                                </div>
                       </div>
<style>
    .clockpicker-popover {
    z-index: 999999;
}
</style>
                       <div class="col-sm-6">
                        <label for="jam_mulai" class="control-label">Jam Mulai</label>
                         <div class="input-group clockpicker1" data-autoclose="true">
                                <input type="text" name="jam_mulai" id="jam_mulai" class="form-control" value="00:00" >
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                        <label for="jam_akhir" class="control-label">Jam Selesai</label>
                         <div class="input-group clockpicker2" data-autoclose="true">
                                <input type="text" name="jam_akhir" id="jam_akhir" class="form-control" value="00:00" >
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                       </div>  
                    </div>

                    <div class="form-group">
                        <label class="control-label">Tempat Rapat</label>
                        <select name="id_tempat" class="form-control" id="id_tempat" required="">
                            <option value="">Pilih</option>
                            @foreach($tempat as $t)
                            <option value="{{$t->id_tempat}}">{{$t->nama_tempat}}</option>
                            @endforeach
                        </select>
                    </div>   
</div>
</div>
<div class="col-sm-6">
    <div class="col-sm-12">
                    <div class="form-group">
                        <label for="judul_rapat" class="control-label">Judul Rapat</label>
                        <input type="text" class="form-control" id="judul_rapat" name="judul_rapat" required="">
                    </div>
                    <div class="form-group">
                        <label for="pimpinan_rapat" class="control-label">Pimpinan Rapat</label>
                        <input type="text" class="form-control" id="pimpinan_rapat" name="pimpinan_rapat" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Sifat Rapat</label>
                        <select name="sifat_rapat" class="form-control" id="sifat_rapat" required="">
                            <option value="">Pilih</option>
                            <option value="Terbuka">Terbuka</option>
                            <option value="Tertutup">Tertutup</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Status Rapat</label>
                        <select name="status_rapat" class="form-control" id="status_rapat" required="">
                            <option value="">Pilih</option>
                            <option value="1">Belum Mulai</option>
                            <option value="2">Proses</option>
                            <option value="3">Selesai</option>
                            <option value="4">Dibatalkan</option>
                        </select>
                    </div>
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
            ajax: {
            url: "{{ url('rapattable') }}",
            type: "POST"
        },
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_jenis', name: 'nama_jenis'},
            {data: 'tgl_rapat', name: 'tgl_rapat'},
            {data: 'waktu_rapat', name: 'waktu_rapat'},
            {data: 'nama_tempat', name: 'nama_tempat'},
            {data: 'judul_rapat', name: 'judul_rapat'},
            {data: 'pimpinan_rapat', name: 'pimpinan_rapat'},
            {data: 'sifat_rapat', name: 'sifat_rapat'},
            {data: 'status_rapat', name: 'status_rapat'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new rapat
        $('#createNewrapat').click(function () {
            $('#saveBtn').html("Simpan");
            $('#rapat_id').val('');
            $('#rapatForm').trigger("reset");
            $('#modelHeading').html("Tambah rapat Rapat");
            $('#ajaxModel').modal('show');
        });

        // create or update rapat
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Menyimpan..');

            $.ajax({
                data: $('#rapatForm').serialize(),
                url: "{{ url('rapat') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#rapatForm').trigger("reset");
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

        // edit rapat
        $('body').on('click', '.editrapat', function () {
            var id_rapat = $(this).data('id_rapat');
            $.get("{{ url('rapat') }}" + '/' + id_rapat + '/edit', function (data) {
                $('#modelHeading').html("Edit rapat Rapat");
                $('#saveBtn').html('Perbaharui');
                $('#ajaxModel').modal('show');
                $('#id_rapat').val(data.id_rapat);
                $('#id_jenis').val(data.id_jenis);
                $('#tgl_rapat').val(data.tgl_rapat);
                $('#jam_mulai').val(data.jam_mulai);
                $('#jam_akhir').val(data.jam_akhir);
                $('#id_tempat').val(data.id_tempat);
                $('#judul_rapat').val(data.judul_rapat);
                $('#pimpinan_rapat').val(data.pimpinan_rapat);
                $('#sifat_rapat').val(data.sifat_rapat);
                $('#status_rapat').val(data.status_rapat);
            })
        });

        $('body').on('click', '.deleterapat', function () {

            var id_rapat = $(this).data("id_rapat");
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
                            url: "{{ url('rapat') }}" + '/' + id_rapat,
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

        // delete rapat
        // $('body').on('click', '.deleterapat', function () {
        //     var id_rapat = $(this).data("id_rapat");
        //     confirm("Apakah yakin menghapus data ini?");

        //     $.ajax({
        //         type: "DELETE",
        //         url: "{{ url('rapat') }}" + '/' + id_rapat,
        //         success: function (data) {
        //             table.draw();
        //         },
        //         error: function (data) {
        //             console.log('Error:', data);
        //         }
        //     });
        // });

  

$('.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
            });

$('.clockpicker1').clockpicker();
$('.clockpicker2').clockpicker();
});
</script>          
@endsection