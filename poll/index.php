<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="assets/js/jquery-latest.min.js"></script>
    <link rel="stylesheet" href="assets/plugins/jqueryConfirm/dist/jquery-confirm.min.css" />
    <link rel="stylesheet" href="assets/plugins/jqueryConfirm/css/jquery-confirm.custom.min.css" />
    <script src="assets/plugins/jqueryConfirm/dist/jquery-confirm.min.js"></script>

    <style>
    .pledge-blk {
        color: #fff;
        background: #074335;
        padding: 50px;
    }
    .pledge-blk select {
        width: calc((80%) - 40px);
        margin-right: 40px;
        float: left;
        border: 3px solid #dbdf36;
        padding: 10px 0px;
        padding-left: 5px;
        color: #fff;
        background: #074335;
        outline: none;
    }

    .pledge-blk #submit-btn {
        width: 20%;
        float: left;
        border: 3px solid #074335;
        padding: 10px 0px;
        color: #074335;
        background: #dbdf36;
        text-transform: uppercase;
        font-weight: bold;
    }

    .pledge-blk h3 {
        font-size: 25px;
        color: #dbdf36;
        text-transform: uppercase;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .w3-border {
        background-color: #dbdf36;
        margin: 0 50px;
    }

    .w3-border .w3-grey {
        background-color: #074335;
    }
    .modal-result h3 {
        font-weight: bold;
        text-align: left;
        margin-left: 50px;
    }
    .modal-result .share {
        font-weight: bold;
        text-align: left;
        margin-left: 50px;
        display: inline-flex;
    }
    .modal-result .share .fb{
        margin-left: 20px;
        margin-right: 20px;
        background: #4267B2;
        color: #fff;
        padding: 10px;
    }
    .modal-result .share .twit{
        background: #000;
        color: #fff;
        padding: 10px;
    }
</style>

</head>
<body>
<div class="pledge-blk clear">
                <h3>I pledge for:</h3>
                <form lass="register_form" action="apps/define.php" method="POST" id="register-form">
                    <select name="pledge" id="pledge">
                        <option value="Reduce the use of plastic">Reduce the use of plastic</option>
                        <option value="Keep the environment clean">Keep the environment clean</option>
                        <option value="Not throwing away waste into outside">Not throwing away waste into outside</option>
                    </select>
                    <input type="submit" value="submit" id="submit-btn">
                </form>
            </div>

<script>
$("#register-form").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData($(this)[0]);
        var actionUrl = form.attr('action');
        $.ajax({
            url: actionUrl,
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            async: false,
            success: function(data) {
                if (!data['error']) {
                    $.confirm({
                        type: 'white',
                        title: '',
                        content: data['message'],
                        boxWidth: '30%',
                        useBootstrap: false,
                    });
                    $('#register-form')[0].reset();
                } else {
                    $.dialog({
                        type: 'red',
                        title: 'Failed',
                        content: data['message'],
                        boxWidth: '30%',
                        useBootstrap: false,
                    });
                }
            },
            error: function(error) {
                $.dialog({
                    type: 'red',
                    title: 'Failed',
                    content: 'Something went wrong',
                    boxWidth: '30%',
                    useBootstrap: false,
                });
            }
        });
    });
</script>
</body>
</html>