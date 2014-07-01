<?php
  
  if(isset($_GET['page_count'])){
    $page_count = $_GET['page_count'];
    if($page_count < 0){
       $page_count = 0;
    }
  }else{
    $page_count = 0;
  }
  $count_per_page = 10;
?>
<a href="/?page=Modules_Register"><button>Add New Account</button></a>
<form action="" method="GET">
  <input type="hidden" name="page" value="Modules_Admin-Panel_Web_Account"/>
  <input type="text" name="search"/>
  <input type="submit" name="searchAcc" value="Search"/>
</form>
<table>
  <thead>
    <tr><th>ID</th><th>Account</th><th>Characters</th><th>Type</th><th>Status</th><!--<th>Edit</th>--><th>Chenage</th></tr>
  </thead>
  <tbody>
    <?php
      $all_accs = $grizismudb->query("Select *,ConnectStat From MEMB_INFO,MEMB_STAT Where MEMB_INFO.memb___id=MEMB_STAT.memb___id AND MEMB_INFO.memb___id Like '%".$_GET['search']."%' order by MEMB_INFO.memb___id OFFSET ".$page_count*$count_per_page." ROWS FETCH NEXT $count_per_page ROWS ONLY");
      $counter = $page_count*$count_per_page+1;
      $type = array(0=>"Normal",1=>"Blocked");
      $status = "<p class=\"error\">Offline</p>";
      if($acc['ConnectStat']){
        $status = "<p class=\"success\">Online</p>";
      }
      foreach($all_accs as $acc){
    ?>
    <tr>
      <td><?=$counter?></td>
      <td><?=$acc['memb___id']?></td>
      <td>
        Check
        <div class="hidden_characters">
          <ul>
            <?php
              $characters = $grizismudb->query("Select Name From Character Where AccountId='".$acc['memb___id']."'");
              foreach($characters as $char){
            ?>
           <li> <a href="/?page=Modules_Admin-Panel_Web_Character-Edit&CharacterName=<?=$char['Name']?>"><?=$char['Name']?></a></li>
            <?php
              }
            ?>
          </ul>
        </div>
      </td>
      <td><?=$type[$acc['bloc_code']]?></td>
      <td><?=$status?></td>
      <!--<td>
        <a href="/?page=Modules_Admin-Panel_Web_Account_Edit&accid=<?=$acc[0]?>"><button>Edit</button></a>
      </td>-->
      <td>
        <?php 
          if($acc['bloc_code'] == 0){
        ?>
        <a onclick="if(!confirm('You will ban this account!\nAre you sure ?')){return false}" href="/?page=Modules_Admin-Panel_Web_Account_Ban&accid=<?=$acc[0]?>"><button>Ban</button></a>
        <?php
          }elseif($acc['bloc_code'] == 1){
        ?>
        <a onclick="if(!confirm('You will unban this account!\nAre you sure ?')){return false}" href="/?page=Modules_Admin-Panel_Web_Account_UnBan&accid=<?=$acc[0]?>"><button>UnBan</button></a>
        <?php
          }
        ?>
      </td>
    </tr>
    <?php
      $counter++;
      }
    ?>
  </tbody>
</table>

<?php
  if($page_count > 0 ){
?>
<a href="/?page=Modules_Admin-Panel_Web_Account&page_count=<?=$page_count-1?>&search=<?=$_GET['search']?>"><< Previous</a>
<?php
  }
?>
<a href="/?page=Modules_Admin-Panel_Web_Account&page_count=<?=$page_count+1?>&search=<?=$_GET['search']?>">Next >></a>