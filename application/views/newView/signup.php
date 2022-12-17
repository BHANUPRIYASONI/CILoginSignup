

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
    
    <title>Sign Up</title>
</head>

<body>
    <h1>Sign Up</h1>

    <body>
        <form class="signupForm" method="post" >
            <!--Username-->
            <label for="username">UserName</label><br>
            <input type="text" id="username" name="username"></input>
            <input type="hidden" name="userid" id="userid"> 
            <br>
            <!--Email-->
            <label for="email">Email</label><br>
            <input type="email" id=email name="email"><br>
            <!--Password-->
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" ><br><br>
            <button type="submit" id="submit" name="submit">Signup</button>

        </form>
        <a href="<?php echo base_url() ?>">Login </a>
     
    </body>
    </html>

    <script>
        $(".signupForm").validate({
        rules: {
            username: {
                required: true,
            },
            email: {
                required: true,
                remote: {
                    url: "<?php echo base_url();?>newController",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#email").val();
                        }
                    }
                },
            },
            password: {
                required: true,
            },
        },
        messages: {
            username: {
                required: "Please Enter User Name ",
            },
            email: {
                required: "Please Enter Your Email",
                remote: "This email is already exist.",
            },
            password: {
                required: "Please Enter Pincode ",
            },
        },
        submitHandler: function(form) { //console.log(form);
            $.ajax({
                url: "<?php echo base_url();?>userSignup",
                type: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: new FormData($('.signupForm')[0]),
                success: function(response) {
                    //console(response);
                    if (response.status == 200) {
                        $('#submit').html('Signup');
                        $('.signupForm')[0].reset();
                        $('#username').val('');
                        $('#email').val('');
                        $('#userid').val('');
                        $('#password').val('');
                        window.location.href = "<?php echo base_url();?>";
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });

    </script>
    