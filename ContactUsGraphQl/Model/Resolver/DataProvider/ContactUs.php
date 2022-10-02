<?php
/**
 * Copyright © Lehan-Max, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Lehan\ContactUsGraphQl\Model\Resolver\DataProvider;

use Magento\Contact\Model\ConfigInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

/**
 * class ContactUs
 *
 * Lehan\ContactUsGraphQl\Model\Resolver\DataProvider
 */
class ContactUs
{
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;
    /**
     * @var MailInterface
     */
    private $mail;

    private $formKey;
    /**
     * @var ConfigInterface
     */
    private $contactsConfig;

    /**
     * ContactUs Constructor.
     *
     * @param ConfigInterface $contactsConfig
     * @param MailInterface $mail
     * @param DataPersistorInterface $dataPersistor
     * @param FormKey $formKey
     */
    public function __construct(
        ConfigInterface $contactsConfig,
        MailInterface $mail,
        DataPersistorInterface $dataPersistor,
        FormKey $formKey
    ) {
        $this->mail = $mail;
        $this->dataPersistor = $dataPersistor;
        $this->formKey = $formKey;
        $this->contactsConfig = $contactsConfig;
    }

    /**
     * ContactUs function to send email
     *
     * @param $fullname
     * @param $email
     * @param $subject
     * @param $message
     * @return array
     * @throws LocalizedException
     */
    public function contactUs($fullname, $email, $subject, $message)
    {
        $status = $this->sendEmail($fullname, $email, $subject, $message);
        if ($status) {
            return [
                'status' => true,
                'message' => __('Thank You for Contacting us.')
            ];
        } else {
            return [
                'status' => false,
                'message' => __('Something went wrong, please contact admin for more details.')
            ];
        }
    }
    /**
     * SendEmail function
     *
     * @param $fullname
     * @param $email
     * @param $telephone
     * @param $description
     * @return bool
     * @throws LocalizedException
     */
    private function sendEmail($fullname, $email, $telephone, $description)
    {
        $form_data = [];
        $form_data['name']      =   $fullname;
        $form_data['email']     =   $email;
        $form_data['telephone'] =   $telephone;
        $form_data['comment']   =   $description;
        $form_data['hideit']    =   "";
        $form_data['form_key']  =   $this->getFormKey();

        try {
            $this->mail->send($email, ['data' => new DataObject($form_data)]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    /**
     * get form key
     *
     * @return string
     * @throws LocalizedException
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}
