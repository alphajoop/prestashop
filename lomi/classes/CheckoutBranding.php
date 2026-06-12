<?php
/**
 * Checkout branding assets (pay-with-lomi image + payment method icons).
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

class LomiCheckoutBranding
{
    private const ICON_SLUGS = array('wave', 'mtn', 'apple-pay', 'google-pay', 'spi');
    private const WIDE_ICON_SLUGS = array('apple-pay', 'google-pay');

    /** @var Lomi */
    private $module;

    public function __construct(Lomi $module)
    {
        $this->module = $module;
    }

    /**
     * @return string
     */
    public function getPayWithImageUrl()
    {
        return $this->resolveAssetUrl('pay-with-lomi.webp');
    }

    /**
     * @return array<int, array{url: string, wide: bool}>
     */
    public function getPaymentIcons()
    {
        $icons = array();

        foreach (self::ICON_SLUGS as $slug) {
            $url = $this->resolveAssetUrl($slug . '.webp');
            if ($url === '') {
                continue;
            }

            $icons[] = array(
                'url' => $url,
                'wide' => in_array($slug, self::WIDE_ICON_SLUGS, true),
            );
        }

        return $icons;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    private function resolveAssetUrl($filename)
    {
        $path = _PS_MODULE_DIR_ . $this->module->name . '/views/img/' . $filename;
        if (!is_file($path)) {
            return '';
        }

        return $this->module->getPathUri() . 'views/img/' . $filename;
    }
}
