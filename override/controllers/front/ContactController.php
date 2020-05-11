<?php

/**
 * Class ContactControllerCore
 *
 * @since 1.0.0
 */
class ContactController extends ContactControllerCore
{
    public function isRussian($text) {
        return preg_match('/[А-Яа-яЁё]/u', $text);
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitMessage')) {
            $saveContactKey = $this->context->cookie->contactFormKey;
            $url = Tools::getValue('url');
            $message = Tools::getValue('message'); // Html entities is not usefull, iscleanHtml check there is no bad html tags.

            if ($url === false || !empty($url) || $saveContactKey != (Tools::getValue('contactKey')) || $this->isRussian($message) ) {
                $this->errors[] = Tools::displayError('An error occurred while sending the message.');

                return false;
            }
        }

        parent::postProcess();
    }

    public function initContent()
    {
        $contactKey = md5(uniqid(microtime(), true));
        $this->context->cookie->__set('contactFormKey', $contactKey);

        $this->context->smarty->assign(array(
            'contactKey' => $contactKey
        ));

        parent::initContent();
    }
}
