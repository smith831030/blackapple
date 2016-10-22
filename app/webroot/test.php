<?php
getAccessToken( ) ;
 
function  getAccessToken( ) {
       
        if ( $_GET [ 'code' ] )   {
                $code   =   $_GET [ 'code' ] ;
                $url   =   "https://api.instagram.com/oauth/access_token" ;
                $access_token_parameters   =  array(
                                'client_id'                                 =>           '1bdf66bc17d648b3888f15a966aecb14' ,
                                'client_secret'                         =>           '34484255bb654cbd91928e3b9b333ac8' ,
                                'grant_type'                               =>           'authorization_code' ,
                                'redirect_uri'                           =>           'http://gamichicken.com.au/test.php' ,
                                'code'                                           =>           $code
                ) ;
                $curl   =  curl_init( $url ) ;         // we init curl by passing the url
               curl_setopt( $curl ,CURLOPT_POST,true) ;       // to send a POST request
               curl_setopt( $curl ,CURLOPT_POSTFIELDS, $access_token_parameters ) ;       // indicate the data to send
               curl_setopt( $curl ,  CURLOPT_RETURNTRANSFER,  1) ;       // to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
               curl_setopt( $curl ,  CURLOPT_SSL_VERIFYPEER,  false) ;       // to stop cURL from verifying the peer's certificate.
                $result   =  curl_exec( $curl ) ;       // to perform the curl session
               curl_close( $curl ) ;       // to close the curl session
       
                $arr   =  json_decode( $result ,true) ;
                echo   "access_Token: " . $arr [ 'access_token' ] ;   // display the access_token
                echo   "<br />" ;      
                echo   "user_name : " . $arr [ 'user' ] [ 'username' ] ;       // display the username
        }
}
 
?>