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
          {data: 'detail', name: 'detail'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
      ]
  });
   
  $('#createNewProduct').click(function () {
      $('#saveBtn').val("create-product");
      $('#product_id').val('');
      $('#productForm').trigger("reset");
      $('#modelHeading').html("Create New Product");
      $('#ajaxModel').modal('show');
  });
  
  $('body').on('click', '.editProduct', function () {
    var product_id = $(this).data('id');
    $.get("{{ route('category.index') }}" +'/' + product_id +'/edit', function (data) {
        $('#modelHeading').html("Edit Product");
        $('#saveBtn').val("edit-user");
        $('#ajaxModel').modal('show');
        $('#product_id').val(data.id);
        $('#name').val(data.name);
        $('#detail').val(data.detail);
    })
 });
  
  $('#saveBtn').click(function (e) {
      e.preventDefault();
      $(this).html('Sending..');
  
      $.ajax({
        data: $('#productForm').serialize(),
        url: "{{ route('category.store') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
   
            $('#productForm').trigger("reset");
            $('#ajaxModel').modal('hide');
            table.draw();
       
        },
        error: function (data) {
            console.log('Error:', data);
            $('#saveBtn').html('Save Changes');
        }
    });
  });
  
  $('body').on('click', '.deleteProduct', function () {
   
      var product_id = $(this).data("id");
      confirm("Are You sure want to delete !");
    
      $.ajax({
          type: "DELETE",
          url: "{{ route('category.store') }}"+'/'+product_id,
          success: function (data) {
              table.draw();
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
  });
});