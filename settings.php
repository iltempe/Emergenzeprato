<?php
//modulo di configurazione per funzionamento dei bot (da non committare)

//fonti
	//meteo LAMMA
define('METEO_LINK','http://www.lamma.rete.toscana.it/previ/ita/xml/comuni_web/dati/prato.xml');

	//biometeo
define('BIOMETEO_ITA_LINK','http://data.biometeo.it/PRATO/PRATO_ITA.xml');
define('BIOMETEO_ENG_LINK','http://data.biometeo.it/PRATO/PRATO_ENG.xml');
	//risk CFR
define('RISK_LINK','http://www.sir.toscana.it/supports/xml/risks_395/');

	//stazioni CFR
	define("IDROMETRIA_Bisenzio_Prato", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS01004782&title=Bisenzio%A0a%A0Prato%20-%20Prato%20(PO)&name=../tmp_cfr/ic37aa43085f53650170047d8830b5a97.png&type=idro");
	define("IDROMETRIA_Bisenzio_Vaiano_Gamberame","http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS01004779&title=Bisenzio%A0a%A0Vaiano%20Gamberame%20-%20Vaiano%20(PO)&name=../tmp_cfr/ifc449e411c1d698e0a105042060a8121.png&type=idro");
	define("IDROMETRIA_Ombrone_PonteAlleVanne", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS15004865&title=Ombrone%20PT%A0a%A0Ponte%20alle%20Vanne%20Cassa%20-%20Prato%20(PO)&name=../tmp_cfr/i3014c9169a32dc31ea59f3514432ab96.png&type=idro");
	define("IDROMETRIA_Ombrone_PoggioACaiano", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS01004875&title=Ombrone%20PT%A0a%A0Poggio%20a%20Caiano%20-%20Poggio%20a%20Caiano%20(PO)&name=../tmp_cfr/ib8207ee4a75d908f5d12480394980cd8.png&type=idro");
	
	define("PLUVIOMETRIA_Prato_Città","http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS11000510&title=Prato%20Citta%B4%20-%20Prato%20(PO)&name=../tmp_cfr/p86ca748d67de092dd67c7145fc9ee64b.png&type=pluvio");
	define("PLUVIOMETRIA_Prato_Università","http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS01001205&title=Prato%20Universita%B4%20-%20Prato%20(PO)&name=../tmp_cfr/pd593af69e5d007829c972264b0c227b0.png&type=pluvio");
	define("PLUVIOMETRIA_Galceti_Montemurlo", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS11000501&title=Galceti%20-%20Montemurlo%20(PO)&name=../tmp_cfr/p7c5ea61eb8336ceb75542aa42adaf3be.png&type=pluvio");
	define("PLUVIOMETRIA_Vaiano_Gamberame", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS01004779&title=Vaiano%20Gamberame%20-%20Vaiano%20(PO)&name=../tmp_cfr/pb9f81e1748c5b76126ff0fb2b6fcbf66.png&type=pluvio");
	define("PLUVIOMETRIA_Vaiano_Acquedotto", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS11000503&title=Vaiano%20acquedotto%20-%20Vaiano%20(PO)&name=../tmp_cfr/p9ee1df5fba00a41437520078cf4b60fd.png&type=pluvio");
	define("PLUVIOMETRIA_Fattoria_Iavello_Montemurlo", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS01001273&title=Fattoria%20Iavello%20-%20Montemurlo%20(PO)&name=../tmp_cfr/p907e73cd7c7b97a8b86f3fafb1a6963e.png&type=pluvio");
	define("PLUVIOMETRIA_Cantagallo","http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS01001151&title=Cantagallo%20-%20Cantagallo%20(PO)&name=../tmp_cfr/p64af6302a680333365d8e4696829e69e.png&type=pluvio");

	define("TERMOMETRIA_Prato_Università", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS01001205&title=Prato%20Universita%B4%20-%20Prato%20(PO)&name=../tmp_cfr/t3ab6ed323c7cf793b8d8e8a69010f0ed.png&type=termo");
	define("TERMOMETRIA_Galceti_Montemurlo", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS11000501&title=Galceti%20-%20Montemurlo%20(PO)&name=../tmp_cfr/taa0862fae3d90f3a282c7b9dce035de1.png&type=termo");

	define("ANEMOMETRIA_Prato_Università", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS01001205&title=Prato%20Universita%B4%20-%20Prato%20(PO)&name=../tmp_cfr/a409aca729c7f90ece9ee833cf6621558.png&type=anemo");
	define("ANEMOMETRIA_Galceti_Montemurlo", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS11000501&title=Galceti%20-%20Montemurlo%20(PO)&name=../tmp_cfr/a7533ff8fdece4d4890f58be89de76777.png&type=anemo");

	define("IGROMETRIA_Prato_Città", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS11000510&title=Prato%20Citta%B4%20-%20Prato%20(PO)&name=../tmp_cfr/ud2dabdafe0c5eedc3eb32e207b923519.png&type=igro");
	define("IGROMETRIA_Galceti_Montemurlo", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS11000501&title=Galceti%20-%20Montemurlo%20(PO)&name=../tmp_cfr/uc7a801b7dcca5d315c900d3e333662b9.png&type=igro");
	define("IGROMETRIA_Vaiano_Acquedotto", "http://www.cfr.toscana.it/monitoraggio/image.php?id=TOS11000503&title=Vaiano%20acquedotto%20-%20Vaiano%20(PO)&name=../tmp_cfr/ubd982b5914b46e61b8fda0451c5a6219.png&type=igro");

	//protezione civile di prato emergenze
	define("PROT_CIV_WEB", "http://www.protezionecivile.comune.prato.it/emergenze/");
	
?>