<!doctype html>
<html lang="en">
<?php $current_url = "//" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>

<head>
    <meta charset="UTF-8">
    <title>CodePen - Animated Login Form using Html &amp; CSS Only</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <link rel="stylesheet" href="assets/style.css">
</head>

<body> <!-- partial:index.partial.html -->
    <section>
        <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span>
        <div class="signin">
            <div class="content">
                <h2>Sign In</h2>
                <div class="form">
                    <form action="<?= $current_url ?>/login.php" method="post" id="verification">
                        <div class="inputBox">
                            <input type="text" id="email" name="email" required> <i>Email</i>
                        </div>
                        <p id="email_error"></p>
                        <br>
                        <div class="inputBox">
                            <input type="submit" name="submit" id="submit" value="Login">
                        </div>
                    </form>
                    <div class="otp-blk" id="otp_blk">
                        <form action="<?= $current_url ?>/check_otp.php" method="post" id="check_otp_form">
                            <div class="inputBox">
                                <input type="text" id="otp" name="otp" required> <i>OTP</i>
                            </div>
                            <p id="otp_error"></p>
                            <br>
                            <div class="inputBox">
                                <input type="submit" name="otp_btn" id="otp_btn" value="Verify OTP">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- partial -->
</body>

<script>
    $("#verification").submit(function(e) {
        e.preventDefault();
        $('#email_error').text('');
        var form = $(this);
        var formData = new FormData($(this)[0]);
        var actionUrl = form.attr('action');
        $.ajax({
            type: "POST",
            url: actionUrl,
            dataType: "json",
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data['msg'] == 'Success') {
                    $("#otp_blk").show();
                } else if (data['msg'] == 'Failed') {
                    $('#email_error').text('Email doesn\'t exist')
                }
            }
        });

    });

    $("#check_otp_form").submit(function(e) {
        e.preventDefault();
        $('#otp_error').text('');
        var form = $(this);
        var formData = new FormData($(this)[0]);
        var actionUrl = form.attr('action');
        $.ajax({
            type: "POST",
            url: actionUrl,
            dataType: "json",
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data['msg'] == 'Success') {
                    window.location.replace(data['url']);
                } else if (data['msg'] == 'Failed') {
                    $('#otp_error').text('Invalid OTP')
                }
            }
        });

    });
</script>

</html>