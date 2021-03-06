<?php
$curl = curl_init();
 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
    'USER' => 'saptadeep.bhowmik-facilitator_api1.digitalavenues.com',
    'PWD' => 'LPXSC5VCBYJN6Y5N',
    'SIGNATURE' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31A9XEfPZ44HULcf1AO3JmLwuxWMQF',
 
    'METHOD' => 'SetExpressCheckout',
    'VERSION' => '106.0',
    'LANDINGPAGE' => 'Billing',
    'SOLUTIONTYPE' => 'Sole',
 
    'PAYMENTREQUEST_0_AMT' => 100,
    'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
    'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
    'PAYMENTREQUEST_0_ITEMAMT' => 100,
 
    'L_PAYMENTREQUEST_0_NAME0' => 'Exemplo',
    'L_PAYMENTREQUEST_0_DESC0' => 'Assinatura de exemplo',
    'L_PAYMENTREQUEST_0_QTY0' => 1,
    'L_PAYMENTREQUEST_0_AMT0' => 100,
    'L_BILLINGAGREEMENTDESCRIPTION0' => 'Exemplo',
 
    'CANCELURL' => 'http://localhost/paypal_express_checkout_nvp/cancel.php',
    'RETURNURL' => 'http://localhost/paypal_express_checkout_nvp/sucess.php'
)));
 
$response =    curl_exec($curl);
 
curl_close($curl);
 
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
///////////////
?>