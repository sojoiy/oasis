$(document).ready(function() {
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	var myDropzone = new Dropzone("div#m_dropzone_three", { 
		url: "/chantier/upload",
		headers: { 'x-csrf-token': CSRF_TOKEN }
	});
	
	myDropzone.on("complete", function(file) {
	   	// ON MET A JOUR LE TOKEN DU FILE ID
	});
	
	myDropzone.on("sending", function(file, xhr, formData) {
	      formData.append("data", $('#file_ID').val());
	});
});