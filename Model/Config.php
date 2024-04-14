<?php
declare(strict_types=1);

namespace PeachCode\WishListQR\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public const IS_MODULE_ENABLED = 'wishlist/wishlist_link/use_qr_for_customer';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check is module enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::IS_MODULE_ENABLED,
            ScopeInterface::SCOPE_STORE,
        );
    }
}
