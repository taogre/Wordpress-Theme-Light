
//Listen on the Burger button
$('div#burgerbtn, div#closebtn, div#blackoverlay').click(()=>{
  $('#navigationbar nav').toggleClass('open');
  $('#blackoverlay').toggleClass('open');
});

//Display metrices
var navBarHeight = $('div.headercontent').height();

//Listen to scroll to fix and unfix the process bar
var onscroll = ()=>{
  //Make the percentage of the bar
  var scrollPos = (document.documentElement.scrollTop ==0 ? document.body.scrollTop : document.documentElement.scrollTop);
  var scrollHeight = document.documentElement.scrollHeight-$(window).height();
  var scrollProc = ((scrollHeight-scrollPos)/scrollHeight)*100;
  $('#readprocess>div').css('width',`${scrollProc}%`);
  //Check if it has to be fixed
  function readProcToFixed(fixed){
    var readp = $('#readprocess');
    //Check if fixed if not fix it -- and reverse
    if(readp.hasClass('fixed') && !fixed)readp.removeClass('fixed');
    else if(!readp.hasClass('fixed') && fixed)readp.addClass('fixed');
    //alert(`Fixed: ${fixed}, ScrollPos: ${scrollPos}`);
  }
  //Update the fix - from the bar
  if(scrollPos>=navBarHeight)readProcToFixed(true);
  else readProcToFixed(false);
};
$(window).scroll(onscroll);
onscroll();

//Move element
function moveElement(up,element){
  // move up:
  if(up)element.prev().insertAfter(element);
  // move down:
  if(!up)element.next().insertBefore(element);
}

//Get default fontSize
let defaultFontSize = -1;
//Calculate width of text
function calculateNavTextWidth(){
  if($('#navigationbar nav').css("position")!="fixed")return;
  //Calc stuff
  console.log("calculating width of text");
  //Make default font size
  if(defaultFontSize==-1)
    defaultFontSize = parseInt($($('ul#menu-topicmenu a').get(0)).css("font-size"));
  //Fetch the container width
  let navWidth = $('#navigationbar nav').width();
  navWidth-=20;
  //For every element
  $('ul#menu-topicmenu a').each((index)=>{
    //Get anchor and clear fontSize
    let anchor = $($('ul#menu-topicmenu a').get(index));
    anchor.css("font-size",`${defaultFontSize}px`);
    let fontSize = defaultFontSize;
    //Add calculator class
    anchor.addClass("calculate-width");
    while(anchor.width()>navWidth){
      anchor.css("font-size",`${fontSize--}px`);
    }
    anchor.removeClass("calculate-width");
  });
}
function resetCalculatedNavTextWidth(){
  //For every element
  $('ul#menu-topicmenu a').each((index)=>{
    //Get anchor and clear fontSize
    let anchor = $($('ul#menu-topicmenu a').get(index));
    anchor.css("font-size",`${defaultFontSize}px`);
  });
}

//Define the resize function
var onresize = (event)=>{
  var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
  var recentPosts = $('.recent-posts');
  var divAside = $('.aside-holder>div');
  //Check if for resizes and stuff -- Desktop mode
  if(width>1000-35){
    //Reset calculated text width
    resetCalculatedNavTextWidth();
    if(divAside.hasClass('flexmode'))divAside.removeClass('flexmode');
    if(recentPosts.hasClass('ontop')){
      moveElement(false,recentPosts);
      recentPosts.removeClass('ontop');
    }
  //Mobile mode
  }else{
    //on mobile calculate width of text
    calculateNavTextWidth();
    if(!divAside.hasClass('flexmode'))divAside.addClass('flexmode');
    if(!recentPosts.hasClass('ontop')){
      moveElement(true,recentPosts);
      recentPosts.addClass('ontop');
    }
  }
};

//On ready function
function onready(){
  //Check for cookie
  let cookie = getCookie("agreed-to-cookies");
  if(cookie!=1) //Cookie not set
    $("#cookiebar").addClass("visible");
}

//If agree button is pressed
function onAgreedToCookie(){
  let expires = new Date(((new Date()).getTime())+1000*60*60*24*365);
  setCookie("agreed-to-cookies",1,expires);
  $("#cookiebar").removeClass("visible");
}

//Make listener and call
$(window).resize(onresize);
onresize();

$(document).ready(onready);
