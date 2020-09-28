<script>

    function Toset(messag,btnClass,text)
 {
    $.toast({
                heading: messag,
                text: text,
              position: 'bottom-right',
                stack: 2,
                icon : btnClass,
                hideAfter: 5000,

            });
 }

 /**
  *
  * @param messag
  * @param btnClass
  * @param text
  * @param hideAfter
  * @constructor
  */
 function TosetV2(messag,btnClass,text,hideAfter)
 {
    $.toast({
                heading: messag,
                text: text,
              position: 'bottom-right',
                stack: 2,
                icon : btnClass,
                hideAfter: hideAfter,

            });
 }
</script>
{{-- custom Function to checkBox --}}
<script>

var checkArray=[];

function check(id)

{

  if($("#checkBox_"+id.toString()+"").is(":checked")==true){

  if(jQuery.inArray(id, checkArray) === -1 || checkArray.length === 0){

     checkArray.push(id);

}

  }else{

     checkArray.splice(checkArray.indexOf(id),1);

}
  console.log(checkArray);
}
</script>

{{-- custom Function to Delete --}}
<script>
function deleteProccess(url)
{
  $("#deleteYse").attr("disabled", true);

        TosetV2('{{ trans("main.proccess") }}','info','',false);

      $.ajax({
          url : url,
          type : "get",
          success : function(data)
          {
              $.toast().reset('all');
            table.ajax.reload();
            $('#DeleteModel').modal('toggle');
            $("#deleteYse").attr("disabled", false);
            Toset('{{trans("main.success")}}','success','{{trans("main.successText")}}');

          },
          error : function ()
          {
            $("#deleteYse").attr("disabled", false);

          }

      })
}
</script>


<script>
    function UserInfo(id) {
        TosetV2('{{ trans("main.proccess") }}','info','',false);
        $('#userInfo_'+id).css({'display' : ''});
        save_method='edit';
        $('#save').text('تعديل');
        $('#title').text('تعديل');

        $.ajax({
            url : '/manage/User/show/' +id,
            type : 'get',
            success : function(data){
                var  user_type ='عضو';
                if(data.user_type == 2)
                    user_type='متجر';
                if(data.user_type == 3)
                    user_type='مندوب';
                $('#nameShow').text(data.name);
                $('#nameUserShow').text(data.name);
                $('#userName').text(data.name);
                $('#phoneShow').text(data.phone);
                $('#created_atUser').text(data.created_at);
                $('#idShow').text(data.id);
                $('#emailShow').text(data.email);
                $('#cityShow').text(data.city_name);
                $('#areaShow').text(data.area_name);
                $('#deliveryShow').text(data.delivery == 1 ? 'يوصل' : 'لا يوصل');
                $('#userTypeShow').text(user_type);
                $('#id').text(id);
                $('#userInfo_'+id).css({'display' : 'none'});
                $('#userInfoModel').modal();
                $.toast().reset('all');
            }
        })
    }
</script>
