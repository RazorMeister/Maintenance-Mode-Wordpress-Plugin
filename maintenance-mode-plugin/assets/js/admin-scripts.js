const COOKIE_NAME = 'MMP_currentTabId';

(function($) {
    $(document).ready(function() {
        let tabs = document.querySelectorAll(".mmp-tabs .tab-control");

        let tabIndex = getCookie(COOKIE_NAME);

        for (let i = 0; i < tabs.length; i++)
            tabs[i].addEventListener("click", switchTab);
    });

    function switchTab(event)
    {
        setCookie(COOKIE_NAME, event.currentTarget.id, 2);
    }

    $('[data-toggle="select-theme"]').click(function(){
        if( $(this).hasClass('active')){
            $(this).removeClass('active');
            $(this).find('[type="checkbox"]').removeAttr('checked');
        } else {
            let current = this.id;
            $(this).addClass('active');
            $(this).find('[type="checkbox"]').attr('checked','true');
            $('[data-toggle="select-theme"]').each(function() {
                if (this.id != current && $(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $(this).find('[type="checkbox"]').removeAttr('checked');
                }
            })
        }
    });
})( jQuery );

/**
 * Set cookie.
 *
 * @param cname
 * @param cvalue
 * @param exdays
 */
function setCookie(cname, cvalue, exdays) {
    cvalue = cvalue.replace(/(\r\n|\n|\r)/gm, "|n|");
    cvalue = cvalue.replace(/(\t)/gm, " ");
    let d = new Date;
    d.setHours(d.getHours() + 24 * (exdays || 365));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 *  Get cookie.
 *
 * @param cname
 *
 * @returns {string}cookie_value
 */
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length).replace(/\|n\|/g, "\n");
        }
    }
    return "";
}


