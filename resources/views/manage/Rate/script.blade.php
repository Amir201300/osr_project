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

        ajax: "/manage/Rate/ProductRate/{{$product->id}}?type={{$type}}",

        columns:
            [
                {data: 'checkBox', name: 'checkBox'},
                {data: 'id', name: 'id'},
                {data: 'user_id', name: 'user_id'},
                {data: 'rate', name: 'rate'},
                {data: 'comment', name: 'comment'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
    });
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
      deleteProccess("/manage/Rate/delete/" +id_num);
      }else{
        
      deleteProccess("/manage/Rate/delete/"+checkArray +'?type=2');

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
