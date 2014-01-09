<?php
/**
 * Template Name: Cellsense Survey Page - No Sidebar or Page Title
*/

    get_header();
	st_before_content($columns='sixteen');




if ( is_user_logged_in() ) {
    
    //test sql query
    /* Query logic: 
     *  - check the rg_lead_detail table to see if there's a matching user_email value
     *  - if there is, then the form was already successfully submitted by the user
     *  - else the survey hasn't been submitted successfully, so display it
     */
    if (is_page('Survey')) {
    	$fid = 1;
    } else $fid = 2;

    //echo 'fid in page php: ' . $fid;
    
    if ( $wpdb->query("SELECT * FROM `°°°°°_rg_lead_detail` WHERE value='$user_email'") ) { 
	    /*Found a matching email. That means they have already submitted an entry.
	      Now see if they're allowed to redo and submit an updated one. */	 

	    
	    $lid = $wpdb->get_row("SELECT * FROM `°°°°°_rg_lead_detail` WHERE value='$user_email' AND form_id='$fid'", ARRAY_A);
	    $lead_id = $lid['lead_id'];
	   //echo ' lid in php:' .$lead_id;


	    //check if they're in pending/correction status or not
	    $resub_row = $wpdb->get_row("SELECT * FROM `°°°°°_rg_lead_detail` WHERE field_number=140 AND lead_id=$lead_id", ARRAY_A);
	    $can_resub = $resub_row['value'];
	    //echo $user_email. ' can resub=' .$can_resub;
	    
	    if($can_resub == 'No') { //Redo not allowed. Thanks, we got your survey, kthxbye.
		    //echo " - Nope. Can't resub";
		    ?>
		    	    <div class='page type-page status-publish hentry'>
		    		<div class='entry-content'>
		    		<h2>Thank you</h2>
					<p>Thank you for completing the Cellsense survey. Your survey has already been submitted.<br /><br />
			    	<a href='<?php echo wp_logout_url(get_permalink()); ?>'>Logout</a></p> 
			    	</div></div>
		    
	    <?php
	    } 
	    

	} else $no_entry = true;

	//echo " no_entry: " .$no_entry; 


	
	if($can_resub == 'Yes' || $can_resub == "") { //if pending is allowed or null, or if there's no matching email (no entry submitted yet), then show form
	?>
	<script type="text/javascript" src="<?php echo get_bloginfo(template_url).'/javascripts/jquery-1.4.1.min.js';?>"></script>
	<script type="text/javascript" src="<?php echo get_bloginfo(template_url).'/javascripts/jquery-jvert-tabs-1.1.4.js';?>"></script>
	<script type="text/javascript" src="<?php echo get_bloginfo(template_url).'/javascripts/jquery.field.min.js';?>"></script>
	<script type="text/javascript" src="<?php echo get_bloginfo(template_url).'/javascripts/jquery.validate.js';?>"></script>

	<script type="text/javascript" src="<?php echo get_bloginfo(template_url).'/javascripts/gc-validate.js';?>"></script>

	<script type="text/javascript">
		$(document).ready(function(){
		
			//hide the gravity form submit button
			$("#gform_submit_button_1").addClass("gform_hidden");
			$("#gform_submit_button_2").addClass("gform_hidden");

			//if validation ran and found a blank, go to the blank
        	//console.log("panel: " +validateThis());
			//validateThis();
			
			//these fields are only allowed to accept digits
			//based on form id
			$("#gform_<?php echo ''.$fid;?>").validate({ 
				  rules: {
				    input_6: {digits: true,min: 1,max: 79},
				    input_11: {digits: true,min: 1,max: 79},
				    input_12: {digits: true,min: 1,max: 79},
				    input_20: {digits: true,min: 1},
				    input_28: {digits: true,min: 1,max: 79},
				    input_29: {digits: true,min: 1,max:79},
				    input_142: {digits: true,min: 1},
				    input_143: {digits: true,min: 1},
				    input_144: {digits: true,min: 1},
				    input_145: {digits: true,min: 1},
				    input_146: {digits: true,min: 1},
				    input_147: {digits: true,min: 1},
				    input_148: {digits: true,min: 1},
				    input_149: {digits: true,min: 1},
				    input_150: {digits: true,min: 1},
				    input_151: {digits: true,min: 1},
				    input_152: {digits: true,min: 1},
				    input_153: {digits: true,min: 1},
				    input_154: {digits: true,min: 1},
				    input_155: {digits: true,min: 1},
				    input_156: {digits: true,min: 1},
				    input_101: {digits: true,min: 1,max: 79},
				    input_104: {digits: true,min: 1,max: 79},
				    input_106: {digits: true,min: 1,max: 79}

				    <?php
				    	if($fid == 2) { //if survey 2
				    		echo ',
				    			input_164: {digits: true,min: 1,max: 79},
				    			input_165: {digits: true,min: 1,max: 79},
				    			input_168: {digits: true,min: 1,max: 79},
				    			input_169: {digits: true,min: 1,max: 79},
				    			input_172: {digits: true,min: 1,max: 79},
				    			input_173: {digits: true,min: 1,max: 79},
				    			input_176: {digits: true,min: 1,max: 79},
				    			input_177: {digits: true,min: 1,max: 79},
				    			input_180: {digits: true,min: 1,max: 79},
				    			input_181: {digits: true,min: 1,max: 79}
				    		';
				    	}
				    ?>

				  }
				  /*,
				  messages: {
					  input_6: {
						  digits: "Please enter only digits",
						  min: "Please enter a value greater than or equal to 1",
						  max: "Please enter a value less than or equal to 150"
					  }
				  }*/
				});
				


			
			// default behavior.
			$("#vtabs1").jVertTabs();			
						
			// add click events for open tab buttons
			$("input[id^=nextTab]").not("#nextTabGGG").each(function(index){
				$(this).click(function(){
					nextTab("#vtabs1",index);
					$('html, body').animate({scrollTop:0}, 'fast');
					return false;
				});
			});	
			$("input[id^=prevTab]").each(function(index){
				$(this).click(function(){
					prevTab("#vtabs1",index);
					$('html, body').animate({scrollTop:0}, 'fast');
					return false;
				});
			});	
			function nextTab(tabId,index){
				$(tabId).jVertTabs('selected',index+1);
			}
			function prevTab(tabId,index){
				$(tabId).jVertTabs('selected',index);
			}
		});
		
		$(function() {

		    var $sidebar   = $("#tab-nav"), 
		        $window    = $(window),
		        offset     = $sidebar.offset(),
		        topPadding = -250;
		
		    $window.scroll(function() {
		        if ($window.scrollTop()-300 > (offset.top) && $window.width() > 960) {
		        
		            $sidebar.stop().animate({
		                marginTop: $window.scrollTop() - offset.top + topPadding
		            }, 100, 'linear');
		        } else {
		            $sidebar.stop().animate({
		                marginTop: 0
		            }, 100, 'linear');
		        }
		    });
		    
		});
		
	</script>
	
	
		   

    <?php
	    //show survey

		// if no user email was found and they're trying to get to form 2, then display message that they need to complete the survey 1 first
		if ($fid == 2 && $no_entry == true && !(current_user_can('bypass_survey1')) ) { ?>
			<div class='page type-page status-publish hentry'>
		    		<div class='entry-content'>
		    		<?php //echo "fid: " .$fid; ?>
		    		<h2>Oops</h2>
					<p>You are trying to access Survey 2, but no entry for Survey 1 was found. Please complete Survey 1 before proceeding.<br /><br />
			    	<a href='<?php echo wp_logout_url(get_permalink()); ?>'>Logout</a></p> 
			    	</div></div>
		<?php
		} else {
			//show the form
	    	get_template_part( 'loop', 'page' );	
	    }
	} 
}
else if (!(current_user_can('level_0'))){ ?>
    	
			<h2>Login</h2>
				<form action="<?php echo get_option("home"); ?>/wp-login.php" method="post">
				<ul id="login-form">
					<li>
						<label for="log">User name:</label><input type="text" name="log" id="log" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="20" />
					</li>
					<li>
						<label for="pwd">Password:</label><input type="password" name="pwd" id="pwd" size="20" />
					</li>
					<li>
						<input type="submit" name="submit" value="Submit" class="button" />
					</li>
				</ul>
				
				    <p>
				       <label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> Remember me</label>
				       <input type="hidden" name="redirect_to" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
				    </p>
				</form>
				<a href="<?php echo get_option("home"); ?>/wp-login.php?action=lostpassword">Recover password</a>
				
		<?php } else { ?>
		
			<h2>Logout</h2>
			<a href="<?php echo wp_logout_url(urlencode($_SERVER["REQUEST_URI"])); ?>">logout</a><br />
			
			
		<?php }


	st_after_content();
	get_footer();



?>
