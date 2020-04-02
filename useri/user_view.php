<?php
require_once( '../config.php' );
$page_head = array( 'meta_title' => 'User view' );
if ( $GLOBALS[ 'login' ]->get_user_level() < 10 ) {
	redirect( 303, LROOT );
}



$asoc_query=multiple_query("select * from asociatii order by nume asc");
	foreach ( $asoc_query as $k => $v ) {
		$asoc[ $v[ 'id' ] ] = $v[ 'nume' ];
	}


	
	$user=many_query("SELECT tu.id,tu.full_name,tu.username,ll.localitate,tu.description,
lj.nume_judet as judet,tu.mail,tu.tel,tu.website,tu.job_title,tu.company,tu.atasamente FROM `thf_users` tu 
left join localizare_judete lj on tu.judet_id=lj.id 
left join localizare_localitati ll on tu.localitate_id=ll.id WHERE tu.id='" . floor( $_GET[ 'edit' ] ) . "'   ORDER BY tu.id ASC");
$pictures=json_decode($user['atasamente']);
	$pid = floor( $user[ 'id' ] );
	
	$loc = multiple_query( "select * from localizare_localitati where parinte  = '" . $user[ 'judet_id' ] . "' " );
	foreach ( $loc as $k => $v ) {
		$localitati[ $v[ 'id' ] ] = $v[ 'localitate' ];
	}
	


	iframe_head();

	//prea($user);
	
	
	?>
	
<div class="ui segment">
  <div class="ui left floated header">
  <?php
  echo $user[ 'full_name' ];
  echo "<br/>";
  
  echo $user[ 'job_title' ].", ".$user[ 'company' ];
  echo "<br/>";
   echo "Locatie:".$user['localitate'].", ".$user[ 'judet' ];
  echo "<br/>";
  ?>
  
  </div>
  <div class="ui right floated header" style="font-size: 10px;">
    <?php
  echo '<i class="envelope icon">&nbsp;&nbsp;'.$user[ 'mail' ].'</i>';
    echo "<br/>";
  echo '<i class="phone square icon">&nbsp;'.$user[ 'tel' ]."</i>";
  echo "<br/>";
   echo '<i class="globe icon">&nbsp;'.$user['website'].'</i>';
  echo "<br/>";
  ?>

  </div>
  <div class="ui clearing divider"></div>
  	
<div class="ui tall stacked segment">
<div class="ui grid">
  <div class="four wide column">
  <div class="ui <?php echo (isset($pictures[1][0])?"instant move reveal":"") ?> ">
    <div class="visible content">
    <img src="<?php echo $pictures[0][0]; ?>" class="ui small image">
  </div>
  
    <div style='display:block !important' class="hidden content" >
    <img src="<?php echo $pictures[1][0]; ?>" class="ui small image">
  </div>


</div>	
</div>
 <div class="twelve wide column">
  <?php
 
  echo $user['description'];
  ?>
  </div>
 </div>
</div>

</div>

	

	<?php
	iframe_footer();


?>

 