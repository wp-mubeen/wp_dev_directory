<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php
$connect = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('connect')));


?>
<div class="ga-connect-place">
    <?php if ($connect->google_analytics) { ?>
        <div class="card col-12 bg-google px-0 py-0 mb-2 mx-0">
            <div class="card-heading my-2">
                <h3 class="card-title text-white">
                    <div class="google-icon fa fa-google mx-2"></div><?php echo esc_html__("Google Analytics", _SQ_PLUGIN_NAME_); ?>
                </h3>
            </div>
            <div class="card-body bg-light py-3">



                <div class="row">
                    <div class="col-7 py-3 m-0">
                        <div>
                            <h6 class="text-black-50">
                                <?php echo esc_html__("You are connected to Google Analytics", _SQ_PLUGIN_NAME_) ?>

                            </h6>
                        </div>
                        <div>
                            <?php
                            $json = SQ_Classes_RemoteController::getGAProperties();
                            if(!is_wp_error($json)) {
                                $properties = $json->properties;
                                $property_id = $json->property_id;

                                if (!$property_id) {
                                    ?>
                                    <form id="sq_ga_property_form" method="post" class="p-0 m-0">
                                        <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_ga_save', 'sq_nonce'); ?>
                                        <input type="hidden" name="action" value="sq_seosettings_ga_save"/>
                                        <select name="property_id" class="d-inline-block m-0 p-1"
                                                onchange="if(confirm('Do you select this property?')){jQuery('form#sq_ga_property_form').submit();}">
                                            <option value=""></option>
                                            <?php foreach ($properties as $property) { ?>
                                                <option value="<?php echo $property->property_id ?>"><?php echo $property->website_url; ?> (<?php echo $property->ga_id ?>)</option>
                                            <?php } ?>
                                        </select>
                                    </form>
                                <?php } else {
                                    foreach ($properties as $property) {
                                        if($property->property_id == $property_id) {
                                            ?>
                                            <div class="text-black-50 font-weight-bold"><?php echo $property->website_url; ?>  (<?php echo $property->ga_id ?>)</div>
                                            <?php
                                            break;
                                        }
                                    }
                                }
                            }?>
                        </div>
                    </div>
                    <div class="col-5 align-items-center my-auto">

                        <form method="post" class="p-0 m-0" onsubmit="if(!confirm('Are you sure?')){return false;}">
                            <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_ga_revoke', 'sq_nonce'); ?>
                            <input type="hidden" name="action" value="sq_seosettings_ga_revoke"/>
                            <button type="submit" class="btn btn-block btn-social btn-google text-info connect-button connect btn-lg">
                                <?php echo esc_html__("Disconnect", _SQ_PLUGIN_NAME_) ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-12 bg-google py-2 mb-2">
            <div class="col-12">
                <h4 class="text-white py-3"><?php echo esc_html__("Connect this site to Google Analytics", _SQ_PLUGIN_NAME_); ?></h4>
                <p><?php echo esc_html__("Connect Google Analytics and get traffic insights for your website on each Audit.", _SQ_PLUGIN_NAME_) ?></p>
                <p><?php echo sprintf(esc_html__("Need Help Connecting Google Analytics? %sClick Here%s", _SQ_PLUGIN_NAME_),'<a href="https://howto.squirrly.co/faq/how-do-i-connect-google-analytics-both-tracking-code-and-the-api-connection/" target="_blank" style="color: lightyellow; text-decoration: underline">','</a>') ?></p>
            </div>
            <div class="sq_step1 mt-1">
                <a href="<?php echo SQ_Classes_RemoteController::getApiLink('gaoauth'); ?>" onclick="jQuery('.sq_step1').hide();jQuery('.sq_step2').show();jQuery(this).sq_clearCache();" target="_blank" type="button" class="btn btn-block btn-social btn-google text-info connect-button connect btn-lg">
                    <span class="fa fa-google"></span> <?php echo esc_html__("Sign in", _SQ_PLUGIN_NAME_); ?>
                </a>
            </div>
            <div class="sq_step2 mt-1" style="display: none">
                <form method="post" class="p-0 m-0">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_ga_check', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_ga_check"/>
                    <button type="submit" class="btn btn-block btn-social btn-warning btn-lg">
                        <span class="fa fa-google"></span> <?php echo esc_html__("Check connection", _SQ_PLUGIN_NAME_); ?>
                    </button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>