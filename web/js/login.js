$(function () {
    let loginInput = $('#login');
    let passwordInput = $('#password');

    loginInput.add(passwordInput).keyup(function() {
        if (inputValLength(loginInput) && inputValLength(passwordInput)) {
            $('button').removeAttr('disabled');
        }
    });

    function inputValLength(input) {
        return input.val().length > 0;
    }
});