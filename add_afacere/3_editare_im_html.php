<div id="editare_im" class="div_step hide">
<form enctype="application/x-www-form-urlencoded" id="forma_editare_im">

<h2 class="ui dividing header">
                        Descrierea afacerii </h2>
            <input type='hidden' name='editare_im' id='editare_im' value='<?php echo $editare_im['idv']; ?>'>
			<?php
			textarea_rolem('istoric',"Istoricul afacerii, proprietatea și structura",$editare_im['istoric'],'');
			textarea_rolem('prezentare_vanzari',"Prezentare generală a vânzărilor și a câștigurilor ",$editare_im['prezentare_vanzari'],'');
			textarea_rolem('prezentare_tendinte',"Prezentare generală a tendinței de dezvoltare a produsului / serviciului ",$editare_im['prezentare_tendinte'],'');
			textarea_rolem('avantaje',"Avantaje și atribute cheie",$editare_im['avantaje'],'');
			textarea_rolem('motivul_vanzarii',"Motivul vânzării",$editare_im['motivul_vanzarii'],'');
			?>
			<h2 class="ui dividing header">
            Viziune, Strategie <span style="font-size: 12px">(daca nu exista Business Plan)</span>
            </h2>
			<?php
			textarea_rolem('misiune',"Misiune",$editare_im['misiune'],'');
			textarea_rolem('obiective',"Obiective",$editare_im['obiective'],'');
			textarea_rolem('strategie',"Strategie",$editare_im['strategie'],'');
			?>
			<h2 class="ui dividing header">
           Locație
            </h2>
			<?php
			textarea_rolem('adresa',"Poziție geografică și adresa. Vecinatatile locatiei.",$editare_im['adresa'],'');
			textarea_rolem('descriere_cladire',"Descrierea clădirii, spatiului, terenului, etc (includeți dacă succesul afacerii se bazează pe locație)",$editare_im['descriere_cladire'],'');
			textarea_rolem('informatii_inchiriere',"Informațiile de închiriere sau despre valoarea imobiliara daca cladirea este in propietate",$editare_im['informatii_inchiriere'],'');
			?>
			<h2 class="ui dividing header">
           Operațiuni
            </h2>
			<?php
			textarea_rolem('ore_functionare',"Ore de funcționare și informații sezoniere",$editare_im['ore_functionare'],'');
			textarea_rolem('echipamente',"Echipamente și mobilier major",$editare_im['echipamente'],'');
			textarea_rolem('materii_prime',"Inventar materii prime, finite",$editare_im['materii_prime'],'');
			textarea_rolem('procese_productie',"Procese de producție sau de lucru (includeți dacă producția sau distribuția este a un atribut unic)",$editare_im['procese_productie'],'');
			textarea_rolem('organigrama',"Prezentarea generală a personalului, organigrama, informații privind politicile de personal",$editare_im['organigrama'],'');
			textarea_rolem('tendinte_fm',"Tendințele și problemele forței de muncă",$editare_im['tendinte_fm'],'');
			?>
			<h2 class="ui dividing header">
           Produs sau serviciu
            </h2>
			<?php
			textarea_rolem('descriere_produs',"Descrierea produsului sau serviciului",$editare_im['descriere_produs'],'');
			textarea_rolem('descriere_brand',"Descrierea Brand-ului. Daca este recunoscut in zona/industrie",$editare_im['descriere_brand'],'');
			textarea_rolem('vanzari',"Vânzări, tendințe de creștere și proiecții",$editare_im['vanzari'],'');
			textarea_rolem('oportunitati_produs',"Oportunități de produs / servicii (includeți dacă afacerea se confruntă cu o creștere bună de oportunități)",$editare_im['oportunitati_produs'],'');
			?>
			<h2 class="ui dividing header">
           Mediul de piață
            </h2>
			<?php
			textarea_rolem('informatii_industrie',"Informații privind industria, inclusiv tendințele de cerere și de creștere (includeți dacă creșterea industriei este buna; sau dacă industria se confruntă cu provocări pe care dvs. sau afacerea este pregătită să le adreseze)",$editare_im['informatii_industrie'],'');
			textarea_rolem('descriere_piata',"Descrierea geografică a pieței și tendințele de creștere (dacă servește afacerea o arie geografică specifică)",$editare_im['descriere_piata'],'');
			textarea_rolem('politica_pret',"Politica prețurilor și a vânzărilor",$editare_im['politica_pret'],'');
			textarea_rolem('clienti_loiali',"Clienți loiali, profilul acestora",$editare_im['clienti_loiali'],'');
			textarea_rolem('abordare_marketing',"	Descrierea abordării de marketing, modelele de achiziție a clienților noi",$editare_im['abordare_marketing'],'');
			textarea_rolem('materiale_marketing',"Materiale de marketing (includeți dacă materialele de marketing reprezintă afacerea bine)",$editare_im['materiale_marketing'],'');
			textarea_rolem('articole',"Articole, filmări, studii ale produsului/serviciului, review-uri",$editare_im['articole'],'');
			textarea_rolem('concurenta',"Concurența, inclusiv concurenții majori și tendințele competitive ",$editare_im['concurenta'],'');
			textarea_rolem('analiza_swot',"Analiza SWOT",$editare_im['analiza_swot'],'');
			?>
			<h2 class="ui dividing header">
			Planuri și proiecții viitoare 
            </h2>
			<?php
			textarea_rolem('obiective_dezvoltare',"Obiective și planuri de dezvoltare pe termen scurt ale afacerii",$editare_im['obiective_dezvoltare'],'');
			textarea_rolem('slabiciuni',"Slăbiciuni sau oportunități care nu au fost încă abordate",$editare_im['slabiciuni'],'');
			textarea_rolem('potential_extindere',"Potențial de extindere a pieței și planuri de dezvoltare",$editare_im['potential_extindere'],'');
			?>
			<h2 class="ui dividing header">
			Informații financiare
            </h2>
			<?php
			textarea_rolem('venituri_recente',"Rezumatul veniturilor recente, pe ultimii 2, 3 ani",$editare_im['venituri_recente'],'');
			textarea_rolem('pl',"P&L",$editare_im['pl'],'');
			?>
			<h2 class="ui dividing header">
			Prețul si posibila finanțare
            </h2>
			<?php
			textarea_rolem('pret_solicitat',"Prețul solicitat",$editare_im['pret_solicitat'],'');
			textarea_rolem('continului_vanzarii',"Conținutul vânzării",$editare_im['continului_vanzarii'],'');
			textarea_rolem('informatii_termeni',"Informații privind termenii",$editare_im['informatii_termeni'],'');
			textarea_rolem('calificari_necesare',"Calificările necesare cumpărătorului",$editare_im['calificari_necesare'],'');
			textarea_rolem('plan_tranzitie',"Planul de tranziție al vânzătorului: acordul de neconcurentă si perioada de training",$editare_im['plan_tranzitie'],'');
			?>
			<h2 class="ui dividing header">
			Altele
            </h2>
			<?php
			textarea_rolem('fotografii_locatie',"Fotografii ale locației, echipamentelor, etc",$editare_im['fotografii_locatie'],'');
			textarea_rolem('anexe',"Anexe cu liste, rapoarte, contracte, etc (vezi Checklist)",$editare_im['anexe'],'');
			textarea_rolem('altele',"Altele: Specificat",$editare_im['altele'],'');

			?>

</form>
</div>