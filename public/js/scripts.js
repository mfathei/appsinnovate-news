const TOKEN = "token";

function setupEvents() {
    $("#my-notes").on("click", ".delete-note", deleteNote);
    $("#my-notes").on("click", ".edit-note", editNote);
    $("#my-notes").on("click", ".update-note", updateNote);
    $(".submit-note").on("click", createNote);
}

// Methods
function login() {
    var data = {
        "email": "admin@test.com",
        "password": "admin1"
    };

    $.ajax({
        url: "http://127.0.0.1:8000/api/auth/login",
        method: 'POST',
        data: data,
        success: (response) => {
            console.log('Congrats');
        },
        error: (error) => {
            console.log("Error can't login");
            console.log(error);
        }
    });
}

function deleteNote(e) {
    var thisNote = $(e.target).parents("li");
    $.ajax({
        beforeSend: (xhr) => {
            xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
        },
        url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data("id"),
        type: 'DELETE',
        success: (response) => {
            thisNote.slideUp();
            if (response.userNotesCount <= 4) {
                $(".note-limit-message").removeClass("active");
            }
            console.log('Congrats');
            console.log(response);
        },
        error: (error) => {
            console.log('Error deleting note');
            console.log(error);
        }
    });
}

function updateNote(e) {
    var thisNote = $(e.target).parents("li");

    var ourUpdatedPost = {
        'title': thisNote.find(".note-title-field").val(),
        'content': thisNote.find(".note-body-field").val()
    };

    $.ajax({
        beforeSend: (xhr) => {
            xhr.setRequestHeader('token', universityData.nonce);
        },
        url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data("id"),
        type: 'POST',
        data: ourUpdatedPost,
        success: (response) => {
            makeNoteReadonly(thisNote);
            console.log('Congrats');
            console.log(response);
        },
        error: (error) => {
            console.log('Error deleting note');
            console.log(error);
        }
    });
}

function createNote(e) {

    var ourNewNote = {
        'title': $(".new-note-title").val(),
        'content': $(".new-note-body").val(),
        'status': 'publish' // or private or 'draft'
    };

    $.ajax({
        beforeSend: (xhr) => {
            xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
        },
        url: universityData.root_url + '/wp-json/wp/v2/note/',
        type: 'POST',
        data: ourNewNote,
        success: (response) => {
            $(".new-note-title, .new-note-body").val('');
            $(`
                <li data-id="${response.id}">
                    <input readonly class="note-title-field" type="text" value="${response.title.raw}">
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
                    <textarea readonly class="note-body-field">${response.content.raw}</textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
                </li>
                `).prependTo("#my-notes").hide().slideDown();

            console.log('Congrats');
            console.log(response);
        },
        error: (error) => {
            if (error.responseText == "You reached the limit for your notes.") {
                $(".note-limit-message").addClass("active");
            }
            console.log('Error deleting note');
            console.log(error);
        }
    });
}

function editNote(e) {
    var thisNote = $(e.target).parents("li");
    if (thisNote.attr("data-state") == "editable") {
        makeNoteReadonly(thisNote);
    } else {
        makeNoteEditable(thisNote);
    }
}

function makeNoteEditable(thisNote) {
    thisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i>Cancel');
    thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly", "readonly").addClass("note-active-field");
    thisNote.find(".update-note").addClass("update-note--visible");
    thisNote.attr("data-state", "editable");
}

function makeNoteReadonly(thisNote) {
    thisNote.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i>Edit');
    thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
    thisNote.find(".update-note").removeClass("update-note--visible");
    thisNote.attr("data-state", "readonly");
}