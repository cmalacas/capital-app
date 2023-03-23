<html data-wf-page="5cfe4a7d71000abebb554f42" data-wf-site="5cfe4a7c71000aad55554f41" class="w-mod-js wf-poppins-n4-active wf-poppins-n6-active wf-poppins-n7-active wf-active" lang="en"><head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Capital Office | Service Registration</title>
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="Webflow" name="generator">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" />
	
    <link href={{ asset("/registration/css/normalize.css") }} rel="stylesheet" type="text/css">
	<link href={{ asset("/registration/css/webflow.css") }} rel="stylesheet" type="text/css">
	<link href={{ asset("/registration/css/yvol-checkout.webflow.css") }} rel="stylesheet" type="text/css">

    <link href={{ asset("/registration/css/registration.css") }} rel="stylesheet" type="text/css">
	
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:regular,600,700" media="all"><script type="text/javascript">WebFont.load({google: {families: ["Poppins:regular,600,700"]}});</script>
	<!-- [if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
	<script type="text/javascript">!function (o, c)
        {
            var n = c.documentElement, t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
        }(window, document);</script>
	<link href="https://daks2k3a4ib2z.cloudfront.net/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
	<link href="https://daks2k3a4ib2z.cloudfront.net/img/webclip.png" rel="apple-touch-icon">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<!--  End TrustBox script  -->
	<script type="text/javascript" src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async=""></script>
	
     <!-- CSRF Token -->
	 <meta name="csrf-token" content="{{ csrf_token() }}">		

	<!-- Start of LiveChat (www.livechatinc.com) code -->
	<script type="text/javascript">
	window.__lc = window.__lc || {};
	window.__lc.license = 8568503;
	(function() {
	var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
	lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
	})();
	</script>
	<noscript>
	<a href="https://www.livechatinc.com/chat-with/8568503/" rel="nofollow">Chat with us</a>,
	powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a>
	</noscript>
	<!-- End of LiveChat code -->
    
    <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=   'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-WBCHR7M');</script>
    <!-- End Google Tag Manager -->

</head>


<body class="body" cz-shortcut-listen="true" style="">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WBCHR7M"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="top-bar">
	<div class="container top">
		<a href="tel:+442075663939"><strong class="link-phone">+44 (0) 207 566 3939</strong></a><a href="mailto:info@capital-office.co.uk?subject=Enquiry%20from%20payment%20page" class="link"><strong class="link-email">info@capital-office.co.uk</strong></a>
        	</div>
</div>
<div class="header">
	<div class="container">
		<a href="#" class="logo w-inline-block"><img src={{ asset("/registration/img/capital-office-logo-400-white.png") }} alt=""></a></div>
</div>

@yield('hero')
@yield('main')
@yield('addons')
@yield('voiceaddons')
@yield('formationaddons')
@yield('bankaddons')
@yield('officeaddons')

<div class="modal fade" id="dontleaveModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel6" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title text-center" style="margin-left:35%" id="myModalLabel6"><i class="text-danger fa fa-warning"></i> Hey! </h2>
				<button type="button" class="close" data-dismiss="modal">×</button>
			</div>
			<div class="modal-body text-left text-regular text-base font-default" style="background-image: url(/site/img/virtual-office-london_CTA-bg.jp)">
				<p class="text-center">Are you sure you want to leave Capital Office?</p>
			</div>
		</div>
	</div>
</div>

<div class="footer">
	<div class="container">
		<div class="w-row">
			<div class="w-col w-col-5"><img src={{ asset("/registration/img/capital-office-logo-400-white.png") }} alt="" class="logo-footer">
				<p>We are located in the heart of the world's leading business capital.</p>
			</div>
			<div class="w-col w-col-7">
				<h3>Call us: +44 (0) 207 566 3939<br>Email:
					<a href="mailto:info@capital-office.co.uk">info@capital-office.co.uk</a></h3>
				<p>Capital Office , 124 City Road, London EC1V 2NX</p>
			</div>
		</div>
		<div class="w-row">
			<div class="w-clearfix w-col w-col-5">
				<h3>Our Main Services</h3>
				<a href="#" class="footer-link">Registered Office Address</a><a href="#" class="footer-link">London Office Address</a><a href="#" class="footer-link">Directors Address</a><a href="#" class="footer-link">Call Answering Services</a><a href="#" class="footer-link">Company Formations</a><a href="#" class="footer-link">Complete Virtual Office</a><a href="#" class="footer-link">Affordable Business Website Design</a><a href="#" class="footer-link">Meeting Rooms London</a>
			</div>
			<div class="w-col w-col-7">
				<div class="w-row">
					<div class="w-clearfix w-col w-col-6">
						<h3>Office Hours</h3>
						<p>Monday to Friday<br>09.00 a.m. – 17.00 p.m.<br>Local Time is (GMT)</p>
						<a href="#" class="footer-link">Terms And Conditions</a><a href="#" class="footer-link">Privacy Policy</a><a href="#" class="footer-link">Cookie Policy</a><a href="#" class="footer-link">Website Usage Terms</a>
					</div>
					<div class="w-col w-col-6">
						<h3>Working With</h3><img src={{ asset("/registration/img/virtual-office-london_22.png") }} alt=""></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="section-copyright">
	<div class="container">
		<div>© Copyright 2019 Capital Office Ltd | VAT number: 976201416 - All Rights Reserved</div>
	</div>
</div>
<script src={{ asset("/registration/js/jquery.min.js") }}></script>
<script src="https://admin.capital-office.co.uk//site/js/bootstrap.min.js"></script>
<script src={{ asset("/registration/js/jquery.bootstrap.wizard.js") }}></script>

@yield('jscript')
<!-- Popover JS by Vikram -->
	<script>
	$(document).ready(function(){
		var popover = $('[data-toggle="popover"]').popover();
		$('body').popover({
			selector: '[data-toggle="popover"]',
			trigger: 'hover',
			html: true
		});
	});
	</script>
<script src={{ asset("/registration/js/webflow.js") }} type="text/javascript"></script>
<!-- [if lte IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->

</body></html>