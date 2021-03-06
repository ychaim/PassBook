<style type="text/css">
    .user-profile select{
        margin: 0 0 1.33333em 0;
        padding: 0.66667em;
    }
    .table-bordered {
        width: 100%;
        font-size: .75em;
    }
</style>
<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="large-12 column">
        <div class="section-container tabs" data-section>
            <section class="section">
                <p class="title"><a href="#pass">Manage Passes</a></p>
                <div class="content" data-slug="filters">
                    <div class="row">
                        <div class="large-12 columns">
                            <h3>Manage Passes</h3>

                            <div class="manage_pass_container">
                                <table class="manage-pass">
                                    <thead>
                                    <tr>
                                        <th width="10%"></th>
                                        <th width="10%"></th>
                                        <th width="10%"></th>
                                        <th width="15%">Name</th>
                                        <th width="15%">Downloads</th>
                                        <th>Download limit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? foreach ($user[0]['Pass'] as $p) { ?>
                                        <tr data-id="<? echo $p['id'] ?>">
                                            <td width="10%" class="pass_img"><img src="<? echo $p['iconImage'] ?>"
                                                                                  width="50px" alt="icon"/></td>
                                            <td width="10%">
                                                <a target="_blank" href="/pass/web_pass/<? echo $p['id'] ?>">view pass</a>
                                            </td>
                                            <td width="10%">
                                                <a class="get_code" href="/pass/web_pass/<? echo $p['id'] ?>">Get
                                                    Code</a>
                                            </td>
                                            <td width="15%">
                                                <? echo $p['organizationName'] ?>
                                            </td>
                                            <td width="15%">
                                                <span class="download_count"><? echo $p['download_count'] ?></span>
                                                <a href="/pass/download_report/<? echo $p['id'] ?>" target="_blank">Export</a>
                                            </td>
                                            <td>
                                                <input <? if (!$p['download_limit']) :?>checked="checked" <?endif;?> type="radio" name="limitPass<?=$p['id']?>" value="no-limit"> no limit<br>
                                                <input <? if ($p['download_limit'] > 0) :?>checked="checked" <?endif;?> type="radio" name="limitPass<?=$p['id']?>" value="limit"> limit to
                                                <input style="width: 50px;" class="update_limit" data-download-count="<? echo $p['download_count'] ?>"
                                                       id="<? echo $p['id'] ?>"
                                                       value="<? echo $p['download_limit'] ?>"/> downloads
                                            </td>
                                        </tr>
                                        <tr class="hide pass_code">
                                            <td colspan="6" class="pass_code">
                                                <h5>Get code to distribute your pass:</h5>

                                                <div class="row">
                                                    <div class="small-4 columns">
                                                        <div class="instruction">1) Copy and paste this link into an
                                                            email/Facebook etc
                                                        </div>
                                                        <div>
                                                            <input type="text"
                                                                   value="http://test.flypass.com.au/pass/web_pass/<? echo $p['id'] ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="small-4 columns">
                                                        <div class="instruction">or... 2) Choose one of our buttons and
                                                            grab the code
                                                        </div>
                                                        <div class="btn_group">
                                                            <button class="download_pass_btn red active">Download Pass
                                                            </button>
                                                            <button class="download_pass_btn velvet">Download Pass
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="small-4 columns">
                                                        <textarea cols="30" rows="3"><a href='http://www.flypass.com.au'><img src=""alt=""/></a></textarea>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section">
                <p class="title"><a href="#pass">Manage Payments</a></p>
                <div class="content" data-slug="payment">
                    <div class="row">
                        <div class="large-12 columns">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Pass Details</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Download</th>
                                    <th>Next Payment</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                    foreach($user[0]['Pass'] as $pass):
                                        $i = 0;
                                        foreach($pass['Payment'] as $payment):
                                            $total = count($pass['Payment']);
                                ?>
                                <tr>
                                    <? if ($i == 0): ?>
                                    <td rowspan='<?= $total?>'>something</td>
                                    <?endif;?>
                                    <td><?= $payment['date']?></td>
                                    <td>$<?= $payment['amount']?></td>
                                    <td><a href='#'>Link</a></td>
                                    <? if ($i == 0): ?>
                                    <td rowspan='<?= $total?>'>Aug 1</td>
                                    <?endif;?>
                                </tr>
                                <?
                                        $i++;
                                        endforeach;
                                    endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section">
                <p class="title"><a href="#customer">Manage Profile</a></p>
                <div style="font-size: 12px;padding: 20px;" class="content user-profile" data-slug="profile">
                    <?=$this->element('users/edit'); ?>
                </div>
            </section>
        </div>

    </div>
</div>

<script>
$(document).ready(function() {

    $(document).foundation();

    $(".get_code").on('click', function () {
        var $this = $(this);
        $this.toggleClass('active');
        $this.parents('tr').next().fadeToggle();
        return false;
    });

    $(".btn_group").on('click', 'button', function () {
        $(this).parent().find('button').removeClass('active');
        $(this).addClass('active');
    });

    var delay = (function(){
      var timer = 0;
      return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
      };
    })();

    $('.update_limit').change(function () {
        var $this = $(this);
        var val = $this.val();

        if (!!val.match(/^(\d+)$/) && val >= $this.data('download-count')) {
            delay(function () {
                $.ajax({
                    type    : "POST",
                    url     : "/pass/update_download_limit/",
                    data    : {'pass_id' : $this.attr('id'), 'limit' : val },
                    success : function (msg) {
                        msg = $.parseJSON(msg);
                        if (msg.success === true) {
                            alert('download limit has been updated');
                        }
                        else {
                            //alert('Problem in saving. Please try later');
                        }
                    }
                });
            }, 500);
        } else {
            alert("Download limit can't be smaller than download count");
            return false;
        }

    });


});
</script>