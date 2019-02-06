<!-- Begin

// set how fast to expand horizontally
// lower is slower
var speedX = 10;

// set how fast to expand vertically
// lower is slower
var speedY = 10;

// set background color of "Loading..." screen
var bgColor = "#000000";

// set text color of "Loading..." screen
var txtColor = "#FF80000";

// do not edit below this line
// ---------------------------
var wide = window.screen.availWidth;
var high = window.screen.availHeight;
function andBoom(embedd) {
var Boomer = window.open("","BoomWindow","fullscreen");
Boomer.document.write('<HTML><BODY BGCOLOR='+bgColor+' SCROLL=NO><FONT FACE=ARIAL COLOR='+txtColor+'>Loading...</FONT></BODY></HTML>');
Boomer.focus();
for (H=1; H<high; H+= speedY) {
Boomer.resizeTo(1,H);
}
for (W=1; W<wide; W+= speedX) {
Boomer.resizeTo(W,H);
}
Boomer.location = embedd;
}
//  End -->