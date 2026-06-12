<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Browser returned to checkout without completing hosted payment (back button / bfcache).
 */
class LomiAbandonModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $idCart = (int) Tools::getValue('id_cart');
        $key = (string) Tools::getValue('key');
        $wantsJson = strpos((string) $_SERVER['HTTP_ACCEPT'], 'application/json') !== false
            || (int) Tools::getValue('ajax') === 1;

        $abandoned = false;

        if ($idCart > 0 && $key !== '') {
            $cart = new Cart($idCart);
            $customer = new Customer((int) $cart->id_customer);
            if (Validate::isLoadedObject($cart) && Validate::isLoadedObject($customer) && $customer->secure_key === $key) {
                /** @var Lomi $module */
                $module = $this->module;
                $abandoned = $module->abandonHostedCheckout((int) $cart->id);
            }
        }

        if ($wantsJson) {
            header('Content-Type: application/json');
            echo json_encode(array(
                'success' => true,
                'abandoned' => $abandoned,
            ));
            exit;
        }

        if ($abandoned) {
            $this->context->cookie->__set('lomi_abandon_notice', '1');
        }

        Tools::redirect($this->context->link->getPageLink('order', true, null, array('step' => 3)));
    }
}
