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
<a href="/?page=Modules_Admin-Panel_Web_News_Add"><button>Add News</button></a>
<table>
  <thead>
    <tr><th>ID</th><th>Title</th><th>Posted By</th><th>Last Update</th><th>Edit</th><th>Delete</th></tr>
  </thead>
  <tbody>
    <?php
      $all_news = $grizismudb->query("Select  * From News ORDER BY LastUpdate desc OFFSET ".$page_count*$count_per_page." ROWS FETCH NEXT $count_per_page ROWS ONLY");
      $counter = 1;
      foreach($all_news as $news){
    ?>
    <tr>
      <td><?=$counter?></td>
      <td><?=$news[1]?></td>
      <td><?=$news[3]?></td>
      <td><?=$news[4]?></td>
      <td>
        <a onclick="startLoading()" href="/?page=Modules_Admin-Panel_Web_News_Edit&newsid=<?=$news[0]?>"><button>Edit</button></a>
      </td>
      <td>
        <a onclick="if(!confirm('You will delete this news!\nAre you sure ?')){return false}else{startLoading()}" href="/?page=Modules_Admin-Panel_Web_News_Delete&newsid=<?=$news[0]?>"><button>Delete</button></a>
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
<a onclick="startLoading()" href="/?page=Modules_Admin-Panel_Web_News&page_count=<?=$page_count-1?>"><< Previous</a>
<?php
  }
?>
<a onclick="startLoading()" href="/?page=Modules_Admin-Panel_Web_News&page_count=<?=$page_count+1?>">Next >></a>