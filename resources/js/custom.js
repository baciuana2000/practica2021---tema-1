//CUSTOM JS
$('#userEditModal').on('shown.bs.modal', function(event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let user = button.data('user');

    let modal = $(this);

    modal.find('#userEditId').val(user.id);
    modal.find('#userEditName').text(user.name);
    modal.find('#userEditRole').val(user.role);
});

$('#userEditModalAjax').on('shown.bs.modal', function(event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let user = button.data('user');

    let modal = $(this);

    modal.find('#userEditIdAjax').val(user.id);
    modal.find('#userEditNameAjax').text(user.name);
    modal.find('#userEditRoleAjax').val(user.role);
});

$('#userDeleteModal').on('shown.bs.modal', function(event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let user = button.data('user');

    let modal = $(this);

    modal.find('#userDeleteId').val(user.id);
    modal.find('#userDeleteName').text(user.name);
});

$('#taskDeleteModal').on('shown.bs.modal', function(event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let task = button.data('board');

    let modal = $(this);

    modal.find('#taskDeleteId').val(task.id);
    modal.find('#taskDeleteName').text(task.name);
});

$('#taskEditModalAjax').on('shown.bs.modal', function(event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let task = button.data('board');

    let modal = $(this);

   
    modal.find('#taskEditNameAjax').val(task.name);
    modal.find('#taskEditIdAjax').val(task.id);
    modal.find('#taskEditDescriptionAjax').val(task.description);
    modal.find('#taskEditAssignmentAjax').val(task.assignment);
    modal.find('#taskEditStatusAjax').val(task.status);
    modal.find('#taskEditCreatedAjax').val(task.created_at);
   

    
});


$('#boardEditModal').on('shown.bs.modal', function(event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let board = button.data('board');
    let modal = $(this);


     modal.find('#boardEditId').val(board.id);
     modal.find('#NumeEditBoard').val(board.name);
     modal.find('#addUser').val(board.user.id);

     modal.find('#boardEditName').text(board.name);


     
//preluare  id 
     modal.find('#userID').val(board.user.id); 

 
     
   
});

$('#boardDeleteModal').on('shown.bs.modal', function(event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let board = button.data('board');

    let modal = $(this);

    modal.find('#boardDeleteId').val(board.id);
    modal.find('#boardDeleteName').text(board.name);
});
/**
 * Update user using ajax
 */
$(document).ready(function() {
    $('#userEditButtonAjax').on('click', function() {
        $('#userEditAlert').addClass('hidden');

        let id = $('#userEditIdAjax').val();
        let role = $('#userEditRoleAjax').val(); 

        $.ajax({
            method: 'POST',
            url: '/user-update/' + id,
            data: {role: role}
        }).done(function(response) {
            if (response.error !== '') {
                $('#userEditAlert').text(response.error).removeClass('hidden');
            } else {
                window.location.reload();
            }
        });
    });

    $('#userDeleteButton').on('click', function() {
        $('#userDeleteAlert').addClass('hidden');
        let id = $('#userDeleteId').val();

        $.ajax({
            method: 'POST',
            url: '/user/delete/' + id
        }).done(function(response) {
            if (response.error !== '') {
                $('#userDeleteAlert').text(response.error).removeClass('hidden');
            } else {
                window.location.reload();
            }
        });
    });

    $('#changeBoard').on('change', function() {
        let id = $(this).val();

        window.location.href = '/board/' + id;
    });

   

   
});

$(document).ready(function() {
    $('#taskEditButtonAjax').on('click', function() {
        $('#taskEditAlert').addClass('hidden');

        let id = $('#taskEditIdAjax').val();
        let name = $('#taskEditNameAjax').val(); 
        let description = $('#taskEditDescriptionAjax').val(); 
        let assignment = $('#taskEditAssignmentAjax').val();
        let status = $('#taskEditStatusAjax').val();
        let created_at = $('#taskEditCreatedAjax').val();
       // console.log(description);
        $.ajax({
            method: 'POST',
            url: '/update-task/' + id ,
            data: {name: name,
                description:description,
                assignment:assignment,
                status:status,
                created_at:created_at
            }
        }).done(function(response) {
            if (response.error !== '') {
                $('#taskEditAlert').text(response.error).removeClass('hidden');
            } else {
                window.location.reload();
            }
        });
    });
    
    $('#taskDeleteButton').on('click', function() {
        $('#taskDeleteAlert').addClass('hidden');
        let id = $('#taskDeleteId').val();

       

        $.ajax({
            method: 'POST',
            url: '/task-delete/' + id
        }).done(function(response) {
            if (response.error !== '') {
                $('#taskDeleteAlert').text(response.error).removeClass('hidden');
            } else {
                window.location.reload();
            }
        });
    });

});


$(document).ready(function() {
    $('#boardEditButton').on('click', function() {
        $('#boardEditAlert').addClass('hidden');

        let id = $('#boardEditId').val();
        let name = $('#NumeEditBoard').val();
        let IdUserCreator= $('#userID').val();
       

        //  console.log(IdUserCreator);
        // console.log(id);
        // console.log(name);

    
         $.ajax({
             method: 'POST',
             url: '/board/update/'+id,
             data: {
                IdUserCreator:IdUserCreator,
                 name:name
               
             }
         }).done(function(response) {
             if (response.error !== '') {
                 $('#boardEditAlert').text(response.error).removeClass('hidden');
             } else {
                 window.location.reload();
             }
         
                   
         });
    });

    $('#boardDeleteButton').on('click', function() {
        $('#boardDeleteAlert').addClass('hidden');
        let id = $('#boardDeleteId').val();

        $.ajax({
            method: 'POST',
            url: '/delete/' + id
        }).done(function(response) {
            if (response.error !== '') {
                $('#boardDeleteAlert').text(response.error).removeClass('hidden');
            } else {
                window.location.reload();
            }
        });
    });

    });

  
    



   


