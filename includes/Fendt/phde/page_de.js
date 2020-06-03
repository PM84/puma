// Javascript für HTML5-Apps (deutsch)
// 13.08.2014 - 24.07.2015

// Konstanten:

var language = "de";                                                 // Abkürzung für Sprache
var textPhysics = "Physik";                                          // Bezeichnung für Physik
var textCollection = "Physik-Apps";                                  // Bezeichnung für Programmsammlung
var textModification = "Letzte \u00c4nderung";                       // Bezeichnung für letzte Änderung

// Array der Monatsnamen:

var month = ["Januar", "Februar", "M\u00e4rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];

// Logo Physik-Apps:

function logo (filename) {
  var t = document.createElement("div");                             // Neues div-Element (übergeordnet)
  t.setAttribute("id","Index");                                      // Attribut id setzen (Layout-Festlegung durch CSS-Datei)
  var t1 = document.createElement("div");                            // Neues div-Element (oben)
  t1.setAttribute("id","Index1");                                    // Attribut id setzen (Layout-Festlegung durch CSS-Datei)
  t.appendChild(t1);                                                 // div-Element hinzufügen
  var t2 = document.createElement("div");                            // Neues div-Element (unten)
  t2.setAttribute("id","Index2");                                    // Attribut id setzen (Layout-Festlegung durch CSS-Datei)
  t.appendChild(t2);                                                 // div-Element hinzufügen
  var a1 = document.createElement("a");                              // Neuer Link (für Logo)
  a1.setAttribute("href","index.html");                              // Adresse für Inhaltsverzeichnis
  var i = document.createElement("img");                             // Neues Bild (Logo Physik)
  i.setAttribute("src","../ph/javaphys.gif");                        // Pfadangabe (Bilddatei)
  i.setAttribute("alt",textPhysics);                                 // Alternativer Text
  a1.appendChild(i);                                                 // Bild zum Link hinzufügen
  t1.appendChild(a1);                                                // Link zum oberen div-Element hinzufügen
  var a2 = document.createElement("a");                              // Neuer Link (für Text)
  a2.setAttribute("href","index.html");                              // Adresse für Inhaltsverzeichnis
  a2.innerHTML = textCollection;                                     // Text für Link
  t2.appendChild(a2);                                                // Link zum unteren div-Element hinzufügen
  var body = document.getElementsByTagName("body")[0];               // Body-Element
  body.appendChild(t);                                               // Übergeordnetes div-Element hinzufügen
  }
  
// Datum nach dem Muster "1. Januar 2000"
// d ... Tag (1 bis 31)
// m ... Monat (1 bis 12)
// y ... Jahr
  
function date (d, m, y) {
  return ""+d+". "+month[m-1]+" "+y;
  }
  
// Daten am Ende der Seite (URL, Copyright, letzte Änderung)

function data (filename, d1, m1, y1, d2, m2, y2) {
  var body = document.getElementsByTagName("body")[0];               // Body-Element
  var p = document.createElement("p");                               // Neuer Absatz
  p.setAttribute("class","Ende");                                    // Klasse (Layout-Festlegung durch CSS-Datei)
  var s = "URL: http://www.walter-fendt.de/html5/ph"+language+"/";   // Anfang der URL
  s += filename+"_"+language+".htm<br>";                             // URL vervollständigen, Zeilenumbruch
  s += "\u00a9  Walter Fendt, "+date(d1,m1,y1)+"<br>";               // Copyright-Vermerk mit Datum, Zeilenumbruch
  s += textModification+": "+date(d2,m2,y2);                         // Datum der letzten Änderung
  p.innerHTML = s;                                                   // Inhalt des Absatzes
  body.appendChild(p);                                               // Absatz hinzufügen
  }
  
// Leere Zeile 
  
function emptyLine () {
  var e = document.createElement("div");                             // Neues Div-Element
  e.setAttribute("class","Abstand");                                 // Klasse (Layout-Festlegung durch CSS-Datei)
  e.innerHTML = "\u0020";                                            // Leerzeichen
  return e;                                                          // Rückgabewert
  }
  
// Seitenende insgesamt
// filename ..... Dateiname (ohne Erweiterungen)
// d1, m1, y1 ... Datum der Erstveröffentlichung
// d2, m2, y2 ... Datum der letzten Änderung

function endPage (filename, d1, m1, y1, d2, m2, y2) {
  var body = document.getElementsByTagName("body")[0];               // Body-Element
  body.appendChild(emptyLine());                                     // Leere Zeile hinzufügen
  var hr = document.createElement("hr");                             // Trennstrich
  hr.setAttribute("class","Trennlinie");                             // Klasse (Layout-Festlegung durch CSS-Datei)
  body.appendChild(hr);                                              // Trennstrich hinzufügen
  body.appendChild(emptyLine());                                     // Leere Zeile hinzufügen
  logo(filename);                                                    // Logo
  data(filename,d1,m1,y1,d2,m2,y2);                                  // Daten am Ende (URL, Copyright, letzte Änderung)
  }
  
  
  
