<?php
/**
 * The template for displaying Mautic Subscription form
 *
 * @link              https://snotrainfotech.com/
 * @since             1.0.0
 *
 * @package           EventNews
 * @subpackage        EventNews/public/views
 */
?>
<div id="mauticform_wrapper_subscription" class="mauticform_wrapper">
    <form autocomplete="false" role="form" method="post" action="http://34.73.98.235/mautic/mauticopensource/form/submit?formId=1" id="mauticform_subscription" data-mautic-form="subscription" enctype="multipart/form-data">
        <div class="mauticform-error" id="mauticform_subscription_error"></div>
        <div class="mauticform-message" id="mauticform_subscription_message"></div>
        <div class="mauticform-innerform">

            <div class="mauticform-page-wrapper mauticform-page-1" data-mautic-form-page="1">

                <div id="mauticform_subscription_email" data-validate="email" data-validation-type="email" class="mauticform-row mauticform-email mauticform-field-1 mauticform-required">
                    <input id="mauticform_input_subscription_email" name="mauticform[email]" value="" placeholder="Enter your e-mail ID" class="mauticform-input" type="email">
                    <button type="submit" name="mauticform[submit]" id="mauticform_input_subscription_submit" value="" class="mauticform-button btn btn-default">Subscribe</button>
                    <span class="mauticform-errormsg" style="display: none;">Please enter valid Email ID</span>
                </div>

                <div id="mauticform_subscription_submit" class="mauticform-row mauticform-button-wrapper mauticform-field-2">
                </div>
            </div>
        </div>

        <input type="hidden" name="mauticform[formId]" id="mauticform_subscription_id" value="1">
        <input type="hidden" name="mauticform[return]" id="mauticform_subscription_return" value="">
        <input type="hidden" name="mauticform[formName]" id="mauticform_subscription_name" value="subscription">
    </form>
</div>