<?php


error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);


class AgenteWeb{

  private $SO        = "";
  private $navegador = "";
  private $agente    = "";
  
  

public  function reconocedorSistemaOperativo($Agente){
	if      (ereg("Windows NT 5.1",  $Agente)) $sistemaOperativo = "Windows XP";
	elseif  (ereg("Windows NT 5.0",  $Agente)) $sistemaOperativo = "Windows 2000";
	elseif  (ereg("Win98     ",      $Agente)) $sistemaOperativo = "Windows 98";
	elseif  (ereg("Win",             $Agente)) $sistemaOperativo = "Windows ??";
	elseif  ( (ereg("Mac",           $Agente)) || (ereg("PPC", $Agente))) $sistemaOperativo = "Macintosh";
	elseif  (ereg("Debian",          $Agente)) $sistemaOperativo = "Debian";
	elseif  (ereg("Linux",           $Agente)) $sistemaOperativo = "Linux";
	elseif  (ereg("FreeBSD",         $Agente)) $sistemaOperativo = "FreeBSD";
	elseif  (ereg("SunOS",           $Agente)) $sistemaOperativo = "SunOS";
	elseif  (ereg("IRIX",            $Agente)) $sistemaOperativo = "IRIX";
	elseif  (ereg("BeOS",            $Agente)) $sistemaOperativo = "BeOS";
	elseif  (ereg("OS/2",            $Agente)) $sistemaOperativo = "OS/2";
	elseif  (ereg("AIX",             $Agente)) $sistemaOperativo = "AIX";
	else   $sistemaOperativo = "Desconocido";

	return $sistemaOperativo;
}




public  function reconocedorNavegador($agente){
//primero tenemos k conocer si se trata de opera!!! ya k el identificador se puede trucar...(OPERA CAN BE spoofed as MSIE 6)
// si no te lo crees miralo pone MSIE BLABLA Opera ...
	if    (eregi("Opera( )*(/){0,1}([0-9]+)(\.([0-9])+)*",            $agente,$browser)); // son validos Opera/7.54 Opera/8 Opera/7.23 Opera 6.2
	elseif(eregi("Netscape([0-9]*)( )*(/){0,1}([0-9]+)(\.([0-9])+)*", $agente,$browser)); //son validos Netscape/7.02  Netscape6/6.2.1
	elseif(eregi("MSIE ([0-9]+)(\.([0-9])+)*",                        $agente,$browser)); //son validos MSIE 6.0 MSIE 5.0  MSIE 5.5
	elseif(eregi("Lynx",                                              $agente,$browser));
	elseif(eregi("WebTV",                                             $agente,$browser));
	elseif(eregi("Galeon/([0-9]+)(\.([0-9])+)*",                      $agente,$browser)); //Galeon/2.2.2
	elseif(eregi("Konqueror/([0-9]+)(\.([0-9])+)*",                   $agente,$browser)); //konqueror/2.2.2 konqueror/3.1
	elseif(eregi("Firefox( )*(/){0,1}([0-9]+)(\.([0-9])+)*",          $agente,$browser)); //Firefox/0.9 Firefox/0.10.1
    elseif(eregi("Iceweasel( )*(/){0,1}([0-9]+)(\.([0-9])+)*",        $agente,$browser)); //IceWeasel/0.9 Firefox/0.10.1
	elseif(eregi("Firebird( )*(/){0,1}([0-9]+)(\.([0-9])+)*",         $agente,$browser)); //Firebird/0.7 Firebird/0.10.1
	elseif(eregi("Safari",                                            $agente,$browser)); //Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/125.4 (KHTML, like Gecko) Safari/125.9
	elseif ((eregi("Gecko",  $agente))
      	||(eregi("X11",    $agente))
      	||(eregi("Mozilla",$agente))
      	||(eregi("U",      $agente)))                               $nombre[0] = "Mozilla";
	elseif(eregi("WAP",                                               $agente,$browser));
	else $nombre[0]="Otro";

      eregi("([a-z]+)",                         $browser[0],$nombre); //conseguimos el nombre
      eregi("([0-9]+)(\.([0-9])+)*",            $browser[0],$version); //conseguimos la version
   $navegador="${nombre[0]} ${version[0]}"; //separamos el nombre y la version por un espacio

return $navegador;
}



public function reconocerRobot($agente){
	if     (ereg("Google",  $agente)) $robot = "Google"; //Googlebot/2.1 (+http://www.google.com/bot.html)
	elseif (ereg("Yahoo",   $agente)) $robot = "Yahoo"; //Mozilla/5.0 (compatible; Yahoo! Slurp; http://www.webmasterworld.com/red.cgi?f=21&d=8530&url=http://help.yahoo.com/help/us/ysearch/slurp)
	elseif (ereg("msnbot",  $agente)) $robot = "MSN"; //msnbot/0.11 (+http://search.msn.com/msnbot.htm)
	elseif (ereg("Scooter", $agente)) $robot = "Bot"; // ? no se k robot es
	elseif (ereg("Spider",  $agente)) $robot = "Bot"; // ? no se k robot es
	elseif (ereg("Infoseek",$agente)) $robot = "Bot"; // ? no se k robot es
	elseif (ereg("Slurp",   $agente)) $robot = "Bot"; // ? no se k robot es
	elseif (ereg("bot",     $agente)) $robot = "Bot"; // ? no se k robot es
	else  $robot="Otro";

return $robot;
}



    public function getSO(){
         return   $this->SO;
    }
    public function getNavegador(){
         return   $this->navegador;
    }
    public function getAgente(){
         return   $this->agente;
    }
    public function setAgente($agente){
            $this->agente=$agente;
    }
    public function setSO($SO){
            $this->SO=$SO;
    }
    public function setNavegador($navegador){
            $this->navegador=$navegador;
    }


	 public function parseaAgente(){

		$this->SO       = $this->reconocedorSistemaOperativo ($this->agente);
		$this->navegador= $this->reconocedorNavegador($this->agente);

	}








/*
 * Recupera el nombre de la imagen correspondiente al navegador
*/
  public function getImagenSrcNavegador(){

  	 $img="question.gif";
  	 eregi("([a-z]+)",  $this->navegador,$nombre); //conseguimos el nombre
 	 switch ($nombre[0]) {
          case "Netscape"  :$img='netscape.gif';  break;
          case "Galeon"    :$img='galeon.gif';    break;
          case "Firefox"   :$img='firefox.gif';   break;
          case "Firebird"  :$img='firebird.gif';  break;
          case "Iceweasel" :$img='iceweasel.gif'; break;
          case "Mozilla"   :$img='mozilla.gif';   break;
          case "MSIE"      :$img='explorer.gif';  break;
          case "Konqueror" :$img='konqueror.gif'; break;
          case "Opera"     :$img='opera.gif';     break;
          case "Lynx"      :$img='lynx.gif';      break;
          case "Bot"       :$img='altavista.gif'; break;
          case "WAP"       :$img='pdaphone.gif';  break;
          case "Otro"      :$img='question.gif';  break;
	}
	return $img;

}

/*
 * Recupera el nombre de la imagen correspondiente al sistema operativo
*/
  public function getImagenSrcSO(){
	 $img ="question.gif";

    switch ($this->SO ) {
          case "Windows ??"   :$img='windows.gif';      break;
   		  case "Windows XP"   :$img='windowsXP.gif';    break;
      	  case "Windows 2000" :$img='windows2000.gif';  break;
          case "Windows 98"   :$img='windows98.gif';    break;
          case "Macintosh"    :$img='mac.gif';      break;
          case "Linux"        :$img='linux.gif';    break;
          case "Debian"       :$img='debian.jpg';   break;
          case "FreeBSD"      :$img='bsd.gif';      break;
          case "SunOS"        :$img='sun.gif';      break;
          case "IRIX"         :$img='irix.gif';     break;
          case "BeOS"         :$img='be.gif';       break;
          case "OS/2"         :$img='os2.gif';      break;
          case "AIX"          :$img='aix.gif';      break;
          case "Desconocido"  :$img='question.gif'; break;
    }
    return  $img;


}



public function __destruct(){

}




}


?>

