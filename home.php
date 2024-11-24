<?php
$base_url = 'https://batangassdp.com/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batangas Province Scholarship Disbursement System</title>
    <link href="jquery.gScrollingCarousel.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <!--Start of Tawk.to Script-->
    <script src="jQueryFAQAccordion.js"></script>
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/648acf6394cf5d49dc5dd252/1h2v3k7ou';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</head>
<!-- Start of Async Drift Code -->

<style>
    .contact-in{
        width:80%;
        height: auto;
        margin: auto;
        display: flex;
        flex-wrap:wrap;
        padding: 10px;
        border-radius:10px;
        background:#fff;
        box-shadow: 0px 0px 10px 0px #666;

    }
    .contact-map{
        width: 100%;
        height: auto;
        flex-basis: 50%;

    }
    .contact-map iframe{
        width: 100%;
        height: 100%;


    }
    .contact-form{
        width: 100%;
        height: auto;
        flex-basis: 50%;
        padding: 30px;
        text-align: center;

    }
    .contact-form h1{
        margin-bottom: 10px;
    }
    .contact-form-txt{
        width: 100%;
        height: 40px;
        color: #000;
        border:1px solid #bcbcbc;
        border-radius:50px;
        outline:none;
        margin-bottom: 20px;
        padding: 15px;

    }
    .contact-form-txt::placeholder{
        color:#aaa;
    }
    .contact-form-textarea{
        width: 100%;
        height: 130px;
        color: #000;
        border:1px solid #bcbcbc;
        border-radius:10px;
        outline:none;
        margin-bottom: 20px;
        padding: 15px;

    }
    .contact-form-textarea::placeholder{
        color:#aaa;
    }

    .contact-form-btn{
        width:100%;
        border:none;
        outline:none;
        border-radius:50px;
        background:palegreen;
        color:#fff;
        text-transform: uppercase;
        padding: 10px;
        cursor:pointer;
        font-size:18px;

    }


    @media only screen and (max-width: 600px) {
        .contact-in{
            flex-direction:column;
        }
        .contact-map,
        .contact-form{
            flex-basis: 100%;
        }
    }


    .question {
        padding: 10px;
        border-radius: 6px;
        background: white;
        transition: all 0.5s ease;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .question:hover {
        background-color: #4CAF50;
    }

    .question.open {
        -webkit-box-shadow: 0px 0px 17px -1px rgba(0,0,0,0.13);
        -moz-box-shadow: 0px 0px 17px -1px rgba(0,0,0,0.13);
        box-shadow: 0px 0px 17px -1px rgba(0,0,0,0.13);
    }

    .question .faqAnswer {
        display: none;
        padding: 20px 10px;
        line-height: 28px;
        color: rgba(0,0,0,0.6);
        font-size: 17px;
    }

    .question.open:hover {
        background: white;
    }

    .question h4 {
        border-radius: 6px;
        margin: 0px;
        padding: 10px;
        color: black;
        font-weight: 400;
        font-size: 20px;
        cursor: pointer;
    }

    .question h4.open {
        border-radius: 6px;
        margin: 0px;
        color: white;
        background-color: #4CAF50;
        cursor: pointer;
    }

    .question:hover h4 {
        color: white;
    }
    .googleMap{
        position: relative;
        height: 0;
        padding-bottom: 50%;
    }

    .googleMap iframe{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 50%;
    }
    .g-scrolling-carousel .items > *{
        min-height:96px;
        margin-right:10px;
    }
    .g-scrolling-carousel .items a:last-child{
        margin-right:0;
    }
    .carousel-three,.carousel-four {
        width: 537px;
    }
</style>


<body>
<header id="header" class="menu-container">

    <!--   Logo -->
    <div class="logo-box">
        <a href="<?php echo $base_url; ?>">
            <img src="logo.png" alt="" id="header-img"><p style="margin-top: 30px;"></a>Batangas Scholarship Disbursement System</p>

    </div>
    <!--   Logo -->

    <!--   navbar -->
    <nav id="nav-bar">
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
            <li><a href="#features" class="nav-link">Features</a></li>
            <li><a href="#about" class="nav-link">About</a></li>
            <li><a href="#contact" class="nav-link">Contact Us</a></li>
            <li><a href="user/login.php" class="nav-link">Student Login</a></li>

            <a class="highlight" href="admin/login.php">Admin Login</a>
        </ul>
    </nav>
    <!--   navbar -->
</header>
<!-- header ends -->

<main class="container" id="home">
    <section class="hero container">
        <h1 class="hero-title-primary">Manage your scholars data.</h1>
        <p class="hero-title-sub">Empowering Lives: Your Education, Our Dedicated Priority</p>

        <button onclick="window.location.href = 'user/login.php';">Join Now!</button>
    </section>
    <div class="hero-image">
        <img src="<?php echo $base_url; ?>scholars.png">
    </div>

</main>
<!--Waves Container-->
<!-- CSS Waves from goodkatz (https://codepen.io/goodkatz/pen/LYPGxQz) -->
<div>
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
        <defs>
            <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
        </defs>
        <g class="parallax">
            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
            <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
            <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
            <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
        </g>
    </svg>
</div>
<!--Waves end-->
<!--Header ends-->

<!--Content starts--><section class="video-content" >
    <div class="video-story">
        <div class="inner-content-title">
            Scholarship Disbursement
        </div>

        <br>
        <div class='embed-container'>

            <iframe id="video" src="https://www.youtube.com/embed/OW7ouAVXkfU?si=EJr7wb-ufoNAgABX" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <!-- <iframe id="video" src="https://www.youtube-nocookie.com/embed/vBKBsrnBdSI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
        </div>
    </div>


    <div class="three-dots">
        <span></span>
        <span></span>
        <span></span>
    </div>

</section>



<section class="content" >

    <div class="inner-content">
        <div class="inner-content-text content__TextLeft">
            <div id="about" class="inter-content-subtitle">
                About
            </div>

            <div class="inner-content-title">
                Batangas Scholarship Disbursement System
            </div>

            <div class="inner-content-para">
                <p>Batangas Scholarship Disbursement System is a digital platform or software used to store, manage, and retrieve student scholarship disbursement records and related information. It allows scholarship providers to efficiently organize and access scholars data, such as disbursement history, test results, scholarship grants and schedule of disbursements.</p>
            </div>
        </div>

        <div class="inner-image-container container__ImageRight">
            <div class="inner-content-image content__ImageRight">
                <img class="section-images" src="<?php echo $base_url; ?>features.jpg" style="object-position: 50% 50%;">
            </div>
        </div>


    </div>


    <div class="inner-content">
        <div class="inner-content-text content__TextRight">
            <div id="features" class="inter-content-subtitle">
                Features
            </div>

            <div class="inner-content-title">
                Scholarship Administration Recording
            </div>

            <div class="inner-content-para">
                <p>Batangas Scholarship Disbursement System is a digital platform or software used to store, manage, and retrieve student scholarship disbursement records and related information. It allows scholarship providers to efficiently organize and access scholars data, such as disbursement history, test results, scholarship grants and schedule of disbursements.</p>
            </div>
        </div>

        <div class="inner-image-container container__ImageLeft" style="margin-bottom:20px;">
            <div class="inner-content-image content__ImageLeft">
                <img class="section-images" src="<?php echo $base_url; ?>images/Pictures/6.jpg">
            </div>
        </div>
    </div>


    <section class="video-content">
        <div class="video-story" style="width: 80%;">
            <div class="inner-content-title">
                Our Community
            </div>
            <br/>
            <div class='embed-container'>

            </div>

            <div class="container">
                <div>

                    <div class="g-scrolling-carousel carousel">
                        <div class="items" style="width: 100%;">
                            <a href="" ><img src="images/Pictures/1.jpg" style="height: 200px;"></a>
                            <a href="" ><img src="images/Pictures/2.jpg" style="height: 200px;"></a>
                            <a href="" ><img src="images/Pictures/3.jpg" style="height: 200px;"></a>
                            <a href="" ><img src="images/Pictures/4.jpg" style="height: 200px;"></a>
                            <a href="" ><img src="images/Pictures/5.jpg" style="height: 200px;"></a>
                            <a href="" ><img src="images/Pictures/6.jpg" style="height: 200px;"></a>
                            <a href="" ><img src="images/Pictures/7.jpg" style="height: 200px;"></a>
                            <a href="" ><img src="images/Pictures/8.jpg" style="height: 200px;"></a>
                            <a href="" ><img src="images/Pictures/9.jpg" style="height: 200px;"></a>
                            <a href="" ><img src="images/Pictures/10.jpg" style="height: 200px;"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <center>
        <div class="inner-content-title">
            Common Questions About Scholarship
        </div>

    </center>



    <div class="inner-content-title" style="color: black;">
        Getting your scholars ready
    </div>
    <div class="question">
        <h4>What types of scholarships are available in Batangas? </h4>
        <div class="faqAnswer">
            Various scholarships are available, including government-funded scholarships, private sector scholarships, and those offered by universities. Common types include merit-based, need-based, athletic, and vocational scholarships.
        </div>
    </div>




    <div class="question">
        <h4>Who is eligible to apply for scholarships in Batangas? </h4>
        <div class="faqAnswer">
            Eligibility criteria vary by scholarship. Generally, students in high school, college, or vocational programs may apply. Specific requirements may include academic performance, financial need, or extracurricular involvement.
        </div>
    </div>

    <div class="question">
        <h4>How can I find scholarship opportunities in Batangas? </h4>
        <div class="faqAnswer">
            You can find scholarship opportunities through:
            <ul>
                <li>Local government websites</li>
                <li>Educational institutions’ official pages</li>
                <li>Non-profit organizations</li>
                <li>Community bulletins and social media groups</li>
            </ul>
        </div>
    </div>

    <div class="question">
        <h4>What documents are usually required for scholarship applications? </h4>
        <div class="faqAnswer">
            <ul>
                <li>Application form</li>
                <li>Academic transcripts</li>
                <li>Certificate of good moral character</li>
                <li>Recommendation letters</li>
                <li>Proof of income or financial status</li>
                <li>Personal essay or statement of purpose</li>
            </ul>
        </div>
    </div>

    <div class="inner-content-title" style="color: black;">
        Schedule for Disbursement
    </div>


    <div class="question">
        <h4>When is the application period for scholarships?</h4>
        <div class="faqAnswer">
            Application periods vary depending on the scholarship. It's important to check the specific deadlines for each scholarship program, as they can be different from one to another.
        </div>
    </div>

    <div class="question">
        <h4>How are scholarship recipients selected? </h4>
        <div class="faqAnswer">
            Selection criteria vary by scholarship but typically include academic performance, financial need, personal essays, interviews, and recommendations.
        </div>
    </div>

    <div class="question">
        <h4>What should I do if I miss the application deadline?</h4>
        <div class="faqAnswer">
            If you miss the deadline for a specific scholarship, you may want to look for other opportunities or consider applying next year. Some scholarships may have rolling admissions or extended deadlines.
        </div>
    </div>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1VDDWMRSTH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-1VDDWMRSTH');
    </script>
    <script>
        try {
            fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", { method: 'HEAD', mode: 'no-cors' })).then(function(response) {
                return true;
            }).catch(function(e) {
                var carbonScript = document.createElement("script");
                carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
                carbonScript.id = "_carbonads_js";
                document.getElementById("carbon-block").appendChild(carbonScript);
            });
        } catch (error) {
            console.log(error);
        }
    </script>

    <center>
        <div class="inner-content-title" id="contact">
            Contact Us
        </div>

    </center>
    <br/>
    <div class="contact-in">
        <div class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3875.2277751728684!2d121.0616510736045!3d13.765133196987655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd055b7bf4813b%3A0xd5d1cf0279820f6!2sBatangas%20Provincial%20Capitol!5e0!3m2!1sen!2sph!4v1728989807938!5m2!1sen!2sph" width="100%" height="auto" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <div class="contact-form">
            <h1>Contact Form</h1>
            <form encrypt="text/plain" action="mailto:merujeshual4@gmail.com" method="GET">
                <input type="text" name="name" Placeholder="Name" class="contact-form-txt">
                <input type="email" Placeholder="Email" class="contact-form-txt" name="email">
                <textarea name="Message" placeholder="Message" class="contact-form-textarea"></textarea>
                <input type="submit" name="Submit" value="send" class="contact-form-btn" style="background-color: #4CAF50;">
            </form>
        </div>
    </div>
    <br>
</section>


<div class="text-center p-3" style="text-align: center;color: white; width:100%;padding:10px;background-color:#4CAF50">
    Batangas Scholarship Disbursement System © 2024 All Rights Reserved.
</div>


</body>
</html>

<script src="jquery.gScrollingCarousel.js"></script>
<script>
    $(document).ready(function(){
        $(".carousel .items").gScrollingCarousel();
        $(".carousel-two .items").gScrollingCarousel({
            mouseScrolling: false,
            draggable: true,
            snapOnDrag: false,
            mobileNative: false,
        });
        $(".carousel-three .items").gScrollingCarousel({
            scrollAmount: 'single'
        });
        $(".carousel-four .items").gScrollingCarousel({
            mouseScrolling: true,
            draggable: false,
            snapOnDrag: false,
        });
    });
</script>
</body>
</html>

