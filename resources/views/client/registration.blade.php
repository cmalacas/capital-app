@extends('layouts.registration')

@section('hero')
<div class="section-hero">
	<div class="container">
		<div class="step-box-wrapper w-row">
			<div class="w-col w-col-3">
				<div class="step-box"><img src={{ asset("/registration/img/virtual-office-london-icon-step1.png") }} alt="" class="step-img">
					<div class="step-text">Choose Your Package</div>
				</div>
			</div>
			<div class="w-col w-col-3">
				<div class="step-box"><img src={{ asset("/registration/img/virtual-office-london-icon-step2.png") }} alt="" class="step-img">
					<div class="step-text">Choose Optional Extras</div>
				</div>
			</div>
			<div class="w-col w-col-3">
				<div class="step-box faded">
					<img src={{ asset("/registration/img/virtual-office-london-icon-step3.png") }} alt="" class="step-img mobile">
					<div class="step-text mobile">Checkout&nbsp;And Pay Securely</div>
				</div>
			</div>
			<div class="w-col w-col-3">
				<div class="step-box faded">
					<img src={{ asset("/registration/img/virtual-office-london-icon-step4.png") }} alt="" class="step-img">
					<div class="step-text">Process Complete</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('main')
<div class="section-main">
	<div class="container">
		<input type="hidden" name="status" id="status" value="">
		<div class="checkout-content">
	
			<!-- Content here -->
			<form id="weblead-form" class="form-horizontal" method="post" action="" novalidate="novalidate"
                  style="width: 100%!important;">
                <div id="rootwizard">
                    <!--  <ul class="nav nav-pills-2">
                        <li id="nav-1" class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true"></a></li>
                        <li id="nav-2"><a href="#tab2" data-toggle="tab"></a></li>
                        <li id="nav-3"><a href="#tab3" data-toggle="tab"></a></li>
                        <li id="nav-4"><a href="#tab4" data-toggle="tab"></a></li>
                     </ul> -->
                     @csrf
                    <input type="hidden" value="" id="service_hidden" name="service_hidden">
                    <input type="hidden" value="" id="option_hidden" name="option_hidden">
                    <input type="hidden" value="" id="term_hidden" name="term_hidden">
                    <input type="hidden" value="" id="term_price_hidden" name="term_price_hidden">
                    <input type="hidden" value="" id="extra_hidden" name="extra_hidden">
                    <input type="hidden" value="" id="extra_price_hidden" name="extra_price_hidden">
                    <input type="hidden" value="" id="mail_hidden" name="mail_hidden">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
							<div class="row">
								<div class="col"><img class="payment-logo" src="https://admin.capital-office.co.uk/img/common/master-payment-logo2.png"></div>
								@if(false)
								<div class="col-lg-4"><span class="got_que">Got a question?</span></div>
								@endif
							</div>
							<div class="row">
								<div class="col"><span class="company--title--start"><hr>Order and Pay Securely</span></div>
							</div>
                            <div class="row">
                                @if (session('ref'))
                                    <div class="payment_failed">
                                        Payment Failed.
                                    </div>
                                @endif
                            </div>
                            <div class="row" style="clear:both;">
                                <div class="col-md-6">
                                    <div class="form-groups">
                                        <div class="input-form-control">
                                            <label for="name" class="cols-md-2 control-label">First Name <span
                                                        class="required" aria-required="true">*</span></label>
                                            <input type="text" class="form-control" name="first_name" id="first-name"
                                                   maxlength="20" size="30" placeholder="Enter your first name"
                                                   onchange="assign_value(this);" required="" aria-required="true"
                                                   value="{{ session('first_name') }}"
                                                   style="padding:0px 10px;">
                                            <label id="first-name-error" class="error hide-div" for="first-name">Please
                                                enter your first name</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-groups input-form-control">
                                        <div class="input-form-control">
                                            <label for="name" class="cols-md-2 control-label">Last Name<span
                                                        class="required" aria-required="true">*</span></label>
                                            <input type="text" class="form-control" name="last_name" id="last-name"
                                                   maxlength="20" size="30" placeholder="Enter your last name"
                                                   value="{{ session('last_name') }}"
                                                   onchange="assign_value(this);" required="" aria-required="true">
                                            <label id="last-name-error" class="error hide-div" for="last-name">Please
                                                enter your last name</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-groups input-form-control">
                                        <div class="input-form-control">
                                            <label for="name" class="cols-md-2 control-label">Your Email <span
                                                        class="required" aria-required="true">*</span></label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                   maxlength="80" size="30" placeholder="Enter your email"
                                                   value="{{ session('email') }}"
                                                   autocomplete="off" onchange="assign_value(this);" required=""
                                                   aria-required="true">
                                            <label id="email-error" class="error hide-div" for="email">Please enter a
                                                valid email</label>
                                            <label id="email-error1" class="error hide-div" for="email">You already have
                                                an account with us, please log into your portal to buy additional
                                                services</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-groups input-form-control">
                                        <div class="input-form-control">
                                            <label for="username" class="cols-md-2 control-label">Your Telephone <span
                                                        class="required" aria-required="true">*</span></label>
                                            <input type="text" class="form-control" name="phone_number"
                                                   id="phone-number" maxlength="20" size="30"
                                                   value="{{ session('phone_number') }}"
                                                   placeholder="Enter your telephone number" autocomplete="off"
                                                   onchange="assign_value(this);" required="" aria-required="true">
                                            <label id="telephone-error" class="error hide-div" for="phone-number">Please
                                                enter your phone number</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="clear:both;">
                                <div class="col-md-6">
                                    <div class="form-groups">
                                        <div class="input-form-control">
                                            <label for="name" class="cols-md-2 control-label">City <span
                                                        class="required" aria-required="true">*</span></label>
                                            <input type="text" class="form-control" name="city" id="city" maxlength="40"
                                                   size="30" placeholder="Enter your city"
                                                   onchange="assign_value(this);" required="" aria-required="true"
                                                   value="{{ session('city') }}"
                                                   style="padding:0px 10px;">
                                            <label id="city-error" class="error hide-div" for="city">Please enter your
                                                city</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-groups input-form-control">
                                        <div class="input-form-control">
                                            <label for="name" class="cols-md-2 control-label">Post Code / Zip Code<span
                                                        class="required" aria-required="true">*</span></label>
                                            <input type="text" class="form-control" name="post_code" id="post-code"
                                                   maxlength="10" size="30" placeholder="Enter your postcode"
                                                   value="{{ session('post_code') }}"
                                                   onchange="assign_value(this);" required="" aria-required="true">
                                            <label id="post-code-error" class="error hide-div" for="post-code">Please
                                                enter your post code</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--   <div class="row hidden">
                                 <div class="col-md-6">
                                    <div class="form-group input-form-control">
                                       <div class="input-form-control">
                                          <label for="username" class="cols-md-2 control-label">Your Website</label>
                                          <input type="text" class="form-control" name="website" id="website" placeholder="Enter your website" autocomplete="off" onchange="weblead_update(this.value,'website');">
                                          <label id="website-error" class="error hide-div" for="website">Please enter your business website</label>
                                       </div>
                                    </div>
                                 </div>
                              </div> -->
                            <div class="row hidden">
                                <div class="col-md-12">
                                    <div class="form-groups">
                                        <div class="input-form-control">
                                            <label for="username" class="cols-md-2 control-label">Choose Service Start
                                                Date <span class="required" aria-required="true">*</span></label>
                                            <div class="date">
                                                <input type="text" class="form-control" name="start_date"
                                                       id="start-date" placeholder="Select your service start date"
                                                       onchange="weblead_update(this.value,'service_start_date');"
                                                       required="" aria-required="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row right_box">
                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="username" class="cols-md-2 control-label" style="margin-left: 1px;">Choose The Service You
                                            want <span class="required" aria-required="true">*</span></label>
                                        <div class="input-form-control">

                                            @php $x = 1; @endphp
                                            
                                            @foreach($services as $service)

                                                @if ($x == 1)

                                                    <div class="choose_service_img"><img src="https://admin.capital-office.co.uk/img/common/virtual-address-service-forwarding.png"></div>

                                                @elseif ($x == 2)

                                                    <div class="choose_service_img"><img src="https://admin.capital-office.co.uk/img/common/call-answering-service.png"></div>

                                                @else 

                                                    <div class="choose_service_img">
                                                        <img src="https://admin.capital-office.co.uk/img/common/virtual-address-service-forwarding.png">
                                                        <span class="choose_service_both">+</span>
                                                        <img src="https://admin.capital-office.co.uk/img/common/call-answering-service.png" style="width: 80px;">
                                                    </div>

                                                @endif

                                                <label class="checkcontainer">
                                                    <input type="radio" name="service_type"
                                                           id="service-type-{{ $x }}"
                                                           value="{{ $service->id }}"
                                                           onchange="get_service_options({{ $service->id }});assign_value_opt(this,{{ $service->id }},'service_type');"
                                                           required=""
                                                           aria-required="true">{{ $service->service_name }}
                                                    <span class="radiobtn"></span>
                                                </label>

                                            @php $x++; @endphp

                                            @endforeach
                                            
                                        </div>
                                        <label id="service_type-error" class="error hide-div" for="service_type">Please
                                            select the service type</label>
                                    </div>
                                </div>
                                <div class="col-md-12 hide-div" id="service-div-1">
                                    <div class="form-group">
                                        <label for="username"
                                               class="cols-md-2 control-label service-div-1-label _xlabel"></label>
                                        <div class="cols-md-8">
                                            <div class="input-form-control service_option-1">
                                            </div>
                                            <label id="service_option-error" class="error hide-div" for="service_type">Please
                                                select the service Option</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 hide-div" id="address-service-div-00">
                                    <div class="form-group">
                                        <label for="username"
                                               class="cols-md-2 control-label befor_text_terms _xlabel"></label>
                                        <div class="cols-md-8">
                                            <div class="input-form-control service-terms-option">
                                            </div>
                                            <span class="small-text after_text_terms">
                        </span>
                                            <label id="service_term-error" class="error hide-div" for="service_type">Please
                                                select term length</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 hide-div" id="address-service-div-01">
                                    <div class="form-group">
                                        <label for="username"
                                               class="cols-md-2 control-label befor_text_mail _xlabel"></label>
                                        <div class="cols-md-8">
                                            <div class="input-form-control service-mail-handling">
                                            </div>
                                            <div class="input-form-control" id="service-call-handling">
                                                <div class="radio">
                                                    <label class='checkcontainer'>
                                                        <input class="radio-wget" type="radio"
                                                               onchange="wget_call_handling(this)" name="opt_call_hand"
                                                               id="opt_call_hand" value="0">Call forwarding
                                                        <span class="radiobtn"></span><span class="term_amt">Deposite Amount: £25 +Vat</span></label>
                                                </div>
                                                <div class="radio">
                                                    <label class='checkcontainer'>
                                                        <input class="radio-wget" type="radio"
                                                               onchange="wget_call_handling(this)" name="opt_call_hand"
                                                               id="opt_call_hand" value="1">Message forwarding
                                                        <span class="radiobtn"></span></label>
                                                </div>
                                            </div>
                                            <input type="text" name="call_forwarding_number" id="call_forwarding_number"
                                                   class="hidden form-control" value=""
                                                   placeholder="Enter a UK forwarding number">
                                            <label id="call_forwarding_number-error" class="error hide-div"
                                                   for="service_type">Please enter call forwarding number</label>
                                            <input type="text" name="mail_forwarding_address"
                                                   id="mail_forwarding_address" style="margin-bottom:10px;"
                                                   class="hidden form-control" value=""
                                                   placeholder="Enter forwarding address">
                                            <label id="mail_forwarding_address-error" class="error hide-div"
                                                   for="service_type">Please enter forwarding address</label>
                                            <input type="hidden" maxlength="8" name="deposite_amount"
                                                   id="deposite_amount" class="hidden form-control" value="">
                                            <select name="deposite_amount_sel" id="deposite_amount_sel"
                                                    class="hidden form-control">
                                                <option value="">--Choose amount--</option>
                                                <option value="10">£10</option>
                                                <option value="20">£20</option>
                                                <option value="50">£50</option>
                                            </select>
                                            <input type="text" name="mail_forwarding_email" style="margin-bottom:10px;"
                                                   id="mail_forwarding_email" class="hidden form-control" value=""
                                                   placeholder="Enter forwarding email">
                                            <label id="mail_forwarding_email-error" class="error hide-div"
                                                   for="service_type">Please enter forwarding email address</label>
                                            <select name="scan_bundle" id="scan_bundle" class="hidden form-control">
                                                <option value="">--Choose scan bundle--</option>
                                                <option value=10>10 Scans - £10.00</option>
                                                <option value=14>20 Scans - £14.00</option>
                                                <option value=20>40 Scans - £20.00</option>
                                                <option value=40>100 Scans - £40.00</option>
                                            </select>
                                            <span class="small-text after_text_mail">
                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 hide-div" id="address-service-div-03"
                                     style="padding-left:0px!important;">
                                    <div class="form-group">
                                        <label for="username"
                                               class="cols-md-2 control-label extra_before_text _xlabel" style="margin-left: 15px;"></label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="input-form-control service-extra">
                                            </div>
                                            <span class="small-text extra_after_text">
                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 hide-div" style="padding-left:0px!important;" id="addon_pack_div">
                                    <div class="form-group">
                                        <label for="username" class="cols-md-2 control-label">Addon Packages</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="input-form-control addon_pack">
                                            </div>
                                            <span class="small-text addon_pack_after_text">
                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="right_box_1 hidden">
                                <div class="sidebar--top animated fadeInRight">
                                    <span class="company--title">Order Summary
									<p class="company-subs">Checkout securely online now. Once you place your order you will receive your account login details.</p>
									<hr></span>
                                    <div class="company--address">
                                        <strong><span id="service_right"></span></strong>
                                        <br>
                                        <span id="service_option_right"></span>
                                        <br>
                                        <br>
                                        <div><span id="service_term_right"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong><span id="service_term_price_right" class="pull-right">
              </span></strong></div>
                                        <div><span id="service_extra_right"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong><span id="service_extra_price_right"
                                                          class="pull-right"></span></strong></div>
                                        <div><span id="scan_bundle_right" style="color: #286da4;">Scan Bundle  </span>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong><span id="scan_bundle_price_right"
                                                          class="pull-right" style="color: #e14117;"></span></strong></div>
                                        <div><span id="deposit_amount_right">Deposite Amount  </span>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong><span id="deposit_amount_price_right"
                                                          class="pull-right"></span></strong></div>
                                        <div id="addon_amount_right" style="margin-bottom:20px!important;"></div>
                                        <div><span id="vat_right" class="hidden">VAT Amount <strong><span
                                                            class="hidden pull-right"
                                                            id="vat_price_right"></span></strong></span></div>
                                        <div><span id="total_right"><hr style="border: 1px solid #153752;">Total Amount <strong><span id="total_price_right"
                                                                                               class=" pull-right"></span></strong></span>
                                        </div>
                                    </div>
                                    <span class="coupon_tytle">Apply Coupo<hr>n</span>
                                    
                                    
                                    <input type="text" name="coupon" id="coupon" class="form-control"
                                           placeholder="Coupon Code" value="{{ $coupon }}">
                                    <input type="hidden" value="0" name="disc_value" id="disc_value">
                                    <button type="button" name="btn-apply-coupon" id="btn-apply-coupon"
                                            class="btn green">Apply
                                    </button>
                                    <button type="button" name="btn-cancel-coupon" id="btn-cancel-coupon"
                                            class="btn green hidden">Cancel
                                    </button>
                                    <br><label class="lbl-coupon hidden">Please enter valid coupon code</label>
                                    <label class="lbl-coupon-percentage hidden"></label><br>
                                    <label class="lbl-save-amount hidden"></label><br>
                                    <label class="lbl-last-amount hidden"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="clear:both;">
                            <div class="col-md-12 col-xs-12">
                                <ul class="pager wizard">
                                    <!-- <li class="previous first disabled" style="display:none;"><a href="#">First</a></li>
                                    <li class="previous disabled"><a href="#">Previous</a></li> -->
                                    <li class="next last" style="display:none;"><a href="#">Last</a></li>
                                    <li class="next"><a class="login-button" href="#">Next</a></li>
                                    <li class="finish hidden"><a class="login-button" href="javascript:;">Submit</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
			
		</div>
	</div>
</div>
@endsection

@section('addons')
<div class="collapse" id="addons">
	<div class="card card-body" style="background-color:#f2f2f2">
		<h4 id="addontitle"></h4>
        			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename141">VAT Registration</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="VAT" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price141">£58.50</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer141">
					<button class="btn add w-button" id="button141" onclick="addAddon(141)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename136">Printed Share Certificate</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Certificate" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price136">£12.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer136">
					<button class="btn add w-button" id="button136" onclick="addAddon(136)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename139">Printed Minutes</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Minutes" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price139">£12.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer139">
					<button class="btn add w-button" id="button139" onclick="addAddon(139)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename140">Printed Mem and Arts</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Arts" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price140">£12.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer140">
					<button class="btn add w-button" id="button140" onclick="addAddon(140)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename137">Printed Incorporation Certificate</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Certificate" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price137">£12.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer137">
					<button class="btn add w-button" id="button137" onclick="addAddon(137)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename161">Printed Full Documents Set</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Documents Set" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price161">£20.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer161">
					<button class="btn add w-button" id="button161" onclick="addAddon(161)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename162">Electronic Full Document Set</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Electronic Document Set" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price162">£0.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer162">
					<button class="btn add w-button" id="button162" onclick="addAddon(162)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename133">Confirmation Statement</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Statement" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price133">£55.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer133">
					<button class="btn add w-button" id="button133" onclick="addAddon(133)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename135">Company Seal</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Seal" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price135">£20.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer135">
					<button class="btn add w-button" id="button135" onclick="addAddon(135)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename138">Company Register</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Register" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price138">£45.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer138">
					<button class="btn add w-button" id="button138" onclick="addAddon(138)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename134">Certificate of Good Standing</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Certificate" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price134">£48.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer134">
					<button class="btn add w-button" id="button134" onclick="addAddon(134)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename114">3 Document Apostille Service</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Apostille" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price114">£200.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer114">
					<button class="btn add w-button" id="button114" onclick="addAddon(114)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename113">2 Document Apostille Service</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Apostille" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price113">£140.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer113">
					<button class="btn add w-button" id="button113" onclick="addAddon(113)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename112">1 Document Apostille Service</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Apostille" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price112">£88.50</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer112">
					<button class="btn add w-button" id="button112" onclick="addAddon(112)">Add</button>
				</div>
			</div>
            	</div>
</div>
<div class="collapse" id="calladdons">
	<div class="card card-body" style="background-color:#f2f2f2">
		<h4 id="calladdontitle"></h4>
        			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename131">Record Own Greeting</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="This is a free and included service. You will be able to record your own caller greeting which is played to callers before the calls is answered. You would need to send us a wav file, but we can assist and provide guidance to you on how to create this." data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price131">£0.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer131">
                    <h4 style="color:#709BE7;margin-top:2px;">Included</h4>				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename132">Record Own Voicemail</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="This is a free and included service. You will be able to record your own voicemail message which will be played to callers when the voicemail is activated. You would need to send us a wav file, but we can assist and provide guidance to you on how to create this. " data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price132">£0.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer132">
                    <h4 style="color:#709BE7;margin-top:2px;">Included</h4>				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename153">Call Forwarding (UK numbers only)</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="The call forwarding service allows our call handler to greet your caller and then transfer the call direct to your number, as opposed to just taking a message. If you are not available to take the call, the call handler will just take a message and email you the details. We require a £25.00 deposit for this service." data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price153">£25.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer153">
                    <button class="btn add w-button" id="button153" onclick="addCall(153)">Add</button>				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename129">Personalised Greeting Message</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="The professional greeting message is recorded by a voiceover artist in a studio. You provide the message and the voiceover artist will record this for you. The greeting is then played to the caller at the very start of the call before being passed to the PA to greet your caller. We will require you to provide the script in order to complete this service." data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price129">£38.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer129">
                    <button class="btn add w-button" id="button129" onclick="addCall(129)">Add</button>				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename130">Personalised Voicemail Message</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="With this additional service our professional voiceover artist will record your chosen voicemail message in a studio. We will require you to provide the script in order to complete this service." data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price130">£38.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer130">
                    <button class="btn add w-button" id="button130" onclick="addCall(130)">Add</button>				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename158">0207 Premium Telephone Number</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="The 0207 telephone number is a premium number due to its exclusivity. The majority of all London telephone numbers issued are now 0203 and thus makes the 0207 more exclusive.  " data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price158">£47.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer158">
                    <button class="btn add w-button" id="button158" onclick="addCall(158)">Add</button>				</div>
			</div>
            	</div>
</div>
@endsection

@section('voiceadons')
<div class="collapse" id="voiceaddons">
	<div class="card card-body" style="background-color:#f2f2f2">
		<h4 id="voiceaddontitle"></h4>
        			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename131">Record Own Greeting</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="This is a free and included service. You will be able to record your own caller greeting which is played to callers before the calls is answered. You would need to send us a wav file, but we can assist and provide guidance to you on how to create this." data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price131">£0.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer131">
                    <h4 style="color:#709BE7;margin-top:2px;">Included</h4>				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename132">Record Own Voicemail</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="This is a free and included service. You will be able to record your own voicemail message which will be played to callers when the voicemail is activated. You would need to send us a wav file, but we can assist and provide guidance to you on how to create this. " data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price132">£0.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer132">
                    <h4 style="color:#709BE7;margin-top:2px;">Included</h4>				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename129">Personalised Greeting Message</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="The professional greeting message is recorded by a voiceover artist in a studio. You provide the message and the voiceover artist will record this for you. The greeting is then played to the caller at the very start of the call before being passed to the PA to greet your caller. We will require you to provide the script in order to complete this service." data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price129">£38.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer129">
                    <button class="btn add w-button" id="button129" onclick="addVoice(129)">Add</button>				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename130">Personalised Voicemail Message</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="With this additional service our professional voiceover artist will record your chosen voicemail message in a studio. We will require you to provide the script in order to complete this service." data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price130">£38.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer130">
                    <button class="btn add w-button" id="button130" onclick="addVoice(130)">Add</button>				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename158">0207 Premium Telephone Number</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="The 0207 telephone number is a premium number due to its exclusivity. The majority of all London telephone numbers issued are now 0203 and thus makes the 0207 more exclusive.  " data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price158">£47.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer158">
                    <button class="btn add w-button" id="button158" onclick="addVoice(158)">Add</button>				</div>
			</div>
            	</div>
</div>
@endsection

@section('formationaddons')
<div class="collapse" id="formationaddons">
	<div class="card card-body" style="background-color:#f2f2f2">
		<h4 id="formationaddontitle">Please now choose the Free Company Formation options</h4>
        			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename141">VAT Registration</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="VAT" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price141">£58.50</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer141">
					<button class="btn add w-button" id="button141" onclick="addFormation(141)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename136">Printed Share Certificate</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Certificate" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price136">£12.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer136">
					<button class="btn add w-button" id="button136" onclick="addFormation(136)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename139">Printed Minutes</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Minutes" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price139">£12.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer139">
					<button class="btn add w-button" id="button139" onclick="addFormation(139)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename140">Printed Mem and Arts</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Arts" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price140">£12.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer140">
					<button class="btn add w-button" id="button140" onclick="addFormation(140)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename137">Printed Incorporation Certificate</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Certificate" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price137">£12.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer137">
					<button class="btn add w-button" id="button137" onclick="addFormation(137)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename161">Printed Full Documents Set</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Documents Set" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price161">£20.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer161">
					<button class="btn add w-button" id="button161" onclick="addFormation(161)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename162">Electronic Full Document Set</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Electronic Document Set" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price162">£0.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer162">
					<button class="btn add w-button" id="button162" onclick="addFormation(162)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename133">Confirmation Statement</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Statement" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price133">£55.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer133">
					<button class="btn add w-button" id="button133" onclick="addFormation(133)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename135">Company Seal</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Seal" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price135">£20.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer135">
					<button class="btn add w-button" id="button135" onclick="addFormation(135)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename138">Company Register</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Register" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price138">£45.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer138">
					<button class="btn add w-button" id="button138" onclick="addFormation(138)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename134">Certificate of Good Standing</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Certificate" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price134">£48.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer134">
					<button class="btn add w-button" id="button134" onclick="addFormation(134)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename114">3 Document Apostille Service</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Apostille" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price114">£200.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer114">
					<button class="btn add w-button" id="button114" onclick="addFormation(114)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename113">2 Document Apostille Service</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Apostille" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price113">£140.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer113">
					<button class="btn add w-button" id="button113" onclick="addFormation(113)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename112">1 Document Apostille Service</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Apostille" data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price112">£88.50</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer112">
					<button class="btn add w-button" id="button112" onclick="addFormation(112)">Add</button>
				</div>
			</div>
            	</div>
</div>
@endsection

@section('bankaddons')
<div class="collapse" id="bankaddons">
	<div class="card card-body" style="background-color:#f2f2f2">
		<h4 id="bankaddontitle"></h4>
        			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename104">Lloyds Banking Referral</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="A successful Lloyds referral comes with £50 cash back for candidates who open an account once we have submitted your details to Lloyds. This is for UK residents only." data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price104">£0.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer104">
					<button class="btn add w-button" id="button104" onclick="addpackage(104)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename105">Barclays Banking Referral</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="A successful Barclays referral comes with £50 cash back for candidates who open an account once we have submitted your details to Barclays. This is for UK residents only." data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price105">£0.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer105">
					<button class="btn add w-button" id="button105" onclick="addpackage(105)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename106">Worldpay Banking Referral</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Worldpay is an online merchant who allow you to process card payments online, in a shop or via the phone. A successful Worldpay referral comes with £50 cash back for candidates who open an account once we have submitted your details to Lloyds. " data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price106">£0.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer106">
					<button class="btn add w-button" id="button106" onclick="addpackage(106)">Add</button>
				</div>
			</div>
            			<div class="optional-row w-row">
				<div class="w-col w-col-7 w-col-small-7 w-col-tiny-7">
					<div class="optional-item-text" id="packagename107">Cashplus Banking Referral</div>
				</div>
				<div class="w-col w-col-1 w-col-small-1 w-col-tiny-1">
					<img src={{ asset("/registration/img/icon-info.png") }} class="bg-white" style="z-index:500" alt="" data-placement="top" data-toggle="popover" data-content="Worldpay is an online merchant who allow you to process card payments online, in a shop or via the phone. A successful Worldpay referral comes with £50 cash back for candidates who open an account once we have submitted your details to Lloyds. " data-trigger="hover" data-original-title="" title="">
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2">
					<div class="price" id="price107">£0.00</div>
				</div>
				<div class="w-col w-col-2 w-col-small-2 w-col-tiny-2" id="buttoncontainer107">
					<button class="btn add w-button" id="button107" onclick="addpackage(107)">Add</button>
				</div>
			</div>
            	</div>
</div>
@endsection

@section('officeaddons')
<div class="collapse" id="officeaddons">
	<div class="card card-body" style="background-color:#f2f2f2">
		<div class="form-group">
			<label for="numofficers">How many officer addresses would you like?</label>
			<select class="form-control" id="numofficers">
				<option value="">-- Choose --</option>
				<option value="1">1 Additional Officer - £10</option>
				<option value="2">2 Additional Officers - £20</option>
				<option value="3">3 Additional Officers - £30</option>
				<option value="4">4 Additional Officers - £40</option>
				<option value="5">5 Additional Officers - £50</option>
			</select>
		</div>
		<button type="button" id="savebutton" class="btn btn-sm btn-success" onclick="officerMulti()">Add</button>
		<button type="button" id="removebutton" class="btn btn-sm btn-danger" onclick="officerRemove()">Remove</button>
	</div>
</div>
@endsection

@section('jscript')
<script type="text/javascript">
    $(document).ready(function () {
        if ($("#coupon").val() != "") {
            var coupon = $("#coupon").val();
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/client-registration/apply-coupon",
                data: {'code': coupon},
                success: function (response) {
                    $('#disc_value').val(response.discount);                    
                }
            });
        }
        var addon_array = [];
        var i = 0;
        var c = 0;
        var total = 0;
        var s_price = 0;
        var e_price = 0;
        var form_data = {};
        var form_valid = 1;
        form_data.addon_amount = 0;
        form_data.addon_array = [];
        $(".mobile_hamburger").click(function () {
            $(".top_menu_bg ul").toggleClass("open");
        });
        $("#coupon").keyup(function () {
            $("#btn-cancel-coupon").addClass('hidden');
            $("#btn-apply-coupon").removeClass('hidden');
        });
        $("#btn-apply-coupon").click(function () {
            var coupon = $("#coupon").val();
            if (coupon == '') {
                $(".lbl-coupon").removeClass('hidden');
                $(".lbl-save-amount").addClass('hidden');
                $(".lbl-last-amount").addClass('hidden');
                $(".lbl-coupon-percentage").html('');
                $("#disc_value").val(0);
                deposite_amount = $("#deposite_amount").val();
                form_data.scan_amount = $("#scan_bundle").val();
                if (form_data.deposite_amount == "") {
                    form_data.deposite_amount = 0;
                }
                if (form_data.scan_amount == "") {
                    form_data.scan_amount = 0;
                }
                var d_amount = form_data.deposite_amount;
                var s_amount = form_data.scan_amount;
                var amt = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(d_amount) + parseFloat(s_amount);
                form_data.amount_after_discount = amt;
            }
            else {
                $(".lbl-coupon").addClass('hidden');
                $(this).text("Loading..");
                $.ajax({
                    type: "post",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "/client-registration/apply-coupon",
                    data: {'code': coupon},
                    success: function (response) {
                        $("#btn-apply-coupon").text("Apply");
                        if (response.discount === 0) {
                            
                            $(".lbl-coupon").removeClass('hidden');
                            $("#disc_value").val(0);

                            deposite_amount = $("#deposite_amount").val();
                            form_data.form_data.scan_amount = $("#scan_bundle").val();
                            if (form_data.deposite_amount == "") {
                                form_data.deposite_amount = 0;
                            }
                            if (form_data.scan_amount == "") {
                                form_data.scan_amount = 0;
                            }
                            var d_amount = form_data.deposite_amount;
                            var s_amount = form_data.scan_amount;
                            var amt = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(d_amount) + parseFloat(s_amount);
                            form_data.amount_after_discount = amt;
                            $(".lbl-save-amount").addClass('hidden');
                            $(".lbl-last-amount").addClass('hidden');
                            $(".lbl-coupon-percentage").html('');
                            $(".lbl-coupon").removeClass('hidden');
                        }
                        else {
                            //var res = JSON.parse(response);
                            
                            $(".lbl-coupon-percentage").removeClass('hidden').html("Discount of " + response.discount + " % applied");
                            $("#disc_value").val(response.discount);
                            form_data.deposite_amount = $("#deposite_amount").val();
                            form_data.scan_amount = $("#scan_bundle").val();
                            if (form_data.deposite_amount == "") {
                                form_data.deposite_amount = 0;
                            }
                            if (form_data.scan_amount == "") {
                                form_data.scan_amount = 0;
                            }
                            var d_amount = form_data.deposite_amount;
                            var s_amount = form_data.scan_amount;
                            var amt = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(d_amount) + parseFloat(s_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
                            amt = amt + amt * 0.2;
                            var save = amt * (response.discount / 100);
                            var last_amt = amt - save;
                            form_data.amount_after_discount = last_amt;
                            $(".lbl-save-amount").removeClass('hidden').html("You saved £" + save.toFixed(2));
                            $(".lbl-last-amount").removeClass('hidden').html("Amount after discount: £" + last_amt.toFixed(2));
                            $(".lbl-coupon").addClass('hidden');
                            $("#btn-cancel-coupon").removeClass('hidden');
                            $("#btn-apply-coupon").addClass('hidden');
                            $("#coupon").attr('disabled', true);
                        }
                    }
                });
            }
        });
        $("#btn-cancel-coupon").click(function () {
            $("#coupon").val('').attr('disabled', false);
            $(".lbl-save-amount").addClass('hidden');
            $(".lbl-last-amount").addClass('hidden');
            $(".lbl-coupon-percentage").html('');
            $(".lbl-coupon").addClass('hidden');
            form_data.amount_after_discount = "";
            $("#btn-cancel-coupon").addClass('hidden');
            $("#btn-apply-coupon").removeClass('hidden');
            $("#disc_value").val("");
        });
        this.get_service_options = function (service_id) {
            form_data.service_option = "";
            form_data.addon_amount = 0;
            form_data.addon_array = [];
            addon_array = [];
            $("#addon_amount_right").addClass('hidden');
            form_data.addon_amount = 0;
            //$("#addon_amount_price_right").addClass('hidden');
            $("#service-call-handling").addClass('hidden');
            $("#call_forwarding_number").addClass('hidden').val('');
            $("input[name=opt_call_hand]:checked", "#weblead-form").removeAttr("checked");
            $("#mail_forwarding_email").addClass('hidden');
            $("#mail_forwarding_address").addClass('hidden');
            $('#scan_bundle').addClass('hidden');
            $("#scan_bundle").val("");
            $('#deposite_amount_sel').addClass('hidden').val('');
            $("#mail_forwarding_email").val('');
            $("#mail_forwarding_address").val('');
            $("#vat_right").addClass('hidden');
            $('#vat_price_right').addClass('hidden');
            $(" #address-service-div-00, #address-service-div-01,#address-service-div-03,#addon_pack").hide();
            //alert(service_id);
            if (service_id == "0") {
                $.post("/client-registration/get-packages", function (resp) {
                    $(".service_option-1").html(null);
                    $("#service-div-1").show();
                    $.each(resp.data, function (index, value) {
                        //alert(value.name);
                        $(".service_option-1").append("<div class=\"radio\" data-placement=\"bottom\" data-toggle=\"popover\" data-content=\"" + value.popup_data + "\">\
                              <label class='checkcontainer'>\
                              <input class=\"radio-wget\" type=\"radio\" name=\"address_service\" id=\"address-service-0\" value=\"" + value.id + "\" onchange=\"get_service_option_details(" + service_id + "," + value.id + ");\">" + value.name + "\
                             <span class=\"radiobtn\"></span> </label>\
                           </div>");
                    });
                    $(".service-div-1-label").html('Package');
                }, "json");
            } else {

                $.ajax( {
                    url: '/client-registration/get-service-options',
                    data: { service_id },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'post',
                    success: (response) => {
                        
                        if (response.addon_packs.length > 0) {
                            $('#addon_packs_div').show();
                        } else {
                            $('#addon_packs_div').hide();
                        }

                        $('.addon_pack').html(null);

                        if (response.type === 1) {

                            $(".service_option-1").html(null);
                            $("#service-div-1").show();
                            
                            $.each(response.data, function (index, value) {
                                $(".service_option-1").append("<div class=\"radio\" data-placement=\"bottom\" data-toggle=\"popover\" data-content=\"" + value.popup_data + "\">\
                                <label class='checkcontainer'>\
                                <input class=\"radio-wget\" type=\"radio\" name=\"address_service\" id=\"address-service-0\" value=\"" + value.id + "\" onchange=\"get_service_option_details(" + service_id + "," + value.id + ");\">" + value.option_title + "\
                                <span class=\"radiobtn\"></span> </label>\
                            </div>");
                            });

                            $.each(response.addon_packs, function (index, value) {
                                $(".addon_pack").append("<div class=\"radio\" data-placement=\"bottom\" data-toggle=\"popover\" data-trigger=\"hover\" data-content=\"" + value.popup_data + "\">\
                                    <label class='checkcontainer'>\
                                    <input class=\"radio-wget\" type=\"checkbox\" name=\"check_addon_pack[]\" id=\"check_addon_pack\" onclick=\"wget_amount_addon(this)\" value=\"" + value.amount + "\" o_value=\"" + value.id + "\"  addon_name=\"" + value.name + "\" \">" + value.name + "\
                                    <span class=\"radiobtn\"></span><span class=\"term_amt\">£" + parseFloat(value.amount).toFixed(2) + "</span> </label>\
                                </div>");
                            });

                            $(".service-div-1-label").html(response.label.befor_text);

                        } else {
                            
                            $('#address-service-div-00').show();
                            $('.service-terms-optin').html(null);
                            $('#service-div-1').hide();

                            $.each(response.terms, function (index, value) {
                                $(".service-terms-option").append("<div class=\"radio\" data-placement=\"bottom\" data-toggle=\"popover\" data-content=\"" + value.popup_data + "\">\
                                <label class='checkcontainer'>\
                                    <input class=\"radio-wget\" type=\"radio\"  name=\"address_service_amount_0\" onchange=\"wget_amount_term(this)\" id=\"address-service-amount-0-0\" value=\"" + value.term_price + "\" data-attr=\"3\" o_value=\"" + value.id + "\"  required=\"required\" aria-required=\"true\">\
                                    <span class=\"amount-text\">" + value.term_title + "</span>\
                                    <span class=\"radiobtn\"></span><span class=\"term_amt\">£" + parseFloat(value.term_price).toFixed(2) + "</span></label>\
                                </div>");
                            });
                            $.each(response.addon_packs, function (index, value) {
                                $(".addon_pack").append("<div class=\"radio\">\
                                    <label class='checkcontainer'>\
                                    <input class=\"radio-wget\" type=\"checkbox\" name=\"check_addon_pack[]\" id=\"check_addon_pack\" onclick=\"wget_amount_addon(this)\" o_value=\"" + value.id + "\" value=\"" + value.amount + "\" addon_name=\"" + value.name + "\" \">" + value.name + "\
                                    <span class=\"radiobtn\"></span><span class=\"term_amt\">£" + parseFloat(value.amount).toFixed(2) + "</span> </label>\
                                </div>");
                            });
                            $("#address-service-div-01").show();
                            $(".service-mail-handling").html(null);
                            $.each(response.m_handling, function (index, value) {
                                $(".service-mail-handling").append("<div class=\"radio\">\
                                <label class='checkcontainer'>\
                                <input class=\"radio-wget\" type=\"radio\" name=\"address_service_2\" id=\"mailhandling\" m_type=\"" + value.m_type + "\" value=\"" + value.mail_handling + "\" aria-label=\"...\" onchange=\"get_mail_handling_details(" + value.m_type + "," + value.id + ");\">" + value.mail_handling + "\
                                <span class=\"radiobtn\"></span></label>\
                            </div>");
                            });
                            $("#address-service-div-03").show();
                            $(".service-extra").html(null);
                            $.each(response.xtra_services, function (index, value) {
                                $(".service-extra").append("<div class=\"radio\">\
                                <label class='checkcontainer'>\
                                <input class=\"radio-wget\" type=\"radio\" onchange=\"wget_amount_extras_service(this)\" name=\"service_amount_4\" id=\"service-amount-4-0\" o_value=\"" + value.id + "\" value=\"" + value.extra_service_price + "\">" + value.extra_service_title + "\
                                <span class=\"radiobtn\"></span><span class=\"extra_amt\">£" + parseFloat(value.extra_service_price).toFixed(2) + "</span></label>\
                            </div>");
                            });
                            response.terms_labels.length != 0 ? $(".befor_text_terms").html(response.terms_labels[0].befor_text) : undefined;
                            response.terms_labels.length != 0 ? $(".after_text_terms").html(response.terms_labels[0].after_text) : undefined;
                            response.terms_labels.length != 0 ? $(".befor_text_mail").html(response.mail_labels[0].befor_text) : undefined;
                            response.terms_labels.length != 0 ? $(".after_text_mail").html(response.mail_labels[0].after_text) : undefined;
                            response.terms_labels.length != 0 ? $(".extra_after_text").html(response.extra_labels[0].after_text) : undefined;
                            response.terms_labels.length != 0 ? $(".extra_before_text").html(response.extra_labels[0].befor_text) : undefined;
                        }

                    }
                });                
            }
        }
        this.get_service_option_details = function (service_id, option_id) {
            form_data.service_option = option_id;
            $("input[name=opt_call_hand]:checked", "#weblead-form").removeAttr("checked");
            $("#mail_forwarding_email").addClass('hidden');
            $("#mail_forwarding_address").addClass('hidden');
            $("#mail_forwarding_email").val('');
            $("#mail_forwarding_address").val('');
            $('#deposite_amount_sel').addClass('hidden').val('');
            $('#scan_bundle').addClass('hidden');
            $("#call_forwarding_number").addClass('hidden').val('');
            $("#service-call-handling").addClass('hidden');
            $("#scan_bundle").val("");
            if (form_data.addon_amount == 0) {
                $("#vat_right").addClass('hidden');
                $('#vat_price_right').addClass('hidden');
                $('#total_right').hide();
            }
            if (form_data.amount_after_discount == 0 || form_data.amount_after_discount == "" || form_data.amount_after_discount == "undefined")
                $('#total_right').hide();
            form_data.amount_term = 0;
            form_data.amount_extra_service = 0;
            $(" #address-service-div-00, #address-service-div-01,#address-service-div-03").hide();
            if (service_id == 0) {

                /* $.post("/client_registration/get_package_details", {package_id: option_id}, function (resp) {
                    $("#address-service-div-00").show();
                    $(".service-terms-option").html(null);
                    $.each(resp.terms, function (index, value) {
                        $(".service-terms-option").append("<div class=\"radio\">\
                            <label class='checkcontainer'>\
                                 <input class=\"radio-wget\" type=\"radio\" onchange=\"wget_amount_term(this)\" name=\"address_service_amount_0\" id=\"address-service-amount-0-0\" value=\"" + value.amount + "\" o_value=\"" + value.term_name + "\" data-attr=\"3\"  required=\"required\" aria-required=\"true\">\
                               <span class=\"amount-text\">" + value.term_name + "</span>\
                                 <span class=\"radiobtn\"></span><span class=\"term_amt\">£" + parseFloat(value.amount).toFixed(2) + "</span></label>\
                            </div>");
                    });
                    $(".befor_text_terms").html("Term Length");
                    var term_after_text = "<span class='new_label1'>Included Products</span><br>";
                    $.each(resp.includes, function (index, value) {
                        term_after_text = term_after_text + value.name + "<br>";
                    });
                    $(".after_text_terms").html(term_after_text);
                    // $("#address-service-div-03").show();
                    $(".service-extra").html(null);
                    $.each(resp.addons, function (index, value) {
                        $(".service-extra").append("<div class=\"radio\">\
                                  <label class='checkcontainer'>\
                                  <input class=\"radio-wget\" type=\"radio\" onchange=\"wget_amount_extras_service(this)\" name=\"service_amount_4\" id=\"service-amount-4-0\" o_value=\"" + value.id + "\" value=\"" + value.monthly_price + "\">" + value.name + "\
                                  <span class=\"radiobtn\"></span><span class=\"extra_amt\">£" + parseFloat(value.monthly_price).toFixed(2) + "</span></label>\
                               </div>");
                    });
                    // $(".extra_before_text").html('Addon Products');
                }, "json"); */
            }
            else {

                $.ajax( {
                    url: '/client-registration/get-service-option-details',
                    data: { service_id, option_id},
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'post',
                    success: (response) => {
                        $("#address-service-div-00").show();
                        $(".service-terms-option").html(null);
                        $.each(response.terms, function (index, value) {
                            $(".service-terms-option").append("<div class=\"radio\">\
                            <label class='checkcontainer'>\
                                <input class=\"radio-wget\" type=\"radio\" onchange=\"wget_amount_term(this)\" name=\"address_service_amount_0\" id=\"address-service-amount-0-0\" value=\"" + value.term_price + "\" o_value=\"" + value.id + "\" data-attr=\"3\"  required=\"required\" aria-required=\"true\">\
                                <span class=\"amount-text\">" + value.term_title + "</span>\
                                <span class=\"radiobtn\"></span><span class=\"term_amt\">£" + parseFloat(value.term_price).toFixed(2) + "</span></label>\
                            </div>");
                        });
                        $("#address-service-div-01").show();
                        $(".service-mail-handling").html(null);
                        $.each(response.m_handling, function (index, value) {
                            $(".service-mail-handling").append("<div class=\"radio\">\
                                <label class='checkcontainer'>\
                                <input class=\"radio-wget\" type=\"radio\" name=\"address_service_2\" id=\"mailhandling\" m_type=\"" + value.m_type + "\" value=\"" + value.mail_handling + "\" aria-label=\"...\" onchange=\"get_mail_handling_details(" + value.m_type + "," + value.id + ");\">" + value.mail_handling + "\
                                <span class=\"radiobtn\"></span></label>\
                            </div>");
                        });

                        $("#address-service-div-01").show();
                        $(".service-mail-handling").html(null);
                        $.each(response.m_handling, function (index, value) {
                            $(".service-mail-handling").append("<div class=\"radio\">\
                                <label class='checkcontainer'>\
                                <input class=\"radio-wget\" type=\"radio\" name=\"address_service_2\" id=\"mailhandling\" m_type=\"" + value.m_type + "\" value=\"" + value.mail_handling + "\" aria-label=\"...\" onchange=\"get_mail_handling_details(" + value.m_type + "," + value.id + ");\">" + value.mail_handling + "\
                                <span class=\"radiobtn\"></span></label>\
                            </div>");
                        });
                        if (response.xtra_services.length > 0)
                            $("#address-service-div-03").show();
                        $(".service-extra").html(null);
                        $.each(response.xtra_services, function (index, value) {
                            $(".service-extra").append("<div class=\"radio\">\
                                <label class='checkcontainer'>\
                                <input class=\"radio-wget\" type=\"radio\" onchange=\"wget_amount_extras_service(this)\" name=\"service_amount_4\" id=\"service-amount-4-0\" o_value=\"" + value.id + "\" value=\"" + value.extra_service_price + "\">" + value.extra_service_title + "\
                                <span class=\"radiobtn\"></span><span class=\"extra_amt\">£" + parseFloat(value.extra_service_price).toFixed(2) + "</span></label>\
                            </div>");
                        });
                        $(".befor_text_mail,.after_text_mail,.extra_after_text,.extra_before_text").html('');
                        response.terms_labels.length != 0 ? $(".befor_text_terms").html(response.terms_labels[0].befor_text) : undefined;
                        response.terms_labels.length != 0 ? $(".after_text_terms").html(response.terms_labels[0].after_text) : undefined;
                        response.mail_labels.length != 0 ? $(".befor_text_mail").html(response.mail_labels[0].befor_text) : undefined;
                        response.extra_labels.length != 0 ? $(".extra_after_text").html(response.extra_labels[0].after_text) : undefined;
                        response.extra_labels.length != 0 ? $(".extra_before_text").html(response.extra_labels[0].befor_text) : undefined;
                        if (option_id == 7) {
                            $("#address-service-div-01").show();
                            $("#service-call-handling").removeClass('hidden');
                            $(".befor_text_mail").html('Call handling options');
                        }
                    }
                })
                
                /* $.post("/client_registration/get_service_option_details", {
                    service_id: service_id,
                    option_id: option_id
                }, function (resp) {
                    //$("._xlabel").html('');
                    $("#address-service-div-00").show();
                    $(".service-terms-option").html(null);
                    $.each(resp.terms, function (index, value) {
                        $(".service-terms-option").append("<div class=\"radio\">\
                          <label class='checkcontainer'>\
                               <input class=\"radio-wget\" type=\"radio\" onchange=\"wget_amount_term(this)\" name=\"address_service_amount_0\" id=\"address-service-amount-0-0\" value=\"" + value.term_price + "\" o_value=\"" + value.id + "\" data-attr=\"3\"  required=\"required\" aria-required=\"true\">\
                             <span class=\"amount-text\">" + value.term_title + "</span>\
                               <span class=\"radiobtn\"></span><span class=\"term_amt\">£" + parseFloat(value.term_price).toFixed(2) + "</span></label>\
                          </div>");
                    });
                    $("#address-service-div-01").show();
                    $(".service-mail-handling").html(null);
                    $.each(resp.m_handling, function (index, value) {
                        $(".service-mail-handling").append("<div class=\"radio\">\
                              <label class='checkcontainer'>\
                              <input class=\"radio-wget\" type=\"radio\" name=\"address_service_2\" id=\"mailhandling\" m_type=\"" + value.m_type + "\" value=\"" + value.mail_handling + "\" aria-label=\"...\" onchange=\"get_mail_handling_details(" + value.m_type + "," + value.id + ");\">" + value.mail_handling + "\
                              <span class=\"radiobtn\"></span></label>\
                           </div>");
                    });
                    if (resp.xtra_services.length > 0)
                        $("#address-service-div-03").show();
                    $(".service-extra").html(null);
                    $.each(resp.xtra_services, function (index, value) {
                        $(".service-extra").append("<div class=\"radio\">\
                              <label class='checkcontainer'>\
                              <input class=\"radio-wget\" type=\"radio\" onchange=\"wget_amount_extras_service(this)\" name=\"service_amount_4\" id=\"service-amount-4-0\" o_value=\"" + value.id + "\" value=\"" + value.extra_service_price + "\">" + value.extra_service_title + "\
                              <span class=\"radiobtn\"></span><span class=\"extra_amt\">£" + parseFloat(value.extra_service_price).toFixed(2) + "</span></label>\
                           </div>");
                    });
                    $(".befor_text_mail,.after_text_mail,.extra_after_text,.extra_before_text").html('');
                    resp.terms_labels.length != 0 ? $(".befor_text_terms").html(resp.terms_labels[0].befor_text) : undefined;
                    resp.terms_labels.length != 0 ? $(".after_text_terms").html(resp.terms_labels[0].after_text) : undefined;
                    resp.mail_labels.length != 0 ? $(".befor_text_mail").html(resp.mail_labels[0].befor_text) : undefined;
                    resp.extra_labels.length != 0 ? $(".extra_after_text").html(resp.extra_labels[0].after_text) : undefined;
                    resp.extra_labels.length != 0 ? $(".extra_before_text").html(resp.extra_labels[0].befor_text) : undefined;
                    if (option_id == 7) {
                        $("#address-service-div-01").show();
                        $("#service-call-handling").removeClass('hidden');
                        $(".befor_text_mail").html('Call handling options');
                    }
                }, "json"); */
            }
        }
        this.get_mail_handling_details = function (m_type, o_id) {
            form_data.mail_handling = o_id;
            $("#mail_forwarding_address-error").hide();
            $("#mail_forwarding_email-error").hide();
            $("#mail_forwarding_email").addClass('hidden');
            $("#mail_forwarding_address").addClass('hidden');
            $("#mail_forwarding_email").val('');
            $("#mail_forwarding_address").val('');
            $("#scan_bundle").addClass('hidden');
            $("#scan_bundle").val("");
            $("#deposite_amount_sel").addClass('hidden').val("");
            form_data.deposite_amount = 0;
            form_data.scan_amount = 0;
            amount = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
            $('#deposit_amount_right,#deposit_amount_price_right,#scan_bundle_right,#scan_bundle_price_right').hide();
            var vat = (amount * 0.2).toFixed(2);
            var vat_amt = parseFloat(amount) + parseFloat(vat);
            $('#vat_right').removeClass('hidden');
            $('#vat_price_right').removeClass('hidden').text(" £" + vat);
            $('#total_right').show();
            $('#total_price_right').text(" £" + vat_amt.toFixed(2));
            if (m_type == 1) {
                $("#mail_forwarding_email").addClass('hidden');
                $("#mail_forwarding_email").val('');
                $("#mail_forwarding_address").removeClass('hidden');
                if (1)
                    $("#deposite_amount_sel").removeClass('hidden');
                else
                    $("#deposite_amount_sel").addClass('hidden');
                $("#scan_bundle").addClass('hidden');
                $("#scan_bundle").val("");
            }
            else if (m_type == 2) {
                $("#mail_forwarding_address").addClass('hidden');
                $("#mail_forwarding_address").val('');
                $("#mail_forwarding_email").removeClass('hidden');
                if (o_id == 5 || o_id == 7 || o_id == 12) {
                    $("#scan_bundle").addClass('hidden');
                }
                else {
                    $("#scan_bundle").removeClass('hidden');
                }
                $("#deposite_amount_sel").addClass('hidden');
            }
        }
        this.wget_call_handling = function (this_) {
            form_data.call_handling = $(this_).attr("value");
            $("#call_forwarding_number-error").hide();
            if ($(this_).attr("value") == 0) {
                $("#call_forwarding_number").removeClass('hidden');
                $("#deposite_amount").val(25);
                $('#deposit_amount_right,#deposit_amount_price_right').show();
                $('#deposit_amount_price_right').text("£25");
            }
            else {
                $("#deposite_amount").val("");
                $("#call_forwarding_number").addClass('hidden').val("");
                $('#deposit_amount_right,#deposit_amount_price_right').hide();
            }
        }
        this.wget_amount_addon = function (this_) {
            if ($(this_).is(":checked")) {
                var addon_amount = $(this_).attr("value");
                form_data.addon_amount = parseFloat(form_data.addon_amount) + parseFloat($(this_).attr("value"));
                var addon_name = $(this_).attr("addon_name");
                var addon_id = $(this_).attr("o_value");
                c = form_data.addon_array.length;
                form_data.addon_array[c] = addon_id;
                i = addon_array.length;
                addon_array[i] = addon_name;
                i++;
                addon_array[i] = addon_amount;
                var j;
                $("#addon_amount_right").removeClass('hidden');
                $("#addon_amount_right").html("");
                for (j = 0; j < addon_array.length; j++) {
                    $("#addon_amount_right").append('<span>' + addon_array[j] + ' </span><strong><span class="pull-right"> £' + parseFloat(addon_array[j + 1]).toFixed(2) + '</span></strong><br>');
                    j = j + 1;
                }
                var d_amount = form_data.deposite_amount;
                var s_amount = form_data.scan_amount;
                // alert(s_amount);
                total = parseFloat(form_data.amount_term) + parseFloat(form_data.amount_extra_service) + parseFloat(s_amount) + parseFloat(d_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
                $('#total_price_right').show();
                var vat = (total * 0.2).toFixed(2);
                $('#vat_right').removeClass('hidden');
                $('#vat_price_right').removeClass('hidden').text(" £" + vat);
                var vat_total = parseFloat(vat) + parseFloat(total);
                $('#total_price_right').text(" £" + vat_total.toFixed(2));
                $('#total_right').show();
                var amt = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(d_amount) + parseFloat(s_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
                var discount_percentage = $("#disc_value").val();
                amt = amt + amt * 0.2;
                var save = amt * (discount_percentage / 100);
                var last_amt = amt - save;
                form_data.amount_after_discount = last_amt;
                if (discount_percentage != 0) {
                    $(".lbl-save-amount").removeClass('hidden').html("and you saved £" + save.toFixed(2));
                    $(".lbl-last-amount").removeClass('hidden').html("Amount after discount: £" + last_amt.toFixed(2));
                }
            }
            else {
                var addon_name = $(this_).attr("addon_name");
                var addon_id = $(this_).attr("o_value");
                var index1 = form_data.addon_array.indexOf(addon_id);
                if (index1 > -1) {
                    form_data.addon_array.splice(index1, 1);
                }
                var index = addon_array.indexOf(addon_name);
                if (index > -1) {
                    addon_array.splice(index, 1);
                    addon_array.splice(index, 1);
                }
                form_data.addon_amount = parseFloat(form_data.addon_amount) - parseFloat($(this_).attr("value"));
                if (form_data.addon_amount > 0) {
                    var j;
                    $("#addon_amount_right").html("");
                    for (j = 0; j < addon_array.length; j++) {
                        $("#addon_amount_right").removeClass('hidden').append('<span>' + addon_array[j] + ' </span><strong><span class="pull-right"> £' + parseFloat(addon_array[j + 1]).toFixed(2) + '</sapn></strong><br>');
                        j = j + 1;
                    }
                    var d_amount = form_data.deposite_amount;
                    var s_amount = form_data.scan_amount;
                    // alert(s_amount);
                    total = parseFloat(form_data.amount_term) + parseFloat(form_data.amount_extra_service) + parseFloat(s_amount) + parseFloat(d_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
                    $('#total_price_right').show();
                    var vat = (total * 0.2).toFixed(2);
                    $('#vat_right').removeClass('hidden');
                    $('#vat_price_right').removeClass('hidden').text(" £" + vat);
                    var vat_total = parseFloat(vat) + parseFloat(total);
                    $('#total_price_right').text(" £" + vat_total.toFixed(2));
                    $('#total_right').show();
                    var amt = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(d_amount) + parseFloat(s_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
                    var discount_percentage = $("#disc_value").val();
                    amt = amt + amt * 0.2;
                    var save = amt * (discount_percentage / 100);
                    var last_amt = amt - save;
                    form_data.amount_after_discount = last_amt;
                    if (discount_percentage != 0) {
                        $(".lbl-save-amount").removeClass('hidden').html("and you saved £" + save.toFixed(2));
                        $(".lbl-last-amount").removeClass('hidden').html("Amount after discount: £" + last_amt.toFixed(2));
                    }
                }
                else {
                    $("#addon_amount_right").addClass('hidden');
                    $("#addon_amount_price_right").addClass('hidden');
                    var d_amount = form_data.deposite_amount;
                    var s_amount = form_data.scan_amount;
                    // alert(s_amount);
                    total = parseFloat(form_data.amount_term) + parseFloat(form_data.amount_extra_service) + parseFloat(s_amount) + parseFloat(d_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
                    $('#total_price_right').show();
                    var vat = (total * 0.2).toFixed(2);
                    $('#vat_right').removeClass('hidden');
                    $('#vat_price_right').removeClass('hidden').text(" £" + vat);
                    var vat_total = parseFloat(vat) + parseFloat(total);
                    $('#total_price_right').text(" £" + vat_total.toFixed(2));
                    $('#total_right').show();
                    var amt = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(d_amount) + parseFloat(s_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
                    var discount_percentage = $("#disc_value").val();
                    amt = amt + amt * 0.2;
                    var save = amt * (discount_percentage / 100);
                    var last_amt = amt - save;
                    form_data.amount_after_discount = last_amt;
                    if (discount_percentage != 0) {
                        $(".lbl-save-amount").removeClass('hidden').html("and you saved £" + save.toFixed(2));
                        $(".lbl-last-amount").removeClass('hidden').html("Amount after discount: £" + last_amt.toFixed(2));
                    }
                    /*$("#vat_right").addClass('hidden');
                    $('#vat_price_right').addClass('hidden');
                    $('#total_right').hide();
                    $('#total_price_right').hide();*/
                }
            }
        }
        $("#mail_forwarding_email").keyup(function () {
            $("#mail_forwarding_email-error").hide();
        });
        $("#mail_forwarding_address").keyup(function () {
            $("#mail_forwarding_address-error").hide();
        });
        $("#call_forwarding_number").keyup(function () {
            $("#call_forwarding_number-error").hide();
        });
        this.wget_amount_term = function (this_) {
            form_data.amount_term = $(this_).attr("value") || 0;
        }
        this.wget_amount_extras_service = function (this_) {
            form_data.amount_extra_service = $(this_).attr("value") || 0;
        }
        this.assign_value = function (this_) {
            form_data[this_.name] = this_.value;
            $(this_).next().hide();
            $(this_).removeClass('error_border');
        }

        

        this.assign_value_opt = function (this_, service, service_type) {
            form_data[service_type] = service;
            $(this_).parents('.input-form-control').next().hide();
        }
        form_invalid = function () {
            form_valid = 0;
        }
        var form_valid1 = 1;
        $("#email").change(function () {
            var mail = $("#email").val();
            $.ajax({
                url: "/client-registration/mail-check", 
                data: {mail: mail}, 
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                success: function (data) {
                    if (data > 0) {
                        $("#email-error1").show() && $("#email").focus() && $("#email").addClass('error_border') && form_invalid();
                        form_valid1 = 0;
                    }
                    else {
                        $("#email-error1").hide();
                        form_valid1 = 1;
                    }
                }
            });
        });
        $(".login-button").click(function () {
            form_valid = 1;
            var mail = $("#email").val();            
            $.ajax({
                url: "/client-registration/mail-check", 
                data: {mail: mail}, 
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                success: function (data) {
                    if (data > 0) {
                        $("#email-error1").show() && $("#email").focus() && $("#email").addClass('error_border') && form_invalid();
                        form_valid1 = 0;
                    }
                    else {
                        $("#email-error1").hide();
                        form_valid1 = 1;
                    }
                    if (form_data.phone_number == undefined || form_data.phone_number.trim() == '')
                        $("#telephone-error").show() && $("#phone-number").focus() && $("#phone-number").addClass('error_border') && form_invalid();
                    if (form_data.email == undefined || !(/^[a-z-_\.A-Z0-9]+@+[a-z-A-Z0-9]+\.[a-z\.A-Z0-9]+$/).test(form_data.email))
                        $("#email-error").show() && $("#email").focus() && $("#email").addClass('error_border') && $("#email-error1").hide() && form_invalid();
                    if (form_data.last_name == undefined || form_data.last_name.trim() == '')
                        $("#last-name-error").show() && $("#last-name").focus() && $("#last-name").addClass('error_border') && form_invalid();
                    if (form_data.first_name == undefined || form_data.first_name.trim() == '')
                        $("#first-name-error").show() && $("#first-name").focus() && $("#first-name").addClass('error_border') && form_invalid();
                    if (form_data.city == undefined || form_data.city.trim() == '')
                        $("#city-error").show() && $("#city").focus() && $("#city").addClass('error_border') && form_invalid();
                    if (form_data.post_code == undefined || form_data.post_code.trim() == '')
                        $("#post-code-error").show() && $("#post-code").focus() && $("#post-code").addClass('error_border') && form_invalid();
                    if (form_data.service_type == undefined || form_data.service_type == '')
                        $("#service_type-error").show() && $("#service_type").addClass('error_border') && form_invalid();
                    if ((form_data.service_option == undefined || form_data.service_option == '') && form_data.service_type != 3)
                        $("#service_option-error").show() && form_invalid();
                    if (form_data.amount_term == undefined || form_data.amount_term == '')
                        $("#service_term-error").show() && form_invalid();
                    if ($("#mail_forwarding_address").val() == "" && (form_data.mail_handling == 2 || form_data.mail_handling == 9 || form_data.mail_handling == 14 || form_data.mail_handling == 17)) {
                        $("#mail_forwarding_address-error").show() && form_invalid();
                    }
                    if ($("#mail_forwarding_email").val() == "" && (form_data.mail_handling == 3 || form_data.mail_handling == 5 || form_data.mail_handling == 7 || form_data.mail_handling == 10 || form_data.mail_handling == 12 || form_data.mail_handling == 15 || form_data.mail_handling == 18)) {
                        $("#mail_forwarding_email-error").show() && form_invalid();
                    }
                    var call_forwarding_number = $("#call_forwarding_number").val();
                    if (call_forwarding_number == "" && form_data.call_handling == "0") {
                        $("#call_forwarding_number-error").show() && form_invalid();
                    }
                    if (form_valid == 1 && form_valid1 == 1) {
                        var amount_after_discount = form_data.amount_after_discount;
                        //amount_after_discount=parseFloat(amount_after_discount+(amount_after_discount*0.2));
                        form_data.deposite_amount = $("#deposite_amount").val();
                        form_data.scan_amount = $("#scan_bundle").val();
                        if (form_data.deposite_amount == "" || form_data.deposite_amount == "undefined") {
                            form_data.deposite_amount = 0;
                        }
                        if (form_data.scan_amount == "" || form_data.scan_amount == "undefined") {
                            form_data.scan_amount = 0;
                        }
                        var d_amount = form_data.deposite_amount;
                        var s_amount = form_data.scan_amount;
                        var amount = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(d_amount) + parseFloat(s_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
                        amount = parseFloat(amount) + parseFloat(amount) * 0.2;
                        if (form_data.amount_after_discount == "undefined" || form_data.amount_after_discount == "" || form_data.amount_after_discount == "NaN") {
                            amount_after_discount = amount;
                        }
                        //$("#weblead-form").attr("action", "/client_registration/payment_init/?pay=" + btoa(amount) + "&d_amount=" + btoa(form_data.amount_after_discount) + "&f=" + btoa(form_data.first_name) + "&l=" + btoa(form_data.last_name) + "&addon_id=" + btoa(form_data.addon_array) + "&addon_array=" + btoa(addon_array));

                        let action = '/client-registration/payment-init/' + btoa(amount) + '/' + btoa(form_data.amount_after_discount) + '/' + btoa(form_data.first_name) + '/' + btoa(form_data.last_name);                         
                        
                        action += btoa(form_data.addon_array) ? `/${btoa(form_data.addon_array)}` : '';

                        action += btoa(addon_array) ? `/${btoa(addon_array)}` : '';

                        $('#weblead-form').attr('action', action); 

                        $("#weblead-form").submit();
                    }
                }
            });
            return false;
        });
        $(this).on("change", "input[name='service_type']", function () {
            $("input[name=address_service_amount_0]:checked", "#weblead-form").removeAttr("checked");
            $("input[name=service_amount_4]:checked", "#weblead-form").removeAttr("checked");
            $("#extra_price_hidden").val("");
            $("#extra_hidden").val("");
            $("#call_forwarding_number-error").hide();
            $("#mail_forwarding_address-error").hide();
            $("#mail_forwarding_email-error").hide();
            s_price = 0;
            e_price = 0;
            form_data.call_handling = "";
            form_data.mail_handling = "";
            form_data.amount_term = 0;
            form_data.amount_extra_service = 0;
            form_data.scan_amount = 0;
            form_data.deposite_amount = 0;
            $('.right_box_1').removeClass('hidden');
            var service = $(this).val();
            //alert(service);
            var text = $(this).parent().text();
            $('#service_right').text(text);
            $('#service_term_price_right').hide();
            $('#service_option_right').hide();
            $('#service_term_right').hide();
            $('#service_term_price_right').hide();
            $('#service_extra_right').hide();
            $('#service_extra_price_right').hide();
            $('#deposit_amount_right,#deposit_amount_price_right,#scan_bundle_right,#scan_bundle_price_right').hide();
            $('#total_right').hide();
            $('#service_hidden').val(service);
            $(".lbl-save-amount").addClass('hidden');
            $(".lbl-last-amount").addClass('hidden');
        });
        $(this).on("change", "input[name='address_service']", function () {
            form_data.call_handling = "";
            form_data.mail_handling = "";
            $("#service_option-error").hide();
            $("#call_forwarding_number-error").hide();
            $("#mail_forwarding_address-error").hide();
            $("#mail_forwarding_email-error").hide();
            $("input[name=service_amount_4]:checked", "#weblead-form").removeAttr("checked");
            $("#extra_price_hidden").val("");
            $("#extra_hidden").val("");
            form_data.scan_amount = 0;
            form_data.deposite_amount = 0;
            form_data.amount_term = 0;
            form_data.amount_extra_service = 0;
            s_price = 0;
            e_price = 0;
            var text = $(this).parent().text();
            var opt = $(this).val();
            $('#service_option_right').show();
            $('#service_option_right').text(text);
            $('#service_term_right').hide();
            $('#service_term_price_right').hide();
            $('#service_extra_right').hide();
            $('#service_extra_price_right').hide();
            if (form_data.amount_after_discount == 0 || form_data.amount_after_discount == "" || form_data.amount_after_discount == "undefined")
                $('#total_right').hide();
            $('#option_hidden').val(opt);
            $(".lbl-save-amount").addClass('hidden');
            $(".lbl-last-amount").addClass('hidden');
            $('#deposit_amount_right,#deposit_amount_price_right,#scan_bundle_right,#scan_bundle_price_right').hide();
        });
        $(this).on("change", "select[name='scan_bundle']", function () {
            form_data.scan_amount = $(this).val();
            if (form_data.scan_amount == "" || form_data.scan_amount == "undefined")
                form_data.scan_amount = 0;
            var d_amount = form_data.deposite_amount;
            var s_amount = form_data.scan_amount;
            // alert(s_amount);
            total = parseFloat(form_data.amount_term) + parseFloat(form_data.amount_extra_service) + parseFloat(s_amount) + parseFloat(d_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
            $('#scan_bundle_right,#scan_bundle_price_right').show();
            $('#scan_bundle_price_right').text("£" + parseFloat(s_amount).toFixed(2));
            $('#total_price_right').show();
            var vat = (total * 0.2).toFixed(2);
            $('#vat_right').removeClass('hidden');
            $('#vat_price_right').removeClass('hidden').text(" £" + vat);
            var vat_total = parseFloat(vat) + parseFloat(total);
            $('#total_price_right').text(" £" + vat_total.toFixed(2));
            $('#total_right').show();
            var amt = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(d_amount) + parseFloat(s_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
            var discount_percentage = $("#disc_value").val();
            amt = amt + amt * 0.2;
            var save = amt * (discount_percentage / 100);
            var last_amt = amt - save;
            form_data.amount_after_discount = last_amt;
            if (discount_percentage != 0) {
                $(".lbl-save-amount").removeClass('hidden').html("and you saved £" + save.toFixed(2));
                $(".lbl-last-amount").removeClass('hidden').html("Amount after discount: £" + last_amt.toFixed(2));
            }
        });
        $("#deposite_amount_sel").on("change", function () {
            form_data.deposite_amount = $("#deposite_amount_sel").val();
            // alert(form_data.deposite_amount);
            $("#deposite_amount").val(form_data.deposite_amount);
            if (form_data.deposite_amount == "" || form_data.deposite_amount == "undefined")
                form_data.deposite_amount = 0;
            var d_amount = form_data.deposite_amount;
            var s_amount = form_data.scan_amount;
            total = parseFloat(s_price) + parseFloat(e_price) + parseFloat(s_amount) + parseFloat(d_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
            $('#deposit_amount_right,#deposit_amount_price_right').show();
            $('#deposit_amount_price_right').text("£" + d_amount);
            $('#total_right').show();
            var vat = (total * 0.2).toFixed(2);
            var vat_total = parseFloat(vat) + parseFloat(total);
            $('#total_price_right').text(" £" + vat_total.toFixed(2)).show();
            $('#vat_right').removeClass('hidden');
            $('#vat_price_right').removeClass('hidden').text(" £" + vat);
            var amt = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(d_amount) + parseFloat(s_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
            amt = amt + amt * 0.2;
            var discount_percentage = $("#disc_value").val();
            var save = amt * (discount_percentage / 100);
            var last_amt = amt - save;
            form_data.amount_after_discount = last_amt;
            if (discount_percentage != 0) {
                $(".lbl-save-amount").removeClass('hidden').html("and you saved £" + save.toFixed(2));
                $(".lbl-last-amount").removeClass('hidden').html("Amount after discount: £" + last_amt.toFixed(2));
            }
        });
        $(this).on("change", "input[name='address_service_amount_0']", function () {
            $("#service_term-error").hide();
            var text = $(this).parent().html();
            var term = $(this).attr('o_value');
            $('#service_term_right').html(text);
            var text2 = $(this).val();
            s_price = parseFloat(text2);
            form_data.amount_term = s_price;
            var d_amount = form_data.deposite_amount;
            var s_amount = form_data.scan_amount;
            total = parseFloat(form_data.amount_term) + parseFloat(form_data.amount_extra_service) + parseFloat(s_amount) + parseFloat(d_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
            $('#service_term_price_right').text("£" + parseFloat(text2).toFixed(2));
            $('#service_term_right').show();
            $('#service_term_price_right').show();
            $("#vat_right").addClass('hidden');
            $('#vat_price_right').addClass('hidden');
            $('#term_hidden').val(term);
            $('#term_price_hidden').val(text2);
            $('#total_price_right').text(" £" + total.toFixed(2));
            $('#total_right').show();
            var vat = (total * 0.2).toFixed(2);
            var vat_total = parseFloat(vat) + parseFloat(total);
            $('#total_price_right').text(" £" + vat_total.toFixed(2));
            $('#vat_right').removeClass('hidden');
            $('#vat_price_right').removeClass('hidden').text(" £" + vat);
            form_data.deposite_amount = $("#deposite_amount").val();
            form_data.scan_amount = $("#scan_bundle").val();
            if (form_data.deposite_amount == "" || form_data.deposite_amount == "undefined") {
                form_data.deposite_amount = 0;
            }
            if (form_data.scan_amount == "" || form_data.scan_amount == "undefined") {
                form_data.scan_amount = 0;
            }
            var d_amount = form_data.deposite_amount;
            var s_amount = form_data.scan_amount;
            var amt = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(d_amount) + parseFloat(s_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
            var discount_percentage = $("#disc_value").val();
            amt = amt + amt * 0.2;
            var save = amt * (discount_percentage / 100);
            var last_amt = amt - save;
            form_data.amount_after_discount = last_amt;
            if (discount_percentage != 0) {
                $(".lbl-save-amount").removeClass('hidden').html("and you saved £" + save.toFixed(2));
                $(".lbl-last-amount").removeClass('hidden').html("Amount after discount: £" + last_amt.toFixed(2));
            }
            //$('#total_right').hide();
        });
        $(this).on("change", "input[name='service_amount_4']", function () {
            var text = $(this).parent().html();
            var text2 = $(this).val();
            var extra = $(this).attr('o_value');
            $('#service_extra_right').hide();
            $('#service_extra_price_right').hide();
            $('#extra_hidden').val(extra);
            $('#extra_price_hidden').val(text2);
            e_price = parseFloat(text2);
            form_data.amount_extra_service = e_price
            var d_amount = form_data.deposite_amount;
            var s_amount = form_data.scan_amount;
            total = parseFloat(form_data.amount_term) + parseFloat(form_data.amount_extra_service) + parseFloat(s_amount) + parseFloat(d_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
            $('#service_extra_right').html(text);
            $('#service_extra_price_right').text("£" + parseFloat(text2).toFixed(2));
            $('#service_extra_right').show();
            $('#service_extra_price_right').show();
            $('#total_right').show();
            var vat = (total * 0.2).toFixed(2);
            var vat_total = parseFloat(vat) + parseFloat(total);
            $('#total_price_right').text(" £" + vat_total.toFixed(2));
            $('#vat_right').removeClass('hidden');
            $('#vat_price_right').removeClass('hidden').text(" £" + vat);
            form_data.deposite_amount = $("#deposite_amount").val();
            scan_amount = $("#scan_bundle").val();
            if (form_data.deposite_amount == "" || form_data.deposite_amount == "undefined") {
                form_data.deposite_amount = 0;
            }
            if (form_data.scan_amount == "" || form_data.scan_amount == "undefined") {
                form_data.scan_amount = 0;
            }
            var d_amount = form_data.deposite_amount;
            var s_amount = form_data.scan_amount;
            var amt = parseFloat(typeof form_data.amount_term == "undefined" ? 0 : form_data.amount_term) + parseFloat(typeof form_data.amount_extra_service == "undefined" ? 0 : form_data.amount_extra_service) + parseFloat(d_amount) + parseFloat(s_amount) + parseFloat(typeof form_data.addon_amount == "undefined" ? 0 : form_data.addon_amount);
            var discount_percentage = $("#disc_value").val();
            amt = amt + amt * 0.2;
            var save = amt * (discount_percentage / 100);
            var last_amt = amt - save;
            form_data.amount_after_discount = last_amt;
            if (discount_percentage != 0) {
                $(".lbl-save-amount").removeClass('hidden').html("and you saved £" + save.toFixed(2));
                $(".lbl-last-amount").removeClass('hidden').html("Amount after discount: £" + last_amt.toFixed(2));
                var vat = (last_amt * 0.2).toFixed(2);
                $('#vat_right').removeClass('hidden');
                $('#vat_price_right').removeClass('hidden').text(" £" + vat);
            }
        });
        $(this).on("change", "#mailhandling", function () {
            var mail = $(this).val();
            $('#mail_hidden').val(mail);
        });
        $(document).on("keypress keyup blur", ".onlyNumbers", function (event) {
            //$(this).val($(this).val().replace(/[^\d].+/, ""));
            console.log(event.which);
            if ((event.which < 48 || event.which > 57) && event.which != 08
        )
            {//https://css-tricks.com/snippets/javascript/javascript-keycodes/
                event.preventDefault();
            }
        });

        $('input[type=text], input[type=email]').trigger('change');

    });
</script>
@endsection