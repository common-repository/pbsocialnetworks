<?php
class pbStats {
	function trackStatics($ref=false){
		global $wpdb;
		
		if( $ref == false ){
			$ref = parse_url($_SERVER['HTTP_REFERER']);
			$ref = $ref['host'];
		}
		
		$ref = trim(strtolower($ref));
		$date = date('Y-m-d');
		
		$results = $wpdb->get_results( 'SELECT * FROM `'.$wpdb->prefix.$this->StatsTable.'` WHERE `date` = \''.$date.'\' LIMIT 0,1' );

		if( !$results ){
			$sql = 'INSERT INTO `'.$wpdb->prefix.$this->StatsTable.'` (`id`, `date`, `facebook`, `facebook_btn`, `twitter`, `twitter_btn`, `googleplus`, `googleplus_btn`, `pinterest`, `pinterest_btn`) VALUES (NULL, \''.$date.'\', \'0\', \'0\', \'0\', \'0\', \'0\', \'0\', \'0\', \'0\');';
			$wpdb->query($sql);
		}
		
		$btnCount = trim(mysql_real_escape_string($_GET['pbsn']));
		
		if( !empty($btnCount) ){
			switch($btnCount){
				case 'facebook':
					$sql = 'UPDATE `'.$wpdb->prefix.$this->StatsTable.'` SET `facebook_btn`=facebook_btn+1 WHERE `date` = \''.$date.'\';';
					break;
				case 'twitter':
					$sql = 'UPDATE `'.$wpdb->prefix.$this->StatsTable.'` SET `twitter_btn`=twitter_btn+1 WHERE `date` = \''.$date.'\';';
					break;
				case 'googleplus':
					$sql = 'UPDATE `'.$wpdb->prefix.$this->StatsTable.'` SET `googleplus_btn`=googleplus_btn+1 WHERE `date` = \''.$date.'\';';
					break;
				case 'pinterest':
					$sql = 'UPDATE `'.$wpdb->prefix.$this->StatsTable.'` SET `pinterest_btn`=pinterest_btn+1 WHERE `date` = \''.$date.'\';';
					break;
			}

			$wpdb->query($sql);
		}
		
		if(!empty($ref)){
			switch($ref){
				case 'facebook.com':
				case 'www.facebook.com':
					$sql = 'UPDATE `'.$wpdb->prefix.$this->StatsTable.'` SET `facebook`=facebook+1 WHERE `date` = \''.$date.'\';';
					break;
				case 't.co':
				case 'twitter.com':
				case 'www.twitter.com':
					$sql = 'UPDATE `'.$wpdb->prefix.$this->StatsTable.'` SET `twitter`=twitter+1 WHERE `date` = \''.$date.'\';';
					break;
				case 'plus.url.google.com':
					$sql = 'UPDATE `'.$wpdb->prefix.$this->StatsTable.'` SET `googleplus`=googleplus+1 WHERE `date` = \''.$date.'\';';
					break;
				case 'pinterest.com':
					$sql = 'UPDATE `'.$wpdb->prefix.$this->StatsTable.'` SET `pinterest`=pinterest+1 WHERE `date` = \''.$date.'\';';
					break;
			}

			$wpdb->query($sql);
		}
	}
	
	function StatsPage(){
		global $wpdb;
		
		$p_viewmode = mysql_real_escape_string(trim(strip_tags($_POST['viewmode'])));
		$p_year = mysql_real_escape_string(trim(strip_tags($_POST['year'])));
		$p_month = mysql_real_escape_string(trim(strip_tags($_POST['month'])));
		$p_day = mysql_real_escape_string(trim(strip_tags($_POST['day'])));
		
		if( $p_viewmode == 'year' || $p_viewmode == 'month' || $p_viewmode == 'week' ){ $mode=$p_viewmode; }else{ $mode='week'; }
		if( !empty($p_year) && is_numeric($p_year) ){ $year=$p_year; }else{ $year=date('Y'); }
		if( !empty($p_month) && is_numeric($p_month) ){ $month=$p_month; }else{ $month=date('m'); }
		if( !empty($p_day) && is_numeric($p_day) ){ $day=$p_day; }else{ $day=false; }
		
		$limit = 7;
		
		if( $mode == 'week' ){
			if( !empty($year) && !empty($month) && !empty($day) ){
				$results = $wpdb->get_results( 'SELECT * FROM `'.$wpdb->prefix.$this->StatsTable.'` WHERE `date`=\''.$year.'-'.$month.'-'.$day.'\'' );
				$id = $results[0]->id;
				if( !empty($id) ){
					$results = $wpdb->get_results( 'SELECT * FROM `'.$wpdb->prefix.$this->StatsTable.'` WHERE (`id`='.($id-3).' OR `id`='.($id-2).' OR `id`='.($id-1).' OR `id`='.$id.' OR `id`='.($id+1).' OR `id`='.($id+2).' OR `id`='.($id+3).') ORDER BY `id` DESC LIMIT 0,7' );
				}else{
					$results = false;
				}
			}else{
				$results = $wpdb->get_results( 'SELECT * FROM `'.$wpdb->prefix.$this->StatsTable.'` ORDER BY `id` DESC LIMIT 0,'.$limit );
			}
			
			$stats = array();
			$i = 0;
			
			foreach( $results as $key ){
				$stats[$i]['date'] = $key->date;
				$stats[$i]['facebook'] = $key->facebook;
				$stats[$i]['twitter'] = $key->twitter;
				$stats[$i]['googleplus'] = $key->googleplus;
				$stats[$i]['pinterest'] = $key->pinterest;
				$stats[$i]['facebook_btn'] = $key->facebook_btn;
				$stats[$i]['twitter_btn'] = $key->twitter_btn;
				$stats[$i]['googleplus_btn'] = $key->googleplus_btn;
				$stats[$i]['pinterest_btn'] = $key->pinterest_btn;
				$i++;
			}
			
		}elseif( $mode == 'month' ){
			$stats = array();
			$i = 1;
			
			while( $i <= 12 ){
				if( $i < 10 ){
					$month = '0'.$i;
				}else{ $month = $i; }

				$results = $wpdb->get_results( 'SELECT * FROM `'.$wpdb->prefix.$this->StatsTable.'` WHERE `date` LIKE \''.$year.'-'.$month.'-%\'' );
				
				$facebook_stats = 0;
				$twitter_stats = 0;
				$googleplus_stats = 0;
				$pinterest_stats = 0;
				$facebook_btn_stats = 0;
				$twitter_btn_stats = 0;
				$googleplus_btn_stats = 0;
				$pinterest_btn_stats = 0;
				
				if( $results ){
					foreach( $results as $key ){
						$facebook_stats = $facebook_stats+((empty($key->facebook))?'0':$key->facebook);
						$twitter_stats = $twitter_stats+((empty($key->twitter))?'0':$key->twitter);
						$googleplus_stats = $googleplus_stats+((empty($key->googleplus))?'0':$key->googleplus);
						$pinterest_stats = $pinterest_stats+((empty($key->pinterest))?'0':$key->pinterest);
						$facebook_btn_stats = $facebook_btn_stats+((empty($key->facebook_btn))?'0':$key->facebook_btn);
						$twitter_btn_stats = $twitter_btn_stats+((empty($key->twitter_btn))?'0':$key->twitter_btn);
						$googleplus_btn_stats = $googleplus_btn_stats+((empty($key->googleplus_btn))?'0':$key->googleplus_btn);
						$pinterest_btn_stats = $pinterest_btn_stats+((empty($key->pinterest_btn))?'0':$key->pinterest_btn);
					}
				}
				
				$stats[$i-1]['date'] = $year.'-'.$month;
				$stats[$i-1]['facebook'] = $facebook_stats;
				$stats[$i-1]['twitter'] = $twitter_stats;
				$stats[$i-1]['googleplus'] = $googleplus_stats;
				$stats[$i-1]['pinterest'] = $pinterest_stats;
				$stats[$i-1]['facebook_btn'] = $facebook_btn_stats;
				$stats[$i-1]['twitter_btn'] = $twitter_btn_stats;
				$stats[$i-1]['googleplus_btn'] = $googleplus_btn_stats;
				$stats[$i-1]['pinterest_btn'] = $pinterest_btn_stats;
				
				$i++;
			}
		}elseif( $mode == 'year' ){
			$stats = array();
			$i = 11;
			
			while( $i >= 0 ){
				$yearI = date('Y')-$i;
				$results = $wpdb->get_results( 'SELECT * FROM `'.$wpdb->prefix.$this->StatsTable.'` WHERE `date` LIKE \''.$yearI.'-%-%\'' );
				
				$facebook_stats = 0;
				$twitter_stats = 0;
				$googleplus_stats = 0;
				$pinterest_stats = 0;
				$facebook_btn_stats = 0;
				$twitter_btn_stats = 0;
				$googleplus_btn_stats = 0;
				$pinterest_btn_stats = 0;
				
				if( $results ){
					foreach( $results as $key ){
						$facebook_stats = $facebook_stats+((empty($key->facebook))?'0':$key->facebook);
						$twitter_stats = $twitter_stats+((empty($key->twitter))?'0':$key->twitter);
						$googleplus_stats = $googleplus_stats+((empty($key->googleplus))?'0':$key->googleplus);
						$pinterest_stats = $pinterest_stats+((empty($key->pinterest))?'0':$key->pinterest);
						$facebook_btn_stats = $facebook_btn_stats+((empty($key->facebook_btn))?'0':$key->facebook_btn);
						$twitter_btn_stats = $twitter_btn_stats+((empty($key->twitter_btn))?'0':$key->twitter_btn);
						$googleplus_btn_stats = $googleplus_btn_stats+((empty($key->googleplus_btn))?'0':$key->googleplus_btn);
						$pinterest_btn_stats = $pinterest_btn_stats+((empty($key->pinterest_btn))?'0':$key->pinterest_btn);
					}
				}
				
				$stats[$i-1]['date'] = $yearI;
				$stats[$i-1]['facebook'] = $facebook_stats;
				$stats[$i-1]['twitter'] = $twitter_stats;
				$stats[$i-1]['googleplus'] = $googleplus_stats;
				$stats[$i-1]['pinterest'] = $pinterest_stats;
				$stats[$i-1]['facebook_btn'] = $facebook_btn_stats;
				$stats[$i-1]['twitter_btn'] = $twitter_btn_stats;
				$stats[$i-1]['googleplus_btn'] = $googleplus_btn_stats;
				$stats[$i-1]['pinterest_btn'] = $pinterest_btn_stats;
				
				$i--;
			}
		}
	?>
	<div class="wrap">
	<?php $this->OptionsPageHeader('stats'); ?>
	
	<h3><?php _e('pbSocialNetworks › Stats', 'pbSocialNetworks'); ?></h3>
	<p><?php _e('Here you can see your social network traffic statics. The statics are separated in two parts, the first part is an overview about all traffic you earned by Facebook, Twitter and Google+. The second part shows only the traffic you received directly by the social network buttons e.g. like or tweet but to track this statics you must use the pbSocialNetworks buttons or add <code>pbsn=facebook</code> / <code>pbsn=twitter</code> / <code>pbsn=googleplus</code> / <code>pbsn=pinterest</code> manually to your buttons. But it\'s easier to use the pbSocialNetworks buttons.', 'pbSocialNetworks'); ?></p>
	
	<div class="pbsn_filter">
		<form action="<?php echo('admin.php?page='.$this->PluginFolder.'/stats.php'); ?>" method="post" name="pbsn_filter" id="pbsn_filter">
			<label for="viewmode" class="pbsn_label"><?php _e('viewmode', 'pbSocialNetworks'); ?>:</label><select name="viewmode"><option value="week"><?php _e('week', 'pbSocialNetworks'); ?></option><option value="month"><?php _e('month', 'pbSocialNetworks'); ?></option><option value="year"><?php _e('year', 'pbSocialNetworks'); ?></option></select>
			<label for="year" class="pbsn_label"><?php _e('year', 'pbSocialNetworks'); ?>:</label><input type="text" name="year" id="year" value="" placeholder="<?php _e('year', 'pbSocialNetworks'); ?>" />
			<label for="month" class="pbsn_label"><?php _e('month', 'pbSocialNetworks'); ?>:</label><input type="text" name="month" id="month" value="" placeholder="<?php _e('month', 'pbSocialNetworks'); ?>" />
			<label for="day" class="pbsn_label"><?php _e('day', 'pbSocialNetworks'); ?>:</label><input type="text" name="day" id="day" value="" placeholder="<?php _e('day', 'pbSocialNetworks'); ?>" />
			<input type="submit" class="button-secondary action" name="pbsn_submit" value="<?php _e('search', 'pbSocialNetworks'); ?>">
		</form>
	</div>

<?php if( $stats ){ ?>

<table class="data">
	<caption><?php _e('Total Social Network Traffic', 'pbSocialNetworks'); ?></caption>
	<thead>
		<tr>
			<td></td>
			<?php
			foreach( $stats as $key ){
				echo('<th scope="col">'.$key['date'].'</th>');
			}
			?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th scope="row"><?php _e('Facebook', 'pbSocialNetworks'); ?></th>
			<?php $this->writeDataCols($stats, 'facebook'); ?>
		</tr>
		<tr>
			<th scope="row"><?php _e('Twitter', 'pbSocialNetworks'); ?></th>
			<?php $this->writeDataCols($stats, 'twitter'); ?>
		</tr>
		<tr>
			<th scope="row"><?php _e('Google+', 'pbSocialNetworks'); ?></th>
			<?php $this->writeDataCols($stats, 'googleplus'); ?>
		</tr>
		<tr>
			<th scope="row"><?php _e('Pinterest', 'pbSocialNetworks'); ?></th>
			<?php $this->writeDataCols($stats, 'pinterest'); ?>
		</tr>
		<tr>
			<th scope="row"><?php _e('Total', 'pbSocialNetworks'); ?></th>
			<?php $this->writeDataCols($stats, 'total'); ?>
		</tr>	
	</tbody>
</table>

<table class="data">
	<caption><?php _e('Social Button Traffic', 'pbSocialNetworks'); ?></caption>
	<thead>
		<tr>
			<td></td>
			<?php
			foreach( $stats as $key ){
				echo('<th scope="col">'.$key['date'].'</th>');
			}
			?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th scope="row"><?php _e('Facebook', 'pbSocialNetworks'); ?></th>
			<?php $this->writeDataCols($stats, 'facebook_btn'); ?>
		</tr>
		<tr>
			<th scope="row"><?php _e('Twitter', 'pbSocialNetworks'); ?></th>
			<?php $this->writeDataCols($stats, 'twitter_btn'); ?>
		</tr>
		<tr>
			<th scope="row"><?php _e('Google+', 'pbSocialNetworks'); ?></th>
			<?php $this->writeDataCols($stats, 'googleplus_btn'); ?>
		</tr>
		<tr>
			<th scope="row"><?php _e('Pinterest', 'pbSocialNetworks'); ?></th>
			<?php $this->writeDataCols($stats, 'pinterest_btn'); ?>
		</tr>
		<tr>
			<th scope="row"><?php _e('Total', 'pbSocialNetworks'); ?></th>
			<?php $this->writeDataCols($stats, 'total_btn'); ?>
		</tr>	
	</tbody>
</table>

<script type="text/javascript">
jQuery(function(){
<?php if($mode=='week'){ ?>
	jQuery('table.data').visualize({type: 'bar', width: '640px', colors: ['#3B5998', '#31b1f2', '#cb491d', '#8a8a8a'] });
	jQuery('table.data').visualize({type: 'line', width: '640px', colors: ['#3B5998', '#31b1f2', '#cb491d', '#8a8a8a'] });
<?php }else{ ?>
	jQuery('table.data').visualize({type: 'bar', width: '1113px', colors: ['#3B5998', '#31b1f2', '#cb491d', '#8a8a8a'] });
	jQuery('table.data').visualize({type: 'line', width: '1113px', colors: ['#3B5998', '#31b1f2', '#cb491d', '#8a8a8a'] });
<?php } ?>
});
</script>
<?php }else{ echo '<div id="message" class="error fade"><p><strong>'.__('Sorry, actually you don´t have any Statics in your database. Please activate the Statics in the General Tab to catch some data.').'</strong></p></div>'; } ?>
	<?php $this->OptionPageFooter(); ?>
	</div>
	<?php
	}
	
	function writeDataCols($dataArray, $dataKey){

		$total = array();
		foreach( $dataArray as $key ){
			if( $dataKey == 'total' ){
				$totalKey = $key['facebook']+$key['twitter']+$key['googleplus']+$key['pinterest'];
			}elseif( $dataKey == 'total_btn' ){
				$totalKey = $key['facebook_btn']+$key['twitter_btn']+$key['googleplus_btn']+$key['pinterest_btn'];
			}else{
				$totalKey = $key[$dataKey];
			}
			
			array_push($total, $totalKey);
		}
		
		$BestVal = @max($total);
		$WorstVal = @min($total);
		
		foreach( $dataArray as $key ){
			if( $dataKey == 'total' ){
				$val = $key['facebook']+$key['twitter']+$key['googleplus']+$key['pinterest'];
			}elseif( $dataKey == 'total_btn' ){
				$val = $key['facebook_btn']+$key['twitter_btn']+$key['googleplus_btn']+$key['pinterest_btn'];
			}else{
				$val = $key[$dataKey];
			}
			
			if( empty($val) ){ $val = 0; }
			
			if( $val == $BestVal ){
				echo('<td class="green">'.$val.'</td>');
			}elseif( $val == $WorstVal ){
				echo('<td class="red">'.$val.'</td>');
			}else{
				echo('<td>'.$val.'</td>');
			}
		}
	}
}
?>