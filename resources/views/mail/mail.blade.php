<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Capital Office</title>

    <link rel="icon" type="image/png" href="favicon.ico">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">

    <style type="text/css">
        body { font-family: 'Roboto', sans-serif; line-height: 1.2 }
        .capital-wrap{ background: #f2f2f2;font-size: 14px; color: #111 }
        .capital-wrap a{color:#226cab !important;}
        .capital-wrap a:link,.capital-wrap a:visited {color: rgb(16,177,198) !important;}
        @media only screen and (max-width: 720px) 
        {
            table {
                width: 100% !important;margin: 0px !important;
            }
            
            table p {text-align: left!important;}
        }
        
        @media only screen and (max-width: 480px) {
            body,table,td,p,a,li,blockquote {
                -webkit-text-size-adjust: none !important;
            }
            table {
                width: 380px !important;margin: 0px !important;margin-top:10px !important;
            }
            table p {
                text-align: left !important;
            }
            .responsive-image img {
                height: auto !important;max-width: 100% !important;width: 100% !important;
            }
        }
	</style>
</head>
<body class="capital-wrap">

    <table width=640 cellpadding=15 cellspacing="0" style="background-color: #fff; margin: 30px auto 0">
	    <tr>
			<td>               

                <img src="http://admin.capital-office.co.uk/images/2021-logo.png" alt="Capital Office Logo" style="margin: 15px;">
          
            </td>
        </tr>

    </table>

    <hr style="height: 5px; background-color: #d30d5f; margin: 0; border: none;" />

    <table width=640 cellpadding=15 cellspacing="0" style="background-color: #fff; margin: 0 auto 50px">

        <tr>
            <td>
                {!! $content !!}
            </td>
        </tr>

        <tr>
            <td>                

                    <p style="line-height:1.2">Copyright Protected. <a style="text-decoration: underline; color: #f91d40" href="https://yourvirtualofficelondon.co.uk" target="_blank">Capital Office Ltd.</a> All rights reserved.</p>

                    <p>A company registered in England and Wales Company Number: 6294297</p>

                    <p>124 City Road, London, EC1V 2NX</p>

                    <p style="line-height:1.3">This message (and any associated files) is intended only for the use of the individual or entity to which it is addressed and may contain information that is confidential, subject to copyright or constitutes a trade secret. If you are not the intended recipient you are hereby notified that any dissemination, copying or distribution of this message, or files associated with this message, is strictly prohibited. If you have received this message in error, please notify us immediately by replying to the message and deleting it from your computer. Messages sent to and from us may be monitored.</p>

                    <p style="line-height:1.3">Internet communications cannot be guaranteed to be secure or error-free as information could be intercepted, corrupted, lost, destroyed, arrive late or incomplete, or contain viruses. Therefore, we do not accept responsibility for any errors or omissions that are present in this message, or any attachment, that have arisen as a result of e-mail transmission. If verification is required, please request a hard-copy version. Any views or opinions presented are solely those of the author and do not necessarily represent those of the company.</p>                
        
            </td>
        </tr>

    </table>

</body>
</html>

