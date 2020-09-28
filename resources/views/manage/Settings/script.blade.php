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

        ajax: "{{ route('Settings.view') }}",

        columns:
            [
                {data: 'id', name: 'id'},
                {data: 'our_policy', name: 'our_policy'},
                {data: 'about_us', name: 'about_us'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
    });
</script>

{{--Add Function --}}


<script>
    $('#formSubmit').submit(function(e){
        e.preventDefault();
        $("#save").attr("disabled", true);
        $('#err').slideUp(200);

        TosetV2('{{ trans("main.proccess") }}','info','',false);

        var id=$('#id').val();
        var our_policy= CKEDITOR.instances.our_policy.getData();
        var about_us= CKEDITOR.instances.about_us.getData();
        var formData = new FormData($('#formSubmit')[0]);
        formData.append('our_policy',our_policy);
        formData.append('about_us',about_us);
        url = "{{route('Settings.update')}}" ;
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
                    CKEDITOR.instances.our_policy.resetDirty();
                    CKEDITOR.instances.about_us.resetDirty();

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
            url : '/manage/Settings/show/' +id,
            type : 'get',
            success : function(data){

                $('#name').val(data.name);
                CKEDITOR.instances['our_policy'].setData(data.our_policy);
                CKEDITOR.instances['about_us'].setData(data.about_us);
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
            url : '/manage/Settings/show/' +id,
            type : 'get',
            success : function(data){

                $('#messageShow').text(data.message);
                $('#id').text(id);
                $('#loadShow_'+id).css({'display' : 'none'});
                $('#showData').modal();
                $.toast().reset('all');
            }
        })
    }
</script>


<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace( 'our_policy' );
    CKEDITOR.replace( 'about_us' );

</script>

