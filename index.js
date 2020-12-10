(() => {
  let baseUrl = "https://led-zepplin-forum.herokuapp.com/";

  document.getElementById("btn_login").addEventListener("click", async () => {
    logIn();
   
  });

  $('.input').on('keyup',function(e){
      if(e.keyCode == 13){
        logIn();
      }
  });

  function logIn(){

    document.getElementById("login_errors").innerHTML = "";
    let emailValue = document.querySelector("#login_email").value;
    if (!emailValue) {
      // If email is empty, display ar error message
      document.getElementById("login_errors").innerHTML =
        "Please enter an email";
      return;
    }

    let passwordValue = document.querySelector("#login_password").value;
    if (!passwordValue) {
      // If password is empty, display ar error message
      document.getElementById("login_errors").innerHTML =
        "Please enter a password";
      return;
    }

    let content = {
      action: "login",
      email: emailValue,
      password: passwordValue,
    };
    let contentStr = JSON.stringify(content);
    $.ajax({
      url: baseUrl + "config/server.php",
      type: "post",
      data: { content: contentStr },
      complete: function (response) {
        console.log(response);
        if (response.status == 200) window.location.href = baseUrl + "home.php";
        else {
          document.getElementById("login_errors").innerHTML =
            response.responseText;
        }
      },
    });


}

document.getElementById("btn_register").addEventListener("click", async () => {
    register();

});

function register(){

    document.getElementById("register_errors").innerHTML = "";
    let usernameValue = document.querySelector("#register_username").value;
    if (!usernameValue) {
      document.getElementById("register_errors").innerHTML =
        "Please enter an username";
      return;
    }

    let passwordValue = document.querySelector("#register_password").value;
    if (!passwordValue) {
      document.getElementById("register_errors").innerHTML =
        "Please enter a password";
      return;
    }

    let passwordConfirmationValue = document.querySelector(
      "#register_password_confirmation"
    ).value;
    if (!passwordConfirmationValue) {
      document.getElementById("register_errors").innerHTML =
        "Please enter a confirmation password";
      return;
    }

    let emailValue = document.querySelector("#register_email").value;
    if (!emailValue) {
      document.getElementById("register_errors").innerHTML =
        "Please enter an email address ";
      return;
    }

    let content = {
      action: "register",
      username: usernameValue,
      password: passwordValue,
      passwordConfirmation: passwordConfirmationValue,
      email: emailValue,
    };
    let contentStr = JSON.stringify(content);
    $.ajax({
      //send a post request to the server with the content as JSON
      url: baseUrl + "config/server.php",
      type: "post",
      data: { content: contentStr },
      complete: function (response) {
        console.log(response);
        if (response.status == 200)
          window.location.href = baseUrl + "home.php";
        //An user that is registered, is automatically logged
        else {
          document.getElementById("register_errors").innerHTML =
            response.responseText;
        }
      },
    });
  



}



  })();
