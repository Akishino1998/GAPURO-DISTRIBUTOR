"use strict";
 
// Class Definition
var KTLogin = function() {
	var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

	var _handleFormSignin = function() {
		var form = KTUtil.getById('kt_login_singin_form');
		var formSubmitUrl = KTUtil.attr(form, 'action');
		var formSubmitButton = KTUtil.getById('kt_login_singin_form_submit_button');
		console.log(form);
		if (!form) {
			return;
		}

		FormValidation
		    .formValidation(
		        form,
		        {
		            fields: {
						email: {
							validators: {
								notEmpty: {
									message: 'Email is required'
								}
							}
						},
						password: {
							validators: {
								notEmpty: {
									message: 'Password is required'
								}
							}
						}
		            },
		            plugins: {
						trigger: new FormValidation.plugins.Trigger(),
						submitButton: new FormValidation.plugins.SubmitButton(),
	            		//defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
						bootstrap: new FormValidation.plugins.Bootstrap({
						//	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
						//	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
						})
		            }
		        }
		    )
		    .on('core.form.valid', function() {
				// Show loading state on button
				KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

				// Simulate Ajax request
				setTimeout(function() {
					KTUtil.btnRelease(formSubmitButton);
				}, 2000);

				// Form Validation & Ajax Submission: https://formvalidation.io/guide/examples/using-ajax-to-submit-the-form
				
		        // FormValidation.utils.fetch(formSubmitUrl, {
		        //     method: 'POST',
				// 	dataType: 'json',
		        //     params: {
		        //         name: form.querySelector('[name="email"]').value,
		        //         email: form.querySelector('[name="password"]').value,
		        //     },
		        // }).then(function(response) { // Return valid JSON
				// 	// Release button
				// 	KTUtil.btnRelease(formSubmitButton);

				// 	if (response && typeof response === 'object' && response.status && response.status == 'success') {
				// 		Swal.fire({
			    //             text: "All is cool! Now you submit this form",
			    //             icon: "success",
			    //             buttonsStyling: false,
				// 			confirmButtonText: "Ok, got it!",
				// 			customClass: {
				// 				confirmButton: "btn font-weight-bold btn-light-primary"
				// 			}
			    //         }).then(function() {
				// 			KTUtil.scrollTop();
				// 		});
				// 	} else {
				// 		Swal.fire({
			    //             text: "Sorry, something went wrong, please try again.",
			    //             icon: "error",
			    //             buttonsStyling: false,
				// 			confirmButtonText: "Ok, got it!",
				// 			customClass: {
				// 				confirmButton: "btn font-weight-bold btn-light-primary"
				// 			}
			    //         }).then(function() {
				// 			KTUtil.scrollTop();
				// 		});
				// 	}
		        // });
				
		    })
			.on('core.form.invalid', function() {
				Swal.fire({
					text: "Sorry, looks like there are some errors detected, please try again.",
					icon: "error",
					buttonsStyling: false,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn font-weight-bold btn-light-primary"
					}
				}).then(function() {
					KTUtil.scrollTop();
				});
		    });
    }

	var _handleFormForgot = function() {
		var form = KTUtil.getById('kt_login_forgot_form');
		var formSubmitUrl = KTUtil.attr(form, 'action');
		var formSubmitButton = KTUtil.getById('kt_login_forgot_form_submit_button');

		if (!form) {
			return;
		}

		FormValidation
		    .formValidation(
		        form,
		        {
		            fields: {
						email: {
							validators: {
								notEmpty: {
									message: 'Email is required'
								},
								emailAddress: {
									message: 'The value is not a valid email address'
								}
							}
						}
		            },
		            plugins: {
						trigger: new FormValidation.plugins.Trigger(),
						submitButton: new FormValidation.plugins.SubmitButton(),
	            		//defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
						bootstrap: new FormValidation.plugins.Bootstrap({
						//	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
						//	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
						})
		            }
		        }
		    )
		    .on('core.form.valid', function() {
				// Show loading state on button
				KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

				// Simulate Ajax request
				setTimeout(function() {
					KTUtil.btnRelease(formSubmitButton);
				}, 2000);
		    })
			.on('core.form.invalid', function() {
				Swal.fire({
					text: "Sorry, looks like there are some errors detected, please try again.",
					icon: "error",
					buttonsStyling: false,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn font-weight-bold btn-light-primary"
					}
				}).then(function() {
					KTUtil.scrollTop();
				});
		    });
    }

	var _handleFormSignup = function() {
		// Base elements
		var wizardEl = KTUtil.getById('kt_login');
		var form = KTUtil.getById('kt_login_signup_form');
		var wizardObj;
		var validations = [];

		if (!form) {
			return;
		}

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					nama_toko: {
						validators: {
							notEmpty: {
								message: 'Nama Toko is required'
							}
						}
					},
					no_hp: {
						validators: {
							notEmpty: {
								message: 'No. HP is required'
							}
						}
					},
					logo: {
						validators: {
							notEmpty: {
								message: 'Logo is required'
							}
						}
					},
					email: {
						validators: {
							notEmpty: {
								message: 'Email is required'
							},
							emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 2
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: { 
					jenis_elektornik: {
						validators: {
							notEmpty: {
								message: 'Harus ada layananmu dong!'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 3
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					lat: {
						validators: {
							notEmpty: {
								message: 'Pilih Lokasi Pada Maps'
							}
						}
					},
					alamat: {
						validators: {
							notEmpty: {
								message: 'Alamat is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Initialize form wizard
		wizardObj = new KTWizard(wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: false // to make steps clickable this set value true and add data-wizard-clickable="true" in HTML for class="wizard" element
		});

		// Validation before going to next page
		wizardObj.on('beforeNext', function (wizard) {
			validations[wizard.getStep() - 1].validate().then(function (status) {
				if (status == 'Valid') {
					wizardObj.goNext();
					KTUtil.scrollTop();
					$("#rnama_toko").html("Nama : "+$("#nama").val());
					$("#rno_hp").html("No. HP : "+$("#no_hp").val());
					$("#remail").html("Email : "+$("#email").val());
					$("#rlayanan").html("Melayani Perbaikan : "+elektronik);
					$("#ralamat").html("Alamat : "+$("#alamat").val());
					if($("#lat").val() != ""){
						var lat = parseFloat($("#lat").val());
						var lng = parseFloat($("#lng").val());
						var myLatLng = {lat:lat, lng: lng};
						
						if( marker2 ){
							// pindahkan marker
							marker2.setPosition(myLatLng);
							} else {
							// buat marker baru
							marker2 = new google.maps.Marker({
								position: myLatLng,
								map: peta2
							});
						}
						peta2.setCenter(myLatLng);
					}
					var logo = document.getElementById("logo");
					if(logo.files.length > 0){
						var item = document.getElementById("rlogo");
						item.src = URL.createObjectURL(logo.files[0]);

					}
					// $("#rnama").val($("#nama").val());
				} else {
					Swal.fire({
						text: "Diisi semuanya, yaaa!",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Okeee",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light-primary"
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});

			wizardObj.stop();  // Don't go to the next step
		});

		// Change event
		wizardObj.on('change', function (wizard) {
			KTUtil.scrollTop();
		});
    }

    // Public Functions
    return {
        init: function() {
            _handleFormSignin();
			_handleFormForgot();
			_handleFormSignup();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTLogin.init();
});
