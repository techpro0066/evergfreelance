<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            background-color: #eeeeee;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .email-wrapper {
            max-width: 600px;
            background: #ffffff;
            margin: 40px auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .logo {
            text-align: center;
            padding: 24px;
        }

        .logo img {
            max-width: 160px;
            /* Adjust logo size here */
            width: 40%;
            height: auto;
        }

        .heading {
            text-align: center;
            font-size: 22px;
            font-family: "Times New Roman", Times, serif;
            color: rgb(102, 118, 107);
            margin-top: -10px;
            /* Slight overlap adjustment */
            margin-bottom: 20px;
        }

        .content {
            padding: 0 24px;
            text-align: center;
            font-size: 15px;
            color: #444444;
            line-height: 1.5;
        }

        .button-wrapper {
            text-align: center;
            margin: 24px 0;
        }

        .button {
            background: #339CB5;
            color: #ffffff;
            padding: 14px 24px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }

        .link-fallback {
            font-size: 14px;
            color: #666666;
            margin: 20px auto;
            word-break: break-all;
            text-align: center;
        }

        .link-fallback a {
            color: #339CB5;
            text-decoration: underline;
        }

        .footer {
            background: #505F3B;
            color: #ffffff;
            text-align: center;
            padding: 14px;
            font-size: 12px;
            border-top: 3px solid #839454;
        }

        @media screen and (max-width: 600px) {
            .email-wrapper {
                margin: 20px;
            }

            .content {
                padding: 0 16px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper"><!-- Logo -->
        <div class="logo"><img src="{{asset('front/assets/images/logo.png')}}" alt="Company Logo"></div><!-- Heading -->
        <div class="heading"><strong>EverGreen <span style="color: #427e8e;">Freelancing</span></strong></div><!-- Text -->
        <div class="content">We received a request to reset your password. If you didn&rsquo;t make this request, you can safely ignore this email. Otherwise, click the button below to set a new password.</div><!-- Button -->
        <div class="button-wrapper"><a href="{{ $resetUrl }}" class="button">Reset Password</a></div><!-- Fallback link -->
        <div class="link-fallback">If the button doesn&rsquo;t work, copy and paste this link into your browser:<br><div style="margin-left:4rem; margin-right:4rem;"><a href="{{ $resetUrl }}">{{ $resetUrl }}</a></div></div><!-- Footer -->
        <div class="footer">&copy; {{date('Y')}} EverGreen Freelancing. All rights reserved.</div>
    </div>
</body>

</html>