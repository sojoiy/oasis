<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div style="color:#49545f;">
		Intervenant
		<sapn style="font-size:10px;font-style:italic;"></span>
	</div>
  	
	<table style="width:100%;">
		<tr>
			<td style="background-color:#6d97cc;">Civilité :</td>
			<td style="background-color:#b8b7b7;">{{ $entite->civilite }}</td>
			
			<td style="background-color:#6d97cc;">Fonction :</td>
			<td style="background-color:#b8b7b7;">{{ $entite->fonction }}</td>
		</tr>
		<tr>
			<td style="background-color:#6d97cc;">Nom :</td>
			<td style="background-color:#b8b7b7;">{{ $entite->nom }}</td>
			
			<td style="background-color:#6d97cc;">Prénom :</td>
			<td style="background-color:#b8b7b7;">{{ $entite->prenom }}</td>
		</tr>
		<tr>
			<td style="background-color:#6d97cc;">Date de naissance :</td>
			<td style="background-color:#b8b7b7;">{{ $entite->date_naissance }}</td>
			
			<td style="background-color:#6d97cc;">Lieu de naissance :</td>
			<td style="background-color:#b8b7b7;">{{ $entite->lieu_naissance }}</td>
		</tr> 
		<tr>
			<td style="background-color:#6d97cc;">Nationalité :</td>
			<td style="background-color:#b8b7b7;">{{ $entite->nationalite }}</td>
			
			<td style="background-color:#6d97cc;">Adresse :</td>
			<td style="background-color:#b8b7b7;">{{ $entite->adresse }}</td>
		</tr>
	</table>
	
	<br>
    <div style="color:#49545f;">
		Informations chantier
		<sapn style="font-size:10px;font-style:italic;"></span>
	</div>
  	<table style="width:100%;">
		<tr>
			<td style="background-color:#6d97cc;">N° chantier :</td>
			<td style="background-color:#b8b7b7;">{{ $chantier->numero }}</td>
			
			<td style="background-color:#6d97cc;">Intitulé chantier :</td>
			<td style="background-color:#b8b7b7;">{{ $chantier->libelle }}</td>
		</tr>
		<tr>
			<td style="background-color:#6d97cc;">Date début :</td>
			<td style="background-color:#b8b7b7;">{{ $chantier->date_debut }}</td>
			
			<td style="background-color:#6d97cc;">Date fin :</td>
			<td style="background-color:#b8b7b7;">{{ $chantier->date_fin }}</td>
		</tr>

		<tr>
			<td style="background-color:#6d97cc;">Titulaire du marché :</td>
			<td style="background-color:#b8b7b7;"></td>
		</tr>
		<tr>
			<td style="background-color:#6d97cc;">Co-titulaire marché :</td>
			<td style="background-color:#b8b7b7;"></td>
		</tr>
		<tr>
			<td style="background-color:#6d97cc;">Co-titulaire marché :</td>
			<td style="background-color:#b8b7b7;"></td>
		</tr>
		<tr>
			<td style="background-color:#6d97cc;">Titulaire du compte tiers :</td>
			<td style="background-color:#b8b7b7;"></td>
		</tr>
	</table>
	
	<br>
    <div style="color:#49545f;">
		Information Employeur
		<sapn style="font-size:10px;font-style:italic;"></span>
	</div>
  	<table style="width:100%;">
		<tr>
			<td style="background-color:#6d97cc;">Rang :</td>
			<td style="background-color:#b8b7b7;">{{ $chantier->numero }}</td>
			
			<td style="background-color:#6d97cc;">Raison sociale :</td>
			<td style="background-color:#b8b7b7;">{{ $employeur->raisonSociale }}</td>
		</tr>
		<tr>
			<td style="background-color:#6d97cc;">Date début :</td>
			<td style="background-color:#b8b7b7;">{{ $chantier->date_debut }}</td>
			
			<td style="background-color:#6d97cc;">Date fin :</td>
			<td style="background-color:#b8b7b7;">{{ $chantier->date_fin }}</td>
		</tr>

		<tr>
			<td style="background-color:#6d97cc;">Titulaire du marché :</td>
			<td style="background-color:#b8b7b7;"></td>
		</tr>
		<tr>
			<td style="background-color:#6d97cc;">Co-titulaire marché :</td>
			<td style="background-color:#b8b7b7;"></td>
		</tr>
		<tr>
			<td style="background-color:#6d97cc;">Co-titulaire marché :</td>
			<td style="background-color:#b8b7b7;"></td>
		</tr>
		<tr>
			<td style="background-color:#6d97cc;">Titulaire du compte tiers :</td>
			<td style="background-color:#b8b7b7;"></td>
		</tr>
	</table>
	
	<!--
	          	<table>
					<tr>
						<td><b>Information Employeur</b></td>
					</tr>
					<tr>
						<td>Rang : ST1</td>
					</tr>
					<tr>
						<td>Nom : {{ $employeur->raisonSociale }}</td>
					</tr>
					<tr>
						<td>Dirigeant : {{ $employeur->prenomDirecteur }} {{ $employeur->nomDirecteur }}</td>
					</tr>
					<tr>
						<td>Adresse : </td>
						<td>KBis</td>
					</tr>
					<tr>
						<td>Téléphone : {{ $employeur->telephone }}</td>
						<td>Vigilance</td>
					</tr>
					<tr>
						<td>Contact :</td>
					</tr>
				</table>
        	</td>
        	<td style="border:solid 1px #000;width:50%;">
	          	<table>
					<tr>
						<td><b>Information Société Utilisatrice</b></td>
					</tr>
					<tr>
						<td>Mandatée par  : ...</td>
					</tr>
					<tr>
						<td>Nom : </td>
					</tr>
					<tr>
						<td>Dirigeant :</td>
					</tr>
					<tr>
						<td>Adresse : </td>
						<td>KBis</td>
					</tr>
					<tr>
						<td>Téléphone :</td>
						<td>Vigilance</td>
					</tr>
					<tr>
						<td>Contact :</td>
					</tr>
				</table>
        	</td>
      	</tr>
		
      	<tr>
        	<td style="border:solid 1px #000;" colspan="2">
	          	<table>
					<tr>
						<td><b>Signature et visa Intervenant et Employeur</b></td>
					</tr>
					<tr>
						<td>Intervenant : </td>
						<td>Employeur : </td>
					</tr>
					<tr>
						<td>Date : </td>
						<td>Date : </td>
					</tr>
				</table>
        	</td>
      	</tr>
		
      	<tr>
        	<td style="border:solid 1px #000;" colspan="2">
	          	<table>
					<tr>
						<td><b>Donneur d'ordre</b></td>
					</tr>
					<tr>
						<td>Accès standard : </td>
						<td>Zones : </td>
						<td>Date début : </td>
					</tr>
					<tr>
						<td>Accès spécifique : </td>
						<td>Zones : </td>
						<td>Date début : </td>
					</tr>
					<tr>
						<td>Signataire 1 : </td>
						<td>Signataire 2 : </td>
						<td>Signataire 3 : </td>
					</tr>
					<tr>
						<td>Accueil en date du : </td>
						<td>Fait par : </td>
						<td>Fonction : </td>
					</tr>
					<tr>
						<td>N°badge : </td>
						<td>Délivré le : </td>
						<td>Restitué le : </td>
					</tr>
				</table>
        	</td>
      	</tr>
    </table> -->
  </body>
</html>