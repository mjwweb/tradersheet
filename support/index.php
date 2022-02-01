    <?php
        require '../Includes/dbh.inc.php';
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Tradersheet Support</title>
        <link rel="icon" type="image/png" href="../icons/favicon.png"/>
        <meta charset="utf-8">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <link rel="stylesheet/less" type="text/css" href="support.less">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;700&display=swap" rel="stylesheet">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js" ></script>
        <script src="https://kit.fontawesome.com/1eb8c39439.js" crossorigin="anonymous"></script>

    </head>
    <body style="font-family: 'Roboto', sans-serif; background: #000;">

    <div class="supportWrap">
        <h1>Contact Us</h1>
        <p class="supportMsg">Feel free to contact us to report a bug or submit a request.</p>
        <div class="supportForm">
            <input type="text" class="supportInput supportField supportName" placeholder="Your Name" />
            <input type="email" class="supportInput supportField supportEmail" placeholder="Your Email" />
            <textarea class="supportField supportUserMsg" placeholder="Leave us a message" rows="8"></textarea>
            <button class="supportSubmitBtn">Submit</button>
        </div>
    </div>

    <div class="successMsgWrap">
        <p class="successMsg">Message sent successfully. We'll be in contact shortly.</p>
        <button onclick="history.back()" class="backBtn">Back</button>
    </div>

    <script>

        $(document).ready(function(){
            $('.supportSubmitBtn').click(function(){
                formErrs = false;
                $('.supportField').each(function(){
                    val = $(this).val().trim();

                    if (val == '') {
                        $(this).addClass('emptyInputErr');
                        formErrs = true;
                    }
                });

                if (formErrs == false) {
                    name = $('.supportName').val();
                    email = $('.supportEmail').val();
                    msg = $('.supportUserMsg').val();

                    $.ajax({
                        type: 'POST',
                        url: 'submitRequest.inc.php',
                        data: {name: name, email: email, msg: msg},
                        success: function() {
                            $('.supportWrap').hide();
                            $('.successMsgWrap').show();
                        }
                    });
                }
            });
        });

        $(document).ready(function(){
            $('.supportField').keypress(function(){
                $(this).removeClass('emptyInputErr');
            });
        });

    </script>