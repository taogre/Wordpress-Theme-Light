
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

//Define the resize function
var onresize = (event)=>{
  var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
  var recentPosts = $('.recent-posts');
  var divAside = $('.aside-holder>div');
  //Check if for resizes and stuff -- Desktop mode
  if(width>900){
    if(divAside.hasClass('flexmode'))divAside.removeClass('flexmode');
    if(recentPosts.hasClass('ontop')){
      moveElement(false,recentPosts);
      recentPosts.removeClass('ontop');
    }
  //Mobile mode
  }else{
    if(!divAside.hasClass('flexmode'))divAside.addClass('flexmode');
    if(!recentPosts.hasClass('ontop')){
      moveElement(true,recentPosts);
      recentPosts.addClass('ontop');
    }
  }
};
//Make listener and call
$(window).resize(onresize);
onresize();