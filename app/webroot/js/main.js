
$(document).ready(function() {


    $("#menu").kendoMenu();
    $("#pass_type").kendoMenu();

    $('#resetPassword').click(function(e){
        var email = $('#email').val();
        $.ajax({
            type:"POST",
            url:'/users/send_password',
            data:{'data[email]':email },
            dataType:"json",
            success:function (json) {
                if (json.success !== undefined) {
                    $('#loginModal .modal-body .error').text(json.success).show();
                } else {
                    $('#loginModal .modal-body .error').text(json.error).show();
                }
            }
        });

    });

    var $tabStrip = $('#tabstrip');
    if($tabStrip.length) {
        $tabStrip.kendoTabStrip({
            animation:{
                open:{
                    effects:"fadeIn"
                }
            }
        });
        $("#barcode_format").kendoDropDownList();
        $('form[id^=step]').each(function(){
            var $form = $(this);
            $(this).ajaxForm({
                success:function (resp) {
                    resp = $.parseJSON(resp);
                    if (resp.error !== undefined) {
                        //todo: show error somewhere
                    } else {
                        if (window.create_mode !== undefined && window.create_mode === true) {
                            window.location.href = '/pass/edit/' + resp.success.id + '/step2';
                            return;
                        }

                        var tabNumber = parseInt($form.attr('id').substr(4,1));
                        if(tabNumber !== 6) {
                            tabNumber++;
                            var $tabToActivate = $('#tab' + tabNumber);
                            $tabStrip.data('kendoTabStrip').activateTab($tabToActivate);
                        }
                    }
                }
            });
        });

    }








});