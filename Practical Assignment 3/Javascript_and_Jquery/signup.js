function log(info) {
  console.log(info);
}

$("#button-signup").click(function () { 
  if(validation()==false || regEX_email()==false || regEX_password()==false)
    return;
  $("#pass1, #pass2").prop('checked', true);
  GenericPost("PHP files/validate-signup.php", convert_form(), command_do);
});

$("#pass1").click(function () {
  var element = document.getElementById("password");
  if(element.type == "password")
    element.type = "text";
  else
    element.type = "password";
});

$("#pass2").click(function () {
  var element = document.getElementById("con-password");
  if(element.type == "password")
    element.type = "text";
  else
    element.type = "password";
});


/************************************/
function command_do(comm) {
  if(comm.command == "error") {
    alert("Error! view error codes in log");
  }
  else if(comm.command == "empty-parameter") {
    alert("please ensure all fields are completed upon submission");
  }
  else if(comm.command == "match-pass") {
    alert("Passwords are not the same");
  }
  else if(comm.command == "regex-pass") {
    alert("The password is required to contain an upper,"+
      "lower case letters, contain atleast a single digit and special character"+
      " and required to be atleast 8 characters long");
  }
  else if(comm.command == "length-pass") {
    alert("password is too short");
  }
  else if(comm.command == "regex-email") {
    alert("The email is invalid");
  }
  else if(comm.command == "email-already-exists") {
    alert("The email is already in use");
  }
  //else if(comm.command == "id-length") {
  //  alert("The ID is not 13 digits long");
  //}
  //else if(comm.command == "id-not-number") {
  //  alert("An ID only consists of digits");
  //}
  else if(comm.command == "name-failure") {
    alert("Names may only be letters from the alphabet, sorry X Æ A-12,");
  }
  else if(comm.command == "surname-failure") {
    alert("Surname may only be letters from the alphabet");
  }
  else if(comm.command == "user-submitted") {
    showkey(comm.key);
  }
  else if(comm.command == "") {
    alert("Empty command");
  }
}

function showkey(key) {
  $("#dataform").css("display", "none");
  $("#dataform").after("<div id=\"apikey\">You have been registered!<br><br>API KEY: "+key+"</div>");
  $("#apikey").css("display", "block");
}

/************************************/
function validation() {
  var field = $("#id_no").val();
  //if(field.length!=13) {
  //  alert("An ID is 13 digits long");
  //  return false;
  //}
  //if(!/(^[0-9]+$)/.test(field)) {
  //  alert("An ID is only numbers");
  //  return false;
  //}
  field = $("#name").val();
  if(!/^[a-zA-Z]+$/.test(field)) {
    alert("A name only contains letters of the alphabet");
    return false;
  }
  field = $("#surname").val();
  if(!/^[a-zA-Z]+$/.test(field)) {
    alert("A surname only contains letters of the alphabet");
    return false;
  }
}


/************************************/
function security_validation() {
  var ins = $(".fields");
}

function convert_form() {
  var ins = $(".fields");
  var form = {};
  
  form = { 
  //  "id" : ins[0].value, 
    "name" : ins[0].value,
    "surname" : ins[1].value,
    "email" : ins[2].value,
    "password" : ins[3].value,
    "con_password" : ins[4].value
  };

  return form;

}

/*****************************************************************************/
//credit to:
//https://www.w3resource.com/javascript/form/email-validation.php
function regEX_email() {
  if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($("#email").val())) {
    return true;
  }
    alert("Email is invalid");
    return false;
}

function regEX_password() {
  var field = $("#password").val();  
  //log(field);
  if(field.length<8) {
    alert("password too short");
    return false;
  }
  if(/([A-Z])\w+/.test(field)==false) {
    alert("No uppercase characters found in password")
    return false;
  }
  if(/([a-z])\w+/.test(field)==false) {
    alert("No uppercase characters found in password")
    return false;
  }
  if(/([0-9])\w+/.test(field)==false) {
    alert("No digit found in password")
    return false;
  }
  if(/([!@#$%^&*()_+`~=~{}/?.,<>])+/.test(field)==false) {
    alert("No special characters found in password")
    return false;
  }
}

function showButton(bool) {
  if(bool==true)
    $("#showBut").css("visibility", "visible");
  else
    $("#showBut").css("visibility", "hidden");
}

