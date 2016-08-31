<?php

include ('DB/connections.php');
include ('bin/getters_ub.php');
include ('bin/setters_ub.php');
include ('bin/getters_user.php');

//Subscription Function
function subscribe($id_usr, $id_tor){
    if(get_tournament_players($id_tor) > check_part($id_tor)){
        $db= connect_urbangames();
        $db->query("LOCK TABLES iscrizione{write}");
        if(get_balance($id_usr) < get_tournament_credits($id_tor)){
            echo("Credito insufficente");
            $db->query("UNLOCK TABLES");
            return;
        }
        $query=$db->prepare("INSERT INTO iscrizione (id_usr, id_tor) VALUES (?, ?)");
        $query->execute(array($id_usr, $id_tor));
        $db->query("UNLOCK TABLES");
        $db_users= connect_users();
        $db_users->query("LOCK TABLES users{write}");
        $query=$db_users->prepare("UPDATE users SET balance = ? WHERE id = ?");
        $query->execute(array(get_balance($id_usr)-get_tournament_credits($id_tor), $id_usr));
        $db_users->query("UNLOCK TABLES");
        echo("Iscrizione effettuata");
        if(get_tournament_players($id_tor) <= check_part($id_tor)){
            if(get_tournament_players($id_tor) == 32){
                increment_tournament_state($id_tor);
                create_final_phase_32($id_tor);
                echo("creata fase ad eliminazione");
            }
            elseif(get_tournament_players($id_tor) == 64 || get_tournament_players($id_tor) == 128){
                increment_tournament_state($id_tor);
                create_groups_matches($id_tor);
                echo("creata fase a gironi");
            }
        }
    }
}

//Return the number of subscriptions for this tournament
function check_part($id_tor){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES iscrizione{read}");
    $query=$db->prepare("SELECT * FROM iscrizione WHERE id_tor = ?");
    $query->execute(array($id_tor));
    $db->query("UNLOCK TABLES");
    return $query->rowCount();
}

//Create groups matches for 16 groups
function create_groups_matches($id_tor){
    $db = connect_urbangames();
    $db->query("LOCK TABLES iscrizione{read}");
    $query= $db->prepare("SELECT id_usr FROM iscrizione WHERE id_tor = ?");
    $query->execute(array($id_tor));
    $users=$query->fetchAll();
    //now all subscricted users are in an array
    $users= mix($users);
    $part=  get_tournament_players($id_tor);
    if($part==64){
      $lenght=4;  
    }else{
        $lenght=8;
    }
    //creates groups
    for($j=65;$j<81;$j++){
       $name=chr($j);
       $query = $db->prepare("INSERT INTO gironi (id_tor,name,cat) VALUES (?,?,0)");
       $query->execute(array($id_tor,$name));        
    }
    //now all groups are created
    
    $inserted=0;
    $query2=$db->prepare("SELECT id FROM gironi WHERE id_tor = ? AND cat=0");
    $query2->execute(array($id_tor));
    while($row=$query2->fetch()){        
        $id_gir=$row['id'];
    	$db->query("LOCK TABLES classifica{write},matches{write}");        
            //creates tables for current group
        $array=array();
        //this array will contain the users of the current group        
        $end=$inserted+$lenght;
for($i=$inserted; $i< $end; $i++){
		$c=$users[$i]['id_usr'];
                $c=(int)$c;
	$query4=$db->prepare("INSERT INTO classifica (id_usr,pnt,win,tie,lose,gm,gs,gd,id_gir) VALUES (?,0,0,0,0,0,0,0,?)");
        $query4->execute(array($c,$id_gir));
        $array[]=$c;
 }
  //creates matches for current group
for($j=0;$j<$lenght;$j++){
 for($k=0;$k<$lenght;$k++){
		if($k!=$j){
         $h=$array[$j];
         $t=$array[$k];
         $query3=$db->prepare("INSERT INTO matches (id_usr1,id_usr2,id_gir,state) VALUES (?,?,?,0)");
         $query3->execute(array($h,$t,$id_gir));
		}
	}
}
$inserted=$inserted+$lenght; 
     $db->query("UNLOCK TABLES"); 
}
    $db->query("UNLOCK TABLES");
}

//random mix of generic array's elements
function mix($array){
    $players=count($array);
    for($q=0;$q<4000;$q++){
  $var=rand(0,($players-2));

//switches $array[$var],$array[$var+1]
    $temp=$array[$var];
    $array[$var]=$array[$var+1];
    $array[$var+1]=$temp;
 }
 return $array;
}

//Create final phases matches for 32 players
function create_final_phase_32($id_tor){
    $db = connect_urbangames();
    $db->query("LOCK TABLES iscrizione{read}");
    $query= $db->prepare("SELECT id_usr FROM iscrizione WHERE id_tor = ?");
    $query->execute(array($id_tor));
    $users=$query->fetchAll();
    $db->query("UNLOCK TABLES");
    $db->query("LOCK TABLES matches{write}");
    $users=mix($users);
    $sedicesimi= create_tab($id_tor);
    $index=0;
    $query=$db->prepare("SELECT id FROM matches WHERE id_gir = ?");
    $query->execute(array($sedicesimi));
    while($row=$query->fetch()){
        $query1=$db->prepare("UPDATE matches SET id_usr1 = ?, id_usr2 = ?, state = 0 WHERE id = ?");
        $query1->execute([$users[$index]['id_usr'], $users[$index+1]['id_usr'], $row['id']]);
        $index+=2;
    }
}

//Create final phases matches for 32 players when tournament has a group phase
function create_final_phase_p_g($id_tor){
    $db = connect_urbangames();
    $primi=array();
    $secondi=array();
    $db->query("LOCK TABLES classifica{read}, gironi{read}");
    $girone=$db->prepare("SELECT id FROM gironi WHERE id_tor = ? AND cat = 0");
    $girone->execute(array($id_tor));
    while($riga=$girone->fetch()){
    $query=$db->prepare("SELECT * FROM classifica WHERE id_gir = ? ORDER BY pnt DESC, gd DESC, gm DESC");
    $query->execute(array($riga['id']));
    $primi[]=$query->fetch();
    $secondi[]=$query->fetch();
    }
    $db->query("UNLOCK TABLES");
    $db->query("LOCK TABLES matches{write}");
    $sedicesimi= create_tab($id_tor);
    $primi=mix($primi);
    $secondi=mix($secondi);
    $query=$db->prepare("SELECT id FROM matches WHERE id_gir = ?");
    $query->execute(array($sedicesimi));
    $index=0;
    while($row=$query->fetch()){
        $query1=$db->prepare("UPDATE matches SET id_usr1 = ?, id_usr2 = ?, state = 0 WHERE id = ?");
        $query1->execute([$primi[$index]['id_usr'], $secondi[$index]['id_usr'], $row['id']]);
        $index++;
    }
}

//Create tab for the final phase
function create_tab($id_tor){
    $db=  connect_urbangames();
    $gironi=array();
    $db->query("LOCK TABLES gironi{write}");
    $query=$db->prepare("INSERT INTO gironi (id_tor, name, cat) VALUES (?, 'FINALE', 1)");
    $query->execute(array($id_tor));
    $gironi[]=$db->lastInsertId();
    $query=$db->prepare("INSERT INTO gironi (id_tor, name, cat) VALUES (?, 'SEMIFINALE', 1)");
    $query->execute(array($id_tor));
    $gironi[]=$db->lastInsertId();
    $query=$db->prepare("INSERT INTO gironi (id_tor, name, cat) VALUES (?, 'QUARTI DI FINALE', 1)");
    $query->execute(array($id_tor));
    $gironi[]=$db->lastInsertId();
    $query=$db->prepare("INSERT INTO gironi (id_tor, name, cat) VALUES (?, 'OTTAVI DI FINALE', 1)");
    $query->execute(array($id_tor));
    $gironi[]=$db->lastInsertId();
    $query=$db->prepare("INSERT INTO gironi (id_tor, name, cat) VALUES (?, 'SEDICESIMI DI FINALE', 1)");
    $query->execute(array($id_tor));
    $gironi[]=$db->lastInsertId();
    $db->query("LOCK TABLES matches{write}");
    $query=$db->prepare("INSERT INTO matches (id_gir, next) VALUES (?, 0)");
    $query->execute(array($gironi[0]));
    $id_finale=$db->lastInsertId();
    $db->query("UNLOCK TABLES");
    $array=  create_prev_matches($gironi[1], $id_finale);
    $quarti1=  create_prev_matches($gironi[2], $array[0]);
    $quarti2=  create_prev_matches($gironi[2], $array[1]);
    $ottavi1=  create_prev_matches($gironi[3], $quarti1[0]);
    $ottavi2=  create_prev_matches($gironi[3], $quarti1[1]);
    $ottavi3=  create_prev_matches($gironi[3], $quarti2[0]);
    $ottavi4=  create_prev_matches($gironi[3], $quarti2[1]);
    $sed1=  create_prev_matches($gironi[4], $ottavi1[0]);
    $sed2=  create_prev_matches($gironi[4], $ottavi1[1]);
    $sed3=  create_prev_matches($gironi[4], $ottavi2[0]);
    $sed4=  create_prev_matches($gironi[4], $ottavi2[1]);
    $sed5=  create_prev_matches($gironi[4], $ottavi3[0]);
    $sed6=  create_prev_matches($gironi[4], $ottavi3[1]);
    $sed7=  create_prev_matches($gironi[4], $ottavi4[0]);
    $sed8=  create_prev_matches($gironi[4], $ottavi4[1]);
    return $gironi[4];
}

//Create previous matches of the current match
function create_prev_matches($id_gir, $id_match){
    $db= connect_urbangames();
    $db->query("LOCK TABLES matches{write}");
    $array=array();
    $query=$db->prepare("INSERT INTO matches (id_gir, next) VALUES (?, ?)");
    $query->execute(array($id_gir, $id_match));
    $array[]=$db->lastInsertId();
    $query=$db->prepare("INSERT INTO matches (id_gir, next) VALUES (?, ?)");
    $query->execute(array($id_gir, $id_match));
    $array[]=$db->lastInsertId();
    $db->query("UNLOCK TABLES");
    return $array;
}

//Refuse score of the match
function refuse_score($id, $id_usr){
    if(get_match_state($id)==1 && (get_admin($id_usr) == 1 || get_match_id_usr2($id) == $id_usr)){
        $db=  connect_urbangames();
        $db->query("LOCK TABLES matches{write}");
        $query=$db->prepare("UPDATE matches SET g1 = null, g2 = null, state = 0 WHERE id = ?");
        $query->execute(array($id));
        $db->query("UNLOCK TABLES");
    }
    else{
        echo ("Operazione non consentita");
    }
}

//Insert score for the match. It must be confirmed
function insert_score($id, $g1, $g2, $id_usr){
    if(get_match_state($id)==0 && (get_admin($id_usr) == 1 || get_match_id_usr1($id) == $id_usr)){
        $db=  connect_urbangames();
        $g1=(int)$g1;
        $g2=(int)$g2;
        $id=(int)$id;
        $db->query("LOCK TABLES matches{write}");
        $query=$db->prepare("UPDATE matches SET g1 = ?, g2 = ?, state = 1 WHERE id = ?");
        $query->execute(array($g1, $g2, $id));
        $db->query("UNLOCK TABLES");
    }
    else{
        echo ("Operazione non consentita");
    }
}

//Update tables, if all of groups matches are played, step to the next phase
function confirm_score($id, $id_usr){
    if(get_match_state($id)==1 && (get_admin($id_usr) == 1 || get_match_id_usr2($id) == $id_usr)){
        update_tables($id);
        $db->query("LOCK TABLES matches{write}");
        $query=$db->prepare("UPDATE matches SET state = 2 WHERE id = ?");
        $query->execute(array($id));
        $db->query("UNLOCK TABLES");
        if(check_groups_end(get_tournament_match_ub($id))){
            create_final_phase_p_g(get_tournament_match_ub($id));
        }
    }
    else{
        echo ("Operazione non consentita");
    }
}

//Check if groups are played
function check_groups_end($id){
    $db=  connect_urbangames();
    $total = 0;
    $db->query("LOCK TABLES matches{read}, gironi{read}");
    $query1=$db->prepare("SELECT id FROM gironi WHERE id_tor = ?");
    $query1->execute(array($id));
    while($row=$query1->fetch()){
        $query=$db->prepare("SELECT * FROM matches WHERE state < 2 AND id_gir = ?");
        $query->execute(array($row['id']));
        $total += $query->rowCount();
    }
    $db->query("UNLOCK TABLES");
    if($total == 0){
        return 1;
    }
    else{
        return 0;
    }
}

//Update tables after confirm input match
function update_tables($id){
    if(get_match_state($id) == 1){
    if(get_match_g1($id) >  get_match_g2($id))$ris=1;
    elseif(get_match_g1($id) == get_match_g2($id))$ris=0;
    else $ris=2;
    $db=  connect_urbangames();
    $db->query("LOCK TABLES matches{read}, classifica{write}");
    $id_gir=  get_match_group($id);
    $usr1 = get_match_id_usr1($id);
    $usr2 = get_match_id_usr2($id);
    $g1=  get_match_g1($id);
    $g2= get_match_g2($id);
    $query = $db->prepare("UPDATE classifica SET gm=gm+?, gd=gd+?, gs=gs+?, gd=gd-? WHERE id_usr = ? AND id_gir = ?");
    $query->execute(array($g1, $g1, $g2, $g2, $usr1, $id_gir));
    $query->execute(array($g2, $g2, $g1, $g1, $usr2, $id_gir));
    
   switch($ris){
   case 0:
       $query=$db->prepare("UPDATE classifica SET tie=tie+1 , pnt=pnt+1 WHERE (id_usr = ? OR id_usr = ?) AND id_gir = ?");
       $query->execute(array($usr1, $usr2, $id_gir));
       break;
   case 1:
       $query=$db->prepare("UPDATE classifica SET win=win+1, pnt=pnt+3 WHERE id_usr = ? AND id_gir = ?");
       $query2=$db->prepare("UPDATE classifica SET lose=lose+1 WHERE id_usr = ? AND id_gir = ?");
       $query->execute(array($usr1, $id_gir));
       $query2->execute(array($usr2, $id_gir));
       break;
   case 2:
       $query=$db->prepare("UPDATE classifica SET win=win+1, pnt=pnt+3 WHERE id_usr = ? AND id_gir = ?");
       $query2=$db->prepare("UPDATE classifica SET lose=lose+1 WHERE id_usr = ? AND id_gir = ?");
       $query->execute(array($usr2, $id_gir));
       $query2->execute(array($usr1, $id_gir));
       break;
   default:
       break;
   
   }
   $db->query("UNLOCK TABLES");
   }
}

//Confirm result(final phase)
function confirm_score_final_phase($id_part, $id_usr){
    if(get_match_state($id_part)==1 && (get_admin($id_usr) == 1 || get_match_id_usr2($id_part) == $id_usr)){
        $db=  connect_urbangames();
        $db->query("LOCK TABLES matches{write}");
        $query=$db->prepare("UPDATE matches SET state = 2 WHERE id = ?");
        $query->execute(array($id_part));
        if(get_match_next($id_part) == 0){
            end_tournament(get_tournament_match_ub($id_part));
        }
        else{
            if(get_match_id_usr1(get_match_next($id_part)) == NULL){
                set_match_id_usr1(get_match_winner($id_part), get_match_next($id_part));
            }
            else{
                set_match_id_usr2(get_match_winner($id_part), get_match_next($id_part));
            }
        }
        $db->query("UNLOCK TABLES");
    }
    else{
        echo ("Operazione non consentita");
    }
}

function end_tournament($id_tor, $id_part, $credits){
    increment_tournament_state($id_tor);
    if(get_tournament_credits($id_tor) == 0){
        set_user_credits(get_match_winner($id_part), $credits);
    }
    else{
        send_mail(get_match_winner($id_part));
}
}

//Insert score for the match(final phase). It must be confirmed
function insert_score_fp($id, $g1, $g2, $id_usr){
    if(get_match_state($id)==0 && (get_admin($id_usr) == 1 || get_match_id_usr1($id) == $id_usr) && $g1 != $g2){
        $db=  connect_urbangames();
        $g1=(int)$g1;
        $g2=(int)$g2;
        $id=(int)$id;
        $db->query("LOCK TABLES matches{write}");
        $query=$db->prepare("UPDATE matches SET g1 = ?, g2 = ?, state = 1 WHERE id = ?");
        $query->execute(array($g1, $g2, $id));
        $db->query("UNLOCK TABLES");
    }
    else{
        if($g1 == $g2){
            echo ("Non sono consentiti pareggi!");
        }
        else{
        echo ("Operazione non consentita");
    }
    }
}

//Function for send Email
function send_mail($id){
        error_reporting(E_ALL);

// Genera un boundary
$mail_boundary = "=_NextPart_" . md5(uniqid(time()));
 
$to = get_mail($id);
$subject = "Testing e-mail";
$sender = "postmaster@urbangames.it";

 
$headers = "From: $sender\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: multipart/alternative;\n\tboundary=\"$mail_boundary\"\n";
$headers .= "X-Mailer: PHP " . phpversion();
 
// Corpi del messaggio nei due formati testo e HTML
$text_msg = "messaggio in formato testo";
$html_msg = "<b>messaggio</b> in formato <p><a href='http://www.aruba.it'>html</a><br><img src=\"http://hosting.aruba.it/image_top/top_01.gif\" border=\"0\"></p>";
 
// Costruisci il corpo del messaggio da inviare
$msg = "This is a multi-part message in MIME format.\n\n";
$msg .= "--$mail_boundary\n";
$msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
$msg .= "Content-Transfer-Encoding: 8bit\n\n";
$msg .= "Questa è una e-Mail di test inviata dal servizio Hosting di Aruba.it per la verifica del corretto funzionamento di PHP mail()function .

Aruba.it";  // aggiungi il messaggio in formato text
 
$msg .= "\n--$mail_boundary\n";
$msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
$msg .= "Content-Transfer-Encoding: 8bit\n\n";
$msg .= "Questa è una e-Mail di test inviata dal servizio Hosting di Aruba.it per la verifica del corretto funzionamento di PHP mail()function .

Aruba.it";  // aggiungi il messaggio in formato HTML
 
// Boundary di terminazione multipart/alternative
$msg .= "\n--$mail_boundary--\n";
 
// Imposta il Return-Path (funziona solo su hosting Windows)
ini_set("sendmail_from", $sender);
 
// Invia il messaggio, il quinto parametro "-f$sender" imposta il Return-Path su hosting Linux
if (mail($to, $subject, $msg, $headers, "-f$sender")) { 
    echo "Mail inviata correttamente !<br><br>Questo di seguito è il codice sorgente usato per l'invio della mail:<br><br>";
    highlight_file($_SERVER["SCRIPT_FILENAME"]);
    unlink($_SERVER["SCRIPT_FILENAME"]);
} else { 
    echo "<br><br>Recapito e-Mail fallito!";
}
}