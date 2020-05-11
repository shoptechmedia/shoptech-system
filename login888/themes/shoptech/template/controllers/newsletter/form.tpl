{*if isset($smarty.get.render)} {if $smarty.get.render === 'contacts'}
<iframe src="https://demo.shoptech.media/mail/s/contacts" style="width: 100%;height: 82vh;border: none;"></iframe>
{elseif $smarty.get.render === 'segments'}
<iframe src="https://demo.shoptech.media/mail/s/segments" style="width: 100%;height: 82vh;border: none;"></iframe>
{elseif $smarty.get.render === 'campaigns'}
<iframe src="https://demo.shoptech.media/mail/s/campaigns" style="width: 100%;height: 82vh;border: none;"></iframe>
{elseif $smarty.get.render === 'emails'}
<iframe src="https://demo.shoptech.media/mail/s/emails" style="width: 100%;height: 82vh;border: none;"></iframe>
{elseif $smarty.get.render === 'reports'}
<iframe src="https://demo.shoptech.media/mail/s/reports" style="width: 100%;height: 82vh;border: none;"></iframe>
{else} {/if} {else}
<iframe src="https://demo.shoptech.media/mail/s/login?user=shoptechmedia&&pass=secure@12" style="width: 100%;height: 82vh;border: none;"></iframe>
{/if*}
<!-- <div id="target" style="width: 100%;height: 100vh;border: none;"></div> -->

<div class="builder email-builder  builder-active">
    <script type="text/html" data-builder-assets="">
        &lt;link rel=&quot;stylesheet&quot; href=&quot;/mail/app/bundles/CoreBundle/Assets/css/libraries/builder.css&quot; data-source=&quot;mautic&quot; /&gt; &lt;script data-source=&quot;mautic&quot;&gt; var mauticBasePath = '/mail'; var mauticAjaxUrl = '/mail/s/ajax'; var mauticBaseUrl = '/mail/'; var mauticAssetPrefix = ''; var mauticLang = { &quot;mautic.core.builder.code_mode_warning&quot;: &quot;By switching to the Code Mode, you will be able to edit the content only in HTML code. Changing back to a theme will lose content.&quot;, &quot;mautic.core.builder.theme_change_warning&quot;: &quot;You will lose the current content if you switch the theme.&quot;, &quot;mautic.core.builder.section_delete_warning&quot;: &quot;Are you sure you want to delete the whole section and the content within?&quot;, &quot;mautic.core.lookup.keep_typing&quot;: &quot;Keep typing...&quot;, &quot;mautic.core.lookup.looking_for&quot;: &quot;Looking for&quot;, &quot;mautic.core.lookup.search_options&quot;: &quot;Search options...&quot;, &quot;mautic.core.dynamicContent&quot;: &quot;Dynamic Content&quot;, &quot;mautic.core.dynamicContent.new&quot;: &quot;Dynamic Content %number%&quot;, &quot;mautic.core.dynamicContent.token_name&quot;: &quot;Name&quot;, &quot;mautic.core.dynamicContent.tab&quot;: &quot;Variation %number%&quot;, &quot;mautic.core.dynamicContent.default_content&quot;: &quot;Default Content&quot;, &quot;mautic.core.dynamicContent.alt_content&quot;: &quot;Content&quot;, &quot;mautic.core.tabs.more&quot;: &quot;more&quot;, &quot;mautic.message.queue.status.cancelled&quot;: &quot;Cancelled&quot;, &quot;mautic.message.queue.status.rescheduled&quot;: &quot;Rescheduled&quot;, &quot;mautic.message.queue.status.pending&quot;: &quot;Pending&quot;, &quot;mautic.message.queue.status.Sent&quot;: &quot;Sent&quot;, &quot;chosenChooseOne&quot;: &quot;Choose one...&quot;, &quot;chosenChooseMore&quot;: &quot;Choose one or more...&quot;, &quot;chosenNoResults&quot;: &quot;No matches found&quot;, &quot;pleaseWait&quot;: &quot;Please wait...&quot;, &quot;popupBlockerMessage&quot;: &quot;It seems the browser is blocking popups. Please enable popups for this site and try again.&quot; }; &lt;/script&gt; &lt;script src=&quot;/mail/media/js/libraries.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/media/js/app.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/froala_editor.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/align.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/code_beautifier.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/code_view.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/colors.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/font_family.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/font_size.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/fullscreen.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/image.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/filemanager.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/inline_style.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/line_breaker.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/link.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/lists.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/paragraph_format.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/paragraph_style.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/quick_insert.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/quote.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/table.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/url.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/gatedvideo.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/token.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; &lt;script src=&quot;/mail/app/bundles/CoreBundle/Assets/js/libraries/froala/plugins/dynamic_content.js?vb99a47f2&quot; data-source=&quot;mautic&quot;&gt;&lt;/script&gt; </script>
    <div class="builder-content">
        <input type="hidden" id="builder_url" value="/mail/s/emails/builder/new_1e7a260bc937c96dcc0ac48dfd11792a7e5d9d27">
        <div id="builder-overlay" class="modal-backdrop fade in hide" style="margin: 0px; padding: 0px; border: none; width: 100%; height: 100%;">
            <div style="position: absolute; top:438.5px; left:657px" class="builder-spinner"><i class="fa fa-spinner fa-spin fa-5x"></i></div>
        </div>
        <iframe id="builder-template-content" scrolling="yes" style="margin: 0px; padding: 0px; border: none; width: 100%; height: 100%; overflow: visible;"></iframe>
    </div>
    <div class="builder-panel">
        <div class="builder-panel-top">

            <div class="row">
                <div class="col-xs-12">
                    <button type="button" class="btn btn-primary btn-apply-builder">
                        Apply </button>
                    <button type="button" class="btn btn-primary btn-close-builder" onclick="Mautic.closeBuilder('email');">
                        Close Builder </button>
                </div>
                <!--
    <div class="col-xs-6 text-right">
        <button type="button" class="btn btn-default btn-undo btn-nospin" data-toggle="tooltip" data-placement="left" title="Undo">
            <span><i class="fa fa-undo"></i></span>
        </button>
        <button type="button" class="btn btn-default btn-redo btn-nospin" data-toggle="tooltip" data-placement="left" title="Redo">
            <span><i class="fa fa-repeat"></i></span>
        </button>
    </div>
    -->
            </div>
            <div class="row">
                <div class="col-xs-12 mt-15">
                    <div id="builder-errors" class="alert alert-danger" role="alert" style="display: none;"></div>
                </div>
            </div>

            <div class="code-mode-toolbar hide">
                <button class="btn btn-default btn-nospin" onclick="Mautic.openMediaManager()" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Opens a new window with media manager where you can upload a new item. When an item is selected, the URL is added to the cursor position">
                    <i class="fa fa-photo"></i> Media Manager </button>
                <button class="btn btn-default btn-nospin" onclick="Mautic.formatCode()" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="This option will re-format your code to optimal code style">
                    <i class="fa fa-indent"></i> Format Code </button>
            </div>
        </div>
        <div class="code-editor hide">
            <div id="customHtmlContainer"></div>
            <i class="text-muted">Hint: Press <b>CTRL</b> + <b>SPACE BAR</b> for token drop down</i>
        </div>
        <div class="builder-toolbar ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Slot types</h4>
                </div>
                <div class="panel-body">
                    <div id="slot-type-container" class="col-md-12">
                        <div class="slot-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-slot-type="text">
                            <i class="fa fa-font" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">Text</span>
                            <script type="text/html">
                                <span>Insert text here</span>
                            </script>
                        </div>
                        <div class="slot-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-slot-type="image">
                            <i class="fa fa-image" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">Image</span>
                            <script type="text/html">

                                <img src="http://demo.shoptech.media/mail/themes/blank.png" alt="An image" />
                                <div style="clear:both"></div>
                            </script>
                        </div>
                        <div class="slot-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-slot-type="imagecard">
                            <i class="fa fa-id-card-o" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">Image<br>Card</span>
                            <script type="text/html">

                                <table class="imagecard" align="center" style="background-color: #ddd;">
                                    <tr>
                                        <td class="imagecard-image" align="center"><img width="100%" src="http://demo.shoptech.media/mail/themes/blank-big.png" alt="An image" /></td>
                                    </tr>
                                    <tr>
                                        <td class="imagecard-caption" style="line-height:16px;padding: 5px;background-color: #bbb;font-size:16px;color:#000" align="center">Your image caption goes here. You can change the position of the caption and style in the customize slot tab.</td>
                                    </tr>
                                </table>
                                <div style="clear:both"></div>
                            </script>
                        </div>
                        <div class="slot-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-slot-type="imagecaption">
                            <i class="fa fa-image" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">Image+Caption</span>
                            <script type="text/html">
                                <figure style="text-align:center;">
                                    <img src="http://demo.shoptech.media/mail/themes/blank.png" alt="An image" />
                                    <figcaption style="line-height:16px;padding: 5px;color:#000;font-size:16px;text-align: left;">Your image caption goes here. You can change the position of the caption and style in the customize slot tab.</figcaption>
                                </figure>
                                <div style="clear:both"></div>
                            </script>
                        </div>
                        <div class="slot-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-slot-type="button">
                            <i class="fa fa-external-link" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">Button</span>
                            <script type="text/html">

                                <a href="#" class="button" target="_blank" style="display:inline-block;text-decoration:none;border-color:#4e5d9d;border-width: 10px 20px;border-style:solid; text-decoration: none; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background-color: #4e5d9d; display: inline-block;font-size: 16px; color: #ffffff; ">
    I want this!
</a>
                                <div style="clear:both"></div>
                            </script>
                        </div>
                        <div class="slot-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-slot-type="socialfollow">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">Social<br>Follow</span>
                            <script type="text/html">

                                <div class="socialfollow">
                                    <a id="glink" href="http://plus.google.com" target="_blank"><img src="http://demo.shoptech.media/mail/themes/neopolitan/img/gplus.gif" alt="google+" class="fr-view fr-dii fr-draggable"></a>
                                    <a id="flink" href="http://www.facebook.com" target="_blank"><img src="http://demo.shoptech.media/mail/themes/neopolitan/img/facebook.gif" alt="facebook" class="fr-view fr-dii fr-draggable"></a>
                                    <a id="tlink" href="http://www.twitter.com" target="_blank"><img src="http://demo.shoptech.media/mail/themes/neopolitan/img/twitter.gif" alt="twitter" class="fr-view fr-dii fr-draggable"></a>
                                </div>
                            </script>
                        </div>
                        <div class="slot-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-slot-type="codemode">
                            <i class="fa fa-code" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">Code<br>Mode</span>
                            <script type="text/html">
                                <div class="codemodeHtmlContainer">
                                    <p>Place your content here</p>
                                </div>

                            </script>
                        </div>
                        <div class="slot-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-slot-type="separator">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">Separator</span>
                            <script type="text/html">
                                <hr/>
                            </script>
                        </div>
                        <div class="slot-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-slot-type="dynamicContent">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">Dynamic<br>Content</span>
                            <script type="text/html">

                                <span>__dynamicContent__</span>

                            </script>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <p class="text-muted pt-md text-center"><i>Drag the type to the desired position.</i></p>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Section types</h4>
                </div>
                <div class="panel-body">
                    <div id="section-type-container" class="col-md-12">
                        <div class="section-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-section-type="one-column">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">One Column</span>
                            <script type="text/html">
                                <div data-section-wrapper="1">
                                    <center>
                                        <table data-section="1" style="margin: 0 auto;border-collapse: collapse !important;width: 600px;" class="w320" cellpadding="0" cellspacing="0" width="600">
                                            <tr>
                                                <td data-slot-container="1" valign="top" class="mobile-block" style="padding-left: 5px; padding-right: 5px;">
                                                    <div data-slot="text">
                                                        <p>Lorem ipsum dolor sit amet, alterum definitiones eu est. Eos no scripta voluptatum necessitatibus, ea his case movet. Porro vivendo delicatissimi ea qui, in usu aliquam consulatu conclusionemque. Eu vel mazim periculis consequat, quo fastidii salutandi eu, et sed nibh exerci consequuntur. Cu diam efficiendi eum, pri eu delenit insolens. Usu nihil oporteat an, et stet mucius vix, ex nostro assueverit mel.</p>
                                                        <p>ripidis mea id, ut mel zril tractatos inciderint. Id eam hinc omnes, est eu labore mnesarchum, prima deserunt erroribus no nam. Hinc liber epicurei at vel, ius eirmod conclusionemque an, ad nec lorem possit. Id mollis commune principes qui.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </center>
                                </div>
                            </script>
                        </div>
                        <div class="section-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-section-type="two-column">
                            <i class="fa fa-columns" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">Two Columns</span>
                            <script type="text/html">
                                <div data-section-wrapper="1">
                                    <center>
                                        <table data-section="1" style="margin: 0 auto;border-collapse: collapse !important;width: 600px;" class="w320" border="0" cellpadding="0" cellspacing="0" width="600">
                                            <tr>
                                                <td align="center" valign="top">
                                                    <table align="left" border="0" cellpadding="10" cellspacing="0" width="300" class="mobile-block">
                                                        <tr>
                                                            <td data-slot-container="1" valign="top" style="padding-left: 5px; padding-right: 5px;">
                                                                <div data-slot="text">
                                                                    <p>Lorem ipsum dolor sit amet, alterum definitiones eu est. Eos no scripta voluptatum necessitatibus, ea his case movet. Porro vivendo delicatissimi ea qui, in usu aliquam consulatu conclusionemque. Eu vel mazim periculis consequat, quo fastidii salutandi eu, et sed nibh exerci consequuntur. Cu diam efficiendi eum, pri eu delenit insolens. Usu nihil oporteat an, et stet mucius vix, ex nostro assueverit mel.</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table align="right" border="0" cellpadding="10" cellspacing="0" width="300" class="mobile-block">
                                                        <tr>
                                                            <td data-slot-container="1" valign="top" style="padding-left: 5px; padding-right: 5px;">
                                                                <div data-slot="text">
                                                                    <p>Lorem ipsum dolor sit amet, alterum definitiones eu est. Eos no scripta voluptatum necessitatibus, ea his case movet. Porro vivendo delicatissimi ea qui, in usu aliquam consulatu conclusionemque. Eu vel mazim periculis consequat, quo fastidii salutandi eu, et sed nibh exerci consequuntur. Cu diam efficiendi eum, pri eu delenit insolens. Usu nihil oporteat an, et stet mucius vix, ex nostro assueverit mel.</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </center>
                                </div>
                            </script>
                        </div>
                        <div class="section-type-handle btn btn-default btn-lg btn-nospin ui-draggable ui-draggable-handle" data-section-type="three-column">
                            <i class="fa fa-th" aria-hidden="true"></i>
                            <br>
                            <span class="slot-caption">Three Columns</span>
                            <script type="text/html">
                                <div data-section-wrapper="1">
                                    <center>
                                        <table data-section="1" style="margin: 0 auto;border-collapse: collapse !important;width: 600px;" class="w320" border="0" cellpadding="0" cellspacing="0" width="600">
                                            <tr>
                                                <td align="center" valign="top">
                                                    <table align="left" border="0" cellpadding="10" cellspacing="0" width="200" class="mobile-block">
                                                        <tr>
                                                            <td data-slot-container="1" valign="top" style="padding-left: 5px; padding-right: 5px;">
                                                                <div data-slot="text">
                                                                    <p>Lorem ipsum dolor sit amet, alterum definitiones eu est. Eos no scripta voluptatum necessitatibus, ea his case movet. Porro vivendo delicatissimi ea qui, in usu aliquam consulatu conclusionemque. Eu vel mazim periculis consequat, quo fastidii salutandi eu, et sed nibh exerci consequuntur. Cu diam efficiendi eum, pri eu delenit insolens. Usu nihil oporteat an, et stet mucius vix, ex nostro assueverit mel.</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table align="left" border="0" cellpadding="10" cellspacing="0" width="200" class="mobile-block">
                                                        <tr>
                                                            <td data-slot-container="1" valign="top" style="padding-left: 5px; padding-right: 5px;">
                                                                <div data-slot="text">
                                                                    <p>Lorem ipsum dolor sit amet, alterum definitiones eu est. Eos no scripta voluptatum necessitatibus, ea his case movet. Porro vivendo delicatissimi ea qui, in usu aliquam consulatu conclusionemque. Eu vel mazim periculis consequat, quo fastidii salutandi eu, et sed nibh exerci consequuntur. Cu diam efficiendi eum, pri eu delenit insolens. Usu nihil oporteat an, et stet mucius vix, ex nostro assueverit mel.</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table align="right" border="0" cellpadding="10" cellspacing="0" width="200" class="mobile-block">
                                                        <tr>
                                                            <td data-slot-container="1" valign="top" style="padding-left: 5px; padding-right: 5px;">
                                                                <div data-slot="text">
                                                                    <p>Lorem ipsum dolor sit amet, alterum definitiones eu est. Eos no scripta voluptatum necessitatibus, ea his case movet. Porro vivendo delicatissimi ea qui, in usu aliquam consulatu conclusionemque. Eu vel mazim periculis consequat, quo fastidii salutandi eu, et sed nibh exerci consequuntur. Cu diam efficiendi eum, pri eu delenit insolens. Usu nihil oporteat an, et stet mucius vix, ex nostro assueverit mel.</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </center>
                                </div>
                            </script>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <p class="text-muted pt-md text-center"><i>Drag the type to the desired position.</i></p>
                </div>
            </div>

            <div class="panel panel-default" id="customize-slot-panel">
                <div class="panel-heading">
                    <h4 class="panel-title">Customize Slot</h4>
                </div>
                <div class="panel-body" id="customize-form-container">
                    <div id="slot-form-container" class="col-md-12">
                        <p class="text-muted pt-md text-center">
                            <i>Select the slot to customize</i>
                        </p>
                    </div>
                    <script type="text/html" data-slot-type-form="text">
                        <form novalidate autocomplete="false" data-toggle="ajax" role="form" name="slot_text" method="post" action="">
                            <div id="slot_text">
                                <div class="has-error">
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <textarea id="slot_text_content" name="slot_text[content]" class="form-control editor" data-slot-param="content" autocomplete="false"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_text_padding-top">Padding Top</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_text_padding-top" name="slot_text[padding-top]" class="form-control" data-slot-param="padding-top" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_text_padding-bottom">Padding Bottom</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_text_padding-bottom" name="slot_text[padding-bottom]" class="form-control" data-slot-param="padding-bottom" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="slot_text__token" name="slot_text[_token]" autocomplete="false" value="LF3MUeRicOYrLLI2ayxMYdbNu2kpolpDMKYO18w8LYs" /> </div>
                        </form>
                    </script>
                    <script type="text/html" data-slot-type-form="image">
                        <form novalidate autocomplete="false" data-toggle="ajax" role="form" name="slot_image" method="post" action="">
                            <div id="slot_image">
                                <div class="has-error">
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label">Image Position</label>
                                        <div class="choice-wrapper">
                                            <div class="btn-group btn-block" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_image_align_0" name="slot_image[align]" class="form-control" data-slot-param="align" autocomplete="false" value="0" /> Left </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_image_align_1" name="slot_image[align]" class="form-control" data-slot-param="align" autocomplete="false" value="1" /> Center </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_image_align_2" name="slot_image[align]" class="form-control" data-slot-param="align" autocomplete="false" value="2" /> Right </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_image_padding-top">Padding Top</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_image_padding-top" name="slot_image[padding-top]" class="form-control" data-slot-param="padding-top" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_image_padding-bottom">Padding Bottom</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_image_padding-bottom" name="slot_image[padding-bottom]" class="form-control" data-slot-param="padding-bottom" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="slot_image__token" name="slot_image[_token]" autocomplete="false" value="XMR3Vi3Ps6IJtklN9xQNQpoNJYCfLYPDojK51Voxbq4" /> </div>
                        </form>
                    </script>
                    <script type="text/html" data-slot-type-form="imagecard">
                        <form novalidate autocomplete="false" data-toggle="ajax" role="form" name="slot_imagecard" method="post" action="">
                            <div id="slot_imagecard">
                                <div class="has-error">
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_imagecard_caption">Image Caption</label>
                                        <input type="text" id="slot_imagecard_caption" name="slot_imagecard[caption]" class="form-control" data-slot-param="cardcaption" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label">Image Position</label>
                                        <div class="choice-wrapper">
                                            <div class="btn-group btn-block" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecard_align_0" name="slot_imagecard[align]" class="form-control" data-slot-param="align" autocomplete="false" value="0" /> Left </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecard_align_1" name="slot_imagecard[align]" class="form-control" data-slot-param="align" autocomplete="false" value="1" /> Center </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecard_align_2" name="slot_imagecard[align]" class="form-control" data-slot-param="align" autocomplete="false" value="2" /> Right </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label">Caption Position</label>
                                        <div class="choice-wrapper">
                                            <div class="btn-group btn-block" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecard_text-align_0" name="slot_imagecard[text-align]" class="form-control" data-slot-param="text-align" autocomplete="false" value="0" /> Left </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecard_text-align_1" name="slot_imagecard[text-align]" class="form-control" data-slot-param="text-align" autocomplete="false" value="1" /> Center </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecard_text-align_2" name="slot_imagecard[text-align]" class="form-control" data-slot-param="text-align" autocomplete="false" value="2" /> Right </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_imagecard_background-color">Background Color</label>
                                        <input type="text" id="slot_imagecard_background-color" name="slot_imagecard[background-color]" class="form-control" data-slot-param="background-color" data-toggle="color" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_imagecard_caption-color">Caption background Color</label>
                                        <input type="text" id="slot_imagecard_caption-color" name="slot_imagecard[caption-color]" class="form-control" data-slot-param="caption-color" data-toggle="color" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_imagecard_color">Text color</label>
                                        <input type="text" id="slot_imagecard_color" name="slot_imagecard[color]" class="form-control" data-slot-param="color" data-toggle="color" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_imagecard_padding-top">Padding Top</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_imagecard_padding-top" name="slot_imagecard[padding-top]" class="form-control" data-slot-param="padding-top" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_imagecard_padding-bottom">Padding Bottom</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_imagecard_padding-bottom" name="slot_imagecard[padding-bottom]" class="form-control" data-slot-param="padding-bottom" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="slot_imagecard__token" name="slot_imagecard[_token]" autocomplete="false" value="pRu0GdSI-2s_xtKzG7HB-1q4e4V1iUJWBLioMmWC2PE" /> </div>
                        </form>
                    </script>
                    <script type="text/html" data-slot-type-form="imagecaption">
                        <form novalidate autocomplete="false" data-toggle="ajax" role="form" name="slot_imagecaption" method="post" action="">
                            <div id="slot_imagecaption">
                                <div class="has-error">
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_imagecaption_caption">Image Caption</label>
                                        <input type="text" id="slot_imagecaption_caption" name="slot_imagecaption[caption]" class="form-control" data-slot-param="caption" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label">Image Position</label>
                                        <div class="choice-wrapper">
                                            <div class="btn-group btn-block" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecaption_align_0" name="slot_imagecaption[align]" class="form-control" data-slot-param="align" autocomplete="false" value="0" /> Left </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecaption_align_1" name="slot_imagecaption[align]" class="form-control" data-slot-param="align" autocomplete="false" value="1" /> Center </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecaption_align_2" name="slot_imagecaption[align]" class="form-control" data-slot-param="align" autocomplete="false" value="2" /> Right </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label">Caption Position</label>
                                        <div class="choice-wrapper">
                                            <div class="btn-group btn-block" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecaption_text-align_0" name="slot_imagecaption[text-align]" class="form-control" data-slot-param="text-align" autocomplete="false" value="0" /> Left </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecaption_text-align_1" name="slot_imagecaption[text-align]" class="form-control" data-slot-param="text-align" autocomplete="false" value="1" /> Center </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_imagecaption_text-align_2" name="slot_imagecaption[text-align]" class="form-control" data-slot-param="text-align" autocomplete="false" value="2" /> Right </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_imagecaption_color">Text color</label>
                                        <input type="text" id="slot_imagecaption_color" name="slot_imagecaption[color]" class="form-control" data-slot-param="color" data-toggle="color" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_imagecaption_padding-top">Padding Top</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_imagecaption_padding-top" name="slot_imagecaption[padding-top]" class="form-control" data-slot-param="padding-top" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_imagecaption_padding-bottom">Padding Bottom</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_imagecaption_padding-bottom" name="slot_imagecaption[padding-bottom]" class="form-control" data-slot-param="padding-bottom" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="slot_imagecaption__token" name="slot_imagecaption[_token]" autocomplete="false" value="EHYFmaZV3Nc337uqZpJZPc1NjRq7Lj8eA-1fDrLsuSU" /> </div>
                        </form>
                    </script>
                    <script type="text/html" data-slot-type-form="button">
                        <form novalidate autocomplete="false" data-toggle="ajax" role="form" name="slot_button" method="post" action="">
                            <div id="slot_button">
                                <div class="has-error">
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_button_padding-top">Padding Top</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_button_padding-top" name="slot_button[padding-top]" class="form-control" data-slot-param="padding-top" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_button_padding-bottom">Padding Bottom</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_button_padding-bottom" name="slot_button[padding-bottom]" class="form-control" data-slot-param="padding-bottom" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_button_border-radius">Border Radius</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_button_border-radius" name="slot_button[border-radius]" class="form-control" data-slot-param="border-radius" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_button_link-text">Button Text</label>
                                        <input type="text" id="slot_button_link-text" name="slot_button[link-text]" class="form-control" data-slot-param="link-text" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_button_href">Button Link</label>
                                        <input type="text" id="slot_button_href" name="slot_button[href]" class="form-control" data-slot-param="href" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label">Button Size</label>
                                        <div class="choice-wrapper">
                                            <div class="btn-group btn-block" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_button_button-size_0" name="slot_button[button-size]" class="form-control" data-slot-param="button-size" autocomplete="false" value="0" /> S </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_button_button-size_1" name="slot_button[button-size]" class="form-control" data-slot-param="button-size" autocomplete="false" value="1" /> M </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_button_button-size_2" name="slot_button[button-size]" class="form-control" data-slot-param="button-size" autocomplete="false" value="2" /> L </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label">Button Position</label>
                                        <div class="choice-wrapper">
                                            <div class="btn-group btn-block" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_button_float_0" name="slot_button[float]" class="form-control" data-slot-param="float" autocomplete="false" value="0" /> Left </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_button_float_1" name="slot_button[float]" class="form-control" data-slot-param="float" autocomplete="false" value="1" /> Center </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_button_float_2" name="slot_button[float]" class="form-control" data-slot-param="float" autocomplete="false" value="2" /> Right </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_button_background-color">Background Color</label>
                                        <input type="text" id="slot_button_background-color" name="slot_button[background-color]" class="form-control" data-slot-param="background-color" data-toggle="color" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_button_color">Text color</label>
                                        <input type="text" id="slot_button_color" name="slot_button[color]" class="form-control" data-slot-param="color" data-toggle="color" autocomplete="false" /> </div>
                                </div>
                                <input type="hidden" id="slot_button__token" name="slot_button[_token]" autocomplete="false" value="ynrzSLAnVPCZo_rbpyvhxnm9xTWR-rG3DqJvZ7hWWxE" /> </div>
                        </form>
                    </script>
                    <script type="text/html" data-slot-type-form="socialfollow">
                        <form novalidate autocomplete="false" data-toggle="ajax" role="form" name="slot_socialfollow" method="post" action="">
                            <div id="slot_socialfollow">
                                <div class="has-error">
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_socialfollow_padding-top">Padding Top</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_socialfollow_padding-top" name="slot_socialfollow[padding-top]" class="form-control" data-slot-param="padding-top" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_socialfollow_padding-bottom">Padding Bottom</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_socialfollow_padding-bottom" name="slot_socialfollow[padding-bottom]" class="form-control" data-slot-param="padding-bottom" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_socialfollow_glink">Google+ URL</label>
                                        <input type="text" id="slot_socialfollow_glink" name="slot_socialfollow[glink]" value="http://plus.google.com" class="form-control" data-slot-param="glink" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_socialfollow_flink">Facebook URL</label>
                                        <input type="text" id="slot_socialfollow_flink" name="slot_socialfollow[flink]" value="http://www.facebook.com" class="form-control" data-slot-param="flink" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_socialfollow_tlink">Twitter URL</label>
                                        <input type="text" id="slot_socialfollow_tlink" name="slot_socialfollow[tlink]" value="http://www.twitter.com" class="form-control" data-slot-param="tlink" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label">Image Position</label>
                                        <div class="choice-wrapper">
                                            <div class="btn-group btn-block" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_socialfollow_align_0" name="slot_socialfollow[align]" class="form-control" data-slot-param="align" autocomplete="false" value="0" /> Left </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_socialfollow_align_1" name="slot_socialfollow[align]" class="form-control" data-slot-param="align" autocomplete="false" value="1" /> Center </label>
                                                <label class="btn btn-default">
                                                    <input type="radio" id="slot_socialfollow_align_2" name="slot_socialfollow[align]" class="form-control" data-slot-param="align" autocomplete="false" value="2" /> Right </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="slot_socialfollow__token" name="slot_socialfollow[_token]" autocomplete="false" value="YxhkKSGfGuVGVnhLwk4en-I1cAspmAMAJGVxXVGyMhQ" /> </div>
                        </form>
                    </script>
                    <script type="text/html" data-slot-type-form="codemode">
                        <form novalidate autocomplete="false" data-toggle="ajax" role="form" name="slot_codemode" method="post" action="">
                            <div id="slot_codemode">
                                <div class="has-error">
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <textarea id="slot_codemode_content" name="slot_codemode[content]" class="form-control" data-slot-param="content" autocomplete="false"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" id="slot_codemode__token" name="slot_codemode[_token]" autocomplete="false" value="jBZiYpfM2xx6APG6ytgtoaqdY3ADdNbYq9MRiAjKh3g" /> </div>
                        </form>
                    </script>
                    <script type="text/html" data-slot-type-form="separator">
                        <form novalidate autocomplete="false" data-toggle="ajax" role="form" name="slot_separator" method="post" action="">
                            <div id="slot_separator">
                                <div class="has-error">
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_separator_color">Separator color</label>
                                        <input type="text" id="slot_separator_color" name="slot_separator[color]" class="form-control" data-toggle="color" data-slot-param="separator-color" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_separator_thickness">Separator thickness</label>
                                        <input type="text" id="slot_separator_thickness" name="slot_separator[thickness]" class="form-control" data-slot-param="separator-thickness" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_separator_padding-top">Padding Top</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_separator_padding-top" name="slot_separator[padding-top]" class="form-control" data-slot-param="padding-top" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="slot_separator_padding-bottom">Padding Bottom</label>
                                        <div class="input-group">
                                            <input autocomplete="false" type="text" id="slot_separator_padding-bottom" name="slot_separator[padding-bottom]" class="form-control" data-slot-param="padding-bottom" postaddon_text="px" autocomplete="false" />

                                            <span class="input-group-addon postaddon">
        <span>px</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="slot_separator__token" name="slot_separator[_token]" autocomplete="false" value="Ya1Pkz6y_-Jbods0qAJYW7PtvkN8TP8U3uh-ZtUDypQ" /> </div>
                        </form>
                    </script>
                    <script type="text/html" data-slot-type-form="dynamicContent">
                        <form novalidate autocomplete="false" data-toggle="ajax" role="form" name="slot_dynamiccontent" method="post" action="">
                            <div id="slot_dynamiccontent">
                                <div class="has-error">
                                </div>
                                <input type="hidden" id="slot_dynamiccontent__token" name="slot_dynamiccontent[_token]" autocomplete="false" value="pljkvNIxEJTmiwbEmjkYlL5mtmQdVUgiwMtXkdBHLgg" /> </div>
                        </form>
                    </script>
                </div>
            </div>
            <div class="panel panel-default" id="section">
                <div class="panel-heading">
                    <h4 class="panel-title">Customize Section</h4>
                </div>
                <div class="panel-body" id="customize-form-container">
                    <div id="section-form-container" class="col-md-12">
                        <p class="text-muted pt-md text-center">
                            <i>Select the section to customize</i>
                        </p>
                    </div>
                    <script type="text/html" data-section-form="">
                        <form novalidate autocomplete="false" data-toggle="ajax" role="form" name="builder_section" method="post" action="">
                            <div id="builder_section">
                                <div class="has-error">
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="builder_section_content-background-color">Content Background Color</label>
                                        <input type="text" id="builder_section_content-background-color" name="builder_section[content-background-color]" class="form-control" data-slot-param="background-color" data-toggle="color" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="builder_section_wrapper-background-color">Wrapper Background Color</label>
                                        <input type="text" id="builder_section_wrapper-background-color" name="builder_section[wrapper-background-color]" class="form-control" data-slot-param="background-color" data-toggle="color" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="builder_section_wrapper-background-image">Wrapper Background Image</label>
                                        <input type="url" id="builder_section_wrapper-background-image" name="builder_section[wrapper-background-image]" class="form-control" value="none" autocomplete="false" /> </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="builder_section_wrapper-background-repeat">Wrapper Background Repeat</label>
                                        <div class="choice-wrapper">
                                            <select id="builder_section_wrapper-background-repeat" name="builder_section[wrapper-background-repeat]" class="form-control" autocomplete="false">
                                                <option value=""></option>
                                                <option value="no-repeat">no-repeat</option>
                                                <option value="repeat">repeat</option>
                                                <option value="repeat-x">repeat-x</option>
                                                <option value="repeat-y">repeat-y</option>
                                                <option value="space">space</option>
                                                <option value="round">round</option>
                                                <option value="repeat-space">repeat-space</option>
                                                <option value="space-round">space-round</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12 ">
                                        <label class="control-label" for="builder_section_wrapper-background-size">Wrapper Background Size (width height | &#039;cover&#039; | &#039;contain&#039;)</label>
                                        <input type="text" id="builder_section_wrapper-background-size" name="builder_section[wrapper-background-size]" class="form-control" autocomplete="false" /> </div>
                                </div>
                                <input type="hidden" id="builder_section__token" name="builder_section[_token]" autocomplete="false" value="9-u2WeEodeZOKuuuZ5VIVlvWItCvUKkBNsFS1KKUaf4" /> </div>
                        </form>
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>