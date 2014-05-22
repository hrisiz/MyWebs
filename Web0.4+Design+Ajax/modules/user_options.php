<?php
// // // // // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(isset($_SESSION['User'])){
?>
<ul class="hor_nav">
  <li>Character
    <ul class="ver_nav">
      <li onclick='loadAjaxPage("Modules_User-Panel_Reset-Character","content")'>Reset</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Add-Stats","content")'>Add Stats</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Bank","content")'>Bank</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Clear-Stats","content")'>Clear Stats</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Clear-PK","content")'>Clear PK</li>
    </ul>
  </li>
  <li>Stones
    <ul class="ver_nav">
      <li onclick='loadAjaxPage("Modules_User-Panel_Stones_Deposit-Stones","content")'>Deposit</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Stones_Change-Name","content")'>Rename</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Stones_Change-Race","content")'>ChangeRace</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Stones_Get-Zen","content")'>Get Zen</li>
    </ul>	
  </li>
  <li>Renas
    <ul class="ver_nav">
      <li onclick='loadAjaxPage("Modules_User-Panel_Renas_Deposit-Renas","content")'>Deposit</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Renas_Upgrade-Items","content")'>UpItems</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Renas_Get-Jewels","content")'>GetJewels</li>
    </ul>	
  </li>
  <li>Other
    <ul class="ver_nav">
      <li onclick='loadAjaxPage("Modules_User-Panel_Vote-Reward","content")'>VoteReward</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Change-Password","content")'>ChangePass</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Quest-System","content")'>Quests</li>
      <li onclick='loadAjaxPage("Modules_User-Panel_Web-House","content")'>WebHouse</li>
    </ul>
  </li>
  <li onclick='loadAjaxPage("Modules_LogOut","content")'>LogOut</li>
</ul>
<?php
}else{
  include "modules/login_panel.php";
}
?>