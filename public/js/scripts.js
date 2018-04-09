// Variable to store your files
var files;

function setupEvents() {
    $("#my-notes").on("click", ".delete-note", deleteNote);
    $("#my-notes").on("click", ".edit-note", editNote);
    $("#my-notes").on("click", ".update-note", updateNote);
    // $(".submit-note").on("click", createNote);
    $('form').on('submit', uploadFiles);
    // Add events
    $('input[type=file]').on('change', prepareUpload);

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
            setToken(response.access_token);
        },
        error: (error) => {
            console.log("Error can't login");
            console.log(error);
        }
    });
}

function getPosts() {
    var data = {
        "token": getToken()
    };

    $.ajax({
        url: "/api/news",
        method: 'GET',
        data: data,
        success: (response) => {
            console.log('Congrats');
            showPosts(response);
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
            xhr.setRequestHeader('Authorization', 'Bearer ' + getToken());
        },
        url: '/api/post/' + thisNote.data("id"),
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
        'body': thisNote.find(".note-body-field").val(),
    };

    $.ajax({
        beforeSend: (xhr) => {
            xhr.setRequestHeader('Authorization', 'Bearer ' + getToken());
        },
        url: '/api/post/' + thisNote.data("id"),
        type: 'PUT',
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

function showPosts(posts) {
    var list = $("#my-notes");
    $(posts).each(function (key, value) {
        list.append(`
        <li data-id="${value.id}">
            <input readonly class="note-title-field" type="text" value="${value.title}">
            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
            <textarea readonly class="note-body-field">${value.body}</textarea>
            <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
            <a href="/uploads/${value.photo}" target='_blank'>Show photo</a>
        </li>
        `);
    });
}

function getToken() {
    return localStorage.getItem("token");
}

function setToken(token) {
    localStorage.setItem("token", token);
}

// Grab the files and set them to our variable
function prepareUpload(event) {
    files = event.target.files;
    console.log(files);
}

// Catch the form submit and upload the files
function uploadFiles(event) {
    event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening

    // START A LOADING SPINNER HERE

    // Create a formdata object and add the files
    var data = new FormData();
    data.append("token", getToken()); // add token
    $.each(files, function (key, value) {
        data.append(key, value);
    });

    $.ajax({
        url: '/api/post/uploadpostphoto',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function (data, textStatus, jqXHR) {
            if (typeof data.error === 'undefined') {
                // Success so call function to process the form
                submitForm(event, data);
            } else {
                // Handle errors here
                console.log('ERRORS: ' + data.error);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        }
    });
}

function submitForm(event, data) {
    // Create a jQuery object from the form
    $form = $(event.target);

    // Serialize the form data
    var formData = $form.serialize();
    formData = formData + '&token=' + getToken();
    // formData.append("token", getToken());// add token

    // You should sterilise the file names
    $.each(data.files, function (key, value) {
        formData = formData + '&filenames[]=' + value;
    });

    $.ajax({
        url: '/api/post/create',
        type: 'POST',
        data: formData,
        cache: false,
        dataType: 'json',
        success: function (response, textStatus, jqXHR) {
            if (typeof response.error === 'undefined') {
                // Success so call function to process the form
                var value = response.data;
                $(".new-note-title, .new-note-body").val('');
                $(`
                <li data-id="${value.id}">
                    <input readonly class="note-title-field" type="text" value="${value.title}">
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
                    <textarea readonly class="note-body-field">${value.body}</textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
                    <a href="/uploads/${value.photo}"  target='_blank'>Show photo</a>
                </li>
                `).prependTo("#my-notes").hide().slideDown();
            } else {
                // Handle errors here
                console.log('ERRORS: ' + data.error);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
        },
        complete: function () {
            // STOP LOADING SPINNER
        }
    });
}