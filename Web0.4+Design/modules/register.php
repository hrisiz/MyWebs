<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}

	if (isset($_POST['register_now']))
	{		
		$e_mail = $_POST['E-Mail'];
		$user_name = $_POST['UserName'];
		$pass = $_POST['Password'];
		$rpass =$_POST['RepeatPassword'];
		$country = $_POST['Country'];
		$sa = $_POST['SecretAnswer'];
		$sq = $_POST['SecretQuestion'];
		$code = $_POST['RepeatCode'];
		$is_name_exist = count($grizismudb->query("Select * From MEMB_INFO Where memb___id = '$user_name'")->fetchAll());
		$is_mail_exist = count($grizismudb->query("Select * From MEMB_INFO Where mail_addr='$e-mail'")->fetchAll());
		if ($is_name_exist > 0)
		{
			echo"<p class='error'>User Name Exist!</p>";
		}
		elseif($is_mail_exist > 0)
		{
			echo"<p class='error'>E-Mail Exist!</p>";
		}
		elseif($pass  != $rpass )
		{
			echo"<p class='error'>Password and Repeat Password are not equal.</p>";
		}
		elseif(strlen($pass ) > 10 || strlen($user_name) > 10 || strlen($e-mail) > 50 || strlen($country) > 50 || strlen($sq) > 50 || strlen($sa) > 50)
		{
			echo"<p class='error'>Some fields are with more symbols then permitted.</p>";
		}
		//elseif($_SESSION['Code'] != $_POST['RepeatCode'])
		//{
		//	echo"<p class='error'>Code and Repeat Code are not equal.</p>";
		//}
		elseif($country == "x")
		{
			echo"<p class='error'>Country Field is empty.</p>";
		}
		else
		{
			$guid = $grizismudb->query("Select MAX(memb_guid) From MEMB_INFO")->fetchAll();
			$guid[0]=$guid[0][0]+1;
			$today = date("Y-m-d H:i:s"); 
			$grizismudb->beginTransaction();
			$check[0] = $grizismudb->exec("SET IDENTITY_INSERT MEMB_INFO ON ");
			$check[1] = $grizismudb->exec("Insert Into MEMB_INFO (memb_guid,memb___id,memb__pwd,memb_name,sno__numb,post_code,addr_deta,tel__numb,phon_numb,mail_addr,fpas_ques,fpas_answ,job__code,appl_days,modi_days,out__days,true_days,mail_chek,bloc_code,ctl1_code,country) values ('$guid[0]','$user_name','$pass','$user_name','Null','1234','11111','11111','11111','$-mail','$sq','$sa','1','$today','$today','$today','$today','1','0','0','$country')");
			$check[2] = $grizismudb->exec("INSERT INTO VI_CURR_INFO (ends_days,chek_code,used_time,memb___id,memb_name,memb_guid,sno__numb,Bill_Section,Bill_value,Bill_Hour,Surplus_Point,Surplus_Minute,Increase_Days )  VALUES ('2005','1',1234,'$user_name','$user_name','$guid[0]','111111111','6','3','6','6','$today','0' )");
			if(count(array_diff ($check,array_fill(0,3,''))) != 3){
				echo"<p class='error'>Problem with register module please connect with admin on skype:grizismu or e-mail:grizismu@abv.bg</p>";
			}else{
				//$grizismudb->commit();
				echo"<p class='success'>Added Successfully</p>";
			}
		}	
	}
	$_SESSION['Code'] = rand(1000,5000);
?>
<form method="POST">
	<label for="UserName">UserName</label>
	<input id="UserName" name="UserName" type="text" maxlength="10" size="11"/><br>
	<label for="Password">Password</label>
	<input id="Password" name="Password" type="password" maxlength="10" size="11"/><br>
	<label for="RepeatPassword">Repeat Password</label>
	<input id="RepeatPassword" name="RepeatPassword" type="password" maxlength="10" size="11"/><br>
	<label for="E-Mail">E-Mail</label>
	<input id="E-Mail" name="E-Mail" type="e-mail" maxlength="50" size="11"/><br>
	<label for="SecretQuestion">Secret Question</label>
	<input id="SecretQuestion" name="SecretQuestion" type="text" maxlength="50" size="11"/><br>
	<label for="SecretAnswer">Secret Answer</label>
	<input id="SecretAnswer" name="SecretAnswer" type="text" maxlength="50" size="11"/><br>
	<label for="country">Your Country</label>
	<select name="Country" id="country"><option value="x">-- Select --</option>
		<option value="Afghanistan">Afghanistan</option>
		<option value="Albania">Albania</option>
		<option value="Algeria">Algeria</option>
		<option value="Andorra">Andorra</option>
		<option value="Angola">Angola</option>
		<option value="Anguilla">Anguilla</option>
		<option value="Antarctica">Antarctica</option>
		<option value="Antigua and Barbuda">Antigua and Barbuda</option>
		<option value="Argentina">Argentina</option>
		<option value="Armenia">Armenia</option>
		<option value="Aruba">Aruba</option>
		<option value="Australia">Australia</option>
		<option value="Austria">Austria</option>
		<option value="Azerbaijan">Azerbaijan</option>
		<option value="Bahamas">Bahamas</option>
		<option value="Bahrain">Bahrain</option>
		<option value="Bangladesh">Bangladesh</option>
		<option value="Barbados">Barbados</option>
		<option value="Belgium">Belgium</option>
		<option value="Belize">Belize</option>
		<option value="Belarus">Belarus</option>
		<option value="Benin">Benin</option>
		<option value="Bermuda">Bermuda</option>
		<option value="Bhutan">Bhutan</option>
		<option value="Bolivia">Bolivia</option>
		<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
		<option value="Botswana">Botswana</option>
		<option value="Brazil">Brazil</option>
		<option value="Brunei">Brunei</option>
		<option value="Bulgaria">Bulgaria</option>
		<option value="Burkina Faso">Burkina Faso</option>
		<option value="Burundi">Burundi</option>
		<option value="Cambodia">Cambodia</option>
		<option value="Cameroon">Cameroon</option>
		<option value="Canada">Canada</option>
		<option value="Cape Verde">Cape Verde</option>
		<option value="Cayman Islands">Cayman Islands</option>
		<option value="Central African Republic">Central African Republic</option>
		<option value="Chile">Chile</option>
		<option value="China">China</option>
		<option value="Colombia">Colombia</option>
		<option value="Comoros">Comoros</option>
		<option value="Congo">Congo</option>
		<option value="Cook Islands">Cook Islands</option>
		<option value="Costa Rica">Costa Rica</option>
		<option value="Cote D Ivoire">Cote D'Ivoire</option>
		<option value="Croatia">Croatia</option>
		<option value="Cuba">Cuba</option>
		<option value="Cyprus">Cyprus</option>
		<option value="Czech Republic">Czech Republic</option>
		<option value="Denmark">Denmark</option>
		<option value="Djibouti">Djibouti</option>
		<option value="Dominica">Dominica</option>
		<option value="Dominican Republic">Dominican Republic</option>
		<option value="Ecuador">Ecuador</option>
		<option value="Egypt">Egypt</option>
		<option value="El Salvador">El Salvador</option>
		<option value="Equatorial Guinea">Equatorial Guinea</option>
		<option value="Eritrea">Eritrea</option>
		<option value="Estonia">Estonia</option>
		<option value="Ethiopia">Ethiopia</option>
		<option value="Falkland Islands">Falkland Islands</option>
		<option value="Fiji">Fiji</option>
		<option value="Finland">Finland</option>
		<option value="France">France</option>
		<option value="French Guiana">French Guiana</option>
		<option value="French Polynesia">French Polynesia</option>
		<option value="Gabon">Gabon</option>
		<option value="Gambia">Gambia</option>
		<option value="Germany">Germany</option>
		<option value="Georgia">Georgia</option>
		<option value="Ghana">Ghana</option>
		<option value="Greece">Greece</option>
		<option value="Greenland">Greenland</option>
		<option value="Grenada">Grenada</option>
		<option value="Guadeloupe">Guadeloupe</option>
		<option value="Guam">Guam</option>
		<option value="Guatemala">Guatemala</option>
		<option value="Guinea">Guinea</option>
		<option value="Guinea-Bissau">Guinea-Bissau</option>
		<option value="Guyana">Guyana</option>
		<option value="Haiti">Haiti</option>
		<option value="Honduras">Honduras</option>
		<option value="Hong Kong">Hong Kong</option>
		<option value="Hungary">Hungary</option>
		<option value="Iceland">Iceland</option>
		<option value="India">India</option>
		<option value="Indonesia">Indonesia</option>
		<option value="Iran">Iran</option>
		<option value="Iraq">Iraq</option>
		<option value="Ireland">Ireland</option>
		<option value="Israel">Israel</option>
		<option value="Italy">Italy</option>
		<option value="Jamaica">Jamaica</option>
		<option value="Japan">Japan</option>
		<option value="Jordan">Jordan</option>
		<option value="Kazakhstan">Kazakhstan</option>
		<option value="Kenya">Kenya</option>
		<option value="Kiribati">Kiribati</option>
		<option value="Kitts and Nevis">Kitts and Nevis</option>
		<option value="North Korea">North Korea</option>
		<option value="South Korea">South Korea</option>
		<option value="Kyrgyzstan">Kyrgyzstan</option>
		<option value="Kuwait">Kuwait</option>
		<option value="Laos">Laos</option>
		<option value="Latvia">Latvia</option>
		<option value="Lebanon">Lebanon</option>
		<option value="Lesotho">Lesotho</option>
		<option value="Liberia">Liberia</option>
		<option value="Libya">Libya</option>
		<option value="Liechtenstein">Liechtenstein</option>
		<option value="Lithuania">Lithuania</option>
		<option value="Luxembourg">Luxembourg</option>
		<option value="Macau">Macau</option>
		<option value="Macedonia">Macedonia</option>
		<option value="Madagascar">Madagascar</option>
		<option value="Malaysia">Malaysia</option>
		<option value="Maldives">Maldives</option>
		<option value="Mali">Mali</option>
		<option value="Marshall Islands">Marshall Islands</option>
		<option value="Malta">Malta</option>
		<option value="Northern Mariana Islands">Northern Mariana Islands</option>
		<option value="Malawi">Malawi</option>
		<option value="Martinique">Martinique</option>
		<option value="Mauritania">Mauritania</option>
		<option value="Mauritius">Mauritius</option>
		<option value="Mayotte">Mayotte</option>
		<option value="Mexico">Mexico</option>
		<option value="Micronesia">Micronesia</option>
		<option value="Moldova">Moldova</option>
		<option value="Mongolia">Mongolia</option>
		<option value="Montserrat">Montserrat</option>
		<option value="Morocco">Morocco</option>
		<option value="Mozambique">Mozambique</option>
		<option value="Myanmar">Myanmar</option>
		<option value="Namibia">Namibia</option>
		<option value="Nauru">Nauru</option>
		<option value="Nepal">Nepal</option>
		<option value="Netherlands">Netherlands</option>
		<option value="Netherlands Antilles">Netherlands Antilles</option>
		<option value="New Caledonia">New Caledonia</option>
		<option value="New Zealand">New Zealand</option>
		<option value="Nicaragua">Nicaragua</option>
		<option value="Niger">Niger</option>
		<option value="Nigeria">Nigeria</option>
		<option value="Niue">Niue</option>
		<option value="Norway">Norway</option>
		<option value="Oman">Oman</option>
		<option value="Pakistan">Pakistan</option>
		<option value="Palau">Palau</option>
		<option value="Panama">Panama</option>
		<option value="Papua New Guinea">Papua New Guinea</option>
		<option value="Paraguay">Paraguay</option>
		<option value="Peru">Peru</option>
		<option value="Philippines">Philippines</option>
		<option value="Pitcairn Island">Pitcairn Island</option>
		<option value="Poland">Poland</option>
		<option value="Portugal">Portugal</option>
		<option value="Puerto Rico">Puerto Rico</option>
		<option value="Qatar">Qatar</option>
		<option value="Reunion">Reunion</option>
		<option value="Romania">Romania</option>
		<option value="Russia">Russia</option>
		<option value="Rwanda">Rwanda</option>
		<option value="Saint Lucia">Saint Lucia</option>
		<option value="Saint Vincent and the Grenadines">SV and Grenadines</option>
		<option value="Samoa-American">Samoa-American</option>
		<option value="Samoa-Western">Samoa-Western</option>
		<option value="San Marino">San Marino</option>
		<option value="Sao Tome and Principe">Sao Tome and Principe</option>
		<option value="Saudi Arabia">Saudi Arabia</option>
		<option value="Senegal">Senegal</option>
		<option value="Seychelles">Seychelles</option>
		<option value="Sierra Leone">Sierra Leone</option>
		<option value="Singapore">Singapore</option>
		<option value="Slovakia">Slovakia</option>
		<option value="Slovenia">Slovenia</option>
		<option value="Solomon Islands">Solomon Islands</option>
		<option value="Somalia">Somalia</option>
		<option value="South Africa">South Africa</option>
		<option value="Spain">Spain</option>
		<option value="Sri Lanka">Sri Lanka</option>
		<option value="Sudan">Sudan</option>
		<option value="Suriname">Suriname</option>
		<option value="Swaziland">Swaziland</option>
		<option value="Sweden">Sweden</option>
		<option value="Switzerland">Switzerland</option>
		<option value="Syria">Syria</option>
		<option value="Taiwan">Taiwan</option>
		<option value="Tajikistan">Tajikistan</option>
		<option value="Tanzania">Tanzania</option>
		<option value="Thailand">Thailand</option>
		<option value="Togo">Togo</option>
		<option value="Tonga">Tonga</option>
		<option value="Trinidad and Tobago">Trinidad and Tobago</option>
		<option value="Tunisia">Tunisia</option>
		<option value="Turkey">Turkey</option>
		<option value="Turkmenistan">Turkmenistan</option>
		<option value="Tuvalu">Tuvalu</option>
		<option value="Uganda">Uganda</option>
		<option value="Ukraine">Ukraine</option>
		<option value="United Arab Emirate">United Arab Emirates</option>
		<option value="United Kingdom">United Kingdom</option>
		<option value="USA">USA</option>
		<option value="Uruguay">Uruguay</option>
		<option value="Uzbekistan">Uzbekistan</option>
		<option value="Vanuatu">Vanuatu</option>
		<option value="Vatican City">Vatican City</option>
		<option value="Venezuela">Venezuela</option>
		<option value="Virgin Islands">Virgin Islands</option>
		<option value="Vietnam">Vietnam</option>
		<option value="Western Sahara">Western Sahara</option>
		<option value="Yemen">Yemen</option>
		<option value="Yugoslavia">Yugoslavia</option>
		<option value="Zambia">Zambia</option>
		<option value="Zimbabwe">Zimbabwe</option>
		<option value="APO">APO</option>
		<option value="FPO">FPO</option>
		<option value="Other">Other</option>
		<option value="Bouvet Island">Bouvet Island</option>
		<option value="British Indian Ocean Territory">British Indian Ocean</option>
		<option value="Chad">Chad</option>
		<option value="Cocos(Keeling) Islands">Cocos(Keeling) Islands</option>
		<option value="East Timor">East Timor</option>
		<option value="Faroe Islands">Faroe Islands</option>
		<option value="French Southern Territories">French Southern Territories</option>
		<option value="Gibraltar">Gibraltar</option>
		<option value="Heard and McDonald Islands">Heard and McDonald Islands</option>
		<option value="Monaco">Monaco</option>
		<option value="Norfolk Island">Norfolk Island</option>
		<option value="Saint Helena">Saint Helena</option>
		<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
		<option value="Svalbard and Jan Mayen Islands">Svalbard and JM Islands</option>
		<option value="Tokelau">Tokelau</option>
		<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
		<option value="United States Minor Outlying Islands">US Minor Outlying Islands</option>
		<option value="Wallis and Futuna">Wallis and Futuna</option>
		<option value="British Virgin Islands">British Virgin Islands</option>
	</select>
	<br>
	<label for="Code">Code</label>
	<input id="Code" name="Code" type="text" value="<?=$_SESSION['Code'];?>" maxlength="4" size="5" disabled/><br>
	<label for="RepeatCode">Repeat Code</label>
	<input id="RepeatCode" name="RepeatCode" type="numbers" maxlength="4" size="5"/><br><br>
	<textarea readonly cols="40" rows="10" >
1. Exploiting bugs Exploiting any bugs in the game or website to gain an advantage or put others  at a disadvantage E.g. Duplicating items Punishment: Account/IP banHow to report:Frequent  scans of item identification serial numbers and game logs will draw  attention to show up offenders. However, if you have information,  please pass it on to a MM as soon as possible including suitable  screenshots if necessary for investigation. 
  
2. Impersonating staff Attempting to mislead people into thinking you are a MM or any member of staff Punishment: Account/IP ban How to report: Pass on any and all information to a MM as soon as possible including  suitable screenshots if necessary for investigation. 
  
3. Hacking / threatening to hack / unlawful activities Gaining unauthorised access to restricted areas of the server; Gaining unauthorised access to another player’s game account, personal details,  account details;  Using this game as a means of conducting unlawful activities This covers a wide variety of possible crimes including hacking, phishing,  using keyloggers, scamming. Punishment: IP ban, we may also feel the need to contact the authorities. How to report: Pass  on any and all information to a MM as soon as possible including  suitable screenshots if necessary for investigation. If you have  discovered items missing or a password changed on your account, please  send in all relevant details. You must include account name and a date  range that the offence could have taken place in. The more recent the  offence, the more likely we are to be able to help. You may or may not  have your items returned when the offender is caught.    DON’T BE A VICTIM, KEEP YOUR PASSWORD SECURE!
  
4. Harassment Harassing another player or member of staff, repeated abusive behaviour  to a particular individual, repeated PKing of an individual to an  extreme degree. Punishment: This may range from a warning to an IP ban depending on severity and prior  offences at the MM\'s discretion.  How to report: Pass on any and all information to a MM as soon as possible including suitable  screenshots if necessary for investigation. 
  
5. Abusive behaviour or language Includes general insults and profanities towards other players, members  of staff or the game as a whole; acts or language of religious  intolerance, racism and all prejudice; threats of violence. Punishment: This may range from a warning to an IP ban depending on severity and prior  offences at the MM\'s discretion.  How to report: Pass on any and all information to a MM as soon as possible including  suitable screenshots if necessary for investigation. 
  
6. Advertising Using the any part of the game, site, forums or community to advertise  other websites, games and servers, products or services Punishment: IP ban  How to report: Pass on any and all information to a MM as soon as possible including  suitable screenshots if necessary for investigation. 
  
7. Trading for real money All data contained on this server is property of our MU. You are not  allowed to buy or sell game items for real money. Any attempt to profit  from being a player in MU will not be tolerated. You may purchase  items legitimately by donating. We will not take any responsibility for  you being scammed out of money or game items by illegitimate trade. Punishment:   Account/IP ban  How to report: Pass on any and all information to a MM as soon as possible including  suitable screenshots if necessary for investigation. 
  
8. Account sharing Sharing your game account with another individual; this is the case for  the lifetime of the account, it does not matter if the account is not  currently in use by its owner. Punishment: Warning, Account suspension, account ban How to report: Pass on any and all information to a MM as soon as possible including  suitable screenshots if necessary for investigation. 
  
9. Abuse of game files Use of 3rd party programs to alter the game or altering any game files  without permission; this would include any trainers, memory hackers,  editing of textures etc. Using the game files for anything other than their intended use; this  includes taking our client files for use on another server, trying to  use client files other than the ones available from this website on  this server. Punishment: Account/IP ban  How to report: Pass on any and all information to a MM as soon as possible including  suitable screenshots if necessary for investigation. 
  
10. Disrupting events We try to run events regularly; however it is very difficult if there  is a large gathering of people and some or all are being disruptive.  When a MM is trying to make an announcement or give instructions during  an event, you must remain quiet. Keep conversations to private messages  (whispers). This is common courtesy. Punishment: Disconnection
  
11. Spamming Flooding the game or forum with comments or other text unnecessarily Punishment: Warning, disconnection, forum ban  How to report: Pass on any and all information to a MM as soon as possible including  suitable screenshots if necessary for investigation.    

NB: 
A “suspension” is a temporary exclusion, whereas  a “ban” is a permanent exclusion. 
All punishments within reason are up to the MM\'s  discretion up to and including IP banning for any offence. 
When  multiple rules have been broken, this will be taken into consideration  and the punishment may be greater than that of the individual offences. 
The player’s record of past offences will also be taken  into consideration; all characters on the same account will be recorded  together; i.e. a first offence on one character will mean the next  offence on any character is treated as a second offence. 
 
HOW TO REPORT RULE BREAKERS WITH SCREENSHOTS 
It is important that you take appropriate screenshots. This means the  maximum conversation log must be visible and legible while keeping the  actual screen content partly visible.
Press F4 until the conversation window takes up the full height of the  screen and alter the transparency of this window so that the writing is  clear and legible, but not so that the window is fully opaque.
Screenshots where very little of the conversation window is shown may be deemed  inadmissible as evidence and dismissed.
    </textarea><br>
	<p>By registration you agree with Terms of Agreement! </p><br>
	<br>
	<input onclick="startLoading()" type="submit" name="register_now" value="Register"/>
</form>