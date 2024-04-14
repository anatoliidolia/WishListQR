<?php
declare(strict_types=1);

namespace PeachCode\WishListQR\Block\Customer\Wishlist;

use Magento\Framework\View\Element\Template\Context;
use Magento\Wishlist\Block\Customer\Wishlist\Items as ItemsParent;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use chillerlan\QRCode\QRCode;
use Magento\Wishlist\Controller\WishlistProviderInterface;
use PeachCode\WishListQR\Model\Config;

/**
 * Wishlist block customer items
 *
 * @api
 * @since 100.0.2
 */
class Items extends ItemsParent
{

    /**
     * @param Config                    $config
     * @param QRCode                    $code
     * @param UrlInterface              $url
     * @param WishlistProviderInterface $wishlistProvider
     * @param Context                   $context
     * @param array                     $data
     */
    public function __construct(
        private readonly Config $config,
        private readonly QRCode $code,
        private readonly UrlInterface $url,
        private readonly WishlistProviderInterface $wishlistProvider,
        Template\Context $context, array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * Get Wish List Sharing Code
     *
     * @return string
     */
    private function getWishlistQR(): string
    {
        $wishlist = $this->wishlistProvider->getWishlist();

        return $wishlist->getSharingCode();
    }

    /**
     * Get public Wish List URL
     *
     * @return string
     */
    public function getWishListLinkQR(): string
    {
        return $this->url->getUrl('*/shared/index', ['code' => $this->getWishlistQR()]);
    }

    /**
     * Get Wish list QR code
     *
     * @return string
     */
    public function getWishListImage(): string
    {
        if(!$this->config->isEnabled()){
            return '';
        }

        $imageLink = $this->code->render($this->getWishListLinkQR());

        return '<img src='."$imageLink".' alt=\'QR Code\' width=\'300\' height=\'300\'>';
    }
}
