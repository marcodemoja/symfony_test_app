$(document).ready(function(){
    var formProfilo = $('form[name="appbundle_profilo"]');
    var formProfiloEsteso = $('form[name="appbundle_profiloesteso"]');

    setXhrReq(formProfilo);
    setXhrReq(formProfiloEsteso);

});


function setXhrReq(form){
    var action_url=form.attr('name').replace('appbundle_','/')+"/";
    var inputs={};
    var post_data = {};

    form.submit(function(e){
        e.preventDefault();
        $("#"+form.attr('name')+"_submit").hide();
        inputs = form.serializeArray();
        $(inputs).each(function(i,field){
            if(field.type != 'textarea')
                post_data[field.name] = field.value;
            else
                post_data[field.name] = field.text()
        });

        $.ajax({
            url:action_url,
            method: 'POST',
            data:post_data,
            dataType:'json',
            success:function(data){
                form.find('div.status').text(data.message).fadeOut(3000,function(){
                    $(this).html('').show();
                    $("#"+form.attr('name')+"_submit").show();
                });
            },
            error: function(response){
                var data = $.parseJSON(response.responseText);
                form.find('div.status').text(data.message).fadeOut(3000,function(){
                    $(this).html('').show();
                    $("#"+form.attr('name')+"_submit").show();
                });
            },
            cache:false
        });
    });
}