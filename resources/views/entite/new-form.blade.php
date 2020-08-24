<div class="form-group">
	<label>Identifiant : *</label>
	<input type="text" name="name" required class="form-control" placeholder="Identifiant">
</div>

@foreach($lesChamps as $key => $unChamp)
@if($unChamp->name != "")
	<div class="form-group">
		<label> {{ $unChamp->name }} :</label>
		@switch($unChamp->type)
		    @case("texte")
				<input type="text" name="{{ $key }}" value="" class="form-control" placeholder="">
			@break
		    @case("email")
				<input type="email" name="{{ $key }}" value="" class="form-control" placeholder="adresse@exemple.com">
			@break
		    @case("date")
				<input type="date" name="{{ $key }}" value="" class="form-control" placeholder="" id="example-date-input">
			@break
		@endswitch	
	</div>
@endif
@endforeach