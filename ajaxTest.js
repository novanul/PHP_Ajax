
var xmlHttp=null;


window.onload=function(){
    document.getElementsByName("name")[0].addEventListener("keyup",sendAjaxInformation);
    document.getElementsByName("age")[0].addEventListener("keyup",sendAjaxInformation);
    document.getElementsByName("gender")[0].addEventListener("click",sendAjaxInformation);
    document.getElementsByName("gender")[1].addEventListener("click",sendAjaxInformation);
    //document.getElementById("test").innerHTML=document.getElementsByName("gender").length;
}


function sendAjaxInformation(){
    var urlTarget   = "ajaxTestRespond.php";
    var contentName = null;
    var content     = "";

    //contentName = Array("name","age","gender");
    contentName = {
        textName  : ["name", "age"],
        radioName : ["gender"]
    }
    content = packInfo(contentName);

    xmlHttp = getXmlHttpObject();
    if(xmlHttp == null){
        //XMLHTTP is not supported!!
        return 1;
    }
    xmlHttp.onreadystatechange = retriveAjaxContent;
    xmlHttp.open("POST",urlTarget,false);
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlHttp.send(content);
}


function testInput(str){
    //drop off the "&" and "="
    var strLength  = str.length;
    var strChecked = "";
    var pattern    = new RegExp("[&=]");
    for(var i = 0; i < strLength; ++i){
        if (pattern.exec(str[i])){
            //Find illegal char
            document.getElementById("test").innerHTML = str[i] + " is illegal.";
        }
        else{
            strChecked = strChecked + str[i];//concat?
        }
    }
    return strChecked;
}


function getRadioValue(strTarget){
    //pick up the checked radio by the name of target radio
    var radioArray = document.getElementsByName(strTarget);
    var radioArrayLength = radioArray.length;
    for(var i = 0; i < radioArrayLength; ++i){
        if(radioArray[i].checked){
            return radioArray[i].value;
        }
    }
    return "";
}

/*
function packInfo_test1(contentName){
    var strSend = "";
    strSend =       contentName[0] + "=" + document.getElementsByName(contentName[0])[0].value +
              "&" + contentName[1] + "=" + document.getElementsByName(contentName[1])[0].value +
              "&" + contentName[2] + "=" + getRadioValue(contentName[2]);
    return strSend;
}


function packInfo_test2(contentName){
    var strSend       = "";
    var contentLength = contentName.length;

    strSend = contentName[0] + "=" + document.getElementsByName(contentName[0])[0].value;
    for(var i = 1; i < contentLength; ++i){
        strSend = strSend + "&" + contentName[i] + "=" + document.getElementsByName(contentName[i])[0].value;//What for radio?if else does.
    }

    return strSend;
}
*/

function packInfo(contentName){
    //Object for form
    var strSend            = "";
    var contentTextLength  = contentName.textName.length;
    var contentRadioLength = contentName.radioName.length;
    var flagFirstArgument  = false;

    strSend = "target=ajax";

    for(var i = 0; i < contentTextLength; ++i){
        strSend = strSend + "&" + contentName.textName[i] + "=" + testInput(document.getElementsByName(contentName.textName[i])[0].value);
    }

    for(var i = 0; i < contentRadioLength; ++i){
        strSend = strSend + "&" + contentName.radioName[i] + "=" + testInput(getRadioValue(contentName.radioName[i]));
    }

    return strSend;
}


function retriveAjaxContent(){
    if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
        document.getElementById("respond_information").innerHTML = xmlHttp.responseText;
    }
}


function getXmlHttpObject(){
    var xmlHttp = null;
    try{
        //Firefox,Chrome,Opera,Safari
        xmlHttp = new XMLHttpRequest();
    }
    catch(excp){
        try{
            //IE for advanced
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(excp){
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}


function test(){
    alert("hh");
}