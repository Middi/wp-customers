<?php

function mailchimp_post($FNAME, $LNAME, $EMAIL) {
		
    $postData = array(
        "EMAIL" => $EMAIL, 
        "FNAME" => $FNAME,
        "LNAME" => $LNAME
        );
    
        $list_id = esc_attr( get_option('mailchimp_list_id') );
        $api_key = esc_attr( get_option('mailchimp_api') );
        $result = json_decode( rudr_mailchimp_subscriber_status($postData['EMAIL'], 'subscribed', $list_id, $api_key, array('FNAME' => $postData['FNAME'],'LNAME' => $postData['LNAME']) ) );
        // print_r( $result ); 
        if( $result->status == 400 ){
            foreach( $result->errors as $error ) {
                echo '<p>Error: ' . $error->message . '</p>';
            }
        } elseif( $result->status == 'subscribed' ){
            echo 'Thank you, ' . $result->merge_fields->FNAME . '. You have subscribed successfully';
        }
        // $result['id'] - Subscription ID
        // $result['ip_opt'] - Subscriber IP address
        die;
    
    }
    
    function rudr_mailchimp_subscriber_status( $email, $status, $list_id, $api_key, $merge_fields = array('FNAME' => '','LNAME' => '') ){
        $data = array(
            'apikey'        => $api_key,
            'email_address' => $email,
            'status'        => $status,
            'merge_fields'  => $merge_fields
        );
    
        // print_r($data);
        $mch_api = curl_init(); // initialize cURL connection
     
        curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
        curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
        curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
        curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
        curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
        curl_setopt($mch_api, CURLOPT_POST, true);
        curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
     
        $result = curl_exec($mch_api);
        return $result;
    }