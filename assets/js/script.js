$("#sub[1]").click( function() {
 $.post( $("#myForm").attr("action"), 
         $("#myForm :td").serializeArray(), 
         function(info){ $("#result").html(info); 
   });
 clearInput();
});
 
$("#myForm").submit( function() {
  return false;	
});
 
function clearInput() {
	$("#myForm :td").each( function() {
	   $(this).val('');
	});
}