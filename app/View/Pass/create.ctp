<div class="container" id="main-container">
    <div class="row phone-container">
        <div id="phone">
            <div class="phone-inner">
                <div class="initial-message text-center">
                    your pass will update here <br>
                    as you make changes
                </div>
            </div>
        </div>
    </div>

    <section id="home-hero-unit" class="hero-unit">
        <div class="row">
            <div class="large-7 columns">
                <section id="pass-creation">
                    <nav id="tab-nav">
                        <ul>
                            <li class="active"><a href="#">design</a></li>
                            <li><a href="#">content</a></li>
                            <li><a href="#">barcode</a></li>
                            <li><a href="#">your account</a></li>
                            <li><a href="#">DONE!</a></li>
                        </ul>
                    </nav>

                    <div class="tab-pane">
                        <h2>step 1 : design</h2>

                        <?=$this->Form->create(null, array('id' => 'step1Form')); ?>
                            <div class="row">
                                <div class="large-12 columns">
                                    <label for="organizationName">your organization name:</label>
                                    <?= $this->Form->input('organizationName', array('div' => false, 'placeholder' => 'organization name','label'=> false )); ?>
                                </div>
                            </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <label for="description">description:</label>
                                <?= $this->Form->input('description', array('div' => false, 'placeholder' => 'description','label'=> false )); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <label for="backgroundColor">background color:</label>
                                <?= $this->Form->input('backgroundColor', array('id' => 'backgroundColor','div' => false, 'placeholder' => 'background color','label'=> false )); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <label for="foregroundColor">foreground color:</label>
                                <?= $this->Form->input('foregroundColor', array('id'=>'foregroundColor' ,'div' => false, 'placeholder' => 'foreground color','label'=> false )); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <label for="labelColor">label color:</label>
                                <?= $this->Form->input('labelColor', array('id'=>'labelColor','div' => false, 'placeholder' => 'label color','label'=> false )); ?>
                            </div>
                        </div>
                            <div class="row">
                                <div class="large-12 columns text-right">
                                    <a class="pb-btn" href="#">
                                        next step
                                    </a>
                                </div>
                            </div>
                        <?=$this->Form->end('Next'); ?>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <section class="app-body">
    </section>
</div>

<!--<section class="app-body">
    <div class="row">
        <div class="large-7 columns">
            <h3>Create a pass in under 5 mins</h3>
            <div id="tabstrip">
                <ul>
                    <li class="k-state-active" id="tab1">
                        design
                    </li>
                    <li id="tab2">
                        front
                    </li>
                    <li id="tab3">
                        back
                    </li>
                    <li id="tab4">
                        configuration
                    </li>
                    <li id="tab5">
                        your account
                    </li>
                    <li id="tab6">
                        DONE!
                    </li>
                </ul>
                <div>
                    <div class="">
                        <?/*=$this->Form->create(null, array('id' => 'step1Form')); */?>
                        <?/*=$this->Form->input('organizationName');*/?>
                        <?/*=$this->Form->input('description');*/?>
                        <?/*=$this->Form->input('backgroundColor', array('id' => 'backgroundColor'));*/?>
                        <?/*=$this->Form->input('foregroundColor', array('id' => 'foregroundColor'));*/?>
                        <?/*=$this->Form->input('labelColor', array('id' => 'labelColor'));*/?>
                        <?/*=$this->Form->end('Next'); */?>
                    </div>
                </div>
                <div>
                    <div class="">
                    </div>
                </div>
                <div>
                    <div class="">
                    </div>
                </div>
                <div>
                    <div class="">

                    </div>
                </div>
                <div>
                    <div class="">

                    </div>
                </div>
                <div>
                    <div class="">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="large-5 columns">

           <?/*//php echo $this->element('simulator/event'); */?>
        </div>
    </div>
</section>-->


<?
echo $this->Html->script('colorpicker.js');
echo $this->Html->css('colorpicker/colorpicker.css');
?>

<script>
    $(document).ready(function () {
        window.create_mode = true;
        $('#tabstrip').data('kendoTabStrip').disable($('[id^=tab]')).enable($('#tab1'));
    });
</script>