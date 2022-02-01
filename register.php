    
    <div class="userAuthPage">
        <div class="userAuthWrap">
            <img class="userAuthLogo" src="img/dtlLogo.png" />
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
        </div>
    </div>

    <script>

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
                        url: 'Includes/registeruser.inc.php',
                        data: {email: email, pwd: pwd},
                        success: function(r) {
                            if ($.trim(r) == 1) {
                                url = window.location.href.split('?')[0];
                                window.location.href = url;
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
                window.location.href = '?auth=login';
            });
        });

    </script>