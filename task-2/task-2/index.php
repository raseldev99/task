<?php
require_once './simple_html_dom.php';

$url = 'https://yourpetpa.com.au';
//Fetch html 
function fetchHtml($url){
    $curl = curl_init();
    $requestType = 'GET';
    $ua = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13';
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => $requestType,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_USERAGENT=>$ua,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true, 
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    $response = curl_exec($curl);

    if ($response === false) {
        throw new Exception(curl_error($curl), curl_errno($curl));
    }

    // Check for HTTP status code
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($http_status !== 200) {
        throw new Exception("HTTP request failed with status code $http_status");
    }
    curl_close($curl);
    return $response;
}
//Progress bar
function progressBar($done, $total) {
    $perc = floor(($done / $total) * 100);
    $left = 100 - $perc;
    $write = sprintf("\033[0G\033[2K[%'={$perc}s>%-{$left}s] - $perc%% - $done/$total", "", "");
    fwrite(STDERR, $write);
}

//Get product urls by category
function getProductUrlByCategory($category_url){
    global $url;
    $productUrlArray = [];
    while($category_url != null){
        $product = fetchHtml($category_url);
        $dom = new simple_html_dom();
        $dom->load($product);
        $products = $dom->find('div[class="product-block__title"] a[class="product-block__title-link"]');
        $pagination = $dom->find('div[class="pagination large-row"] span[class="next"] a');
        foreach($products as $item){
            $productUrlArray[] = $item->href;
        }
        if(count($pagination) >0){
            $category_url = $url . $pagination[0]->href;
        }else{
            $category_url = null;
        }
    }
    
    return $productUrlArray;
}

//Retrieve product URLs organized by their corresponding categories.
function getAllCategoryWithProductUrl($url){
    echo "Getting all products urls...." . PHP_EOL;
    $response = fetchHtml($url);
    $dom = new simple_html_dom();
    $dom->load($response);
    $category = $dom->find('a[class="site-nav__link site-nav__dropdown-heading"]');

    //for progress bar
    $done = 0;
    $total = count($category);
    progressBar($done,$total);

    $allProduct = [];
    foreach($category as $item){
        $item = (object)$item;
        $allProduct[$item->plaintext] = getProductUrlByCategory($url.$item->href);

        //for progress bar
        progressBar(++$done,$total);
    }

    return $allProduct;
}

//Retrieve product info
function getProductInfo($url,$category){
    $response = fetchHtml($url);
    $dom = new simple_html_dom();
    $dom->load($response);
    $title = $dom->find('h3[class="product-detail__title heading-font-5"]',0)->plaintext;
    $price = $dom->find('div[class="product-detail__price product-price"] span',0)->plaintext;
    $img = $dom->find('a[data-product-image]',0)->href;
    $description = $dom->find('div[class="product__description_full--width"]',0)->plaintext;
    return[
        'Title' => $title,
        'Category'=>$category,
        'Description' => $description,
        'Price' => $price,
        'URL'  => $url,
        'imageURL'=>$img
    ];

}

//Retrieve all products information as an array.
function getAllProductInfo(){
    global $url;
    $productsUrl = getAllCategoryWithProductUrl($url);
    $products = [];

    echo PHP_EOL . "Getting all product info....".PHP_EOL;
    //For progress bar
    $done = 0;
    $total = 0;
    foreach ($productsUrl as $items) {
        $total+= count($items);
    }
    progressBar($done,$total);


    foreach($productsUrl as $key => $product_url){
        foreach($product_url as $url_item){
          $products[] = getProductInfo($url.$url_item,$key);
          
          //For progress bar
          progressBar(++$done,$total);
        }
    }

    return $products;
}

//Generate CSV file
function generateCSV($products){
    echo PHP_EOL ."Generating csv file..." . PHP_EOL;
    $file_name = "products".rand(100,1000).".csv";
    $fp = fopen($file_name,'w');
    fputcsv($fp, array_keys($products[0]));
    $done = 0;
    $total = count($products);
    foreach ($products as $product) {
        fputcsv($fp, $product);

        //for progress bar
        progressBar(++$done,$total);
    }
    fclose($fp);
    echo PHP_EOL . "Successfully generated all products as a CSV file";
}
try {
    generateCSV(getAllProductInfo());
} catch (Exception $e) {
    // Handle any exceptions
    echo 'Error: ' . $e->getMessage();
}

?>
