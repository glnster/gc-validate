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
    
    
    if ( $wpdb->query("SELECT * FROM `thi11wp_rg_lead_detail` WHERE value='$user_email'") ) { 
	    /*Found a matching email. That means they have already submitted an entry.
	      Now see if they're allowed to redo and submit an updated one. */	      

	    //check if they're in pending/correction status or not
	    $lid = $wpdb->get_row("SELECT * FROM `thi11wp_rg_lead_detail` WHERE value='$user_email'", ARRAY_A);
	    $lead_id = $lid['lead_id'];
	   // echo ' lid:' .$lead_id;

	    $resub_row = $wpdb->get_row("SELECT * FROM `thi11wp_rg_lead_detail` WHERE field_number=140 AND lead_id=$lead_id", ARRAY_A);
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
	    

	} 
	
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
        		
			
			//these fields are only allowed to accept digits
			$("#gform_1").validate({
				  rules: {
				    input_6: {digits: true,min: 1,max: 150},
				    input_11: {digits: true,min: 1,max: 150},
				    input_12: {digits: true,min: 1,max: 150},
				    input_20: {digits: true,min: 1},
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
				    input_101: {digits: true,min: 1,max: 150},
				    input_104: {digits: true,min: 1,max: 150},
				    input_106: {digits: true,min: 1,max: 150}
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
			
			var $runCount = 0;
			
			// add click events for open tab buttons
			$("input[id^=nextTab]").each(function(index){
				$(this).click(function(){
					
					if ($runCount == 0) {
						//console.log("runCount before validation: "+$runCount);
						var hasBlank = validateThis(index);
						//console.log("hasBlank: " +hasBlank);
						
						if (!hasBlank) {
							$runCount = 0;			
							nextTab("#vtabs1",index);
							$('html, body').animate({scrollTop:0}, 'fast');
						} else {
							$("#masthead").after('<h5 class="error">Blank fields are highlighted. You may answer them or click Next anyway to proceed to the next section.</h5>');
							$('html, body').animate({scrollTop:0}, 'fast');
						}
						
								
						$runCount = 1;
						//console.log("set runCount to: " +$runCount);
						return false;
					}
					
					if ($runCount == 1)	{	
						//console.log("2nd time around: "+$runCount);
						$runCount = 0;	
						//console.log("reset runCount to: " +$runCount);		
						nextTab("#vtabs1",index);
						$('html, body').animate({scrollTop:0}, 'fast');
					}
					
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
		
					//do onchange validation for number fields


		
	</script>
	
	
		   

		    <?php
		    		    //show survey
		    	get_template_part( 'loop', 'page' );	
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
