// Toggle between Sign Up / Sign In
function changeView() {
    var signUpBox = document.getElementById("signUpBox");
    var signInBox = document.getElementById("signInBox");

    signUpBox.classList.toggle("d-none");
    signInBox.classList.toggle("d-none");
}

// Sign Up function
function signUp() {
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var mobile = document.getElementById("mobile").value;
    var gender = document.getElementById("gender").value;
    var institution = document.getElementById("institution").value;

    var f = new FormData();
    f.append("f", fname);
    f.append("l", lname);
    f.append("e", email);
    f.append("p", password);
    f.append("m", mobile);
    f.append("g", gender);
    f.append("i", institution);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                Swal.fire({
                    title: "Success",
                    text: "Registration successful! Please sign in.",
                    icon: "success"
                }).then(() => {
                    changeView();
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error"
                });
            }
        }
    };

    request.open("POST", "process/signUpProcess.php", true);
    request.send(f);
}

// Sign In function
function signIn() {
    var rememberMe = document.getElementById("rememberMe").checked;
    var email = document.getElementById("email2").value;
    var password = document.getElementById("password2").value;

    var f = new FormData();
    f.append("e", email);
    f.append("p", password);
    f.append("r", rememberMe);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                Swal.fire({
                    title: "Success",
                    text: "Login successful!",
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location = "home.php";
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error"
                });
            }
        }
    };

    request.open("POST", "process/signInProcess.php", true);
    request.send(f);
}

// Sign Out function
function signOut() {
    Swal.fire({
        title: "Sign Out",
        text: "Are you sure you want to sign out?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#f06292",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, Sign Out"
    }).then((result) => {
        if (result.isConfirmed) {
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var response = request.responseText.trim();

                    if (response == "success") {
                        window.location = "index.php";
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response,
                            icon: "error"
                        });
                    }
                }
            };

            request.open("POST", "process/signOutProcess.php", true);
            request.send();
        }
    });
}


var forgotPasswordModal;

function forgotPassword() {
    var email = document.getElementById("email2").value.trim();

    if (email === "") {
        Swal.fire({
            title: "Email Required",
            text: "Please enter your email in the Sign In box first to receive a verification code.",
            icon: "warning",
            confirmButtonColor: "#ec407a"
        });
        return;
    }

    var f = new FormData();
    f.append("e", email);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            var response = request.responseText.trim();

            if (response === "success") {
                Swal.fire({
                    title: "Verification Code Sent",
                    text: "We have sent the verification code to your email.",
                    icon: "success",
                    confirmButtonColor: "#ec407a"
                }).then(() => {
                    var modalElement = document.getElementById("fpmodal");
                    forgotPasswordModal = bootstrap.Modal.getOrCreateInstance(modalElement);
                    forgotPasswordModal.show();
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error",
                    confirmButtonColor: "#ec407a"
                });
            }
        }
    };

    request.open("POST", "process/forgotPasswordProcess.php", true);
    request.send(f);

}

function showpassword1() {
    var text = document.getElementById("np");
    var btn = document.getElementById("npb");

    if (text.type === "password") {
        text.type = "text";
        btn.innerHTML = "Hide";
    } else {
        text.type = "password";
        btn.innerHTML = "Show";
    }
}



function showpassword2() {
    var text = document.getElementById("rnp");
    var btn = document.getElementById("rnpb");

    if (text.type === "password") {
        text.type = "text";
        btn.innerHTML = "Hide";
    } else {
        text.type = "password";
        btn.innerHTML = "Show";
    }
}

function resetPassword() {
    var email = document.getElementById("email2").value;
    var nPassword = document.getElementById("np").value;
    var rnPassword = document.getElementById("rnp").value;
    var vcode = document.getElementById("vcode").value;

    var f = new FormData();
    f.append("e", email);
    f.append("n", nPassword);
    f.append("r", rnPassword);
    f.append("c", vcode);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            var response = request.responseText.trim();

            if (response === "success") {
                Swal.fire({
                    title: "Password Reset Success",
                    text: "Your password has been reset successfully. Please sign in with your new password.",
                    icon: "success",
                    confirmButtonColor: "#ec407a"
                }).then(() => {
                    if (forgotPasswordModal) {
                        forgotPasswordModal.hide();
                    }
                    window.location = "index.php";
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error",
                    confirmButtonColor: "#ec407a"
                });
            }
        }
    };

    request.open("POST", "process/resetPasswordProcess.php", true);
    request.send(f);
}


// Toggle Admin Sign In / Sign Up
function changeAdminView() {
    var adminSignInBox = document.getElementById("adminSignInBox");
    var adminSignUpBox = document.getElementById("adminSignUpBox");

    if (adminSignInBox && adminSignUpBox) {
        adminSignInBox.classList.toggle("d-none");
        adminSignUpBox.classList.toggle("d-none");
    }
}

// Admin Sign In
function adminSignIn() {
    var email = document.getElementById("adminEmail").value.trim();
    var password = document.getElementById("adminPassword").value;
    var rememberMe = document.getElementById("adminRememberMe").checked;

    if (email === "") {
        Swal.fire({
            title: "Error",
            text: "Please Enter Your Email",
            icon: "error"
        });
        return;
    }

    if (password === "") {
        Swal.fire({
            title: "Error",
            text: "Please Enter Your Password",
            icon: "error"
        });
        return;
    }

    var f = new FormData();
    f.append("e", email);
    f.append("p", password);
    f.append("r", rememberMe);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                Swal.fire({
                    title: "Welcome Admin",
                    text: "Authentication successful!",
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location = "adminPanel.php";
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error",
                    confirmButtonColor: "#ec407a"
                });
            }
        }
    };

    request.open("POST", "process/adminSignInProcess.php", true);
    request.send(f);
}


// Add Announcement (admin)
function addAnnouncement() {
    var title = document.getElementById("title").value;
    var desc = document.getElementById("description").value;
    var date = document.getElementById("event_date").value;

    var f = new FormData();
    f.append("t", title);
    f.append("desc", desc);
    f.append("date", date);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                Swal.fire({
                    title: "Success",
                    text: "Announcement added successfully.",
                    icon: "success"
                }).then(() => {
                    window.location = "announcements.php";
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error"
                });
            }
        }
    };

    request.open("POST", "process/addAnnouncementProcess.php", true);
    request.send(f);
}

// Add Event (admin)
function addEvent() {
    var title = document.getElementById("title").value;
    var description = document.getElementById("description").value;
    var category = document.getElementById("category").value;
    var location = document.getElementById("location").value;
    var event_date = document.getElementById("event_date").value;
    var capacity = document.getElementById("capacity").value;
    var eventimage = document.getElementById("eventimage").files[0];

    var f = new FormData();
    f.append("title", title);
    f.append("description", description);
    f.append("category", category);
    f.append("location", location);
    f.append("event_date", event_date);
    f.append("capacity", capacity);

    if (eventimage) {
        f.append("eventimage", eventimage);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                Swal.fire({
                    title: "Success",
                    text: "Event added successfully.",
                    icon: "success"
                }).then(() => {
                    window.location = "manageEvents.php";
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error"
                });
            }
        }
    };

    request.open("POST", "process/addEventProcess.php", true);
    request.send(f);
}

// Update Event (admin)
function updateEvent() {
    var id = document.getElementById("event_id").value;
    var title = document.getElementById("title").value;
    var description = document.getElementById("description").value;
    var category = document.getElementById("category").value;
    var location = document.getElementById("location").value;
    var event_date = document.getElementById("event_date").value;
    var capacity = document.getElementById("capacity").value;
    var status = document.getElementById("status").value;
    var eventimage = document.getElementById("eventimage").files[0];

    var f = new FormData();
    f.append("id", id);
    f.append("title", title);
    f.append("description", description);
    f.append("category", category);
    f.append("location", location);
    f.append("event_date", event_date);
    f.append("capacity", capacity);
    f.append("status", status);

    if (eventimage) {
        f.append("eventimage", eventimage);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                Swal.fire({
                    title: "Success",
                    text: "Event updated successfully.",
                    icon: "success"
                }).then(() => {
                    window.location = "manageEvents.php";
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error"
                });
            }
        }
    };

    request.open("POST", "process/updateEventProcess.php", true);
    request.send(f);
}

// Delete Event (admin)
function deleteEvent(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you really want to delete this event?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            var f = new FormData();
            f.append("id", id);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var response = request.responseText.trim();

                    if (response == "success") {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Event has been deleted.",
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response,
                            icon: "error"
                        });
                    }
                }
            };

            request.open("POST", "process/deleteEventProcess.php", true);
            request.send(f);
        }
    });
}

// Register for an event
function registerEvent() {
    var eventId = document.getElementById("eventId").value;
    var userId = document.getElementById("userId").value;
    var name = document.getElementById("rfullname").value;
    var email = document.getElementById("remail").value;
    var mobile = document.getElementById("rmobile").value;
    var note = document.getElementById("rnote").value;

    var f = new FormData();
    f.append("ev", eventId);
    f.append("u", userId);
    f.append("n", name);
    f.append("e", email);
    f.append("m", mobile);
    f.append("no", note);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                Swal.fire({
                    title: "Success",
                    text: "Registration successful! See you at the event.",
                    icon: "success"
                }).then(() => {
                    window.location = "myRegistrations.php";
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error"
                });
            }
        }
    };

    request.open("POST", "process/registerEventProcess.php", true);
    request.send(f);
}

// Cancel a registration
function cancelRegistration(id) {
    Swal.fire({
        title: "Cancel Registration?",
        text: "Do you really want to cancel this registration?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, cancel it!"
    }).then((result) => {
        if (result.isConfirmed) {
            var f = new FormData();
            f.append("id", id);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var response = request.responseText.trim();

                    if (response == "success") {
                        Swal.fire({
                            title: "Cancelled",
                            text: "Registration has been cancelled.",
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response,
                            icon: "error"
                        });
                    }
                }
            };

            request.open("POST", "process/cancelRegistrationProcess.php", true);
            request.send(f);
        }
    });
}

// Mark attendance (admin)
function markAttendance(id) {
    Swal.fire({
        title: "Mark Attendance",
        text: "Mark this student as attended?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#ffca28",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, Mark Attended"
    }).then((result) => {
        if (result.isConfirmed) {
            var f = new FormData();
            f.append("id", id);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var response = request.responseText.trim();

                    if (response == "success") {
                        Swal.fire({
                            title: "Success",
                            text: "Attendance marked successfully.",
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response,
                            icon: "error"
                        });
                    }
                }
            };

            request.open("POST", "process/markAttendanceProcess.php", true);
            request.send(f);
        }
    });
}

// Activate or deactivate a student (admin)
function changeUserStatus(id) {
    Swal.fire({
        title: "Change Status",
        text: "Are you sure you want to change this student's account status?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f06292",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, Change Status"
    }).then((result) => {
        if (result.isConfirmed) {
            var f = new FormData();
            f.append("id", id);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var response = request.responseText.trim();

                    if (response == "success") {
                        Swal.fire({
                            title: "Success",
                            text: "Student status has been changed.",
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response,
                            icon: "error"
                        });
                    }
                }
            };

            request.open("POST", "process/changeUserStatusProcess.php", true);
            request.send(f);
        }
    });
}

// Update Profile
function updateProfile() {
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var mobile = document.getElementById("mobile").value;
    var institution = document.getElementById("institution").value;
    var bio = document.getElementById("bio").value;
    var profileimage = document.getElementById("profileimage").files[0];

    var f = new FormData();
    f.append("fname", fname);
    f.append("lname", lname);
    f.append("mobile", mobile);
    f.append("institution", institution);
    f.append("bio", bio);

    if (profileimage) {
        f.append("profileimage", profileimage);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                Swal.fire({
                    title: "Success",
                    text: "Profile updated successfully.",
                    icon: "success"
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error"
                });
            }
        }
    };

    request.open("POST", "process/updateProfileProcess.php", true);
    request.send(f);
}

// Upload Media to Gallery
function uploadMedia() {
    var event = document.getElementById("gallery_event").value;
    var caption = document.getElementById("gallery_caption").value;
    var mediafile = document.getElementById("gallery_mediafile").files[0];

    var f = new FormData();
    f.append("event", event);
    f.append("caption", caption);

    if (mediafile) {
        f.append("mediafile", mediafile);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                Swal.fire({
                    title: "Success",
                    text: "Photo uploaded successfully.",
                    icon: "success"
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error"
                });
            }
        }
    };

    request.open("POST", "process/uploadMediaProcess.php", true);
    request.send(f);
}

// Send a contact message
function sendMessage() {
    var name = document.getElementById("cname").value;
    var email = document.getElementById("cemail").value;
    var subject = document.getElementById("csubject").value;
    var message = document.getElementById("cmessage").value;

    var f = new FormData();
    f.append("n", name);
    f.append("e", email);
    f.append("s", subject);
    f.append("m", message);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText.trim();

            if (response == "success") {
                Swal.fire({
                    title: "Success",
                    text: "Your message was sent! We will reply soon.",
                    icon: "success"
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: response,
                    icon: "error"
                });
            }
        }
    };

    request.open("POST", "process/contactProcess.php", true);
    request.send(f);
}

// Preview the selected profile picture before uploading
function changeProfileImg() {
    var input = document.getElementById("profileimage");
    var file = input.files[0];

    if (file) {
        var url = window.URL.createObjectURL(file);
        document.getElementById("img").src = url;
    }
}