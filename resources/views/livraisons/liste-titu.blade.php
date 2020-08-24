@foreach($transporteurs as $titulaire)

	<li role="treeitem" data-jstree="{ &quot;opened&quot; : true }" aria-selected="false" aria-level="2" aria-labelledby="j2_{{$titulaire->id}}_anchor" aria-expanded="true" id="j2_{{$titulaire->id}}" class="jstree-node  jstree-open">
		<i class="jstree-icon jstree-ocl" role="presentation"></i>
		<a data-toggle="modal" data-target="#kt_modal_{{ $titulaire->id }}" class="jstree-anchor" href="#" tabindex="-1" id="j2_{{$titulaire->id}}_anchor">
			<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
			{{ $titulaire->raisonSociale() }} {{ ($titulaire->societe == $livraison->societe) ? '(P)' : '' }} 
		</a>
	</li>
@endforeach