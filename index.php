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

		<!-- Banner -->
        <?php include_once 'pages/components/banner.php'; ?>

		<!-- One -->
			<section id="one" class="wrapper style2">
				<div class="inner">
					<div class="grid-style">

                        <div>
                            <div class="box">
                                <div class="image fit">
                                    <img src="images/custom_photos/telescopes_cover.jpg" alt="" />
                                </div>
                                <div class="content">
                                    <header class="align-center">
                                        <p>For beautiful and clear stargazing</p>
                                        <h2>Telescopes</h2>
                                    </header>
                                    <p> Discover the cosmos like never before with our exquisite collection of telescopes. Whether you're a novice stargazer or an experienced astronomer, our telescopes offer an unparalleled journey through the night sky. From powerful refracting telescopes that reveal intricate lunar landscapes to advanced reflecting telescopes that unveil distant galaxies in stunning detail. </p>
                                    <footer class="align-center">
                                        <router-link to="/products" class="button alt">Buy Now</router-link>
                                    </footer>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="box">
                                <div class="image fit">
                                    <img src="images/custom_photos/clothes_cover.jpg" alt="" />
                                </div>
                                <div class="content">
                                    <header class="align-center">
                                        <p>For astronomicaly gorgeous style</p>
                                        <h2>Clothing and Merchandise</h2>
                                    </header>
                                    <p> Immerse yourself in the grandeur of the cosmos with our captivating collection of space-themed clothing. Our unique apparel allows you to wear the beauty of the universe, showcasing stunning celestial designs that capture the spirit of exploration. From nebula-inspired patterns to artistic renderings of distant planets, our clothing lets you express your fascination with space in style. </p>
                                    <footer class="align-center">
                                        <router-link to="/products" class="button alt">Buy Now</router-link>
                                    </footer>
                                </div>
                            </div>
                        </div>

					</div>
				</div>
			</section>

		<!-- Two -->
            <section id="two" class="wrapper style3 style4">
                <div class="inner">
                    <header class="align-center">
                        <p>Millions of happy and satisfied customers all around the globe</p>
                        <h2>Where Savings and Stars Align!</h2>
                    </header>
                </div>
            </section>

		<!-- Three -->
            <section id="one" class="wrapper style2">
                <div class="inner">
                    <div class="grid-style">

                        <div>
                            <div class="box">
                                <div class="image fit">
                                    <img src="images/custom_photos/books_cover.jpg" alt="" />
                                </div>
                                <div class="content">
                                    <header class="align-center">
                                        <p>For more info about our giant universe</p>
                                        <h2>Astronomy Books and Guides</h2>
                                    </header>
                                    <p> Embark on a journey of cosmic discovery with our handpicked selection of astronomy books and guides. Whether you're a curious beginner or a seasoned stargazer, our collection offers a universe of knowledge at your fingertips. Dive into the pages of captivating narratives about the cosmos, or explore practical guides that unveil the secrets of the night sky. </p>
                                    <footer class="align-center">
                                        <router-link to="/products" class="button alt">Buy Now</router-link>
                                    </footer>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="box">
                                <div class="image fit">
                                    <img src="images/custom_photos/toys_cover.jpg" alt="" />
                                </div>
                                <div class="content">
                                    <header class="align-center">
                                        <p>For kids and visual learners</p>
                                        <h2>Astronomy Toys and Models</h2>
                                    </header>
                                    <p> Ignite young minds and kindle your own fascination with our captivating collection of astronomy toys and models. Designed to inspire the next generation of space explorers, our curated selection offers a universe of educational fun. From intricate planetarium models that simulate the night sky to interactive solar system kits that bring celestial bodies to life.  </p>
                                    <footer class="align-center">
                                        <router-link to="/products" class="button alt">Buy Now</router-link>
                                    </footer>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

        <!-- Four -->
            <section id="two" class="wrapper style3">
                <div class="inner">
                    <header class="align-center">
                        <p>Still not sure what to get? Take a peek at our other categories!</p>
                        <h2>Don't Miss Out on Celestial Deals at Our Astronomy Boutique!</h2>
                    </header>
                </div>
            </section>

        <!-- Five -->
            <section id="three" class="wrapper style2">
                <div class="inner">
                    <header class="align-center">
                        <p class="special">Take a peek at our customers' submisions</p>
                        <h2>Customers' space gallery</h2>
                    </header>
                    <div class="gallery">
                        <div>
                            <div class="image fit">
                                <a href="#"><img src="images/pic01.jpg" alt="" /></a>
                            </div>
                        </div>
                        <div>
                            <div class="image fit">
                                <a href="#"><img src="images/pic02.jpg" alt="" /></a>
                            </div>
                        </div>
                        <div>
                            <div class="image fit">
                                <a href="#"><img src="images/pic03.jpg" alt="" /></a>
                            </div>
                        </div>
                        <div>
                            <div class="image fit">
                                <a href="#"><img src="images/pic04.jpg" alt="" /></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


		<!-- Footer -->
        <?php include_once 'pages/components/footer.php'; ?>

	</body>
</html>