var current_page;
var uri = window.location.href;
var targ;
var enableFixedMenu = false;
var mobile_width = 800;
var progressBar;
var spareTimeOut;
var firstLoad = true;
checkUri();
function load(page,option) {
    $('.menu_container').find('.selected').removeClass('selected');
    $('.menu_container').find('a[href=#'+page+']').addClass('selected');
    $('.one_menu_current').removeClass('one_menu_current');
    current_page = page;
    $.ajax({
        type: "POST",
        url: "/actions",
        data: {load:"1",page:page,option:option},
        beforeSend: function(){
            startProgress();
        },
        success: function(data){
            $('#main_content').html(data);
        }
    });
}

function startProgress() {
    showLoader();
    if (firstLoad){
        setTimeout(function () {
            setProgress(30);
        },10);
        spareTimeOut = setTimeout(finishProgress,10000);
    } else {
        progressBar.addClass('blemp');
        spareTimeOut = setTimeout(finishProgress,6000);
    }
}

function finishProgress() {
    clearTimeout(spareTimeOut);
    $('.blemp').removeClass('blemp');
    progressBar.addClass('ready');
    getScriptForCurrentPage();
    onPageLoad();
    showContent();
    selMenuIt(current_page);
    if (firstLoad){
        setTimeout(setProgress(100),200);
    }
    setTimeout(function () {
      clearProgress();
    },1000);
}

function onPageLoad() {
    var action;
    $('.order_btn').click(function () {
        action = $(this).attr('href').replace(/#/g, "");
        action = action.replace(/!/g, "");
        // alert(action);
        if (action=='order_form'){
            formActionSpan = '';
            formActionSpan = $(this).parents('.create_web').find('.descr_name').html();
            showOrderForm();
        } else {
            load(action);
        }
    });
    $(window).off('scroll');
    // setFixedMenuForFull();
}

//Current page menu identy
function selMenuIt(myPage) {
    $('.selected').removeClass('selected');
    $('.menu_container').find('a[href=#'+ myPage +']').addClass('selected');
    $('.mobile_menu').find('a[href=#'+ myPage +']').addClass('selected');
    if (window.location.href.length>19){
        if (uri.indexOf('?_escaped_fragment_=')==-1){
            // window.location.href = "/#!"+myPage;
        }
    }
}

//check if reload page
function checkUri() {
    current_page = uri.slice(19,uri.length);
    if (uri.indexOf("#")==-1 && $('.menu_container').find('a[href=#'+current_page+']').length!=0) {

    } else if (uri.indexOf("#")!=-1){
        if (uri.indexOf('!')!=-1){
            var uriNum = uri.indexOf("#");
            var uriPage = uri.slice(uriNum+2,uri.length);
            current_page = uriPage;
        } else {
            var uriNum = uri.indexOf("#");
            var uriPage = uri.slice(uriNum+1,uri.length);
            current_page = uriPage;
            window.location.href = '/#!'+uriPage;
        }
    } else if (uri.indexOf('?_escaped_fragment_=')){
        var uriNum = uri.indexOf("?_escaped_fragment_=");
        var uriPage = uri.slice(uriNum+20,uri.length);
        current_page = uriPage;
    }
    else {
        current_page = "main";
    }
}


//start loader
function showLoader() {
    $('.main_content').hide();
    $('#loader').show();
}

//end loader
function showContent() {
    $('.mobile_menu').css('transition','none');
    $('.main_content').show();
    $('#loader').hide();
    setTimeout(function () {
        $('.mobile_menu').css('transition','');
    },100);
}

function setProgress(pers) {
    progressBar.css('width',pers+'%');
}

function clearProgress() {
    progressBar.css('width','');
    progressBar.removeClass('blemp').removeClass('ready');
}