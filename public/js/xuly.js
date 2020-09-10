$(document).ready(function() {
    $('#student_table').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax": "{!! route('getdata') !!}",
       "columns":[
           { "data": "category_name" },
           { "data": "action", orderable:false, searchable: false},
           { "data":"checkbox", orderable:false, searchable:false}
       ]
    });

   $('#add_data').click(function(){
       $('#studentModal').modal('show');
       $('#student_form')[0].reset();
       $('#form_output').html('');
       $('#button_action').val('insert');
       $('#action').val('Add');
       $('.modal-title').text('Add Data');
   });

   $('#student_form').on('submit', function(event){
       event.preventDefault();
       var form_data = $(this).serialize();
       $.ajax({
           url:"{{ route('admin.postdata') }}",
           method:"POST",
           data:form_data,
           dataType:"json",
           success:function(data)
           {
               if(data.error.length > 0)
               {
                   var error_html = '';
                   for(var count = 0; count < data.error.length; count++)
                   {
                       error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                   }
                   $('#form_output').html(error_html);
               }
               else
               {
                   $('#form_output').html(data.success);
                   $('#student_form')[0].reset();
                   $('#action').val('Add');
                   $('.modal-title').text('Add Data');
                   $('#button_action').val('insert');
                   $('#student_table').DataTable().ajax.reload();
               }
           }
       })
   });

   $(document).on('click', '.edit', function(){
       var id = $(this).attr("id");
       $('#form_output').html('');
       $.ajax({
           url:"{{route('ajaxdata.fetchdata')}}",
           method:'get',
           data:{id:id},
           dataType:'json',
           success:function(data)
           {
               $('#first_name').val(data.first_name);
               $('#last_name').val(data.last_name);
               $('#student_id').val(id);
               $('#studentModal').modal('show');
               $('#action').val('Edit');
               $('.modal-title').text('Edit Data');
               $('#button_action').val('update');
           }
       })
   });

   $(document).on('click', '.delete', function(){
       var id = $(this).attr('id');
       if(confirm("Are you sure you want to Delete this data?"))
       {
           $.ajax({
               url:"{{route('ajaxdata.removedata')}}",
               mehtod:"get",
               data:{id:id},
               success:function(data)
               {
                   alert(data);
                   $('#student_table').DataTable().ajax.reload();
               }
           })
       }
       else
       {
           return false;
       }
   }); 

   $(document).on('click', '#bulk_delete', function(){
       var id = [];
       if(confirm("Are you sure you want to Delete this data?"))
       {
           $('.student_checkbox:checked').each(function(){
               id.push($(this).val());
           });
           if(id.length > 0)
           {
               $.ajax({
                   url:"{{ route('ajaxdata.massremove')}}",
                   method:"get",
                   data:{id:id},
                   success:function(data)
                   {
                       alert(data);
                       $('#student_table').DataTable().ajax.reload();
                   }
               });
           }
           else
           {
               alert("Please select atleast one checkbox");
           }
       }
   });

});