<?php
namespace Getwhisky\Views;

use Getwhisky\Controllers\AddressController;
use Getwhisky\Controllers\CheckoutController;

class CheckoutView
{
    // CheckoutController instance
    private CheckoutController $checkout;


    public function __construct($checkout)
    {
        $this->checkout = $checkout;
    }


    public function deliveryPage()
    {
        $html = "";
        $title = "Checkout | Getwhisky";
        $script = "/assets/js/checkout-delivery-page.js";
        $style = "/assets/style/checkout-pages.css";

        $cart = $this->checkout->getCart();
        $userAddresses = $this->checkout->getUser()->getAddresses();

        $html.=SharedView::backwardsNavigation(array(
            ['url' => '/basket', 'pageName' => 'My Basket'],
            ['url' => '', 'pageName' => "Checkout"]
        ));

        $html.="<div class='delivery-root'>";
            
            // User addresses
            $html.="<div class='address-container'>";
                $html.="<div class='content'>";
                    // header
                    $html.="<div class='header'>";
                        $html.="<h5>Choose delivery address</h5>";
                    $html.="</div>";
                    // Delivery info
                    $html.="<div class='info'>";
                        $html.="<p><b>Please Note:</b> We are currently only able to deliver to addresses within the UK. We apologize for any inconvenience.";
                    $html.="</div>";
                    $html.="<div class='info'>";
                        $html.="<p>Free delivery on orders over £".constant("free_delivery_threshold").". For all other orders a flat delivery fee of £".constant("delivery_cost")." will be applied during checkout.</p>";
                    $html.="</div>";


                    // User addresses
                    if (!empty($userAddresses)) {
                        $html.="<div class='address-items'>";
                        foreach($userAddresses as $address) {
                            $html.=$address->getView()->deliveryItemView();
                        }          
                        $html.="</div>";
                    } else {
                        $html.="<p class='mt-4 text-muted'>You have no saved addresses! click the button below to create an address.</p>";
                    }
        
                    // Options
                    $html.="<div class='options'>";
                        // Add new address button
                        $html.="<button class='link-button' id='add-address-show'>Add new address</button>";
                        // Address id form
                        $html.="<form id='address-form' method='POST' action='/checkout/create-checkout-session'>";
                            $html.="<input type='hidden' value='' name='address-id' id='selected-address'>";
                        $html.="</form>";

                    $html.="</div>";

                $html.="</div>";
            $html.="</div>";



            // Cart summary
            $html.="<div class='cart-summary-container'>";
                $html.="<div class='content'>";
                    // Header
                    $html.="<div class='header'>";
                        $html.="<h5>Basket Summary</h5>";
                    $html.="</div>";

                    // Basket items - summary
                    $html.="<div class='basket-items'>";
                    foreach($cart->getItems() as $item) {
                        // basket item
                        $html.="<div class='item'>";
                            $html.="<div class='image-container'>";
                                $html.="<img src={$item->getProduct()->getImage()}>";
                            $html.="</div>";

                            $html.="<div class='details-container'>";
                                $html.="<p>{$item->getProduct()->getName()}</p>";
                                $html.="<p>Qty: {$item->getQuantity()}</p>";
                                $html.="<p>£{$item->getItemPrice()}</p>";
                            $html.="</div>";
                        $html.="</div>";
                    }
                        $html.="<div class='summary'>";
                            $html.="<p>Total: <span class='total'>£{$cart->getCartTotal()}</span></p>";
                        $html.="</div>";
                    $html.="</div>";

                $html.="</div>";
            $html.="</div>";

        $html.="</div>";

        $html.="<div class='add-address-root'>";
            $html.=(new AddressController())->getView()->createAddressForm();
        $html.="</div>";

        //$html.=$this->checkout->getUser()->getAddresses()[0]->getView()->createAddressForm();
        return [
            'html' => $html,
            'title' => $title,
            'script' => $script,
            'style' => $style
        ];
    }

    public function orderConfirmationPage()
    {
        $html = "";
        $title = "Thank you!";
        $style = "/assets/style/order-confirmation-page.css";
        $script = "";

        $order = $this->checkout->getOrder();
        $user = $this->checkout->getUser();

        $html.="<div class='order-confirmation-root'>";

            // Left
            $html.="<div class='left'>";
                $html.="<div class='header'>";
                    $html.="<h2>Thank you, {$user->getFirstName()}!</h2>";
                    $html.="<p>Your order has been placed.</p>";
                $html.="</div>";

                $html.="<div class='shipping'>";
                    $html.="<h5>Delivery address</h5>";
                    $html.="<p>{$order->getDeliveryRecipient()}</p>";
                    $html.="<p>{$order->getDeliveryLine1()}</p>";
                    $html.="<p>{$order->getDeliveryLine2()}</p>";
                    $html.="<p>{$order->getDeliveryCity()}, {$order->getDeliveryPostcode()}</p>";
                    $html.="<p>{$order->getDeliveryCounty()}</p>";
                $html.="</div>";

                $html.="<div class='info'>";
                    $html.="<p>A confirmation email has been sent to {$user->getEmail()}<br><i>(Implementation pending)</i></p>";
                    $html.="<p>Have any questions about your order?<br>Pop us an email at <a href='mailto:".constant("support_email")."'>".constant("support_email")."</a></p>";
                $html.="</div>";
            $html.="</div>";
            
            $html.="<div class='right'>";
                // header
                $html.="<div class='header'>";
                    $html.="<h5>Items to be delivered</h5>";
                $html.="</div>";
                // Order items
                $html.="<div class='order-items'>";
                    foreach($order->getItems() as $item) {
                        // Item
                        $html.="<div class='item'>";
                            // Left details
                            $html.="<div class='details-left'>";
                                // Image
                                $html.="<img src='{$item['product_image']}'>";
                                // Details
                                $html.="<div class='center-details'>";
                                    $html.="<p style='font-weight: 500;'>{$item['product_name']}</p>";
                                    $html.="<p class='qty'>Quantity: {$item['quantity']}</p>";
                                    $html.="<p>";
                                $html.="</div>";
                            $html.="</div>";
                            // Price
                            $html.="<p style='font-weight: 500;'>£{$item['price_paid']}</p>";
                        $html.="</div>";
                    }
                $html.="</div>";

                $html.="<div class='order-summary'>";
                    $html.="<div class='detail-item'><p>Shipping</p><p>£{$order->getDeliveryCost()}</p></div>";
                    if ($order->getDiscountTotal() != 0) $html.="<div class='detail-item'><p>Discounts</p><p>£{$order->getDiscountTotal()}</p></div>";
                    $finalTotal = number_format($order->getTotal() + $order->getDeliveryCost(), 2, ".", "");
                    $html.="<div class='detail-item'><p>Total</p><p>£{$finalTotal}</p></div>";
                $html.="</div>";

            $html.="</div>";

        $html.="</div>";
        return [
            'html' => $html,
            'title' => $title,
            'style' => $style,
            'script' => $script
        ];
    }
}
?>