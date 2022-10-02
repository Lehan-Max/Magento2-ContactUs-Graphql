<?php
/**
 * Copyright © Lehan-Max, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lehan\ContactUsGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * class ContactUs
 *
 * Lehan\ContactUsGraphQl\Model\Resolver
 */
class ContactUs implements ResolverInterface
{
    /**
     * @var DataProvider\ContactUs
     */
    private $contactusDataProvider;

    /**
     * ContactUs constructor.
     *
     * @param DataProvider\ContactUs $contactusDataProvider
     */
    public function __construct(
        DataProvider\ContactUs $contactusDataProvider
    ) {
        $this->contactusDataProvider = $contactusDataProvider;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $fullName = $args['input']['fullname'];
        $email = $args['input']['email'];
        $telephone = $args['input']['telephone'];
        $description = $args['input']['description'];

        $message = $this->contactusDataProvider->contactUs(
            $fullName,
            $email,
            $telephone,
            $description
        );
        return $message;
    }
}
