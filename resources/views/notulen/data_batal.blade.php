@extends("tem.template")

@section("content")
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Data Selesai</h5>

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
                data: {status:4}
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

    </script>          
    @endsection