// Reflexion und Brechung von Lichtwellen (Huygens-Prinzip), deutsche Texte
// Letzte Änderung 21.09.2015

// Texte in HTML-Schreibweise:

var text01 = "Neustart";
var text02 = "N&auml;chster Schritt";
var text03 = ["Pause", "Weiter"];                  
var text04 = "1. Brechungsindex:";
var text05 = "2. Brechungsindex:";
var text06 = "Einfallswinkel:";

var author = "&copy;&nbsp; W. Fendt 1998";
var translator = "";

// Symbole und Einheiten:

var decimalSeparator = ",";                                // Dezimaltrennzeichen (Komma/Punkt)
var degree = "&deg;";                                      // Grad

// Texte in Unicode-Schreibweise:

var text07 = [
  ["Eine gerade Wellenfront l\u00e4uft",                   // i == 0 (step == 0, n1 != n2, eps1 > 0)
   "schr\u00e4g gegen die Grenze",
   "zweier Medien, in denen die",
   "Phasengeschwindigkeiten",
   "unterschiedlich gro\u00df sind."],
   
  ["Eine gerade Wellenfront l\u00e4uft",                   // i == 1 (step == 0, n1 != n2, eps1 == 0)
   "senkrecht gegen die Grenze",
   "zweier Medien, in denen die",
   "Phasengeschwindigkeiten",
   "unterschiedlich gro\u00df sind."],
   
  ["Bei Ankunft der Wellenfront",                          // i == 2 (step == 1, n1 > n2)
   "werden in den Punkten der",
   "Grenze nach dem Prinzip von",
   "Huygens Kreis- bzw. Kugel-",
   "wellen (sogenannte Elementar-",
   "wellen) angeregt.",
   "Im Medium 2 breiten sich diese",
   "Elementarwellen schneller",
   "aus, da dort der Brechungs-",
   "index kleiner ist."],
   
  ["Bei Ankunft der Wellenfront",                          // i == 3 (step == 1, n1 < n2)
   "werden in den Punkten der",
   "Grenze nach dem Prinzip von",
   "Huygens Kreis- bzw. Kugel-",
   "wellen (sogenannte Elementar-",
   "wellen) angeregt.",
   "Im Medium 2 breiten sich diese",
   "Elementarwellen langsamer",
   "aus, da dort der Brechungs-",
   "index gr\u00f6\u00dfer ist."],
   
  ["Durch \u00dcberlagerung der Ele-",                     // i == 4 (step == 2, total == false, esp1 > 0)
   "mentarwellen entstehen neue,",
   "gerade Wellenfronten.",
   "Im Medium 1 bildet sich eine",
   "reflektierte Welle, im Medium 2",
   "dagegen eine gebrochene Welle."], 
   
  ["Durch \u00dcberlagerung der Ele-",                     // i == 5 (step == 2, total == false, esp1 == 0)
   "mentarwellen entstehen neue,",
   "gerade Wellenfronten.",
   "Im Medium 1 bildet sich eine",
   "reflektierte Welle, im Medium 2",
   "dagegen eine gebrochene Welle."],
   
  ["Durch \u00dcberlagerung der",                          // i == 6 (step == 2, total == true)
   "Elementarwellen entsteht im",
   "Medium 1 eine neue, gerade",
   "Wellenfront (reflektierte Welle).",
   "Im Medium 2 dagegen kommt",
   "keine Wellenfront zustande",
   "(Totalreflexion)."],
   
  ["Zus\u00e4tzlich sind nun Wellen-",                     // i == 7 (step == 3)
   "strahlen eingezeichnet, an",
   "denen man die Richtung der",
   "Wellenausbreitung erkennen",
   "kann."],
   
  ["Eine Wellenfront kommt",                               // i == 8 (step == 4)
   "selten allein."],

   ["Wenn die Brechungsindizes",                           // i == 9 (n1 == n2)
    "\u00fcbereinstimmen, tut sich",
    "nichts Besonderes."]];
          
var text08 = "Einfallswinkel:"; 
var text09 = "Reflexionswinkel:";
var text10 = "Brechungswinkel:"; 
var text11 = "Medium 1";
var text12 = "Medium 2";      
var text13 = ["Grenzwinkel der", "Totalreflexion:"];

// Einheiten:

var degreeUnicode = "\u00b0";                              // Grad
