<?php
/**
 * Data
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Helper;


use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Onecode\WebApiLogger\Helper
 */
class Data extends AbstractHelper implements ScopeInterface
{
    /**
     * DEFAULT XML PATH
     */
    const XML_PATH = "onecode_api/";

    /**
     * API XML PATH
     */
    const API_XML_PATH = self::XML_PATH . "general/";

    /**
     * CONFIG_ACTIVE
     */
    const CONFIG_ACTIVE = 'active';

    /**
     * CONFIG_CLEAN_UP_DAYS
     */
    const CONFIG_CLEAN_UP_DAYS = 'cleanup_days';

    /**
     * CONFIG_ACCEPT_ALL_HTTP_METHODS
     */
    const CONFIG_ACCEPT_ALL_HTTP_METHODS = 'accept_all_http_methods';

    /**
     * CONFIG_SELECTED_HTTP_METHOD
     */
    const CONFIG_SELECTED_HTTP_METHODS = 'selected_http_methods';

    const CONFIG_SELECTED_USER_TO_TRACK = 'user_to_track';

    /**
     * @param      $code
     * @param null $storeId
     *
     * @return mixed
     */
    public function getApiConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::API_XML_PATH . $code, $storeId);
    }

    /**
     * @param      $field
     * @param null $storeId
     *
     * @return mixed
     */
    private function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, self::SCOPE_STORE, $storeId
        );
    }
}
