<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    //
	public function nomQui()
	{
		if($this->qui != NULL)
		{
			$initiateur = EquipierDo::find($this->qui);
			return $initiateur->nom;
		}
		else
			return "-";
	}
	
	public function info_validation()
	{
		if($this->validation <> 0)
		{
			$initiateur = EquipierDo::find($this->validation);
			return $initiateur->nom;
		}
		else
			return "-";
	}
	
	public function documents()
	{
		$documents = Justificatif::where('action', $this->id)->get();
		
		$links = '';
		
		foreach($documents as $document)
		{
			switch($document->extension)
			{
				case "pdf" :
					$links .= '<a href="/chantier/downloadJustificatif/'.$document->id.'" title="'.$document->libelle.'" target="_blank"><i class="fa fa-file-pdf fa-2x"></i></a>&nbsp;';
					break;
				case "mp4" :
					$links .= '<a href="/chantier/downloadJustificatif/'.$document->id.'" title="'.$document->libelle.'" target="_blank"><i class="fa fa-file-video fa-2x"></i></a>&nbsp;';
					break;
				case "jpg" :
				case "png" :
				case "gif" :
					$links .= '<a href="/chantier/downloadJustificatif/'.$document->id.'" title="'.$document->libelle.'" target="_blank"><i class="fa fa-file-image fa-2x"></i></a>&nbsp;';
					break;
				case "default" :
					$links .= '<a href="/chantier/downloadJustificatif/'.$document->id.'" title="'.$document->libelle.'" target="_blank"><i class="fa fa-file fa-2x"></i></a>&nbsp;';
					break;
			}	
		}
		
		echo $links;
	}
}
