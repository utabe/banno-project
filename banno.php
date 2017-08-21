<?php {

  /*
  Pulls in the html from both https://banno.com and
  https://banno.com/features to find the products
  */
  $html = file_get_contents("https://banno.com/index.html");
  $products_html = file_get_contents("https://banno.com/features/index.html");

  //Splits the html into an array where each line of the html is an element
  $array = preg_split ('/$\R?^/m', $html);

  //Counts the number of products offered on https://banno.com/features
  function count_products_offered($products_html){
    $products_array = preg_split ('/$\R?^/m', $products_html);
    $number_of_products = 0;
    foreach ($products_array as $line) {
      if (preg_match('/Banno.*&trade;/', $line)) {
        $number_of_products += 1;
      }
    }
    //return $number_of_products;
    echo "According to https://banno.com/features there seems to be "
    . $number_of_products . " different product(s).\n";
  }


  //Counts the 3 most common letters in the html
  function count_letters($html){
    //an associative array for the letters and how often each occurs
    $letters = array();
    $strlen = strlen($html);
    for ($i = 0; $i < $strlen; $i++) {
      $char = $html[$i];
      //checks if the character is alphanumeric
      if (ctype_alnum($char)) {
        //if the character is in the array add one to the count
        //if it does not exist add it to the array
        if (array_key_exists($char, $letters)) {
          $letters[$char] += 1;
        }
        else {
          $letters[$char] = 1;
        }
      }
    }
    //sort the array by largest value
    arsort($letters);

    echo "The most frequent occuring characters are " . array_keys($letters)[0] .
    ', ' . array_keys($letters)[1] . ', and ' . array_keys($letters)[2] . ".\n";

    for ($j = 0; $j < 3; $j++){
      echo "The character '" . array_keys($letters)[$j] . "' appears " .
      array_values($letters)[$j] . ' time(s).' . "\n";
    }
  }


  //Counts the number of png images in the array
  function count_png($array){
    $count = 0;
    foreach ($array as $line) {
      if (preg_match('/.png/', $line)) {
        $count += 1;
      }
    }
  echo 'The number of png images in the html is ' . $count .".\n";
  }


  //Finds the twitter handle for Banno
  function find_twitter_handle($array){
    $twitter_handle = '';
    //finds the line with both 'twitter' and '@' and then strips away the excess
    //to leave only the twitter handle
    foreach ($array as $line) {
      if (preg_match('/twitter.*@|@.*twitter/', $line)) {
        $twitter_handle = substr($line, strpos($line, '@'));
        $twitter_handle = substr($twitter_handle, 0, strpos($twitter_handle, '"'));
        echo "BannoJHA's twitter handle is " . $twitter_handle . ".\n";
        break;
      }
    }
  }


  //Counts how often "financial instituion" appears in the html
  function count_financial_institution($html){
    //use regex to find 'finacial institution' (case insensitive)
    $count = preg_match_all('/financial institution/i', $html);

    echo "The term \"financial institution\" appears " . $count . " time(s).\n";
  }

  count_products_offered($products_html);
  count_letters($html);
  count_png($array);
  find_twitter_handle($array);
  count_financial_institution($html);

} ?>
