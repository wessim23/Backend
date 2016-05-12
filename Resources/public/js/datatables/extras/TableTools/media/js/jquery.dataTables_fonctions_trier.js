$.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
	 
	var ukDatea = a.split('/');
	var ukDatea_ = ukDatea[2].split(' ');
	var x_hms = '';
	if( ukDatea_.length > 1 ){
		var ukDatea_hms = ukDatea_[1].split(':');
		if( ukDatea_hms.length > 2 ){
			x_hms = ukDatea_hms[0] + ukDatea_hms[1] + ukDatea_hms[2]
		}
	}
	
	var ukDateb = b.split('/');
	var ukDateb_ = ukDateb[2].split(' ');
	var y_hms = '';
	if( ukDateb_.length > 1 ){
		var ukDateb_hms = ukDateb_[1].split(':');
		if( ukDateb_hms.length > 2 ){
			y_hms = ukDateb_hms[0] + ukDateb_hms[1] + ukDateb_hms[2]
		}
	}
	var x = (ukDatea_[0] + ukDatea[1] + ukDatea[0] + x_hms) * 1;
	var y = (ukDateb_[0] + ukDateb[1] + ukDateb[0] + y_hms) * 1;
 
	return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
$.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
	var ukDatea = a.split('/');
	var ukDatea_ = ukDatea[2].split(' ');
	var x_hms = '';
	if( ukDatea_.length > 1 ){
		var ukDatea_hms = ukDatea_[1].split(':');
		if( ukDatea_hms.length > 2 ){
			x_hms = ukDatea_hms[0] + ukDatea_hms[1] + ukDatea_hms[2]
		}
	}
	
	var ukDateb = b.split('/');
	var ukDateb_ = ukDateb[2].split(' ');
	var y_hms = '';
	if( ukDateb_.length > 1 ){
		var ukDateb_hms = ukDateb_[1].split(':');
		if( ukDateb_hms.length > 2 ){
			y_hms = ukDateb_hms[0] + ukDateb_hms[1] + ukDateb_hms[2]
		}
	}
	var x = (ukDatea_[0] + ukDatea[1] + ukDatea[0] + x_hms) * 1;
	var y = (ukDateb_[0] + ukDateb[1] + ukDateb[0] + y_hms) * 1;
 
	return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
};
$.fn.dataTableExt.oSort['uk_date_fr-asc']  = function(a,b) {
	 
	var ukDatea = a.split('-');
	var ukDatea_ = ukDatea[2].split(' ');
	var x_hms = '';
	if( ukDatea_.length > 1 ){
		var ukDatea_hms = ukDatea_[1].split(':');
		if( ukDatea_hms.length > 2 ){
			x_hms = ukDatea_hms[0] + ukDatea_hms[1] + ukDatea_hms[2]
		}
	}
	
	var ukDateb = b.split('-');
	var ukDateb_ = ukDateb[2].split(' ');
	var y_hms = '';
	if( ukDateb_.length > 1 ){
		var ukDateb_hms = ukDateb_[1].split(':');
		if( ukDateb_hms.length > 2 ){
			y_hms = ukDateb_hms[0] + ukDateb_hms[1] + ukDateb_hms[2]
		}
	}
	var x = (ukDatea_[0] + ukDatea[1] + ukDatea[0] + x_hms) * 1;
	var y = (ukDateb_[0] + ukDateb[1] + ukDateb[0] + y_hms) * 1;
 
	return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
 
$.fn.dataTableExt.oSort['uk_date_fr-desc'] = function(a,b) {
	var ukDatea = a.split('-');
	var ukDatea_ = ukDatea[2].split(' ');
	var x_hms = '';
	if( ukDatea_.length > 1 ){
		var ukDatea_hms = ukDatea_[1].split(':');
		if( ukDatea_hms.length > 2 ){
			x_hms = ukDatea_hms[0] + ukDatea_hms[1] + ukDatea_hms[2]
		}
	}
	
	var ukDateb = b.split('-');
	var ukDateb_ = ukDateb[2].split(' ');
	var y_hms = '';
	if( ukDateb_.length > 1 ){
		var ukDateb_hms = ukDateb_[1].split(':');
		if( ukDateb_hms.length > 2 ){
			y_hms = ukDateb_hms[0] + ukDateb_hms[1] + ukDateb_hms[2]
		}
	}
	var x = (ukDatea_[0] + ukDatea[1] + ukDatea[0] + x_hms) * 1;
	var y = (ukDateb_[0] + ukDateb[1] + ukDateb[0] + y_hms) * 1;
 
	return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
};
$.fn.dataTableExt.oSort['numeric_rim-asc']  = function(a,b) {
	a = a.replace( /<.*?>/g, "" ).toLowerCase();
	b = b.replace( /<.*?>/g, "" ).toLowerCase();
	var x = (a=="-" || a==="") ? 0 : a*1;
	var y = (b=="-" || b==="") ? 0 : b*1;
	return x - y;
};

$.fn.dataTableExt.oSort['numeric_rim-desc'] = function(a,b) {
	a = a.replace( /<.*?>/g, "" ).toLowerCase();
	b = b.replace( /<.*?>/g, "" ).toLowerCase();
	var x = (a=="-" || a==="") ? 0 : a*1;
	var y = (b=="-" || b==="") ? 0 : b*1;
	return y - x;
};