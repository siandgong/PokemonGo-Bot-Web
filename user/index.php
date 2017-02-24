<?php
session_start();
if(empty($_SESSION['ID']))
    die("<script>alert('로그인이 필요합니다.');location.href='./../#login';</script>");
$id = $_SESSION['ID'];
?>

<?php
require_once('../db.php');
$p_bot = new PokemonGo_Bot();
$idx = $p_bot->get_idx($_SESSION['ID']);
?>

<!DOCTYPE HTML>
<!--
	Hyperspace by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>PokemonGo Bot</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2TBP8mfOsIt9ZRyFWfniCeWcN5C7KPr8"></script>
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
        <script src="http://code.jquery.com/jquery-1.11.0.js"></script>

        <style type="text/css">
            #map { height: 100%; }
        </style>
	</head>
	<body>

		<!-- Sidebar -->
			<section id="sidebar">
				<div class="inner">
					<nav>
						<ul>
							<li><a href="#setting_bot">설정</a></li>
                            <?php if ($p_bot->get_bot_config_flag($idx)) { ?>
							<li><a href="#log">로그</a></li>
							<li><a href="#map">지도</a></li>
							<li><a href="#two">문서</a></li>
                            <?php } ?>
						</ul>
					</nav>
				</div>
			</section>

		<!-- Wrapper -->
			<div id="wrapper">
                <?php if (!$p_bot->is_exist_bot_account($idx)) { ?>
                <section id="setting_bot" class="wrapper style1 fullscreen spotlights" style="height:100%">
                    <div class="inner">
                        <h2>사용자 봇 설정</h2>
                        <p>Only Support Google Account. Phasellus convallis elit id ullamcorper pulvinar. Duis aliquam turpis mauris, eu ultricies erat malesuada quis. Aliquam dapibus, lacus eget hendrerit bibendum, urna est aliquam sem, sit amet imperdiet est velit quis lorem.</p>
                        <div class="split style1">
                            <section>
                                <form method="post" action="regist_bot.php">
                                    <div class="field half first">
                                        <label for="name">이메일</label>
                                        <input type="email" name="email" id="email" />
                                    </div>
                                    <div class="field half">
                                        <label for="email">비밀번호</label>
                                        <input type="password" name="pw" id="pw" />
                                    </div>
                                    <div class="field">
                                        <label for="message">해시키</label>
                                        <textarea name="hash_key" id="hash_key" rows="5"></textarea>
                                    </div>
                                    <ul class="actions">
                                        <li style="width:100%"><a href="" style="font-size:0.8em;width:100%" class="button submit">제출</a></li>
                                    </ul>
                                </form>
                            </section>
                            <section>
                                <br><br><br>
                                <ul class="contact">
                                    <li>
                                        <h3>이메일 형식</h3>
                                        <span>구글 계정만 지원합니다.</span>
                                    </li>
                                    <li>
                                        <h3>주의사항</h3>
                                        <span>사이트를 통해 발생하는 <br>모든 책임은 사용자에게 있습니다.</span>
                                    </li>
                                    <li>
                                        <h3>기타 문의</h3>
                                        <a href="#">siandgong@naver.com</a>
                                    </li>
                                </ul>
                            </section>
                        </div>
                    </div>
                </section>
                <?php } else {?>
                    <section id="setting_bot" class="wrapper style2 fullscreen spotlights" style="height:100%">
                        <div class="inner">
                            <h2>봇 설정</h2>
                            <p>Only Support Google Account. Phasellus convallis elit id ullamcorper pulvinar. Duis aliquam turpis mauris, eu ultricies erat malesuada quis. Aliquam dapibus, lacus eget hendrerit bibendum, urna est aliquam sem, sit amet imperdiet est velit quis lorem.</p>
                            <div class="split style1">
                                <section>
                                    <form method="post" action="make_config_file.php">
                                        <div class="field half first">
                                            <label for="name">시작 좌표</label>
                                            <input type="text" name="bot_geolocation" id="bot_geolocation" placeholder="37.497967, 127.027238"/>
                                        </div>
                                        <div class="field half">
                                            <label for="time">동작 시간</label>
                                            <input type="text" name="bot_during_run_time" id="bot_during_run_time" placeholder="12시간"/>
                                        </div>
                                        <div class="field">
                                            <label for="message">기타 세팅</label>
                                            <textarea name="hash_key" id="hash_key" rows="5"></textarea>
                                        </div>
                                        <ul class="actions">
                                            <li style="width:100%"><a href="" style="font-size:0.8em;width:100%" class="button submit">세팅</a></li>
                                        </ul>
                                    </form>
                                </section>
                                <section>
                                    <br><br><br>
                                    <ul class="contact">
                                        <li>
                                            <h3>사용자 계정</h3>
                                            <span><?php echo $p_bot->get_bot_email($idx); ?></span>
                                        </li>
                                        <li>
                                            <h3>해시키</h3>
                                            <span><?php echo $p_bot->get_bot_hashkey($idx); ?></span>
                                        </li>
                                        <li>
                                            <h3>기타</h3>
                                            <a href="#">초기설정 변경</a>
                                        </li>
                                    </ul>
                                </section>
                            </div>
                        </div>
                    </section>
                <?php }?> 
                <?php if ($p_bot->get_bot_config_flag($idx)) { ?>
                     <section id="log" class="wrapper style1 fullscreen fade-up">
						<div class="inner">
							<h2>봇 실행 로그</h2>
							<p>봇 실행 후 조금 후에 새로고침 하시면 잡은 포켓몬 목록이 출력됩니다.<br> Phasellus convallis elit id ullamcorper pulvinar. Duis aliquam turpis mauris, eu ultricies erat malesuada quis. Aliquam dapibus, lacus eget hendrerit bibendum, urna est aliquam sem, sit amet imperdiet est velit quis lorem.</p>
							<div class="split" style="width:100%">
								<section style="width:22.2%">
                                    <ul class="actions">
                                        <li style="width:100%">
                                            <a href="./start_bot.php" style="font-size:0.8em;width:100%" class="button submit">실행</a>
                                            <hr>
                                            <a href="./stop_bot.php" style="font-size:0.8em;width:100%" class="button submit">종료</a>
                                        </li>
                                    </ul>
								</section>
                <section style="width:77.7%" id="bot_log">
								<script>
                $(document).ready(function(){
                    var refresh_log = function() {
                      url = './read_log.php';
                      $.ajax({
                          type:"GET",
                          url:url,
                          success:function(args){
                              $("#bot_log").html(args);
                          },
                          error:function(e){
                              console.log('read_log error');
                              alert(e.responseText);
                          }
                     });
                    }
                    self.setInterval(refresh_log, 2000);
                });
								</script>
							</div>
						</div>
					</section>

					<section id="map" style="height:100%;background-color:rgb(110, 86, 116);" class="wrapper style4 fullscreen fade-up">
            <div id="bot_map" style="z-index:9999; width: -webkit-calc(100% - 20px);height:80%;left:10px;border-radius:20px;position:absolute"></div>
                <script type="text/javascript">
								// Geolocation API에 액세스할 수 있는지를 확인
								var map;
								function initMap() {
									map = new google.maps.Map(document.getElementById('bot_map'), {
										center: {lat: 37.520034, lng: 126.9155836},
										zoom: 15
									});
                  var infoWindow = new google.maps.InfoWindow({content: "<p style='color:black'><?php echo $p_bot->get_bot_email($idx);?></p>", map: map});

                  var flag = true;
                  var refresh_log = function() {
                        url = './read_geolocation.php';
                        $.ajax({
                            type:"GET",
                            url:url,
                            success:function(args){
                                var pos = {
                                lat: parseFloat(args.split(', ')[0]),
                                lng: parseFloat(args.split(', ')[1])
                                };

                                if(flag) {
                                  flag = false;
                                  map.setCenter(pos);
                                }
                                infoWindow.setPosition(pos);
                            },
                            error:function(e){
                                console.log('read geolocation error');
                                alert(e.responseText);
                            }
                       });
                  }

                  self.setInterval(refresh_log, 3000);
								}
                initMap();


                </script>
					</section>

				<!-- One -->

				<!-- Two -->
					<section id="two" class="wrapper style3 fade-up">
						<div class="inner">
							<h2>What we do</h2>
							<p>Phasellus convallis elit id ullamcorper pulvinar. Duis aliquam turpis mauris, eu ultricies erat malesuada quis. Aliquam dapibus, lacus eget hendrerit bibendum, urna est aliquam sem, sit amet imperdiet est velit quis lorem.</p>
							<div class="features">
								<section>
									<span class="icon major fa-code"></span>
									<h3>Lorem ipsum amet</h3>
									<p>Phasellus convallis elit id ullam corper amet et pulvinar. Duis aliquam turpis mauris, sed ultricies erat dapibus.</p>
								</section>
								<section>
									<span class="icon major fa-lock"></span>
									<h3>Aliquam sed nullam</h3>
									<p>Phasellus convallis elit id ullam corper amet et pulvinar. Duis aliquam turpis mauris, sed ultricies erat dapibus.</p>
								</section>
								<section>
									<span class="icon major fa-cog"></span>
									<h3>Sed erat ullam corper</h3>
									<p>Phasellus convallis elit id ullam corper amet et pulvinar. Duis aliquam turpis mauris, sed ultricies erat dapibus.</p>
								</section>
								<section>
									<span class="icon major fa-desktop"></span>
									<h3>Veroeros quis lorem</h3>
									<p>Phasellus convallis elit id ullam corper amet et pulvinar. Duis aliquam turpis mauris, sed ultricies erat dapibus.</p>
								</section>
								<section>
									<span class="icon major fa-chain"></span>
									<h3>Urna quis bibendum</h3>
									<p>Phasellus convallis elit id ullam corper amet et pulvinar. Duis aliquam turpis mauris, sed ultricies erat dapibus.</p>
								</section>
								<section>
									<span class="icon major fa-diamond"></span>
									<h3>Aliquam urna dapibus</h3>
									<p>Phasellus convallis elit id ullam corper amet et pulvinar. Duis aliquam turpis mauris, sed ultricies erat dapibus.</p>
								</section>
							</div>
							<ul class="actions">
								<li><a href="#" class="button">Learn more</a></li>
							</ul>
						</div>
					</section>
                    <?php }?>

			</div>

		<!-- Footer -->
			<footer id="footer" class="wrapper style1-alt">
				<div class="inner">
					<ul class="menu">
						<li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>
				</div>
			</footer>

      <!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
	</body>
</html>
