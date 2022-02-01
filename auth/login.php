
    <div class="userAuthPage">
        <div class="userAuthWrap">
            <img class="userAuthLogo" src="../logo_variants/dtlLogo.png" />
            <div class="userAuthForm">
                <div class="userAuthLogin">
                    <p class="userAuthHdr">Sign In</p>
                    <label>Email<input class="loginEmail loginInpt" type="email" /></label>
                    <label>Password<input type="password" class="loginPwd loginInpt" /></label>
                    <p class="authErrMsg"></p>
                    <button class="loginSubmit">Login</button>

                    <p class="authAltMsg">Don't have an account?</p>
                    <p class="authTog">New Account</p>
                </div>
            </div>
        </div>
    </div>

    <script>

        var local = false;

        if (location.hostname === "localhost" || location.hostname === "127.0.0.1") {
            local = true;
        }

        $(document).keypress(function(e){
            if (e.keyCode == '13') {
                $('.loginSubmit').trigger('click');
            }
        });

        $(document).ready(function(){
            $('.loginInpt').change(function(){
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('emptyLoginInpt');
                }
            });
        });

        $(document).ready(function(){
            $('.loginSubmit').click(function(){
                validForm = true;

                email = $('.loginEmail').val().trim();
                pwd = $('.loginPwd').val().trim();

                $('.loginInpt').removeClass('emptyLoginInpt');
                $('.loginInpt').each(function(){
                    val = $(this).val().trim();

                    if (val == '') {
                        validForm = false;
                        $(this).addClass('emptyLoginInpt');
                    }
                });

                if (validForm == true) {
                    $.ajax({
                        type: 'POST',
                        url: '../Includes/loginuser.inc.php',
                        data: {email: email, pwd: pwd},
                        success: function(r) {
                            if ($.trim(r) == 1) {
                                if (local == true) {
                                    window.location.href = 'http://localhost/tradersheet';
                                } else {
                                    window.location.href = 'https://www.mike-worden.com/tradersheet';
                                }
                            } else {
                                alert(r);
                            }
                        }
                    });
                }

            });
        });

        $(document).ready(function(){
            $('.authTog').click(function(){
                window.location.href = '?register';
            });
        });

    </script>