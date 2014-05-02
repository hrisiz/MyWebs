<?php

	function do_reset_stats()
	{
		global $option;
		$acc = $_SESSION['dt_username'];
		$char = $_POST['character'];
		
		$show_msg=array(
			'error'=>array()
		);
		
		if(empty($char))
		{
			$show_msg['error'][] = 'Please select a character!';
		}
		elseif(preg_match('/[^a-zA-Z0-9\_\-]/', $char))
		{
			$show_msg['error'][] = 'Invalid symbols!';
		}
		elseif(strlen($char) < 3 || strlen($char) > 10)
		{
			$show_msg['error'][] = 'Invalid Character Name!';
		}
		else
		{
			$is_acc_char = mssql_num_rows(
				mssql_query("SELECT Name FROM Character WHERE AccountID='". $acc ."' AND Name='". $char ."'")
			);
			
			$is_online=is_online($char, 1);
			$character = char_info($char);
			
			$new_lvlupp = $character['LevelUpPoint'] + $character['Strength'] + $character['Dexterity'] + $character['Vitality'] + $character['Energy'];

			$new_money = ($character['Money'] - $option['rs_zen']);

			if($is_acc_char==0)
			{
				$show_msg['error'][] = 'This character is not yours!';
			}
			elseif($is_online === 1)
			{
				$show_msg['error'][] = 'You need to leave the game!';
			}
			elseif($new_money < 0)
			{
				$show_msg['error'][] = 'You don&#39;t have enough money(zen)!';
			}
			elseif($character['cLevel'] < $option['rs_level'])
			{
				$show_msg['error'][] = 'You need '.($option['rs_level'] - $character['cLevel']).' more levels!';
			}
			elseif($character['Resets'] < $option['rs_resets'])
			{
				$show_msg['error'][] = 'You need '.($option['rs_resets'] - $character['Resets']).' more resets!';
			}
			else
			{
				$sql = "UPDATE Character SET Strength = 0, Dexterity = 0, Vitality = 0, Energy = 0,  Money = ".$new_money.",  LevelUpPoint = ".$new_lvlupp." WHERE Name='".$character['Name']."' AND AccountID='".$acc."'";
				mssql_query($sql);
				$show_msg['success'][0] =  'The stats are successfully reset and '. $char .' have '.$new_lvlupp.' points.';
			}
		}
		return $show_msg;
	}

	function do_grand_reset()
	{
		global $option;
		$acc = $_SESSION['dt_username'];
		$char = $_POST['character'];
		
		$show_msg=array(
			'error'=>array()
		);
		
		if(empty($char))
		{
			$show_msg['error'][] = 'Please select a character!';
		}
		elseif(preg_match('/[^a-zA-Z0-9\_\-]/', $char))
		{
			$show_msg['error'][] = 'Invalid symbols!';
		}
		elseif(strlen($char) < 3 || strlen($char) > 10)
		{
			$show_msg['error'][] = 'Invalid Character Name!';
		}
		else
		{
			$is_acc_char = mssql_num_rows(
				mssql_query("SELECT Name FROM Character WHERE AccountID='". $acc ."' AND Name='". $char ."'")
			);

			$is_online = is_online($char, 1);
			$character = char_info($char);
			
			$new_gr = ($character['GrandResets'] + 1);
			
			$new_res = ($character['Resets'] - $option['gr_resets']);
			
			$new_money = ($character['Money'] - $option['gr_zen']);
		
			if($is_acc_char == 0)
			{
				$show_msg['error'][] = 'This character is not yours!';
			}
			elseif($is_online === 1)
			{
				$show_msg['error'][] = 'You need to leave the game!';
			}
			elseif($character['cLevel'] < $option['gr_level'])
			{
				$show_msg['error'][] = 'You need '.($option['gr_level'] - $character['cLevel']).' more levels!';
			}
			elseif($new_res < 0)
			{
				$show_msg['error'][] = 'You need '.($option['gr_resets'] - $character['Resets']).' more resets!';
			}
			elseif($new_money < 0)
			{
				$show_msg['error'][] = 'You don&#39;t have enough money(zen)!';
			}
			elseif($new_gr > $option['gr_max_resets'])
			{
				$show_msg['error'][] = 'You have reach the maximum grand resets!';
			}
			else
			{
				$sql ="UPDATE Character SET Resets = ". $new_res .", Money = ".$new_money.", GrandResets = ". $new_gr .", LevelUpPoint = ". $option['gr_reward'] .",cLevel = 1,Experience = 0 WHERE Name='".$character['Name']."' AND AccountID='".$acc."'";
				mssql_query($sql);
				
				if($option['gr_credits'] === 1)
				{
					$reward = mssql_fetch_row(
						mssql_query("SELECT ". $option['cr_db_column'] ." FROM ". $option['cr_db_table'] ." WHERE " . $option['cr_db_check_by'] ."='" . $acc . "'")
					);
					
					$gr_reward=($reward[0] + $option['gr_reward']);
					
					$sql2 = "UPDATE ". $option['cr_db_table'] ." SET ". $option['cr_db_column'] ." = ".$gr_reward." WHERE  " . $option['cr_db_check_by'] ."='" . $acc . "'";
					mssql_query($sql2);
				}
				
				$show_msg['success'][0] = $char .' have successfully grand reset for '.$new_gr.' time.';
			}
		}
		return $show_msg;
	}

	function do_add_stats()
	{
		global $option;
		$acc = $_SESSION['dt_username'];
		$char = $_POST['character'];
		$str = (int)$_POST['str'];
		$agi = (int)$_POST['agi'];
		$vit = (int)$_POST['vit'];
		$ene = (int)$_POST['ene'];
		$com = (int)$_POST['com'];
		$has_command = '';
		$is_dl = 0;

		$total_points=($str + $agi + $vit + $ene + $com);
		
		$show_msg=array(
			'error'=>array()
		);
		
		if(empty($char))
		{
			$show_msg['error'][] = 'Please select a character!';
		}
		elseif(preg_match('/[^a-zA-Z0-9\_\-]/', $char))
		{
			$show_msg['error'][] = 'Invalid symbols!';
		}
		elseif(strlen($char) < 3 || strlen($char) > 10)
		{
			$show_msg['error'][] = 'Invalid Character Name!';
		}
		else
		{
			$is_acc_char = mssql_num_rows(
				mssql_query("SELECT Name FROM Character WHERE AccountID='". $acc ."' AND Name='". $char ."'")
			);
			
			$is_online=is_online($char, 1);
			$character=char_info($char);
			
			$lvlupp = $character['LevelUpPoint'];
			$new_lvlupp=($lvlupp - $total_points);
			
			$new_str = $character['Strength'] + $str;
			$new_agi = $character['Dexterity'] + $agi;
			$new_vit = $character['Vitality'] + $vit;
			$new_eng = $character['Energy'] + $ene;
			$new_com = 0;
			if($option['has_dl'] === 1)
			{
				if($character['Class'] == 64 OR $character['Class'] == 65 OR $character['Class'] == 66)
				{
					$new_com = $character['Leadership'] + $com;
					$has_command .= ', Leadership = '. $new_com;
					$is_dl = 1;
				}
			}
		
		
			if($is_acc_char==0)
			{
				$show_msg['error'][] = 'This character is not yours!';
			}
			elseif($is_online === 1)
			{
				$show_msg['error'][] = 'You need to leave the game!';
			}
			elseif($lvlupp < 1)
			{
				$show_msg['error'][] = 'You have 0 points!';
			}
			elseif($new_lvlupp < 0)
			{
				$show_msg['error'][] = 'You need '.($total_points - $lvlupp).' more points!';
			}
			elseif($is_dl === 0 && $com != 0)
			{
				$show_msg['error'][] = 'This character can&#39;t use command!';
			}
			elseif(($new_str > $option['as_max_stats']) OR ($new_agi > $option['as_max_stats']) OR 
			($new_vit > $option['as_max_stats']) OR ($new_eng > $option['as_max_stats']))
			{
				$show_msg['error'][] = 'You can&#39;t have more than '.$option['as_max_stats'].' points!';
			}
			else
			{
				$sql="UPDATE Character SET Strength = ".$new_str.", Dexterity = ".$new_agi.", Vitality = ".$new_vit.",Energy = ".$new_eng." ".$has_command.",  LevelUpPoint = ".$new_lvlupp." WHERE Name='".$character['Name']."' AND AccountID='".$acc."'";
				mssql_query($sql);
				$show_msg['success'][0] =  'The stats are successfully added and '. $char .' have '.$new_lvlupp.' left points.';
			}
		}
		return $show_msg;
	}

	function do_reset_character()
	{
		global $option;
		$acc = $_SESSION['dt_username'];
		$char = $_POST['character'];

		$show_msg=array(
			'error'=>array()
		);
		
		if(empty($char))
		{
			$show_msg['error'][] = 'Please select a character!';
		}
		elseif(preg_match('/[^a-zA-Z0-9\_\-]/', $char))
		{
			$show_msg['error'][] = 'Invalid symbols!';
		}
		elseif(strlen($char) < 3 || strlen($char) > 10)
		{
			$show_msg['error'][] = 'Invalid Character Name!';
		}
		else
		{
			$is_acc_char = mssql_num_rows(
				mssql_query("SELECT Name FROM Character WHERE AccountID='". $acc ."' AND Name='". $char ."'")
			);
			
			$is_online=is_online($char, 1);
			$character=char_info($char);
			
			$new_res=($character['Resets'] + 1);
			
			if($option['rc_zen_type'] === 1)
			{
				$option['rc_zen'] = ($option['rc_zen'] * $new_res);
			}
			
			$new_money=($character['Money'] - $option['rc_zen']);
			if($option['rc_bonus_points'] == 1)
			{
				switch($character['Class'])
				{
					case 0:
					case 1:
					case 2:
						$option['rc_stats_per_reset'] = $option['rc_stats_for_sm'];
						break;
					case 16:
					case 17:
					case 18:
						$option['rc_stats_per_reset'] = $option['rc_stats_for_bk'];
						break;
					case 32:
					case 33:
					case 34:
						$option['rc_stats_per_reset'] = $option['rc_stats_for_me'];
						break;
					case 48:
					case 49:
						$option['rc_stats_per_reset'] = $option['rc_stats_for_mg'];
						break;
					case 64:
					case 65:
						$option['rc_stats_per_reset'] = $option['rc_stats_for_dl'];
						break;
				}
			}
			$level_up_points = $option['rc_stats_per_reset'];
			if($option['rc_stats_type'] === 1)
			{
				 $level_up_points = $level_up_points * $new_res;
			}
			if($option['rc_gr_bonus'] === 1)
			{
				 $level_up_points += ($option['gr_reward'] * $character['GrandResets']);
			}
		
			if($is_acc_char == 0)
			{
				$show_msg['error'][] = 'This character is not yours!';
			}
			elseif($is_online === 1)
			{
				$show_msg['error'][] = 'You need to leave the game!';
			}
			elseif($character['cLevel'] < $option['rc_level'])
			{
				$show_msg['error'][] = 'You need '.($option['rc_level'] - $character['cLevel']).' more levels!';
			}
			elseif($new_money < 0)
			{
				$show_msg['error'][] = 'You don&#39;t have enough money(zen)!';
			}
			elseif($new_res > $option['rc_max_resets'])
			{
				$show_msg['error'][] = 'You have reach the maximum resets!';
			}
			else
			{
				$sql='UPDATE Character SET ';
				if($option['rc_clear_stats'] === 1)
				{
					$sql .='Strength = 25, Dexterity = 25, Vitality = 25, Energy = 25, ';
				}
				$sql .="Resets = ".$new_res.", Money = ".$new_money.", LevelUpPoint = ".$level_up_points.",cLevel = 1,Experience = 0 WHERE Name='".$character['Name']."' AND AccountID='".$acc."'";
				mssql_query($sql);
				$show_msg['success'][0] = $char .' have successfully reset for '.$new_res.' time.';
			}
		}
		return $show_msg;
	}

	function do_pk_clear()
	{
		global $option;
		$acc = $_SESSION['dt_username'];
		$char = $_POST['character'];
		
		$show_msg=array(
			'error'=>array()
		);
		
		if(empty($char))
		{
			$show_msg['error'][] = 'Please select a character!';
		}
		elseif(preg_match('/[^a-zA-Z0-9\_\-]/', $char))
		{
			$show_msg['error'][] = 'Invalid symbols!';
		}
		elseif(strlen($char) < 3 || strlen($char) > 10)
		{
			$show_msg['error'][] = 'Invalid Character Name!';
		}
		else
		{
			$is_acc_char = mssql_num_rows(
				mssql_query("SELECT Name FROM Character WHERE AccountID='". $acc ."' AND Name='". $char ."'")
			);
			
			$is_online = is_online($char, 1);
			$character = char_info($char);
			
			if($option['pkc_zen_type'] === 1)
			{
				$option['pkc_zen'] = ($option['pkc_zen'] * ($character['PkLevel'] - 3));
			}
			
			$new_money=($character['Money'] - $option['pkc_zen']);
			
			if($is_acc_char==0)
			{
				$show_msg['error'][] = 'This character is not yours!';
			}
			elseif($is_online === 1)
			{
				$show_msg['error'][] = 'You need to leave the game!';
			}
			elseif($character['PkLevel'] <= 3)
			{
				$show_msg['error'][] = 'This character is not a killer!';
			}
			elseif($new_money < 0)
			{
				$show_msg['error'][] = 'You don&#39;t have enough money(zen)!';
			}
			else
			{
				$sql = "UPDATE Character SET Money = ".$new_money.",  PkLevel = 3 WHERE Name='".$character['Name']."' AND AccountID='".$acc."'";
				mssql_query($sql);
				$show_msg['success'][0] =  $char .' is successfully cleared.';
			}
		}
		return $show_msg;
	}

	function do_login()
	{
		
		$acc = $_POST['account'];
		$pass = $_POST['password'];
		$show_msg=array(
			'error'=>array()
		);
		
		if(empty($acc) OR empty($pass))
		{
			$show_msg['error'][] = 'Some fields are empty!';
		}
		elseif(preg_match('/[^a-zA-Z0-9\_\-]/', $acc) OR preg_match('/[^a-zA-Z0-9\_\-]/', $pass))
		{
			$show_msg['error'][] = 'Invalid symbols!';
		}
		else
		{
			$is_acc_pass = mssql_num_rows(
				mssql_query("SELECT memb___id FROM MEMB_INFO WHERE memb___id='". $acc ."' AND memb__pwd='". $pass ."'")
			);
			
			if($is_acc_pass == 0)
			{
				$show_msg['error'][] = 'Wrong Account or Password!';
			}
			else
			{
				$_SESSION['dt_username'] = $acc;
				$_SESSION['dt_password'] = $pass;
				header('Location: ?p=home');
			}
		}
		return $show_msg;
	}

	function do_registration()
	{
		$acc = $_POST['account'];
		$pass = $_POST['password'];
		$repass = $_POST['repassword'];
		$mail = $_POST['email'];
		$sq = $_POST['question'];
		$sa = $_POST['answer'];
		$show_msg=array(
			'error'=>array()
		);
		$error=0;
		
		if(empty($acc) OR empty($pass) OR empty($repass) OR empty($mail) OR empty($sq) OR empty($sa))
		{
			$show_msg['error'][] = 'Some fields are empty!';
		}
		elseif(preg_match('/[^a-zA-Z0-9\_\-]/', $acc) OR preg_match('/[^a-zA-Z0-9\_\-]/', $pass) OR preg_match('/[^a-zA-Z0-9\_\-]/', $repass) OR preg_match('/[^a-zA-Z0-9\_\-]/', $sq) OR preg_match('/[^a-zA-Z0-9\_\-]/', $sa))
		{
			$show_msg['error'][] = 'Invalid symbols!';
		}
		elseif(!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$/D', $mail))
		{
			$show_msg['error'][] = 'Invalid Email address! Example: email@mail.com';
		}
		else
		{
			if(strlen($acc) < 4 OR strlen($acc) > 10)
			{
				$show_msg['error'][] = 'Account need to be between 4-10 symbols!';
				$error=1;
			}
			if(strlen($pass) < 4 OR strlen($pass) > 10)
			{
				$show_msg['error'][] = 'Password need to be between 4-10 symbols!';
				$error=1;
			}
			if($pass!=$repass)
			{
				$show_msg['error'][] = 'The Passwords don&#39;t match!';
				$error=1;
			}
			if(strlen($mail) > 60)
			{
				$show_msg['error'][] = 'The Email Address can&#39;t be more than 60 symbols!';
				$error=1;
			}
			if($sq==$sa)
			{
				$show_msg['error'][] = 'Secret Question and Answer must be different!';
				$error=1;
			}
			if(strlen($sq) < 6 OR strlen($sq) > 10)
			{
				$show_msg['error'][] = 'Secret Question need to be between 6-10 symbols!';
				$error=1;
			}
			if(strlen($sa) < 6 OR strlen($sa) > 10)
			{
				$show_msg['error'][] = 'Secret Answer need to be between 6-10 symbols!';
				$error=1;
			}
			if($error===0)
			{
				$is_acc_mail = mssql_num_rows(
					mssql_query("SELECT memb___id FROM MEMB_INFO WHERE memb___id='". $acc ."' OR mail_addr='". $mail ."'")
				);
				
				if($is_acc_mail!=0)
				{
					$show_msg['error'][] = 'This Account OR Email Address is already used!';
				}
				else
				{
					mssql_query("INSERT INTO MEMB_INFO (memb___id,memb__pwd,memb_name,sno__numb,post_code,addr_info,addr_deta,tel__numb,mail_addr,phon_numb,fpas_ques,fpas_answ,job__code,appl_days,modi_days,out__days,true_days,mail_chek,bloc_code,ctl1_code) VALUES ('". $acc ."','". $pass ."','Server','1111111111111','1234', '11111', '111111111','12343','". $mail ."', '0','". $sq ."','". $sa ."','1','2003-11-23', '2003-11-23', '2003-11-23', '2003-11-23', '1', '0', '1')");
					mssql_query("INSERT INTO VI_CURR_INFO (memb_guid,ends_days,chek_code,used_time,memb___id,memb_name,sno__numb,Bill_Section,Bill_value,Bill_Hour,Surplus_Point,Surplus_Minute,Increase_Days )  VALUES ('1','2005','1',1234,'". $acc ."','Server','7','6','3','6','6','2003-11-23 10:36:00','0' )");
					$show_msg['success'][0] = 'Thank you "'.$acc.'", your registration is complete.';
				}
			}
		}
		return $show_msg;
	}