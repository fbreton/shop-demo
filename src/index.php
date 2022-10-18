<?php
session_start();
require("tools.php");
require_once "mobile-detect/Mobile_Detect.php";

$detect = new Mobile_Detect;
if (!$detect->isMobile()) $device = "Computer";
else if ($detect->isiPhone()) $device = "iPhone";
else if ($detect->isSamsung()) $device = "Samsung";
else if ($detect->isAndroidOS()) $device = "Android";

$_SESSION["device"] = $device;

//DEFAULT
if (!isset($_ENV["LOGO"]) || empty($_ENV["LOGO"])) $_ENV["LOGO"] = "/img/customer/default-logo.png";
if (!isset($_ENV["BACKGROUND"]) || empty($_ENV["BACKGROUND"])) $_ENV["BACKGROUND"] = "/img/customer/default-background.png";
if (!isset($_SESSION['buyer']))
{
    $_SESSION['buyer'] = readable_random_string();
}
?>
	<!DOCTYPE html>
	<html lang="zxx" class="no-js">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="img/fav.png">
		<!-- Author Meta -->
		<meta name="author" content="codepixer">
		<!-- Meta Description -->
		<meta name="description" content="">
		<!-- Meta Keyword -->
		<meta name="keywords" content="">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<title>Online Shopping!</title>

		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="css/linearicons.css">
			<link rel="stylesheet" href="css/font-awesome.min.css">
			<link rel="stylesheet" href="css/bootstrap.css">
			<link rel="stylesheet" href="css/magnific-popup.css">
			<link rel="stylesheet" href="css/nice-select.css">					
			<link rel="stylesheet" href="css/animate.min.css">
			<link rel="stylesheet" href="css/owl.carousel.css">
			<link rel="stylesheet" href="css/main.css">
		</head>
		<body>
		<script>

function DoAction(v_action, v_value)
{
	console.log("Updating customer to :"+v_value);
	$.ajax({
		type: "GET",
		url: '/tools.php',
		data: {action: v_action, value: v_value},
		success: function(data){
			console.log(data);
		}
	});
			
}

		window.count_wallet=0;
		function Checkout(v_metric, v_value)
			{
				v_value = window.count_wallet;
				
				if (v_value <= 0)
				{
					$("div.shoppingcart" ).html("<p>EMPTY!</p>");
					return;
				}

				$( ".shoppingcart" ).show();
				$("div.shoppingcart" ).html("<p><img src='img/loader.gif' width='40px' marging-bottom:'15px'></p>");
				console.log("Try to send ["+v_metric+"] and ["+v_value+"]");
				$.ajax({
					type: "GET",
					url: '/api-signalfx.php',
					data: {metric: v_metric, value: v_value},
					success: function(data){
						if (data == "-1")
							$("div.shoppingcart" ).html("<p>ERROR</p>");
						else
						{
						console.log(data);
						window.count_wallet = 0;
						$("div.shoppingcart" ).html("<p>DONE!</p>");
						}
					}
				});
						
			}


			function AddToCart(v_metric, v_value)
			{
				$( ".shoppingcart" ).show();
				$("div.shoppingcart" ).html("<p><img src='img/loader.gif' width='40px' marging-bottom:'15px'></p>");
				console.log("Try to send ["+v_metric+"] and ["+v_value+"]");
				$.ajax({
					type: "GET",
					url: '/api-signalfx.php',
					data: {metric: v_metric, value: v_value},
					success: function(data){
						//if (data == "-1")
						//	$("div.shoppingcart" ).html("<p>ERROR</p>");
						//else
						//{
						console.log(data);
						window.count_wallet = parseInt(window.count_wallet) + parseInt(v_value);
						$("div.shoppingcart" ).html("<p>"+window.count_wallet+"</p>");
						//}
					}
				});
						
			}

			function Simulation()
			{
				var v_size = 60;
				$( ".shoppingcart" ).show();
				$("div.shoppingcart" ).html("<p><img src='img/loader.gif' width='40px' marging-bottom:'15px'></p>");
				alert("Simulation started for "+v_size+" seconds! Please watch the SignalFx Dashboard...");
				//console.log("Simulation starting...");
				$.ajax({
					type: "GET",
					url: '/simulation.php',
					data: {size: v_size},
					success: function(data){
						console.log(data);
						//alert("Simulation Finised!");
						$("div.shoppingcart" ).html("<p>DONE</p>");
					}
				});
						
			}

			

		


			
		</script>
		<style type="text/css">
.shoppingcart {
    background-image: url("img/bag.png");
    background-repeat: no-repeat, no-repeat;
	background-color: transparent;
	width:80px;
	height:80px;
	background-size: 80px;
	color:white;
	display:none;
}
.shoppingcart p{
   
	vertical-align: baseline;
    text-align: center;
    padding-top: 40px;
    font-size: 30px;

}
.banner-area {
    /* BACKGROUND */
    background: url(<? echo $_ENV["BACKGROUND"]; ?>) center;
    background-size: cover;
}
</style>
			  <header id="header" id="home">
			    <div class="container">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="/"><img src="<? echo $_ENV["LOGO"]; ?>" alt="" title="" height="50px"/></a>
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav-menu">
				          <li class="menu-active"><a href="#home">Home</a></li>
				          <li><a href="javascript:Simulation();">simulate Customers</a></li>
				          <li><a href="#service">share with people</a></li>
						  <li><a href="#jenkins">Canary Push</a></li>
						  <li><a href="/listen">Feedbacks</a></li>
				          <li><a href="#faq">Faq</a></li>
				          <li class="menu-has-children"><a href="">DEBUG</a>
				            <ul>
				              <li>Token: <b><?php echo $_ENV["TOKEN"]; ?></b></li>
							  <li>Realm: <b><?php echo $_ENV["REALM"]; ?></b></li>
				              <li>Hostname: <b><?php echo $_ENV["HOST"]; ?></b></li>
							  <li>"Buy-Metric=<b><?php echo $_ENV["BUYMETRIC"]; ?></b>"</li>
							  <li>"?company=<b><?php echo $_GET["company"]; ?></b>"</li>
				            </ul>
				          </li>
						  <li class="menu-has-children"><a href="">CONFIG</a>
				            <ul>
				              <li>Customer: <form><input type="text" id="customer" value="<?php echo $_SESSION['buyer']; ?>"></form></li>
				            </ul>
				          </li>
				        </ul>
				      </nav><!-- #nav-menu-container -->		    		
			    	</div>
			    </div>
			  </header><!-- #header -->


			<!-- start banner Area -->
			<section class="banner-area" id="home">	
				<div class="container">
					<div class="row fullscreen d-flex align-items-center justify-content-center">
						<div class="banner-content col-lg-10">
							<div style="margin:0 auto; margin-bottom:10px" id="SV Fintechn Corp.shoppingcart" name="shoppingcart" class="shoppingcart"><p>0</p></div>
							<h5 class="text-white text-uppercase"></h5>
							<h1>
								<?php if ($_GET['company']) echo $_GET['company']; else echo ""; ?>				
							</h1>
							<a href="javascript:AddToCart('<?php echo $_ENV["BUYMETRIC"]; ?>.cart', '1');" class="primary-btn text-uppercase">Add To Cart</a>
							<a href="javascript:Checkout('<?php echo $_ENV["BUYMETRIC"]; ?>.sold', '1');" class="primary-btn text-uppercase">Checkout!</a>
						</div>											
					</div>
				</div>
			</section>
			<!-- End banner Area -->	

					

			<!-- Start service Area -->
			<section class="service-area section-gap" id="service">
				<div class="container">
					<div class="row d-flex justify-content-center">
						<div class="col-md-8 pb-40 header-text">
							<h1>
							<?php 
							$url = $_SERVER['HTTP_HOST'];
							echo $url;
							?></h1>
							<p>
								<div style="align:center;font-size:15px">Play The Game!</div>
								<?php echo '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$url.'"%2F&choe=UTF-8" width="100%">'; ?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-user"></span>Expert Technicians</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-license"></span>Professional Service</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>								
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-phone"></span>Great Support</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>								
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-rocket"></span>Technical Skills</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>				
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-diamond"></span>Highly Recomended</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>								
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-bubble"></span>Positive Reviews</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>									
							</div>
						</div>						
					</div>
				</div>	
			</section>
			<!-- End service Area -->

				<!-- Start Jenkins Area -->
			<section class="service-area section-gap" id="jenkins">
				<div class="container">
					<div class="row d-flex justify-content-center">
						<div class="col-md-8 pb-40 header-text">
							<h1>
							Do a Canary Push, in production?</h1>
							<p>
								<a href="api.php?kill=true"><img src="img/jenkins.png" /><br>If you know what you are doing: HERE</a>
								<div style="align:center;font-size:15px"><a href="api.php?run=true">To revert and Fix the app: HERE</a></div>
								
							</p>
						</div>
					</div>
					
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-rocket"></span>Technical Skills</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>				
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-diamond"></span>Highly Recomended</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>								
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="single-service">
								<h4><span class="lnr lnr-bubble"></span>Positive Reviews</h4>
								<p>
									Usage of the Internet is becoming more common due to rapid advancement of technology and power.
								</p>									
							</div>
						</div>						
					</div>
				</div>	
			</section>
			<!-- End service Area -->	

			
			<!-- start footer Area -->		
			<footer class="footer-area section-gap">
				<div class="container">
					<div class="row">
						<div class="col-lg-5 col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>About Us</h6>
								<p>
									Powered by <a href="mailto:ecointet@signalfx.com">Etienne Cointet</a> for SignalFx - 2019.
								</p>
								<p class="footer-text">
									<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
								</p>								
							</div>
						</div>
						<div class="col-lg-5  col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>Newsletter</h6>
								<p>Stay update with our latest</p>
								<div class="" id="mc_embed_signup">
									<form target="_blank" novalidate="true" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="form-inline">
										<input class="form-control" name="EMAIL" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '" required="" type="email">
			                            	<button class="click-btn btn btn-default"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
			                            	<div style="position: absolute; left: -5000px;">
												<input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
											</div>

										<div class="info"></div>
									</form>
								</div>
							</div>
						</div>						
						<div class="col-lg-2 col-md-6 col-sm-6 social-widget">
							<div class="single-footer-widget">
								<h6>Follow Us</h6>
								<p>Let us be social</p>
								<div class="footer-social d-flex align-items-center">xs
									<a href="https://twitter.com/signalfx"><i class="fa fa-twitter"></i></a>
									<a href="https://www.signalfx.com/"><i class="fa fa-dribbble"></i></a>
									<a href="#"><i class="fa fa-behance"></i></a>
								</div>
							</div>
						</div>							
					</div>
				</div>
			</footer>	
			<!-- End footer Area -->	

			<script src="js/vendor/jquery-2.2.4.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
			<script src="js/vendor/bootstrap.min.js"></script>			
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
  			<script src="js/easing.min.js"></script>			
			<script src="js/hoverIntent.js"></script>
			<script src="js/superfish.min.js"></script>	
			<script src="js/jquery.ajaxchimp.min.js"></script>
			<script src="js/jquery.magnific-popup.min.js"></script>	
			<script src="js/owl.carousel.min.js"></script>			
			<script src="js/jquery.sticky.js"></script>
			<script src="js/jquery.nice-select.min.js"></script>			
			<script src="js/parallax.min.js"></script>	
			<script src="js/mail-script.js"></script>	
			<script src="js/main.js"></script>	

			<script>
//Customerchange
$( "#customer" ).change(function() {
	console.log($( "#customer" ).val());
	DoAction("update-customer", $( "#customer" ).val());
			});

		//End
		function GetName()
{
var person = prompt("What's your name?", "<?php echo $_SESSION["buyer"]; ?>");

if (person == null || person == "") {
  console.log("user is the default one");
} else {
	//console.log("user updated:"+person);
	DoAction("update-customer", person);
		}
}

GetName();
			</script>
		</body>
	</html>



