<?php 
if(!isset($_GET['result'],$_GET['token'],$_GET['PayerID'])){
   die('Payment Failed');
}
if($_GET['result'] === 'success'){
   $PayerID = $_GET['PayerID'];
   $token = $_GET['token'];

$ch = curl_init( 'https://api-3t.sandbox.paypal.com/nvp' );

$params = array(
   'method'                         => 'DoExpressCheckoutPayment',
   'PAYMENTREQUEST_0_AMT'           => '1.00',
   'PAYMENTREQUEST_0_CURRENCYCODE'  => 'USD',
   'LANDINGPAGE'                    => 'Billing',
   'SOLUTIONTYPE'                   => 'Sole',
   'returnUrl'                      => 'http://localhost/paypal/payment-request.php?result=success',
   'cancelUrl'                      => 'http://localhost/paypal/payment-request.php?result=cancelled',
   'version'                        => '106.0',
   'user'                           => 'saptadeep.bhowmik-facilitator_api1.digitalavenues.com',
   'pwd'                            => 'LPXSC5VCBYJN6Y5N',
   'signature'                      => 'AFcWxV21C7fd0v3bYYYRCpSSRl31A9XEfPZ44HULcf1AO3JmLwuxWMQF',
   'TOKEN'                          => $token,
   'PAYERID'                        => $PayerID,
   'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale'
);

curl_setopt($ch, CURLOPT_POST, true );
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

echo 'Success : '.$response = curl_exec( $ch );
echo 'Error : '.$err = curl_error($ch);

}
?>