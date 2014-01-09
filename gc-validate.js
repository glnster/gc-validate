/*
Flow:
- click on the Next button
- has the page been checked for blanks?
	- yes: goto next page
	- no: check it for blanks. trigger a validation switch
		- show all the fields that are blank and set focus to the first blank field
	
*/

//checks for blank fields, returns blank count
function checkBlank(ftype, fname) {

	switch (ftype) {
		case "r": ftype = "radio"; break;
		case "s": ftype = "select"; break;
		case "i": ftype = "input"; break;
		default: alert("no type specified");
	}
	
	
	var field = (ftype == "radio") ? $("input[name='input_"+fname+"']") : $(ftype+"[name='input_"+fname+"']");
	
	var blank = ($(field).getValue() == '') ? true : false;
	
	

	//debug
	if(blank) {
		//console.log("input_"+fname+" is blank!");
	} else {
		//console.log("input_"+fname+": "+$(field).getValue());
	}	
	
	return blank;
	
}




function validateThis() {

			var fld = {
				"18" : "s",
				"17" : "s",
				"16" : "s",
				"15" : "s",
				"14" : "s",
				"13" : "r",
				"12" : "i",
				"11" : "i",
				"10" : "r",
				"157" : "s",
				"158" : "s",
				"6" : "i",
				"5" : "r",
				"4" : "r",
//
				"30" : "s",
				"29" : "i",
				"28" : "i",
				"27" : "s",
				"26" : "s",
				"25" : "s",
				"24" : "s",
				"23" : "r",
				"22" : "s",
				"137" : "s",
				"136" : "s",
				"20" : "i",
				"133" : "r",
				"132" : "s",
				"131" : "s",
//
				"34" : "r",
				"33" : "r",
//
				"46" : "r",
				"45" : "r",
				"44" : "r",
				"43" : "r",
				"42" : "r",
				"41" : "r",
				"40" : "r",
				"39" : "r",
				"38" : "r",
				"37" : "r",
//
				"58" : "r",
				"57" : "r",
				"56" : "r",
				"55" : "r",
				"54" : "r",
				"53" : "r",
				"52" : "r",
				"51" : "r",
				"50" : "r",
				"49" : "r",
//
				"68" : "s",
				"67" : "s",
				"66" : "s",
				"65" : "s",
				"64" : "s",
				"63" : "s",
				"62" : "s",
				"61" : "s",
				"60" : "r",
//
				"87[]" : "s",
				"86" : "s",
				"156" : "i",
				"85" : "r",
				"155" : "i",
				"84" : "r",
				"154" : "i",
				"83" : "r",
				"153" : "i",
				"82" : "r",
				"152" : "i",
				"81" : "r",
				"151" : "i",
				"80" : "r",
				"150" : "i",
				"79" : "r",
				"149" : "i",
				"78" : "r",
				"148" : "i",
				"77" : "r",
				"147" : "i",
				"76" : "r",
				"146" : "i",
				"75" : "r",
				"145" : "i",
				"74" : "r",
				"144" : "i",
				"73" : "r",
				"143" : "i",
				"72" : "r",
				"142" : "i",
				"71" : "r",
//
				"90" : "r",
				"89" : "r",
//
				"106" : "i",
				"105" : "r",
				"104" : "i",
				"103" : "r",
				"102" : "i",
				"101" : "i",
				"100" : "r",
				"99" : "r",
				"98" : "r",
				"96" : "r",
				"95" : "r",
				"94" : "r",
				"93" : "r"
			}
			
			var gotIt = 0;
			var saveKey;
			
			$.each(fld, function(key, value) {
			    	if (checkBlank(value, key) && gotIt <= 0) {
				    	gotIt = 1;
				    	saveKey = key;
/*
				    	console.log("within validateThis and found the first blank: " +key);
				    	return saveKey;
*/
			    	}			    
			});

			//console.log("within validateThis. Panel : " +$(saveKey).closest('.vtabs_content_panel').attr(id));
			return $("select[name='input_4']").closest(".vtabs-content-panel").attr("id");
	
}




	
/*
$.each($('#gform_1')[0].elements,
           function(i,o)
           {
            var _this=$(o);
            console.log('id:'+_this.attr('id')+'\ntitle:'+_this.attr('title'));
           })

*/

	


	

 


