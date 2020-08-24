<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div style="color:#49545f;text-align:center;">
		Titres d'habilitation		
	</div>
  	
	<table style="width:100%;">
		<tr>
			<td colspan="3" style="background-color:#6d97cc;height:30px;font-size:10px;padding:5px;"><b>Employeur (Agence d'intérim si intérimaire) :</b></td>
			<td colspan="3" style="background-color:#6d97cc;height:30px;font-size:10px;padding:5px;"><b>Profession de l'intervenant</b></td>
		</tr>
		<tr>
			<td colspan="3" style="background-color:#b8b7b7;height:30px;font-size:10px;padding:5px;">{{ $employeur->raisonSociale }}</td>
			<td colspan="3" style="background-color:#b8b7b7;height:30px;font-size:10px;padding:5px;">{{ $entite->fonction }}</td>
		</tr>
		<tr>
			<td colspan="3" style="background-color:#6d97cc;height:30px;font-size:10px;padding:5px;"><b>ENTREPRISE UTILISATRICE, (seulement si Intérimaire) :</b></td>
			<td colspan="3" style="background-color:#6d97cc;height:30px;font-size:10px;padding:5px;"></td>
		</tr>
		<tr>
			<td colspan="3" style="background-color:#b8b7b7;height:30px;font-size:10px;padding:5px;"></td>
			<td colspan="3" style="background-color:#b8b7b7;height:30px;font-size:10px;padding:5px;"></td>
		</tr>

		<tr>
			<td colspan="3" style="background-color:#6d97cc;height:30px;font-size:10px;padding:5px;"><b>NOM DE L’INTERVENANT :</b></td>
			<td colspan="3" style="background-color:#6d97cc;height:30px;font-size:10px;padding:5px;"><b>PRENOM DE L’INTERVENANT :</b></td>
		</tr>
		<tr>
			<td colspan="3" style="background-color:#b8b7b7;height:30px;font-size:10px;padding:5px;">{{ $entite->nom }}</td>
			<td colspan="3" style="background-color:#b8b7b7;height:30px;font-size:10px;padding:5px;">{{ $entite->prenom }}</td>
		</tr>
		
		<tr>
			<td colspan="3" style="background-color:#6d97cc;height:30px;font-size:10px;padding:5px;"><b>HABILITATIONS ELECTRIQUES</b></td>
			<td colspan="3" style="background-color:#6d97cc;height:30px;font-size:10px;padding:5px;"><b>HABILITATIONS MECANIQUES</b></td>
		</tr>
		<tr>
			<td colspan="6" style="background-color:#fff;text-align:center;color:red;">NB : Toute case non remplie devra être barrée</td>
		</tr>
		<tr>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;width:20%;"><b>NIVEAU D'HABILITATION</b></td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;width:15%;"><b>DELIVREES LE</b></td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;width:15%;"><b>VALABLES JUSQU’AU</b></td>
			
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;width:20%;"><b>NIVEAU D'HABILITATION</b></td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;width:15%;"><b>DELIVREES LE</b></td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;width:15%;"><b>VALABLES JUSQU’AU</b></td>
		</tr>
		<tr>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;">HO BO</td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
			
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;">MO</td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
		</tr>
		<tr>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;">H1 B1 BE B1V BS MANOEUVRE</td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
			
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;">M1</td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
		</tr>
		<tr>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;">H2 HE B2 BR B2V BE<br>MESURAGE/VERIFICATION/<br>ESSAI</td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
			
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;">M2</td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
			<td style="background-color:#b8b7b7;height:30px;font-size:10px;font-size:10px;padding:5px;"></td>
		</tr>
		<tr>
			<td colspan="6" style="background-color:#fff;text-align:center;color:red;">* Minimum obligatoire pour travailler</td>
		</tr>
		<tr>
			<td colspan="3" style="background-color:#6d97cc;height:30px;font-size:10px;padding:5px;"><b>Signature de l'intervenant</b></td>
			<td colspan="3" style="background-color:#6d97cc;height:30px;font-size:10px;padding:5px;"><b>Cachet + Signature<br>(Employeur ou Entreprise utilisatrice si Intérimaire)</b></td>
		</tr>
		<tr>
			<td colspan="3" style="background-color:#b8b7b7;height:70px;font-size:10px;padding:5px;"></td>
			<td colspan="3" style="background-color:#b8b7b7;height:70px;font-size:10px;padding:5px;"></td>
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