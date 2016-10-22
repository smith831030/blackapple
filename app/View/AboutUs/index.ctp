			<!--<ABOUT BLACK APPLE>-->
			<div class="container">
				<div class="col-md-2">
					<img src="img/aboutba/profile_image.jpg" title="profile image" alt="profile image" width="150" height="210" />
				</div>

				<!--<PROFILE>-->
				<div class="col-md-5">
					<div id="profile_dh">
						<h2>DH's Profile</h2>

						<table class="table">
							<colgroup>
								<col class="type" />
								<col class="content" />
							</colgroup>
							<tbody>
								<tr>
									<th>Name</th>
									<td>DH = Dark Hwan = JANGHO,SEO</td>
								</tr>
								<tr >
									<th>Sex</th>
									<td>Male</td>
								</tr>
								<tr>
									<th>Nationality</th>
									<td>Republic of Korea</td>
								</tr>
								<tr >
									<th>Date of birth</th>
									<td>1983.10.30</td>
								</tr>
								<tr>
									<th>Blood type</th>
									<td>A(RH+)</td>
								</tr>
								<tr >
									<th>Interests</th>
									<td>Playing basketball, Watching soccer, Drawing, Cooking</td>
								</tr>
								<tr>
									<th>Occupation</th>
									<td>Web Developer</td>
								</tr>
								<tr >
									<th>Skills</th>
									<td>HTML, JAVASCRIPT, CSS, JQUERY, ASP, PHP, JAVA, MSSQL, MySQL</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div id="profile_history">
						<h2>History</h2>

						<table class="table">
							<colgroup>
								<col class="type" />
								<col class="content" />
							</colgroup>
							<thead>
								<tr>
									<th>Date</th>
									<th>Content</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>2016.09-NOW</td>
									<td>Web developer @Furphy media in South Melbourne, Australia</td>
								</tr>
								<tr>
									<td>2015.07-2016.07</td>
									<td>Full-stack web developer @AGS in Melbourne, Australia</td>
								</tr>
								<tr >
									<td>2013.01-2015.05</td>
									<td>Freelance web developer &amp; designer, @<a href="http://gamichicken.com.au" target="_blank" class="highlight">Gami chicken&beer</a>, Melbourne, Australia</td>
								</tr>
								<tr>
									<td>2012.08-2013.08</td>
									<td>Learning about cooking Japanese foods in Melbourne, Australia</td>
								</tr>
								<tr >
									<td>2012.06-2012.08</td>
									<td>General English course @IMEC in Baguio, Philippine</td>
								</tr>
								<tr>
									<td>2012.03-2012.06</td>
									<td>Part-time web developer @Tupolar.com in Korea</td>
								</tr>
								<tr >
									<td>2011.08-2012.03</td>
									<td>Travelling in Australia</td>
								</tr>
								<tr>
									<td>2011.03-2011.07</td>
									<td>General English course @Shafston college in Brisbane, Australia</td>
								</tr>
								<tr >
									<td>2010.01-2011.2</td>
									<td>Part-time lecturer, Web programming course on the weekend @HIMEDIA computer school in Korea</td>
								</tr>
								<tr>
									<td>2008.11-2009.12</td>
									<td>Part-time lecturer, Web programming course on the weekend @Green art computer school in Korea</td>
								</tr>
								<tr >
									<td>2007.12-2011.01</td>
									<td>Full-time web developer @JCEntertainment in Korea</td>
								</tr>
								<tr>
									<td>2007.08</td>
									<td>Part-time web developer @JCEntertainment in Korea</td>
								</tr>
								<tr >
									<td>2007.06</td>
									<td>Internship web developer @JCEntertainment in Korea</td>
								</tr>
								<tr>
									<td>2005.06-2007.06</td>
									<td>Network army, Network team @Capital corps in Korea</td>
								</tr>
								<tr >
									<td>2004-2005</td>
									<td>Freelance web developer in Korea</td>
								</tr>
								<tr>
									<td>2004</td>
									<td>Computer network course, Korea cyber university, Korea</td>
								</tr>
								<tr >
									<td>2003-2004</td>
									<td>Studying web develop course, Green computer art school, Korea</td>
								</tr>
								<tr>
									<td>2002-2003</td>
									<td>Assistance professional cartoonist, Korea</td>
								</tr>
								<tr >
									<td>2002</td>
									<td>Animation course, Seoul Ah-Hyun high school, Korea</td>
								</tr>
								<tr>
									<td>1999-2001</td>
									<td>Seoul Se-Jong high school, Korea</td>
								</tr>
								<tr >
									<td>1996-1999</td>
									<td>Seoul Su-Seo junior high school, Korea</td>
								</tr>
								<tr>
									<td>1993-1996</td>
									<td>Seoul Ban-Won elementary school, Korea</td>
								</tr>
								<tr >
									<td>1990-1993</td>
									<td>Seoul Wal-Cheon elementary school, Korea</td>
								</tr>
								<tr>
									<td>1983.10.30</td>
									<td>Born in Busan, Korea</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!--</PROFILE>-->

				<!--<BLACK APPLE>-->
				<div class="col-md-5">
					<div id="blackapple_history">
						<h2>BlackApple's history</h2>

						<table class="table">
							<colgroup>
								<col class="type" />
								<col class="content" />
							</colgroup>
							<thead>
								<tr>
									<th>DATE</th>
									<th>CONTENT</th>
								</tr>
							</thead>
							<tbody>
								<?php $historyI=0;?>
								<?php foreach ($posts as $post): ?>
								<?php
								$history_wb_date=$post['WsHistory']['wb_date'];;
								$history_new_wb_date=substr($history_wb_date,0,10);
								$history_new_wb_date=str_replace("-", ".", $history_new_wb_date);
								$history_wb_content=$post['WsHistory']['wb_content'];
								$history_wb_content=str_replace("&", "&amp;", $history_wb_content);
								if($historyI%2==1)
									$historyBG="class='bg'";
								else
									$historyBG="";
								?>
								<tr <?php echo $historyBG?>>
									<td><?php echo $history_new_wb_date?></td>
									<td><?php echo $history_wb_content?></td>
								</tr>
								<?php $historyI++; ?>
								<?php endforeach; ?>
								<?php unset($post); ?>

								<tr >
									<td>2005.06</td>
									<td>Attended "47th Seoul Comic World" festival with my <a href="/Works/DoorEp2" class="highlight">original comic book</a></td>
								</tr>
								<tr>
									<td>2003</td>
									<td>Dong-Wook withdrew</td>
								</tr>
								<tr >
									<td>2002</td>
									<td>Attended "Seoul Comic World" festival with our original illustration book</td>
								</tr>
								<tr>
									<td>2001</td>
									<td>Changed team name to "Black Apple"</td>
								</tr>
								<tr >
									<td>1999</td>
									<td>Yong-Wook withdrew and changed team name to "Ruin"</td>
								</tr>
								<tr>
									<td>1998</td>
									<td>Made an amateur artist team "Freestyle" with Dong-Wook and Yong-Wook</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!--</BLACK APPLE>-->
