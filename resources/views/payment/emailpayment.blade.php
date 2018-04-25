

<html lang="en-US">
<head>
    <meta charset="text/html">
</head>
<body>

<div style="width:500px; margin:0 auto;">
    <table style="border-collapse: collapse; border-spacing: 0; color: #4d4d4d; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; font-weight: normal; height: 100%; line-height: 19px; margin: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
        <tbody>
        <tr style="padding: 0; text-align: left; vertical-align: top;">
            <td  align="center" valign="top" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse; color: #4d4d4d; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 19px; margin: 0; padding: 0; text-align: center; vertical-align: top; word-break: break-word;">
                <center style="width: 100%;">
                    <!-- Email Content -->
                    <!--[if (gte mso 9)|(IE)]>
                    <table width="560" align="center">
                        <tr>
                            <td>
                    <![endif]-->
                    <!-- Header -->
                    <table style="background-color: #0079BF; border-collapse: collapse; border-spacing: 0; color: #fff; padding: 0; text-align: inherit; vertical-align: top; width: 100%;">
                        <tbody>
                        <tr style="padding: 0; text-align: left; vertical-align: top;">
                            <td style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse; color: #4d4d4d; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 19px; margin: 0; padding: 0; text-align: left; vertical-align: top; word-break: break-word;">
                                <div style="display: block; margin: 0 auto; max-width: 580px; padding: 12px 60px;">
                                    <img height="37" width="122" src="https://monita.vn/images/frontend/logo.png" alt="Monita Logo" title="Monita Logo" style="-ms-interpolation-mode: bicubic; clear: both; display: block; float: none; height: 37px; margin: 0 auto; max-height: 37px; max-width: 122px; outline: none; text-decoration: none; width: 122px;">
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table style="background-color: #F0F0F0; border-collapse: collapse; border-spacing: 0; padding: 0; text-align: inherit; vertical-align: top; width: 100%;">
                        <tbody>
                        <tr style="padding: 0; text-align: left; vertical-align: top;">
                            <td style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse; color: #4d4d4d; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 19px; margin: 0; padding: 16px 0; text-align: left; vertical-align: top; word-break: break-word;">
                                <div  style="display: block; margin: 0 auto; max-width: 580px; padding: 12px 16px;">
                                    <h6 style="color: #4d4d4d; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 20px; font-weight: normal; line-height: 1.3; margin: 0; margin-bottom: 12px; padding: 0; text-align: left; word-break: normal;">
                                        Hello {{$full_name}},
                                    </h6>
                                    <table width="100%"  style="border-collapse: collapse; border-spacing: 0; margin: 12px 0; padding: 0; text-align: left; vertical-align: top;">
                                        <tbody>
                                        <tr style="padding: 0; text-align: left; vertical-align: top;">

                                            <td colspan="2" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse; color: #4d4d4d; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 19px; margin: 0; padding: 0; text-align: left; vertical-align: top; word-break: break-word;">
                                                <p>We have paid for you as bellow:</p>
                                            </td>

                                        </tr>
                                        <tr style="padding: 0; text-align: left; vertical-align: top;padding-bottom: 6px;">
                                            <td colspan="2" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse; color: #4d4d4d; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 19px; margin: 0; padding: 0; text-align: left; vertical-align: top; word-break: break-word;">
                                                <b>Request payment</b>
                                            </td>
                                            <td> {{number_format($pay_money,0)}} VND</td>
                                        </tr>
                                        <tr style="padding: 0; text-align: left; vertical-align: top;padding-bottom: 6px;">
                                            <td colspan="2" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse; color: #4d4d4d; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 19px; margin: 0; padding: 0; text-align: left; vertical-align: top; word-break: break-word;">
                                                <b>Payment via</b>
                                            </td>
                                            <td> {{$payment_type}}</td>
                                        </tr>

                                        <tr style="padding: 0; text-align: left; vertical-align: top;padding-bottom: 6px;">
                                            <td colspan="2" style="-moz-hyphens: auto; -webkit-hyphens: auto; border-collapse: collapse; color: #4d4d4d; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 19px; margin: 0; padding: 0; text-align: left; vertical-align: top; word-break: break-word;">
                                                <b> Current your balance</b>
                                            </td>
                                            <td> {{number_format($balance,0)}} VND</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <h3 style="color: #4d4d4d; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 20px; font-weight: normal; line-height: 1.3; margin: 0; margin-bottom: 12px; padding: 0; text-align: left; word-break: normal;">
                                        Thank you,<br/> Monita
                                    </h3>

                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!-- End gray background -->
                    <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                    <!-- / Email Content --> </defanged_script></defanged_script>
                </center>
            </td>
        </tr>
        </tbody>
    </table>
</div>

</body>
</html>

