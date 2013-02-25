<? /**
 * @var $this View
 */
?>
<section id="pass_config">

<h3>Create a pass in under 5 mins</h3>

<div id="tabstrip">
    <ul>
        <li class="k-state-active" id="tab1">
            Details
        </li>
        <li id="tab2">
            Base items
        </li>
        <li id="tab3">
            Front
        </li>
        <li id="tab4">
            Back
        </li>
        <li id="tab5">
            Relevance
        </li>
    </ul>
    <div>
        <div class="">
            <?=$this->Form->create(null, array('url' => '/pass/edit/' . $this->data['Pass']['id'], 'id' => 'step1Form')); ?>
            <?=$this->Form->input('organizationName');?>
            <?=$this->Form->input('description');?>
            <?=$this->Form->end('Next'); ?>
        </div>
    </div>
    <div>
        <div class="">
            <div style="width:45%">
                <img src="/<?=$this->request->data['Pass']['iconImage']?>" id="iconImg"/>
                <?=$this->Form->input('iconImage', array('type' => 'file', 'rel' => '#iconImg', 'class' => 'imageUpload'));?>
                <img src="/<?=$this->request->data['Pass']['iconImageRetina']?>" id="iconImgRetina"/>
                <?=$this->Form->input('iconImageRetina', array('type' => 'file', 'rel' => '#iconImgRetina', 'class' => 'imageUpload'));?>

                <img src="/<?=$this->request->data['Pass']['backgroundImage']?>" id="backgroundImg"/>
                <?=$this->Form->input('backgroundImage', array('type' => 'file', 'rel' => '#backgroundImg', 'class' => 'imageUpload'));?>
                <img src="/<?=$this->request->data['Pass']['backgroundImageRetina']?>" id="backgroundImgRetina"/>
                <?=$this->Form->input('backgroundImageRetina', array('type' => 'file', 'rel' => '#backgroundImgRetina', 'class' => 'imageUpload'));?>

                <?=$this->Form->create(null, array('url' => '/pass/edit/' . $this->data['Pass']['id'], 'id' => 'step2Form')); ?>
                <?=$this->Form->input('backgroundColor', array('id' => 'backgroundColor'));?>
                <?=$this->Form->input('foregroundColor', array('id' => 'foregroundColor'));?>
                <?=$this->Form->input('labelColor', array('id' => 'labelColor'));?>
                <?=$this->Form->end('Next'); ?>
            </div>
        </div>
    </div>
    <div>
        <div class="">
            <div style="width:45%">
                <img src="/<?=$this->request->data['Pass']['logoImage']?>" id="logoImg"/>
                <?=$this->Form->input('logoImage', array('type' => 'file', 'rel' => '#logoImg', 'class' => 'imageUpload'));?>
                <img src="/<?=$this->request->data['Pass']['logoImageRetina']?>" id="logoImgRetina"/>
                <?=$this->Form->input('logoImageRetina', array('type' => 'file', 'rel' => '#logoImgRetina', 'class' => 'imageUpload'));?>

                <img src="/<?=$this->request->data['Pass']['thumbnailImage']?>" id="thumbnailImg"/>
                <?=$this->Form->input('thumbnailImage', array('type' => 'file', 'rel' => '#thumbnailImg', 'class' => 'imageUpload'));?>
                <img src="/<?=$this->request->data['Pass']['thumbnailImageRetina']?>" id="thumbnailImgRetina"/>
                <?=$this->Form->input('thumbnailImageRetina', array('type' => 'file', 'rel' => '#thumbnailImgRetina', 'class' => 'imageUpload'));?>

                <?=$this->Form->create(null, array('url' => '/pass/edit/' . $this->data['Pass']['id'], 'id' => 'step3Form')); ?>
                <?=$this->Form->input('logoText');?>
                <?=$this->Form->input('headerText');?>
                <div>
                    <label>Primary Fields: </label>
                    <button type="button" class="k-button dynamicFields" data-target="#primaryFieldsContainer">Add
                    </button>
                    <div class="<?=empty($this->data['Pass']['primaryFields']) ? 'hide' : ''?>"
                         id="primaryFieldsContainer">
                        <div class="inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.primaryFields.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.primaryFields.Value', array('label' => false));?>
                        </div>
                    </div>
                </div>
                <div>
                    <label>Secondary Fields: </label>
                    <button type="button" class="k-button dynamicFields" data-target="#secondaryFieldsContainer">Add
                    </button>
                    <div class="<?=empty($this->data['Pass']['secondaryFields']) ? 'hide' : ''?>"
                         id="secondaryFieldsContainer">
                        <div class="<?=empty($this->data['Pass']['secondaryFields'][0]) ? 'hide' : ''?> inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.secondaryFields.0.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.secondaryFields.0.Value', array('label' => false));?>
                        </div>
                        <div class="<?=empty($this->data['Pass']['secondaryFields'][1]) ? 'hide' : ''?> inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.secondaryFields.1.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.secondaryFields.1.Value', array('label' => false));?>
                        </div>
                        <div class="<?=empty($this->data['Pass']['secondaryFields'][2]) ? 'hide' : ''?> inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.secondaryFields.2.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.secondaryFields.2.Value', array('label' => false));?>
                        </div>
                        <div class="<?=empty($this->data['Pass']['secondaryFields'][3]) ? 'hide' : ''?> inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.secondaryFields.3.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.secondaryFields.3.Value', array('label' => false));?>
                        </div>
                        <div class="<?=empty($this->data['Pass']['secondaryFields'][4]) ? 'hide' : ''?> inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.secondaryFields.4.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.secondaryFields.4.Value', array('label' => false));?>
                        </div>
                    </div>
                </div>
                <div>
                    <label>Auxiliary Fields: </label>
                    <button type="button" class="k-button dynamicFields" data-target="#auxiliaryFieldsContainer">Add
                    </button>
                    <div class="<?=empty($this->data['Pass']['auxiliaryFields']) ? 'hide' : ''?>"
                         id="auxiliaryFieldsContainer">
                        <div class="<?=empty($this->data['Pass']['auxiliaryFields'][0]) ? 'hide' : ''?> inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.0.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.0.Value', array('label' => false));?>
                        </div>
                        <div class="<?=empty($this->data['Pass']['auxiliaryFields'][1]) ? 'hide' : ''?> inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.1.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.1.Value', array('label' => false));?>
                        </div>
                        <div class="<?=empty($this->data['Pass']['auxiliaryFields'][2]) ? 'hide' : ''?> inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.2.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.2.Value', array('label' => false));?>
                        </div>
                        <div class="<?=empty($this->data['Pass']['auxiliaryFields'][3]) ? 'hide' : ''?> inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.3.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.3.Value', array('label' => false));?>
                        </div>
                        <div class="<?=empty($this->data['Pass']['auxiliaryFields'][4]) ? 'hide' : ''?> inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.4.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.4.Value', array('label' => false));?>
                        </div>
                        <div class="<?=empty($this->data['Pass']['auxiliaryFields'][5]) ? 'hide' : ''?> inner">
                            <label>Label:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.5.Label', array('label' => false));?>
                            <label>Value:</label>
                            <?=$this->Form->input('Pass.auxiliaryFields.5.Value', array('label' => false));?>
                        </div>
                    </div>
                </div>
                <?=$this->Form->input('barcode_format_id');?>
                <p class="error"></p>
                <?=$this->Form->end('Next'); ?>
            </div>
        </div>
    </div>
    <div>
        <div class="">
            <a class="k-button" href="javascript:void(0);"
               data-href="/pass/generate_pass/<?=$this->data['Pass']['id']?>"
               id="generateBtn">Generate Pass</a>

        </div>
    </div>
    <div>
        <div class="">

            <p>
                Pass can be relevent by location. You can choose 10 locations.
                When your pass is close to the location it will appear on the lock screen.
            </p>
        </div>
    </div>
</div>


</section>
<section id="simulator">
    <?php echo $this->element('simulator/event'); ?>
</section>

<?
echo $this->Html->script('colorpicker.js');
echo $this->Html->css('colorpicker/colorpicker.css');
?>

<script>

    $(document).ready(function () {
        $('#backgroundColor, #foregroundColor, #labelColor').ColorPicker({
            onSubmit:function (hsb, hex, rgb, el) {
                $(el).val('rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')');
                $(el).ColorPickerHide();
            },
            onBeforeShow:function () {
                $(this).ColorPickerSetColor(this.value);
            }
        });

        var tabNumber = parseInt('<?=$step?>');
        var $tabToActivate = $('#tab' + tabNumber);
        $('#tabstrip').data('kendoTabStrip').activateTab($tabToActivate);

        $('.imageUpload').each(function () {
            var $this = $(this);
            $this.kendoUpload({
                async:{
                    saveUrl:"/pass/edit/<?=$this->data['Pass']['id']?>/",
                    removeUrl:"/pass/edit/<?=$this->data['Pass']['id']?>/?remove=" + encodeURIComponent($this.attr('name')),
                    autoUpload:true
                },
                multiple:false,
                success:function (e) {
                    var $target_img = $($this.attr('rel'));
                    if (e.response.success === true) $target_img.attr('src', '');
                    else $target_img.attr('src', e.response.success + '?' + Math.random());
                }
            });
        });
        $('#generateBtn').click(function () {
            var $this = $(this);
            $.ajax({
                url:$this.attr('data-href'),
                success:function (msg) {
                    alert('Success');
                }
            })
        });
        $('.dynamicFields').click(function () {
            var $container = $($(this).attr('data-target'));
            $container.show();
            $container.find('.inner:hidden').eq(0).show();
        })
    });
</script>