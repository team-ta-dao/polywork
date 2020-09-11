<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
    
<div class="container">
    <a class="btn btn-success" href="javascript:void(0)" id="addCategory">Add Category</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="categoryFrom" name="categoryFrom" class="form-horizontal">
                    <span id="form_output"></span>
                   <input type="hidden" name="category_id" id="category_id">
                    <div class="form-group">
                        <label for="category_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="button_action" id="button_action" value="insert" />
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
</body>
    
<script type="text/javascript">
  $(function () {
     
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('category.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#addCategory').click(function () {
        $('#saveBtn').val("createCategory");
        $('#category_id').val('');
        $('#button_action').val('insert');
        $('#categoryFrom').trigger("reset");
        $('#modelHeading').html("Create New Category");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editCategory', function () {
      var category_id = $(this).data('id');
      $.get("{{ route('category.index') }}" +'/' + category_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Category");
          $('#saveBtn').html("Save changes");
          $('#button_action').val('update');
          $('#ajaxModel').modal('show');
          $('#category_id').val(data.id);
          $('#category_name').val(data.name);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();    
        $(this).html('Sending..');
        $.ajax({
          data: $('#categoryFrom').serialize(),
          url: "{{ route('category.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            if(data.error != null)
            {
                console.log(data.error);
                $('#saveBtn').html('Save changes');
                var error_html = '';
                error_html += '<div class="alert alert-danger">'+data.error+'</div>';
                $('#form_output').html(error_html);
                return false;
            }else{
                $('#categoryFrom').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
            }
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deleteCategory', function () {
     
        var category_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('category.store') }}"+'/'+category_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
  });
</script>
</html>