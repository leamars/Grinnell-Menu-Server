<?php

include_once "Nutrition.php";

class Entree
{
  private $name;
  private $ovolacto;    //True if the dish is ovolacto, else false
  private $vegan;       //  "   "   "   "   "  vegan       "   "
  private $passover;    //  "   "   "   "   " for passover "   "
  private $halal;       //  "   "   "   "   " for halal    "   "
  private $gluten_free; //  "   "   "   "   " gluten free  "   "
  private $nutrition;   // Nil if there is no nutrtion, else contains array of nutrition values


  /** Construct the item with the string from csv */
  function __construct($itemName, $dishID, &$json_a){
  
	$length1 = strlen($itemName);
	$itemName = str_replace("OL*", "", $itemName);
    $itemName = str_replace("(OL)", "", $itemName);
	$length2 = strlen($itemName);
	if($length1 != $length2)
		$this->ovolacto = "true";
	else $this->ovolacto = "false";
  
  	$itemName = str_replace("V*", "", $itemName);
    $itemName = str_replace("(V)", "", $itemName);
	$length1 = strlen($itemName);
	if($length1 != $length2){
        $this->vegan = "true";
        $this->ovolacto = "true"; // If it is vegan, then it is also ovolacto.
      }
      else $this->vegan = "false";
	
	$itemName = str_replace("P*", "", $itemName);
    $itemName = str_replace("(P)", "", $itemName);
	$length2 = strlen($itemName);
	if($length1 != $length2)
		$this->passover = "true";
	else $this->passover = "false";

	$itemName = str_replace("H*", "", $itemName);
    $itemName = str_replace("(H)", "", $itemName);
	$length1 = strlen($itemName);
	if($length1 != $length2)
		$this->halal = "true";
	else $this->halal = "false";	
	
	$itemName = str_replace("GF*", "", $itemName);
    $itemName = str_replace("(GF)", "", $itemName);
	$length1 = strlen($itemName);
	if($length1 != $length2)
		$this->gluten_free = "true";
	else $this->gluten_free = "false";	
	$itemName = trim($itemName);
	$this->name = $itemName;
	/*
    $splitName = split('\*',$itemName); //dish name and fields delimited by *
    if(count($splitName) == 2){
      $this->name = ucwords(strtolower($splitName[1]));
      if(ereg('O',$splitName[0]) > 0)
        $this->ovolacto = "true";
      else $this->ovolacto = "false";
      if(ereg('V',$splitName[0]) > 0){
        $this->vegan = "true";
        $this->ovolacto = "true"; // If it is vegan, then it is also ovolacto.
      }
      else $this->vegan = "false";
      if(ereg('P',$splitName[0]) > 0)
        $this->passover = "true";
      else $this->passover = "false";
      if(ereg('H',$splitName[0]) > 0)
        $this->halal = "true";
        else $this->halal = "false";
    }
    else {
      $this->name = ucwords(strtolower($splitName[0]));
      $this->vegan = "false";
      $this->ovolacto = "false";
      $this->passover = "false";
      $this->halal = "false";
    }*/
	$temp_nutrition = build_nutrition($dishID, &$json_a);
	if ($temp_nutrition == null)
		$this->nutrition = "";
	else
		$this->nutrition = $temp_nutrition;
  }

  public function returnJson(){
    $tempName = str_replace('"','\\"',$this->name);
    $ret = "{ \"name\" : \"".$tempName."\",\n";
    $ret = $ret."\"vegan\" : \"".$this->vegan."\",\n";
    $ret = $ret."\"ovolacto\" : \"".$this->ovolacto."\",\n";
	$ret = $ret."\"gluten_free\" : \"".$this->gluten_free."\",\n";
    $ret = $ret."\"passover\" : \"".$this->passover."\",\n";
	$ret = $ret."\"halal\" : \"".$this->halal."\",\n";
	if ((strcmp($this->nutrition, "")) == 0)
		$ret = $ret."\"nutrition\" : \""."NIL"."\",\n";
	else
		$ret = $ret."\"nutrition\" : ".$this->nutrition."\n";
    $ret = $ret."}";
    return $ret;

  }

}

?>