<?php
$ch = curl_init( 'https://api-3t.sandbox.paypal.com/nvp' );

$params = array(
   'method'                         => 'SetExpressCheckout',
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
   'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale'
);

curl_setopt($ch, CURLOPT_POST, true );
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

echo $response = curl_exec( $ch );
$err = curl_error($ch);

$nvp = array();
 
if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
    foreach ($matches['name'] as $offset => $name) {
        $nvp[$name] = urldecode($matches['value'][$offset]);
    }
}

if (isset($nvp['ACK']) && $nvp['ACK'] == 'Success') {
    $query = array(
        'cmd'    => '_express-checkout',
        'token'  => $nvp['TOKEN']
    );
    $redirectURL = sprintf('https://www.sandbox.paypal.com/cgi-bin/webscr?%s', http_build_query($query));
    header('Location: ' . $redirectURL);
} else {
    //Opz, alguma coisa deu errada.
    //Verifique os logs de erro para depuração.
} 

// Validate transaction

// Redirect the buyer to PayPal:

// $ch = curl_init( 'https://api-3t.sandbox.paypal.com/nvp' );
// $params = array(
//    'method'                         => 'SetExpressCheckout',
//    'PAYMENTREQUEST_0_AMT'           => '1.00',
//    'PAYMENTREQUEST_0_CURRENCYCODE'  => 'USD',
//    'returnUrl'                      => 'http://my.domain.here/payment-request.php?result=success',
//    'cancelUrl'                      => 'http://my.domain.here/payment-request.php?result=cancelled',
//    'version'                        => '106.0',
//    'user'                           => 'saptadeep.bhowmik-facilitator_api1.digitalavenues.com',
//    'pwd'                            => 'LPXSC5VCBYJN6Y5N',
//    'signature'                      => 'AFcWxV21C7fd0v3bYYYRCpSSRl31A9XEfPZ44HULcf1AO3JmLwuxWMQF',
//    'LANDINGPAGE'                    => 'Billing',
//    'SOLUTIONTYPE'                   => 'Sole',
//    //'IDENTITYACCESSTOKEN'            => $accessToken,
//    'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale'
// );

// curl_setopt($ch, CURLOPT_POST, true );
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

// $response = curl_exec( $ch );
echo '<pre>';
print_r($response);
print_r($err);
echo '</pre>';
?>