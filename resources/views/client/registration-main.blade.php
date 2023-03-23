<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel='stylesheet' id='tp-open-sans-css'
          href='https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C400%2C600%2C700%2C800&#038;ver=4.9.6'
          type='text/css' media='all'/>
    <!-- Bootstrap CSS -->
    <link href={{ asset("/registration/css/bootstrap.min.css") }} rel="stylesheet">
    <link rel="stylesheet" type="text/css" href={{ asset("/registration/css/style.css") }}>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css"
          integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
    <title>Capital Office | Service Registration</title>
    <!-- CSRF Token -->
	 <meta name="csrf-token" content="{{ csrf_token() }}">		
    <style type="text/css">
        body {
            font-family: 'Lato';
        }
        .small-text {
            display: inline-block;
            font-size: 11px;
            width: 100%;
        }
        label.error {
            color: #eb5858;
        }
        .error_border {
            border: 2px solid #f91818 !important;
        }
        .hide-div {
            display: none;
        }
        .h3_main {
            color: #1ef01e;
            margin: 20px auto;
            font-size: 18px;
        }
        .sidebar--top {
            padding: 30px 40px 50px 40px;
        }
        .sidebar--top .company--title {
            font-size: 19px
        }
		.red{
			color: red;
		}
    </style>
</head>
<body>
<div class="mobile_logo">
    <div class="col-md-12">
        <img src={{ asset("/registration/img/mobile-logo.jpg") }}>
    </div>
    <div class="top-social-mobile mobile-row">
        <div class="container">
            <div class="col-xs-8 phone">
                <aside id="text-18" class="widget widget_text">
                    <div class="textwidget"><span>CALL US +44 (0) 207 566 3939</span></div>
                </aside>
            </div>
            <div class="col-xs-4 social">
<span>
   <span><img src={{ asset("/registration/img/footer-widget-facebook.png") }}></span>
  <span><img src={{ asset("/registration/img/footer-widget-googleplus.png") }}></span>
  <span><img src={{ asset("/registration/img/footer-widget-twitter.png") }}></span>
</span>
            </div>
        </div>
    </div>
</div>
<header class="header">
    <div class="container mb">
        <div class="row">
            <div class="col-md-1 home_logo">
                <a href="#" rel="home">
                    <img src={{ asset("/registration/img/home-button.jpg") }} class="nav-home-btn">
                </a>
            </div>
            <div class="col-md-4 moob_prim_menu">
                <div class="row">
                    <div class="primary_menu">
                        <div id="nav-icon1">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <ul class="menu_list">
                            <li>
                                OUR SERVICES
                            </li>
                            <li>FAQ’S</li>
                            <li>
                                BLOG
                            </li>
                            <li>CONTACT US</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 main_logo">
                <div class="site-branding">
                    <a href="#" rel="home">
                        <img src={{ asset("/registration/img/LOGO.png") }} alt="logo">
                    </a></div>
            </div>
            <div class="col-md-4 top_contact contact_sp">
                <div class="row">
                    <div class="col-xs-7">
                        <span>CALL US +44 (0) 207 566 3939</span>
                    </div>
                    <div class="col-xs-5">
                        <div class="social">
                            <span><img src={{ asset("/registration/img/footer-widget-facebook.png") }}></span>
                            <span><img src={{ asset("/registration/img/footer-widget-googleplus.png") }}></span>
                            <span><img src={{ asset("/registration/img/footer-widget-twitter.png") }}></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<section>
    <div class="resource-header-banner">
        <div class="container banner_text"><h1 style="text-align: center;"><span style="color: #ffffff;">SIGNUP</span>
                <span style="color: #cc0001;">NOW</span></h1>
            <p style="text-align: center;color: #FFF;">Please contact Capital Office if you have any questions about any
                of our services. We will be pleased to answer any question that you ask. You will find our staff
                extremely friendly and helpful, and they will be more than happy to speak with you. If you are just
                looking for some general advice or guidance, then do not hesitate to get in touch! One of our friendly
                customer services team members will be happy to help you.</p></div>
    </div>
    <main class="content">
        <div class="container">
            <form id="weblead-form" class="form-horizontal" method="post" action="" novalidate="novalidate">
                <input type="hidden" name="reg_id" id="reg_id" value="{{ $record_id }}">
                <input type="hidden" name="service_order_id" value="{{ $service_order_id }}">
                <input type="hidden" name="transaction_id" value="{{ $transaction_id }}">
                <div id="rootwizard">
                    <!-- <ul class="nav nav-pills-2">
                       <li id="nav-1" class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true"></a></li>
                       <li id="nav-2"><a href="#tab2" data-toggle="tab"></a></li>
                       <li id="nav-3"><a href="#tab3" data-toggle="tab"></a></li>
                       <li id="nav-4"><a href="#tab4" data-toggle="tab"></a></li>
                    </ul> -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="row">
                                <span class="top-msg_1 h3_main alert alert-success fade in alert-dismissible show">Payment successfully completed. Please complete your registration</span>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <div class="input-form-control">
                                            <label for="name" class="cols-md-2 control-label">Referral Code</label>
                                            <input type="text" class="form-control" id="referral_code"
                                                   name="referral_code" maxlength="50" size="30"
                                                   placeholder="Enter Referral Code" aria-required="true">
                                            <label id="ref-label">If you are a partner or a client being referred to us,
                                                please enter the code in this box</label>
                                        </div>
                                    </div>
                                    <!--  <div class="form-group">
                                        <div class="input-form-control">
                                           <label for="name" class="cols-md-2 control-label">Partner ID</label>
                                           <input type="text" class="form-control" name="service_start_date" maxlength="50" size="30" placeholder="Enter Partner ID"  required="" aria-required="true" >
                                           <label id="partner-id-error" class="error hide-div" for="partner-id-error">Please select your date of birth</label>
                                        </div>
                                     </div> -->
                                    @php 
                                        
                                        $array = array();
                                        
                                        foreach ($labels as $label) {
                                            $array[$label->label_key] = $label->label_text;
                                        } 

                                    @endphp
                                    <div class="form-group">
                                        <div class="input-form-control">
                                            <label for="name"
                                                   class="cols-md-2 control-label">{{ $array['SERVICE_START_DATE'] }}
                                                <span class="required" aria-required="true">*</span></label>
                                            <input type="text" class="form-control" name="service_start_date"
                                                   id="service_start_date" maxlength="50" size="30"
                                                   placeholder="Select service start date" required=""
                                                   aria-required="true" readonly>
                                            <label id="service-start-date-error" class="error hide-div"
                                                   for="service_start_date">Please select your date of birth</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="cols-md-2 control-label">{{ $array['LOCATION'] }}
                                            <span class="required">*</span></label>
                                        <div class="input-form-control">
                                            <div class="radio">
                                                <label class="checkcontainer">
                                                    <input type="radio" name="location_type" id="location-type-0"
                                                           value="0" required>UK
                                                    <span class="radiobtn"></span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label class="checkcontainer">
                                                    <input type="radio" name="location_type" id="location-type-1"
                                                           value="1">Europe
                                                    <span class="radiobtn"></span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label class="checkcontainer">
                                                    <input type="radio" name="location_type" id="location-type-2"
                                                           value="2">Rest of World
                                                    <span class="radiobtn"></span>
                                                </label>
                                            </div>
                                            <label id="location-type-error" class="error hide-div" for="location_type">Please
                                                select your location</label>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                       <div class="col-md-12">
                                          <div class="form-group input-form-control">
                                             <div class="date">
                                                <label for="website" class="cols-md-2 control-label">COOSE SERVICE START DATE <span class="required" aria-required="true">*</span></label>
                                                <input type="text" class="form-control" name="service_start" id="service_start" maxlength="30" size="30" placeholder="Select your service start date" autocomplete="off"  required="" aria-required="true">
                                                <label id="telephone-error" class="error hide-div" for="phone-number">Please select service start date</label>
                                             </div>
                                          </div>
                                       </div>
                                    </div> -->
                                    <div class="form-group">
                                        <div class="input-form-control">
                                            <label for="name" class="cols-md-2 control-label">{{ $array['DOB'] }} <span
                                                        class="required" aria-required="true">*</span></label>
                                            <input type="text" class="form-control" name="date_of_birth"
                                                   id="date-of-birth" maxlength="50" size="30"
                                                   placeholder="Select your date of birth" required=""
                                                   aria-required="true" readonly>
                                            <label id="date-of-birth-error" class="error hide-div" for="date-of-birth">Please
                                                select your date of birth</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="cols-md-2 control-label">{{ $array['GENDER'] }}
                                            <span class="required">*</span></label>
                                        <div class="input-form-control">
                                            <div class="radio">
                                                <label class="checkcontainer">
                                                    <input type="radio" name="gender" id="gender-1" value="1" required>Male
                                                    <span class="radiobtn"></span>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label class="checkcontainer">
                                                    <input type="radio" name="gender" id="gender-2" value="0">Female
                                                    <span class="radiobtn"></span>
                                                </label>
                                            </div>
                                            <label id="gender-error" class="error hide-div" for="gender">Please select
                                                your gender</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <span class="top-msg">Your Residential Address</span>
                                        <span class="small-text">Please confirm your residential address below.</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="cols-md-2 control-label">{{ $array['HOUSE_NAME'] }}
                                            <span class="required">*</span></label>
                                        <div class="input-form-control">
                                            <input type="text" class="form-control" name="house_name" id="house-name"
                                                   required>
                                            <label id="house-name-error" class="error hide-div" for="house-name">Please
                                                select your House Number / Name</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="name" class="cols-md-2 control-label">{{ $array['STREAT_NAME'] }}
                                            <span class="required">*</span></label>
                                        <div class="input-form-control">
                                            <input type="text" class="form-control" name="street_name" id="street-name"
                                                   required>
                                            <label id="street-name-error" class="error hide-div" for="street-name">Please
                                                select your Street Name</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name"
                                                class="cols-md-2 control-label">{{ $array['CITY'] }}</label>
                                        <div class="input-form-control">
                                            <input type="text" class="form-control" name="city" id="city"
                                                    value="{{ @$payInfo['city'] }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="cols-md-2 control-label">{{ $array['COUNTY'] }}
                                            <span class="required">*</span></label>
                                        <div class="input-form-control">
                                            <input type="text" class="form-control" name="country_area"
                                                    id="country-area" required>
                                            <label id="country-area-error" class="error hide-div"
                                                    for="country-name">Please select your County / Area</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="cols-md-2 control-label">{{ $array['POST_CODE'] }}
                                            <span class="required">*</span></label>
                                        <div class="input-form-control">
                                            <input type="text" class="form-control" name="post_code" id="post-code"
                                                    value="{{ @$payInfo['post_code'] }}" required>
                                            <label id="post-code-error" class="error hide-div" for="street-name">Please
                                                select your Post / Area Code</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="cols-md-2 control-label">{{ $array['COUNTRY'] }}
                                            <span class="required">*</span></label>
                                        <div class="input-form-control">
                                            <input type="text" class="form-control" name="country" id="country"
                                                    required>
                                            <label id="country-error" class="error hide-div" for="country">Please
                                                select your Country</label>
                                        </div>
                                    </div>
                                        <!-- </div> -->
                                        <div class="row" id="complete-postal-address">
                                            <div class="col-md-12">
                                                <div class="residential-info">
                                                    <div class="form-group">
                                                        <label for="username" class="cols-md-2 control-label">Postal
                                                            Forwarding Address</label>
                                                        <span class="small-text">Please tell us where you would like your post forwarded too.</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="cols-md-8">
                                                            <div class="input-form-control">
                                                                <label class="checkcontainer">
                                                                    <input type="checkbox" id="same-as-above"
                                                                           name="same_as_above" value="1">
                                                                    <span class="tc-text">Same as above</span>
                                                                    <span class="radiobtn"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name"
                                                               class="cols-md-2 control-label">{{ $array['FORWARDING_HOUSE_NAME'] }}
                                                            <span class="required">*</span></label>
                                                        <div class="input-form-control">
                                                            <input type="text" class="form-control"
                                                                   name="forwarding_house_name"
                                                                   id="forwarding-house-name" required>
                                                            <label id="forwarding-house-name-error"
                                                                   class="error hide-div" for="forwarding-house-name">Please
                                                                enter House Number / Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name"
                                                               class="cols-md-2 control-label">{{ $array['FORWARDING_STREAT_NAME'] }}
                                                            <span class="required">*</span></label>
                                                        <div class="input-form-control">
                                                            <input type="text" class="form-control"
                                                                   name="forwarding_street_name"
                                                                   id="forwarding-street-name" required>
                                                            <label id="forwarding-street-name-error"
                                                                   class="error hide-div" for="forwarding-street-name">Please
                                                                enter Street Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name"
                                                               class="cols-md-2 control-label">{{ $array['FORWARDING_CITY'] }}</label>
                                                        <div class="input-form-control">
                                                            <input type="text" class="form-control"
                                                                   name="forwarding_city" id="forwarding-city">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name"
                                                               class="cols-md-2 control-label">{{ $array['FORWARDING_COUNTY'] }}
                                                            <span class="required">*</span></label>
                                                        <div class="input-form-control">
                                                            <input type="text" class="form-control"
                                                                   name="forwarding_country_area"
                                                                   id="forwarding-country-area" required>
                                                            <label id="forwarding-country-area-error"
                                                                   class="error hide-div" for="forwarding-country-area">Please
                                                                enter County / Locality</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name"
                                                               class="cols-md-2 control-label">{{ $array['FORWARDING_POST_CODE'] }}
                                                            <span class="required">*</span></label>
                                                        <div class="input-form-control">
                                                            <input type="text" class="form-control"
                                                                   name="forwarding_post_code" id="forwarding-post-code"
                                                                   required>
                                                            <label id="forwarding-post-code-error"
                                                                   class="error hide-div" for="forwarding-post-code">Please
                                                                enter Post / Area Code</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name"
                                                               class="cols-md-2 control-label">{{ $array['FORWARDING_COUNTRY'] }}
                                                            <span class="required">*</span></label>
                                                        <div class="input-form-control">
                                                            <input type="text" class="form-control"
                                                                   name="forwarding_country" id="forwarding-country"
                                                                   required>
                                                            <label id="forwarding-country-error" class="error hide-div"
                                                                   for="forwarding-country">Please enter Country</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  <div class="comapny-info "> -->
                                        <div class="form-group">
                                            <label for="username" class="cols-md-2 control-label">User Type<span
                                                        class="required">*</span></label>
                                            <div class="cols-md-8">
                                                <div class="input-form-control">
                                                    <div class="radio">
                                                        <label class="checkcontainer">
                                                            <input type="radio" class="user_type" name="user_type"
                                                                   id="user-type-1" value="0" required>Personal
                                                            <span class="radiobtn"></span>
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label class="checkcontainer">
                                                            <input type="radio" class="user_type" name="user_type"
                                                                   id="user-type-2" value="1" required>Business
                                                            <span class="radiobtn"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <label id="user-type-error" class="error hide-div" for="user-type">Please
                                                    choose user type</label>
                                            </div>
                                        </div>
                                        <div class="business_details_div hidden">
                                            <div class="form-group">
                                                <label for="username" class="cols-md-2 top-msg_2">Your business
                                                    details</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="name"
                                                       class="cols-md-2 control-label">{{ $array['BUSINESS_NAME'] }}
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="input-form-control">
                                                    <input type="text" class="form-control" name="business_name"
                                                           id="business-name" required>
                                                    <label id="business-name-error" class="error hide-div"
                                                           for="business_name">Please enter your business name</label>
                                                </div>
                                                <span class="small-text">This is the name that will be used to receive mail in</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="cols-md-2 control-label">Industry Type <span
                                                            class="required">*</span>
                                                </label>
                                                <div class="input-form-control">
                                                    <select class="form-control" name="industry_type"
                                                            id="industry_type_name" required>
                                                        <option value="">---Select Industry Type---</option>
                                                        <option value=0>Others</option>
                                                        
                                                        @foreach ($industries as $industry)                                                        
                                                            <option industry='{{ $industry['name'] }}' risk='{{  $industry['type'] }}' value='{{ $industry['id'] }}'>{{ $industry['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="risk" id="risk" value="">
                                                    <input type="hidden" name="industry" id="industry" value="">
                                                    <label id="industry_type_error" class="error hide-div"
                                                           for="industry_type">Please choose your Industry type</label>
                                                </div>
                                            </div>
                                            <div class="form-group hidden" id="industry_text">
                                                <div class="input-form-control">
                                                    <input type="text" name="industry_text" class="form-control"
                                                           placeholder="Enter Idustry Type">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name"
                                                       class="cols-md-2 control-label">{{ $array['BUSINESS_DESCRIPTION'] }}
                                                    <span class="required">*</span></label>
                                                <div class="input-form-control">
                                                    <textarea class="form-control" name="business_description"
                                                              id="business_description" required></textarea>
                                                    <label id="business-description-error" class="error hide-div"
                                                           for="business_description">Please enter your business
                                                        description</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="cols-md-8">
                                                    <div class="input-form-control">
                                                        <label class="checkcontainer">
                                                            <input type="checkbox" id="same-as-above1"
                                                                   name="same_as_above1" value="1">
                                                            <span class="tc-text">Same as above</span>
                                                            <span class="radiobtn"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="cols-md-2 control-label">Email <span
                                                            class="required">*</span>
                                                </label>
                                                <div class="input-form-control">
                                                    <input type="text" class="form-control" name="business_email"
                                                           id="business-email" required>
                                                    <label id="business-email-error" class="error hide-div"
                                                           for="business_email">Please enter your Email</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="cols-md-2 control-label">Phone Number<span
                                                            class="required">*</span>
                                                </label>
                                                <div class="input-form-control">
                                                    <input type="text" class="form-control" name="business_phone"
                                                           id="business_phone" required>
                                                    <label id="business-phone-error" class="error hide-div"
                                                           for="business_phone">Please enter your phone number</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="business_web" class="cols-md-2 control-label">Website
                                                </label>
                                                <div class="input-form-control">
                                                    <input type="text" class="form-control" name="business_web"
                                                           id="business-web">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="business_address" class="cols-md-2 control-label">Address
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="input-form-control">
                                                    <textarea name="business_address" class="form-control"
                                                              placeholder="Address" rows="4"
                                                              id="business_phone"></textarea>
                                                    <label id="business-address-error" class="error hide-div"
                                                           for="business_phone">Please enter your address</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="business_address" class="cols-md-2 control-label">Post Code
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="input-form-control">
                                                    <input type="text" name="business_post" class="form-control"
                                                           placeholder="Post code" id="business_post">
                                                    <label id="business-post-error" class="error hide-div"
                                                           for="business_post">Please enter your post code</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="username"
                                                       class="cols-md-2 control-label">{{ $array['FREE_ACCOUNTANT'] }}
                                                    <span class="required">*</span></label>
                                                <div class="cols-md-8">
                                                    <div class="input-form-control">
                                                        <div class="radio">
                                                            <label class="checkcontainer">
                                                                <input type="radio" name="free_accountant"
                                                                       id="free-accountant-0" value="Yes" required>Yes
                                                                <span class="radiobtn"></span>
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label class="checkcontainer">
                                                                <input type="radio" name="free_accountant"
                                                                       id="free-accountant-1" value="No" required>No
                                                                <span class="radiobtn"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <label id="free-accountant-error" class="error hide-div"
                                                           for="free_accountant">Please choose Yes or No</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="username" class="cols-md-2 control-label">Company Type <span
                                                            class="required">*</span></label>
                                                <div class="cols-md-8">
                                                    <div class="input-form-control">
                                                        <select onchange="manageForm(this);" name="company_type"
                                                                id="company_type" class="form-control">
                                                            <option value=''>Choose one</option>
                                                            <option form-text="Add Shareholders/Directors Details"
                                                                    value=1>Limited Company
                                                            </option>
                                                            <option form-text="Add Partners Details" value=2>
                                                                Partnership
                                                            </option>
                                                            <option form-text="Add Members Details" value=3>Charity
                                                            </option>
                                                            <option form-text="Add Directors Details" value=4>Limited by
                                                                Guarantee
                                                            </option>
                                                            <option form-text="Add Owners Details" value=5>Sole Trader
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <label id="company-type-error" class="error hide-div"
                                                       for="company_type">Please enter your Company type</label>
                                            </div>
                                        </div>
                                        <!-- officer box -->
                                        <div class="tab-pane active hidden officer_form">
                                            <div class="title-row">
                                                <h4 class="form-title">form_title</h4>
                                                <span class="pull-right"><button class="add-row btn btn-success"
                                                                                 type="button">(+) Add more</button></span>
                                            </div>
                                            <div class="staff-wraper">
                                                <h4>Person 1</h4>
                                                <div class="row row-wrapper">
                                                    <div class="col-md-12 officer-type ">
                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                <label><input type="radio" value=1 checked
                                                                              required="required" name="directors[1][officer_type]">
                                                                    Shareholders</label>
                                                                <label><input type="radio" value=2 required
                                                                              name="directors[1][officer_type]"> Directors</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">First Name <span
                                                                        class="required">*</span></label>
                                                            <input type="text" required="required" name="directors[1][first_name]"
                                                                   class="form-control" placeholder="First Name"
                                                                   id="first-name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Last Name <span
                                                                        class="required">*</span></label>
                                                            <input type="text" required="required" name="directors[1][last_name]"
                                                                   class="form-control" placeholder="Last Name"
                                                                   id="last-name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Date of Birth<span
                                                                        class="required">*</span></label>
                                                            <input type="date" required="required" name="directors[1][dob]"
                                                                   class="form-control" placeholder="Date Of Birth"
                                                                   id="dob">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Address</label>
                                                            <textarea name="directors[1][officer_address]"
                                                                                              class="form-control"
                                                                                              placeholder="Address"
                                                                                              rows="4"
                                                                                              id="officer_address"></textarea>                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Country <span class="required">*</span></label>
                                                            <select name="directors[1][officer_country]" required="required"
                                                                    class="form-control" id="officer_country">
                                                                @foreach($countries AS $currentCountry)                                                                
                                                                    <option value="{{ $currentCountry  }}">{{ $currentCountry  }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Post Code <span
                                                                        class="required">*</span></label>
                                                            <input type="text" required="required"
                                                                   name="directors[1][officer_post_code]" class="form-control"
                                                                   placeholder="Post Code" maxlength="15"
                                                                   id="officer_post-code">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- box end -->
                                    </div>
                              

                                <div class="col-md-5">

                                    <div class="right_box_1">
                                        <div class="sidebar--top animated fadeInRight hidden-xs">
                                            <h3><u>Details:</u></h3>
                                            <span class="company--title hidden">ABC LTD</span>
                                            <div class="company--address hidden">
                                                Registered Office Address:
                                                <br>
                                                <strong><span data-bind="text: addressFull" class='company-address'></span></strong>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="pager wizard">
                                        <!--  <li class="previous first disabled" style="display:none;"><a href="#">First</a></li> -->
                                        <!-- <li class="previous disabled"><a href="#">Previous</a></li> -->
                                        <li class="next last" style="display:none;"><a href="#">Last</a></li>
                                        <li class="next"><a class="login-button finished" href="#">Next</a></li>
                                        <li class="finish hidden"><a class="login-button finished" href="javascript:;">Submit</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <img class="payment-logo"
                                 src="https://admin.capital-office.co.uk/img/common/master-payment-logo.png">
            </form>
        </div>
    </main>
</section>
<div id="resource-footer-img"></div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 widget-with-bg">
                <aside id="text-15">
                    <div class="textwidget">
                        <div class="header-one-widget-footer">
                            <img src={{ asset("/registration/img/footer-logo.png") }} alt="Capital Office"></div>
                        <p>We are located in the heart of the world's leading business capital.</p></div>
                </aside>
                <div class="social">
                    <span><img src={{ asset("/registration/img/footer-widget-facebook.png") }}></span>
                    <span><img src={{ asset("/registration/img/footer-widget-googleplus.png") }}></span>
                    <span><img src={{ asset("/registration/img/footer-widget-twitter.png") }}></span>
                </div>
                <div class="img-wrapper">
                    <img class="widget-one-bg" src={{ asset("/registration/img/footer-widget-bg.png") }} alt="Capital Office"></div>
            </div>
            <div class="col-md-3">
                <aside id="text-17" class="widget widget_text">
                    <div class="textwidget">
                        <h4 class="header-two-footer services h2-heading">Our Main Services</h4></div>
                </aside>
                <aside id="nav_menu-2" class="widget widget_nav_menu">
                    <div class="menu-footer-menu-container">
                        <ul id="menu-footer-menu" class="menu">
                            <li id="menu-item-77246"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-77246">
                                <a href="#">Call Answering</a></li>
                            <li id="menu-item-77247"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-77247">
                                <a href="#">Company Formations</a></li>
                            <li id="menu-item-77248"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-77248">
                                <a href="#">Affordable Business Website Design</a></li>
                            <li id="menu-item-78096"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-78096">
                                <a href="#">Complete Virtual Office</a></li>
                            <li id="menu-item-77250"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-77250">
                                <a href="#">Meeting Rooms London</a></li>
                            <li id="menu-item-77251"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-77251"><a
                                        href="#">London Address Services</a></li>
                        </ul>
                    </div>
                </aside>
            </div>
            <div class="col-md-6">
                <aside id="text-7" class="widget widget_text">
                    <div class="textwidget">
                        <div class="row combined-widgets">
                            <div class="col-md-5">
                                <div class="header-two-footer h2-heading">CALL US +44 (0) 207 566 3939</div>
                            </div>
                            <div class="col-md-7">
                                <div class="header-two-footer h2-heading">Email: info@capital-office.co.uk</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><p>Capital Office , 124 City Road, London EC1V 2NX</p></div>
                        </div>
                        <div class="row">
                            <div class="col-md-5"><h4 class="header-two-footer h2-heading">OFFICE HOURS</h4>
                                <p>Monday to Friday</p>
                                <p>09.00 a.m. – 17.00 p.m.</p>
                                <p>Local Time is (GMT)</p></div>
                            <div class="col-md-7"></div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</footer>
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-6 credits-left">
                © Copyright 2016 Capital Office Ltd | VAT number: 976201416 <br><a href="/terms-conditions/"
                                                                                   title="Terms And Conditions">Terms
                    And Conditions</a> | <a href="/privacy-policy-capital-office-ltd/" title="GDPR Privacy Policy">GDPR
                    Privacy Policy</a> | <a href="/terms-of-use/" title="Website Usage Terms">Website Usage Terms</a> |
                <a href="/cookie-policy/" title="Cookie Policy">Cookie Policy</a><br>
                Please <a href="/squatters-illegal-use-of-our-address/" style="text-decoration:underline;">click
                    here</a> to view the latest businesses using our address without authorisation.
            </div>
            <div class="col-md-6 badges-footer credits-right">
                <img src={{ asset("/registration/img/badge1.png") }}>
                <img src={{ asset("/registration/img/badge2.png") }}>
                <img src={{ asset("/registration/img/badge3.png") }}>
                <img src={{ asset("/registration/img/badge4.png") }}>
                <img src={{ asset("/registration/img/badge5.png") }}>
                <img src={{ asset("/registration/img/badge6.png") }}>
                <img src={{ asset("/registration/img/badge7.png") }}>
                <img src={{ asset("/registration/img/badge8.png") }}>
                <img src={{ asset("/registration/img/badge9.png") }}></div>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script type="text/javascript">
    (function () {
        $(".officer_form").find(":input").removeAttr("required");
    })();
    $(document).ready(function () {
        var i = 1;
        window.manageForm = function (element) {
            i = 1;
            $(".officer-type").addClass('hidden');
            $(".row-wrapper-extra").remove();
            if ($(element).val()) {
                $(".officer_form").removeClass('hidden');
                $(".form-title").html($(element).find("option:selected").attr("form-text"));
                if ($(element).val() == 1)
                    $(".officer-type").removeClass('hidden');
            }
            else
                $(".officer_form").addClass('hidden');
        }
        
        


        $(".add-row").on("click", function () {
            i++;
            
            const row = `<div class="col-md-12 officer-type ">
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="radio" value=1 checked
                                                required="required" name="directors[${i}][officer_type]">
                                    Shareholders</label>
                                <label><input type="radio" value=2 required
                                                name="directors[${i}][officer_type]"> Directors</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">First Name <span
                                        class="required">*</span></label>
                            <input type="text" required="required" name="directors[${i}][first_name]"
                                    class="form-control" placeholder="First Name"
                                    id="first-name">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Last Name <span
                                        class="required">*</span></label>
                            <input type="text" required="required" name="directors[${i}][last_name]"
                                    class="form-control" placeholder="Last Name"
                                    id="last-name">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Date of Birth<span
                                        class="required">*</span></label>
                            <input type="date" required="required" name="directors[${i}][dob]"
                                    class="form-control" placeholder="Date Of Birth"
                                    id="dob">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <textarea name="directors[${i}][officer_address]"
                                                                class="form-control"
                                                                placeholder="Address"
                                                                rows="4"
                                                                id="officer_address"></textarea>
                            
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Country <span class="required">*</span></label>
                            <select name="directors[${i}][officer_country]" required="required"
                                    class="form-control" id="officer_country">
                                @foreach($countries AS $currentCountry)                                                                
                                    <option value="{{ $currentCountry  }}">{{ $currentCountry  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Post Code <span
                                        class="required">*</span></label>
                            <input type="text" required="required"
                                    name="directors[${i}][officer_post_code]" class="form-control"
                                    placeholder="Post Code" maxlength="15"
                                    id="officer_post-code">
                        </div>
                    </div>`

            
            $(".staff-wraper").append("<div class='row row-wrapper-extra'><h4>Person " + i + "</h4>" + row + "</div");
            if ($("#company_type").val() == 1)
                $(".officer-type").removeClass('hidden');
            else
                $(".officer-type").addClass('hidden');
        });
        $("#industry_type_name").change(function () {
            if ($('option:selected', this).attr('value') == 0) {
                $("#industry_text").removeClass('hidden');
                $("#risk").val(0);
            }
            else {
                var risk = $('option:selected', this).attr('risk');
                var industry = $('option:selected', this).attr('industry');
                $("#risk").val(risk);
                $("#industry").val(industry);
                $("#industry_text").addClass('hidden');
            }
        });
        $(".user_type").click(function () {
            $("#user-type-error").hide();
            if ($(this).val() == 1) {
                $('.business_details_div').removeClass('hidden');
            }
            else {
                $('.business_details_div').addClass('hidden');
            }
        });
        $(window).scroll(function () {
            if ($(this).scrollTop() >= "520")
                $(".right_box_1").addClass("right_box_fixed")
            else
                $(".right_box_1").removeClass("right_box_fixed")
        })
        $("#business-name").on("keyup", function () {
            $(".company--title").html($("#business-name").val()).removeClass("hidden");
        });
        $("#forwarding-house-name, #forwarding-street-name, #forwarding-city, #forwarding-country-area, #forwarding-post-code, #forwarding-country").on("keyup", function () {
            setTimeout(function () {
                assignAddressToLabel();
            }, 10);
        });
        $("#same-as-above").on("change", function () {
            if ($(this).is(":checked"))
                setTimeout(function () {
                    assignAddressToLabel();
                }, 200);
            else
                $(".company--address").addClass("hidden");
        });
        function assignAddressToLabel() {
            var add1 = $("#forwarding-house-name").val() ? $("#forwarding-house-name").val() + ", " : '';
            var add2 = $("#forwarding-street-name").val();
            var add3 = $("#forwarding-city").val() ? $("#forwarding-city").val() + ", " : '';
            var add4 = $("#forwarding-country-area").val();
            var add5 = $("#forwarding-post-code").val() ? $("#forwarding-post-code").val() + ", " : "";
            ;
            var add6 = $("#forwarding-country").val();
            var $fulladdress = add1 + add2 + "<br>" + add3 + add4 + "<br>" + add5 + add6;
            $(".company-address").html($fulladdress);
            $(".company--address").removeClass("hidden");
        }
        //company-address
        $("#date-of-birth").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            maxDate: new Date(),
            yearRange: '1900:2018'
        });
        $("#service_start_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            minDate: new Date(),
            yearRange: '2018:2050'
        });
        // $("#service_start_date").datepicker({ startDate: "today" , format: 'yyyy-mm-dd',autoclose: true});
        // $("#date-of-birth").datepicker({endDate: "today",  format: 'yyyy-mm-dd',autoclose: true});
        var form_data = {};
        var form_valid = 1;
        form_invalid = function () {
            form_valid = 0;
        }
        $('#same-as-above').change(function () {
            if ($(this).is(":checked")) {
                $('#forwarding-house-name').val($('#house-name').val());
                $('#forwarding-street-name').val($('#street-name').val());
                $('#forwarding-country-area').val($('#country-area').val());
                $('#forwarding-city').val($('#city').val());
                $('#forwarding-post-code').val($('#post-code').val());
                $('#forwarding-country').val($('#country').val());
            }
            else {
                $('#forwarding-house-name').val('');
                $('#forwarding-street-name').val('');
                $('#forwarding-country-area').val('');
                $('#forwarding-city').val('');
                $('#forwarding-post-code').val('');
                $('#forwarding-country').val('');
            }
        });
        $('#same-as-above1').change(function () {
            if ($(this).is(":checked")) {
                var reg_id = $('#reg_id').val();
                
                $.ajax( {
                    url: "/client-registration/get-client-details",
                    type: 'post',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {reg_id: reg_id},
                    dataType: 'json',
                    success: (resp) => {
                        
                        if (resp.client) {
                            $('#business-email').val(resp.client.email);
                            $('#business_phone').val(resp.client.phone_number);
                        }
                        
                        /* $.each(resp, function (index, value) {
                            
                        }); */    
                    }
                });
            } else {
                $('#business-email').val('');
                $('#business_phone').val('');
            }
        });
        $('.form-control').change(function () {
            $(this).next().hide();
            $("#ref-label").show();
            //$(this).next().addClass('hidden');
            $(this).removeClass('error_border');
        });
        $(".login-button").click(function (e) {
            $('.error').hide();
            //alert('ok');
            form_valid = 1;
            if (document.getElementsByName('service_start_date')[0].value == undefined || document.getElementsByName('service_start_date')[0].value == '')
                $("#service-start-date-error").show() && $("#service_start_date").focus() && $("#service_start_date").addClass('error_border') && form_invalid();
            if (!document.getElementById('location-type-0').checked && !document.getElementById('location-type-1').checked && !document.getElementById('location-type-2').checked)
                $("#location-type-error").show() && $("#location_type").focus() && form_invalid();
            if (!document.getElementById('user-type-1').checked && !document.getElementById('user-type-2').checked)
                $("#user-type-error").show() && $("#user-type-1").focus() && form_invalid();
            if (document.getElementsByName('date_of_birth')[0].value == undefined || document.getElementsByName('date_of_birth')[0].value == '')
                $("#date-of-birth-error").show() && $("#date-of-birth").focus() && $("#date-of-birth").addClass('error_border') && form_invalid();
            if (!document.getElementById('gender-1').checked && !document.getElementById('gender-2').checked)
                $("#gender-error").show() && $("#gender-1").focus() && form_invalid();
            if (document.getElementsByName('house_name')[0].value == undefined || document.getElementsByName('house_name')[0].value == '')
                $("#house-name-error").show() && $("#house-name").focus() && $("#house-name").addClass('error_border') && form_invalid();
            if (document.getElementsByName('street_name')[0].value == undefined || document.getElementsByName('street_name')[0].value == '')
                $("#street-name-error").show() && $("#street-name").focus() && $("#street-name").addClass('error_border') && form_invalid();
            if (document.getElementsByName('country_area')[0].value == undefined || document.getElementsByName('country_area')[0].value == '')
                $("#country-area-error").show() && $("#country-area").focus() && $("#country-area").addClass('error_border') && form_invalid();
            if (document.getElementsByName('post_code')[0].value == undefined || document.getElementsByName('post_code')[0].value == '')
                $("#post-code-error").show() && $("#post-code").focus() && $("#post-code").addClass('error_border') && form_invalid();
            if (document.getElementsByName('country')[0].value == undefined || document.getElementsByName('country')[0].value == '')
                $("#country-error").show() && $("#country").focus() && $("#country").addClass('error_border') && form_invalid();
            if (document.getElementById('user-type-2').checked) {
                if (document.getElementsByName('business_name')[0].value == undefined || document.getElementsByName('business_name')[0].value == '')
                    $("#business-name-error").show() && $("#business-name").focus() && $("#business-name").addClass('error_border') && form_invalid();
                if (document.getElementsByName('business_description')[0].value == undefined || document.getElementsByName('business_description')[0].value == '')
                    $("#business-description-error").show() && $("#business_description").focus() && $("#business_description").addClass('error_border') && form_invalid();
                if (!document.getElementById('free-accountant-0').checked && !document.getElementById('free-accountant-1').checked)
                    $("#free-accountant-error").show() && $("#free-accountant-1").focus() && $("#free-accountant-1").addClass('error_border') && form_invalid();
                if (document.getElementsByName('business_email')[0].value == undefined || document.getElementsByName('business_email')[0].value == '')
                    $("#business-email-error").show() && $("#business_email").focus() && $("#business_phone").addClass('error_border') && form_invalid();
                if (document.getElementsByName('business_phone')[0].value == undefined || document.getElementsByName('business_phone')[0].value == '')
                    $("#business-phone-error").show() && $("#business_email").focus() && $("#business_phone").addClass('error_border') && form_invalid();
                if (document.getElementsByName('business_post')[0].value == undefined || document.getElementsByName('business_phone')[0].value == '')
                    $("#business-post-error").show() && $("#business_post").focus() && $("#business_post").addClass('error_border') && form_invalid();
                if (document.getElementsByName('business_address')[0].value == undefined || document.getElementsByName('business_address')[0].value == '')
                    $("#business-address-error").show() && $("#business_address").focus() && $("#business_address").addClass('error_border') && form_invalid();
                if (document.getElementsByName('business_address')[0].value == undefined || document.getElementsByName('business_address')[0].value == '')
                    $("#company-type-error").show() && $("#company_type").focus() && $("#company_type").addClass('error_border') && form_invalid();
            }
            if (document.getElementsByName('forwarding_house_name')[0].value == undefined || document.getElementsByName('forwarding_house_name')[0].value == '')
                $("#forwarding-house-name-error").show() && $("#forwarding-house-name").focus() && $("#forwarding-house-name").addClass('error_border') && form_invalid();
            if (document.getElementsByName('forwarding_street_name')[0].value == undefined || document.getElementsByName('forwarding_street_name')[0].value == '')
                $("#forwarding-street-name-error").show() && $("#forwarding-street-name").focus() && $("#forwarding-street-name").addClass('error_border') && form_invalid();
            if (document.getElementsByName('forwarding_country_area')[0].value == undefined || document.getElementsByName('forwarding_country_area')[0].value == '')
                $("#forwarding-country-area-error").show() && $("#forwarding-country-area").focus() && $("#forwarding-country-area").addClass('error_border') && form_invalid();
            if (document.getElementsByName('forwarding_post_code')[0].value == undefined || document.getElementsByName('forwarding_post_code')[0].value == '')
                $("#forwarding-post-code-error").show() && $("#forwarding-post-code").focus() && $("#forwarding-post-code").addClass('error_border') && form_invalid();
            if (document.getElementsByName('forwarding_country')[0].value == undefined || document.getElementsByName('forwarding_country')[0].value == '')
                $("#forwarding-country-error").show() && $("#forwarding-country").focus() && $("#forwarding-country").addClass('error_border') && form_invalid();
            if (form_valid == 1) {
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "/client-registration/registration-main",
                    data: $("#weblead-form").serialize(),
                    success: function (result) {
                        if (result.success == 1) location.href = "/client-registration/success";
                    }
                });
            }
        });
        //console.log("I ❤ web");
        $(".mobile_hamburger").click(function () {
            $(".top_menu_bg ul").toggleClass("open");
        });
    });
    // 
    //             
</script>
</body>
</html>