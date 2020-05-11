<?php

if (defined('_PS_VERSION_') == false) {
    exit;
}
include_once 'videoUpload.php';

class VideosTab extends Module
{

    protected $error = false;
    public function __construct()
    {
        $this->name = 'videostab';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->need_instance = 0;
        $this->module_key = "408c1f4965d7b98a91127f1810ea8670";
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Video tab');
        $this->description = $this->l('Add additional product tab for videos');
        $this->confirmUninstall = $this->l('Are you sure you want to delete all tab data?');
    }

    public function install()
    {
        if (!parent::install() or !$this->registerHook('productTab')
            or !Configuration::updateValue($this->name . '_mediaplayer', 0)
            or !$this->registerHook('addproduct')
            or !$this->registerHook('updateproduct')
            or !$this->registerHook('deleteproduct')
            or !$this->registerHook('productTabContent') or !$this->registerHook('displayAdminProductsExtra') or !$this->registerHook('displayHeader') or !$this->installDB()) {
            return (false);
        }

        return (true);
    }

    //type 0 = embed code, type 1 = uloaded video
    public function installDb()
    {
        Db::getInstance()->Execute('
    CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'videos_tab_mod` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `id_product` INT NOT NULL,
	  `type` INT NOT NULL,
      `video` TEXT NOT NULL
    ) ENGINE = ' . _MYSQL_ENGINE_ . ' CHARACTER SET utf8 COLLATE utf8_general_ci;');
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName($this->name . '_mediaplayer') ||
            !$this->uninstallDB()) {
            return false;
        }

        return true;
    }

    public function uninstallDb()
    {
        return Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'videos_tab_mod`');

    }

    public function hookProductTab($params)
    {

    
         $id_product = (int) Tools::getValue('id_product');   
       
        $this->smarty->assign(array('videosNb' => $this->getVideosNb($id_product)));
        
        return $this->display(__FILE__, 'tab.tpl');
    }

    public function hookDisplayHeader($params)
    {
        if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'product') {
            return;
        }

        if (Configuration::get($this->name . '_mediaplayer')) {
            $this->context->controller->addCss($this->_path . 'mediaplayer/mediaelementplayer.min.css');
            $this->context->controller->addJS($this->_path . 'mediaplayer/mediaelement-and-player.min.js');
            $this->context->controller->addJS($this->_path . 'videostab.js');
        }
        $this->context->controller->addCss($this->_path . 'videotab.css');
    }

    public function hookProductTabContent($params)
    {

        $id_product = (int) Tools::getValue('id_product');
        $this->smarty->assign('this_path', $this->_path);
        $this->smarty->assign(array('videos' => $this->getVideos($id_product)));
    
    
        return $this->display(__FILE__, 'videostab.tpl');

    }

    public function clearCache()
    {
        $this->_clearCache('tab.tpl');
        $this->_clearCache('videostab.tpl');
    }

    public function hookAddProduct($params)
    {
        $this->clearCache();
    }

    public function hookUpdateProduct($params)
    {
        $this->clearCache();
    }

    public function hookDeleteProduct($params)
    {
        $this->clearCache();
    }

    public function hookDisplayAdminProductsExtra($params)
    {

        $id_product = Tools::getValue('id_product');
        if ($id_product) {

            $this->_displayProductVideos($id_product);
            $this->_displayFormEmbed($id_product);
            $this->_displayFormUpload($id_product);
            $this->clearCache();
            return ($this->_html);
        } else {

            $this->_html = $this->displayError($this->l('You must save this product before adding videos.'));
            return ($this->_html);

        }
    }

    public function getVideos($id_product)
    {
        return Db::getInstance()->ExecuteS('
                SELECT * FROM `' . _DB_PREFIX_ . 'videos_tab_mod`
                WHERE `id_product` = ' . intval($id_product) . '');
    }

    public function getVideosNb($id_product)
    {
        $result = Db::getInstance()->getRow('
		SELECT COUNT(*) AS "videosNb"
		FROM `' . _DB_PREFIX_ . 'videos_tab_mod`
		WHERE `id_product` = ' . intval($id_product));
        if ($result) {
            return intval($result['videosNb']);
        }

        return false;

    }

    private function _displayProductVideos($id_product)
    {
        $videos = $this->getVideos($id_product);

        $this->_html .= '<div class="panel product-tab">
				 <h3 class="card-header">' . $this->l('Product videos') . '</h3>
				<style type="text/css">
				video {
  width: 100%    !important;
  height: auto   !important;
}

.videoWrapper {
	position: relative;
	padding-bottom: 56.25%; /* 16:9 */
	padding-top: 25px;
	height: 0;
}
.videoWrapper iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}
</style>
						<script type="text/javascript">


			$(".deleteVideo").on("click", function(event){
			event.preventDefault();

      			 var url = this.href;
               	 $.ajax({
                        url: url,
                        dataType: "json",
                        type: "POST",
		       			async: false,
		       			cache: false,
                        success: function(response) {
                                $("#videotr_"+response).remove();
								if(!$("#videos_table tbody").has("tr").length){
								$("#videos_table").hide();
								$("#no_videos").fadeIn();
								}
                        }
                });
				});
		</script>

            <div class="panel-body">
              <fieldset>
                 <table class="table" border="0" cellspacing="0" cellpadding="0" id="videos_table" style="' . (sizeof($videos) ? " " : "display: none;") . '">
				 <thead>
				  <tr>
				   <th style="width:40px;">' . $this->l('Id') . '</th>
				   <th style="width:200px;">' . $this->l('Video') . '</th>
				   <th style="width:40px;">' . $this->l('Delete') . '</th>
				  </tr>
				 </thead>
				 <tbody>';
        if (sizeof($videos)) {
            foreach ($videos as $video) {
                $vid = $video['video'];
                $this->_html .= '<tr id="videotr_' . $video['id'] . '">
					 <td>' . $video['id'] . '</td>
                     <td><div class="videoWrapper">' . ($video['type'] == 1 ? '<a href="' . $this->_path . 'uploads/' . $vid . '">' : "") . $vid . ($video['type'] == 1 ? '</a>' : "") . '</div></td>
                     <td>
						<a class="deleteVideo" href="
						'.$this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&action=VideoAjax&ajax=1&step=deleteVideo&videoType=' . $video['type'] . '&id=' . $video['id'] . '"><img src="../img/admin/delete.gif" alt="" title="" style="cursor: pointer" />
					 </td>
					</tr>';
            }}
        $this->_html .= '</tbody>
				</table>
				';

        $this->_html .= '
                <p id="no_videos" style="' . (sizeof($videos) ? "display: none;" : "") . '">';
        $this->_html .= $this->l('No videos found.') . '</p></fieldset>
			</div>
        </div>';

    }

    public function getContent()
    {

        if (Tools::isSubmit('submitModule')) {

            Configuration::updateValue($this->name . '_mediaplayer', (int) (Tools::getValue('mediaplayer')));

            $this->_html .= $this->displayConfirmation($this->l('Settings updated'));
        }

        $this->_html .= $this->renderForm();

        return $this->_html;
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Videotab module configuration'),
                    'icon' => 'icon-link',
                ),

                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Load JS video player'),
                        'name' => 'mediaplayer',
                        'is_bool' => true,
                        'desc' => $this->l('Enable it if you want to play videos uploaded by you in older browsers. Deafult: Disabled becouse of js files needed to load'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled'),
                            ),
                        ),
                    ),
                ),
                'submit' => array(
                    'name' => 'submitModule',
                    'title' => $this->l('Save'),
                ),
            ),
        );

        if (Shop::isFeatureActive()) {
            $fields_form['form']['description'] = $this->l('The modifications will be applied to') . ' ' . (Shop::getContext() == Shop::CONTEXT_SHOP ? $this->l('shop') . ' ' . $this->context->shop->name : $this->l('all shops'));
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'mediaplayer' => Tools::getValue('mediaplayer', Configuration::get($this->name . '_mediaplayer')),
        );
    }

    public function ajaxProcessVideoAjax()
    {	
    
        if (Tools::getValue('step') == 'deleteVideo' && Tools::getValue('id')) {

            if (Tools::getValue('videoType') == 1) {
                $row = Db::getInstance()->getRow('
                SELECT video FROM `' . _DB_PREFIX_ . 'videos_tab_mod`
                WHERE `id` = ' . intval(Tools::getValue('id')) . '');

                if (file_exists('../modules/' . $this->name . '/uploads/' . $row['video'])) {
                    unlink('../modules/' . $this->name . '/uploads/' . $row['video']);
                }

            }

            $query = Db::getInstance()->Execute('DELETE FROM ' . _DB_PREFIX_ . 'videos_tab_mod WHERE `id`=' . (int) (Tools::getValue('id')));
            if ($query) {
                echo Tools::getValue('id');
            }

        }

        if (Tools::getValue('step') == 'submitEmbedVideo' && Tools::getValue('id_product') && Tools::getValue('embedCode')) {

            $query = Db::getInstance()->Execute('
            INSERT INTO `' . _DB_PREFIX_ . 'videos_tab_mod`
		(`id_product`, `type`, `video`) VALUES(
		' . intval(Tools::getValue('id_product')) . ', 0,
		\'' . urldecode(Tools::getValue('embedCode')) . '\')');

            $last_id = Db::getInstance()->Insert_ID();
            $data = array();
            $data['id'] = $last_id;
            $data['video'] = Tools::getValue('embedCode');
            if ($query) {
                print json_encode($data);
            }

        }

        if (Tools::getValue('step') == 'submitUploadVideo' && Tools::getValue('id_product')) {
            $allowedExtensions = array("mp4");
            $sizeLimit = 10485760;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload('../modules/' . $this->name . '/uploads/');
            $filename = $uploader->getName();
            if (isset($result['success'])) {

                $query = Db::getInstance()->Execute('
            INSERT INTO `' . _DB_PREFIX_ . 'videos_tab_mod`
		(`id_product`, `type`, `video`) VALUES(
		' . intval(Tools::getValue('id_product')) . ', 1,
		\'' . $result['filename'] . '\')');

                $last_id = Db::getInstance()->Insert_ID();
                $result['id_video'] = $last_id;

                print json_encode($result);
            } else {
                print json_encode($result);
            }

        }
    }

    private function _displayFormEmbed($id_product)
    {
        global $cookie;

        $this->_html .= '<br/>
		<div class="panel product-tab">
				 <h3 class="card-header">' . $this->l('Add a new video') . '</h3>
								<script type="text/javascript">
			$( "#submitEmbedVideo" ).on( "click", function(event) {
			event.preventDefault();

      			 var url = $(this).attr("href");
				 var embedCode = encodeURI($("#video_embed_code").val().replace("https:", ""));
               	 $.ajax({
                        url: url,
                        dataType: "json",
                        type: "POST",
		       			async: false,
		       			cache: false,
						data: { embedCode: embedCode },
						success: function(response) {
                                $("#video_embed_code").val("");
								$("#videos_table").show();
								var video_id = response[\'id\'];
								var video_code = response[\'video\'];
								$("#no_videos").fadeOut();
				$("#videos_table tbody").append(\'<tr id="videotr_\' + video_id + \'"><td>\' + video_id + \'</td><td><div class="videoWrapper">\' + decodeURI(video_code) + \'</div></td><td><a class="deleteVideo" href="'.$this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&action=VideoAjax&ajax=1&step=deleteVideo&videoType=0&id=\' + video_id + \'"><img src="../img/admin/delete.gif" alt="" title="" style="cursor: pointer" /></a></td></tr>\');

                        }
                });
				});
		</script>


		<fieldset class="panel-body">
			<label for="video_embed_code">' . $this->l('Embed code(youtube, vimeo, etc)') . '</label>
			<div class="form-group">
			<textarea class="form-control" cols="60" rows="15" id="video_embed_code" name="video_embed_code"></textarea>
			</div>
			<div class="margin-form clear">
            <a  href="'.$this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&action=VideoAjax&ajax=1&step=submitEmbedVideo&id_product=' . $id_product . '" name="submitEmbedVideo" id="submitEmbedVideo" class="btn btn-primary"><i class="icon-plus-sign"></i>' . $this->l('Add Video') . '</a></div>
		</fieldset></div>';
    }

    private function _displayFormUpload($id_product)
    {
        global $cookie;

        $this->_html .= '<br/>
<link href="' . $this->_path . 'fileuploader.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="' . $this->_path . 'fileuploader.js"></script>
		    <script type="text/javascript">
			var upbutton = "Upload";

			$(document).ready(function(){

            var uploader = new qq.FileUploader({
                element: document.getElementById("file-uploader-demo1"),
                action: "'.$this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&action=VideoAjax&ajax=1",
				allowedExtensions: [\'mp4\'],
       messages: {
            typeError: "{file} has invalid extension. Only {extensions} are allowed.",
            sizeError: "{file} is too large, maximum file size is {sizeLimit}.",
            minSizeError: "{file} is too small, minimum file size is {minSizeLimit}.",
            emptyError: "{file} is empty, please select files again without it.",
            allowedExtensionsError : "{file} is not allowed.",
            onLeave: "The files are being uploaded, if you leave now the upload will be cancelled."
        },
        showMessage: function (message) {
            alert(message);
        },
                debug: true,
					params: {
					step : "submitUploadVideo",
					id_product: ' . $id_product . ',
				},
				onComplete: function(id, fileName, responseJSON){console.log(responseJSON);

								$("#videos_table").show();
								var video_id = responseJSON[\'id_video\'];
								var video_code = responseJSON[\'filename\'];
								$("#no_videos").fadeOut();
				$("#videos_table tbody").append(\'<tr id="videotr_\' + video_id + \'"><td>\' + video_id + \'</td><td><div class="videoWrapper"><a href="' . $this->_path . 'uploads/\' + video_code + \'">\' + video_code + \'</a></div></td><td>				<a class="deleteVideo" href="'.$this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&action=VideoAjax&ajax=1&step=deleteVideo&videoType=1&id=\' + video_id + \'"><img src="../img/admin/delete.gif" alt="" title="" style="cursor: pointer" /></td></tr>\');



				},
				onSubmit: function(id, fileName){$(".qq-upload-list").fadeIn();},
            });
       });

    </script>
		<div class="panel product-tab">
		<h3 class="card-header">' . $this->l('Upload a new video') . '</h3>
		<fieldset class="panel-body">
				<label for="video_embed_code">' . $this->l('Video file(only .mp4 format)') . '</label>
				<div class="margin-form">
					<div id="file-uploader-demo1">
		<noscript>
			<p>Please enable JavaScript to use file uploader.</p>
			<!-- or put a simple form for upload here -->
		</noscript>
	</div>
				</div>
			</fieldset></div><div class="panel product-tab">
<div class="panel-footer clearfix">
		<button type="submit" name="submitAddproduct" class="btn btn-primary pull-right"><i class="process-icon-save"></i> ' . $this->l('Save') . '</button>
		<button type="submit" name="submitAddproductAndStay" class="btn btn-primary pull-right"><i class="process-icon-save"></i> ' . $this->l('Save and stay') . '</button>
	</div></div>
			';
    }

}
