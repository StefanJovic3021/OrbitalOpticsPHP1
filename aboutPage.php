<?php
    include_once ("php/conn.php");
    session_start();
?>
<!DOCTYPE HTML>
<!--
	Hielo by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
    <!-- Head -->
    <?php include_once 'pages/components/head.php'; ?>

    <body>
        <!-- Header -->
        <?php include_once 'pages/components/header.php'; ?>

        <!-- Nav -->
        <?php include_once 'pages/components/navigation.php'; ?>

        <div id="aboutPage">
            <!-- One -->
            <section id="One" class="wrapper style3">
                <div class="inner">
                    <header class="align-center">
                        <p>Learn more about our company and our goals</p>
                        <h2>About us | Contact</h2>
                    </header>
                </div>
            </section>

            <!-- Two -->
            <section id="two" class="wrapper style2">
                <div class="inner">
                    <div class="box">
                        <div class="content">
                            <header class="align-center">
                                <p>Introduction</p>
                                <h2>About Us</h2>
                            </header>
                            <div class="about_block center_block">
                                <p>Welcome to Orbital Optics, your one-stop destination for all things related to the cosmos and beyond. We are passionate stargazers, astronomers, and science enthusiasts on a mission to bring the wonders of the universe closer to you.</p>
                                <p>Our vision is simple yet profound: to inspire curiosity about the cosmos and foster a deeper appreciation for the beauty and mysteries of outer space. We believe that the universe has a lot to offer, from breathtaking celestial phenomena to the joy of stargazing with loved ones.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="inner">
                    <div class="box">
                        <div class="content">
                            <header class="align-center">
                                <p>Take a peek</p>
                                <h2>What We Offer</h2>
                            </header>
                            <div class="about_block">
                                <p>At Orbital Optics, we offer a carefully curated selection of products that cater to your passion for space and astronomy. Whether you're an experienced astronomer searching for the perfect telescope, a space enthusiast looking for stylish apparel, or a parent eager to ignite a love for the stars in your child, we have something special for you.</p>
                                <p>Our product range includes:</p>
                                <ul>
                                    <li><strong>Telescopes:</strong> Explore the depths of the universe with our high-quality telescopes, designed to bring distant galaxies and celestial objects closer to your view.</li>
                                    <li><strong>Astronomy Apparel:</strong> Express your cosmic love with our collection of astronomy-themed hoodies, t-shirts, and accessories. Wear your passion proudly!</li>
                                    <li><strong>Educational Toys:</strong> Ignite a lifelong interest in space with our selection of space-themed toys and educational materials, perfect for all ages.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="inner">
                    <div class="box">
                        <div class="content">
                            <header class="align-center">
                                <p>We are the best</p>
                                <h2>Why Choose Us?</h2>
                            </header>
                            <div class="about_block">
                                <ol>
                                    <li><strong>Passion:</strong> We're passionate about astronomy, just like you. Our products are handpicked with care to ensure they meet the highest standards.</li>
                                    <li><strong>Quality:</strong> We believe in quality over quantity. Our products are sourced from reputable brands known for their excellence.</li>
                                    <li><strong>Community:</strong> Join our growing community of space enthusiasts. Follow us on social media, share your stargazing experiences, and connect with like-minded individuals.</li>
                                    <li><strong>Customer Satisfaction:</strong> Your satisfaction is our priority. We're here to assist you at every step of your cosmic journey.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="inner">
                    <div class="box">
                        <div class="content">
                            <header class="align-center">
                                <p>Keep us on your radar</p>
                                <h2>Join Us on This Cosmic Adventure</h2>
                            </header>
                            <div class="about_block center_block">
                                <p>Thank you for choosing Orbital Optics as your space exploration partner. Together, let's embark on a cosmic adventure and explore the mysteries of the universe. We look forward to being a part of your stargazing journey.</p>
                                <div id="socials_platform">
                                    <a href="https://www.twitter.com"><div class="social_card" id="twitter_splash">
                                            <p><i class="icon fa-twitter"></i> TWITTER</p>
                                        </div></a>
                                    <a href="https://www.facebook.com"><div class="social_card" id="facebook_splash">
                                            <p><i class="icon fa-facebook"></i> FACEBOOK</p>
                                        </div></a>
                                    <a href="https://www.instagram.com"><div class="social_card" id="instagram_splash">
                                            <p><i class="icon fa-instagram"></i> INSTAGRAM</p>
                                        </div></a>
                                    <a href="#"><div class="social_card" id="email_splash">
                                            <p><i class="icon fa-envelope-o"></i> E-MAIL</p>
                                        </div></a>
                                </div>
                                <p>Feel free to reach out to us anytime on our social platforms. Clear skies and happy stargazing!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <?php include_once 'pages/components/footer.php'; ?>

    </body>
    <style>
        .about_block {
            display: flex;
            align-items: flex-start;
            flex-direction: column;
            text-align: start;
        }
        .about_block p {
            font-size: 18px;
            padding: 20px;
        }
        .center_block {
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        #socials_platform {
            width: 100%;
            display: flex;
            align-items: center;
        }
        #socials_platform p {
            margin: 0;
            padding: 0;
            text-transform: uppercase;
            font-family: "Poppins", sans-serif;
            font-size: 25px;
            font-weight: bold;
        }
        #socials_platform a {
            color: #fff;
            text-decoration: none;
            width: 25%;
        }
        #socials_platform .social_card {
            padding: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease-in-out;
        }
        #socials_platform #twitter_splash {
            background: rgb(29, 160, 242);
        }
        #socials_platform #facebook_splash {
            background: rgb(66, 103, 178);
        }
        #socials_platform #instagram_splash {
            background: linear-gradient(115deg, #f9ce34, #ee2a7b, #6228d7);
        }
        #socials_platform #email_splash {
            background: rgb(255, 192, 0);
        }
        #socials_platform #twitter_splash:hover, #socials_platform #facebook_splash:hover, #socials_platform #instagram_splash:hover, #socials_platform #email_splash:hover {
            transform: scale(1.05);
            /* background-color: rgba(0, 255, 0, 0.5); */
            background: rgb(255, 255, 255);
            color: rgb(0, 0, 0);
        }
    </style>
</html>