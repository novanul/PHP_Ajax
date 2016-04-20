<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <script type="text/javascript" src="ajaxTest.js" charset="utf-8" ></script>
    <title>This is a test.</title>
</head>
<body>

<h3 >This is a test.</h3>
<form id="ajax_send">
    name : <input type="text" name="name" /><span id="input_name"></span><br/>
    age &nbsp&nbsp&nbsp: <input type="text" name="age" /><span id="input_age"></span><br/>
    gender :
    <label>male<input type="radio" name="gender" value="male"></label>
    &nbsp&nbsp&nbsp
    <label>female<input type="radio" name="gender" value="female"></label><span id="input_gender"></span><br/>
</form>

<h3>This is the respond</h3>
<div id="respond_information"></div>
<div id="test"></div>

</body>

</html>
