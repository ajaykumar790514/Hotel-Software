
<div class="inner-banner inner-bg2">
<div class="container">
<div class="inner-title">
<ul>
<li>
<a href="index.html">Home</a>
</li>
<li><i class="bx bx-chevron-right"></i></li>
<li>Contact</li>
</ul>
<h3>Contact</h3>
</div>
</div>
</div>


<div class="contact-area pt-100 pb-70">
<div class="container">
<div class="row align-items-center">
<div class="col-lg-6">
<div class="contact-content">
<div class="section-title">
<h2>Let's get started!!!
Send us a message or call us.</h2>
</div>
<div class="contact-img">
<img src="<?=base_url();?>static/portal/assets/img/contact/contact-img1.jpg" alt="Images">
</div>
</div>
</div>
<div class="col-lg-6">
<div class="contact-form">
<form id="contactForm" class="form ajaxsubmit-enquiry reload-tb" action="<?=base_url();?>submit-enquiry" method="POST" enctype="multipart/form-data">
<div class="row">
<div class="col-lg-6 col-sm-6">
<div class="form-group">
<input type="text" name="name" id="name" class="form-control" required data-error="Please enter your name" placeholder="Name">
<div class="help-block with-errors"></div>
</div>
</div>
<div class="col-lg-6 col-sm-6">
<div class="form-group">
<input type="email" name="email" id="email" class="form-control" required data-error="Please enter your email" placeholder="Email">
<div class="help-block with-errors"></div>
</div>
</div>
<div class="col-lg-6 col-sm-6">
<div class="form-group">
<input type="text" name="mobile" id="phone_number" required data-error="Please enter your number" class="form-control" placeholder="Phone">
<div class="help-block with-errors"></div>
</div>
</div>
<div class="col-lg-6 col-sm-6">
<div class="form-group">
<input type="text" name="subject" id="msg_subject" class="form-control" required data-error="Please enter your subject" placeholder="Your Subject">
<div class="help-block with-errors"></div>
</div>
</div>
<div class="col-lg-12 col-md-12">
<div class="form-group">
<textarea name="message" class="form-control" id="message" cols="30" rows="8" required data-error="Write your message" placeholder="Your Message"></textarea>
<div class="help-block with-errors"></div>
</div>
</div>

<div class="form-group">
    <div class="g-recaptcha" data-sitekey="<?=captcha_settings()->siteKey;?>"></div>
    </div>
<div class="col-lg-12 col-md-12">
<button type="submit" class="default-btn btn-bg-three">
Send Message
</button>
<div id="msgSubmit" class="h3 text-center hidden"></div>
<div class="clearfix"></div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>


<div class="contact-another pb-70">
<div class="container">
<div class="row">
<div class="col-lg-6">
<div class="contact-another-content">
<div class="section-title">
<h2>Contacts Info</h2>
<p>
We are one of the best agency and we can easily make a contract
us anytime on the below details.
</p>
</div>
<div class="contact-item">
<ul>
 <li>
<div class="content">
<span style="font-size:1.2rem;">DEV DARSHAN HOSPITALITIES</span>
</div>
</li>
<li>
<i class="bx bx-phone-call"></i>
<div class="content">
<span><a href="tel:+91 9377303613">+91 9377303613</a></span>
<span><a href="tel:+91 9897191027">+91 9897191027</a></span>
</div>
</li>
<li>
<i class="bx bx-envelope"></i>
<div class="content">
<span><a href="/cdn-cgi/l/email-protection#support@thehotelreception.com"><span class="__cf_email__" data-cfemail="support@thehotelreception.com">support@thehotelreception.com</span></a></span>
</div>
</li>
<li class="">
<i class="bx bx-home mt-4"></i>
<div class="content">
<span class=" mt-1  ">378-B,Near Kipps Wali Gali,</br>  Indra Nagar, Bareilly, Uttar Pradesh,</br>243122</span>
</div>
</li>
</ul>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="contact-another-img">
<img src="<?=base_url();?>static/portal/assets/img/contact/contact-img2.jpg" alt="Images">
</div>
</div>
</div>
</div>
</div>
