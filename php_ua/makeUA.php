<?php
  header("Content-Type: JSON");
  header("Access-Control-Allow-Origin: *");
  $function = "";
  $input = "";
  $response = array();;
  if(isset($_SERVER["REQUEST_METHOD"])) {
    if(isset($_GET["function"]) && isset($_GET["input"])){
      $function = $_GET["function"];
      $input = $_GET["input"];
      if($function === "i2a"){
        $response = convert_i2a($input);
      }
      elseif($function === "check_TLD"){
        $response = check_TLD($input);
      }
    }
    $json_result = json_encode($response);
    echo $json_result;
    return $json_result;  
  }

  // IDN to ASCII
  function convert_i2a($domain_part) {
    $ascii_result = idn_to_ascii($domain_part);
    $response = array();
    if($ascii_result) {
        $response["result"] = "1";
        $response["status"] = "✔️ Domain part is valid : " . $domain_part;
    }
    else {
        $response["result"] = "0";
        $response["status"] = "❌ Error in domain part : " . $domain_part;
    }
    return $response;
  }

  // Check TLD
  function check_TLD($domain_part) {
    $response = array();
    $domain_part_array = explode(".", trim($domain_part));
    $TLD_string = end($domain_part_array);
    $idn_validated_TLD = idn_to_ascii($TLD_string);
    if($idn_validated_TLD) {
      $TLD_file = "./TLD.txt";
      $TLD_file_contents = file_get_contents($TLD_file);
      $TLD_array = explode("\n", $TLD_file_contents);
      array_shift($TLD_array);
      array_pop($TLD_array);
      $tld = strtoupper(trim($idn_validated_TLD));
      $result = in_array($tld, $TLD_array);
      if($result) {
        $response["result"] = "1";
        $response["status"] = "✔️ Valid TLD : " . $TLD_string;
      }
      else {
        $response["result"] = "0";
        $response["status"] = "❌ Invalid TLD : " . $TLD_string;
      }  
    }
    else {
      $response["result"] = "0";
      $response["status"] = "❌ Error in TLD." . $TLD_string;
    }
    return $response;  
  }
?>