@extends('layout.default')

@section('content')

<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Création de compte DO</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<div class="modal fade" id="kt_modal_creation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Compte créé</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<p>Le compte a été créé.</p>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-primary">OK</button>
					<!-- ><button type="button" data-dismiss="modal" class="btn btn-danger">Non merci, je veux recharger mes pièces</button> -->
				</div>
			</div>
		</div>
	</div>
	
	<div class="kt-wizard-v4" id="kt_apps_user_add_user" data-ktwizard-state="step-first">

		<!--begin: Form Wizard Nav -->
		<div class="kt-wizard-v4__nav">
			<div class="kt-wizard-v4__nav-items nav">
				<a class="kt-wizard-v4__nav-item nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="current">
					<div class="kt-wizard-v4__nav-body">
						<div class="kt-wizard-v4__nav-number">
							1
						</div>
						<div class="kt-wizard-v4__nav-label">
							<div class="kt-wizard-v4__nav-label-title">
								Société
							</div>
							<div class="kt-wizard-v4__nav-label-desc">
								Informations générales
							</div>
						</div>
					</div>
				</a>
				<a class="kt-wizard-v4__nav-item nav-item" href="#" data-ktwizard-type="step">
					<div class="kt-wizard-v4__nav-body">
						<div class="kt-wizard-v4__nav-number">
							2
						</div>
						<div class="kt-wizard-v4__nav-label">
							<div class="kt-wizard-v4__nav-label-title">
								Compte
							</div>
							<div class="kt-wizard-v4__nav-label-desc">
								Connexion à l'application
							</div>
						</div>
					</div>
				</a>
				<a class="kt-wizard-v4__nav-item nav-item" href="#" data-ktwizard-type="step">
					<div class="kt-wizard-v4__nav-body">
						<div class="kt-wizard-v4__nav-number">
							3
						</div>
						<div class="kt-wizard-v4__nav-label">
							<div class="kt-wizard-v4__nav-label-title">
								Addresses
							</div>
							<div class="kt-wizard-v4__nav-label-desc">
								Données de contact
							</div>
						</div>
					</div>
				</a>
				<a class="kt-wizard-v4__nav-item nav-item" href="#" data-ktwizard-type="step">
					<div class="kt-wizard-v4__nav-body">
						<div class="kt-wizard-v4__nav-number">
							4
						</div>
						<div class="kt-wizard-v4__nav-label">
							<div class="kt-wizard-v4__nav-label-title">
								Abonnement
							</div>
							<div class="kt-wizard-v4__nav-label-desc">
								Vos options
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>

		<!--end: Form Wizard Nav -->
		<div class="kt-portlet">
			<div class="kt-portlet__body kt-portlet__body--fit">
				<div class="kt-grid">
					<div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">

						<!--begin: Form Wizard Form-->
						<form class="kt-form" id="kt_apps_user_add_user_form" method="post">
							<input type="hidden" name="societe" value="{{ $societe->id }}" >

							<!--begin: Form Wizard Step 1-->
							<div class="kt-wizard-v4__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
								<div class="kt-section kt-section--first">
									<div class="kt-wizard-v4__form">
										<div class="row">
											<div class="col-xl-12">
												<div class="kt-section__body">
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Nom</label>
														<div class="col-lg-9 col-xl-9">
															<input class="form-control" type="text" name="nom" value="">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Prénom</label>
														<div class="col-lg-9 col-xl-9">
															<input class="form-control" type="text" value="" name="prenom">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Raison sociale</label>
														<div class="col-lg-9 col-xl-9">
															<input class="form-control" type="text" required onkeyup="verifierRS(this.value);" id="raisonSociale" name="raison_sociale" value="{{ $societe->raisonSociale }}">
															<span class="form-text text-muted" id="searchingRS">Indiquez ici la raison sociale telle qu'elle apparait sur le Kbis.</span>
														</div>
													</div>
													<div class="form-group form-group-last row">
														<label class="col-xl-3 col-lg-3 col-form-label">Numéro SIRET</label>
														<div class="col-lg-9 col-xl-9">
															<div class="input-group">
																<input type="text" name="no_siret" required onkeyup="verifierSI(this.value);" id="sjy_inputmask_siret" class="form-control" placeholder="N° SIRET" value="{{ $societe->noSiret }}">
															</div>
															<span class="form-text text-muted" id="searchingSI"></span>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Téléphone</label>
														<div class="col-lg-9 col-xl-9">
															<div class="input-group">
																<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone"></i></span></div>
																<input type="text" class="form-control" name="telephone" value="" placeholder="Phone" aria-describedby="basic-addon1">
															</div>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Email </label>
														<div class="col-lg-9 col-xl-9">
															<div class="input-group">
																<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
																<input type="email" name="email" required onkeyup="$('#identifiant').val(this.value);verifierEM(this.value);" class="form-control" value="{{ $societe->email }}" placeholder="Email" aria-describedby="basic-addon1">
															</div>
															<span class="form-text text-muted" id="searchingEM">&nbsp;</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!--end: Form Wizard Step 1-->

							<!--begin: Form Wizard Step 2-->
							<div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
								<div class="kt-section kt-section--first">
									<div class="kt-wizard-v4__form">
										<div class="row">
											<div class="col-xl-12">
												<div class="kt-section__body">
													<div class="form-group row">
														<div class="col-lg-9 col-xl-6">
															<h3 class="kt-section__title kt-section__title-md">Identifiants</h3>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Identifiant</label>
														<div class="col-lg-9 col-xl-9">
															<input class="form-control" type="text" value="" disabled id="identifiant">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Mot de passe</label>
														<div class="col-lg-9 col-xl-9">
															<div class="input-group">
																<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-key"></i></span></div>
																<input type="password" autocomplete="off" id="pwd" minlength="8" required name="password" class="form-control" onkeyup="verifierPWD(this.value)" value="" placeholder="Mot de passe" aria-describedby="basic-addon1">
															</div>
															<span class="form-text text-muted" id="score_password">Minimum 8 caractères dont 2 chiffres.</span>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Vérification mot de passe</label>
														<div class="col-lg-9 col-xl-9">
															<div class="input-group">
																<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-key"></i></span></div>
																<input type="password" autocomplete="off" id="pwdconf" minlength="8" required name="password_conf" class="form-control" onkeyup="verifierCPWD()" value="" placeholder="Saisissez à nouveau le mot de passe" aria-describedby="basic-addon1">
															</div>
														</div>
													</div>
													<div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>
													<div class="form-group row">
														<div class="col-lg-9 col-xl-6">
															<h3 class="kt-section__title kt-section__title-md">Vie privée</h3>
														</div>
													</div>

													<div class="form-group form-group-last row">
														<label class="col-xl-3 col-lg-3 col-form-label">Communication</label>
														<div class="col-lg-9 col-xl-6">
															<div class="kt-checkbox-inline">
																<label class="kt-checkbox">
																	<input type="checkbox" checked=""> Email
																	<span></span>
																</label>
																<label class="kt-checkbox">
																	<input type="checkbox" checked=""> SMS
																	<span></span>
																</label>
																<label class="kt-checkbox">
																	<input type="checkbox"> Téléphone
																	<span></span>
																</label>
															</div>
															<span class="form-text text-muted">Indiquez-nous la façon dont nous pouvons vous contacter (Assistance, informations importantes).</span>
														</div>
													</div>
													<br>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label"></label>
														<div class="col-lg-9 col-xl-6">
															<div class="kt-checkbox-single">
																<label class="kt-checkbox">
																	<input type="checkbox"> Consentement RGPD 
																	<span></span>
																</label>
															</div>
															<span class="form-text text-muted">
																Pour connaître la façon dont nous utilisons vos données connectez vous à la page suivante
																<a href="#" class="kt-link">RGPD</a>.
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!--end: Form Wizard Step 2-->

							<!--begin: Form Wizard Step 3-->
							<div class="kt-wizard-v4__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
								<div class="kt-heading kt-heading--md">Adresse</div>
								<div class="kt-form__section kt-form__section--first">
									<div class="kt-wizard-v4__form">
										<div class="form-group">
											<label>Nom directeur</label>
											<input type="text" class="form-control" name="nomDirecteur" placeholder="DOE" value="">
										</div>
										<div class="form-group">
											<label>Prénom directeur</label>
											<input type="text" class="form-control" name="prenomDirecteur" placeholder="John" value="">
										</div>
										<div class="form-group">
											<label>Adresse</label>
											<input type="text" class="form-control" name="adresse" placeholder="75 Rue de la paix" value="">
										</div>
										<div class="form-group">
											<label>Complément</label>
											<input type="text" class="form-control" name="complement" placeholder="BP00000" value="">
										</div>
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group">
													<label>Code Postal</label>
													<input type="text" class="form-control" name="code_postal" placeholder="75000" value="">
												</div>
											</div>
											<div class="col-xl-6">
												<div class="form-group">
													<label>Ville</label>
													<input type="text" class="form-control" name="ville" placeholder="Paris" value="">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xl-6">
												<div class="form-group">
													<label>Région</label>
													<input type="text" class="form-control" name="region" placeholder="Ile-de-France" value="">
												</div>
											</div>
											<div class="col-xl-6">
												<div class="form-group">
													<label>Pays</label>
													<select name="pays" class="form-control">
														<option value="">Select</option>
														<option value="AF">Afghanistan</option>
														<option value="AX">Åland Islands</option>
														<option value="AL">Albania</option>
														<option value="DZ">Algeria</option>
														<option value="AS">American Samoa</option>
														<option value="AD">Andorra</option>
														<option value="AO">Angola</option>
														<option value="AI">Anguilla</option>
														<option value="AQ">Antarctica</option>
														<option value="AG">Antigua and Barbuda</option>
														<option value="AR">Argentina</option>
														<option value="AM">Armenia</option>
														<option value="AW">Aruba</option>
														<option value="AU" selected="">Australia</option>
														<option value="AT">Austria</option>
														<option value="AZ">Azerbaijan</option>
														<option value="BS">Bahamas</option>
														<option value="BH">Bahrain</option>
														<option value="BD">Bangladesh</option>
														<option value="BB">Barbados</option>
														<option value="BY">Belarus</option>
														<option value="BE">Belgium</option>
														<option value="BZ">Belize</option>
														<option value="BJ">Benin</option>
														<option value="BM">Bermuda</option>
														<option value="BT">Bhutan</option>
														<option value="BO">Bolivia, Plurinational State of</option>
														<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
														<option value="BA">Bosnia and Herzegovina</option>
														<option value="BW">Botswana</option>
														<option value="BV">Bouvet Island</option>
														<option value="BR">Brazil</option>
														<option value="IO">British Indian Ocean Territory</option>
														<option value="BN">Brunei Darussalam</option>
														<option value="BG">Bulgaria</option>
														<option value="BF">Burkina Faso</option>
														<option value="BI">Burundi</option>
														<option value="KH">Cambodia</option>
														<option value="CM">Cameroon</option>
														<option value="CA">Canada</option>
														<option value="CV">Cape Verde</option>
														<option value="KY">Cayman Islands</option>
														<option value="CF">Central African Republic</option>
														<option value="TD">Chad</option>
														<option value="CL">Chile</option>
														<option value="CN">China</option>
														<option value="CX">Christmas Island</option>
														<option value="CC">Cocos (Keeling) Islands</option>
														<option value="CO">Colombia</option>
														<option value="KM">Comoros</option>
														<option value="CG">Congo</option>
														<option value="CD">Congo, the Democratic Republic of the</option>
														<option value="CK">Cook Islands</option>
														<option value="CR">Costa Rica</option>
														<option value="CI">Côte d'Ivoire</option>
														<option value="HR">Croatia</option>
														<option value="CU">Cuba</option>
														<option value="CW">Curaçao</option>
														<option value="CY">Cyprus</option>
														<option value="CZ">Czech Republic</option>
														<option value="DK">Denmark</option>
														<option value="DJ">Djibouti</option>
														<option value="DM">Dominica</option>
														<option value="DO">Dominican Republic</option>
														<option value="EC">Ecuador</option>
														<option value="EG">Egypt</option>
														<option value="SV">El Salvador</option>
														<option value="GQ">Equatorial Guinea</option>
														<option value="ER">Eritrea</option>
														<option value="EE">Estonia</option>
														<option value="ET">Ethiopia</option>
														<option value="FK">Falkland Islands (Malvinas)</option>
														<option value="FO">Faroe Islands</option>
														<option value="FJ">Fiji</option>
														<option value="FI">Finland</option>
														<option value="FR">France</option>
														<option value="GF">French Guiana</option>
														<option value="PF">French Polynesia</option>
														<option value="TF">French Southern Territories</option>
														<option value="GA">Gabon</option>
														<option value="GM">Gambia</option>
														<option value="GE">Georgia</option>
														<option value="DE">Germany</option>
														<option value="GH">Ghana</option>
														<option value="GI">Gibraltar</option>
														<option value="GR">Greece</option>
														<option value="GL">Greenland</option>
														<option value="GD">Grenada</option>
														<option value="GP">Guadeloupe</option>
														<option value="GU">Guam</option>
														<option value="GT">Guatemala</option>
														<option value="GG">Guernsey</option>
														<option value="GN">Guinea</option>
														<option value="GW">Guinea-Bissau</option>
														<option value="GY">Guyana</option>
														<option value="HT">Haiti</option>
														<option value="HM">Heard Island and McDonald Islands</option>
														<option value="VA">Holy See (Vatican City State)</option>
														<option value="HN">Honduras</option>
														<option value="HK">Hong Kong</option>
														<option value="HU">Hungary</option>
														<option value="IS">Iceland</option>
														<option value="IN">India</option>
														<option value="ID">Indonesia</option>
														<option value="IR">Iran, Islamic Republic of</option>
														<option value="IQ">Iraq</option>
														<option value="IE">Ireland</option>
														<option value="IM">Isle of Man</option>
														<option value="IL">Israel</option>
														<option value="IT">Italy</option>
														<option value="JM">Jamaica</option>
														<option value="JP">Japan</option>
														<option value="JE">Jersey</option>
														<option value="JO">Jordan</option>
														<option value="KZ">Kazakhstan</option>
														<option value="KE">Kenya</option>
														<option value="KI">Kiribati</option>
														<option value="KP">Korea, Democratic People's Republic of</option>
														<option value="KR">Korea, Republic of</option>
														<option value="KW">Kuwait</option>
														<option value="KG">Kyrgyzstan</option>
														<option value="LA">Lao People's Democratic Republic</option>
														<option value="LV">Latvia</option>
														<option value="LB">Lebanon</option>
														<option value="LS">Lesotho</option>
														<option value="LR">Liberia</option>
														<option value="LY">Libya</option>
														<option value="LI">Liechtenstein</option>
														<option value="LT">Lithuania</option>
														<option value="LU">Luxembourg</option>
														<option value="MO">Macao</option>
														<option value="MK">Macedonia, the former Yugoslav Republic of</option>
														<option value="MG">Madagascar</option>
														<option value="MW">Malawi</option>
														<option value="MY">Malaysia</option>
														<option value="MV">Maldives</option>
														<option value="ML">Mali</option>
														<option value="MT">Malta</option>
														<option value="MH">Marshall Islands</option>
														<option value="MQ">Martinique</option>
														<option value="MR">Mauritania</option>
														<option value="MU">Mauritius</option>
														<option value="YT">Mayotte</option>
														<option value="MX">Mexico</option>
														<option value="FM">Micronesia, Federated States of</option>
														<option value="MD">Moldova, Republic of</option>
														<option value="MC">Monaco</option>
														<option value="MN">Mongolia</option>
														<option value="ME">Montenegro</option>
														<option value="MS">Montserrat</option>
														<option value="MA">Morocco</option>
														<option value="MZ">Mozambique</option>
														<option value="MM">Myanmar</option>
														<option value="NA">Namibia</option>
														<option value="NR">Nauru</option>
														<option value="NP">Nepal</option>
														<option value="NL">Netherlands</option>
														<option value="NC">New Caledonia</option>
														<option value="NZ">New Zealand</option>
														<option value="NI">Nicaragua</option>
														<option value="NE">Niger</option>
														<option value="NG">Nigeria</option>
														<option value="NU">Niue</option>
														<option value="NF">Norfolk Island</option>
														<option value="MP">Northern Mariana Islands</option>
														<option value="NO">Norway</option>
														<option value="OM">Oman</option>
														<option value="PK">Pakistan</option>
														<option value="PW">Palau</option>
														<option value="PS">Palestinian Territory, Occupied</option>
														<option value="PA">Panama</option>
														<option value="PG">Papua New Guinea</option>
														<option value="PY">Paraguay</option>
														<option value="PE">Peru</option>
														<option value="PH">Philippines</option>
														<option value="PN">Pitcairn</option>
														<option value="PL">Poland</option>
														<option value="PT">Portugal</option>
														<option value="PR">Puerto Rico</option>
														<option value="QA">Qatar</option>
														<option value="RE">Réunion</option>
														<option value="RO">Romania</option>
														<option value="RU">Russian Federation</option>
														<option value="RW">Rwanda</option>
														<option value="BL">Saint Barthélemy</option>
														<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
														<option value="KN">Saint Kitts and Nevis</option>
														<option value="LC">Saint Lucia</option>
														<option value="MF">Saint Martin (French part)</option>
														<option value="PM">Saint Pierre and Miquelon</option>
														<option value="VC">Saint Vincent and the Grenadines</option>
														<option value="WS">Samoa</option>
														<option value="SM">San Marino</option>
														<option value="ST">Sao Tome and Principe</option>
														<option value="SA">Saudi Arabia</option>
														<option value="SN">Senegal</option>
														<option value="RS">Serbia</option>
														<option value="SC">Seychelles</option>
														<option value="SL">Sierra Leone</option>
														<option value="SG">Singapore</option>
														<option value="SX">Sint Maarten (Dutch part)</option>
														<option value="SK">Slovakia</option>
														<option value="SI">Slovenia</option>
														<option value="SB">Solomon Islands</option>
														<option value="SO">Somalia</option>
														<option value="ZA">South Africa</option>
														<option value="GS">South Georgia and the South Sandwich Islands</option>
														<option value="SS">South Sudan</option>
														<option value="ES">Spain</option>
														<option value="LK">Sri Lanka</option>
														<option value="SD">Sudan</option>
														<option value="SR">Suriname</option>
														<option value="SJ">Svalbard and Jan Mayen</option>
														<option value="SZ">Swaziland</option>
														<option value="SE">Sweden</option>
														<option value="CH">Switzerland</option>
														<option value="SY">Syrian Arab Republic</option>
														<option value="TW">Taiwan, Province of China</option>
														<option value="TJ">Tajikistan</option>
														<option value="TZ">Tanzania, United Republic of</option>
														<option value="TH">Thailand</option>
														<option value="TL">Timor-Leste</option>
														<option value="TG">Togo</option>
														<option value="TK">Tokelau</option>
														<option value="TO">Tonga</option>
														<option value="TT">Trinidad and Tobago</option>
														<option value="TN">Tunisia</option>
														<option value="TR">Turkey</option>
														<option value="TM">Turkmenistan</option>
														<option value="TC">Turks and Caicos Islands</option>
														<option value="TV">Tuvalu</option>
														<option value="UG">Uganda</option>
														<option value="UA">Ukraine</option>
														<option value="AE">United Arab Emirates</option>
														<option value="GB">United Kingdom</option>
														<option value="US">United States</option>
														<option value="UM">United States Minor Outlying Islands</option>
														<option value="UY">Uruguay</option>
														<option value="UZ">Uzbekistan</option>
														<option value="VU">Vanuatu</option>
														<option value="VE">Venezuela, Bolivarian Republic of</option>
														<option value="VN">Viet Nam</option>
														<option value="VG">Virgin Islands, British</option>
														<option value="VI">Virgin Islands, U.S.</option>
														<option value="WF">Wallis and Futuna</option>
														<option value="EH">Western Sahara</option>
														<option value="YE">Yemen</option>
														<option value="ZM">Zambia</option>
														<option value="ZW">Zimbabwe</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!--end: Form Wizard Step 3-->

							<!--begin: Form Wizard Step 4-->
							<div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
								<div class="kt-heading kt-heading--md">Votre abonnement</div>
								<div class="kt-form__section kt-form__section--first">
									<div class="kt-wizard-v4__review">
										<div class="kt-wizard-v4__review-item">
											<div class="kt-wizard-v4__review-title">
												Formule Basique
												<input type="radio" checked name="formule" value="basic" /> 
											</div>
											<div class="kt-wizard-v4__review-content">
												Contenu de la formule
											</div>
										</div>
										<div class="kt-wizard-v4__review-item">
											<div class="kt-wizard-v4__review-title">
												Formule Intermédiaire
												<input type="radio" name="formule" value="medium" /> 
											</div>
											<div class="kt-wizard-v4__review-content">
												Contenu de la formule
											</div>
										</div>
										<div class="kt-wizard-v4__review-item">
											<div class="kt-wizard-v4__review-title">
												Formule Avancée
												<input type="radio" name="formule" value="advanced" /> 
											</div>
											<div class="kt-wizard-v4__review-content">
												Contenu de la formule
											</div>
										</div>
									</div>
								</div>
							</div>

							<!--end: Form Wizard Step 4-->

							<!--begin: Form Actions -->
							<div class="kt-form__actions">
								<div class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">
									Précédent
								</div>
								<div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">
									Valider
								</div>
								<div class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" id="next" data-ktwizard-type="action-next">
									étape suivante
								</div>
							</div>

							<!--end: Form Actions -->
						</form>

						<!--end: Form Wizard Form-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End::Section-->
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/demo1/pages/custom/apps/user/add-do.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/input-mask.js') }}" type="text/javascript"></script>
@endsection