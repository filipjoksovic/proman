function setUser(source, destination){
    destination = source;
}
function getUserData(id){
    let user = null;
    $.ajax({
        url:"index.php",
        dataType:"json",
        type:"GET",
        async:false,
        data:{
            "action":"get_user_data",
            "user_id":id
        },
        success:function(response){
            user = response
            console.log(response)
            // setUser(response,user)
        },
        error:function(response){
            console.log(response)
        }
    })
    console.log(user)
    return user;
}
function initiateDelete(id){
    let user = getUserData(id);
    $("#delete_id").val(user.id)
    $("#deleteEmailPlaceholder").text(user.fname + " " + user.lname);
}
function initiateEdit(id){
    let user = getUserData(id);
    $("#edit_user_id").val(user.id)
    $("#editFname").val(user.fname);
    $("#editLname").val(user.lname);
    $("#editEmail").val(user.email);
    $("#edit_cat").val(user.created_at);
    $("#edit_uat").val(user.updated_at);
}
function confirmUserDelete(){
    let user_id = $("#delete_id").val()
    $.ajax({
        url:"index.php",
        dataType:"json",
        type:"POST",
        data:{
            "user_id":user_id,
            "action":"delete_user"
        },
        success:function(response){
            location.reload()
        },
        error:function(response){
            location.reload()
        }
    })
}