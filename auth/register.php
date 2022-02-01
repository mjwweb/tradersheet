    
    <div class="userAuthPage">
        <div class="userAuthWrap">
            <img class="userAuthLogo" src="../logo_variants/dtlLogo.png" />
            <div class="userAuthForm">
                <div class="userAuthRegister">
                    <p class="userAuthHdr">New Account</p>
                    <label>Email<input class="registerEmail registerInpt" type="email" /></label>
                    <label>Password<input type="password" class="registerPwd registerInpt" /></label>
                    <label>Verify Password<input type="password" class="registerPwdRpt registerInpt" /></label>
                    <button class="registerSubmit">Create Account</button>
                    <p class="authAltMsg">Already have an account?</p>
                    <p class="authTog">Sign In</p>
                </div>
            </div>

            <p style="font-size: 12px;" class="authAltMsg">By registering you have read and
                                         agreed to our<br> <a href="https://www.mike-worden.com/tradersheet/terms">terms of use</a>
                                            and <a href="https://www.mike-worden.com/tradersheet/privacy">privacy policy</a></p>

        </div>
    </div>

    <script>

        var local = false;

        if (location.hostname === "localhost" || location.hostname === "127.0.0.1") {
            local = true;
        }

        $(document).keypress(function(e){
            if (e.keyCode == '13') {
                $('.registerSubmit').trigger('click');
            }
        });

        $(document).ready(function(){
            $('.registerInpt').change(function(){
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('emptyRegisterInpt');
                }
            });
        });

        $(document).ready(function(){
            $('.registerSubmit').click(function(){
                validForm = true;

                email = $('.registerEmail').val().trim();
                pwd = $('.registerPwd').val().trim();
                pwdRpt = $('.registerPwdRpt').val().trim();

                if (validateEmail(email)) {

                    $('.registerInpt').removeClass('.emptyRegisterInpt');
                    $('.registerInpt').each(function(){
                        val = $(this).val().trim();

                        if (val == '') {
                            validForm = false;
                            $(this).addClass('emptyRegisterInpt');
                        }
                    });

                    if (pwd !== pwdRpt) {
                        validForm = false;
                        alert('passwords do not match');
                    }

                    if (validForm == true) {
                        $.ajax({
                            type: 'POST',
                            url: '../Includes/registeruser.inc.php',
                            data: {email: email, pwd: pwd},
                            success: function(r) {
                                if ($.trim(r) == 1) {
                                    if (local == true) {
                                        window.location.href = 'http://localhost/tradersheet';
                                    }else {
                                        window.location.href = 'https://www.mike-worden.com/tradersheet';
                                    }
                                } else {
                                    alert(r);
                                }
                            }
                        });
                    }

                } else {
                    alert('Invalid email address');
                }

            });
        });

        function validateEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

        $(document).ready(function(){
            $('.authTog').click(function(){
                window.location.href = '?login';
            });
        });

    </script>