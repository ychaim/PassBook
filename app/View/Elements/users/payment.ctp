

<div class="row">
    <div class="large-12 column">
        <h1 class="">Payment</h1>
        <? echo $this->Form->create('Payment'); ?>
        <? echo $this->Form->input('card_name', array('placeholder' => 'name', 'label' => FALSE, 'class' => 'input')); ?>
        <? echo $this->Form->input('card_number', array('placeholder' => 'number', 'label' => FALSE, 'class' => 'input')); ?>
        <? echo $this->Form->input('card_ccv', array('placeholder' => 'ccv', 'label' => FALSE, 'class' => 'input')); ?>
        <?php echo $this->Form->end(array('id' => 'submit', 'label' => 'Submit'));?>


    </div>
</div>