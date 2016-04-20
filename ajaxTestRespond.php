<?php


header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");


/*
echo "Your name : " . testInput($_POST["name"]) . "<br/>";
echo "Your age &nbsp&nbsp&nbsp: " . testInput($_POST["age"]) . "<br/>";
echo "Your gender : " . testInput($_POST["gender"]) . "<br/>";
*/


$xmlUrl       = "ajaxTestArchive.xml";
$target       = testInput($_POST["target"]);
$postKeys     = array("name","age","gender");
$responseKeys = array("name","age","gender");

$xmlDoc  = new DOMDocument();
$xmlDoc -> load($xmlUrl);


//showXML(parseXML($xmlUrl, packPostInfo()));
respondXML(parseXML($xmlUrl, packPostInfo()));


function packPostInfo(){
    global $postKeys;
    $postInfo = array();
    foreach ($postKeys as $key) {
        $postInfo[$key] = testInput($_POST[$key]);
        #print($_POST[$key]);
    }
    return $postInfo;
}


/* This function is not safe enough but automatic....
function packPostInfo(){
    $postInfo = array();
    foreach ($_POST as $key => $value) {
        if ($key != "target") {
            $postInfo[testInput($key)] = testInput($value);
        }
    }
    return $postInfo;
}
*/


function respondXML($personTargetIDs){
    global $xmlDoc;
    global $responseKeys;
    global $target;
    print('<?xml version="1.0" encoding="UTF-8"?>');
    print("<target>" . $target . "</target>");
    if(empty($personTargetIDs)) {
        print("Not Found!");
    }
    else{
        foreach ($personTargetIDs as $personTargetID) {
            $xmlTargetIDNodes = $xmlDoc -> getElementsByTagName("id");
            foreach ($xmlTargetIDNodes as $targetIDNode) {
                if ($personTargetID == $targetIDNode -> firstChild -> nodeValue) {
                    $personTarget = $targetIDNode -> parentNode;
                    print("<person>");
                    #print("id = " . $personTargetID . "<br/>");
                    #print($personTarget -> getElementsByTagName("name") -> item(0) -> firstChild -> nodeValue . "<br/>");
                    foreach ($responseKeys as $respondKey) {
                        print("<" . $respondKey . ">". 
                            $personTarget -> getElementsByTagName($respondKey) -> item(0) -> firstChild -> nodeValue . 
                            "</" . $respondKey . ">");
                        //print($personTarget -> getElementsByTagName($respondKey) -> item(0) -> firstChild -> nodeValue . "<br/>");
                    }
                    print("</person>");
                }
            }       
            //print("<br/><br/>");
        }
    }
}


function showXML($personTargetIDs){
    global $xmlDoc;
    global $responseKeys;
    if (empty($personTargetIDs)) {
        print("Not Found!");
    }
    else{
        foreach ($personTargetIDs as $personTargetID) {
            $xmlTargetIDNodes = $xmlDoc -> getElementsByTagName("id");
            foreach ($xmlTargetIDNodes as $targetIDNode) {
                if ($personTargetID == $targetIDNode -> firstChild -> nodeValue) {
                    $personTarget = $targetIDNode -> parentNode;
                    #print("id = " . $personTargetID . "<br/>");
                    #print($personTarget -> getElementsByTagName("name") -> item(0) -> firstChild -> nodeValue . "<br/>");
                    foreach ($responseKeys as $respondKey) {
                        print($personTarget -> getElementsByTagName($respondKey) -> item(0) -> firstChild -> nodeValue . "<br/>");
                    }
                }
            }       
            print("<br/><br/>");
        }
    }
}


function parseXML($xmlUrl, $postInfo){
    global $xmlDoc;
    $flagMatch       = 0;
    $flagNull        = 0;
    $personTargetIDs = array();# Array for IDs

    $xmlDocPeopleNodes = $xmlDoc -> getElementsByTagName("person");
    foreach ($xmlDocPeopleNodes as $personNode) {
        $flagMatch = true;
        //$flagNull  = 0;
        #print("This is a xml respond : " . $personNode -> getElementsByTagName("name") -> item(0) -> firstChild -> nodeValue . "<br/>");
        foreach ($postInfo as $postInfoKey => $postInfoValue) {
            $attributeValue = $personNode -> getElementsByTagName($postInfoKey) -> item(0) -> firstChild -> nodeValue;
            if ($postInfoValue != ""){
                if(strtolower($postInfoValue) != strtolower(substr($attributeValue, 0, strlen($postInfoValue)))){
                    $flagMatch = false;
                }
            }
        }
        if($flagMatch == true){
            array_push($personTargetIDs , $personNode -> getElementsByTagName("id") -> item(0) -> firstChild -> nodeValue);
        }
    }
    return $personTargetIDs;
}


function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>