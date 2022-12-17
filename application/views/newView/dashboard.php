<!DOCTYPE html>
<html lang="en">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" ></script>
    <style>
    .h1 {
        text-align: center;
        font-size: 100%;
    }

    .h2 {
        text-align: center;
    }

    #show {
        background-color: antiquewhite;
        width: 60%;
        padding-top: 3%;
        margin-left: 37%;
        margin-top: -19%;
        padding-left: 3%;
        padding-right: 3%;
        padding-bottom: 2%;
    }

    #container {
        background-color: antiquewhite;
        width: 32%;
        margin-left: 5px;
        line-height: normal;
    }

    .close {
        padding-left: 3%;
        margin-left: -8px;
    }

    #cross {
        color: red;
        cursor: pointer;
    }

    .alert alert-primary {
        text-align: justify;
    }

    .error {
        color: red;
    }
    
</style>


<head>
    
    <title>Dashboard</title>
</head>
<body>

<h1 class="h2">hello <span class="h1"></span></h1>

<a href="<?php echo base_url() ?>xyz" style="float:right;margin-top: -1%;" class="btn btn-info btn-lg">
            <span class="glyphicon glyphicon-log-out"></span> Log out
</a>

<div>

        <h2 style="text-align: left;">Dynamic Dependency CRUD</h2>
        <form class="dynamic" method="post">
            <div id="container">

                <label for="name">Name</label><br>
                <input type="text" id="name" name="name"><br>
                <input type="hidden" name="userId" id="userId">

                <!-- Country dropdown -->
                <div class="form-group">
                    <label for="country">Country</label>
                    <select id="country" name="country" class="form-control" onchange="getState(this.value);">
                        <option value="">Select Country</option>
                    </select>
                </div>

                <!-- State dropdown -->
                <div class="form-group">
                    <label for="state">State</label>
                    <select id="state" name="state" class="form-control" onchange="getCity(this.value);">
                        <option value="">Select country first</option>

                    </select>
                </div>

                <!-- City dropdown -->
                <div class="form-group">
                    <label for="city">City</label>
                    <select id="city" name="city" class="form-control">
                        <option value="">Select state first</option>

                    </select>
                </div>

                <button id="btn" name="save">Save</button>

            </div>
        </form>
    </div>
    <div class="col-md-8" id="show">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="users-list">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="info">
                
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

<script>

    getName();
    function getName(){
        $.ajax({
                url: "<?php echo base_url();?>getProfile",
                type: 'post',
                dataType: 'json',                
                success: function(response) {
                    //console.log(response);
                    if (response.status == 200) {
                      $('.h1').html(response.userName);    
                    } else {
                        alert(response.message);
                    }
                }
            });
        }

        $(".dynamic").validate({
        rules: {
            name: {
                required: true,
            },
            country: {
                required: true,
            },
            state: {
                required: true,
            },
            city: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please Enter the field ",
            },
            country: {
                required: "Please Enter Country ",
            },
            state: {
                required: "Please Enter State ",
            },
            city: {
                required: "Please Enter City ",
            },
        },
        submitHandler: function(form) {
            $.ajax({
                url: "<?php echo base_url();?>userSignupDashboard",
                type: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: new FormData($('.dynamic')[0]),
                success: function(response) {
                    if (response.status == 200) {
                        $('#btn').html('Save');
                        $('.dynamic')[0].reset();
                        $('.userId').val('');
                        $('#country').val('');
                        $('#state').val('');
                        $('#city').val('');
                        getData();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });

    getData();

    function getData() {
        $.ajax({
            url: "<?php echo base_url();?>getData",
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response.userData);
                //console.log(response.userData.length);
                var main_content = '';
                if (response.userData.length > 0) {
                    $.each(response.userData, function(index, row) {
                        //console.log(row.userName);
                        main_content +=
                            `<tr>
                        <td>` + (++index) + `</td>
                        <td>` + row.userName + `</td>
                        <td>` + row.countryName + `</td>
                        <td>` + row.stateName + `</td>
                        <td>` + row.cityName + `</td>
                        <td>
                        <button type="button" onclick="setUserInfo(` + row.user_id + `);" class="btn btn-info me-2">Edit</button>
                        <button type="button" onclick="removeUserInfo(` + row.user_id + `);" class="btn btn-warning">Delete</button>
                        </td>
                        </tr>`;
                        //console.log(main_content);
                    })
                } else {
                    main_content = `No Data Found!`
                }

                $('#info').html(main_content);
                $('#users-list').DataTable();
            }
        });
    }

    getCountry();

    function getCountry(countryId = '') {
        $.ajax({
            type: 'GET',
            url: "<?php echo base_url();?>getCountry",
            dataType: 'json',
            success: function(response) {
                var html = '<option value="">Select country first</option>';
                //console.log(response);
                if (response.country.length > 0) {
                    $.each(response.country, function(index, row) {
                        var select = '';
                        if (countryId != '' && countryId == row.id) {
                            select = 'selected';
                        }
                        
                        html += `<option `+select+` value="` + row.id + `">` + row.countryName + `</option>`;
                    });
                }
                $('#country').html(html);
            }
        });
    }

    function getState(countryID, stateId = '') {

        if (countryID) {
            $.ajax({
                type: 'GET',
                url: "<?php echo base_url();?>getState",
                dataType: 'json',
                data: 'country_id=' + countryID,
                success: function(response) {
                    var html = '<option value="">Select country first</option>';

                    if (response.state.length > 0) {
                        $.each(response.state, function(index, row) {
                            var select = '';
                            if (stateId != '' && stateId == row.id) {
                                select = 'selected';
                            }
                            html += `<option ` + select + ` value="` + row.id + `">` + row.stateName + `</option>`;
                        })
                    }
                    $('#state').html(html);
                }
            });
        }
    }

    function getCity(stateID, cityId = '') {

        if (stateID) {
            $.ajax({
                type: 'GET',
                url: "<?php echo base_url();?>getCity",
                dataType: 'json',
                data: 'state_id=' + stateID,
                success: function(response) {

                    var html = '<option value="">Select state first</option>';
                    if (response.city.length > 0) {
                        $.each(response.city, function(index, row) {
                            var select = '';
                            if (cityId != '' && cityId == row.id) {
                                select = 'selected';
                            }
                            html += `<option ` + select + ` value="` + row.id + `">` + row.cityName + `</option>`;
                        })
                    }
                    $('#city').html(html);
                }
            });
        }
    }


    function setUserInfo(user_id) {
        $.ajax({
            url: "<?php echo base_url();?>getInfoById",
            type: 'get',
            dataType: 'json',
            data: {
                user_id: user_id
            },
            success: function(response) {
                //console.log(response.userData.userName);
                $('#name').val(response.userData.userName);
                $('#userId').val(response.userData.user_id);
                getCountry(response.userData.country);
                getState(response.userData.country, response.userData.state);
                getCity(response.userData.state, response.userData.city);
                $('#btn').html('Update');
            }
        });
    }

    function removeUserInfo(user_id) {
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "<?php echo base_url();?>deleteData",
                type: 'post',
                dataType: 'json',
                data: {
                    user_id: user_id
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        getData();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    }


</script>