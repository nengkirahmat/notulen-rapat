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
#pegawai{
    display: none;
}
#non-pegawai{
    display: none;
}
#anggotadprd{
    display: none;
}

                     </style>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><i class="fa fa-eye"></i> Detail Rapat</h5>
            </div>
            <div class="ibox-content">
               <div class="row" style="font-size: 16px;">
                                <div class="col-sm-4">
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
                                                                            
                                    </address>
                                </div>
                                <div class="col-sm-4">
                                    <address>
                                        <strong>Judul Rapat</strong><br>
                                        {{$rapat[0]->judul_rapat}}<br>
                                        <strong>Pimpinan Rapat</strong><br>
                                        {{$rapat[0]->pimpinan_rapat}}<br>
                                        
                                    </address>
                                </div>
                                <div class="col-sm-4">
                                    <address>
                                        <strong>Sifat Rapat</strong><br>
                                        {{$rapat[0]->sifat_rapat}}<br>
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
                            </div>

                <button class="btn btn-info ml-auto" id="createNewpeserta"><i class="fa fa-plus"></i> Tambah Peserta</button>
                <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th>Nama Peserta</th>
                            <th>Instansi</th>
                            <th>Jabatan</th>
                            <th>No. Ponsel</th>
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
                <h4 class="modal-title">Peserta Rapat</h4>
            </div>
            <form id="pesertaForm" name="pesertaForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id_rapat" id="id_rapat" value="{{$rapat[0]->id_rapat}}">
                    <input type="hidden" name="id_peserta" id="id_peserta">
                    <div class="form-group">
                        <label for="nama_peserta" class="col-sm-3 control-label">Jenis Peserta</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="jenis">
                                <option value="">Pilih Jenis Peserta</option>
                                <option value="1">Pegawai Kota Solok</option>
                                <option value="2">Non Pegawai Kota Solok</option>
                                <option value="3">Anggota DPRD Kota Solok</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="pegawai">
                        <label for="nama_peserta" class="col-sm-3 control-label">Nama Peserta</label>
                        <div class="col-sm-9">
                            <select name="select" class="select2"></select>         
                        </div>
                     </div>

                     <div class="form-group" id="anggotadprd">
                        <label for="nama_peserta" class="col-sm-3 control-label">Nama Peserta</label>
                        <div class="col-sm-9">
                            <select name="select" class="form-control select3">
                                <option value="">Pilih Nama</option>
                                @foreach($anggotadprd as $dprd)
                                <option value="{{$dprd->id_anggotadprd}}">{{$dprd->nama_anggotadprd}}</option>
                                @endforeach
                            </select>         
                        </div>
                     </div>

                    <div class="form-group" id="non-pegawai">
                        <label for="nama_peserta" class="col-sm-3 control-label">Nama Peserta</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" required="">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label for="divisi" class="col-sm-3 control-label">Instansi</label>
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
            responsive: true,
            scrollX: true,
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
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // create new peserta
        $('#createNewpeserta').click(function () {
            $('.select2').val(null).trigger('change');
            $('#saveBtn').html("Simpan");
            $('#id_peserta').val('');
            $('#nama_peserta').val('');
            $('.select2').val(null).trigger('change');
            $('#pesertaForm').trigger("reset");
            $('#modelHeading').html("Tambah Peserta Rapat");
            $('#ajaxModel').modal('show');
        });

        // create or update peserta
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $( "#canvasloading" ).show();
            $( "#loading" ).show();
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
            $('.select2').val(null).trigger('change');
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

        // edit peserta
        $('body').on('click', '.editpeserta', function () {
            
            var id_peserta = $(this).data('id_peserta');
            $('.select2').val(null).trigger('change');
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
            $( "#canvasloading" ).show();
            $( "#loading" ).show();
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

 $(document).on("change","#jenis",function(){
                            var jenis=$(this).val();
                            if (jenis==1){
                                $('#nama_peserta').val("");
                                $('#divisi').val("");
                                $('#jabatan').val("");
                                $('#hp').val("");
                                $('.select2').val(null).trigger('change');
                                $('.select3').val(null).trigger('change');
                                $("#pegawai").css("display","block");
                                $("#non-pegawai").css("display","none");
                                $("#anggotadprd").css("display","none");
                            }else if(jenis==2){
                                $('#nama_peserta').val("");
                                $('#divisi').val("");
                                $('#jabatan').val("");
                                $('#hp').val("");
                                $('.select2').val(null).trigger('change');
                                $('.select3').val(null).trigger('change');
                                $("#non-pegawai").css("display","block");
                                $("#pegawai").css("display","none");
                                $("#anggotadprd").css("display","none");
                            }else if(jenis==3){
                                $('#nama_peserta').val("");
                                $('#divisi').val("");
                                $('#jabatan').val("");
                                $('#hp').val("");
                                $('.select2').val(null).trigger('change');
                                $('.select3').val(null).trigger('change');
                                $("#non-pegawai").css("display","none");
                                $("#pegawai").css("display","none");
                                $("#anggotadprd").css("display","block");
                            }else{
                                $('#nama_peserta').val("");
                                $('#divisi').val("");
                                $('#jabatan').val("");
                                $('#hp').val("");
                                $('.select2').val(null).trigger('change');
                                $('.select3').val(null).trigger('change');
                                $("#non-pegawai").css("display","none");
                                $("#pegawai").css("display","none");
                                $("#anggotadprd").css("display","none");
                            }
                        })


        $('.select2').select2(
        {
                    placeholder: 'Nama Anggota',
                    minimumInputLength: 2,
                    ajax: {
                        url: "/pegawaiSearch",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                return {
                                    q: params.term
                                    //tambahkan parameter lainnya di sini jika ada
                                }
                        },
                        processResults: function (data) {
                            return {
                                results:  $.map(data, function (item) {
                                        return {
                                            text:  item.nama_lengkap,
                                            id: item.id_user
                                        }
                                    })
                            };
                        },
                        cache: true
                    },
                    templateSelection: function (selection) {
                        var result = selection.text.split('-');
                        return result[0];
                    }
                }
                );



        $('.select2').on('select2:select', function (e) {
$( "#canvasloading" ).show();
            $( "#loading" ).show();
    var id = $(this).val();
            // $.get("{{ url('getUser') }}" + '/' + id,dataType:"json",function (data) {
            //     $('#nama_peserta').val(data.nama_lengkap);
            //     $('#divisi').val(data.nama_opd);
            //     $('#jabatan').val(data.jabatan);
            //     $('#hp').val(data.hp);
            //     alert(data.nama_lengkap);
            // })

            $.ajax({
                            type: "get",
                            url: "{{ url('getUser') }}" + '/' + id,
                            success: function (data) {
                                $('.select2').val(data.nama_lengkap);
                                $('#nama_peserta').val(data.nama_lengkap);
                $('#divisi').val(data.nama_opd);
                $('#jabatan').val(data.jabatan);
                $('#hp').val(data.hp);
                $( "#canvasloading" ).hide();
                $( "#loading" ).hide();
                                swal("Info", "Data Ditemukan...!", "success");
                            },
                            error: function (data) {
                                console.log('Error:', data);
                                $( "#canvasloading" ).hide();
                $( "#loading" ).hide();
                            }
                        });
});



// $('.select3').select2(
//         {
//                     placeholder: 'Nama Anggota',
//                     minimumInputLength: 2,
//                     ajax: {
//                         url: "/anggotadprdSearch",
//                         dataType: 'json',
//                         delay: 250,
//                         data: function (params) {
//                                 return {
//                                     q: params.term
//                                     //tambahkan parameter lainnya di sini jika ada
//                                 }
//                         },
//                         processResults: function (data) {
//                             return {
//                                 results:  $.map(data, function (item) {
//                                         return {
//                                             text:  item.nama_anggotadprd+ ' - ' + item.id_anggotadprd,
//                                             id: item.id_anggotadprd
//                                         }
//                                     })
//                             };
//                         },
//                         cache: true
//                     },
//                     templateSelection: function (selection) {
//                         var result = selection.text.split('-');
//                         return result[0];
//                     }
//                 }
//                 );

 $('.select3').select2();

        $('.select3').on('select2:select', function (e) {
$( "#canvasloading" ).show();
            $( "#loading" ).show();
    var id = $(this).val();
            // $.get("{{ url('getUser') }}" + '/' + id,dataType:"json",function (data) {
            //     $('#nama_peserta').val(data.nama_lengkap);
            //     $('#divisi').val(data.nama_opd);
            //     $('#jabatan').val(data.jabatan);
            //     $('#hp').val(data.hp);
            //     alert(data.nama_lengkap);
            // })

            $.ajax({
                            type: "get",
                            url: "{{ url('getanggotadprd') }}" + '/' + id,
                            success: function (data) {
                                $('.select3').val(data.nama_anggotadprd);
                                $('#nama_peserta').val(data.nama_anggotadprd);
                $('#divisi').val("DPRD Kota Solok");
                $('#jabatan').val(data.jabatan_anggotadprd);
                //$('#hp').val(data.hp_anggotadprd);
                $( "#canvasloading" ).hide();
                $( "#loading" ).hide();
                                swal("Info", "Data Ditemukan...!", "success");
                            },
                            error: function (data) {
                                console.log('Error:', data);
                                $( "#canvasloading" ).hide();
                $( "#loading" ).hide();
                            }
                        });
});


    });
</script>          
@endsection