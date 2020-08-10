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

        ajax: "{{ route('Product.view') }}",

        columns:
            [
                {data: 'checkBox', name: 'checkBox'},
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'price', name: 'price'},
                {data: 'cat_id', name: 'cat_id'},
                {data: 'user_id', name: 'user_id'},
                {data: 'rate', name: 'rate'},
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

        $('#title').text('{{trans("اضافة منتج جديد")}}');

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
          url = save_method == 'add' ? "{{route('Product.store')}}" : "{{route('Product.update')}}" ;
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
      url : '/manage/Product/show/' +id,
      type : 'get',
      success : function(data){

        $('#name').val(data.name);
        $('#price').val(data.price);
        $('#desc').val(data.desc);
        $('#delivery').val(data.delivery);
        $('#cat_id').val(data.cat_id);
        $('#user_id').val(data.user_id);
        $('#special').val(data.special);
        $('#status').val(data.status);
        $('#id').val(id);
        $('#loadEdit_'+id).css({'display' : 'none'});
        $('#formModel').modal();
          $.toast().reset('all');
      }
    })
  }
</script>


{{--Show Data --}}
<script>
    function showData(id)
    {
        TosetV2('{{ trans("main.proccess") }}','info','',false);
        $('#loadShow_'+id).css({'display' : ''});
        save_method='edit';
        $('#save').text('تعديل');
        $('#title').text('تعديل');

        $.ajax({
            url : '/manage/Product/show/' +id,
            type : 'get',
            success : function(data){

                $('#nameShow').text(data.name);
                $('#descShow').val(data.desc);
                $('#created_at').text(data.created_at);
                $('#view').text(data.view);
                $('#priceShow').text(data.price);
                $('#imageNum').text(data.imageNum);
                $('#rateNum').text(data.rateNum);
                $('#deliveryShow').text(data.delivery == 1 ? 'يوصل' : 'لا يوصل');
                $('#specialShow').text(data.special == 1 ? 'مميز' : 'غير مميز');
                $('#id').text(id);
                $('#loadShow_'+id).css({'display' : 'none'});
                $('#showData').modal();
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
      deleteProccess("/manage/Product/delete/" +id_num);
      }else{
        
      deleteProccess("/manage/Product/delete/"+checkArray +'?type=2');

    }
      }
</script>


{{-- Search Form --}}
<script>
    $('#seachForm').submit(function(e){
        e.preventDefault();
        var formData=$('#seachForm').serialize();
        table.ajax.url('/manage/Product/view?'+formData);
        table.ajax.reload();
        TosetV2('تمت العملية بنجاح','success','',5000);

    })
</script>

<script>
    function ChangeStatus(status,id) {
        TosetV2('{{ trans("main.proccess") }}','info','',false);
        $.ajax({
            url : '/manage/Product/ChangeStatus/' +id +'?status='+status,
            type : 'get',
            success : function(data){
                $.toast().reset('all');
                table.ajax.reload();
                TosetV2('تمت العملية بنجاح','success','',5000);
            }
        })
    }
</script>
