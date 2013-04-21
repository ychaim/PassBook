
<? /**
 * @var $this View
 */
?>
<div class="row">
    <div class="large-12 columns">
        <h1>User Details</h1>
        <p class="error"></p>
        <?=$this->Form->create('User', array('url' => '/users/add', 'id' => 'UserRegistrationForm'))?>

        <div class="row">
            <div class="large12 columns">
                <? echo $this->Form->input('name', array('placeholder' => 'Name', 'label' => FALSE, 'class' => 'input', 'required' => 'required', 'validationMessage' => "Please enter name")); ?>
            </div>
        </div>
        <div class="row">
            <div class="large12 columns">
                <? echo $this->Form->input('email', array('placeholder' => 'Email', 'label' => FALSE, 'class' => 'input', 'required' => 'required', 'validationMessage' => "Please enter email")); ?>
            </div>
        </div>
        <div class="row">
            <div class="large12 columns">
                <? echo $this->Form->input('password', array('placeholder' => 'Password', 'label' => FALSE, 'class' => 'input', 'required' => 'required', 'validationMessage' => "Please enter password")); ?>
            </div>
        </div>
        <div class="row">
            <div class="large12 columns">
                <? echo $this->Form->input('password2', array('placeholder' => 'Confirm Password', 'label' => FALSE, 'class' => 'input', 'required' => 'required', 'validationMessage' => "Please enter password again")); ?>
            </div>
        </div>
        <div class="row">
            <div class="large12 columns">
                <? echo $this->Form->input('company', array('placeholder' => 'Company', 'label' => FALSE, 'class' => 'input', 'required' => 'required', 'validationMessage' => "Please enter company")); ?>
            </div>
        </div>
        <div class="row">
            <div class="large12 columns">
                <? echo $this->Form->input('phone', array('placeholder' => 'Phone', 'label' => FALSE, 'class' => 'input', 'required' => 'required', 'validationMessage' => "Please enter phone")); ?>
            </div>
        </div>
        <div class="row">
            <div class="large12 columns">
                <? echo $this->Form->input('address', array('placeholder' => 'Address', 'label' => FALSE, 'class' => 'input', 'required' => 'required', 'validationMessage' => "Please enter address")); ?>
            </div>
        </div>
        <div class="row">
            <div class="large12 columns">
        <?php $states = array('nsw' => 'NSW', 'vic' => 'VIC', 'qld' => 'QLD', 'wa' => 'WA', 'nt' => 'NT', 'tas' => 'TAS', 'act' => 'ACT');
            echo $this->Form->input('state', array('options' => $states, 'default' => 'nsw','class'=>'small'));
        ?>
            </div>
        </div>
        <div class="row">
            <div class="large12 columns">
                <?php $country = array('Australia' => 'Australia', 'New Zealand' => 'New Zealand');
                      echo $this->Form->input('country', array('options' => $country, 'default' => 'Australia','class'=>'small'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <?php echo $this->Form->button('Register', array('type' => 'submit', 'class' => 'pb-btn medium')); ?>
            </div>
        </div>
        <?=$this->Form->end(); ?>
        </div>
</div>

<script>
    $(function(){
        var validator = $("#UserRegistrationForm").kendoValidator().data("kendoValidator");
        $("#UserRegistrationForm").submit(function(){
            return validator.validate();
        });

        $('#UserRegistrationForm').ajaxForm({
            before: function () {
                $('#AccountBlock p.error').hide();
            },
            success: function (resp) {
                resp = $.parseJSON(resp);
                if (resp.error !== undefined) {
                    $('#AccountBlock p.error').text(resp.error).show();
                } else {
                    $('#AccountBlock p.error').hide();
                    update_pass_user(resp.user_id,PassId);

                    $.ajax({
                        url: '/pass/payment_status/' + PassId,
                        dataType: 'json',
                        success: function(resp) {
                            if (resp.result) {
                                //paid then, what to do?
                                $('#AccountBlock').html('<p class="message">Your payment is good now, you can now go to next step.</p>')
                                $('#tabstrip').data('kendoTabStrip').enable($('#tab6'));
                            } else {
                                $('#AccountBlock').load('/users/payment', function(){
                                    $('#PaymentPassId').val(PassId);
                                });
                            }
                        }
                    })
                }
            }
        });

        function  update_pass_user(user_id,pass_id){
            $.ajax({
                type: "POST",
                url: "/pass/update_pass_user",
                data: {'user_id': user_id, 'pass_id': pass_id},
                success: function (resp) {
                    resp = $.parseJSON(resp);
                }
            });
        }

    })
</script>


