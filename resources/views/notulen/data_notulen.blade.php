@extends("tem.template")

@section("content")
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Data Proses</h5>

            </div>
            <div class="ibox-content">
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
    <div class="modal-dialog modal-md">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Ubah Status Rapat</h4>
            </div>
            <form id="statusForm" name="statusForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id_rapat" id="id_rapat">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Judul Rapat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="judul_rapat" id="judul_rapat" readonly="">
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status Rapat</label>
                        <div class="col-sm-9">
                        <select name="status_rapat" class="form-control" id="status_rapat" required="">
                            <option value="">Pilih</option>
                            <option value="3">Selesai</option>
                            <option value="4">Dibatalkan</option>
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
 $(document).ready(function(){ 
        //ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // datatable
        table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('rapattable') }}",
                type: "POST",
                data: {status:2}
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



$(document).on("click",".editstatus",function(){
    var id_rapat=$(this).data("id_rapat");
    var judul=$(this).data("judul");
    var status_rapat=$(this).data("status_rapat");
    $("#id_rapat").val(id_rapat);
    $("#status_rapat").val(status_rapat);
    $("#judul_rapat").val(judul);
    $("#ajaxModel").modal("show");
})

// create or update peserta
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Menyimpan..');

            $.ajax({
                data: $('#statusForm').serialize(),
                url: "{{ url('rapat/update_status') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#statusForm').trigger("reset");
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


    </script>          
    @endsection