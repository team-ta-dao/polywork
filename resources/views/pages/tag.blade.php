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
    <a class="btn btn-success" href="javascript:void(0)" id="addTag">Add Skill Tag</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Tag Name</th>
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
                <form id="TagFrom" name="TagFrom" class="form-horizontal">
                    <span id="form_output"></span>
                   <input type="hidden" name="tag_id" id="tag_id">
                    <div class="form-group">
                        <label for="tag_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="tag_name" name="tag_name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_name">Tag</label>
                        <div class="col-sm-12">
                        <select class="form-control" id="category_name" name="category_name">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                        </select>
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
        ajax: "{{ route('tag.index') }}",
        columns: [
            {data: 'st_name', name: 'st_name'},
            {data: 'TagOfCategory', name: 'TagOfCategory'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#addTag').click(function () {
        $('#saveBtn').val("createTag");
        $('#Tag_id').val('');
        $('#button_action').val('insert');
        $('#TagFrom').trigger("reset");
        $('#modelHeading').html("Create New Tag");
        $('#ajaxModel').modal('show');
    });
    $('body').on('click', '.editTag', function () {
      var Tag_id = $(this).data('id');
      $.get("{{ route('tag.index') }}" +'/' + Tag_id +'/edit', function (data) {
        $('#modelHeading').html("Edit Tag");
        $('#saveBtn').html("Save changes");
        $('#button_action').val('update');
        $('#ajaxModel').modal('show');
        $('#tag_id').val(data.id);
        $('#tag_name').val(data.st_name);
        $("#category_name").find('option:selected').removeAttr("selected");
        $("#category_name").find('option[value="' + data.cat_id + '"]').attr("selected",true);
    })
   });
$('#saveBtn').click(function (e) {
        e.preventDefault();    
        $(this).html('Sending..');
        $.ajax({
          data: $('#TagFrom').serialize(),
          url: "{{ route('tag.store') }}",
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
                $('#TagFrom').trigger("reset");
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
    
    $('body').on('click', '.deleteTag', function () {
     
        var Tag_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('tag.store') }}"+'/'+Tag_id,
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