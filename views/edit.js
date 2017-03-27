

document.addEventListener("DOMContentLoaded", function () {
    
    var button = document.querySelector('.edit-button');

    button.addEventListener("click", function () {
        alert("Profile updated!");
    });

    var delAcc = document.querySelector('.danger');

    delAcc.addEventListener("click", function (event) {
        var ask = window.confirm("Delete account?");
        if (ask !== true) {
            event.preventDefault();
            }
        });
        
    
    
    
    
    
    var msg = document.querySelector('#message');
    
    
    msg.addEventListener("click", function (event) {
          
    
        
        
        
        
        var confirmation = window.confirm("Send message?");
        if (confirmation !== true) {
            event.preventDefault();
        }
    })
   
   



});

