

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


   



});