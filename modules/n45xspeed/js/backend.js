var stop2 = 0;
var $rebuild;
var $windowurl = getLocation(window.location.href);
var $shouldBeOpen = (typeof sessionStorage.shouldBeOpen != 'undefined') ? sessionStorage.shouldBeOpen : false;

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');

    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];

        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }

    return "";
}

function getLocation(href) {
    var l = document.createElement("a");

    l.href = href;

    return l;
}

var CacheRebuild = function(){
    var $that = this;

    var $currentchopurl = base_dir;
        $currentchopurl = $currentchopurl.replace('http:', '');
        $currentchopurl = $currentchopurl.replace('https:', '');

    $that.cachePages = function(){
        $.ajax({
            url: $currentchopurl + 'modules/n45xspeed/rebuild/execute-cron.php',

            success: function(res){
                if(res == 'Rebuild is already running'){
                    alert(res);
                }else{
                    $('#rebuildFirmaCache').html(RebuildingCacheTxt);
                }
            }
        });

        setTimeout($that.checkProgress, 5000);
    };

    $that.checkProgress = function(callback){
        $.ajax({
            url: $currentchopurl + 'modules/n45xspeed/rebuild/execute-cron.php?checkProgress=1',

            success: function(status){
                if(status == 1){
                    if(typeof callback == 'undefined'){
                        alert(CacheRebuiltTxt);

                        $('#rebuildFirmaCache').html(RebuildCacheTxt);
                    }
                }else{
                    if(typeof callback == 'function'){
                        callback();
                    }else{
                        setTimeout($that.checkProgress, 5000);
                    }
                }
            }
        });
    };

    $that.updateStats = function(speedModuleLink, $appended){
        $.ajax({
            url: speedModuleLink,

            type: 'POST',

            data: {
                getCacheStats: 1
            },

            dataType: 'json',

            success: function(data){
                console.log(data);
                $appended.find('#CacheEntries').html('<span>' + CacheEntriesTxt + ': </span>' + data.CacheEntries);
                $appended.find('#CacheHits').html('<span>' + CacheHitsTxt + ': </span>' + data.CacheHits);
                $appended.find('#TimeSaved').html('<span>' + TimeSavedTxt + ': </span>' + data.TimeSaved);
                $appended.find('#SpaceUsed').html('<span>' + SpaceUsedTxt + ': </span>' + data.SpaceUsed);
            }
        });
    };

};


$(document).ready(function(){
    var curADVCACHEMGMT = getCookie('ADVCACHEMGMT');

    if(typeof(admin_modules_link) != 'undefined'){
        var speedModuleLink = window.location.pathname + '/../' + admin_modules_link + '&configure=n45xspeed';

        var extraInfosAction  = '<form action="' + speedModuleLink + '" method="post">';
                extraInfosAction += '<input type="radio" name="ADVCACHEMGMT" id="ADVCACHEMGMT_on" class="ADVCACHEMGMT" value="2"><label class="t" for="ADVCACHEMGMT_on">' + VisibleToAllTxt + '</label>';
                extraInfosAction += '<input type="radio" name="ADVCACHEMGMT" id="ADVCACHEMGMT_emp" class="ADVCACHEMGMT" value="1"><label class="t" for="ADVCACHEMGMT_emp">' + VisibleToCurrentEmployeeTxt + '</label>';
                extraInfosAction += '<input type="radio" name="ADVCACHEMGMT" id="ADVCACHEMGMT_off" class="ADVCACHEMGMT" value="0"><label class="t" for="ADVCACHEMGMT_off">' + DisabledTxt + '</label>';
                extraInfosAction += '<input type="hidden" name="onlyVisibility" value="1">';
                extraInfosAction += '<input type="submit" name="submitModule" value="' + UpdateSettingsTxt + '" class="button">';
            extraInfosAction += '</form>';

        var $appended = '';
            $appended += '<ul class="dropdown-menu" id="extraInfos">';

                $appended += '<li>';

                    $appended += '<a id="clearFirmaCache" href="javascript:;">' + ClearCacheTxt + '</a>';

                $appended += '</li>';

                $appended += '<li>';

                    $appended += '<a id="rebuildFirmaCache" href="javascript:;">' + RebuildCacheTxt + '</a>';

                $appended += '</li>';

                $appended += '<li>';

                    $appended += '<a id="deactivateFirmaCache" href="javascript:;">';

                    if(getCookie('deactivatedCache') == 1){
                        $appended += 'Aktivere midlertidig cache';
                    }else{
                        $appended += 'Deaktivere midlertidig cache';
                    }

                    $appended += '</a>';

                $appended += '</li>';

                $appended += '<li class="dropdown open">';

                    $appended += '';

                    $appended += '<ul id="CacheStats">';

                        $appended += '<li id="CacheEntries">';

                            $appended += '<span>' + CacheEntriesTxt + ': </span>';

                        $appended += '</li>';

                        $appended += '<li id="CacheHits">';

                            $appended += '<span>' + CacheHitsTxt + ': </span>';

                        $appended += '</li>';

                        $appended += '<li id="TimeSaved">';

                            $appended += '<span>' + TimeSavedTxt + ': </span>';

                        $appended += '</li>';

                        $appended += '<li id="SpaceUsed" style="float:none;">';

                            $appended += '<span>' + SpaceUsedTxt + ': </span>';

                        $appended += '</li>';

                    $appended += '</ul>';

                $appended += '</li>';

                $appended += '<li>';

                    $appended += extraInfosAction;

                $appended += '</li>';

            $appended += '</ul>';

        $appended  = '<li id="anchorExtraInfos" class="dropdown ' + (($shouldBeOpen == 'true') ? 'open' : '') + '"><a href="javascript:void(0)">Vis/Gem Cache <i class="icon-caret-down"></i></a>' + $appended + '</li>';

        $appended = $($appended);

        $rebuild = new CacheRebuild();

        $rebuild.updateStats(speedModuleLink, $appended);

        $('#header_quick').append($appended);

        //$('#header_infos').append($appended);
        $('#anchorN45xspeed').parent().parent().remove();
        //$('body').addClass('withExtraInfos');

        if(typeof(curADVCACHEMGMT) != 'undefined'){
            $('.ADVCACHEMGMT[value="' + curADVCACHEMGMT + '"]').prop('checked', true);
        }

        $('#extraInfos form').submit(function(e){
            var ADVCACHEMGMT = $('.ADVCACHEMGMT:checked').val();
            var that = $(this);
            var submitButton = that.find('input[type="submit"]');

            submitButton.prop('disabled', true);
            submitButton.val(UpdatingTxt + '...');

            $.ajax({
                url: speedModuleLink,
                type: 'POST',
                data: {
                    onlyVisibility: 1,
                    submitModule: 'Update settings',
                    ADVCACHEMGMT: ADVCACHEMGMT
                },

                success: function(res){
                    console.log(res);
                    setCookie('ADVCACHEMGMT', ADVCACHEMGMT, 10);

                    submitButton.val(UpdatedTxt);

                    setTimeout(function(){
                        submitButton.prop('disabled', false);
                        submitButton.val(UpdateSettingsTxt);
                    }, 1500);
            }
            });

            return false;
        });

        var stop = 0;
        $('#clearFirmaCache').click(function(){
            if(stop == 0){
                stop = 1;

                var that = $(this);

                that.html(ClearingCacheTxt);

                $.ajax({
                    url: speedModuleLink,
                    type: 'POST',
                    data: {
                        clearCache: 1
                    },

                    success: function(res){
                        that.html(CacheClearedTxt);

                        $rebuild.updateStats(speedModuleLink, $('#extraInfos'));

                        setTimeout(function(){
                            that.html(ClearCacheTxt);
                            stop = 0;
                        }, 1500);
                    }
                });
            }
        });

        $rebuild.checkProgress(function(){
            $('#rebuildFirmaCache').html(RebuildingCacheTxt);
        });

        $('#rebuildFirmaCache').click(function(){
            var confirm = window.confirm('Er du sikker på du vil gøre dette? Det kan tage lang tid');

            if(confirm == true){
                var that = $(this);

                $rebuild.cachePages();
            }
        });

        $('#deactivateFirmaCache').click(function(){
            var deactivatedCookie = getCookie('deactivatedCache');

            var button = this;

            if(deactivatedCookie == 1){
                button.innerHTML = 'Deaktivere midlertidig cache';

                setCookie('deactivatedCache', '', 0);

                $rebuild.cachePages();
            }else{
                var cookieLife = prompt('Hvor mange timer vil du deaktivere cachen? Efter den valgte tid vil systemet selv cache alle sider selv.', '');

                var validator = new RegExp(/^\d+$/);

                var isValid = validator.test(cookieLife);

                if(isValid){
                    var cookieLife_hour = cookieLife
                    cookieLife = (1 / 24) * cookieLife;

                    button.innerHTML = 'Aktivere midlertidig cache';

                    var $currentchopurl = base_dir;
                        $currentchopurl = $currentchopurl.replace('http:', '');
                        $currentchopurl = $currentchopurl.replace('https:', '');

                    $.ajax({
                        url: $currentchopurl + 'modules/n45xspeed/rebuild/execute-cron.php?scheduleIn=' + cookieLife_hour,

                        type: 'GET',

                        success: function(){

                        }
                    });

                    setCookie('deactivatedCache', 1, cookieLife);
                }
            }
        });
    }
});

$(window).load(function(){
    $('#anchorN45xspeed').parent().parent().remove();
    $('a[href*="configure=n45xspeed"]').remove();

    $('#anchorExtraInfos > a').bind('click', function(){
        var $isOpen = $('#anchorExtraInfos').hasClass('open');

        if($isOpen){
            $('#anchorExtraInfos').removeClass('open');
            sessionStorage.shouldBeOpen = false;
        }else{
            $('#anchorExtraInfos').addClass('open');
            sessionStorage.shouldBeOpen = true;
        }
    });
});