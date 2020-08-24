@extends('layout.default')

@section('content')

    <div class="card card-custom">
        <div class="card-body">

           	<table class="table table-striped table-bordered table-hover table-checkable">
				<tr>
					<th># </th>
					<th>Libellé </th>
					<th>Date création</th>
					<th>Date modification</th>
					<th></th>
				</tr>
				
				@foreach ($elements as $element)
					<tr id="ligne_entite_{{ $element->id }}">
						<td style="width:100px;">{{ $element->id }}</td>
						<td style="width:200px;">{{ $element->libelle }}</td>
						<td style="width:90px;">{{ date('d/m/Y à H:i', strtotime($element->created_at)) }}</td>
						<td style="width:90px;">{{ date('d/m/Y à H:i', strtotime($element->updated_at)) }}</td>
						<td style="width:90px;" class="text-center" nowrap>
							<a href="/admin/unezone/{{ $element->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>
						</td>
					</tr>
				@endforeach
			</table>
        </div>

    </div>
	
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection