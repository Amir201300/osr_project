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

        ajax: "{{ route('User.view',['user_type'=>$user_type]) }}",

        columns:
            [
                {data: 'checkBox', name: 'checkBox'},
                {data: 'id', name: 'id'},
                {data: 'image', name: 'image'},
                {data: 'name', name: 'name'},
                {data: 'user_type', name: 'user_type'},
                {data: 'city_id', name: 'city_id'},
                {data: 'area_id', name: 'area_id'},
                {data: 'status', name: 'status'},
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

        $('#title').text('{{trans("اضافة جديد")}}');

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
          url = save_method == 'add' ? "{{route('User.store')}}" : "{{route('User.update')}}" ;
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
             }else if(data.status == 0){
                 Toset('{{ trans("main.tryAgin") }}','error','');
                 console.log(data.message)
                 $('#errorText').text('* '+ data.message);
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
      url : '/manage/User/show/' +id,
      type : 'get',
      success : function(data){

        $('#name').val(data.name);
        $('#phone').val(data.phone);
        $('#email').val(data.email);
        $('#city_id').val(data.city_id);
        $('#area_id').val(data.area_id);
        $('#status').val(data.status);
        $('#user_type').val(data.user_type);
        $('#id').val(id);
        $('#loadEdit_'+id).css({'display' : 'none'});
        $('#formModel').modal();
          $.toast().reset('all');
      }
    })
  }
</script>

{{--- Store Info --}}

<script>
    function storeInfo(id)
    {
        TosetV2('{{ trans("main.proccess") }}','info','',false);
        $('#loadStoreInfo_'+id).css({'display' : ''});
        save_method='edit';
        $('#save').text('تعديل');
        $('#title').text('تعديل');

        $.ajax({
            url : '/manage/User/storeInfo/' +id,
            type : 'get',
            success : function(data){
                $('#loadStoreInfo_'+id).css({'display' : 'none'});
                if(data.status == 2)
                {
                    alert('هذا ليس متجر');
                }else {
                    var image= data.cover_photo ? '/images/Users/' + data.cover_photo : '/images/1.png';

                    $('#facebook').val(data.facebook);
                    $('#whatsapp').val(data.whatsapp);
                    $('#youtube').val(data.youtube);
                    $('#twitter').val(data.twitter);
                    $('#snap').val(data.snap);
                    $('#instagram').val(data.instagram);
                    $('#about_info').val(data.about_info);
                    $('#user_type').val(data.user_type);
                    $('#idUser').val(id);
                    $('#coverLink').attr('href',image);
                    $('#cover_photoImage').attr('src',image);
                    $('#InfoModel').modal();
                }
                $.toast().reset('all');
            }
        })
    }
</script>


{{--InfoForm Function --}}

<script>
    $('#InfoForm').submit(function(e){
        e.preventDefault();
        $("#saveInfo").attr("disabled", true);
        $('#err').slideUp(200);

        TosetV2('{{ trans("main.proccess") }}','info','',false);

        var id=$('#id').val();
        var formData = new FormData($('#InfoForm')[0]);
        url =  "{{route('User.storeInfoUpdate')}}"  ;
        $.ajax({
            url : url,
            type : "post",
            data : formData,
            contentType:false,
            processData:false,

            success : function(data)
            {
                $.toast().reset('all');
                $("#saveInfo").attr("disabled", false);

                if(data.errors==false)
                {
                    $('#InfoForm')[0].reset();
                    $('#errInfo').slideUp(200);
                    Toset('{{trans("main.success")}}','success','{{trans("main.successText")}}');

                    $("#InfoModel").modal('toggle');
                    table.ajax.reload();
                }else if(data.status == 0){
                    Toset('{{ trans("main.tryAgin") }}','error','');
                    console.log(data.message)
                    $('#errorText').text('* '+ data.message);
                }
                // Error
                else
                {
                    $.toast().reset('all');
                    $("#saveInfo").attr("disabled", false);
                    Toset('{{ trans("main.error") }}','error','',5000);
                }
            },
            error :  function(y)
            {
                $("#saveInfo").attr("disabled", false);
                $.toast().reset('all');
                Toset('{{ trans("main.tryAgin") }}','error','');
                var error = y.responseText;
                error= JSON.parse(error);
                error = error.errors;
                console.log(error );
                $('#errInfo').empty();
                for(var i in error)
                {
                    for(var k in error[i])
                    {
                        var message=error[i][k];
                        $('#errInfo').append("<p class='text-danger'>*"+message+"</p>");
                    }
                    $('#errInfo').slideDown(200);

                }
            }
        });

    })

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
      deleteProccess("/manage/User/delete/" +id_num);
      }else{
        
      deleteProccess("/manage/User/delete/"+checkArray +'?type=2');

    }
      }
</script>


{{-- Search Form --}}
<script>
    $('#seachForm').submit(function(e){
        e.preventDefault();
        var formData=$('#seachForm').serialize();
        table.ajax.url('/manage/User/view?'+formData);
        table.ajax.reload();
        TosetV2('تمت العملية بنجاح','success','',5000);

    })
</script>

<script>
    function ChangeStatus(status,id) {
        TosetV2('{{ trans("main.proccess") }}','info','',false);
        $.ajax({
            url : '/manage/User/ChangeStatus/' +id +'?status='+status,
            type : 'get',
            success : function(data){
                $.toast().reset('all');
                table.ajax.reload();
                TosetV2('تمت العملية بنجاح','success','',5000);
            }
        })
    }
</script>
