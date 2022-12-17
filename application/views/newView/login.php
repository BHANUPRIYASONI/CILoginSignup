
<!doctype html>
<html lang="en">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <style>
        label.error {
            color: red;
        }
    </style>

<head>
    
    <title>Log in</title>
</head>

<body>
    <h1>Log in</h1>

    <body>
        <form class="loginForm" method="post" >
            <!--Email-->
            <label for="email">Email</label><br>
            <input type="email" id=email name="email"><br>
            <!--Password-->
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password"><br>
            <br><button type="submit" name="submit">login</button>
        </form>
        <a href="<?php echo base_url('signup') ?>">signup</a>
    </body>
    </html>
    <script>
        $(".loginForm").validate({
        rules: {
            email: {
                required: true,
                        },
            password: {
                required: true,
            },
        },
        messages: {
            email: {
                required: "Please Enter Your Email",
            },
            password: {
                required: "Please Enter Password ",
            },
        },
        submitHandler: function(form) { //console.log(form);
            $.ajax({
                url: "<?php echo base_url();?>userLogin",
                type: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: new FormData($('.loginForm')[0]),
                success: function(response) {
                    //console.log(response);
                    if (response.status == 200) {
                        $('#submit').html('Login');
                        $('.loginForm')[0].reset();
                        $('#email').val('');
                        $('#password').val('');
                        window.location.href = "<?php echo base_url('dashboard');?>";
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });

    </script>