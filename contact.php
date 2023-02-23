<?php include("inc/header.inc.php"); ?>
<!-- Page specific information and scripts -->
<title>Cinder Ash - Nursery and pre school in Long Sutton - Contact Us</title>

</head>

<body itemscope itemtype="https://schema.org/ChildCare">
    <?php include("inc/nav.inc.php"); ?>
    <main>
        <div class="hero about-hero">
            <div class="hero-container">
                <h1 class="hero-title">Contact Us</h1>
                <p class="hero-subtitle">Got a question about our nursery or need to make contact with us, fill out the form below and we will respond ASAP.</p>

            </div>
        </div>

        <section class="container my-4" id="section-one">
            <h2 class="section-title text-center">Contact Us</h2>
            <div class="std-card">
                <div class="grid-row-2col my-3">
                    <div class="grid-col">
                        <h3>Contact Details</h3>
                        <ul class="contact-details fa-ul" role="list">
                            <li><span class="fa-li"><i class="fa-solid fa-phone"></i></span><span class="sr-only">Phone:</span> <span><a href="tel:01406 258382" itemprop="telephone">01406 258382</a> </span></li>
                            <li><span class="fa-li"><i class="fa-solid fa-envelope"></i></span><span class="sr-only">eMail:</span> <span><a href="mailto:cinderashpre-school@hotmail.co.uk" itemprop="email"> cinderashpre-school@hotmail.co.uk</a></span></li>
                            <li><span class="fa-li"><i class="fa-regular fa-registered"></i></span>Registered Charity No. <span>518581</span></li>
                            <li><span class="fa-li"><i class="fa-regular fa-registered"></i></span>Ofsted Registration No. <span>253615</span></li>
                            <li><span class="fa-li"><i class="fa-brands fa-facebook-f"></i></span><a href="https://www.facebook.com/profile.php?id=100013728515694" target="_blank">Facebook Lucy Cooper</a></li>
                        </ul>
                        <h3>Address</h3>
                    <address>
                    The Pavilion, Park Road Long Sutton, Spalding PE12 9DJ
                    </address>

                    </div>
                    <div class="grid-col">
                    <iframe width="100%" height="100%" style="border:0" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJF_ELv2H510cROXY4vLConj0&key=AIzaSyCUbVYYbH8fD_3C7jRBX6KkNjL8I2xJPoA"></iframe>
                    </div>
                   
                </div>
                <form action="scripts/contact-script.php" method="POST" class="grid-row-2col my-3" id="contact" >
                    <div class="grid-col">
                    <div class="form-input-wrapper">
                            <label for="visitor_name"><strong>Name</strong></label>
                            <!-- input -->
                            <input title="Please provide us with your name" type="text" name="visitor_name" id="visitor_name" placeholder="Enter your name..." required  maxlength="45" value="" autocomplete="name">
                        </div>
                        <div class="form-input-wrapper">
                            <label for="visitor_email"><strong>Email Address</strong></label>
                            <!-- input -->
                            <input type="email" name="visitor_email" id="visitor_email" placeholder="Enter email address..." required="" maxlength="45" value="" autocomplete="email" title="Please provide an email address">
                        </div>
                        <div class="form-input-wrapper">
                            <label for="visitor_phone"><strong>Phone Number</strong></label>
                            <!-- input -->
                            <input title="Please provide a phone number" type="text" name="visitor_phone" id="visitor_phone" placeholder="Enter phone number..." required maxlength="45" value="" autocomplete="tel" >
                        </div>
                    </div>
                    <div class="grid-col">
                        <div class="form-textarea-wrapper">
                            <label for="visitor-message"><strong>Your Message</strong></label>
                            <textarea name="visitor_message" id="visitor-message"  placeholder="Your message..."></textarea>
                        </div>
                    </div>

                    <div class="button-section"><button class="btn-primary form-controls-btn loading-btn" type="submit">Send Message<img id="loading-icon" class="loading-icon d-none" src="./assets/img/icons/loading.svg" alt=""></button></div>
                    
                </form>
                <div class="google-policy">
                            <p>Our website is protected by reCAPTCHA and the Google</p>
                            <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> and
                            <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.
                        </div>
                <div class="response d-none" id="response"></div>
            </div>

            </div>
        </section>
    </main>
    <script>



$('#contact').submit(function(event) {
    event.preventDefault(); //prevent form default submit
    //bring in recaptcha scripts and request token
    grecaptcha.ready(function() {
        grecaptcha.execute('6LeRdqkkAAAAAHn11l-i3DDK9vgpi10iULGTpMHT', {
            action: 'submit'
        }).then(function(token) {
            var formData = new FormData($("#contact").get(0));
            formData.append("token", token);//append the recaptcha token
            $.ajax({ //start ajax post
                type: "POST",
                url: "scripts/contact-script.php",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() { //animate button
                    $("#loading-icon").show(400);
                },
                complete: function() {
                    $("#loading-icon").hide(400);
                },
                success: function(data, responseText) {
                    $("#response").html(data);
                    $("#response").slideDown(400);
                }
            });
        });
    });
});
</script>
    <?php include("inc/footer.inc.php"); ?>

</body>