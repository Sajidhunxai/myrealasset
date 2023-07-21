<?php
if (!is_user_logged_in()) {
    ?>
    <li class="topbar-item login-item">
        <a href="#" class="login" data-bs-toggle="modal" data-bs-target="#st-login-form"><?php echo esc_html__('Login', 'traveler') ?></a>
    </li>

    <li class="topbar-item signup-item">
        <a href="#" class="signup" data-bs-toggle="modal" data-bs-target="#st-register-form"><?php echo esc_html__('Sign Up', 'traveler') ?></a>
    </li>
    <script>
        jQuery(function ($) {
            var startApp = function () {
                var key = st_social_params.google_client_id;
                gapi.load('auth2', function () {
                    auth2 = gapi.auth2.init({
                        client_id: key,
                        cookiepolicy: 'single_host_origin',
                    });
                    attachSignin(document.getElementById('st-google-signin2'));
                    attachSignin(document.getElementById('st-google-signin3'));
                });
            };

            if (typeof window.gapi != 'undefined') {
                startApp();
            }

            function attachSignin(element) {
                auth2.attachClickHandler(element, {},
                        function (googleUser) {
                            var profile = googleUser.getBasicProfile();
                            startLoginWithGoogle(profile);

                        }, function (error) {
                    console.log(JSON.stringify(error, undefined, 2));
                });
            }

            function startLoginWithGoogle(profile) {
                if (typeof window.gapi.auth2 == 'undefined')
                    return;
                sendLoginData({
                    'channel': 'google',
                    'userid': profile.getId(),
                    'username': profile.getName(),
                    'useremail': profile.getEmail(),
                });
            }

            function startLoginWithFacebook(btn) {
                btn.addClass('loading');

                FB.getLoginStatus(function (response) {
                    if (response.status === 'connected') {
                        sendLoginData({
                            'channel': 'facebook',
                            'access_token': response.authResponse.accessToken
                        });

                    } else {
                        FB.login(function (response) {
                            if (response.authResponse) {
                                sendLoginData({
                                    'channel': 'facebook',
                                    'access_token': response.authResponse.accessToken
                                });

                            } else {
                                alert('User cancelled login or did not fully authorize.');
                            }
                        }, {
                            scope: 'email',
                            return_scopes: true
                        });
                    }
                });
            }

            function sendLoginData(data) {
                data._s = st_params._s;
                data.action = 'traveler.socialLogin';

                $.ajax({
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    url: st_params.ajax_url,
                    success: function (rs) {
                        handleSocialLoginResult(rs);
                    },
                    error: function (e) {

                        alert('Can not login. Please try again later');
                    }
                })
            }

            function handleSocialLoginResult(rs) {
                if (rs.reload)
                    window.location.reload();
                if (rs.message)
                    alert(rs.message);
            }

            $('.st_login_social_link').on('click', function () {
                var channel = $(this).data('channel');

                switch (channel) {
                    case "facebook":
                        startLoginWithFacebook($(this));
                        break;
                }
            })

            /* Fix social login popup */
            function popupwindow(url, title, w, h) {
                var left = (screen.width / 2) - (w / 2);
                var top = (screen.height / 2) - (h / 2);
                return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            }

            $('.st_login_social_link').on('click', function () {
                var href = $(this).attr('href');
                if ($(this).hasClass('btn_login_tw_link'))
                    popupwindow(href, '', 600, 450);
                return false;
            });
            /* End fix social login popup */
        })
    </script>
    <?php
} else {
    $userdata = wp_get_current_user();
    $account_dashboard = st()->get_option('page_my_account_dashboard');
    ?>
    <li class="dropdown dropdown-user-dashboard">
        <?php
        if (!empty($in_header)) {
            echo st_get_profile_avatar($userdata->ID, 40);
        }
        ?>
        <a href="#" class="dropdown-toggle"  role="button" id="dropdown-dashboard" data-bs-toggle="dropdown" aria-expanded="false">
               <?php echo __('Hi, ', 'traveler') . TravelHelper::get_username($userdata->ID); ?>
            <i class="fa fa-angle-down"></i>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdown-dashboard">
            <li>
                <a href="<?php echo esc_url(get_the_permalink($account_dashboard)) ?>"><?php echo __('Dashboard', 'traveler') ?></a>
            </li>
            <li>
                <a href="<?php echo add_query_arg('sc', 'booking-history', get_the_permalink($account_dashboard)) ?>"><?php echo __('Booking History', 'traveler') ?></a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a href="<?php echo wp_logout_url() ?>"><?php echo __('Log out', 'traveler') ?></a>
            </li>
        </ul>
    </li>
    <?php
}
