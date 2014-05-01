<img src="images/header.png" alt="header" width="100%" height="200px"/>
			<ul class="nav">
				<li><a href="?page=Modules_Home">Home</a></li>
				<li><a href="?page=Modules_Register">Register</a></li>	
				<li><a href="?page=Modules_Download">Download</a></li>
				<li><a>Rankings</a>
					<div style="height:20px"></div>
					<ul class="nav">
						<li><a href="/?page=Modules_Rankings&subpage=Auction">Auction</a></li>
						<li><a>Races</a>
							<div style="height:28px"></div>
							<ul class="nav">
								<li><a href="/?page=Modules_Rankings&subpage=Races&race=17">Blade Knight</a></li>
								<li><a href="/?page=Modules_Rankings&subpage=Races&race=1">Soul Master</a></li>
								<li><a href="/?page=Modules_Rankings&subpage=Races&race=48">Magic Gladiator</a></li>
								<li><a href="/?page=Modules_Rankings&subpage=races&race=33">Muse Elf</a></li>
								<li><a href="/?page=Modules_Rankings&subpage=races&race=0">Dark Knight</a></li>
								<li><a href="/?page=Modules_Rankings&subpage=races&race=16">Dark Wizard</a></li>
								<li><a href="/?page=Modules_Rankings&subpage=races&race=32">Elf</a></li>
							</ul>
						</li>
						<li><a href="/?page=Modules_Rankings&subpage=Week_Online_Time">WeekOnlineTime</a></li>
						<li><a href="/?page=Modules_Rankings&subpage=Characters">Characters</a></li>
						<li><a href="/?page=Modules_Rankings&subpage=Guilds">Guilds</a></li>
					</ul>
				</li>
				<li><a>Information</a>
					<div style="height:20px"></div>
					<ul class="nav">
						<li><a href="/?page=Modules_Information&subpage=Server">Server</a></li>
						<li><a>Monsters</a>
							<div style="height:28px"></div>
							<ul class="nav">
								<?php
									for ($i = 0; $i < count($server['Citys']); $i++)
									{
										echo"<li><a href=\"?page=Modules_Information&subpage=Monsters&city=".$server['Citys'][$i]."\">".$server['Citys'][$i]."</a></li>";
									}
								?>
							</ul>
						</li>
						<li><a href="/?page=Modules_Information&subpage=Quests">Quests</a></li>
						<li><a>Drop</a>
							<div style="height:28px"></div>
							<ul class="nav">
								<li><a href="/?page=Modules_Information&subpage=Drop&Box=1">Box +1</a></li>
								<li><a href="/?page=Modules_Information&subpage=Drop&Box=2">Box +2</a></li>
								<li><a href="/?page=Modules_Information&subpage=Drop&Box=3">Box +3</a></li>
								<li><a href="/?page=Modules_Information&subpage=Drop&Box=4">Box +4</a></li>
								<li><a href="/?page=Modules_Information&subpage=Drop&Box=5">Box +5</a></li>
							</ul>
						</li>
						<li><a href="/?page=Modules_Information&subpage=Statistics">Statistics</a></li>
						<li><a href="/?page=Modules_Information&subpage=Rules">Rules</a></li>
						<li><a href="/?page=Modules_Information&subpage=Contacts">Contacts</a></li>
					</ul>
				</li>
			<ul>