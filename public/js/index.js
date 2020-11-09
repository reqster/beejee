function getTasks(page = 1, orderBy = 'username', sort = 'asc'){
  $.get("taskList/" + page + "/" + orderBy + "/" + sort, function( data ) {
    $("#tasklist").html(data);
  });
}

function edit(id = 0){
  task = {};
  if (id == 0){
    task.username = $("#task-new-name").val();
    task.email = $("#task-new-email").val();
    task.description = $("#task-new-description").val();
  }

  errors = false;
  if (!task.username || !task.email || !task.description){
    errors = true;
    errorPopup("All fields must be filled");
  }
  
  if (!errors){
    $.post("edit/" + id, { username: task.username, email: task.email, description: task.description }, 
      function( data ) {
        if (!data.success){
          errorPopup(data.errors.join("</br>"));
        }
        else{
          successPopup("Task successfully created");
          getTasks();
        }
      },
    "json")
  }
}

function complete(id){
  $.post("complete/" + id, {}, function( data ){
    $('#task-complete-' + id).attr("onclick", 'return false;');
  });
}

function popup(text, title){
  $('#popup-title').html(title);
  $('#popup-body').html(text);
  $('#the-popup').modal('show'); 
}

function errorPopup(text){
  popup(text, 'Error')
}

function successPopup(text){
  popup(text, 'Success')
}

function logout(){
  $.get("logout", function( data ) {
    window.location.replace('/');
  });
}

function login(){
    $.post("login", { login: $('#login-login').val(), password: $('#login-password').val() }, 
      function( data ) {
        if (!data.success){
          errorPopup(data.errors.join("</br>"));
        }
        else{
          window.location.replace('/');
        }
      },
    "json")  
}

getTasks();