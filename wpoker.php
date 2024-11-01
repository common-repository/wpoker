<?php
/*
Plugin Name: WPoker
Plugin URI: http://www.wpoker.me/wpoker/
Description: a plugin for Poker webmaster, all poker features in ONE !
Version: 0.1
Author: Lipaonline
Author URI: http://poker-blog.lipaonline.com/

$Revision$

*/



function parse_poker($text) {
	$content2="";
	$lignes = explode("\n",$text);
	for($i=0;$i<count($lignes);$i++){
		$ligne = $lignes[$i];
		$ligne = trans_cards($ligne);
		$ligne = render_card($ligne);
		$content2.=$ligne;
	}
	return $content2;
}

function trans_cards($texte){
	$return = $texte;
	$pos = strpos($texte, "[");
	while($pos<>false){
		$debut = $pos;
		$fin = strpos($texte,"]",$pos);
		$chaine = substr($texte,$debut+1,$fin-$debut-1);
		$chaine_ori = substr($texte,$debut,$fin-$debut+1);
		$split = explode(" ",trim($chaine));
		$occ = "";
		for($i=0;$i<count($split);$i++){
			$occ.="[".trim($split[$i])."]";
		}
		$return = str_replace($chaine_ori,$occ,$return);
		$pos = strpos($texte, "[",$fin+1);
	}

	return $return;
}

function render_card($texte){




	$motif ='`\[([xakqjtXAKQJT2-9]|10)([xscdhXDSCH])\]`e';

 $chaine = "'<IMG SRC=\"".WP_PLUGIN_URL."/wpoker/images/cards/'.(strtoupper($1)).(strtolower($2)).'.gif\" alt=\"$1$2\" border=\"0\">'";

   
	$chain  = preg_replace($motif,$chaine,$texte);

	$motif='`\[\:([akqjtAKQJT2-9]|10)([xscdhDSCH])\]`';
	$chaine = "[$1$2]";
	$chain  = preg_replace($motif,$chaine,$chain);

	return $chain;
}

add_filter('the_content',parse_poker);
add_filter('the_excerpt', parse_poker);
add_filter('comment_text', parse_poker);

?>