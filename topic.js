(() => {
    let baseUrl = "https://led-zepplin-forum.herokuapp.com/"; //to be adapted

    document.getElementById("btn_submit").addEventListener("click", async () => {
        
        let messageValue = document.getElementById("message_text").innerHTML;
        console.log(messageValue); 
        if(!messageValue) // If message is empty, display an alert
        {
            alert("Please enter a message");
            return;
        }

        let topicId = document.getElementById("btn_submit").getAttribute("data-topicId");

        let content = {
            'action': 'create_message',
            'message': messageValue,
            'topicId' : topicId
        };
        let contentStr = JSON.stringify(content);
        $.ajax({
            url: baseUrl + 'server.php',
            type: 'post',
            data: {content: contentStr},
            complete: function(response) {
                console.log(response);
                if (response.status == 200)
                    window.location.href = baseUrl + `topic.php?topic_id=${topicId}`;
                else
                {
                    alert(response.responseText);
                }
            } 
        });
    });

    
    
  })();