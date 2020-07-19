@extends("tem.template")

@section("content")
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Detail Rapat</h5>
            </div>
            <div class="ibox-content">
               <div class="row" style="font-size: 16px;">
                                <div class="col-sm-6">
                                    <address>
                                        <strong>Jenis Rapat</strong><br>
                                        {{$rapat[0]->nama_jenis}}<br>
                                        <strong>Tempat</strong><br>
                                        {{$rapat[0]->nama_tempat}}<br>
                                        <strong>Hari / Tanggal Rapat / Jam</strong><br>
                                        @if($rapat[0]->jam_akhir=="00:00")
                                        <?php $akhir="Selesai"; ?>
                                        @else
                                        <?php $akhir=$rapat[0]->jam_akhir; ?>
                                        @endif
                                        {{$rapat[0]->hari." / ".$rapat[0]->tgl_rapat." / ".$rapat[0]->jam_mulai." - ".$akhir}}<br>
                                        <strong>Status Rapat</strong><br>
                                        <?php
                                        if ($rapat[0]->status_rapat==1){
                                            $status="Belum Mulai";
                                        }elseif ($rapat[0]->status_rapat==2) {
                                            $status="Berlangsung";
                                        }elseif ($rapat[0]->status_rapat==3) {
                                            $status="Selesai";
                                        }elseif ($rapat[0]->status_rapat==4) {
                                            $status="Dibatalkan";
                                        }
                                        ?>
                                        {{$status}}<br>                                    
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <address>
                                        <strong>Judul Rapat</strong><br>
                                        {{$rapat[0]->judul_rapat}}<br>
                                        <strong>Pimpinan Rapat</strong><br>
                                        {{$rapat[0]->pimpinan_rapat}}<br>
                                        <strong>Sifat Rapat</strong><br>
                                        {{$rapat[0]->sifat_rapat}}<br>
                                    </address>
                                </div>
                            </div>

                <button class="btn btn-info ml-auto" id="createNewpeserta">Tambah Peserta Rapat</button>
                <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th>Nama Peserta</th>
                            <th>Divisi</th>
                            <th>Jabatan</th>
                            <th>No. Ponsel</th>
                            <th>Status Hadir</th>
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
                <h4 class="modal-title">Peserta Rapat</h4>
            </div>
            <form id="pesertaForm" name="pesertaForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id_rapat" id="id_rapat" value="{{$rapat[0]->id_rapat}}">
                    <input type="hidden" name="id_peserta" id="id_peserta">
                    <div class="form-group">
                        <label for="nama_peserta" class="col-sm-3 control-label">Nama Peserta</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" required="">
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="divisi" class="col-sm-3 control-label">Divisi</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="divisi" name="divisi" required="">
                    </div>
                </div>
                    <div class="form-group">
                        <label for="jabatan" class="col-sm-3 control-label">Jabatan</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="jabatan" name="jabatan" required="">
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="hp" class="col-sm-3 control-label">No. Ponsel</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="hp" name="hp" required="">
                    </div>
                </div>
                    <!-- <div class="form-group">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-9">
                        <select name="status_peserta" class="form-control" id="status_peserta" required="">
                            <option value="1">Aktif</option>
                            <option value="2">Non Aktif</option>
                        </select>
                    </div>
                    </div> -->
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
        var id="{{$rapat[0]->id_rapat}}";
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
           ajax: {
            url: "{{ url('pesertatable').'/'.$rapat[0]->id_rapat }}",
            type: "POST",
            data: {id_rapat:"{{$rapat[0]->id_rapat}}"},
        },
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_peserta', name: 'nama_peserta'},
            {data: 'divisi', name: 'divisi'},
            {data: 'jabatan', name: 'jabatan'},
            {data: 'hp', name: 'hp'},
            {data: 'status_hadir', name: 'status_hadir'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new peserta
        $('#createNewpeserta').click(function () {
            $('#saveBtn').html("Simpan");
            $('#id_peserta').val('');
            $('#pesertaForm').trigger("reset");
            $('#modelHeading').html("Tambah Peserta Rapat");
            $('#ajaxModel').modal('show');
        });

        // create or update peserta
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Menyimpan..');

            $.ajax({
                data: $('#pesertaForm').serialize(),
                url: "{{ url('peserta') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#pesertaForm').trigger("reset");
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

        // edit peserta
        $('body').on('click', '.editpeserta', function () {
            var id_peserta = $(this).data('id_peserta');
            $.get("{{ url('peserta') }}" + '/' + id_peserta + '/edit', function (data) {
                $('#modelHeading').html("Edit Peserta Rapat");
                $('#saveBtn').html('Perbaharui');
                $('#ajaxModel').modal('show');
                $('#id_peserta').val(data.id_peserta);
                $('#nama_peserta').val(data.nama_peserta);
                $('#divisi').val(data.divisi);
                $('#jabatan').val(data.jabatan);
                $('#hp').val(data.hp);
                $('#status_hadir').val(data.status_peserta);
            })
        });

        $('body').on('click', '.deletepeserta', function () {

            var id_peserta = $(this).data("id_peserta");
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
                            url: "{{ url('peserta') }}" + '/' + id_peserta,
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

        // delete peserta
        // $('body').on('click', '.deletepeserta', function () {
        //     var id_peserta = $(this).data("id_peserta");
        //     confirm("Apakah yakin menghapus data ini?");

        //     $.ajax({
        //         type: "DELETE",
        //         url: "{{ url('peserta') }}" + '/' + id_peserta,
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