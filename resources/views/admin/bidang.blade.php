@extends('layouts.template')

@section('title')
Manage Departmen
@endsection

@section('badge')
{{$belum}}
@endsection

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
    </div>
    <!-- /.content-header -->
 <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="nav-icon fas fa-edit"></i> Manage Bidang</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <div class="text-center">
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-add">
          <i class="fa fa-plus"></i> Tambah data</button>
      </div >
      <br>
              <div class="table-responsive-sm">
              <table id="tabel_bidang" class="table table-bordered table-striped" style="width:100% !important; ">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

<!-- MODAL -->

      <!-- Modal tambah data bidang -->
      <div class="modal fade bd-example-modal-md" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Bidang </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Konten -->
          <form action="" method="POST" id="add-bidang">
          @csrf
        <div class="form-group">
        <label for="exampleInputEmail1">Nama Bidang</label>
        <input class="form-control" name="nama_bidang" type="text">
      </div>
        <!-- End Konten -->
      </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" title="Batal"><i class="fa fa-times"></i></button>
        <button type="submit" class="btn btn-outline-success btn-sm" title="Tambah"><i class="fa fa-check"></i></button>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>
      <!-- Akhir Modal tambah data bidang -->

      <!-- Modal edit data bidang -->
      <div class="modal fade bd-example-modal-md" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Konten -->
          <form action="" method="POST" id="edit-bidang">
          @csrf
        <div class="form-group">
        <label for="exampleInputEmail1">Nama Bidang</label>
        <input class="form-control" name="nama_bidang" type="text" id="nama">
      </div>
        <!-- End Konten -->
      
      <input type="hidden" name="_method" value="PUT">
      <input type="hidden" id="id_bidang">
      </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" title="Batal"><i class="fa fa-times"></i></button>
        <button type="submit" class="btn btn-outline-success btn-sm" title="Edit"><i class="fa fa-check"></i></button>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>
      <!-- Akhir Modal tambah data bidang -->
<!-- END MODALS -->
@endsection

@section('js')
<script type="text/javascript">

$('#modal-edit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var nama = button.data('nama')
  var id = button.data('id_bidang')

  var modal = $(this)
  modal.find('.modal-title').text('Edit ' + nama)
  modal.find('.modal-body #nama').val(nama)
  modal.find('.modal-body #id_bidang').val(id)
})

function hapus() {
  $('body').on('click', '#del_bidang', function(e){
      e.preventDefault();
      console.log('ojakjaf');
      Swal.fire({
        title: 'Anda Yakin ?',
        text: "Anda tidak dapat mengembalikan data yang telah di hapus!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Lanjutkan Hapus!',
        timer: 6500
      }).then((result) => {
          if (result.value) {
            var me = $(this),
                url = me.attr('href'),
                token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                  url: url,
                  method: "POST",
                  data : {
                    '_method' : 'DELETE',
                    '_token'  : token
                  },
                  success:function(data){
                    berhasil(data.status, data.pesan);
                    $('#tabel_bidang').DataTable().ajax.reload();
                  },
                  error: function(xhr, status, error){
                      var error = xhr.responseJSON; 
                      if ($.isEmptyObject(error) == false) {
                        $.each(error.errors, function(key, value) {
                          gagal(key, value);
                        });
                      }
                  } 
                });
        }
      });
    });
}

$('#add-bidang').submit(function(e){
      e.preventDefault();
    var request = new FormData(this);
    var endpoint= '{{route("bidang.store")}}';
          $.ajax({
            url: endpoint,
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            // dataType: "json",
            success:function(data){
              $('#add-bidang')[0].reset();
              $('#tabel_bidang').DataTable().ajax.reload();
              $('#modal-add').modal('hide');
              berhasil(data.status, data.pesan);
            },
            error: function(xhr, status, error){
                var error = xhr.responseJSON; 
                if ($.isEmptyObject(error) == false) {
                  $.each(error.errors, function(key, value) {
                    gagal(key, value);
                  });
                }
                } 
            }); 
    });

  //edit data bidang
  $('#edit-bidang').submit(function(e) {
    e.preventDefault();
    var id = eval(document.getElementById("id_bidang").value); //id pada inputan
    console.log(id);
    var request = new FormData(this);
    var endpoint = "manage-bidang/" + id;
    $.ajax({
      url: endpoint,
      method: "POST",
      data: request,
      contentType: false,
      cache: false,
      processData: false,
      // dataType: "json",
      success: function(data) {
        $('#edit-bidang')[0].reset(); //id form
        $('#modal-edit').modal('hide'); //id modal
        console.log(data.pesan);
        $('#tabel_bidang').DataTable().ajax.reload();
        berhasil(data.status, data.pesan);
      },
      error: function(xhr, status, error) {
        var error = xhr.responseJSON;
        if ($.isEmptyObject(error) == false) {
          $.each(error.errors, function(key, value) {
            gagal(key, value);
          });
        }
      }
    });
  });
  // end edit data bidang

tabel = $(document).ready(function(){
    $('#tabel_bidang').DataTable({
        "autoWidth": true,
        "searching": false,
        "processing": true,
        "serverSide": true,
        "deferRender": true,
        "lengthChange": false,
        "paging": false,
        "ordering": false,        // "scrollX" : true,
        "order": [[ 0, 'desc' ]],
        "aLengthMenu": [[5, 10, 50],[ 5, 10, 50]],
        "ajax":  {
                "url":  '{{route("table.bidang")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
        "columns": [
            { data: 'DT_RowIndex', name:'DT_RowIndex'},
            { "data": "nama" },
            { "data": "action" }
        ]
    });
});
</script>
@endsection