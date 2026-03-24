<?php
/**
 * Data
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    support@onecde.gr
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
    /** DEFAULT XML PATH */
    const XML_PATH = 'onecode_api/';

    /** API XML PATH */
    const API_XML_PATH = self::XML_PATH . 'general/';

    const CONFIG_ACTIVE = 'active';

    const CONFIG_CLEAN_UP_DAYS = 'cleanup_days';

    const CONFIG_ACCEPT_ALL_HTTP_METHODS = 'accept_all_http_methods';

    const CONFIG_SELECTED_HTTP_METHODS = 'selected_http_methods';

    const CONFIG_SELECTED_USER_TO_TRACK = 'user_to_track';

    const CONFIG_LOG_REST = 'log_rest';

    const CONFIG_LOG_GRAPHQL = 'log_graphql';

    const CONFIG_LOG_SOAP = 'log_soap';

    /**
     * @param string      $code
     * @param int|null    $storeId
     *
     * @return mixed
     */
    public function getApiConfig(string $code, ?int $storeId = null)
    {
        return $this->getConfigValue(self::API_XML_PATH . $code, $storeId);
    }

    /**
     * @param string   $field
     * @param int|null $storeId
     *
     * @return mixed
     */
    private function getConfigValue(string $field, ?int $storeId = null)
    {
        return $this->scopeConfig->getValue($field, self::SCOPE_STORE, $storeId);
    }
}
