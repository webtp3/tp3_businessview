window.addEventListener("load", function(){
    var p;
    window.cookieconsent.initialise({
        "palette": {
            "popup": {
                "background": "{$plugin.bootstrap_package.settings.less.body-bg}",
                "text": "{$plugin.bootstrap_package.settings.less.gray-base}"
            },


            "button": {
                "background": "{$plugin.bootstrap_package.settings.less.brand-info}"
            }
        },
        "theme": "edgeless",
        "position": "bottom-right",
        "type": "opt-out",
        "content": {
            "message": "Diese Webseite benötigt Cookies für die optimale Leistung",
            "dismiss": "ok",
            "deny": "nein",
            "link": "mehr hierzu",
            "href": "/?id={$lib.tp3mods.privacyPid}",
        },
        onPopupOpen: function() {
            console.log('<em>onPopupOpen()</em> called');
        },
        onPopupClose: function() {
            console.log('<em>onPopupClose()</em> called');
        },
        onInitialise: function (status) {
            console.log('<em>onInitialise()</em> called with status <em>'+status+'</em>');
        },
        onStatusChange: function(status) {
            console.log('<em>onStatusChange()</em> called with status <em>'+status+'</em>');
            tp3_app.cookies = false;
            gaOptout();
        },
        onRevokeChoice: function() {
            console.log('<em>onRevokeChoice()</em> called');
        },

    },function (popup) {
        p = popup;
    }, function (err) {
        console.log(err);
    });
});
var footermeta = $('.footer .footer-section-meta .frame.meta');
var btn = document.createElement('button');
btn.id ="privacyPopup-open";
btn.innerHTML = '<b>Cookies</b>';
footermeta.appendChild(btn);



var log = console.log;
document.getElementById('btn-dismissCookie').onclick = function (e) {
    log("Calling <em>setStatus(cookieconsent.status.dismiss)</em>");
    p.setStatus(cookieconsent.status.dismiss);
    log("Calling <em>close()</em>");
    p.close();
};

document.getElementById('btn-allowCookie').onclick = function (e) {
    log("Calling <em>setStatus(cookieconsent.status.allow)</em>");
    p.setStatus(cookieconsent.status.allow);
    log("Calling <em>close()</em>");
    p.close();
};

document.getElementById('btn-denyCookie').onclick = function (e) {
    log("Calling <em>setStatus(cookieconsent.status.deny)</em>");
    p.setStatus(cookieconsent.status.deny);
    log("Calling <em>close()</em>");
    p.close();
};

document.getElementById('btn-revokeChoice').onclick = function (e) {
    log("Calling <em>revokeChoice()</em>");
    p.revokeChoice();

};

document.getElementById('privacyPopup-open').onclick = function (e) {
    log("Calling <em>open()</em>");
    p.open();
};

document.getElementById('cookieconsent-close').onclick = function (e) {
    log("Calling <em>close()</em>");
    p.close();
};

document.getElementById('cookieconsent-destroy').onclick = function (e) {
    log("Calling <em>destroy()</em>");
    p.destroy();
    log("<span class='alert'>Cookie Consent has been destroyed and cannot be used again. Reload the page.</span>");
};


