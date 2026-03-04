<?php include("inc/header.inc.php"); ?>
<!-- Page specific information and scripts -->
<link rel="canonical" href="https://www.cinderashpreschool.co.uk/join-waiting-list">
<title>Cinder Ash - Nursery and pre school in Long Sutton - Join Waiting List</title>
<meta name="description" content="Join the waiting list for Cinder Ash Pre School. Fill out our form to secure a spot for your child.">
</head>

<body itemscope itemtype="https://schema.org/ChildCare">
    <?php include("inc/nav.inc.php"); ?>
    <main>
        <div class="hero about-hero">
            <div class="hero-container">
                <h1 class="hero-title">Join Our Waiting List</h1>
                <p class="hero-subtitle">Secure a spot for your child at Cinder Ash Pre School by joining our waiting list.</p>
            </div>
        </div>

        <section class="container my-4" id="section-one">
            <h2 class="section-title text-center">Join Our Waiting List</h2>
            <div class="std-card">

                <div class="waiting-list-form-wrap">

                    <div class="waiting-list-info my-3">
                        <p>We are currently operating a waiting list for all new admissions. The next available bookable space is <strong>September 2027</strong>. We recommend booking at least a year in advance where possible, and especially if particular days and hours are required.</p>
                    </div>

                    <form id="waitingListForm" method="POST" action="/scripts/waiting-list-script.php" novalidate>

                        <div class="row my-2">
                            <div class="col-50">
                                <div class="form-input-wrapper">
                                    <label for="parent_name">Parent / Guardian Name <span class="required">*</span></label>
                                    <input type="text" id="parent_name" name="parent_name" placeholder="Your full name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-50">
                                <div class="form-input-wrapper">
                                    <label for="email">Email Address <span class="required">*</span></label>
                                    <input type="email" id="email" name="email" placeholder="your@email.com" required autocomplete="email" inputmode="email">
                                </div>

                            </div>
                            <div class="col-50">
                                <div class="form-input-wrapper">
                                    <label for="phone">Phone Number <span class="required">*</span></label>
                                    <input type="tel" id="phone" name="phone" placeholder="Your contact number" required autocomplete="tel" inputmode="tel">
                                </div>
                            </div>

                        </div>
                        <div class="row my-2">
                            <div class="col-50">
                                <div class="form-input-wrapper">
                                    <label for="child_name">Child's Name <span class="required">*</span></label>
                                    <input type="text" id="child_name" name="child_name" placeholder="Child's full name" required>
                                </div>
                            </div>
                            <div class="col-50">
                                <div class="form-input-wrapper">
                                    <label for="child_dob">Child's Date of Birth <span class="required">*</span></label>
                                    <input type="date" id="child_dob" name="child_dob" required>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-50">
                                <h3 class="my-2">Days Required <span class="required">*</span></h3>
                                <div class="flex-row flex-wrap gap-3">
                                    <label class="checkbox-form-control ">
                                        <input type="checkbox" name="days[]" value="Monday"> Monday
                                    </label>
                                    <label class="checkbox-form-control ">
                                        <input type="checkbox" name="days[]" value="Tuesday"> Tuesday
                                    </label>
                                    <label class="checkbox-form-control ">
                                        <input type="checkbox" name="days[]" value="Wednesday"> Wednesday
                                    </label>
                                    <label class="checkbox-form-control ">
                                        <input type="checkbox" name="days[]" value="Thursday"> Thursday
                                    </label>
                                    <label class="checkbox-form-control ">
                                        <input type="checkbox" name="days[]" value="Friday"> Friday
                                    </label>
                                </div>
                            </div>
                            <div class="col-50">
                                <div class="form-row">
                                    <div class="form-input-wrapper">
                                        <label for="hours">Hours Required <span class="required">*</span></label>
                                        <select id="hours" name="hours" required>
                                            <option value="" disabled selected>Please select...</option>
                                            <option value="Morning">Morning</option>
                                            <option value="Afternoon">Afternoon</option>
                                            <option value="Full Day">Full Day</option>
                                        </select>
                                    </div>
                                    <div class="form-input-wrapper">
                                        <label for="start_date">Preferred Start Date <span class="required">*</span></label>
                                        <input type="date" id="start_date" name="start_date" required value="2027-09-01">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-input-wrapper">
                            <label for="notes">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="4" placeholder="Anything else you'd like us to know..."></textarea>
                        </div>

                        <div class="form-input-wrapper">
                            <button type="submit" id="submitBtn" class="btn btn-primary">Join Waiting List</button>
                        </div>

                    </form>

                    <div class="response d-none" id="response"></div>

                </div>
                <div class="google-policy">
                    <p>Our website is protected by reCAPTCHA and the Google</p>
                    <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> and
                    <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.
                </div>
            </div>

            </div>
        </section>
    </main>
    <script src="/assets/js/waiting-list.js"></script>
    <?php include("inc/footer.inc.php"); ?>

</body>