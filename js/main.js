$hcl.checkUri();
if (current_page.length == ''){
    current_page = 'main';
}
if ($('.menu_container').find('a[href="#'+current_page+'"]').length==0) {
    current_page = "main";
}
progressBar = $('#progressBar');
$hcl.setProgress(0);

$('.menu_container').find('a').click(function () {
    $('.menu_container').find('.selected').removeClass('selected');
    $(this).addClass('selected');
    var page = $(this).attr('href').slice(1);
    if (current_page!=page){
        $hcl.load(page);
    }
});

$('.mobile_menu').find('a').click(function () {
    $('.mobile_menu').find('.selected').removeClass('selected');
    $(this).addClass('selected');
    var page = $(this).attr('href').slice(1);
    if (current_page!=page) {
        $hcl.load(page);
    }
});

current_page = "main";
$hcl.load('main');


var Wwdth = $(window).width();
var Whght = $(window).height();
var WhghtI = window.innerHeight;
var blockMaxHeight;
var blockMinHeight;
var ifStartWhy = false;
var whyInt;
var mm;
var targ2;
var isMobile = false;
var formActionSpan = "";

if (Wwdth<=mobile_width){
    isMobile = true;
}

function revertWhy() {
    if (!$('.flipper').hasClass('escape')){
        $('.flipper').addClass('escape');
    } else {
        $('.flipper').removeClass('escape');
    }
}

function setMobileBlockHeight(obj,persent) {
    blockMaxHeight = WhghtI*persent/100;
    blockMinHeight = WhghtI*(persent-2)/100;
    $(obj).css('max-height',blockMaxHeight);
    $(obj).css('min-height',blockMinHeight);
}

function getScriptForCurrentPage() {

}