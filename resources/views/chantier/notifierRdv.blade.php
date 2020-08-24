<div class="alert-icon"><i class="fa fa-check text-success"></i></div>
<div class="alert-text">
 	Le RDV pour <strong>{{ $equipier->name() }}</strong> est demandé pour le <strong>{{ date("d/m/Y à H:i", strtotime($creneau->date_debut)) }}</strong>.
</div>