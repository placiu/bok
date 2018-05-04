$(function () {
    let loginInput = $('#login');
    let password1Input = $('#password1');
    let password2Input = $('#password2');

    let loginPattern = /^(?=.*[a-z])\w{3,}$/;
    let passwordPattern = /^(?=.*[A-Z])(?=.*[0-9])\w{6,}$/;

    loginInput.popover({
        trigger: 'focus'
    });

    password1Input.popover({
        trigger: 'focus'
    });

    password2Input.popover({
        trigger: 'focus'
    });

    loginInput.add(password1Input).add(password2Input).keyup(function() {
       if (inputCharsCheck(loginInput, loginPattern) && inputCharsCheck(password1Input, passwordPattern) && inputCharsCheck(password2Input, passwordPattern) && passwordsMatches()) {
           $('button').removeAttr('disabled');
       }
    });

    function inputCharsCheck(input, pattern) {
        return pattern.test(input.val());
    }

    function passwordsMatches() {
        return password1Input.val() === password2Input.val();
    }
});