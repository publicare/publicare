//******************************************************************************
// ------ Apycom.com DHTML Tabs Data -------------------------------------------
//******************************************************************************
var bblankImage      = "/html/imagens/menu/menutab/blank.gif";
var bmenuWidth       = 100;
var bmenuHeight      = 0;
var bmenuOrientation = 0;

var bmenuBackColor   = "";
var bmenuBorderWidth = 0;
var bmenuBorderColor = "";
var bmenuBorderStyle = "";
var bmenuBackImage   = "";

var bbeforeItemSpace = 0;
var bafterItemSpace  = 0;

var bbeforeItemImage = ["/html/html/imagens/menu/menutab/tab01_before_n.gif","/html/imagens/menu/menutab/tab01_before_o.gif","/html/imagens/menu/menutab/tab01_before_s.gif"];
//var bbeforeItemImage = ["",""]
var bbeforeItemImageW = 5;
var bbeforeItemImageH = 18;

var bafterItemImage  = ["/html/imagens/menu/menutab/tab01_after_n.gif","/html/imagens/menu/menutab/tab01_after_o.gif","/html/imagens/menu/menutab/tab01_after_s.gif"];
//var bafterItemImage = ["",""]
var bafterItemImageW = 5;
var bafterItemImageH = 18;

var babsolute = 0;
var bleft     = 520;
var btop      = 120;

var bfloatable       = 0;
var bfloatIterations = 0;

var bfontStyle       = ["bold 10pt sans-serif","",""];
var bfontColor       = ["#000000","","#000000"];
var bfontDecoration  = ["","",""];

var bitemBorderWidth = 0;
var bitemBorderColor = ["","", ""];
var bitemBorderStyle = ["","",""];

var bitemBackColor = ["#ffffff","#FFEEB9","#F9BC00"];
var bitemBackImage = ["/html/imagens/menu/menutab/tab01_back_n.gif","/html/imagens/menu/menutab/tab01_back_o.gif","/html/imagens/menu/menutab/tab01_back_s.gif"];
var bitemAlign     = "center";
var bitemCursor    = "default";

var bitemSpacing = 0;
var bitemPadding = 0;
var browSpace    = 0;

var biconAlign  = "left";
var biconWidth  = 16;
var biconHeight = 16;

var bseparatorWidth = 20;

var btransition    = 24;
var btransDuration = 300;

var bstyles =
[
  ["biconWidth=50","biconHeight=20","bitemBackImage=/html/imagens/menu/menutab/tab01_back_n2.gif,/html/imagens/menu/menutab/tab01_back_o2.gif,/html/imagens/menu/menutab/tab01_back_s.gif","bbeforeItemImage=/html/imagens/menu/menutab/tab01_before_n2.gif,/html/imagens/menu/menutab/tab01_before_o2.gif,/html/imagens/menu/menutab/tab01_before_s.gif","bafterItemImage=/html/imagens/menu/menutab/tab01_after_n2.gif,/html/imagens/menu/menutab/tab01_after_o2.gif,/html/imagens/menu/menutab/tab01_after_s.gif"],
];
var bmenuItems = [
  ["-"],
   [menu_a, "divGuiaA",  ,,,, "0"],
  ];

 if (menu_b != "!")
 bmenuItems =
[
  ["-"],
  [menu_a, "divGuiaA",  ,,,, "0"],
  ["-"],
  [menu_b, "divGuiaB",  ,,,, "0"],
  ];
  
 if (menu_c != "!")
 bmenuItems =
[
  ["-"],
  [menu_a, "divGuiaA",  ,,,, "0"],
  ["-"],
  [menu_b, "divGuiaB",  ,,,, "0"],
  [menu_c,  "divGuiaC",  ,,,, "0"],
  ];
  
 if (menu_d != "!")
 bmenuItems =
[
  ["-"],
  [menu_a, "divGuiaA",  ,,,, "0"],
  ["-"],
  [menu_b, "divGuiaB",  ,,,, "0"],
  [menu_c,  "divGuiaC",  ,,,, "0"],
  [menu_d,  "divGuiaD",  ,,,, "0"],
  ];
  
 if (menu_e != "!")
 bmenuItems =
[
  ["-"],
  [menu_a, "divGuiaA",  ,,,, "0"],
  ["-"],
  [menu_b, "divGuiaB",  ,,,, "0"],
  [menu_c,  "divGuiaC",  ,,,, "0"],
  [menu_d,  "divGuiaD",  ,,,, "0"],
  ["-"],
  ["-"],
  [menu_e,  "divGuiaE",  ,,,, "0"],
];
	apy_tabsInit();