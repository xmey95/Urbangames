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
    $users= mix($users, count($users));
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
function mix($array,$players){
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
    $users=mix($users, 32);
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
    $primi=mix($primi, 16);
    $secondi=mix($secondi, 16);
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