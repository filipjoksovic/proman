let project_id = null;
function setProjectID(id) {
    project_id = id;
}
function prepareProjectEdit(id) {
    $.ajax({
        url: "index.php",
        type: "GET",
        dataType: "json",
        data: {
            "action": "get_project",
            "project_id": id
        },
        success: function (response) {
            console.log(response)
            $("#editName").val(response.name)
            $("#editDescription").text(response.description)
            $("#editBenefits").text(response.benefits)
            $("#editLocation").val(response.location)
            $("#deadlineEdit").val(response.deadline)
            $("#editEducation").val(response.education)
            setProjectID(response.id)
        },
        error: function (response) {
            alert(response.responseText)
        }
    })
}
function submitEdit() {
    $.ajax({
        url: "index.php",
        type: "POST",
        dataType: "json",
        data: {
            "action": "update_project",
            "project_id": project_id,
            "name": $("#editName").val(),
            "description": $("#editDescription").val(),
            "benefits": $("#editBenefits").val(),
            "location": $("#editLocation").val(),
            "deadline": $("#deadlineEdit").val(),
            "education": $("#editEducation").val(),
        },
        success: function (response) {
            location.reload();
        },
        error: function (response) {
            location.reload()
        }
    })
}

function prepareProjectDelete(id){
    $.ajax({
        url: "index.php",
        type: "GET",
        dataType: "json",
        data: {
            "action": "get_project",
            "project_id": id
        },
        success: function (response) {
            setProjectID(id)
        },
        error: function (response) {
            alert(response.responseText)
        }
    })
}
function submitDelete(){
    $.ajax({
        url: "index.php",
        type: "POST",
        dataType: "json",
        data: {
            "action": "delete_project",
            "project_id": project_id,
        },
        success: function (response) {
            location.reload();
        },
        error: function (response) {
            location.reload()
        }
    })
}