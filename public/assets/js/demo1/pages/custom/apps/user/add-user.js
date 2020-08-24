"use strict";


function verifierRS(keywords)
{
	if(keywords.length > 3)
	{
		$("#searchingRS").html('<span><i class="fa fa-spinner fa-pulse"></i> Recherche en cours</span>');
		
		$.ajax({
		        type:'POST',
		        url:'/comptes/rechercher-presta',
		        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
			        "keywords": keywords
			     },
		         success:function(data){
		            $("#searchingRS").html(data);
		         }
		      });
	}
}

function verifierSI(keywords)
{
	$("#searchingSI").html('<span><i class="fa fa-spinner fa-pulse"></i> Recherche en cours</span>');
	
	$.ajax({
	        type:'POST',
	        url:'/comptes/rechercher-presta3',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "keywords": keywords
		     },
	         success:function(data){
	            if(data == '' || data == 'warning')
				{
					if(data == 'warning')
						$("#searchingSI").html('<i class="fa fa-exclamation-triangle"></i> Un compte avec le même SIREN que vous existe déjà sur OASIS, ce n’est pas bloquant mais renseignez-vous dans votre entreprise ou contactez notre support pour ne pas ouvrir de compte inutile');
					else
						$("#searchingSI").html(data);
					
					$("#next").show();
				}	
				else
				{
					$("#searchingSI").html(data);
					$("#next").hide();
				}
	         }
	      });
}



function verifierEM(keywords)
{
	if(keywords.length > 3)
	{
		$("#searchingEM").html('<span><i class="fa fa-spinner fa-pulse"></i> Recherche en cours</span>');
		
		$.ajax({
		        type:'POST',
		        url:'/comptes/rechercher-presta2',
		        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
			        "keywords": keywords
			     },
		         success:function(data){
		            if(data == '')
					{
						$("#searchingEM").html(data);
						$("#next").show();
					}	
					else
					{
						$("#searchingEM").html(data);
						$("#next").hide();
					}
		         }
		      });
	}
}

function verifierPWD(password)
{
	$.ajax({
	        type:'POST',
	        url:'/comptes/verifier-password',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {
		        "password": password
		     },
	         success:function(data){
	            if(data == '')
				{
					if($('#pwdconf').val() == $('#pwd').val())
					{
						$("#next").show();
						$("#score_password").html('');
					}	
					else
					{
						$("#next").hide();
						$("#score_password").html('<span class="text-danger">Les mots de passe sont différents</span>');
					}	
				}	
				else
				{
					$("#next").hide();
					$("#score_password").html(data);
				}
	         }
	      });
}

function verifierCPWD()
{
	if($('#pwdconf').val() == $('#pwd').val())
	{
		$("#next").show();
		$("#score_password").html('');
	}	
	else
	{
		$("#next").hide();
		$("#score_password").html('<span class="text-danger">Les mots de passe sont différents</span>');
	}
}

// Class definition
var KTAppUserAdd = function () {
	// Base elements
	var wizardEl;
	var formEl;
	var validator;
	var wizard;
	var avatar;
	
	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		wizard = new KTWizard('kt_apps_user_add_user', {
			startStep: 1,
		});

		// Validation before going to next page
		wizard.on('beforeNext', function(wizardObj) {
			if (validator.form() !== true) {
				wizardObj.stop();  // don't go to the next step
			}
		})

		// Change event
		wizard.on('change', function(wizard) {
			KTUtil.scrollTop();	
		});
	}

	var initValidation = function() {
		validator = formEl.validate({
			// Validate only visible fields
			ignore: ":hidden",

			// Validation rules
			rules: {
				raisonSociale: {
					required: true
				}
			},
			
			// Display error  
			invalidHandler: function(event, validator) {	 
				KTUtil.scrollTop();

				swal.fire({
					"title": "", 
					"text": "There are some errors in your submission. Please correct them.", 
					"type": "error",
					"buttonStyling": false,
					"confirmButtonClass": "btn btn-brand btn-sm btn-bold"
				});
			},

			// Submit valid form
			submitHandler: function (form) {
				
			}
		});   
	}

	var initSubmit = function() {
		var btn = formEl.find('[data-ktwizard-type="action-submit"]');

		btn.on('click', function(e) {
			e.preventDefault();

			$.ajax({
					type:'POST',
					url:'/comptes/adduser',
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: $("#kt_apps_user_add_user_form").serialize(),
				     success:function(data){
						 $('#kt_modal_creation').modal('show');
				     },
					 error:function(data){;
						 var message = JSON.parse(data.fail().responseText);
						 console.log(message);
						 $('#error_message').html(message.message);
						 $('#kt_modal_error').modal('show');
				     }
					 
				});
		});
	}
	 
	var initKTAppsUserAdd = function() {
		avatar = new KTAvatar('kt_apps_user_add_user_avatar');
	}	

	return {
		// public functions
		init: function() {
			formEl = $('#kt_apps_user_add_user_form');

			initWizard(); 
			initValidation();
			initSubmit();
			initKTAppsUserAdd(); 
		}
	};
}();

jQuery(document).ready(function() {	
	KTAppUserAdd.init();
});