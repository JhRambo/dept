
function getCheckVals(name){
	var vals = [];
	$("input[name = "+name+"]:checked").each(function(){
		vals.push(this.value);
	});
	
	return vals;
}