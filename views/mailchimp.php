<?php

function mailchimp_post($FNAME, $LNAME, $EMAIL, $ID) {
    
        $list_id = esc_attr( get_option('mailchimp_list_id') );
        $api_key = esc_attr( get_option('mailchimp_api') );
        $result = json_decode( rudr_mailchimp_subscriber_status($EMAIL, 'subscribed', $list_id, $api_key, array('FNAME' => $FNAME,'LNAME' => $LNAME, 'RMB_ID' => $ID) ) );
        if( $result->status == 400 ){
            echo json_encode(['status' => 0, 'message' => 'Something went wrong.']);
        }
        elseif( $result->status == 'subscribed' ){
            echo json_encode(['status' => 1, 'message' => 'You are now signed up, Check your email.']);
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