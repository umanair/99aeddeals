<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'off');			
global $startDealNo;

require("includes/db.php"); 

if ((isset($_GET['action'])) && ($_GET['action'] != "")){

	$ajaxFuncs = new ajaxFunctions;

	switch($_GET['action']){
		case "grabInitialDeals" : return $ajaxFuncs->getInitialDeals(); break;
		case "grabDeal" : return $ajaxFuncs->getNextDeal(); break;
		case "grabDealInfo" : return $ajaxFuncs->getNextDealInfomation(); break;
	}		
}

class ajaxFunctions{

	public static $instance;
	private $DbObject = NULL;
	private $userId;
	
	public function __construct() {}	
	
	static function getInstance() { if (self::$instance == NULL) return new self; }
	
	public function getInitialDeals(){
	
		$select = mysql_query("select * from deals LIMIT 0, 5");
		while($row = mysql_fetch_array($select)){
			echo '<div id="'.$row["id"].'" class="featuredDeal">
						<span>instead of <!-- deal original price goes here -->'.round($row["market_price"]).' pay</span>
						<span><!-- deal price goes here --r>'.round($row["deals_price"]).'</span>
						<span>aed</span>
						<img class="smallDealImg" src="public/images/price_label.png">
						<img src="'.$row[1].'" width="160" height="92" /><!-- deal small image goes here -->
					 </div>';		
		}
	}
    	
	public function getNextDeal(){
	
	    $selectdeals = mysql_query("select * from deals") or die ("select * from deals".mysql_error());
		$select = mysql_query("select * from deals LIMIT ".($_GET['next'] + $_GET['initial']).",1");
		$fetch = mysql_fetch_array($select);
		$imagepath = $fetch["image"];
		$images = explode("../",$imagepath);
		echo '<div id="'.$fetch["id"].'" class="featuredDeal">
                	<span>instead of <!-- deal original price goes here -->'.round($fetch["market_price"]).' pay</span>
                    <span><!-- deal price goes here -->'.round($fetch["deals_price"]).'</span>
                    <span>aed</span>
                    <img class="smallDealImg" src="public/images/price_label.png">
                    <img src="'.$images[1].'" width="160" height="92" /><!-- deal small image goes here -->
                 </div>';		
	}
	
	public function getNextDealInfomation(){
		$deal_id          	   = $_GET["dealId"];
		
		$selectQuery      	   = mysql_query("select * from deals where id='$deal_id'");
		$result          	   = mysql_fetch_array($selectQuery);
		
		$marketPrice      	   = $result["market_price"];
		$marketValue      	   = explode(".",$marketPrice);
		$marketWholeValue 	   = $marketValue[0];
		$marketCentValue 	   = $marketValue[1];
		$sellingPrice     	   = $result["deals_price"];
		$sellingValue     	   = explode(".",$sellingPrice);
		$sellingWholeValue	   = $sellingValue[0];
		$sellingCentValue 	   = $sellingValue[1];
		$saveWholePrice        = $marketWholeValue- $sellingWholeValue;
		$saveCentPrice         = $marketCentValue - $sellingCentValue;
		
		echo "<div class='priceDetailNodes'>
            	<div>
                	<span>99aed.com</span>
                	<span>Everything is under 99AED</span>
                </div>
                <div>
                	<span>PREORDER NOW</span>
                    <span>only </span>
                    <span>".$sellingWholeValue."<!-- Original price as whole numbers goes here --></span>
                    <div>
                    	<span> .".$sellingCentValue." <!-- Original price as cents goes here --></span>
                        <span>AED</span>
                	</div>
                </div>
                <div>
                	<span>You save</span>
                    <span>".$saveWholePrice."<!-- reduced price as whole numbers goes here --></span>
                    <div>
                    	<span> .".$saveCentPrice."<!-- reduced price as cents goes here --></span>
                        <span>AED</span>
                	</div>
                </div>
                <div>
                	<span>Original Price</span>
                    <span>".$marketWholeValue."<!-- reduced price as whole numbers goes here --></span>
                    <div>
                    	<span> .".$marketCentValue."<!-- reduced price as cents goes here --></span>
                        <span>AED</span>
                	</div>
                </div>
                <div>
                	<span>DISCOUNT</span>
                	<span><!-- Discount value goes here -->-".$result["discount"]."%</span>
                	<div><span>Thank you for buying</span></div>
                </div>
            </div>
        </div><!-- Price details ends here -->";
	}
}