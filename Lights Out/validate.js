//Validate the contact us form before sending the details to the database:
function contactValidate() 
{
    if(document.contactus.firstname.value.trim() == ""){//If First Name is empty:
        alert("Please enter your first name");
        document.contactus.firstname.focus();
        return false;
    }

    if(document.contactus.lastname.value.trim() == ""){//If Last Name is empty:
        alert("Please enter your last name");
        document.contactus.lastname.focus();
        return false;
    }

    if(document.contactus.email.value.trim() == ""){ //If Email is empty:
        alert("Please enter your email address");
        document.contactus.email.focus();
        return false;
    }

    if(document.contactus.comments.value.trim() == ""){ //If Comments are empty:
        alert("Please enter any comments or suggestions");
        document.contactus.comments.focus();
        return false;
    }
}

/* Using Javascript to shift between both forms in the login.php file based on if the user clicks on the Login or Register button:  */
var x=document.getElementById("login");
var y=document.getElementById("register");
var z=document.getElementById("btn");

function login(){ /* If the user clicks on Login, shift the form into view and hide the other form: */
    x.style.left="50px";
    y.style.left ="450px";
    z.style.left = "0";
}

function register(){ /* If the user clicks on Register, shift the form into view and hide the other form: */
    x.style.left="-400px";
    y.style.left ="50px";
    z.style.left = "110px";
}       

//Validate the registration form before sending the details to the database:
function validate_registration(){

    var agree_checkbox=document.getElementById("agree_checkbox"); /* Store the agree to the terms and conditions checkbox from the regisration form: */
    
    if (!agree_checkbox.checked){ /* If the box is left unchecked upon submission display an alert to the user: */
        alert("Please agree to the terms and conditions before registering.");
        return false; //Prevent the form from being submitted:
    }
    return true; //Alow the form to be submitted once the checkbox is checked:
}