<?php
include "config/connection.php";
include "includes/header.php";
?>

<div class="container py-4">
    <div class="row g-4">

        <div class="col-12 text-center text-lg-start mb-2">
            <h1 class="title01 mb-1">Help & Contact</h1>
            <p class="text-muted fs-6">Have questions or feedback? We're here to assist you!</p>
        </div>

        <div class="col-12 col-lg-7">
            <div class="soft-card p-4">
                <h2 class="title02 mb-3">Send Us A Message</h2>

                <div class="row g-3">

                    <div class="col-12 d-none" id="msgdiv3">
                        <div class="alert alert-danger rounded-3" role="alert" id="msg3"></div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="cname" placeholder="ex: Dewmini Aloka">
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="cemail" placeholder="ex: dewmini@student.lk">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" id="csubject" placeholder="ex: Question about a workshop">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" id="cmessage" rows="5" placeholder="Type your message here..."></textarea>
                    </div>

                    <div class="col-12 col-lg-5 d-grid mt-4">
                        <button class="btn btn-pink py-2 fw-bold" onclick="sendMessage();">Send Message</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="soft-card p-4 h-100">
                <h2 class="title02 mb-3">CampusHub Office</h2>
                
                <div class="bg-white p-3 rounded-4 border mb-3">
                    <h3 class="title03 mb-2">Student Services Division</h3>
                    <p class="text-secondary mb-0">
                        No 45, Campus Road, Colombo 07<br>
                        Sri Lanka
                    </p>
                </div>

                <div class="bg-white p-3 rounded-4 border">
                    <h3 class="title03 mb-2">Contact Details</h3>
                    <p class="text-secondary mb-2">
                        <b>Email:</b> info@campushub.lk
                    </p>
                    <p class="text-secondary mb-2">
                        <b>Phone:</b> 011 2 345 678
                    </p>
                    <p class="text-secondary mb-0">
                        <b>Working Hours:</b> Monday to Friday, 9:00 AM - 5:00 PM
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
include "includes/footer.php";
?>
