   <?php
            date_default_timezone_set('US/Eastern');
            //update user records
          
            
            $sqlUpdate1="select * from embedded_capacity_status where id=1";
            $resultUpdate2=mysqli_query($con,$sqlUpdate1);
            $row=mysqli_fetch_array($resultUpdate2);
            
            $offtimes=$row['offtime'];
            $status=$row['status'];
            $d1=explode(":",$offtimes)[0];
            $num = $d1;
            $str_length = 2;
            // hardcoded left padding if number < $str_length
            $str = substr("0{$num}", -$str_length);
            $offtime=$str.":". explode(":",$offtimes)[1];
            
            
            $ontimes=$row['ontime'];
            $d2=explode(":",$ontimes)[0];
            $num2 = $d2;
            $str_length2 = 2;
            // hardcoded left padding if number < $str_length
            $str2 = substr("0{$d2}", -$str_length2);
            $ontime=$str2.":". explode(":",$ontimes)[1];

            $currentDateTime=date("h:i A");

  
           //$ontime='05:20  PM';
           //$ontime='06:43 PM';
           $crtime_10prev = strtotime(date("h:i A"));
           $crtime_10pre1 = date("h:i A", strtotime('-5 minutes', $crtime_10prev));
           $crtime_10after = date("h:i A", strtotime('+5 minutes', $crtime_10prev));
        
        if($status > 0){
       
          if($offtime >= $crtime_10pre1 && $offtime <= $crtime_10after){
         /*
		 *Stop Embed capacity
		 */
                    $TokenData = getAADToken();
                    $token = json_decode($TokenData)->access_token;
                    $server = 'https://management.azure.com/subscriptions/{{Put-here-subscriptions-id}}/resourceGroups/edgedataportals/providers/Microsoft.PowerBIDedicated/capacities/edgedataportalsembedded/suspend?api-version=2017-10-01'; // INSERT FULL URL OF curltest_data.php 
                    $curlHandle = curl_init(); 
                    $str = json_encode(array()); 
                    $len = mb_strlen($str); 
                    $headers = array('Content-type: application/json', 
                      'Content-length: ' . $len,
                      'authorization: Bearer '.$token,
                      'cache-control: no-cache'
                      ); // WHEN OMITTING THIS CONTENT-LENGHT HEADER, IT WORKS FINE 
                    curl_setopt($curlHandle,CURLOPT_HTTPGET,FALSE);
                    curl_setopt($curlHandle,CURLOPT_POST,TRUE);
                    curl_setopt($curlHandle,CURLOPT_POSTFIELDS,$str); 
                    curl_setopt($curlHandle,CURLOPT_HEADER,TRUE); 
                    curl_setopt($curlHandle,CURLOPT_NOBODY,FALSE); 
                    curl_setopt($curlHandle,CURLOPT_TIMEOUT,5); 
                    curl_setopt($curlHandle,CURLOPT_USERAGENT,'CURL'); 
                    curl_setopt($curlHandle,CURLOPT_URL,$server); 
                    curl_setopt($curlHandle,CURLOPT_VERBOSE,TRUE); 
                    curl_setopt($curlHandle,CURLOPT_SSL_VERIFYPEER,0); 
                    curl_setopt($curlHandle,CURLOPT_SSL_VERIFYHOST,0); 
                    curl_setopt($curlHandle,CURLOPT_RETURNTRANSFER,TRUE); 
                    curl_setopt($curlHandle,CURLOPT_HTTPHEADER,$headers); 
                    $responseContentsStr= curl_exec($curlHandle); 
                    $responseContentsArr= explode("\r\n\r\n", $responseContentsStr); 
                    // echo 'DATA: ' . $str; 
                    // echo '<br />DATA LEN: ' . $len; 
                    // echo '<br />HEADERS: '; 
                    // print_r($headers); 
                    // echo '<br />ERROR: ' . curl_error($curlHandle); 
                    // echo '<br />'; 
                    $tmp = curl_getinfo($curlHandle); 
                    //print_r($tmp); 
                    curl_close($curlHandle); 
                    //echo '<br />RESPONSE:<br />'; 
                    $sucessArr=$responseContentsArr[0];
                    $sucess=explode(" ",$sucessArr);
                    $errorResponse= $responseContentsArr[1];
                    $errorResp=json_decode($errorResponse);
                    $errorMsg=$errorResp->error;
                    //echo $errorMsg->message;
                    #print_r($responseContentsArr);
                    if ($sucess[1]==400){
                      echo json_encode(array("message"=>"error","messageResponse"=>"Service is already stoped: Service is not ready to be updated","status"=>1,"code"=>400));
                    } else {
                       $sql = mysqli_query($con,"update embedded_capacity_status set status='0' where id='1'");
                       echo json_encode(array("message"=>"success","messageResponse"=>"Service has been stoped successfully","status"=>1,"code"=>200));
                    }
            }
            
         
       
            // $ontime='15';
            // $crtime_10prev='10';
            // $crtime_10after='30';
            
         /*
		 *Start Embed capacity
		 */
        $crtime_10pre1;
        $crtime_10after;
            if($ontime >= $crtime_10pre1 && $ontime <= $crtime_10after){
					
                    $TokenData = getAADToken();
                    $token = json_decode($TokenData)->access_token;
                    $server = 'https://management.azure.com/subscriptions/{{Put-here-subscriptions-id}}/resourceGroups/edgedataportals/providers/Microsoft.PowerBIDedicated/capacities/edgedataportalsembedded/resume?api-version=2017-10-01'; // INSERT FULL URL OF curltest_data.php 
                    $curlHandle = curl_init(); 
                    $str = json_encode(array()); 
                    $len = mb_strlen($str); 
                    $headers = array('Content-type: application/json', 
                      'Content-length: ' . $len,
                      'authorization: Bearer '.$token,
                      'cache-control: no-cache'
                      ); // WHEN OMITTING THIS CONTENT-LENGHT HEADER, IT WORKS FINE 
                    curl_setopt($curlHandle,CURLOPT_HTTPGET,FALSE);
                    curl_setopt($curlHandle,CURLOPT_POST,TRUE);
                    curl_setopt($curlHandle,CURLOPT_POSTFIELDS,$str); 
                    curl_setopt($curlHandle,CURLOPT_HEADER,TRUE); 
                    curl_setopt($curlHandle,CURLOPT_NOBODY,FALSE); 
                    curl_setopt($curlHandle,CURLOPT_TIMEOUT,5); 
                    curl_setopt($curlHandle,CURLOPT_USERAGENT,'CURL'); 
                    curl_setopt($curlHandle,CURLOPT_URL,$server); 
                    curl_setopt($curlHandle,CURLOPT_VERBOSE,TRUE); 
                    curl_setopt($curlHandle,CURLOPT_SSL_VERIFYPEER,0); 
                    curl_setopt($curlHandle,CURLOPT_SSL_VERIFYHOST,0); 
                    curl_setopt($curlHandle,CURLOPT_RETURNTRANSFER,TRUE); 
                    curl_setopt($curlHandle,CURLOPT_HTTPHEADER,$headers); 
                    $responseContentsStr= curl_exec($curlHandle); 
                    $responseContentsArr= explode("\r\n\r\n", $responseContentsStr); 
                    // echo 'DATA: ' . $str; 
                    // echo '<br />DATA LEN: ' . $len; 
                    // echo '<br />HEADERS: '; 
                    // print_r($headers); 
                    // echo '<br />ERROR: ' . curl_error($curlHandle); 
                    // echo '<br />'; 
                    $tmp = curl_getinfo($curlHandle); 
                    //print_r($tmp); 
                    curl_close($curlHandle); 
                    //echo '<br />RESPONSE:<br />'; 
                    $sucessArr=$responseContentsArr[0];
                    $sucess=explode(" ",$sucessArr);
                    $errorResponse= $responseContentsArr[1];
                    $errorResp=json_decode($errorResponse);
                    $errorMsg=$errorResp->error;
                    //echo $errorMsg->message;
                    #print_r($responseContentsArr);
                    if ($sucess[1]==400){
                       echo json_encode(array("message"=>"error","messageResponse"=>"Service is already resumed: Service is not ready to be updated","status"=>1,"code"=>400));
                    } else {
                       $sql = mysqli_query($con,"update embedded_capacity_status set status='1' where id='1'");
                       echo json_encode(array("message"=>"success","messageResponse"=>"Service has been resume successfully","status"=>1,"code"=>200));
                    }
            }
  }
 

function getAADToken(){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://login.microsoftonline.com/{{Put-directory-id-hare}}/oauth2/token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>  "grant_type=client_credentials&client_id={{put here client_id}}&client_secret={{put here client_secret}}&resource=https%3A%2F%2Fmanagement.azure.com",
CURLOPT_HTTPHEADER => array(
    CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache",
      "content-type: application/x-www-form-urlencoded"
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  
  curl_close($curl);
  
  if ($err) {
    // echo "cURL Error #:" . $err;
    return json_encode(array("message"=>"error","AADToken"=>"cURL Error #:" . $err,"status"=>1,"code"=>400));
  } else {
    // echo $response;
    // $TokenData = json_decode($response);
    return $response;
  }
}