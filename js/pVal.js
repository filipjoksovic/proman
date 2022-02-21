$("#confirm_password").keyup(function(){
    let passwordValue = $("#password").val()
    let confirmPasswordValue = $("#confirm_password").val()
    console.log(passwordValue,confirmPasswordValue)
    if(passwordValue != confirmPasswordValue){
        $("#validator_text").text("Lozinke se ne poklapaju")
        $("#validator_text").css("color","red")
    }
    else{
        $("#validator_text").text("Lozinke se poklapaju")
        $("#validator_text").css("color","green")
    }
    if(passwordValue == "" && confirmPasswordValue == ""){
        $("#validator_text").text("")

    }
})
$("#password").keyup(function(){
    let passwordValue = $("#password").val()
    let confirmPasswordValue = $("#confirm_password").val()
    console.log(passwordValue,confirmPasswordValue)
    if(passwordValue != confirmPasswordValue){
        $("#validator_text").text("Lozinke se ne poklapaju")
        $("#validator_text").css("color","red")
    }
    else{
        $("#validator_text").text("Lozinke se poklapaju")
        $("#validator_text").css("color","green")
    }
    if(passwordValue == "" && confirmPasswordValue == ""){
        $("#validator_text").text("")
    }
})