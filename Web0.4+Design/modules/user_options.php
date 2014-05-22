<?php
// // // // // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(isset($_SESSION['User'])){
?>
<ul class="hor_nav">
  <li>Character
    <ul class="ver_nav">
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Reset-Character"><li>Reset</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Add-Stats"><li>Add Stats</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Bank"><li>Bank</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Clear-Stats"><li>Clear Stats</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Clear-PK"><li>Clear PK</li></a>
    </ul>
  </li>
  <li>Stones
    <ul class="ver_nav">
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Stones_Deposit-Stones"><li>Deposit</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Stones_Change-Name"><li>Rename</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Stones_Change-Race"><li>ChangeRace</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Stones_Get-Zen"><li>Get Zen</li></a>
    </ul>	
  </li>
  <li>Renas
    <ul class="ver_nav">
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Renas_Deposit-Renas"><li>Deposit</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Renas_Upgrade-Items"><li>UpItems</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Renas_Get-Jewels"><li>GetJewels</li></a>
    </ul>	
  </li>
  <li>Other
    <ul class="ver_nav">
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Vote-Reward"><li>VoteReward</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Change-Password"><li>ChangePass</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Quest-System"><li>Quests</li></a>
      <a onclick="startLoading()" href="/?page=Modules_User-Panel_Web-House"><li>WebHouse</li></a>
    </ul>
  </li>
  <a onclick="startLoading()" href="/?page=Modules_LogOut"><li>LogOut</li></a>
</ul>
<?php
}else{
  include "modules/login_panel.php";
}
?>