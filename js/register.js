$(function(){
    var username = document.getElementById("username"),
        email = document.getElementById("email"),
        password = document.getElementById("password")

    function passValidate() {
        if (password.value.length < 6)
            password.setCustomValidity("Your password cannot be shorter than 6 characters.")
        else if (password.value.length > 30)
            password.setCustomValidity("Your password cannot be longer than 30 characters")
        else if (password.value.search(/[^a-zA-Z0-9]/) != -1)
            password.setCustomValidity("Your password may not contain special characters")
        else
            password.setCustomValidity('')
}

    function usernValidate() {
        if (username.value.search(/[^a-zA-Z0-9]/) != -1)
            username.setCustomValidity("Your username may not contain special characters")
        else if (username.value.length < 6)
            username.setCustomValidity("Your username may not be shorter than 6 characters")
        else if (username.value.length > 50)
            username.setCustomValidity("Your username may not be longer than 50 characters")
        else
            username.setCustomValidity('')
}

    function emailValidate() {
        if (email.value.length > 200)
            email.setCustomValidity("Your email may not be longer than 200 characters")
        else if (email.value.search(/[^a-zA-Z0-9\@\.]/) != -1)
            email.setCustomValidity("Your email address may not contain special characters other than @ and .")
        else
            email.setCustomValidity('')
    }
    password.onchange = passValidate;
    username.onchange = usernValidate;
})