{{-- DataTable Function --}}
<script>
    var table = $('#datatable').DataTable({

        bLengthChange: false,

        searching: true,

        responsive: true,

        'processing': true,

        serverSide: true,

        order: [[0, 'desc']],

        "language": {
            "search": "بحث :"
        },

        ajax: "{{ route('Jobs.view') }}",

        columns:
            [
                {data: 'checkBox', name: 'checkBox'},
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'image', name: 'image'},
                {data: 'link', name: 'link'},
                {data: 'job_type', name: 'job_type'},
                {data: 'city_id', name: 'city_id'},
                {data: 'user_id', name: 'user_id'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
    });
</script>

{{--Add Function --}}

<script>
    function addFunction()
    {
        save_method='add';

        $('#err').slideUp(200);

        $('#save').text('حفظ');

        $('#title').text('{{trans("اضافة وظيفه جديده")}}');

        $('#formSubmit')[0].reset();

        $('#formModel').modal();
    }
</script>

{{--submit Function --}}

<script>
          $('#formSubmit').submit(function(e){
            e.preventDefault();
            $("#save").attr("disabled", true);
            $('#err').slideUp(200);

              TosetV2('{{ trans("main.proccess") }}','info','',false);

          var id=$('#id').val();
          var formData = new FormData($('#formSubmit')[0]);
          url = save_method == 'add' ? "{{route('Jobs.store')}}" : "{{route('Jobs.update')}}" ;
          $.ajax({
          url : url,
          type : "post",
          data : formData,
          contentType:false,
          processData:false,

          success : function(data)
          {
              $.toast().reset('all');
              $("#save").attr("disabled", false);

             if(data.errors==false)
             {
                $('#formSubmit')[0].reset();
                $('#loginDiv').slideUp(300);
                $('#err').slideUp(200);
                Toset('{{trans("main.success")}}','success','{{trans("main.successText")}}');

               //Redirect to dashboard
               $("#formModel").modal('toggle');
               table.ajax.reload();
             }
             // Error
             else
             {
                 $.toast().reset('all');
                 $("#save").attr("disabled", false);
              Toset('{{ trans("main.error") }}','error','',5000);
             }
          },
          error :  function(y)
          {
            $("#save").attr("disabled", false);
              $.toast().reset('all');
            Toset('{{ trans("main.tryAgin") }}','error','');
            var error = y.responseText;
            error= JSON.parse(error);
            error = error.errors;
            console.log(error );
            $('#err').empty();
            for(var i in error)
            {
              for(var k in error[i])
              {
                var message=error[i][k];
                $('#err').append("<p class='text-danger'>*"+message+"</p>");
                }
                $('#err').slideDown(200);

            }
          }
          });

        })

</script>

{

{{--Eedit --}}
<script>
  function edit(id)
  {
      TosetV2('{{ trans("main.proccess") }}','info','',false);
      $('#loadEdit_'+id).css({'display' : ''});
        save_method='edit';
        $('#save').text('تعديل');
        $('#title').text('تعديل');

    $.ajax({
      url : '/manage/Jobs/show/' +id,
      type : 'get',
      success : function(data){

        $('#name').val(data.name);
        $('#link').val(data.link);
        $('#desc').val(data.desc);
        $('#job_type').val(data.job_type);
        $('#email').val(data.email);
        $('#phone').val(data.phone);
        $('#salary').val(data.salary);
        $('#city_id').val(data.city_id);
        $('#id').val(id);
        $('#loadEdit_'+id).css({'display' : 'none'});
        $('#formModel').modal();
          $.toast().reset('all');
      }
    })
  }
</script>


{{--Delete --}}
<script>
    var id_num='';
    var checkNum='';
    function deleteFunction(id,check){
      
      id_num=id;
      checkNum=check;
      
      if(check == 2){
        if(checkArray.length == 0){
          alert("{{trans('main.noItemSelected')}}")
          }else{
            $('#DeleteModel').modal();
          }
        }
      
      else{
        $('#DeleteModel').modal();
      }
      
    }

    function yesDelete()
    {
      
      if(checkNum == 1){
      deleteProccess("/manage/Jobs/delete/" +id_num);
      }else{
        
      deleteProccess("/manage/Jobs/delete/"+checkArray +'?type=2');

    }
      }
</script>

