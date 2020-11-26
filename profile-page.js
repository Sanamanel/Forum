(async function() {
    
    let baseUrl = "https://led-zepplin-forum.herokuapp.com/"; //to be adapted

        $.ajax({
            url: baseUrl + 'server.php',
            type: 'get',
            data: {action : 'profile' },
            complete: function(response) {
                //console.log(response);
                
                if(response.status == 200) //The server have send information
                {
                    const profile = JSON.parse(response.responseText); //Decode JSON sent by the server
                    document.getElementById("email").value = profile.email;
                    document.getElementById("firstname").value = profile.firstname;
                    document.getElementById("lastname").value = profile.lastname;
                    document.getElementById("username").value = profile.username;
                    document.getElementById("birthdate").value = profile.birthdate;
                    document.getElementById("country").value = profile.country;
                    document.getElementById("signature").value = profile.signature;
                    document.getElementById("username_display").innerHTML = profile.username;
                    document.getElementById("signature_display").innerHTML = profile.signature;
                    document.getElementById("fullname_display").innerHTML = `${Strings.orEmpty(profile.firstname)} ${Strings.orEmpty(profile.lastname) }`;
                    document.getElementById("avatar").src = "http://2.gravatar.com/avatar/" + md5(profile.email.toLowerCase());

                }
                else if (response.status == 401 ) // When user is not authenticated, redirect to login page
                    window.location.href = baseUrl + 'index.php';
                else if (response.status == 500 ) //Internal error 
                    window.location.href = baseUrl + 'index.php';
                else 
                    window.location.href = baseUrl + 'index.php';

            }
        });

        document.getElementById("btn_save").addEventListener("click", async () => {
            
            let firstnameUp = document.getElementById("firstname").value;
            let lastnameUp = document.getElementById("lastname").value;
            let birthdateUp = document.getElementById("birthdate").value;
            let countryUp = document.getElementById("country").value;
            let signatureUp = document.getElementById("signature").value;
            let passwordUp = document.getElementById("password").value;
            
            let content = {
                'action': 'updateProfile',
                'firstname': firstnameUp,
                'lastname': lastnameUp,
                'birthdate': birthdateUp,
                'country': countryUp,
                'signature': signatureUp,
                'password': passwordUp
            };
            
         
            let contentStr = JSON.stringify(content);
            $.ajax({
                url: baseUrl + 'server.php',
                type: 'put',
                data: {content: contentStr},
                complete: function(response) {
                    console.log(response);
                    if (response.status == 200)
                        window.location.href = baseUrl + 'profile-page.php';
                    else
                    {
                        alert(response.responseText);
                    }
    
                   
                } 
            });


 
    });

        const Strings = {};
        Strings.orEmpty = function( entity ) {
        return entity || "";
        };
})();
