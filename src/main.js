var OM = new Object();

OM.Form = new Object(), OM.Modal = new Object(), OM.Database = new Object(), OM.Page = new Object(), 
OM.Button = new Object(), OM.Validation = new Object(), OM.Date = new Object(), 
OM.Saved = new Object(), OM.Removed = new Object(), OM.login = null, OM.name = "rcvicharan", 
OM.db_prefix = "rcv-", OM.domain = window.location.protocol + "//" + window.location.host + window.location.pathname, 
OM.process = OM.domain + "process/", OM.hash = "", OM.setup = 5, OM.menu_btn = '<button id="btn-nav" class="button"><i class="fa fa-reorder"></i></button>', 
OM.loading_circle = '<div class="loading-circle"><div><div><div></div></div></div></div>';

var agent = navigator.userAgent.toLowerCase();

OM.ios = agent.indexOf("iphone") >= 0 || agent.indexOf("ipad") >= 0 || agent.indexOf("ipod") >= 0 ? !0 : !1, 
OM.android = agent.indexOf("android") >= 0 ? !0 : !1, OM.isMac = agent.indexOf("mac") >= 0 ? !0 : !1, 
OM.isMobile = agent.indexOf("blackberry") >= 0 || agent.indexOf("android") >= 0 || agent.indexOf("ipod") >= 0 || agent.indexOf("ipad") >= 0 || agent.indexOf("iphone") >= 0 || agent.indexOf("opera mini") >= 0 ? !0 : !1, 
OM.online = function() {
    return navigator.onLine;
}, OM.log = function(logs) {
    console.log(logs);
}, OM.back_btn = function(href) {
    return '<button data-href="' + href + '" id="back-btn" class="button" type="button"><i class="fa fa-angle-left"></i></button>';
}, OM.trigger = function(id, trigger_event) {
    $("#" + id).trigger(trigger_event);
}, OM.live_event = function(target, event, action) {
    $(document).on(event, target, action);
}, OM.error_message_remove = function(id) {
    $(id).slideUp("blind", function() {
        $(id).remove();
    });
}, OM.is_string = function(input) {
    return "string" == typeof input;
}, OM.is_empty = function(str) {
    return !str || 0 === str.length;
}, OM.is_blank = function(str) {
    return !str || /^\s*$/.test(str);
}, OM.ucfirst = function(string) {
    return string.substring(0, 1).toUpperCase() + string.substring(1).toLowerCase();
}, OM.add_zero = function(string) {
    return 10 > string && (string = "0" + string), string;
}, OM.get_data = function(url, data, functions, type) {
    type && void 0 != type || (type = "post"), "post" == type ? $.post(url, data, functions) : "get" == type ? $.get(url, data, functions) : "json" == type && $.getJSON(url, data, functions);
}, OM.message = function(c) {
    return '<div id="system-message">' + c + "</div>";
}, OM.error_message = function(page_name, selecter, message) {
    var id = selecter.replace(/^#/, "");
    message && (console.warn(id + ": " + message), $(selecter).attr("data-border", "error"), 
    OM.message_contener(page_name), $("#message-" + page_name).html(message).attr("data-message", "error"));
}, OM.message_contener = function(page_name) {
    0 == $("#message-" + page_name).length && $("#form-" + page_name).prepend('<div id="message-' + page_name + '"></div>');
}, OM.reset_form = function(page_name) {
    $("#form-" + page_name).find("[data-border]").removeAttr("data-border");
}, OM.replace_quotes = function(text) {
    return text = text.replace(/"/g, "&#34;"), text = text.replace(/'/g, "&#39;");
}, OM.replace_space = function(text) {
    return text = text.replace(/ /gi, "-");
}, OM.search_objects = function(obj, key, val) {
    var objects = [];
    for (var i in obj) obj.hasOwnProperty(i) && ("object" == typeof obj[i] ? objects = objects.concat(OM.search_objects(obj[i], key, val)) : i == key && obj[key] == val && objects.push(obj));
    return objects;
}, OM.talkingToServer_animation = function(text) {
    return '<div id="talkingToServer"><div class="loading"><div></div><div></div><div></div><div></div><div></div></div><div class="text">' + text + '</div><div class="server"></div><i class="fa fa-cog fa-spin"></i></div>';
}, OM.doneTalkingToServer = function(text) {
    return '<div id="doneTalkingToServer">' + text + "</div>";
}, OM.nicEditor = function(id) {
    0 == OM.isMobile && new nicEditor({
        iconsPath: "src/plugin/nicEditorIcons.gif",
        maxHight: 500,
        buttonList: [ " ", " ", "bold", "italic", "underline", "strikethrough", "indent", "outdent", "ol", "ul", "removeformat" ]
    }).panelInstance(id);
}, OM.Database = function() {
    null == window.localStorage.getItem(OM.db_prefix + "assignedCenters") ? window.localStorage.setItem(OM.db_prefix + "assignedCenters", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "checkedInCenters") ? window.localStorage.setItem(OM.db_prefix + "checkedInCenters", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "checkedInDates") ? window.localStorage.setItem(OM.db_prefix + "checkedInDates", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "checkedInUsers") ? window.localStorage.setItem(OM.db_prefix + "checkedInUsers", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "last_link") ? window.localStorage.setItem(OM.db_prefix + "last_link", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "myCheckIn") ? window.localStorage.setItem(OM.db_prefix + "myCheckIn", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "myGoals") ? window.localStorage.setItem(OM.db_prefix + "myGoals", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "myVicharanEvents") ? window.localStorage.setItem(OM.db_prefix + "myVicharanEvents", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "plannedDates") ? window.localStorage.setItem(OM.db_prefix + "plannedDates", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "plannedUsers") ? window.localStorage.setItem(OM.db_prefix + "plannedUsers", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "profiles") ? window.localStorage.setItem(OM.db_prefix + "profiles", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "regionCenter") ? window.localStorage.setItem(OM.db_prefix + "regionCenter", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "select") ? window.localStorage.setItem(OM.db_prefix + "select", "null") : "", 
    null == window.localStorage.getItem(OM.db_prefix + "session") ? window.localStorage.setItem(OM.db_prefix + "session", '{"t":null,"u":null}') : "", 
    null == window.localStorage.getItem(OM.db_prefix + "vicharanNotes") ? window.localStorage.setItem(OM.db_prefix + "vicharanNotes", "null") : "", 
    OM.assignedCenters = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "assignedCenters")), 
    OM.checkedInCenters = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "checkedInCenters")), 
    OM.checkedInDates = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "checkedInDates")), 
    OM.checkedInUsers = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "checkedInUsers")), 
    OM.last_link = window.localStorage.getItem(OM.db_prefix + "last_link"), OM.myCheckIn = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "myCheckIn")), 
    OM.myGoals = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "myGoals")), 
    OM.myVicharanEvents = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "myVicharanEvents")), 
    OM.plannedDates = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "plannedDates")), 
    OM.plannedUsers = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "plannedUsers")), 
    OM.profiles = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "profiles")), 
    OM.regionCenter = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "regionCenter")), 
    OM.select = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "select")), OM.session = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "session")), 
    OM.vicharanNotes = $.parseJSON(window.localStorage.getItem(OM.db_prefix + "vicharanNotes"));
}, OM.Database.empty = function() {
    window.localStorage.clear(), OM.Database();
}, OM.Database.update = function(key, value) {
    var update = !1;
    "assignedCenters" == key ? (update = !0, OM.assignedCenters = value) : "checkedInCenters" == key ? (update = !0, 
    OM.checkedInCenters = value) : "checkedInDates" == key ? (update = !0, OM.checkedInDates = value) : "checkedInUsers" == key ? (update = !0, 
    OM.checkedInUsers = value) : "myCheckIn" == key ? (update = !0, OM.myCheckIn = value) : "myGoals" == key ? (update = !0, 
    OM.myGoals = value) : "myVicharanEvents" == key ? (update = !0, OM.myVicharanEvents = value) : "plannedUsers" == key ? (update = !0, 
    OM.plannedUsers = value) : "plannedDates" == key ? (update = !0, OM.plannedDates = value) : "profiles" == key ? (update = !0, 
    OM.profiles = value) : "regionCenter" == key ? (update = !0, OM.regionCenter = value) : "select" == key ? (update = !0, 
    OM.select = value) : "session" == key ? (update = !0, OM.session = value) : "vicharanNotes" == key && (update = !0, 
    OM.vicharanNotes = value), update && window.localStorage.setItem(OM.db_prefix + key, JSON.stringify(value));
}, OM.Database.check = function(data) {
    var message = !0;
    return void 0 == data ? message = !1 : "undefined" == data ? message = !1 : null == data ? message = !1 : "null" == data && (message = !1), 
    message;
}, OM.Database.sync = function(options, type) {
    options = void 0 == options || "" == options ? "" : options, type = void 0 == type || "" == type ? "" : type, 
    OM.get_data(OM.process + "index.php", {
        code: "sync",
        type: type,
        sid: OM.session.t,
        uid: OM.session.u
    }, function(data) {
        1 == data.login ? (OM.login = !0, data.assignedCenters ? OM.Database.update("assignedCenters", data.assignedCenters) : "", 
        data.checkedInCenters ? OM.Database.update("checkedInCenters", data.checkedInCenters) : "", 
        data.checkedInDates ? OM.Database.update("checkedInDates", data.checkedInDates) : "", 
        data.checkedInUsers ? OM.Database.update("checkedInUsers", data.checkedInUsers) : "", 
        data.myCheckIn ? OM.Database.update("myCheckIn", data.myCheckIn) : "", data.myGoals ? OM.Database.update("myGoals", data.myGoals) : "", 
        data.myVicharanEvents ? OM.Database.update("myVicharanEvents", data.myVicharanEvents) : "", 
        data.plannedUsers ? OM.Database.update("plannedUsers", data.plannedUsers) : "", 
        data.plannedDates ? OM.Database.update("plannedDates", data.plannedDates) : "", 
        data.profiles ? OM.Database.update("profiles", data.profiles) : "", data.regionCenter ? OM.Database.update("regionCenter", data.regionCenter) : "", 
        data.select ? OM.Database.update("select", data.select) : "", data.session ? OM.Database.update("session", data.session) : "", 
        data.vicharanNotes ? OM.Database.update("vicharanNotes", data.vicharanNotes) : "", 
        OM.session.syncTime = data.datetime[1], "vicharan-notes" == options && $("#back-btn").trigger("click"), 
        "my-goals" == options && OM.Page.my_goals(), "setting-check-in" == options && OM.Page.setting_check_in(), 
        "admin-profiles" == options && $("#back-btn").trigger("click"), "admin-assign-center" == options && OM.Page.admin_assign_center(), 
        "admin-centers" == options && OM.Page.admin_centers(), "admin-select-other-option" == options && OM.Page.admin_select_other_option(), 
        "sync-btn" == options ? ($("#btn-sync").removeAttr("disable").attr({
            "data-color": "purple"
        }), $("#btn-sync i").removeClass("fa-spin"), $("#sync-time").html("Last updated: " + OM.session.syncTime)) : "setup-start" == options ? OM.Page.setup_start() : "none" == options || $(window).trigger("hashchange")) : (OM.login = !1, 
        console.log(data.login), $(window).trigger("hashchange"));
    });
}, OM.Database(), OM.Database.sync(), OM.Validation.firstName = function(string) {
    return OM.is_empty(string) ? "Please enter first name." : string.length < 2 ? "Please enter first name." : /[a-zA-Z]*/.test(string) ? !0 : "Please enter validate first name.";
}, OM.Validation.lastName = function(string) {
    return OM.is_empty(string) ? "Please enter last name." : string.length < 2 ? "Please enter last name." : /[a-zA-z]+([ '-][a-zA-Z]+)*/.test(string) ? !0 : "Please enter validate last name.";
}, OM.Validation.email = function(string) {
    return OM.is_empty(string) ? "Please enter email address." : /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(string) ? !0 : "Please enter validate email address.";
}, OM.Validation.password = function(string) {
    return OM.is_empty(string) ? "Please enter password." : string.length < 6 ? "Please enter at least 6 characters." : string.match(/[A-Z]/) ? string.match(/[A-z]/) ? string.match(/\d/) ? !0 : "Please enter at least one number." : "Please enter at least one letter." : "Please enter at least one capital letter.";
}, OM.Validation.confirm_match = function(string, confirm, field) {
    return OM.is_empty(confirm) ? "Please confirm " + field + "." : string != confirm ? "Confirm " + field + " does not match." : !0;
}, OM.Form.built_select_box = function(id, name, value, title_option, selected_value, attr, index) {
    void 0 == attr && (attr = ""), void 0 == index && (index = 0);
    var option = '<option value="">' + title_option + "</option>", selected = "";
    ("" == index || "-1" == index) && (index = 0);
    for (var a = index; a < value.length; a++) selected = selected_value == value[a] ? " selected" : "", 
    option += '<option value="' + value[a] + '"' + selected + ">" + name[a] + "</option>";
    return '<select id="' + id + '" name="' + id + '" ' + attr + ">" + option + "</select>";
}, OM.Form.select_assign_center = function(id, attr, other_center, other) {
    for (var option = '<option value="">Select Center</option>', center = OM.session.assign_center, a = 0; a < center.length; a++) option += '<option value="' + center[a].name + '" data-bm="' + center[a].bm + '" data-km="' + center[a].km + '" data-bst="' + center[a].bst + '" data-kst="' + center[a].kst + '" data-campus="' + center[a].campus + '" data-goshti="' + center[a].goshti + '" data-lam="' + center[a].lam + '">' + center[a].name + "</option>";
    return option += 1 == other && OM.select.other_option.length > 0 ? '<option value="other">Other</option>' : "", 
    option += 1 == other_center ? '<option value="other-center">Other Center</option>' : "", 
    '<select id="' + id + '" name="' + id + '" ' + attr + ">" + option + "</select>";
}, OM.Form.change_sabha_type = function(page_name, selecter) {
    var bm = $("#" + selecter + " option:selected").attr("data-bm"), km = $("#" + selecter + " option:selected").attr("data-km"), bst = $("#" + selecter + " option:selected").attr("data-bst"), kst = $("#" + selecter + " option:selected").attr("data-kst"), campus = $("#" + selecter + " option:selected").attr("data-campus"), goshti = $("#" + selecter + " option:selected").attr("data-goshti"), lam = $("#" + selecter + " option:selected").attr("data-lam"), content = "", value = OM.select.sabha_type;
    return OM.is_empty(bm) || "B" != OM.session.mandal || (content += '<option value="' + value[0] + '">' + value[0] + "</option>"), 
    OM.is_empty(bst) || "B" != OM.session.mandal || (content += '<option value="' + value[1] + '">' + value[1] + "</option>"), 
    OM.is_empty(km) || "K" != OM.session.mandal || (content += '<option value="' + value[2] + '">' + value[2] + "</option>"), 
    OM.is_empty(kst) || "K" != OM.session.mandal || (content += '<option value="' + value[3] + '">' + value[3] + "</option>"), 
    OM.is_empty(campus) || "K" != OM.session.mandal || (content += '<option value="' + value[4] + '">' + value[4] + "</option>"), 
    OM.is_empty(goshti) || (content += '<option value="' + value[5] + '">' + value[5] + "</option>"), 
    OM.is_empty(lam) || (content += '<option value="' + value[6] + '">' + value[6] + "</option>"), 
    '<option value="">Select Sabha</option>' + content;
}, OM.Form.change_mandal_on_off = function(page_name, selecter) {
    var mandal_value = new Array($("#" + selecter + " option:selected").attr("data-bm"), $("#" + selecter + " option:selected").attr("data-bst"), $("#" + selecter + " option:selected").attr("data-km"), $("#" + selecter + " option:selected").attr("data-kst"), $("#" + selecter + " option:selected").attr("data-campus"), $("#" + selecter + " option:selected").attr("data-goshti"), $("#" + selecter + " option:selected").attr("data-lam")), mandal_name = new Array("BM", "BST", "Goshti", "LAM", "KM", "KST", "Campus"), content = "", checked = "";
    if ("B" == OM.session.mandal) for (var a = 0; 3 > a; a++) checked = OM.is_empty(mandal_value[a]) ? "" : "checked", 
    content += "<li><span>" + mandal_name[a] + '</span><span class="checkbox yes-no"><input type="checkbox" id="edit-' + page_name + "-" + mandal_name[a] + '" value="Y" class="mandal-' + page_name + '" placeholder="' + mandal_name[a] + '" ' + checked + '><label for="edit-' + page_name + "-" + mandal_name[a] + '"><div class="inner"></div><div class="btn-switch"></div></label></span></li>'; else if ("K" == OM.session.mandal) for (var a = 2; 7 > a; a++) checked = OM.is_empty(mandal_value[a]) ? "" : "checked", 
    content += "<li><span>" + mandal_name[a] + '</span><span class="checkbox yes-no"><input type="checkbox" id="edit-' + page_name + "-" + mandal_name[a] + '" value="Y" class="mandal-' + page_name + '" placeholder="' + mandal_name[a] + '" ' + checked + '><label for="edit-' + page_name + "-" + mandal_name[a] + '"><div class="inner"></div><div class="btn-switch"></div></label></span></li>';
    return '<ul class="li-icon">' + content + "</ul>";
}, OM.Form.year = function(id, value, more) {
    var year = OM.Date.year_full();
    OM.Date.month() >= 11 && (year += 1, value = year);
    var this_yrar, selected_year, year_different = Math.abs(year - Math.abs(year - 1)), year_option = "";
    more || (more = ""), value || (value = "");
    for (var a = 0; year_different > a; a++) {
        var this_yrar = year - a;
        selected_year = this_yrar == value ? "selected" : "", year_option += '<option value="' + this_yrar + '" ' + selected_year + ">" + this_yrar + "</option>";
    }
    return '<select name="' + id + '" id="' + id + '" ' + more + '><option value="">Select Year</option>' + year_option + "</select>";
}, OM.Form.month = function(id, value, more) {
    var selected, b, month_option = "";
    value += 1;
    for (var a = 1; 13 > a; a++) b = 10 > a ? "0" + a : a, selected = b == value ? "selected" : "", 
    month_option += '<option value="' + b + '" ' + selected + ">" + OM.change_month(a, "word", "full") + "</option>";
    return '<select name="' + id + '" id="' + id + '" ' + more + '><option value="">Select Month</option>' + month_option + "</select>";
}, OM.Form.day = function(id, value, more) {
    for (var selected, b, day_option = "", a = 1; 32 > a; a++) b = 10 > a ? "0" + a : a, 
    selected = b == value ? "selected" : "", day_option += '<option value="' + b + '" ' + selected + ">" + b + "</option>";
    return '<select name="' + id + '" id="' + id + '" ' + more + '><option value="">Select Day</option>' + day_option + "</select>";
}, OM.Form.fields = function(form_id) {
    for (var fields = $("#" + form_id).find("input, select, textarea"), output = Array(), a = 0; a < fields.length; a++) if (void 0 == fields[a].attributes["data-not"]) {
        var field = fields[a], id = field.attributes.id.value, element = $("#" + id).get(0).tagName, checked = $("#" + id).is(":checked"), type = field.attributes.type ? field.attributes.type.value : null, value = "checkbox" == type ? checked ? field.value : null : field.value;
        output[a] = {
            id: id,
            id_short: id.split(form_id + "-")[1],
            element: element,
            type: type,
            required: field.attributes.required ? !0 : !1,
            disabled: field.attributes.disabled ? !0 : !1,
            checked: checked,
            hidden: $("#" + id).parent().parent().is(":hidden"),
            group: field.attributes["data-group"] ? parseInt(field.attributes["data-group"].value) : null,
            show: field.attributes["data-show"] ? field.attributes["data-show"].value : null,
            field: "checkbox" == type ? $("#" + id).parent().parent().parent().find(".field").text() : $("#" + id).parent().parent().find(".field").text(),
            value: value,
            value_filtered: null == value ? null : $("<p>" + value + "</p>").text(),
            text: "SELECT" == element ? $("#" + id + " option:selected").text() : field.value,
            prefix: $("#" + id).parent().find(".prefix").text(),
            suffix: $("#" + id).parent().find(".suffix").text()
        };
    }
    return output;
}, OM.Form.validate = function(form_id) {
    var fields = OM.Form.fields(form_id), error = !1, groups = new Array();
    $(".validation-icon span.fa").remove(), $("#" + form_id + " [data-border]").removeAttr("data-border");
    for (var a = 0; a < fields.length; a++) {
        var row = fields[a];
        if (row.required && !row.hidden) if (null == row.group) "SELECT" == row.element ? "" == row.value_filtered ? (error = !0, 
        OM.Form.validation_effect(row.id)) : OM.Form.validation_effect(row.id, "success") : "INPUT" == row.element ? "checkbox" == row.type ? row.checked ? OM.Form.validation_effect(row.id, "success") : (error = !0, 
        OM.Form.validation_effect(row.id)) : "" == row.value_filtered ? (error = !0, OM.Form.validation_effect(row.id)) : OM.Form.validation_effect(row.id, "success") : "TEXTAREA" == row.element && ("" == row.value_filtered ? (error = !0, 
        OM.Form.validation_effect(row.id)) : OM.Form.validation_effect(row.id, "success")); else {
            var b = row.group - 1;
            groups[b] = void 0 == groups[b] ? new Array() : groups[b];
            var c = groups[b].length;
            groups[b][c] = void 0 == groups[b][c] ? new Object() : groups[b][c], groups[b][c] = row;
        }
    }
    for (var a = 0; a < groups.length; a++) {
        for (var group = groups[a], is_empty = !0, b = 0; b < group.length; b++) {
            var row = group[b];
            "" != row.value_filtered && (is_empty = !1);
        }
        if (is_empty) {
            error = !0;
            for (var b = 0; b < group.length; b++) {
                var row = group[b];
                OM.Form.validation_effect(row.id);
            }
        }
    }
    if (error) {
        var message = '<h4><i class="fa fa-warning"></i>OH SNAP! I found some error in this form.</h4><p>Change a few things up and try submitting again.</p>';
        return 0 == $("#message-" + form_id).length && $("#" + form_id).before('<div id="message-' + form_id + '" data-card="message"></div>'), 
        $("#message-" + form_id).html(message).attr("data-background", "error"), !1;
    }
    return !0;
}, OM.Form.validation_effect = function(id, type) {
    type = void 0 == type ? "error" : type;
    var icon = "error" == type ? "times-circle" : "success" == type ? "check-circle" : "warning";
    0 == $("#fa-" + id).length && $("#" + id).after('<span id="fa-' + id + '"></span>'), 
    $("#" + id).attr("data-border", type).parent().find(".nicEdit-main").attr("data-border", type), 
    $("#fa-" + id).attr("data-color", type).removeAttr("class").addClass("validation-icon fa fa-" + icon), 
    setTimeout(function() {
        $("#" + id).parent().addClass("validation").attr("data-has", "error");
    }, 50);
}, OM.Form.confirm = function(form_id, title) {
    if (OM.Form.validate(form_id)) {
        for (var fields = OM.Form.fields(form_id), output = "", hidden = "", a = 0; a < fields.length; a++) {
            var row = fields[a];
            switch (row.prefix = "" != row.prefix ? row.prefix + " " : "", row.suffix = "" != row.suffix ? " " + row.suffix : "", 
            hidden = "confirm" == row.show || !row.hidden && "hidden" != row.type ? "" : "hidden", 
            row.type) {
              case "date":
                row.value = OM.Date.change(row.value);
                break;

              case "checkbox":
                row.value = row.checked ? "Yes" : "No";
            }
            output += '<li class="' + hidden + '"><div class="field">' + row.field + '</div><div class="value">' + row.prefix + row.value + row.suffix + "</div></li>";
        }
        OM.Modal.confirm(form_id, title, '<ul data-list="form">' + output + "</ul>");
    }
}, OM.Form.field_json = function(form_id, code) {
    code = void 0 == code ? "" : code;
    for (var fields = OM.Form.fields(form_id), output = "{" + code, a = 0; a < fields.length; a++) {
        var row = fields[a];
        row.value = null == row.value_filtered || "" == row.value_filtered ? null : '"' + row.value.replace(/"/g, '\\"') + '"', 
        output += 0 == a && "" != code ? "," : "", output += '"' + row.id_short + '":' + row.value, 
        output += a != fields.length - 1 ? "," : "";
    }
    return output += "}";
}, OM.Button.create = function(element, attr, text) {
    return "<" + element + " " + attr + ">" + text + "</" + element + ">";
}, OM.Button.save = function(a) {
    return a.color = void 0 != a.color && 1 == a.color ? 'data-button data-color="green"' : 'data-button data-color="' + a.color + '"', 
    void 0 != a.icon && 1 == a.icon ? a.icon = '<i class="fa fa-save"></i> ' : "", "" == a.attr || void 0 == a.attr ? a.attr = "" : "", 
    "" == a.text || void 0 == a.text ? a.text = "" : "", OM.Button.create("button", 'type="submit" id="btn-save-' + a.page_name + '" ' + a.color + " " + a.attr, a.icon + a.text);
}, OM.Button.add = function(a) {
    return a.color = void 0 != a.color && 1 == a.color ? 'data-button data-color="dark-blue"' : 'data-button data-color="' + a.color + '"', 
    void 0 != a.icon && 1 == a.icon ? a.icon = '<i class="fa fa-plus"></i> ' : "", "" == a.attr || void 0 == a.attr ? a.attr = "" : "", 
    "" == a.text || void 0 == a.text ? a.text = "" : "", OM.Button.create("button", 'type="button" id="btn-add-' + a.page_name + '" ' + a.color + " " + a.attr, a.icon + a.text);
}, OM.Button.edit = function(a) {
    return a.color = void 0 != a.color && 1 == a.color ? 'data-button data-color="dark-teal"' : 'data-button data-color="' + a.color + '"', 
    void 0 != a.icon && 1 == a.icon ? a.icon = '<i class="fa fa-edit"></i> ' : "", "" == a.attr || void 0 == a.attr ? a.attr = "" : "", 
    "" == a.text || void 0 == a.text ? a.text = "" : "", OM.Button.create("button", 'type="button" class="btn-edit-' + a.page_name + '" ' + a.color + " " + a.attr, a.icon + a.text);
}, OM.Button.close = function(a) {
    return a.color = void 0 != a.color && 1 == a.color ? 'data-button data-color="red"' : 'data-button data-color="' + a.color + '"', 
    void 0 != a.icon && 1 == a.icon ? a.icon = '<i class="fa fa-times"></i> ' : "", 
    "" == a.attr || void 0 == a.attr ? a.attr = "" : "", "" == a.text || void 0 == a.text ? a.text = "" : "", 
    OM.Button.create("button", 'type="button" data-id="' + a.page_name + '" class="close-dialog btn-close-' + a.page_name + '" ' + a.color + " " + a.attr, a.icon + a.text);
}, OM.Button.remove = function(a) {
    return a.color = void 0 != a.color && 1 == a.color ? 'data-button data-color="red"' : 'data-button data-color="' + a.color + '"', 
    void 0 != a.icon && 1 == a.icon ? a.icon = '<i class="fa fa-trash-o"></i> ' : "", 
    "" == a.attr || void 0 == a.attr ? a.attr = "" : "", "" == a.text || void 0 == a.text ? a.text = "" : "", 
    OM.Button.create("button", 'type="button" class="btn-remove-' + a.page_name + '" ' + a.color + " " + a.attr, a.icon + a.text);
}, OM.Button.confirm = function(a) {
    return a.color = void 0 != a.color && 1 == a.color ? 'data-button data-color="yellow"' : 'data-button data-color="' + a.color + '"', 
    void 0 != a.icon && 1 == a.icon ? a.icon = '<i class="fa fa-thumbs-o-up"></i> ' : "", 
    "" == a.attr || void 0 == a.attr ? a.attr = "" : "", "" == a.text || void 0 == a.text ? a.text = "" : "", 
    OM.Button.create("button", 'type="button" id="btn-confirm-' + a.page_name + '" ' + a.color + " " + a.attr, a.icon + a.text);
}, OM.Button.download = function(a) {
    return a.color = void 0 != a.color && 1 == a.color ? 'data-button data-color="yellow"' : 'data-button data-color="' + a.color + '"', 
    void 0 != a.icon && 1 == a.icon ? a.icon = '<i class="fa fa-cloud-download"></i> ' : "", 
    "" == a.attr || void 0 == a.attr ? a.attr = "" : "", "" == a.text || void 0 == a.text ? a.text = "" : "", 
    OM.Button.create("button", 'type="button" ' + a.color + " " + a.attr, a.icon + a.text);
}, OM.date = new Object(), OM.Date.year_full = function() {
    return new Date().getFullYear();
}, OM.Date.month = function() {
    return new Date().getMonth() + 1;
}, OM.Date.date = function() {
    return new Date().getDate();
}, OM.Date.day = function() {
    return new Date().getDay();
}, OM.Date.hour = function() {
    return new Date().getHours();
}, OM.Date.minute = function() {
    return new Date().getMinutes();
}, OM.Date.second = function() {
    return new Date().getSeconds();
}, OM.Date.day = function() {
    return new Date().getDay();
}, OM.Date.today = function() {
    return OM.Date.year_full() + "-" + OM.add_zero(OM.Date.month()) + "-" + OM.add_zero(OM.Date.date());
}, OM.Date.time = function() {
    return OM.add_zero(OM.Date.hour()) + ":" + OM.add_zero(OM.Date.minute());
}, OM.Date.full_time = function() {
    return OM.add_zero(OM.Date.hour()) + ":" + OM.add_zero(OM.Date.minute()) + ":" + OM.add_zero(OM.Date.second());
}, OM.Date.now = function() {
    return OM.Date.today() + " " + OM.Date.full_time();
}, OM.Date.datetime_format = function(value, type) {
    var date_split = value.split("/"), return_value = "";
    return "yyyy-mm-dd" == type && (return_value = date_split[2] + "-" + date_split[0] + "-" + date_split[1]), 
    return_value ? return_value : value;
}, OM.Date.change = function(date) {
    return date = date.split("-"), OM.Date.change_month(date[1], "word", "") + " " + date[2] + ", " + date[0];
}, OM.Date.change_month = function(month, type, lenth) {
    var month_num_long = new Array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"), month_num_short = new Array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"), month_word_long = new Array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december");
    OM.is_string(month) && (month = month.toLowerCase());
    for (var i = 0; 12 > i; i++) {
        if (array_i = 0, parseFloat(month)) {
            if (month_num_long[i] != month) {
                array_i = month - 1;
                break;
            }
            array_i = i;
        }
        if (OM.is_string(month) && (month_word_long[i] == month ? array_i = i : month_word_long[i].substr(0, 3) == month && (array_i = i)), 
        !OM.is_empty(array_i)) break;
    }
    return "num" == type ? month = "full" == lenth ? month_num_long[array_i] : parseFloat(month_num_short[array_i]) : "word" == type ? (month = "short" == lenth ? month_word_long[array_i].substr(0, 3) : month_word_long[array_i], 
    OM.ucfirst(month)) : month;
}, OM.Date.convert_time = function(time, type) {
    time = time.split(" ");
    var ap = OM.PHP.strtolower(time[1]);
    time = time[0].split(":");
    var hour = time[0];
    return "24" == type ? ("am" == ap ? "12" == hour && (hour = "00") : "pm" == ap && ("01" == hour ? hour = "13" : "02" == hour ? hour = "14" : "03" == hour ? hour = "15" : "04" == hour ? hour = "16" : "05" == hour ? hour = "17" : "06" == hour ? hour = "18" : "07" == hour ? hour = "19" : "08" == hour ? hour = "20" : "09" == hour ? hour = "21" : "10" == hour ? hour = "22" : "11" == hour && (hour = "23")), 
    ap = "") : "12" == type && (ap = "12" > hour ? " AM" : " PM", "13" == hour ? hour = "01" : "14" == hour ? hour = "02" : "15" == hour ? hour = "03" : "16" == hour ? hour = "04" : "17" == hour ? hour = "05" : "18" == hour ? hour = "06" : "19" == hour ? hour = "07" : "20" == hour ? hour = "08" : "21" == hour ? hour = "09" : "22" == hour ? hour = "10" : "23" == hour ? hour = "11" : "00" == hour && (hour = "12")), 
    hour + ":" + time[1] + ap;
}, OM.Date.timestamp = function(input) {
    input = input.split(" ");
    var date = input[0], time = input[1];
    if (date = date.split("-"), void 0 == time) var timestamp = new Date(date[0], date[1] - 1, date[2]).getTime(); else {
        time = time.split(":");
        var timestamp = new Date(date[0], date[1] - 1, date[2], time[0], time[1], time[2]).getTime();
    }
    return timestamp / 1e3;
}, OM.Modal.new = function(id, content, selecter, attr) {
    attr && void 0 != attr || (attr = ""), selecter && void 0 != selecter || (selecter = "body"), 
    0 == $("#dialog-" + id).length && (content || (content = OM.Modal.format("Error: Loading Data", OM.Button.close({
        page_name: id,
        color: !0,
        icon: !0
    }), OM.message("<h3>There was some error loading data</h3>"))), console.log("open: #dialog-" + id), 
    $(selecter).append('<section id="dialog-' + id + '" class="dialog" style="opacity:0;"><div id="dialog-' + id + '-content" class="dialog-content" ' + attr + ' data-id="' + id + '">' + content + "</div></section>"), 
    OM.Modal.fix_postion(id), $("#dialog-" + id).animate({
        opacity: 1
    }, 100));
}, OM.live_event(".close-dialog", "click", function() {
    OM.Modal.close($(this).attr("data-id"));
}), OM.Modal.close = function(id) {
    $("#dialog-" + id).length > 0 && (console.log("close: #dialog-" + id), $("#dialog-" + id).animate({
        opacity: 0
    }, 100, function() {
        $("#dialog-" + id).remove();
    }));
}, OM.Modal.format = function(header, button, section) {
    var format = "";
    return header && (format = "<header><span>" + header + "</span><span>" + button + "</span></header>"), 
    section && (format += "<section>" + section + "</section>"), format;
}, OM.Modal.change_content = function(id, content) {
    $("#dialog-" + id + "-content").html(content);
}, OM.Modal.hide = function(id) {
    $("#dialog-" + id).css("display", "none");
}, OM.Modal.show = function(id) {
    $("#dialog-" + id).css("display", "block");
}, OM.Modal.loading = function(id) {
    OM.Modal.new(id, OM.loading_circle);
}, OM.Modal.site_loading = function() {
    OM.Modal.new("site-loader", '<div id="site-loader"></div>');
}, OM.Modal.confirm = function(page_name, header, content) {
    OM.Modal.new("confirm-" + page_name, OM.Modal.format("Confirm: " + header, OM.Button.close({
        page_name: "confirm-" + page_name,
        color: !0,
        icon: !0
    }), content + '<div class="btn">' + OM.Button.confirm({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Confirm"
    }) + "</div>"));
}, OM.Modal.save = function(page_name, php_page, post_data, callBack) {
    $("footer").html(OM.talkingToServer_animation("Saving")).addClass("show"), $("#page").addClass("footer"), 
    OM.get_data(php_page, post_data, function(data) {
        1 == data.login && ("success" == data.status ? (callBack(data), $("footer").html(OM.doneTalkingToServer("Saved")), 
        setTimeout(function() {
            $("footer").html("").removeClass("show"), $("#page").removeClass("footer");
        }, 3e3)) : "error" == data.status && (OM.Modal.new("saved-" + page_name, OM.Modal.format("Error: Saving", OM.Button.close({
            page_name: "saved-" + page_name,
            color: !0,
            icon: !0
        }), OM.message("<h3>" + data.message + "</h3><p><u>Error message:</u> " + data.error + "</p>"))), 
        $("footer").html("").removeClass("show"), $("#page").removeClass("footer")));
    });
}, OM.Modal.remove = function(page_name, php_page, data, callBack) {
    $("footer").html(OM.talkingToServer_animation("Removing")).addClass("show"), $("#page").addClass("footer"), 
    OM.get_data(php_page, data, function(data) {
        1 == data.login && ("success" == data.status ? (callBack(data), $("footer").html(OM.doneTalkingToServer("Removed")), 
        setTimeout(function() {
            $("footer").html("").removeClass("show"), $("#page").removeClass("footer");
        }, 2e3)) : "error" == data.status && OM.Modal.new("removed-" + page_name, OM.Modal.format("Error: Removing", OM.Button.close({
            page_name: "removed-" + page_name,
            color: !0,
            icon: !0
        }), OM.message("<h3>" + data.message + "</h3><p><u>Error message:</u> " + data.error + "</p>"))));
    }, "post");
}, OM.Modal.fix_postion = function(id) {
    var dialog_fix = function(id) {
        var margin_top = Math.abs($("#dialog-" + id + "-content").height() / 2), margin_left = Math.abs($("#dialog-" + id + "-content").width() / 2), max_height = Math.abs($(window).height()), max_height_section = Math.abs(max_height - $("#dialog-" + id + "-content header").height());
        $("#dialog-" + id + "-content").find("header").length > 0, $("#dialog-" + id + "-content").css({
            "margin-top": "-" + margin_top + "px",
            "margin-left": "-" + margin_left + "px",
            "max-height": max_height + "px"
        }), $("#dialog-" + id + "-content section").css({
            "max-height": max_height_section + "px"
        });
    };
    if (id && void 0 != id) dialog_fix(id); else for (var i = 0; i < $(".dialog-content").length; i++) id = $(".dialog-content").eq(i).attr("data-id"), 
    dialog_fix(id);
}, setInterval(function() {
    OM.Modal.fix_postion();
}, 100), OM.Page.format = function(header_left, header_center, header_right, page, footer) {
    $("body").scrollTop(0), "setup" !== header_left && $("#top-left").html(OM.menu_btn + header_left), 
    OM.is_empty(header_center) || $("#top-center").html(header_center), $("#top-right").html(OM.is_empty(header_right) ? "" : header_right), 
    OM.is_empty(page) || $("#page").html(page), $("footer").html(OM.is_empty(footer) ? "" : footer);
}, OM.Page.row = function(rows, attr) {
    var row = "", content = "", a = 0, b = 0;
    for (a = 0; a < rows.length; a++) {
        for (content = "", b = 1; b <= rows[a].length - 1; b++) content += "i" == rows[a][b][0] ? rows[a][b][1] : "link" == rows[a][b][0] ? rows[a][b][1] : '<div class="' + rows[a][b][0] + '">' + rows[a][b][1] + "</div>";
        row += "<li " + rows[a][0].attr + ">" + content + "</li>";
    }
    return "<ul " + attr + ">" + row + "</ul>";
}, OM.Page.tabNav = function(t) {
    for (var a = 0, c = ""; a < t.length; a++) void 0 == t[a].active ? t[a].active = "" : "", 
    c += '<li class="' + t[a].active + '"><a href="' + t[a].link + '">' + t[a].name + "</a></li>";
    return '<ul data-tabNav="' + t.length + '">' + c + "</ul>";
}, OM.Page.error = function(num, type) {
    return 404 == num ? "dialog" == type ? OM.Modal.new("error-page-404", OM.Modal.format("Page not found", OM.Button.close({
        page_name: "error-page-404",
        color: !0,
        icon: !0
    }), '<div id="error-page"><h1>404 - File not found</h1><p>The resource you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p></div>')) : OM.Page.format(OM.back_btn("javascript:window.history.back();"), "Page not found", "", '<div id="error-page"><h1>404 - File not found</h1><p>The resource you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p></div>') : 403 == num ? "dialog" == type ? OM.Modal.new("error-page-403", OM.Modal.format("Access is denied", OM.Button.close({
        page_name: "error-page-403",
        color: !0,
        icon: !0
    }), '<div id="error-page"><h1>403 - Forbidden</h1><p>You do not have permission to view this page using the credentials that you supplied.</p></div>')) : OM.Page.format(OM.back_btn("javascript:window.history.back();"), "Access is denied", "", '<div id="error-page"><h1>403 - Forbidden</h1><p>You do not have permission to view this page using the credentials that you supplied.</p></div>') : void 0;
}, OM.load_datepicker = function() {
    1 == OM.isMac;
}, OM.Page.login = function() {
    return '<div id="access"><div id="cardHolder"><img src="src/img/cardHolder.png"></div><h1>RC Vicharan</h1><section><form id="form-login"><h2>Login</h2><div id="message-login"></div><div id="login-form"><div class="input"><span><i class="fa fa-envelope-o"></i></span><input type="email" id="login-email" value="" placeholder="Email address" /></div><div class="input"><span><i class="fa fa-key"></i></span><input type="password" id="login-password" value="" placeholder="Password" /></div><div class="btn"><button type="submit" data-button data-color="green">Login</button></div></div><div id="login-done"><p>Please wait while we load the website.</p>' + OM.loading_circle + '</div><p class="back-link">Forgot Password?</p></form><form id="form-forgot-password" style="display:none;"><div id="forgot-password-form"><h2>Forgot Password</h2><div id="message-forgot-password"></div><div class="input"><span><i class="fa fa-envelope-o"></i></span><input type="email" id="forgot-password-email" value="" placeholder="Email address" /></div><div class="btn"><button type="submit" data-button data-color="green">Reset Password</button></div></div><div id="forgot-password-done"><h2>Emailed!</h2><p>Please check your email for reset password link.</p></div><p class="back-link">Login</p></form></section><div id="copyright">Copyright &copy; ' + OM.Date.year_full() + " BAPS Satsang Activities. All Rights Reserved</div></div>";
}, OM.Page.reset_password = function(id) {
    var page_name = "reset-password", content = "";
    OM.Modal.loading(page_name), OM.get_data(OM.process + "index.php", {
        code: "reset-password",
        id: id
    }, function(a) {
        content = 1 == a.setup ? '<div id="access"><div id="cardHolder"><img src="img/cardHolder.png"></div><h1>RC Vicharan</h1><section><form id="' + page_name + '"><div id="' + page_name + '-form"><h2>Reset Password</h2><div id="message-' + page_name + '"></div><div class="input"><span><i class="fa fa-key"></i></span><div class="value"><input type="password" id="' + page_name + '-new" value="" placeholder="new password"></div></div><div class="input"><span><i class="fa fa-thumbs-o-up"></i></span><div class="value"><input type="password" id="' + page_name + '-confirm" value="" placeholder="Confirm password"></div></div><div class="btn"><div class="btn"><button type="submit" data-button data-color="green">Update</button></div></div><input type="hidden" id="' + page_name + '-uid" value="' + a.uid + '"></div><div id="' + page_name + '-done"><h2>Reset!</h2><p>Your password has been successfully reset. Please click login to return to the login page.</p></div><a href="' + OM.domain + '" class="back-link">Login</a></form></section><div id="copyright">Copyright &copy; ' + OM.Date.year_full() + " BAPS Satsang Activities. All Rights Reserved</div></div>" : '<div id="access"><div id="cardHolder"><img src="img/cardHolder.png"></div><h1>RC Vicharan</h1><section><h2>Invalid Link</h2><p>We apologize, but we are unable to verify the link you used to access this page. Please click Continue to return to the home page and start over.</p><div class="btn"><a class="block" data-button data-color="dark-blue" href="' + OM.domain + '#">Continue</a></div></section><div id="copyright">Copyright &copy; ' + OM.Date.year_full() + " BAPS Satsang Activities. All Rights Reserved</div></div>", 
        OM.Modal.close(page_name), OM.body.html(content);
    });
}, OM.Page.nav = function() {
    var admin_links = "", home_icon_link = "", check_list_link = "";
    return OM.session.ul <= OM.select.user_level_value[4] && (admin_links = '<a href="' + OM.domain + '#admin/"><i class="fa fa-user"></i>Admin</a>'), 
    (1 == OM.ios || 1 == OM.android) && (home_icon_link = '<a href="' + OM.domain + '#settings/home-icon/"><i class="fa fa-th-large"></i>Add to Home Screen</a>'), 
    "M" == OM.session.gender && (check_list_link = '<a href="' + OM.domain + '#check-list/"><i class="fa fa-check-square-o"></i>Check List</a>'), 
    '<aside class="nano"><div class="nano-content"><header>' + OM.session.fn + " " + OM.session.ln + '</header><nav><a href="' + OM.domain + '#check-in/"><i class="fa fa-map-marker"></i>Check-in</a><a href="' + OM.domain + '#my-vicharan/"><i class="fa fa-calendar"></i>My Vicharan</a><a href="' + OM.domain + '#vicharan-notes/"><i class="fa fa-comments-o"></i>Vicharan Notes</a><a href="' + OM.domain + '#my-goals/"><i class="fa fa-flag"></i>Year Goals</a><a href="' + OM.domain + '#reports/"><i class="fa fa-bar-chart-o"></i>My Vicharan Snapshot</a>' + check_list_link + '<a href="http://prasa.ng/" target="_blank"><i class="fa fa-chain"></i>Prasangs</a>' + admin_links + home_icon_link + '<a href="' + OM.domain + '#settings/"><i class="fa fa-cogs"></i>Settings</a><div class="child"><a href="' + OM.domain + '#settings/profile/"><i class="fa fa-level-up fa-rotate-90"></i>Profile</a><a href="' + OM.domain + '#settings/password/"><i class="fa fa-level-up fa-rotate-90"></i>Reset Password</a><a href="' + OM.domain + '#settings/check-in/"><i class="fa fa-level-up fa-rotate-90"></i>Check-in History</a><a href="' + OM.domain + '#settings/gcal/"><i class="fa fa-level-up fa-rotate-90"></i>Sync to Calendar</a></div><a href="' + OM.domain + '#logout/"><i class="fa fa-lock"></i>Logout</a><p>Copyright &copy; ' + OM.Date.year_full() + " BAPS Satsang Activities<br>All Rights Reserved</p></nav></div></aside>";
}, OM.Page.setup_welcome = function() {
    var li_icon_1 = "", li_icon_2 = "", li_icon_3 = "", li_icon_4 = "", content = "", icon_check = '<i class="fa fa-check-square-o"></i>';
    return OM.session.setup < OM.setup - 1 ? (OM.session.setup > 0 && (li_icon_1 = icon_check), 
    OM.session.setup > 1 && (li_icon_2 = icon_check), OM.session.setup > 2 && (li_icon_3 = icon_check), 
    OM.session.setup > 3 && (li_icon_4 = icon_check), content = "<div data-card><h3>Welcome " + OM.session.fn + " " + OM.session.ln + ' to Mobile Vicharan Site.</h3><br><p>We like to take a moment to update your account.</p><ul data-list><li><div>Profile</div><div data-text="right">' + li_icon_1 + '</div></li><li><div>Password</div><div data-text="right">' + li_icon_2 + '</div></li><li><div>Vicharan Centers</div><div data-text="right">' + li_icon_3 + '</div></li><li><div>Vicharan Goals</div><div data-text="right">' + li_icon_4 + '</div></li></ul><div class="text-center"><button data-href="' + OM.domain + '#setup/" data-button data-color="orange">Begin</button></div></div>') : content = "<div data-card><h3>Thank you! " + OM.session.fn + " " + OM.session.ln + '</h3><br><p>Thank you for your time to update your account.</p><ul data-list="li-icon"><li><div>Profile</div><div data-text="right">' + icon_check + '</div></li><li><div>Password</div><div data-text="right">' + icon_check + '</div></li><li><div>Vicharan Centers</div><div data-text="right">' + icon_check + '</div></li><li><div>Vicharan Goals</div><div data-text="right">' + icon_check + '</div></li></ul><div class="text-center"><button data-href="' + OM.domain + '#check-in/" id="setup-next" data-setup_pg="5" data-button data-color="blue"><i class="fa fa-map-marker"></i> Check-in!</button></div></div>', 
    OM.Page.format("setup", "Setup", "", content);
}, OM.Page.setup_start = function() {
    var content = "Coming Soon", page_name = "setup-", title = "", top_right = "";
    if (0 == OM.session.setup) page_name += "profile", title = " - Profile", content = '<form id="' + page_name + '" data-card>' + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "First Name"), Array("value", '<input id="' + page_name + '-first_name" placeholder="First Name" value="' + OM.session.fn + '" type="text" spellcheck="false" />')), Array({
        attr: ""
    }, Array("field", "Last Name"), Array("value", '<input id="' + page_name + '-last_name" placeholder="Last Name" value="' + OM.session.ln + '" type="text" spellcheck="false" />')), Array({
        attr: ""
    }, Array("field", "Email Address"), Array("value", '<div class="note">This will be you username</div><div><input id="' + page_name + '-email" placeholder="Email Address" value="' + OM.session.e + '" type="email" spellcheck="false" /></div>')), Array({
        attr: ""
    }, Array("field", "Region"), Array("value", OM.Form.built_select_box(page_name + "-region", OM.select.region, OM.select.region, "Select Region", OM.session.region, 'class="get-center-by-region" data-page_name="' + page_name + '" data-center="' + OM.session.center + '"'))), Array({
        attr: 'id="' + page_name + '-all-center" class="hidden"'
    }, Array("field", "Center"), Array("value", '<select id="' + page_name + '-region-center"></select>'))), 'data-list="form"') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Update"
    }) + "</div></form>", setTimeout(function() {
        $("#" + page_name + "-region").trigger("change");
    }, 100); else if (1 == OM.session.setup) page_name += "password", title = " - Password", 
    content = '<form id="' + page_name + '" data-card>' + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "New Password"), Array("value", '<input type="password" id="' + page_name + '-new" value="">')), Array({
        attr: ""
    }, Array("field", "Confirm New Password"), Array("value", '<input type="password" id="' + page_name + '-confirm" value="">'))), 'data-list="form"') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Update"
    }) + "</div></form>"; else if (2 == OM.session.setup) page_name += "center", title = "- Vicharan Centers", 
    top_right = '<button type="button" id="setup-next" data-setup_pg="3" data-color="orange">Next</button>', 
    content = '<form id="' + page_name + '" data-card><h3>Please Select your <strong>vicharan</strong> center</h3><br>' + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Region"), Array("value", OM.Form.built_select_box(page_name + "-region", OM.select.region, OM.select.region, "Select Region", "", 'class="get-center-by-region" data-page_name="' + page_name + '"'))), Array({
        attr: ""
    }, Array("field", "Center"), Array("value", '<select id="' + page_name + '-region-center"></select>'))), 'data-list="form"') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Add"
    }) + '</div></form><button class="hidden" id="' + page_name + '-reload-list"></button>', 
    content += '<div id="' + page_name + '-list" data-card></div>', setTimeout(function() {
        $("#" + page_name + "-reload-list").trigger("click");
    }, 200); else if (3 == OM.session.setup) {
        page_name += "goal", title = " - Vicharan Goals", top_right = '<button type="button" id="setup-next" data-setup_pg="4" data-color="orange">Next</button>';
        var year_show = "";
        OM.Date.month() < 11 && (year_show = 'class="hidden"'), content = '<form id="' + page_name + '" data-card>' + OM.Page.row(Array(Array({
            attr: 'id="' + page_name + '-assign-center"'
        }, Array("field", "Center"), Array("value", OM.Form.select_assign_center(page_name + "-center", "", ""))), Array({
            attr: ""
        }, Array("field", "Goal"), Array("value", '<input type="number" id="' + page_name + '-goal" value="" min="1" max="99">')), Array({
            attr: year_show
        }, Array("field", "Year"), Array("value", OM.Form.year(page_name + "-year", OM.Date.year_full(), "")))), 'data-list="form"') + '<div class="btn">' + OM.Button.save({
            page_name: page_name,
            color: !0,
            icon: !0,
            text: "Add"
        }) + '</div></form><button class="hidden" id="' + page_name + '-reload-list"></button>', 
        content += '<div id="' + page_name + '-list" data-card></div>', setTimeout(function() {
            $("#" + page_name + "-reload-list").trigger("click");
        }, 200);
    }
    OM.session.setup < OM.setup - 1 ? OM.Page.format("setup", "Setup" + title, top_right, content) : OM.Page.setup_welcome();
}, OM.Page.auto_pass = function() {
    var page_name = "auto-pass";
    OM.Page.format("setup", "Auto Password", "", '<div data-card><h3>You are using auto password to login to website.</h3><br><p>Please update your password for security purpose.</p><form id="form-' + page_name + '">' + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "New Password"), Array("value", '<input type="password" id="' + page_name + '-new" value="">')), Array({
        attr: ""
    }, Array("field", "Confirm New Password"), Array("value", '<input type="password" id="' + page_name + '-confirm" value="">'))), 'data-list="form"') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Submit"
    }) + "</div></form></div>");
}, OM.Page.check_in = function(options) {
    options = void 0 == options ? options = new Object() : options, options.date = void 0 != options.date ? options.date : OM.Date.today(), 
    options.type = void 0 != options.type ? options.type : "", options.back_link = void 0 != options.back_link ? options.back_link : "", 
    options.history = void 0 != options.history ? !1 : !0, options.center = void 0 != options.center ? options.center : "", 
    options.region = void 0 != options.region ? options.region : "", options.sabha = void 0 != options.sabha ? options.sabha : "";
    var page_name = "check-in", content = "", check_in_history = "", loop_stop = 0;
    if (options.history && OM.Database.check(OM.myCheckIn) && OM.myCheckIn.length > 0) {
        loop_stop = OM.myCheckIn.length > 5 ? 5 : OM.myCheckIn.length;
        for (var a = 0; loop_stop > a; a++) row = OM.myCheckIn[a], 0 == a && (check_in_history += "<ul data-list data-card>", 
        check_in_history += '<li data-title><div class="text-center">Add your vicharan notes</div></li>', 
        check_in_history += '<li data-help><div class="text-right"><span data-color="dark-teal">No notes</span>&nbsp;&nbsp;<span data-color="dark-blue">Edit notes</span></div></li>'), 
        check_in_history += '<li><div class="detail"><div class="title"><strong>' + row.center + "</strong>(" + row.sabha_type + ") - <em>" + row.region + '</em></div><div class="note">' + row.datetime + '</div></div><div data-btn="right">' + OM.Button.edit({
            page_name: page_name + "-comment",
            color: "" != row.vicharan_note_id ? "dark-blue" : !0,
            icon: !0,
            attr: 'data-href="' + OM.domain + "#check-in/" + row.index + '/"'
        }) + "</div></li>", check_in_history += a == loop_stop - 1 ? "</ul>" : "";
    }
    content = '<form id="' + page_name + '" novalidate>' + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Date"), Array("value", '<input type="date" id="' + page_name + '-date" value="' + options.date + '" required>')), Array({
        attr: 'id="' + page_name + '-assign-center"'
    }, Array("field", "Center"), Array("value", OM.Form.select_assign_center({
        page_name: page_name + "-center",
        attr: "required",
        other_center: !0,
        other: !0,
        selected: options.center
    }))), Array({
        attr: ' id="' + page_name + '-all-region" class="hidden"'
    }, Array("field", "Region"), Array("value", OM.Form.built_select_box(page_name + "-region", OM.select.region, OM.select.region, "Select Region", options.region, 'class="get-center-by-region" data-page_name="' + page_name + '" data-center="' + options.center + '" data-sabha="' + options.sabha + '" required'))), Array({
        attr: ' id="' + page_name + '-all-center" class="hidden"'
    }, Array("field", "Center"), Array("value", '<select id="' + page_name + '-region-center" required></select>')), Array({
        attr: ' id="' + page_name + '-other-option" class="hidden"'
    }, Array("field", "Other"), Array("value", OM.Form.built_select_box(page_name + "-other", OM.select.other_option, OM.select.other_option, "Select Option", "", "required"))), Array({
        attr: ' id="' + page_name + '-sabha_type" class="hidden"'
    }, Array("field", "Sabha Type"), Array("value", '<select id="' + page_name + '-sabha" required></select>')), Array({
        attr: 'class="hidden"'
    }, Array("field", "Check-in Type"), Array("value", '<input data-not type="hidden" id="' + page_name + '-type" value="' + options.type + '" disabled>'))), 'data-list="form"') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: '<i class="fa fa-map-marker"></i> ',
        text: "Check-in"
    }) + "</div></form>", "dialog" == options.type ? OM.Modal.new(page_name, OM.Modal.format("Check-In", OM.Button.close({
        page_name: page_name,
        color: !0,
        icon: !0
    }), content)) : OM.Page.format(options.back_link, "Check-In", "", "<div data-card>" + content + "</div>" + check_in_history);
}, OM.Page.check_in_vicharan_note = function(index) {
    var page_name = "check-in-comment", data = OM.myCheckIn[index], center = "", content = "";
    OM.myCheckIn[index] ? (center = " - " + data.center, content = Array(Array({
        attr: ""
    }, Array("field", "Date"), Array("value", data.datetime)), Array({
        attr: ""
    }, Array("field", "Center"), Array("value", data.center + "(" + data.sabha_type + ") - <em>" + data.region + "</em>")), Array({
        attr: 'class="hidden"'
    }, Array("field", "Region"), Array("value", '<input type="hidden" id="' + page_name + '-region" value="' + data.region + '" data-show="confirm">')), Array({
        attr: 'class="hidden"'
    }, Array("field", "Center"), Array("value", '<input type="hidden" id="' + page_name + '-center" value="' + data.center + '" data-show="confirm">')), Array({
        attr: 'class="hidden"'
    }, Array("field", "Sabha Type"), Array("value", '<input type="hidden" id="' + page_name + '-sabha" value="' + data.sabha_type + '" data-show="confirm">')), Array({
        attr: ""
    }, Array("field", "Positive Points"), Array("value", '<textarea data-group="1" id="' + page_name + '-positive_points" required>' + data.positive_points + "</textarea>")), Array({
        attr: ""
    }, Array("field", "Issues"), Array("value", '<textarea data-group="1" id="' + page_name + '-issues" required>' + data.issues + "</textarea>")), Array({
        attr: ""
    }, Array("field", "Follow Up List"), Array("value", '<textarea data-group="1" id="' + page_name + '-follow_up_list" required>' + data.follow_up_list + "</textarea>")), Array({
        attr: ""
    }, Array("field", "Other/General Comment"), Array("value", '<textarea data-group="1" id="' + page_name + '-other_comment" required>' + data.other_comment + "</textarea>"))), 
    "" == data.vicharan_note_id && (content[content.length] = Array({
        attr: ""
    }, Array("field", "Email P. Sant/RMC"), Array("value", '<div class="checkbox yes-no"><input type="checkbox" id="' + page_name + '-email" value="Y" placehoder="Email P. Sant/RMC"><label for="' + page_name + '-email"><div class="inner"></div><div class="btn-switch"></div></label></div><div class="note">After comfirming this comment it will be send to P. Santos/RMC who are doing vicharan in ' + data.center + ".</div>"))), 
    content = '<form id="' + page_name + '" data-card data-index="' + index + '" novalidate>' + OM.Page.row(content, 'data-list="form"') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: '<i class="fa fa-comments-o"></i> ',
        text: "Submit"
    }) + "</div></form>") : content = "Sorry! we can not read the data.", OM.Page.format(OM.back_btn(OM.domain + "#check-in/"), "Vicharan Notes" + center, "", content), 
    OM.nicEditor(page_name + "-positive_points"), OM.nicEditor(page_name + "-issues"), 
    OM.nicEditor(page_name + "-follow_up_list"), OM.nicEditor(page_name + "-other_comment");
}, OM.Page.my_vicharan = function(date) {
    date = void 0 == date || "" == date ? null : date;
    var page_name = "my-vicharan";
    OM.Page.format("", "My Vicharan", OM.Button.add({
        page_name: page_name,
        color: !1,
        icon: '<i class="fa fa-map-marker"></i>',
        attr: "onClick=\"javascript:OM.Page.check_in('" + OM.Date.today() + "','dialog');\" data-date=\"\""
    }) + OM.Button.add({
        page_name: page_name,
        color: !1,
        icon: !0,
        attr: 'onClick="javascript:OM.Page.plan_my_vicharan();" data-date=""'
    }), '<div id="' + page_name + '-body"></div>'), $(document).flatCalendar({
        events: OM.myVicharanEvents,
        id: page_name + "-body",
        no_event: "my-text",
        selected_date: date,
        buttonText: {
            prev: '<i class="fa fa-chevron-left"></i>',
            next: '<i class="fa fa-chevron-right"></i>',
            "delete": OM.Button.remove({
                page_name: page_name,
                color: !0,
                icon: !0
            })
        }
    });
}, OM.Page.plan_my_vicharan = function(date) {
    var page_name = "my-vicharan";
    void 0 == date && (date = OM.Date.today()), OM.Modal.new(page_name, OM.Modal.format("Plan Vicharan", OM.Button.close({
        page_name: page_name,
        color: !0,
        icon: !0
    }), '<form id="' + page_name + '" novalidate>' + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Date"), Array("value", '<input type="date" id="' + page_name + '-date" value="' + date + '" class="datepicker" required>')), Array({
        attr: 'id="' + page_name + '-assign-center"'
    }, Array("field", "Center"), Array("value", OM.Form.select_assign_center(page_name + "-center", "required", !0, !0))), Array({
        attr: ' id="' + page_name + '-all-region" class="hidden"'
    }, Array("field", "Region"), Array("value", OM.Form.built_select_box(page_name + "-region", OM.select.region, OM.select.region, "Select Region", "", 'class="get-center-by-region" data-page_name="' + page_name + '" required'))), Array({
        attr: ' id="' + page_name + '-all-center" class="hidden"'
    }, Array("field", "Center"), Array("value", '<select id="' + page_name + '-region-center" required></select>')), Array({
        attr: ' id="' + page_name + '-other-option" class="hidden"'
    }, Array("field", "Other"), Array("value", OM.Form.built_select_box(page_name + "-other", OM.select.other_option, OM.select.other_option, "Select Option", "", "required"))), Array({
        attr: ' id="' + page_name + '-sabha_type" class="hidden"'
    }, Array("field", "Sabha Type"), Array("value", '<select id="' + page_name + '-sabha" required></select>'))), 'data-list="form"') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        text: "Submit",
        icon: !0
    }) + "</div></form>"));
}, OM.Page.vicharan_notes = function() {
    var content = "";
    if (null == OM.vicharanNotes || void 0 == OM.vicharanNotes) OM.Page.error(404); else if (OM.vicharanNotes.length > 0) for (var mandal = OM.vicharanNotes, a = 0; a < mandal.length; a++) {
        if (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) {
            var show = "hide";
            if (0 == a) {
                show = "show";
                for (var tab = 0; tab < mandal.length; tab++) {
                    var active = "";
                    0 == tab && (content += '<ul data-tabNav="' + mandal.length + '">', active = "active"), 
                    content += '<li data-tabContent-id="' + mandal[tab].mandal + '" class="' + active + '"><div>' + mandal[tab].mandal + "</div></li>", 
                    tab == mandal.length - 1 && (content += "</ul><div data-tabContentParent>");
                }
            }
            content += '<div class="' + show + '" data-tabContent="' + mandal[a].mandal + '">';
        }
        content += "<div data-card>";
        for (var regions = mandal[a].regions, b = 0; b < regions.length; b++) {
            regions.length > 1 && (0 == b && (content += '<ul data-list="nest" data-colorName="inverse">'), 
            content += '<li><div data-title="region-' + b + '"><u class="fa fa-globe"></u>' + regions[b].region + '<i class="fa fa-caret-up"></i></div><div data-content="region-' + b + '">');
            for (var centers = regions[b].centers, c = 0; c < centers.length; c++) 0 == c && (content += '<ul data-list="link">'), 
            content += '<li><a href="' + OM.domain + "#vicharan-notes/" + a + "-" + b + "-" + c + '/">' + centers[c].center + '</a><i class="fa fa-chevron-right"></i></li>', 
            c == centers.length - 1 && (content += "</ul>");
            regions.length > 1 && (content += "</div></li>", b == regions.length - 1 && (content += "</ul>"));
        }
        content += "</div>", (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) && (content += "</div>"), 
        a == mandal.length - 1 && (content += "</div>");
    } else content = '<div style="text-align:right; position:relative;"><i class="fa fa-level-up" style="font-size:10em; margin-right:5px;"></i><div style="position:absolute; bottom:30px; right:90px; font-size:2em; width:170px; line-height:1em;">Click here to add vicharan note</div></div>';
    OM.Page.format("", "Vicharan Notes", OM.Button.add({
        color: !1,
        icon: !0,
        attr: 'data-href="' + OM.domain + '#vicharan-notes/add/"'
    }), content);
}, OM.Page.vicharan_note_read = function(indexs) {
    var content = "", indexs = indexs.split("-");
    if (null == OM.vicharanNotes || void 0 == OM.vicharanNotes) OM.Page.error(404); else if (OM.vicharanNotes.length > 0) for (var rows = OM.vicharanNotes[indexs[0]].regions[indexs[1]].centers[indexs[2]].sabha_types, a = 0; a < rows.length; a++) {
        var row = rows[a];
        if (rows.length > 0) {
            var show = "hide";
            if (0 == a) {
                show = "show";
                for (var b = 0; b < rows.length; b++) {
                    var active = "";
                    0 == b && (content += '<ul data-tabNav="' + rows.length + '">', active = "active"), 
                    content += '<li data-tabContent-id="' + OM.replace_space(rows[b].sabha_type) + '" class="' + active + '"><div>' + rows[b].sabha_type + "</div></li>", 
                    b == rows.length - 1 && (content += "</ul><div data-tabContentParent>");
                }
            }
            content += '<div class="' + show + '" data-tabContent="' + OM.replace_space(row.sabha_type) + '">';
        }
        for (var c = 0; c < row.comments.length; c++) {
            var comment = row.comments[c];
            content += '<div data-list="comment" data-card>', "" !== comment.positive_points && (content += "<p><strong>Positive Points:</strong> " + comment.positive_points + "</p>"), 
            "" !== comment.issues && (content += "<p><strong>Issues:</strong> " + comment.issues + "</p>"), 
            "" !== comment.follow_up_list && (content += "<p><strong>Follow Up List:</strong> " + comment.follow_up_list + "</p>"), 
            "" !== comment.other_comment && (content += "<p><strong>Other/General Comment:</strong> " + comment.other_comment + "</p>"), 
            content += '<div class="footer"><span>' + comment.name + "</span><span>" + comment.date + "</span></div></div>";
        }
        rows.length > 1 && (content += "</div>"), a == rows.length - 1 && (content += "</div>");
    }
    OM.Page.format(OM.back_btn(OM.domain + "#vicharan-notes/"), OM.vicharanNotes[indexs[0]].regions[indexs[1]].centers[indexs[2]].center + " Notes", "", content);
}, OM.Page.add_vicharan_note = function() {
    var page_name = "vicharan-notes";
    OM.Page.format(OM.back_btn(OM.domain + "#vicharan-notes/"), "Add Vicharan Notes", "", '<form id="form-' + page_name + '" data-card>' + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Date"), Array("value", '<input type="date" id="' + page_name + '-date" value="' + OM.Date.today() + '" class="datepicker">')), Array({
        attr: 'id="' + page_name + '-assign-center"'
    }, Array("field", "Center"), Array("value", OM.Form.select_assign_center(page_name + "-center", "", !0))), Array({
        attr: ' id="' + page_name + '-all-region" class="hidden"'
    }, Array("field", "Region"), Array("value", OM.Form.built_select_box(page_name + "-region", OM.select.region, OM.select.region, "Select Region", "", 'class="get-center-by-region" data-page_name="' + page_name + '"'))), Array({
        attr: ' id="' + page_name + '-all-center" class="hidden"'
    }, Array("field", "Center"), Array("value", '<select id="' + page_name + '-region-center"></select>')), Array({
        attr: ' id="' + page_name + '-sabha_type" class="hidden"'
    }, Array("field", "Mandal"), Array("value", "")), Array({
        attr: ""
    }, Array("field", "Positive Points"), Array("value", '<textarea id="' + page_name + '-positive_points"></textarea>')), Array({
        attr: ""
    }, Array("field", "Issues"), Array("value", '<textarea id="' + page_name + '-issues"></textarea>')), Array({
        attr: ""
    }, Array("field", "Follow Up List"), Array("value", '<textarea id="' + page_name + '-follow_up_list"></textarea>')), Array({
        attr: ""
    }, Array("field", "Other/General Comment"), Array("value", '<textarea id="' + page_name + '-other_comment"></textarea>')), Array({
        attr: ""
    }, Array("field", "Email P. Sant/RMC"), Array("value", '<div class="checkbox yes-no"><input type="checkbox" id="' + page_name + '-email" value="Y" placehoder="Email P. Sant/RMC"><label for="' + page_name + '-email"><div class="inner"></div><div class="btn-switch"></div></label></div>'))), 'data-list="form"') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: '<i class="fa fa-comments-o"></i> ',
        text: "Submit"
    }) + "</div></form>"), OM.load_datepicker();
}, OM.Page.my_goals = function() {
    var page_name = "my-goals", content = "";
    if (null == OM.myGoals || void 0 == OM.myGoals) OM.Page.error(404); else if (OM.myGoals.length > 0) for (var mandal = OM.myGoals, a = 0; a < mandal.length; a++) {
        if (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) {
            var show = "hide";
            if (0 == a) {
                show = "show";
                for (var tab = 0; tab < mandal.length; tab++) {
                    var active = "";
                    0 == tab && (content += '<ul data-tabNav="' + mandal.length + '">', active = "active"), 
                    content += '<li data-tabContent-id="' + mandal[tab].mandal + '" class="' + active + '"><div>' + mandal[tab].mandal + "</div></li>", 
                    tab == mandal.length - 1 && (content += "</ul><div data-tabContentParent>");
                }
            }
            content += '<div data-tabContent="' + mandal[a].mandal + '" class="' + show + '">';
        }
        for (var years = mandal[a].years, b = 0; b < years.length; b++) {
            if (years.length > 1) {
                var show = "hide";
                if (0 == b) {
                    show = "show";
                    for (var tab = 0; tab < years.length; tab++) {
                        var active = "";
                        0 == tab && (content += '<ul data-tabNav="' + years.length + '">', active = "active"), 
                        content += '<li data-tabContent-id="' + years[tab].year + '" class="' + active + '"><div>' + years[tab].year + "</div></li>", 
                        tab == years.length - 1 && (content += "</ul>");
                    }
                }
                content += '<div data-tabContent="' + years[b].year + '" class="' + show + '">';
            }
            content += "<div data-card>";
            for (var regions = years[b].regions, c = 0; c < regions.length; c++) {
                (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (0 == c && (content += '<ul data-list="nest" data-colorName="inverse">'), 
                content += '<li><div data-title="region-' + c + '"><u class="fa fa-globe"></u>' + regions[c].region + '<i class="fa fa-caret-up"></i></div><div data-content="region-' + c + '">');
                for (var users = regions[c].users, regions_content = "", regions_goal = 0, regions_visted = 0, regions_percent = 0, d = 0; d < users.length; d++) {
                    (users.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (0 == d && (regions_content += '<ul data-list="list">'), 
                    regions_content += '<li data-color="gray" data-title><u class="fa fa-user"></u>' + users[d].user + "</li><li>");
                    for (var centers = users[d].centers, percent = 0, e = 0; e < centers.length; e++) regions_visted += parseInt(centers[e].visited), 
                    regions_goal += parseInt(centers[e].goal), percent = parseInt(centers[e].visited) ? parseInt(centers[e].visited) / parseInt(centers[e].goal) * 100 : 0, 
                    percent = Math.round(10 * percent) / 10, percent = parseFloat(percent.toFixed(2)), 
                    0 == e && (regions_content += '<ul data-list="list">'), regions_content += "<li><div>" + centers[e].center + '</div><div class="progress-bar"><div class="bar" style="width:' + percent + '%;"></div><div class="percent">' + percent + "% (" + centers[e].visited + ')</div></div><div data-btn="right"><button class="edit-my-goals" data-button data-color="dark-purple" data-id="' + centers[e].id + '" data-center="' + centers[e].center + '">' + centers[e].goal + "</button></div></li>", 
                    e == centers.length - 1 && (regions_content += "</ul>");
                    (users.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (regions_content += "</li>", 
                    d == users.length - 1 && (regions_content += "</ul>"));
                }
                regions_percent = regions_visted ? regions_visted / regions_goal * 100 : 0, regions_percent = Math.round(10 * regions_percent) / 10, 
                regions_percent = parseFloat(regions_percent.toFixed(2)), content += '<div class="progress-bar"><div class="bar" style="width:' + regions_percent + '%;"></div><div class="percent">' + regions_percent + "%</div></div>", 
                content += regions_content, (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (content += "</div></li>", 
                c == regions.length - 1 && (content += "</ul>"));
            }
            content += "</div>", years.length > 1 && (content += "</div>");
        }
        (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) && (content += "</div>"), 
        a == years.length - 1 && (content += "</div>");
    } else content = '<div style="text-align:right; position:relative;"><i class="fa fa-level-up" style="font-size:10em; margin-right:5px;"></i><div style="position:absolute; bottom:30px; right:90px; font-size:2em; width:170px; line-height:1em;">Click here to add vicharan note</div></div>';
    OM.Page.format("", "My Goals", OM.Button.add({
        page_name: page_name,
        color: !1,
        icon: !0,
        attr: 'onClick="javascript:OM.Page.add_my_goals();"'
    }), content, "");
}, OM.Page.add_my_goals = function() {
    var page_name = "my-goals", year_show = "";
    OM.Date.month() < 10 && (year_show = 'class="hidden"'), OM.Modal.new(page_name, OM.Modal.format("Add my goal", OM.Button.close({
        page_name: page_name,
        color: !0,
        icon: !0
    }), '<form id="form-' + page_name + '">' + OM.Page.row(Array(Array({
        attr: 'id="' + page_name + '-assign-center"'
    }, Array("field", "Center"), Array("value", OM.Form.select_assign_center(page_name + "-center", "", ""))), Array({
        attr: ""
    }, Array("field", "Goal"), Array("value", '<input type="number" id="' + page_name + '-goal" value="" min="1" max="99">')), Array({
        attr: year_show
    }, Array("field", "Year"), Array("value", OM.Form.year(page_name + "-year", OM.Date.year_full(), "")))), 'data-list="form"') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0
    }) + "</div></form>"));
}, OM.Page.reports = function() {
    var content = "";
    content = OM.session.ul <= parseInt(OM.select.user_level_value[4]) ? OM.Page.row(Array(Array({
        attr: ""
    }, Array("i", '<i class="float-right fa fa-chevron-right"></i>'), Array("link", '<a href="' + OM.domain + '#reports/individual/">Individual Progress</a>')), Array({
        attr: "data-title"
    }, Array("", "Checked-In Summary")), Array({
        attr: "data-indent"
    }, Array("i", '<i class="float-right fa fa-chevron-right"></i>'), Array("link", '<a href="' + OM.domain + '#reports/checked_in-rc/">RC</a>')), Array({
        attr: "data-indent"
    }, Array("i", '<i class="float-right fa fa-chevron-right"></i>'), Array("link", '<a href="' + OM.domain + '#reports/checked_in-date/">Date</a>')), Array({
        attr: "data-indent"
    }, Array("i", '<i class="float-right fa fa-chevron-right"></i>'), Array("link", '<a href="' + OM.domain + '#reports/checked_in-center/">Center</a>')), Array({
        attr: "data-title"
    }, Array("", "Planned Visits Summary")), Array({
        attr: "data-indent"
    }, Array("i", '<i class="float-right fa fa-chevron-right"></i>'), Array("link", '<a href="' + OM.domain + '#reports/planned-visits-rc/">RC</a>')), Array({
        attr: "data-indent"
    }, Array("i", '<i class="float-right fa fa-chevron-right"></i>'), Array("link", '<a href="' + OM.domain + '#reports/planned-visits-date/">Date</a>'))), 'data-list="link" data-card') : OM.Page.row(Array(Array({
        attr: ""
    }, Array("i", '<i class="float-right fa fa-chevron-right"></i>'), Array("link", '<a href="' + OM.domain + '#reports/individual/">Individual Summary</a>'))), 'data-list="link" data-card'), 
    OM.Page.format("", "My Vicharan Snapshot", "", content, "");
}, OM.Page.reports_individual = function() {
    var content = "";
    if (null == OM.myGoals || void 0 == OM.myGoals) OM.Page.error(404); else if (OM.myGoals.length > 0) for (var mandal = OM.myGoals, a = 0; a < mandal.length; a++) {
        if (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) {
            var show = "hide";
            if (0 == a) {
                show = "show";
                for (var tab = 0; tab < mandal.length; tab++) {
                    var active = "";
                    0 == tab && (content += '<ul data-tabNav="' + mandal.length + '">', active = "active"), 
                    content += '<li data-tabContent-id="' + mandal[tab].mandal + '" class="' + active + '"><div>' + mandal[tab].mandal + "</div></li>", 
                    tab == mandal.length - 1 && (content += "</ul><div data-tabContentParent>");
                }
            }
            content += '<div data-tabContent="' + mandal[a].mandal + '" class="' + show + '">';
        }
        for (var years = mandal[a].years, b = 0; b < years.length; b++) {
            if (years.length > 1) {
                var show = "hide";
                if (0 == b) {
                    show = "show";
                    for (var tab = 0; tab < years.length; tab++) {
                        var active = "";
                        0 == tab && (content += '<ul data-tabNav="' + years.length + '">', active = "active"), 
                        content += '<li data-tabContent-id="' + years[tab].year + '" class="' + active + '"><div>' + years[tab].year + "</div></li>", 
                        tab == years.length - 1 && (content += "</ul>");
                    }
                }
                content += '<div data-tabContent="' + years[b].year + '" class="' + show + '">';
            }
            content += "<div data-card>", content += '<table><thead><tr><th width="35%">Center</th><th width="20%">Goal</th><th width="20%">Visited</th><th width="25%">Remaining</th></tr></thead></table>';
            for (var regions = years[b].regions, c = 0; c < regions.length; c++) {
                (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (0 == c && (content += '<ul data-list="nest" data-colorName="inverse">'), 
                content += '<li><div data-title="region-' + c + '"><u class="fa fa-globe"></u>' + regions[c].region + '<i class="fa fa-caret-up"></i></div><div data-content="region-' + c + '">');
                for (var users = regions[c].users, d = 0; d < users.length; d++) {
                    (users.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (0 == d && (content += '<ul data-list="list">'), 
                    content += '<li data-color="gray" data-title><u class="fa fa-user"></u>' + users[d].user + "</li><li>");
                    for (var centers = users[d].centers, e = 0; e < centers.length; e++) {
                        0 == e && (content += "<table><tbody>");
                        var remain = 0;
                        remain = parseInt(centers[e].goal) - parseInt(centers[e].visited), 1 > remain && (remain = 0), 
                        content += '<tr><td width="35%">' + centers[e].center + '</td><td width="20%">' + centers[e].goal + '</td><td width="20%">' + centers[e].visited + '</td><td width="25%">' + remain + "</td></tr>", 
                        e == centers.length - 1 && (content += "</tbody></table>");
                    }
                    (users.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (content += "</li>", 
                    d == users.length - 1 && (content += "</ul>"));
                }
                (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (content += "</div></li>", 
                c == regions.length - 1 && (content += "</ul>"));
            }
            content += "</div>", years.length > 1 && (content += "</div>");
        }
        (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) && (content += "</div>"), 
        a == years.length - 1 && (content += "</div>");
    }
    OM.Page.format(OM.back_btn(OM.domain + "#reports/"), "Individual Summary", OM.Button.download({
        color: !1,
        icon: !0,
        attr: 'data-href="' + OM.process + 'reports-individual-export.php"'
    }), content, "");
}, OM.Page.reports_checked_in_rc = function() {
    var content = "";
    if (null == OM.checkedInUsers || void 0 == OM.checkedInUsers) OM.Page.error(404); else if (OM.checkedInUsers.length > 0) for (var mandal = OM.checkedInUsers, a = 0; a < mandal.length; a++) {
        if (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) {
            var show = "hide";
            if (0 == a) {
                show = "show";
                for (var tab = 0; tab < mandal.length; tab++) {
                    var active = "";
                    0 == tab && (content += '<ul data-tabNav="' + mandal.length + '">', active = "active"), 
                    content += '<li data-tabContent-id="' + mandal[tab].mandal + '" class="' + active + '"><div>' + mandal[tab].mandal + "</div></li>", 
                    tab == mandal.length - 1 && (content += "</ul><div data-tabContentParent>");
                }
            }
            content += '<div data-tabContent="' + mandal[a].mandal + '" class="' + show + '">';
        }
        content += "<div data-card>";
        for (var regions = mandal[a].regions, b = 0; b < regions.length; b++) {
            (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (0 == b && (content += '<ul data-list="nest" data-colorName="inverse">'), 
            content += '<li><div data-title="region-' + b + '"><u class="fa fa-globe"></u>' + regions[b].region + '<i class="fa fa-caret-up"></i></div><div data-content="region-' + b + '">');
            for (var users = regions[b].users, c = 0; c < users.length; c++) {
                (users.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (0 == c && (content += '<ul data-list="list">'), 
                content += '<li data-color="gray" data-title><u class="fa fa-user"></u>' + users[c].user + "</li><li>");
                for (var centers = users[c].centers, d = 0; d < centers.length; d++) 0 == d && (content += "<ul data-list>"), 
                content += '<li><div class="detail"><div class="title"><strong>' + centers[d].center + "</strong> - <em>" + centers[d].region + '</em></div><div class="note">' + centers[d].datetime + '</div></div><div data-text="right">' + centers[d].sabha_type + "</div></li>", 
                d == centers.length - 1 && (content += "</ul>");
                (users.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (content += "</li>", 
                c == users.length - 1 && (content += "</ul>"));
            }
            (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (content += "</div></li>", 
            b == regions.length - 1 && (content += "</ul>"));
        }
        content += "</div>", (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) && (content += "</div>"), 
        a == mandal.length - 1 && (content += "</div>");
    } else content = "&nbsp;";
    OM.Page.format(OM.back_btn(OM.domain + "#reports/"), "Checked-in by RC", OM.Button.download({
        color: !1,
        icon: !0,
        attr: 'data-href="' + OM.process + 'reports-rc-checked_in-history-export.php"'
    }), content, "");
}, OM.Page.reports_checked_in_center = function() {
    var content = "";
    if (null == OM.checkedInCenters || void 0 == OM.checkedInCenters) OM.Page.error(404); else if (OM.checkedInCenters.length > 0) for (var mandal = OM.checkedInCenters, a = 0; a < mandal.length; a++) {
        if (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) {
            var show = "hide";
            if (0 == a) {
                show = "show";
                for (var tab = 0; tab < mandal.length; tab++) {
                    var active = "";
                    0 == tab && (content += '<ul data-tabNav="' + mandal.length + '">', active = "active"), 
                    content += '<li data-tabContent-id="' + mandal[tab].mandal + '" class="' + active + '"><div>' + mandal[tab].mandal + "</div></li>", 
                    tab == mandal.length - 1 && (content += "</ul><div data-tabContentParent>");
                }
            }
            content += '<div data-tabContent="' + mandal[a].mandal + '" class="' + show + '">';
        }
        content += "<div data-card>";
        for (var regions = mandal[a].regions, b = 0; b < regions.length; b++) {
            (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (0 == b && (content += '<ul data-list="nest" data-colorName="inverse">'), 
            content += '<li><div data-title="region-' + b + '"><u class="fa fa-globe"></u>' + regions[b].region + '<i class="fa fa-caret-up"></i></div><div data-content="region-' + b + '">');
            for (var centers = regions[b].centers, c = 0; c < centers.length; c++) {
                (centers.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (0 == c && (content += '<ul data-list="list">'), 
                content += '<li data-color="gray" data-title><u class="fa fa-user"></u>' + centers[c].center + "</li><li>");
                for (var users = centers[c].users, d = 0; d < users.length; d++) 0 == d && (content += '<ul data-list="li-icon">'), 
                content += '<li><div class="detail"><div class="title">' + users[d].name + '</div><div class="note">' + users[d].datetime + '</div></div><div data-text="right">' + users[d].sabha_type + "</div></li>", 
                d == users.length - 1 && (content += "</ul>");
                (centers.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (content += "</li>", 
                c == centers.length - 1 && (content += "</ul>"));
            }
            (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (content += "</div></li>", 
            b == regions.length - 1 && (content += "</ul>"));
        }
        content += "</div>", (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) && (content += "</div>"), 
        a == mandal.length - 1 && (content += "</div>");
    }
    OM.Page.format(OM.back_btn(OM.domain + "#reports/"), "Checked-in by Center", OM.Button.download({
        color: !1,
        icon: !0,
        attr: 'data-href="' + OM.process + 'reports-center-checked_in-history-export.php"'
    }), content, "");
}, OM.Page.reports_checked_in_date = function() {
    var content = "";
    if (null == OM.checkedInDates || void 0 == OM.checkedInDates) OM.Page.error(404); else if (OM.checkedInDates.length > 0) for (var mandal = OM.checkedInDates, a = 0; a < mandal.length; a++) {
        if (mandal.length > 1 && OM.session.ul <= parseInt(OM.select.user_level_value[1])) {
            var show = "hide";
            if (0 == a) {
                show = "show";
                for (var tab = 0; tab < mandal.length; tab++) {
                    var active = "";
                    0 == tab && (content += '<ul data-tabNav="' + mandal.length + '">', active = "active"), 
                    content += '<li data-tabContent-id="' + mandal[tab].mandal + '" class="' + active + '"><div>' + mandal[tab].mandal + "</div></li>", 
                    tab == mandal.length - 1 && (content += "</ul>");
                }
                content += "<div data-tabContentParent>";
            }
            content += '<div data-tabContent="' + mandal[a].mandal + '" class="' + show + '">';
        }
        content += "<div data-card>";
        for (var dates = mandal[a].dates, b = 0; b < dates.length; b++) {
            (dates.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (0 == b && (content += '<ul data-list="list">'), 
            content += '<li data-color="gray" data-title><u class="fa fa-clock-o"></u>' + dates[b].date + "</li><li>");
            for (var users = dates[b].users, c = 0; c < users.length; c++) 0 == c && (content += "<ul data-list>"), 
            content += '<li><div class="detail"><div class="title">' + users[c].name + '</div><div class="note"><strong>' + users[c].center + "</strong> - <em>" + users[c].region + '</em></div></div><div data-text="right">' + users[c].sabha_type + "</div></li>", 
            c == users.length - 1 && (content += "</ul>");
            (dates.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (content += "</li>", 
            c == dates.length - 1 && (content += "</ul>"));
        }
        content += "</div>", mandal.length > 1 && OM.session.ul <= parseInt(OM.select.user_level_value[1]) && (content += "</div>"), 
        a == mandal.length - 1 && (content += "</div>");
    } else content = '<div id="error-page"><h1>There is nothing planed.</h1><p>You are looking this because RC have not planed any vicharan for upcoming dates.</p></div>';
    OM.Page.format(OM.back_btn(OM.domain + "#reports/"), "Checked-in by Date", "", content, "");
}, OM.Page.reports_planned_visits_rc = function() {
    var content = "";
    if (null == OM.plannedUsers || void 0 == OM.plannedUsers) OM.Page.error(404); else if (OM.plannedUsers.length > 0) for (var mandal = OM.plannedUsers, a = 0; a < mandal.length; a++) {
        if (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) {
            var show = "hide";
            if (0 == a) {
                show = "show";
                for (var tab = 0; tab < mandal.length; tab++) {
                    var active = "";
                    0 == tab && (content += '<ul data-tabNav="' + mandal.length + '">', active = "active"), 
                    content += '<li data-tabContent-id="' + mandal[tab].mandal + '" class="' + active + '"><div class="tab">' + mandal[tab].mandal + "</div></li>", 
                    tab == mandal.length - 1 && (content += "</ul>");
                }
                content += "<div data-tabContentParent>";
            }
            content += '<div data-tabContent="' + mandal[a].mandal + '" class="' + show + '">';
        }
        content += "<div data-card>";
        for (var regions = mandal[a].regions, b = 0; b < regions.length; b++) {
            (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (0 == b && (content += '<ul data-list="nest" data-colorName="inverse">'), 
            content += '<li><div data-title="region-' + b + '"><u class="fa fa-globe"></u>' + regions[b].region + '<i class="fa fa-caret-up"></i></div><div data-content="region-' + b + '">');
            for (var users = regions[b].users, c = 0; c < users.length; c++) {
                (users.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (0 == c && (content += '<ul data-list="list">'), 
                content += '<li data-color="gray" data-title><u class="fa fa-user"></u>' + users[c].name + "</li><li>");
                for (var planes = users[c].planes, d = 0; d < planes.length; d++) 0 == d && (content += "<ul data-list>"), 
                content += '<li><div class="detail"><div class="title"><strong>' + planes[d].center + "</strong> - <em>" + planes[d].region + '</em></div><div class="note">' + planes[d].date + '</div></div><div data-text="right">' + planes[d].sabha_type + "</div></li>", 
                d == planes.length - 1 && (content += "</ul>");
                (users.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (content += "</li>", 
                c == users.length - 1 && (content += "</ul>"));
            }
            (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (content += "</div></li>", 
            b == regions.length - 1 && (content += "</ul>"));
        }
        content += "</div>", mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1]) ? content += "</div>" : "", 
        a == mandal.length - 1 ? content += "</div>" : "";
    } else content = '<div id="error-page"><h1>There is nothing planed.</h1><p>You are looking this because RC have not planed any vicharan for upcoming dates.</p></div>';
    OM.Page.format(OM.back_btn(OM.domain + "#reports/"), "Planned Visits by RC", "", content, "");
}, OM.Page.reports_planned_visits_date = function() {
    var content = "";
    if (null == OM.plannedDates || void 0 == OM.plannedDates) OM.Page.error(404); else if (OM.plannedDates.length > 0) for (var mandal = OM.plannedDates, a = 0; a < mandal.length; a++) {
        if (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) {
            var show = "hide";
            if (0 == a) {
                show = "show";
                for (var tab = 0; tab < mandal.length; tab++) {
                    var active = "";
                    0 == tab && (content += '<ul data-tabNav="' + mandal.length + '">', active = "active"), 
                    content += '<li data-tabContent-id="' + mandal[tab].mandal + '" class="' + active + '"><div>' + mandal[tab].mandal + "</div></li>", 
                    tab == mandal.length - 1 && (content += "</ul>");
                }
                content += "<div data-tabContentParent>";
            }
            content += '<div data-tabContent="' + mandal[a].mandal + '" class="' + show + '">';
        }
        content += "<div data-card>";
        for (var dates = mandal[a].dates, b = 0; b < dates.length; b++) {
            (dates.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (0 == b && (content += '<ul class="list">'), 
            content += '<li data-color="gray" data-title><u class="fa fa-user"></u>' + dates[b].date + "</li>");
            var users = dates[b].users;
            content += "<li>";
            for (var c = 0; c < users.length; c++) 0 == c && (content += "<ul data-list>"), 
            content += '<li><div class="detail"><div class="title">' + users[c].name + '</div><div class="note"><strong>' + users[c].center + "</strong> - <em>" + users[c].region + '</em></div></div><div data-text="right">' + users[c].sabha_type + "</div></li>", 
            c == users.length - 1 && (content += "</ul>");
            (dates.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (content += "</li>", 
            b == dates.length - 1 && (content += "</ul>"));
        }
        content += "</div>", mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1]) ? content += "</div>" : "", 
        a == mandal.length - 1 ? content += "</div>" : "";
    } else content = '<div id="error-page"><h1>There is nothing planed.</h1><p>You are looking this because RC have not planed any vicharan for upcoming dates.</p></div>';
    OM.Page.format(OM.back_btn(OM.domain + "#reports/"), "Planned Visits by Date", "", content, "");
}, OM.Page.settings = function() {
    var content = OM.Page.row(Array(Array({
        attr: ""
    }, Array("link", '<a href="' + OM.domain + '#settings/profile/">My Profile</a>'), Array("i", '<i class="float-right fa fa-chevron-right"></i>')), Array({
        attr: ""
    }, Array("link", '<a href="' + OM.domain + '#settings/password/">Reset Password</a>'), Array("i", '<i class="float-right fa fa-chevron-right"></i>')), Array({
        attr: ""
    }, Array("link", '<a href="' + OM.domain + '#settings/check-in/">My Check-in History</a>'), Array("i", '<i class="float-right fa fa-chevron-right"></i>')), Array({
        attr: ""
    }, Array("link", '<a href="' + OM.domain + '#settings/gcal/">Sync to Calendar</a>'), Array("i", '<i class="float-right fa fa-chevron-right"></i>'))), 'data-list="link" data-card') + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Update database"), Array("value", '<button type="button" id="btn-sync" data-button data-color="purple"><i class="fa fa-refresh"></i></button><div class="note" id="sync-time">Last updated: ' + OM.session.syncTime + "</div>"))), 'data-list="form" data-card');
    OM.Page.format("", "Settings", "", content, "");
}, OM.Page.setting_profile = function() {
    var page_name = "setting-profile", hidden = "";
    OM.session.ul > parseInt(OM.select.user_level_value[4]) && (hidden = 'class="hidden"'), 
    OM.Page.format(OM.back_btn(OM.domain + "#settings/"), OM.session.fn + " " + OM.session.ln, "", '<form id="form-' + page_name + '">' + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "First Name"), Array("value", '<input id="' + page_name + '-first_name" placeholder="First Name" value="' + OM.session.fn + '" type="text" spellcheck="false" />')), Array({
        attr: ""
    }, Array("field", "Last Name"), Array("value", '<input id="' + page_name + '-last_name" placeholder="Last Name" value="' + OM.session.ln + '" type="text" spellcheck="false" />')), Array({
        attr: ""
    }, Array("field", "Email Address"), Array("value", '<div class="note">This will be you username</div><div><input id="' + page_name + '-email" placeholder="Email Address" value="' + OM.session.e + '" type="email" spellcheck="false" /></div>')), Array({
        attr: ""
    }, Array("field", "Region"), Array("value", OM.Form.built_select_box(page_name + "-region", OM.select.region, OM.select.region, "Select Region", OM.session.region, 'class="get-center-by-region" data-page_name="' + page_name + '" data-center="' + OM.session.center + '"'))), Array({
        attr: 'id="' + page_name + '-all-center" class="hidden"'
    }, Array("field", "Center"), Array("value", '<select id="' + page_name + '-region-center"></select>'))), 'data-list="form" data-card') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Update"
    }) + "</div></form>", ""), $("#" + page_name + "-region").trigger("change");
}, OM.Page.setting_password = function() {
    var page_name = "setting-password";
    return OM.Page.format(OM.back_btn(OM.domain + "#settings/"), "Reset Password", "", '<form id="form-' + page_name + '" data-card>' + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "New Password"), Array("value", '<input type="password" id="' + page_name + '-new" value="">')), Array({
        attr: ""
    }, Array("field", "Confirm New Password"), Array("value", '<input type="password" id="' + page_name + '-confirm" value="">'))), 'data-list="form"') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Update"
    }) + "</div></form>");
}, OM.Page.setting_check_in = function() {
    var page_name = "setting-check-in", content = "";
    if (null == OM.myCheckIn || void 0 == OM.myCheckIn) setTimeout(function() {
        OM.Page.setting_check_in();
    }, 1e3); else if (OM.myCheckIn.length > 0) {
        content += "<ul data-list data-card>";
        for (var a = 0; a < OM.myCheckIn.length; a++) row = OM.myCheckIn[a], content += '<li><div class="detail"><div class="title"><strong>' + row.center + "</strong>(" + row.sabha_type + ") - <em>" + row.region + '</em></div><div class="note">' + row.datetime + '</div></div><div data-btn="right">' + OM.Button.remove({
            page_name: page_name,
            color: !0,
            icon: !0,
            attr: 'data-id="' + row.id + '"'
        }) + "</div></li>";
        content += "</ul>";
    } else content = "No History in database. please check in! 1st to see your history.";
    OM.Page.format(OM.back_btn(OM.domain + "#settings/"), "Check-in History", "", content);
}, OM.Page.setting_gcal = function() {
    OM.Page.format(OM.back_btn(OM.domain + "#settings/"), "Sync to Calendar", "", '<div data-card><div><strong>Google Calendar</strong></div><br><li>Please do the following steps on the desktop.</li><ol data-list="list"><li>Go to <a href="http://www.google.com/calendar/" target="_blank">http://www.google.com/calendar/</a></li><li>On the left side click on the drop down arrow next to <strong>other calendars</strong> and select <strong>Add by URL</strong><br><img src="' + OM.domain + 'img/google_calendar.png"></li><li>In the dialog box enter this link (<strong>' + OM.domain + "gcal.php?id=iz5kcdpt2g" + OM.session.u + "</strong>) and click <strong>Add Calendar</strong> Button.</li></ol><li>The initial sync to your calendar should be instant, but updates may take a while to reach your calendar - sometimes up to a day.</li></div>");
}, OM.Page.setting_home_icon = function() {
    var content = "";
    1 == OM.ios ? content = '<div data-card><div><h2 class="text-center"><i class="fa fa-apple"></i>&nbsp;iOS Devices</h2></div><ol data-list="list"><li>Open this website in <strong>Safari App</strong><br><img src="' + OM.domain + 'img/home-icon/ios-1.jpg" width="70"></li><li>Click on the <strong>share</strong> button located at bottom-center<br><img src="' + OM.domain + 'img/home-icon/ios-2.png" width="280"></li><li>Select <strong>Add to Home Screen</strong><br><img src="' + OM.domain + 'img/home-icon/ios-3.png" width="280"></li><li>Press <strong>Add</strong><br><img src="' + OM.domain + 'img/home-icon/ios-4.png" width="280"></li><li>You should see the RC Vicharan icon on your home screen.<br><img src="' + OM.domain + 'img/home-icon/app-icon.png" width="70"><br>When you open this WebApp it will open in full screen so it will feel like a native app.</li></ol></div>' : 1 == OM.android && (content = '<div data-card><div><h2 class="text-center"><i class="fa fa-android"></i>&nbsp;Android Devices</h2></div><ol data-list="list"><li>Open this website in <strong>Chrome App</strong><br><img src="' + OM.domain + 'img/home-icon/android-1.jpg" width="70"></li><li>Click on Menu then select <strong>Add to homescreen</strong>.<br><img src="' + OM.domain + 'img/home-icon/android-2.png" width="280"></li><li>If you do not see the Title prefill then give Title <strong>RC Vicharan</strong> then touch on <strong>Add</strong> button on the bottom of the dialog box.<br><img src="' + OM.domain + 'img/home-icon/android-3.png" width="280"></li><li>You should see the RC Vicharan icon on your home screen.<br><img src="' + OM.domain + 'img/home-icon/app-icon.png" width="70"><br>When you open this WebApp it will open in full screen so it will feel like a native app.</li></ol></div>'), 
    content ? OM.Page.format(OM.back_btn(OM.domain + "#settings/"), "Add to Home Screen", "", content) : OM.Page.error(404);
}, OM.Page.check_list = function() {
    if ("M" == OM.session.gender) {
        var content = '<ul data-list="nest" data-color="primary" data-card><li><div data-title="check-list-0">Planning for Vicharan<i class="fa fa-caret-up"></i></div><div data-content="check-list-0"><ul data-list="style"><li>Setting goals for visits (and adding them to the vicharan webapp)</li><li>Planning vicharan dates (including adding vicharan dates to the vicharan webapp), who to take along (if applicable), how to get there (in some cases), where to stay (if staying the night).<ul data-list="style"><li>See if your B/K RC counterpart can visit the same weekend so that you can tag team with him.</li></ul></li><li>Checking into the vicharan webapp</li><li>(Related to vicharan but done outside of sabha_type visits) Frequently analyzing goals vs. actual visits on the site</li><li>Before heading out to vicharan, call the P. BK Sant to discuss any issues he thinks you need to address during the visit (also works vice versa when the P. BK Sant goes on vicharan to that center).  In addition, a post-vicharan call to highlight to the P. BK Sant any issues that need his attention.</li></ul></div></li><li><div data-title="check-list-1">Ongoing Basis<i class="fa fa-caret-up"></i></div><div data-content="check-list-1"><ul data-list="style"><li>Monitor the progress of 10 in 14 goals (including culture change)<ul data-list="style"><li>Reaffirm how each project helps achieve these 10 goals in some way shape or form</li></ul></li><li>5 Core Messages of 2014<ul data-list="style"><li>Values, Traditions, Policies, BK Projects, Special Foci</li><li>Need to reiterate these from time to time so that they are fresh in our karyakars minds</li></ul></li><li>Mentoring & Karyakar Development<ul data-list="style"><li>Spend time doing 1 on 1s as needed to reinforce and further mentoring goals</li><li>Identify new talent and facilitate karyakar changeovers</li></ul></li><li>Sabha<ul data-list="style"><li>10 in &#34;14 Goal<ul data-list="style"><li>60% for Post Sabha Review</li></ul></li><li>Ensure post-sabha review happens and ensure quality of post sabha review</li><li>See if sabha sanchalak is helping presenters to prepare on a regular basis</li><li>Determine if pre-sabha preparation happens regularly (presentation, MC, dhoon-prarthana-kirtan)</li><li>Ensure that presentations are being assigned in advance (two weeks where possible)</li><li>Discuss upcoming kishore priority sabha / Bal Group 3 focused sabhas - speaker assignments, networking</li><li>Collect feedback on the syllabus</li><li>Examine bal/kishore reception and reaction to presentations (topics, style of presenting, etc.)</li><li>Evaluate sabha room environment (jabho-lengho, tilak chandlo, adequacy of room, equipment, timings, etc.)</li><li>Present - Goal should be for RCs to present at least 1x a month in sabhas</li><li>Bal Only: Monitor how frequently sabha recap letters are sent to parents by PCs</li></ul></li><li>Campus Sabha (Kishore RCs only, if present)<ul data-list="style"><li>10 in &#34;14 Goal<ul data-list="style"><li>8 Sabhas per semester</li></ul></li><li>Attend where possible</li><li>Talk to the campus sabha sanchalak about sabha_type progress and relay messages back to the RCSL</li><li>Provide feedback on material to RCSL</li></ul></li><li>KST (Kishore RCs only)<ul data-list="style"><li>10 in &#34;14 Goal<ul data-list="style"><li>80% Quiz Average</li><li>80% of KST graduates placed in Seva</li></ul></li><li>Prior to KST launch in August, ensure that karyakars are planning for and conduct a launch meeting with parents (i.e. KST Parents Meeting)</li><li>Interaction with kishores</li><li>Examine KST kishore progress (to help determine readiness for seva placement as well as a seva inclination)</li><li>Deliver high quality presentations</li><li>Provide feedback on presentations, activities, and overall day</li><li>Examine progress of education mentoring by talking with kishores and their education mentors</li><li>Examine progress of satsang mentoring</li></ul></li><li>BST (Bal RCs only)<ul data-list="style"><li>10 in &#34;14 Goal<ul data-list="style"><li>P. Santo are involved in 6 of the 8 sessions</li><li>PCs send out Parents Update Letters to parents for 7 of the 8 sessions</li></ul></li><li>Prior to BST launch in August, ensure that karyakars are planning for and conduct a launch meeting with parents (i.e. BST Parents Meeting), and ensure the application process is implemented locally before selecting balaks</li><li>Attend BSTs (whether or not they fall under our vicharan centers)</li><li>Examine BST balaks’ progress (to assist Sanchalaks in determining seva placement after graduating bal sabha_type)</li><li>Deliver high quality presentations when doing vicharan to BSTs</li><li>Provide feedback on presentations, activities, and overall day to BST Lead</li><li>Examine progress of mentoring by BST Lead to the balaks</li><li>Inquire to progress of PCs sending parents update letters after every BST</li></ul></li><li>BAPS Policies<ul data-list="style"><li>Note whether liability forms are being signed for required events</li><li>Monitor sleepover dates and weekends are within guidelines</li></ul></li><li>Goshti<ul data-list="style"><li>10 in &#34;14 Goal<ul data-list="style"><li>8 gosthis per year</li></ul></li><li>Ensure Gosthi is happening regularly</li><li>Conduct the goshti when in that center</li></ul></li><li>Spend some time having fun with the balaks/kishores/karyakars</li><li>During Samaiyo practice help with practices or planning to customize the samaiyo for the sabha_type</li><li>Discuss anything that needs to be addressed from previous month’s report</li><li>Speak with balaks, kishores, karyakars, admin team to understand any issues outside of project related items that the sabha_type may be facing</li><li>Gujarati Class (Bal RCs only)<ul data-list="style"><li>Speak with Gujarati Coordinator & Sanchalak to address concerns (class quality, need of teachers, facilities, etc.). Communicate these concerns to Regional PC Lead and P. BK Sant.</li><li>Follow-up with Gujarati Coordinator to submit reports to Main Sanchalak</li><li>Assist Sanchalak in working with Gujarati Coordinator to maximize Gujarati attendance and Sabha attendance (pinpointing balaks to come to one and not the other)</li></ul></li></ul></div></li><li><div data-title="check-list-1">Special Activities<i class="fa fa-caret-up"></i></div><div data-content="check-list-1"><ul data-list="style"><li>Satsang Exams<ul data-list="style"><li>10 in &#34;14 Goal<ul data-list="style"><li>100% of A centers have a Study Plan</li><li>50% of B centers have a Study Plan</li><li>25% of C centers have a Study Plan</li></ul></li><li>Ensure a satsang exam lead has been appointed</li><li>Ensure that study plans are created and implemented</li><li>Motivate karyakars to study</li><li>Ask if everyone has the materials they need to study</li><li>Follow up on pre-test</li><li>Follow-up with PCs/Sanchalak for registration during September-November visits</li></ul></li><li>Parent Sanchalak Meeting<ul data-list="style"><li>Ensure PCs are leading the planning of the event and provide feedback to Regional Lead RC RPCL.</li><li>Discuss PSM planning with PC & Sanchalak</li><li>Kishore RCs Only: Talk with the parents in remote centers as needed to go over education seminar material </li></ul></li><li>The Princeton Review Seminar (Kishore RCs Only)<ul data-list="style"><li>If on vicharan prior to the seminar, follow up to ensure that the KM local rep is in touch with the TPR local rep and that arrangements have been finalized</li></ul></li><li>Parent Awareness Seminars<ul data-list="style"><li>Follow up to ensure that PC/sanchalak is sitting with presenters to go over messages to be delivered</li></ul></li><li>Chaturmas Niyam Drive<ul data-list="style"><li>If present during drive, motivate karyakars to take Chaturmas niyams</li><li>Ask karyakars, balaks, kishores how niyams are faring when visiting during Chaturmas</li></ul></li><li>Walkathon<ul data-list="style"><li>In the month preceding Walkathon, encourage karyakars to form teams of kishores for fundraising  (Kishore RCs Only)</li><li>Be sure the Walkathon sabha is held (Bal Only)</li></ul></li><li>Sports Days/Stayovers/Outings<ul data-list="style"><li>Follow up with karyakars to ensure some type of activities are included in the calendar</li><li>Follow up on networking for these events</li><li>Ensure liability forms have been created on the website and sent out</li></ul></li><li>Children’s Diwali Celebrations (Bal RCs Only)<ul data-list="style"><li>Ensure Sanchalak is keeping track of actual expenses and within budget</li><li>Review the sabha program with the programming team to ensure messages are relayed properly</li><li>Sit with PCs and Sanchalak to understand the networking plan (pre, during and post)</li><li>Ensure liability forms have been created</li></ul></li><li>Samaiya<ul data-list="style"><li>When doing vicharan at the time the packet is released, ensure that balance with respect to involvement is there.  Discuss issues as necessary with the Satsang Admin</li><li>Follow up on status of practices</li><li>Help out as needed during the samaiyo (if present)</li><li>Ensure that regular activities continue (sabha, etc.).  Volunteer to present so that local presenters have one less thing to do during practice season</li><li>Ensure sleepover schedules match liability policies</li></ul></li><li>Prasad Vitaran (Kishore RCs Only)<ul data-list="style"><li>When visiting prior to prasad vitaran, follow up on which kishores’ houses will be visited</li></ul></li><li>Regional Karyakar Exchange (Kishore RCs Only)<ul data-list="style"><li>If on vicharan prior to RKE, follow up on schedule and logistics</li><li>If attending RKE,<ul data-list="style"><li>Ensure karyakars are introduced to each other</li><li>Help with communication between visiting and host sabha_types</li></ul></li></ul></li><li>Summer Shibir/KarCons<ul data-list="style"><li>Follow up on attendance</li><li>Motivate balaks/kishores/karyakars to register</li><li>Follow up with mandal leads on preparation - test them to ensure they’re preparing properly</li></ul></li><li>Basketball Tournament (Kishore Only)<ul data-list="style"><li>Ask about registration progress</li></ul></li><li>NSC<ul data-list="style"><li>If visiting a center where an NSC candidate is present, ask about his application status and motivate him to apply</li></ul></li><li>India Trip (Kishore Only)<ul data-list="style"><li>Talk to sanchalak about potential India Trip candidates</li></ul></li></ul></div></li><li><div data-title="check-list-1">On a Term Basis<i class="fa fa-caret-up"></i></div><div data-content="check-list-1"><ul data-list="style"><li>RAM/RCT Meeting<ul data-list="style"><li>Sit with sanchalaks to review progress on goals and ensure they are preparing for the meeting</li></ul></li><li>LAMs<ul data-list="style"><li>Present as necessary</li><li>Remind karyakars of the five main messages</li><li>Help sanchalak conduct a review of the past term and discuss action items for the upcoming term</li><li>Evaluate the culture change within the sabha_type and stress it during visits</li></ul></li><li>Regional event attendance<ul data-list="style"><li>Push karyakars to attend regional events (RAM, RCT meeting, etc)</li></ul></li></ul></div></li><li><div data-title="check-list-1">Inter-Wing Relations<i class="fa fa-caret-up"></i></div><div data-content="check-list-1"><ul data-list="style"><li>Meet and discuss issues with Satsang Admin and Mandir Coordinator</li></ul></div></li></ul>';
        OM.Page.format("", "Check List", "", content);
    } else OM.Page.error(404);
}, OM.Page.admin = function() {
    if (OM.session.ul <= OM.select.user_level_value[4]) {
        var content = Array(Array({
            attr: ""
        }, Array("link", '<a href="' + OM.domain + '#admin/profiles/">Profiles</a>'), Array("i", '<i class="float-right fa fa-chevron-right"></i>')), Array({
            attr: ""
        }, Array("link", '<a href="' + OM.domain + '#admin/assign-center/">Assign Center</a>'), Array("i", '<i class="float-right fa fa-chevron-right"></i>')), Array({
            attr: ""
        }, Array("link", '<a href="' + OM.domain + '#admin/center/">Centers</a>'), Array("i", '<i class="float-right fa fa-chevron-right"></i>')));
        OM.session.ul <= OM.select.user_level_value[2] && (content[content.length] = Array({
            attr: ""
        }, Array("link", '<a href="' + OM.domain + '#admin/select-other-option/">Other Option List</a>'), Array("i", '<i class="float-right fa fa-chevron-right"></i>')), 
        content[content.length] = Array({
            attr: ""
        }, Array("link", '<a href="' + OM.domain + '#analysis/">Analysis</a>'), Array("i", '<i class="float-right fa fa-chevron-right"></i>'))), 
        OM.Page.format("", "Admin", "", OM.Page.row(content, 'data-list="link" data-card'), "");
    } else OM.Page.error(403);
}, OM.Page.admin_profiles = function() {
    var content = "";
    if (OM.session.ul <= OM.select.user_level_value[4]) {
        if (null == OM.profiles || void 0 == OM.profiles) OM.Page.error(404); else if (OM.profiles.length > 0) for (var mandal = OM.profiles, a = 0; a < mandal.length; a++) {
            if (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) {
                var show = "hide";
                if (0 == a) {
                    show = "show";
                    for (var tab = 0; tab < mandal.length; tab++) {
                        var active = "";
                        0 == tab && (content += '<ul data-tabNav="' + mandal.length + '">', active = "active"), 
                        content += '<li data-tabContent-id="' + mandal[tab].mandal + '" class="' + active + '"><div>' + mandal[tab].mandal + "</div></li>", 
                        tab == mandal.length - 1 && (content += "</ul>");
                    }
                    content += "<div data-tabContentParent>";
                }
                content += '<div data-tabContent="' + mandal[a].mandal + '" class="' + show + '">';
            }
            content += "<div data-card>";
            for (var regions = mandal[a].regions, b = 0; b < regions.length; b++) {
                (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (0 == b && (content += '<ul data-list="nest" data-colorName="inverse">'), 
                content += '<li><div data-title="region-' + b + '"><u class="fa fa-globe"></u>' + regions[b].region + '<i class="fa fa-caret-up"></i></div><div data-content="region-' + b + '">');
                for (var users = regions[b].users, c = 0; c < users.length; c++) 0 == c && (content += '<ul data-list="link">'), 
                content += '<li><a href="' + OM.domain + "#admin/profiles/edit/" + users[c].id + '/">' + users[c].name + '</a><i class="float-right fa fa-chevron-right"></i></li>', 
                c == users.length - 1 && (content += "</ul>");
                (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (content += "</div></li>", 
                b == regions.length - 1 && (content += "</ul>"));
            }
            content += "</div>", mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1]) ? content += "</div>" : "", 
            a == mandal.length - 1 ? content += "</div>" : "";
        } else OM.Page.error(404);
        OM.Page.format(OM.back_btn(OM.domain + "#admin/"), "Profiles", OM.Button.add({
            page_name: "admin-profiles",
            color: !1,
            icon: !0,
            attr: 'data-href="' + OM.domain + '#admin/profiles/add/"'
        }), content, "");
    } else OM.Page.error(403);
}, OM.Page.admin_profile_add = function() {
    var page_name = "admin-profile-add";
    OM.session.ul <= OM.select.user_level_value[4] ? OM.Page.format(OM.back_btn(OM.domain + "#admin/profiles/"), "New Profile", "", '<form id="form-' + page_name + '">' + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "First Name"), Array("value", '<input id="' + page_name + '-first_name" placeholder="First Name" value="" type="text" spellcheck="false" />')), Array({
        attr: ""
    }, Array("field", "Last Name"), Array("value", '<input id="' + page_name + '-last_name" placeholder="Last Name" value="" type="text" spellcheck="false" />')), Array({
        attr: ""
    }, Array("field", "Email Address"), Array("value", '<div class="note">This will be the username</div><div><input id="' + page_name + '-email" placeholder="Email Address" value="" type="email" spellcheck="false" /></div>')), Array({
        attr: ""
    }, Array("field", "Gender"), Array("value", '<div class="radio" data-radio="2"><input type="radio" name="' + page_name + '-gender" id="' + page_name + '-gender-m" value="M" checked><label for="' + page_name + '-gender-m">Male</label><input type="radio" name="' + page_name + '-gender" id="' + page_name + '-gender-f" value="F"><label for="' + page_name + '-gender-f">Female</label><span class="slide-button"></span></div>')), Array({
        attr: ""
    }, Array("field", "Mandal"), Array("value", '<div class="radio" data-radio="3"><input type="radio" name="' + page_name + '-sabha_type" id="' + page_name + '-sabha_type-bm" value="B" checked><label for="' + page_name + '-sabha_type-bm">B</label><input type="radio" name="' + page_name + '-sabha_type" id="' + page_name + '-sabha_type-km" value="K"><label for="' + page_name + '-sabha_type-km">K</label><input type="radio" name="' + page_name + '-sabha_type" id="' + page_name + '-sabha_type-sm" value="C"><label for="' + page_name + '-sabha_type-sm">P. Sant/RMC</label><span class="slide-button"></span></div>')), Array({
        attr: ""
    }, Array("field", "Region"), Array("value", OM.Form.built_select_box(page_name + "-region", OM.select.region, OM.select.region, "Select Region", "", 'class="get-center-by-region" data-page_name="' + page_name + '"'))), Array({
        attr: 'id="' + page_name + '-all-center" class="hidden"'
    }, Array("field", "Center"), Array("value", '<select id="' + page_name + '-region-center"></select>')), Array({
        attr: ""
    }, Array("field", "User Level"), Array("value", OM.Form.built_select_box(page_name + "-user_level", OM.select.user_level_name, OM.select.user_level_value, "Select User Level", OM.select.user_level_value[6], "", OM.select.user_level_value.indexOf("" + OM.session.ul))))), 'data-list="form" data-card') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Submit"
    }) + "</div></form>", "") : OM.Page.error(403);
}, OM.Page.admin_profile_edit = function(id, options) {
    var page_name = "admin-profile-edit";
    OM.session.ul <= OM.select.user_level_value[4] ? (void 0 == options && OM.Modal.loading("loading-" + page_name), 
    OM.get_data(OM.process + "index.php", {
        code: "admin",
        type: "get-profile",
        id: id,
        token: OM.session.t,
        uid: OM.session.u
    }, function(data) {
        OM.Modal.close("loading-" + page_name);
        var row = data.p, b_sabha_type = "", k_sabha_type = "", c_sabha_type = "", m_gender = "", f_gender = "", active = "";
        "B" == row.gr ? b_sabha_type = "checked" : "K" == row.gr ? k_sabha_type = "checked" : "C" == row.gr && (c_sabha_type = "checked"), 
        "M" == row.ge ? m_gender = "checked" : "F" == row.ge && (f_gender = "checked"), 
        active = "Y" == row.a ? '<button type="button" data-button data-color="dark-red" id="btn-active-' + page_name + '" data-value="" data-id="' + id + '">Deactivate</button>' : '<button type="button" data-button data-color="dark-green" id="btn-active-' + page_name + '" data-value="Y" data-id="' + id + '">Activate</button>', 
        OM.Page.format(OM.back_btn(OM.domain + "#admin/profiles/"), "Edit Profile", "", '<form id="form-' + page_name + '">' + OM.Page.row(Array(Array({
            attr: ""
        }, Array("field", "First Name"), Array("value", '<input id="' + page_name + '-first_name" placeholder="First Name" value="' + row.fn + '" type="text" spellcheck="false" />')), Array({
            attr: ""
        }, Array("field", "Last Name"), Array("value", '<input id="' + page_name + '-last_name" placeholder="First Name" value="' + row.ln + '" type="text" spellcheck="false" />')), Array({
            attr: ""
        }, Array("field", "Email Address"), Array("value", '<div class="note">This will be the username</div><div><input id="' + page_name + '-email" placeholder="Email Address" value="' + row.e + '" type="email" spellcheck="false" /></div>')), Array({
            attr: ""
        }, Array("field", "Gender"), Array("value", '<div class="radio" data-radio="2"><input type="radio" name="' + page_name + '-gender" id="' + page_name + '-gender-m" value="M" ' + m_gender + '><label for="' + page_name + '-gender-m">Male</label><input type="radio" name="' + page_name + '-gender" id="' + page_name + '-gender-f" value="F" ' + f_gender + '><label for="' + page_name + '-gender-f">Female</label><span class="slide-button"></span></div>')), Array({
            attr: ""
        }, Array("field", "Mandal"), Array("value", '<div class="radio" data-radio="3"><input type="radio" name="' + page_name + '-sabha_type" id="' + page_name + '-sabha_type-bm" value="B" ' + b_sabha_type + '><label for="' + page_name + '-sabha_type-bm">B</label><input type="radio" name="' + page_name + '-sabha_type" id="' + page_name + '-sabha_type-km" value="K" ' + k_sabha_type + '><label for="' + page_name + '-sabha_type-km">K</label><input type="radio" name="' + page_name + '-sabha_type" id="' + page_name + '-sabha_type-sm" value="C" ' + c_sabha_type + '><label for="' + page_name + '-sabha_type-sm">P. Sant/RMC</label><span class="slide-button"></span></div>')), Array({
            attr: ""
        }, Array("field", "Region"), Array("value", OM.Form.built_select_box(page_name + "-region", OM.select.region, OM.select.region, "Select Region", row.r, 'class="get-center-by-region" data-page_name="' + page_name + '" data-center="' + row.c + '"'))), Array({
            attr: 'id="' + page_name + '-all-center"'
        }, Array("field", "Center"), Array("value", '<select id="' + page_name + '-region-center"></select><input type="hidden" id="' + page_name + '-id" value="' + id + '">')), Array({
            attr: ""
        }, Array("field", "User Level"), Array("value", OM.Form.built_select_box(page_name + "-user_level", OM.select.user_level_name, OM.select.user_level_value, "Select User Level", row.ul, "", OM.select.user_level_value.indexOf("" + OM.session.ul)))), Array({
            attr: ""
        }, Array("btn", active + '&nbsp;<button type="button" data-button data-color="orange" id="btn-reset-password-' + page_name + '" data-id="' + id + '">Reset Password</button>'))), 'data-list="form" data-card') + '<div class="btn">' + OM.Button.save({
            page_name: page_name,
            color: !0,
            icon: !0,
            text: "Submit"
        }) + "</div></form>", ""), $("#" + page_name + "-region").trigger("change");
    }, "post")) : OM.Page.error(403);
}, OM.Page.admin_assign_center = function() {
    var page_name = "admin-assign-center", content = "";
    if (OM.session.ul <= OM.select.user_level_value[4]) {
        if (null == OM.assignedCenters || void 0 == OM.assignedCenters) OM.Page.error(404); else if (OM.assignedCenters.length > 0) for (var mandal = OM.assignedCenters, a = 0; a < mandal.length; a++) {
            if (mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1])) {
                var show = "hide";
                if (0 == a) {
                    show = "show";
                    for (var tab = 0; tab < mandal.length; tab++) {
                        var active = "";
                        0 == tab && (content += '<ul data-tabNav="' + mandal.length + '">', active = "active"), 
                        content += '<li data-tabContent-id="' + mandal[tab].mandal + '" class="' + active + '"><div>' + mandal[tab].mandal + "</div></li>", 
                        tab == mandal.length - 1 && (content += "</ul>");
                    }
                    content += "<div data-tabContentParent>";
                }
                content += '<div data-tabContent="' + mandal[a].mandal + '" class="' + show + '">';
            }
            content += "<div data-card>";
            for (var regions = mandal[a].regions, b = 0; b < regions.length; b++) {
                (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (0 == b && (content += '<ul data-list="nest" data-colorName="inverse">'), 
                content += '<li><div data-title="region-' + b + '"><u class="fa fa-globe"></u>' + regions[b].region + '<i class="fa fa-caret-up"></i></div><div data-content="region-' + b + '">');
                for (var users = regions[b].users, c = 0; c < users.length; c++) {
                    (users.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (0 == c && (content += '<ul data-list="list">'), 
                    content += '<li data-color="gray" data-title><u class="fa fa-user"></u>' + users[c].user + "</li><li>");
                    for (var centers = users[c].centers, d = 0; d < centers.length; d++) {
                        0 == d && (content += "<ul data-list>");
                        var sabha_type_array = new Array(), sabha_type_list = "";
                        "" !== centers[d].bm && (sabha_type_array[sabha_type_array.length] = "BM"), "" !== centers[d].bst && (sabha_type_array[sabha_type_array.length] = "BST"), 
                        "" !== centers[d].km && (sabha_type_array[sabha_type_array.length] = "KM"), "" !== centers[d].kst && (sabha_type_array[sabha_type_array.length] = "KST"), 
                        "" !== centers[d].campus && (sabha_type_array[sabha_type_array.length] = "Campus"), 
                        "" !== centers[d].goshti && (sabha_type_array[sabha_type_array.length] = "Goshti"), 
                        "" !== centers[d].lam && (sabha_type_array[sabha_type_array.length] = "LAM");
                        for (var m = 0; m < sabha_type_array.length; m++) sabha_type_list += sabha_type_array[m], 
                        m < sabha_type_array.length - 1 && (sabha_type_list += ", ");
                        content += '<li><div class="detail"><div class="title">' + centers[d].center + '</div><div class="note">' + sabha_type_list + '</div></div><div data-btn="right">' + OM.Button.edit({
                            page_name: page_name,
                            color: !0,
                            icon: !0,
                            attr: 'data-id="' + centers[d].id + '" data-index="' + a + "," + b + "," + c + "," + d + '"'
                        }) + "</div></li>", d == centers.length - 1 && (content += "</ul>");
                    }
                    (users.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[4])) && (content += "</li>", 
                    c == users.length - 1 && (content += "</ul>"));
                }
                (regions.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[2])) && (content += "</div></li>", 
                b == regions.length - 1 && (content += "</ul>"));
            }
            content += "</div>", mandal.length > 1 || OM.session.ul <= parseInt(OM.select.user_level_value[1]) ? content += "</div>" : "", 
            a == mandal.length - 1 ? content += "</div>" : "";
        }
        OM.Page.format(OM.back_btn(OM.domain + "#admin/"), "Assign Center", OM.Button.add({
            page_name: "admin-" + page_name,
            color: !1,
            icon: !0,
            attr: 'onClick="javascript:OM.Page.admin_assign_center_add();"'
        }), content, "");
    } else OM.Page.error(403);
}, OM.Page.admin_assign_center_add = function() {
    var page_name = "admin-assign-center-add", options = "";
    if (OM.session.ul <= OM.select.user_level_value[4]) {
        for (var a = 0; a < OM.profiles.length; a++) {
            options += '<optmandal label="' + OM.profiles[a].mandal + '">';
            for (var b = 0; b < OM.profiles[a].regions.length; b++) {
                options += '<optmandal label="' + OM.profiles[a].regions[b].region + '">';
                for (var c = 0; c < OM.profiles[a].regions[b].users.length; c++) row = OM.profiles[a].regions[b].users[c], 
                options += '<option value="' + row.id + '">' + row.name + "</option>";
                options += "</optmandal>";
            }
            options += "</optmandal>";
        }
        OM.Modal.new(page_name, OM.Modal.format("Assign Center", OM.Button.close({
            page_name: page_name,
            color: !0,
            icon: !0
        }), '<form id="form-' + page_name + '">' + OM.Page.row(Array(Array({
            attr: ""
        }, Array("field", "Name"), Array("value", '<select id="' + page_name + '-user"><option value="">Select Name</option>' + options + "</select>")), Array({
            attr: ""
        }, Array("field", "Region"), Array("value", OM.Form.built_select_box(page_name + "-region", OM.select.region, OM.select.region, "Select Region", "", 'class="get-center-by-region" data-page_name="' + page_name + '"'))), Array({
            attr: 'id="' + page_name + '-all-center" class="hidden"'
        }, Array("field", "Center"), Array("value", '<select id="' + page_name + '-region-center"></select>')), Array({
            attr: ' id="' + page_name + '-sabha_type" class="hidden"'
        }, Array("field", "Mandal"), Array("value", ""))), 'data-list="form" data-card') + '<div class="btn">' + OM.Button.save({
            page_name: page_name,
            color: !0,
            icon: !0
        }) + "</div></form>"));
    }
}, OM.Page.admin_centers = function() {
    var page_name = "admin-centers", content = "";
    if (OM.session.ul <= OM.select.user_level_value[4]) {
        if (null == OM.regionCenter || void 0 == OM.regionCenter) OM.Page.error(404); else if (OM.regionCenter.length > 0) {
            content += "<div data-card>";
            for (var regions = OM.regionCenter, a = 0; a < regions.length; a++) {
                regions.length > 1 && (0 == a && (content += '<ul data-list="nest" data-colorName="inverse">'), 
                content += '<li><div data-title="center-' + b + '"><u class="fa fa-global"></u>' + regions[a].region + '<i class="fa fa-caret-up"></i></div><div data-content="center-' + b + '">');
                for (var centers = regions[a].centers, b = 0; b < centers.length; b++) {
                    0 == b && (content += "<ul data-list>");
                    var sabha_type_array = new Array(), sabha_type_list = "";
                    "" !== centers[b].bm && (sabha_type_array[sabha_type_array.length] = "BM"), "" !== centers[b].bst && (sabha_type_array[sabha_type_array.length] = "BST"), 
                    "" !== centers[b].km && (sabha_type_array[sabha_type_array.length] = "KM"), "" !== centers[b].kst && (sabha_type_array[sabha_type_array.length] = "KST"), 
                    "" !== centers[b].campus && (sabha_type_array[sabha_type_array.length] = "Campus"), 
                    "" !== centers[b].goshti && (sabha_type_array[sabha_type_array.length] = "Goshti"), 
                    "" !== centers[b].lam && (sabha_type_array[sabha_type_array.length] = "LAM");
                    for (var m = 0; m < sabha_type_array.length; m++) sabha_type_list += sabha_type_array[m], 
                    m < Math.abs(sabha_type_array.length - 1) && (sabha_type_list += ", ");
                    content += '<li><div class="detail"><div class="title">' + centers[b].name + '</div><div class="note">' + sabha_type_list + '</div></div><div data-btn="right">' + OM.Button.edit({
                        page_name: page_name,
                        color: !0,
                        icon: !0,
                        attr: 'data-id="' + centers[b].id + '" data-index="' + a + "," + b + '"'
                    }) + "</div></li>", b == Math.abs(centers.length - 1) && (content += "</ul>");
                }
                regions.length > 1 && (content += "</div></li>", a == regions.length - 1 && (content += "</ul>"));
            }
        }
        OM.Page.format(OM.back_btn(OM.domain + "#admin/"), "Centers", OM.Button.add({
            page_name: "admin-" + page_name,
            color: !1,
            icon: !0,
            attr: 'onClick="javascript:OM.Page.admin_centers_add();"'
        }), content);
    } else OM.Page.error(403);
}, OM.Page.admin_centers_add = function() {
    function render_status(page_name, sabha_type, status) {
        for (var status_value = new Array("", "A", "B", "C", "R"), status_text = new Array("None", "A", "B", "C", "R"), checked = "", render = "", a = 0; a < status_value.length; a++) checked = status_value[a] == status ? "checked" : "", 
        render += '<input type="radio" name="' + page_name + '-status" id="' + page_name + "-status-" + status_value[a] + '" value="' + status_value[a] + '" ' + checked + '><label for="' + page_name + "-status-" + status_value[a] + '">' + status_text[a] + "</label>";
        return '<div class="radio" data-radio="' + a + '" data-sabha_type="' + sabha_type + '">' + render + '<span class="slide-button"></span></div>';
    }
    var page_name = "admin-centers-add", content = "", mandal = OM.session.mandal;
    kishore_name = new Array("KST", "Campus"), region = "", hide = "", OM.session.ul <= OM.select.user_level_value[2] ? (OM.session.ul < OM.select.user_level_value[3] ? region = OM.Form.built_select_box(page_name + "-region", OM.select.region, OM.select.region, "Select Region") : (region = OM.Form.built_select_box(page_name + "-region", OM.select.region, OM.select.region, "Select Region", OM.session.region, "disabled"), 
    hide = 'class="hidden"'), content = Array(Array({
        attr: hide
    }, Array("field", "Region"), Array("value", region)), Array({
        attr: ""
    }, Array("field", "Center"), Array("value", '<input type="text" id="' + page_name + '-center" value="" placeholder="center name">'))), 
    ("B" == mandal || "C" == mandal) && (content[content.length] = Array({
        attr: ""
    }, Array("field", "Bal Mandal"), Array("value", render_status(page_name, "bm", ""))), 
    content[content.length] = Array({
        attr: 'class="float"'
    }, Array("field", "BST"), Array("value", '<div class="checkbox yes-no"><input type="checkbox" id="edit-' + page_name + '-bst" value="Y" class="sabha_type-' + page_name + '" placeholder="BST"><label for="edit-' + page_name + '-bst"><div class="inner"></div><div class="btn-switch"></div></label></div>'))), 
    ("K" == mandal || "C" == mandal) && (content[content.length] = Array({
        attr: ""
    }, Array("field", "Kishore Mandal"), Array("value", render_status(page_name, "km", ""))), 
    content[content.length] = Array({
        attr: 'class="float"'
    }, Array("field", "KST"), Array("value", '<div class="checkbox yes-no"><input type="checkbox" id="edit-' + page_name + '-kst" value="Y" class="sabha_type-' + page_name + '" placeholder="KST"><label for="edit-' + page_name + '-kst"><div class="inner"></div><div class="btn-switch"></div></label></div>')), 
    content[content.length] = Array({
        attr: 'class="float"'
    }, Array("field", "Campus"), Array("value", '<div class="checkbox yes-no"><input type="checkbox" id="edit-' + page_name + '-campus" value="Y" class="sabha_type-' + page_name + '" placeholder="Campus"><label for="edit-' + page_name + '-campus"><div class="inner"></div><div class="btn-switch"></div></label></div>'))), 
    content[content.length] = Array({
        attr: 'class="float"'
    }, Array("field", "Goshti"), Array("value", '<div class="checkbox yes-no"><input type="checkbox" id="edit-' + page_name + '-goshti" value="Y" class="sabha_type-' + page_name + '" placeholder="Goshti"><label for="edit-' + page_name + '-goshti"><div class="inner"></div><div class="btn-switch"></div></label></div>')), 
    content[content.length] = Array({
        attr: 'class="float"'
    }, Array("field", "LAM"), Array("value", '<div class="checkbox yes-no"><input type="checkbox" id="edit-' + page_name + '-lam" value="Y" class="sabha_type-' + page_name + '" placeholder="LAM"><label for="edit-' + page_name + '-lam"><div class="inner"></div><div class="btn-switch"></div></label></div>')), 
    content = '<form id="form-' + page_name + '">' + OM.Page.row(content, 'data-list="form" data-card') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Submit"
    }) + "</div></form>", OM.Modal.new(page_name, OM.Modal.format("Add New Center", OM.Button.close({
        page_name: page_name,
        color: !0,
        icon: !0
    }), content))) : OM.Page.error(403, "dialog");
}, OM.Page.admin_select_other_option = function() {
    var page_name = "admin-select-other-option", content = "";
    if (OM.session.ul <= OM.select.user_level_value[2]) {
        if ("null" == OM.select.other_option || void 0 == OM.select.other_option || OM.select.other_option.length < 1) content += '<li class="null">No option</li>'; else for (var name = "", a = 0; a < OM.select.other_option.length; a++) name = OM.select.other_option[a], 
        content += "<li><div>" + name + '</div><div data-btn="right">' + OM.Button.remove({
            page_name: page_name,
            color: !0,
            icon: !0,
            attr: 'data-value="' + name + '"'
        }) + "</div></li>";
        content = '<form id="form-' + page_name + '" style="margin:5px;" data-card><input type="text" style="width:100%;" id="' + page_name + '-new" placeholder="enter new option"></form><ul data-list data-card>' + content + "</ul>", 
        OM.Page.format(OM.back_btn(OM.domain + "#admin/"), "Other Option List", OM.Button.save({
            page_name: page_name,
            color: !1,
            icon: !0
        }), content);
    } else OM.Page.error(403);
}, OM.Page.admin_top_links = function() {
    var page_name = "admin-top-links", content = "";
    OM.session.ul <= OM.select.user_level_value[2] ? (OM.Modal.loading("loading-" + page_name), 
    OM.get_data(OM.process + "index.php", {
        code: "admin",
        type: "top-links",
        token: OM.session.t,
        uid: OM.session.u
    }, function(data) {
        if (OM.Modal.close("loading-" + page_name), "error" == data.status) content = data.message; else for (var a = 0; a < data.top_links.length; a++) 0 == a && (content += "<ul data-list data-card>"), 
        content += '<li><div><a href="' + OM.domain + "#" + data.top_links[a].hash + '">' + data.top_links[a].hash + '</a></div><div data-btn="right"><button data-button data-color="purple">' + data.top_links[a].clicks + "</button></div></li>", 
        a == data.top_links.length - 1 && (content += "</ul>");
        OM.Page.format(OM.back_btn(OM.domain + "#admin/"), "Top Links", "", content);
    })) : OM.Page.error(403);
}, OM.Page.admin_charts = function() {
    OM.Page.format(OM.back_btn(OM.domain + "#admin/"), "Charts", "", '<div id="pie-chart"><div class="pie-bg"></div><div id="pie-slice-1" class="pie-hold"><div class="pie"></div></div><div id="pie-slice-2" class="pie-hold"><div class="pie"></div></div><div id="pie-slice-3" class="pie-hold"><div class="pie"></div></div></div>');
}, OM.Page.analysis = function(type) {
    var page_name = "analysis", content = "";
    OM.session.ul <= OM.select.user_level_value[2] && (OM.Modal.loading("loading-" + page_name), 
    OM.get_data(OM.process + "analysis.php", {
        type: type,
        token: OM.session.t,
        uid: OM.session.u
    }, function(data) {
        content = data, console.log(data), OM.Modal.close("loading-" + page_name), OM.Page.format(OM.back_btn(OM.domain + "#admin/"), "Analysis", "", content);
    }));
}, $(document).ready(function() {
    OM.body = $("#na"), OM.page_loaded = !1, $("#dialog-site-loader").length < 1 && (OM.Modal.site_loading(), 
    $("#dialog-site-loader").css({
        "background-color": "transparent"
    })), $(window).bind("hashchange", function() {
        OM.hash = window.location.hash.replace(/^#/, ""), OM.hash_split = OM.hash.split("/"), 
        (null == OM.session.t || "null" == OM.session.t || "" == OM.session.t || void 0 == OM.session.t) && (OM.login = !1), 
        $("html").attr("data-login", OM.login), "reset-password" == OM.hash_split[0] ? (OM.Modal.close("site-loader"), 
        OM.Page.reset_password(OM.hash_split[1])) : 0 == OM.login ? (OM.Modal.close("site-loader"), 
        OM.body.html(OM.Page.login())) : 1 == OM.login && (OM.Modal.close("site-loader"), 
        OM.hash ? "logout/" == OM.hash ? OM.get_data(OM.process + "index.php", {
            code: "logout",
            token: OM.session.t,
            uid: OM.session.u
        }, function(c) {
            0 == c.login && (window.localStorage.setItem("session", '{"t":null,"u":null}'), 
            OM.empty_storage(), window.location.href = OM.domain);
        }) : ($("menu,#menu-cover").removeClass("show"), OM.body.find("header").length < 1 && (OM.body.html('<header id="header"><div><span id="top-left"></span><h1 id="top-center"></h1><span id="top-right"></span></div></header>' + OM.Page.nav() + '<div id="menu-cover"></div><section id="page"></section><footer id="footer"></footer>'), 
        $(".nano").nanoScroller()), OM.page_loaded = !1, OM.session.setup < OM.setup && "setup" == OM.hash_split[0] ? (OM.Page.setup_start(), 
        OM.page_loaded = !0) : OM.session.setup < OM.setup ? (OM.Page.setup_welcome(), OM.page_loaded = !0) : "Y" == OM.session.auto_pass ? (OM.Page.auto_pass(), 
        OM.page_loaded = !0) : "check-in" == OM.hash_split[0] && "" !== OM.hash_split[1] ? (OM.Page.check_in_vicharan_note(OM.hash_split[1]), 
        OM.page_loaded = !0) : "check-in" == OM.hash_split[0] ? (OM.Page.check_in(), OM.page_loaded = !0) : "my-vicharan" == OM.hash_split[0] ? (OM.Page.my_vicharan(), 
        OM.page_loaded = !0) : "vicharan-notes" == OM.hash_split[0] && "add" == OM.hash_split[1] ? (OM.Page.add_vicharan_note(), 
        OM.page_loaded = !0) : "vicharan-notes" == OM.hash_split[0] && "" !== OM.hash_split[1] ? (OM.Page.vicharan_note_read(OM.hash_split[1]), 
        OM.page_loaded = !0) : "vicharan-notes" == OM.hash_split[0] ? (OM.Page.vicharan_notes(), 
        OM.page_loaded = !0) : "my-goals" == OM.hash_split[0] ? (OM.Page.my_goals(), OM.page_loaded = !0) : "reports" == OM.hash_split[0] && "planned-visits-date" == OM.hash_split[1] ? (OM.Page.reports_planned_visits_date(), 
        OM.page_loaded = !0) : "reports" == OM.hash_split[0] && "planned-visits-rc" == OM.hash_split[1] ? (OM.Page.reports_planned_visits_rc(), 
        OM.page_loaded = !0) : "reports" == OM.hash_split[0] && "checked_in-date" == OM.hash_split[1] ? (OM.Page.reports_checked_in_date(), 
        OM.page_loaded = !0) : "reports" == OM.hash_split[0] && "checked_in-center" == OM.hash_split[1] ? (OM.Page.reports_checked_in_center(), 
        OM.page_loaded = !0) : "reports" == OM.hash_split[0] && "checked_in-rc" == OM.hash_split[1] ? (OM.Page.reports_checked_in_rc(), 
        OM.page_loaded = !0) : "reports" == OM.hash_split[0] && "individual" == OM.hash_split[1] ? (OM.Page.reports_individual(), 
        OM.page_loaded = !0) : "reports" == OM.hash_split[0] ? (OM.Page.reports(), OM.page_loaded = !0) : "check-list" == OM.hash_split[0] ? (OM.Page.check_list(), 
        OM.page_loaded = !0) : "settings" == OM.hash_split[0] && "home-icon" == OM.hash_split[1] ? (OM.Page.setting_home_icon(), 
        OM.page_loaded = !0) : "settings" == OM.hash_split[0] && "gcal" == OM.hash_split[1] ? (OM.Page.setting_gcal(), 
        OM.page_loaded = !0) : "settings" == OM.hash_split[0] && "check-in" == OM.hash_split[1] ? (OM.Page.setting_check_in(), 
        OM.page_loaded = !0) : "settings" == OM.hash_split[0] && "password" == OM.hash_split[1] ? (OM.Page.setting_password(), 
        OM.page_loaded = !0) : "settings" == OM.hash_split[0] && "profile" == OM.hash_split[1] ? (OM.Page.setting_profile(), 
        OM.page_loaded = !0) : "settings" == OM.hash_split[0] ? (OM.Page.settings(), OM.page_loaded = !0) : "admin" == OM.hash_split[0] && "charts" == OM.hash_split[1] ? (OM.Page.admin_charts(), 
        OM.page_loaded = !0) : "admin" == OM.hash_split[0] && "profiles" == OM.hash_split[1] && "edit" == OM.hash_split[2] ? (OM.Page.admin_profile_edit(OM.hash_split[3]), 
        OM.page_loaded = !0) : "admin" == OM.hash_split[0] && "profiles" == OM.hash_split[1] && "add" == OM.hash_split[2] ? (OM.Page.admin_profile_add(), 
        OM.page_loaded = !0) : "admin" == OM.hash_split[0] && "profiles" == OM.hash_split[1] ? (OM.Page.admin_profiles(), 
        OM.page_loaded = !0) : "admin" == OM.hash_split[0] && "assign-center" == OM.hash_split[1] ? (OM.Page.admin_assign_center(), 
        OM.page_loaded = !0) : "admin" == OM.hash_split[0] && "center" == OM.hash_split[1] ? (OM.Page.admin_centers(), 
        OM.page_loaded = !0) : "admin" == OM.hash_split[0] && "select-other-option" == OM.hash_split[1] ? (OM.Page.admin_select_other_option(), 
        OM.page_loaded = !0) : "admin" == OM.hash_split[0] && "top-links" == OM.hash_split[1] ? (OM.Page.admin_top_links(), 
        OM.page_loaded = !0) : "admin" == OM.hash_split[0] ? (OM.Page.admin(), OM.page_loaded = !0) : "analysis" == OM.hash_split[0] && (OM.hash_split[1] = void 0 == OM.hash_split[1] ? "" : OM.hash_split[1], 
        OM.Page.analysis(OM.hash_split[1]), OM.page_loaded = !0), 1 == OM.page_loaded && ($("aside a").removeClass("active"), 
        $('aside a[href="' + OM.domain + "#" + OM.hash + '"]').addClass("active"), window.localStorage.setItem(OM.db_prefix + "last_link", OM.hash), 
        OM.last_link = OM.hash, OM.get_data(OM.process + "index.php", {
            code: "click",
            hash: OM.hash
        }))) : window.location.hash = null == OM.last_link || "null" == OM.last_link || void 0 == OM.last_link || "undefined" == OM.last_link || "" == OM.last_link ? "check-in/" : OM.last_link);
    }), OM.before_loading = function() {
        OM.Modal.new("loading", OM.loading_circle, "radius-90");
    }, OM.live_event("input, textarea", "keyup", function() {
        OM.login && ($(this).val().length >= 2 ? OM.Form.validation_effect($(this).attr("id"), "process") : OM.Form.validation_effect($(this).attr("id"), "error"));
    }), OM.live_event('input[type="radio"],input[type="checkbox"]', "click", function() {
        var id = $(this).parent().attr("data-message-id");
        $(this).parent().removeClass("error-border"), OM.error_message_remove("#message-" + id);
    }), OM.live_event('select, input[type="date"]', "change", function() {
        "" != $(this).val() ? OM.Form.validation_effect($(this).attr("id"), "process") : OM.Form.validation_effect($(this).attr("id"), "error");
    }), OM.live_event("#btn-nav", "click", function() {
        $("body").attr("data-move") ? OM.hide_menu() : $("body").attr("data-move", "right");
    }), OM.live_event("aside a", "click", function() {
        OM.hide_menu();
    }), OM.live_event("#menu-cover", "click", function() {
        OM.hide_menu();
    }), OM.live_event("#menu-cover", "touchstart", function(e) {
        e.preventDefault(), OM.hide_menu();
    }), OM.hide_menu = function() {
        $("body").removeAttr("data-move");
    }, OM.live_event(".get-center-by-region", "change", function() {
        var region = $(this).val(), page_name = $(this).attr("data-page_name"), default_center = $(this).attr("data-center"), centers = "", options = '<option value="">Select Center</option>', selected = "";
        switch (region) {
          case "Canada":
            centers = OM.select.region_center[0].centers;
            break;

          case "Midwest":
            centers = OM.select.region_center[1].centers;
            break;

          case "Northeast":
            centers = OM.select.region_center[2].centers;
            break;

          case "Southeast":
            centers = OM.select.region_center[3].centers;
            break;

          case "Southwest":
            centers = OM.select.region_center[4].centers;
            break;

          case "West":
            centers = OM.select.region_center[5].centers;
        }
        for (var a = 0; a < centers.length; a++) {
            var row = centers[a];
            selected = default_center == row.name ? ' selected="selected"' : "", options += '<option value="' + row.name + '" data-bm="' + row.bm + '" data-km="' + row.km + '" data-bst="' + row.bst + '" data-kst="' + row.kst + '" data-campus="' + row.campus + '" data-goshti="' + row.goshti + '" data-lam="' + row.lam + '"' + selected + ">" + row.name + "</option>";
        }
        "" == region ? ($("#" + page_name + "-all-center").slideUp(), $("#" + page_name + "-region-center").html("")) : ($("#" + page_name + "-all-center").slideDown(), 
        $("#" + page_name + "-region-center").html(options));
    }), OM.live_event('[data-list="nest"]>li>[data-title]', "click", function() {
        var color = $(this).parent().parent().attr("data-colorName"), data_id = $(this).attr("data-title");
        ("" == color || void 0 == color) && (color = "inverse"), $(this).next('[data-content="' + data_id + '"]').is(":hidden") ? ($(this).parent().parent().find("li>div[data-content]").slideUp("faster"), 
        $(this).parent().parent().find("li").removeClass("active"), $(this).parent().parent().find("li>[data-title]").removeAttr("data-color"), 
        $(this).next('[data-content="' + data_id + '"]').slideDown(), $(this).parent().addClass("active"), 
        $(this).attr("data-color", color)) : ($(this).next('[data-content="' + data_id + '"]').slideUp("faster"), 
        $(this).parent().removeClass("active"), $(this).removeAttr("data-color"));
    }), OM.live_event("[data-tabNav]>li", "click", function() {
        var id = $(this).attr("data-tabContent-id"), active_tab_id = "";
        active_tab_id = $(this).parent().find(".active").attr("data-tabContent-id"), $(this).parent().find(".active").removeClass("active"), 
        $('[data-tabContent="' + active_tab_id + '"]').removeClass("show").addClass("hide"), 
        $(this).addClass("active"), $('[data-tabContent="' + id + '"').removeClass("hide").addClass("show");
    }), OM.live_event("button[data-href]", "click", function() {
        var href = $(this).attr("data-href");
        window.location.href = href;
    }), OM.live_event("#btn-sync", "click", function() {
        return "disable" != $(this).attr("disable") && ($(this).attr({
            disable: "disable",
            "data-color": "orange"
        }), $(this).children("i").addClass("fa-spin"), OM.sync("sync-btn")), !1;
    });
}), $(".back-link").live("click", function() {
    var parent_id = $(this).parent().attr("id");
    $("#" + parent_id).slideUp(), "form-login" == parent_id ? $("#form-forgot-password").slideDown() : $("#form-login").slideDown();
}), OM.live_event("#form-login", "submit", function() {
    var page_name = "login", email = $("#" + page_name + "-email").val(), pass = $("#" + page_name + "-password").val();
    return $("#" + page_name + "-email, #" + page_name + "-password").removeAttr("data-border"), 
    $("#message-" + page_name).attr({
        "data-message": "",
        "data-ribbon": ""
    }).show(), email ? pass ? ($("#message-" + page_name).html('<i class="fa fa-refresh fa-spin"></i> Verifing your credentials...').attr("data-message", "process"), 
    OM.get_data(OM.process + "index.php", {
        code: "login",
        type: "login",
        email: email,
        password: php_md5(pass)
    }, function(a) {
        $("#message-" + page_name).html("").attr("data-message", ""), a.success ? ($("#message-" + page_name).html('<i class="fa fa-thumbs-up"></i>&nbsp;You are now logged in!').attr("data-message", "success"), 
        OM.login = !0, $("#login-form").slideUp(), $("#login-done").slideDown(), OM.Database.update(a.session), 
        OM.Database.sync()) : $("#message-" + page_name).html('<i class="fa fa-thumbs-down"></i>&nbsp;Invalid login credentials').attr("data-message", "error");
    })) : ($("#" + page_name + "-password").attr("data-border", "error").focus(), $("#message-" + page_name).html('<i class="fa fa-thumbs-down"></i> Please enter your password').attr("data-message", "error")) : ($("#" + page_name + "-email").attr("data-border", "error").focus(), 
    $("#message-" + page_name).html('<i class="fa fa-thumbs-down"></i> Please enter your email').attr("data-message", "error")), 
    !1;
}), OM.live_event("#form-forgot-password", "submit", function() {
    var page_name = "forgot-password", email = $("#" + page_name + "-email").val();
    return $("#" + page_name + "-email").removeAttr("data-border"), $("#message-" + page_name).attr({
        "data-message": "",
        "data-ribbon": ""
    }).show(), email ? ($("#message-" + page_name).html('<i class="fa fa-refresh fa-spin"></i> Verifing your email address...').attr("data-message", "process"), 
    OM.get_data(OM.process + "index.php", {
        code: "login",
        type: "forgot-password",
        email: email
    }, function(a) {
        $("#message-" + page_name).html("").attr("data-message", ""), console.log(a), a.success ? ($("#" + page_name + "-form").slideUp(), 
        $("#" + page_name + "-done").slideDown(), $("#message-" + page_name).hide().removeAttr("data-message", "data-ribbon"), 
        $("#" + page_name + "-email").val("")) : $("#message-" + page_name).html(a.message).attr("data-message", "error");
    })) : ($("#" + page_name + "-email").attr("data-border", "error").focus(), $("#message-" + page_name).html('<i class="fa fa-thumbs-down"></i> Please enter your email').attr("data-message", "error")), 
    !1;
}), OM.live_event("form#reset-password", "submit", function() {
    var page_name = "reset-password", id = $("#" + page_name + "-uid").val(), new_selecter = "#" + page_name + "-new", confirm_selecter = "#" + page_name + "-confirm", new_val = $(new_selecter).val(), confirm_val = $(confirm_selecter).val();
    return OM.reset_form(page_name), $("#message-" + page_name).attr({
        "data-message": "",
        "data-ribbon": ""
    }).show(), null != OM.Validation.password(new_val) ? ($(new_selecter).attr("data-border", "error").focus(), 
    OM.error_message(page_name, new_selecter, OM.Validation.password(new_val))) : null != OM.Validation.confirm_match(new_val, confirm_val, "password") ? ($(confirm_selecter).attr("data-border", "error").focus(), 
    OM.error_message(page_name, confirm_selecter, OM.Validation.confirm_match(new_val, confirm_val, "password"))) : ($("#message-" + page_name).html('<i class="fa fa-refresh fa-spin"></i> Updating your password...').attr("data-message", "process"), 
    OM.get_data(OM.process + "index.php", {
        code: "login",
        type: "reset-password",
        id: id,
        password: php_md5(new_val)
    }, function(a) {
        $("#message-" + page_name).html("").attr("data-message", ""), a.success ? ($("#" + page_name + "-form").slideUp(), 
        $("#" + page_name + "-done").slideDown(), $("#message-" + page_name).html("").removeAttr("data-message", "data-ribbon"), 
        $("#" + page_name + "-new,#" + page_name + "-confirm").val("")) : $("#message-" + page_name).html(a.message).addClass("error-message");
    })), !1;
}), OM.live_event("#check-in-center", "change", function() {
    var value = $(this).val();
    "other-center" == value ? ($("#check-in-assign-center,#check-in-other-option").slideUp(), 
    $("#check-in-all-region").slideDown()) : "other" == value ? ($("#check-in-all-region,#check-in-all-center").slideUp(), 
    $("#check-in-other-option").slideDown()) : $("#check-in-all-region,#check-in-all-center,#check-in-other-option").slideUp();
}), OM.live_event("#check-in-center, #check-in-region-center", "change", function() {
    var page_name = "check-in", id = $(this).attr("id"), value = $(this).val();
    "other" == value || "other-center" == value ? $("#" + page_name + "-sabha").html("").parent().parent().slideUp() : (OM.Form.validation_effect(page_name + "-sabha", "error"), 
    $("#" + page_name + "-sabha").html(OM.Form.change_sabha_type(page_name, id)).parent().parent().slideDown());
}), OM.live_event("form#check-in", "submit", function() {
    return OM.Form.confirm("check-in", "Check-in"), !1;
}), OM.live_event("#btn-confirm-check-in", "click", function() {
    var page_name = "check-in", type_val = $("#" + page_name + "-type").val();
    OM.Modal.close("confirm-" + page_name), OM.Modal.save(page_name, OM.process + "index.php", $.parseJSON(OM.Form.field_json(page_name, '"code":"check-in", "type":"save"')), function(data) {
        OM.Database.update("myCheckIn", data.myCheckIn), OM.Database.update("myVicharanEvents", data.myVicharanEvents), 
        "dialog" == type_val ? (setTimeout(OM.Page.my_vicharan(), 500), OM.Modal.close("check-in")) : setTimeout(OM.Page.check_in(), 500);
    });
}), OM.live_event("form#check-in-comment", "submit", function() {
    return OM.Form.confirm("check-in-comment", "Vicharan Note"), !1;
}), OM.live_event("#btn-confirm-check-in-comment", "click", function() {
    var page_name = "check-in-comment", index = "0" == $("#" + page_name).attr("data-index") ? 0 : parseInt($("#" + page_name).attr("data-index")), vicharan_note_id = OM.myCheckIn[index].vicharan_note_id, check_in_id = OM.myCheckIn[index].id;
    OM.Modal.close("confirm-" + page_name), OM.Modal.save(page_name, OM.process + "index.php", $.parseJSON(OM.Form.field_json(page_name, '"code":"check-in", "type":"save-comment", "id":"' + check_in_id + '", "vicharan_note_id":"' + vicharan_note_id + '"')), function(data) {
        OM.Database.update("myCheckIn", data.myCheckIn), OM.Database.update("vicharanNotes", data.vicharanNotes), 
        setTimeout(function() {
            $("#back-btn").trigger("click");
        }, 500);
    });
});

var form_submit = !1;

OM.live_event("#my-vicharan-center", "change", function() {
    var value = $(this).val();
    "other-center" == value ? ($("#my-vicharan-assign-center,#my-vicharan-other-option").slideUp(), 
    $("#my-vicharan-all-region").slideDown()) : "other" == value ? ($("#my-vicharan-all-region,#my-vicharan-all-center").slideUp(), 
    $("#my-vicharan-other-option").slideDown()) : $("#my-vicharan-all-region,#my-vicharan-all-center,#my-vicharan-other-option").slideUp();
}), OM.live_event("#my-vicharan-center, #my-vicharan-region-center", "change", function() {
    var page_name = "my-vicharan", id = $(this).attr("id"), value = $(this).val();
    "other" == value || "other-center" == value ? $("#" + page_name + "-sabha").html("").parent().parent().slideUp() : (OM.Form.validation_effect(page_name + "-sabha", "error"), 
    $("#" + page_name + "-sabha").html(OM.Form.change_sabha_type(page_name, id)).parent().parent().slideDown());
}), OM.live_event("#btn-save-my-vicharan", "click", function() {
    $("#form-my-vicharan").trigger("submit");
}), OM.live_event("form#my-vicharan", "submit", function() {
    return OM.Form.confirm("my-vicharan", "My Vicharan"), !1;
}), OM.live_event("#btn-confirm-my-vicharan", "click", function() {
    var page_name = "my-vicharan", date = $("#" + page_name + "-date").val();
    OM.Modal.close("confirm-" + page_name), OM.Modal.save(page_name, OM.process + "index.php", $.parseJSON(OM.Form.field_json(page_name, '"code":"my-vicharan", "type":"save"')), function(data) {
        OM.Database.update("myCheckIn", data.myCheckIn), OM.Database.update("myVicharanEvents", data.myVicharanEvents), 
        OM.Modal.close("my-vicharan"), OM.Page.my_vicharan(date);
    });
}), OM.live_event(".btn-remove-my-vicharan", "click", function() {
    var remove_id = $(this).parent().parent().attr("id"), date = $(this).parent().parent().attr("data-date"), index = $(this).parent().parent().attr("data-index"), classes = $(this).parent().parent().attr("data-borderleft"), code = "";
    "0" == index && (index = 0), "check_in" == classes ? code = "check-in" : "vicharan" == classes && (code = "my-vicharan"), 
    OM.Modal.remove("my-vicharan", OM.process + "index.php", {
        code: code,
        type: "remove",
        id: remove_id
    }, function(data) {
        OM.Database.update("myCheckIn", data.myCheckIn), OM.Database.update("myVicharanEvents", data.myVicharanEvents), 
        OM.Page.my_vicharan(date);
    });
}), OM.live_event("#btn-save-my-goals", "click", function() {
    $("#form-my-goals").trigger("submit");
}), OM.live_event("#form-my-goals", "submit", function() {
    var page_name = "my-goals", center_selecter = "#" + page_name + "-center", goal_selecter = "#" + page_name + "-goal", year_selecter = "#" + page_name + "-year", center_val = $(center_selecter + " option:selected").val(), center_text = $(center_selecter + " option:selected").text(), goal_val = $(goal_selecter).val(), year_val = $(year_selecter + " option:selected").val(), year_text = $(year_selecter + " option:selected").text(), error = !1;
    if ($(".error-" + page_name).remove(), center_val || (error = !0, OM.error_message(page_name, center_selecter, "Please select a center")), 
    goal_val || (error = !0, OM.error_message(page_name, goal_selecter, "Please enter goal")), 
    year_val || (error = !0, OM.error_message(page_name, year_selecter, "Please select a year")), 
    0 == error) {
        var year_show = "";
        OM.Date.month() < 11 && (year_show = 'class="hidden"'), OM.Modal.confirm(page_name, "Add my goal", OM.Page.row(Array(Array({
            attr: ""
        }, Array("field", "Center"), Array("value", center_text)), Array({
            attr: ""
        }, Array("field", "Goal"), Array("value", goal_val)), Array({
            attr: year_show
        }, Array("field", "Year"), Array("value", year_text))), 'data-list="form"'));
    }
    return !1;
}), OM.live_event("#btn-confirm-my-goals", "click", function() {
    var page_name = "my-goals", center_selecter = "#" + page_name + "-center", goal_selecter = "#" + page_name + "-goal", year_selecter = "#" + page_name + "-year", center_val = $(center_selecter).val(), goal_val = $(goal_selecter).val(), year_val = $(year_selecter).val();
    OM.Modal.close("confirm-" + page_name), OM.Modal.save(page_name, OM.process + "index.php", {
        code: "my-goals",
        type: "save",
        center: center_val,
        goal: goal_val,
        year: year_val,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && (OM.Modal.close("my-goals"), OM.sync("my-goals"));
    }, 2500);
}), OM.live_event(".edit-my-goals", "click", function() {
    var page_name = "edit-my-goals";
    id = $(this).attr("data-id"), center = $(this).attr("data-center"), goal = $(this).html(), 
    OM.Modal.new(page_name, OM.Modal.format("Edit: My Goal", OM.Button.close({
        page_name: page_name,
        color: !0,
        icon: !0
    }), '<form id="form-' + page_name + '">' + OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Center"), Array("value", center)), Array({
        attr: ""
    }, Array("field", "Goal"), Array("value", '<div><input type="number" id="' + page_name + '-goal" value="' + goal + '" min="0" max="99"></div><div class="note">Enter "0" to remove this center from your goal list.<br>List on My Goals page will update when you reload this page.</div>'))), 'data-list="form"') + '<div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Submit"
    }) + '</div><input type="hidden" id="' + page_name + '-id" value="' + id + '"></form>'));
}), OM.live_event("#btn-save-edit-my-goals", "click", function() {
    $("#form-edit-my-goals").trigger("submit");
}), OM.live_event("#form-edit-my-goals", "submit", function() {
    var page_name = "edit-my-goals";
    return id_val = $("#" + page_name + "-id").val(), goal_val = $("#" + page_name + "-goal").val(), 
    OM.Modal.hide("edit-my-goals"), OM.Modal.save(page_name, OM.process + "index.php", {
        code: "my-goals",
        type: "save-edit",
        goal: goal_val,
        id: id_val,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save ? (OM.Modal.close("edit-my-goals"), $('.edit-my-goals[data-id="' + id_val + '"]').html(goal_val), 
        OM.sync("none")) : OM.Modal.show("edit-my-goals");
    }, 2500), !1;
}), OM.live_event(".btn-remove-setting-check-in", "click", function() {
    var page_name = "setting-check-in", id = $(this).attr("data-id");
    OM.Modal.remove(page_name, OM.process + "index.php", {
        code: "settings",
        type: "remove-check-in",
        id: id,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_remove = $("#data-remove").val();
        "success" == data_remove && OM.sync("setting-check-in");
    }, 2500);
}), OM.live_event("#btn-save-setting-password", "click", function() {
    $("#form-setting-password").trigger("submit");
}), OM.live_event("#form-setting-password", "submit", function() {
    var page_name = "setting-password", new_selecter = "#" + page_name + "-new", confirm_selecter = "#" + page_name + "-confirm", new_val = $.trim($(new_selecter).val()), confirm_val = $.trim($(confirm_selecter).val()), validate_new = OM.Validation.password(new_val), error = !1;
    return $(".error-" + page_name).remove(), new_val ? confirm_val ? 1 != validate_new ? (console.log("validate_new"), 
    error = !0, OM.error_message(page_name, new_selecter, validate_new)) : new_val !== confirm_val && (console.log("confirm_val"), 
    error = !0, OM.error_message(page_name, confirm_selecter, "Confirm password does not match")) : (console.log("confirm_val"), 
    error = !0, OM.error_message(page_name, confirm_selecter, "Please enter confirm password")) : (console.log("new_val"), 
    error = !0, OM.error_message(page_name, new_selecter, "please enter new password")), 
    0 == error && (OM.Modal.save(page_name, OM.process + "index.php", {
        code: "settings",
        type: "save-password",
        password: php_md5(confirm_val),
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && $("#back-btn").trigger("click");
    }, 2500)), !1;
}), OM.live_event("#btn-save-setting-profile", "click", function() {
    $("#form-setting-profile").trigger("submit");
}), OM.live_event("#form-setting-profile", "submit", function() {
    var page_name = "setting-profile", first_name_selecter = "#" + page_name + "-first_name", last_name_selecter = "#" + page_name + "-last_name", email_selecter = "#" + page_name + "-email", region_selecter = "#" + page_name + "-region", region_center_selecter = "#" + page_name + "-region-center", first_name_val = $(first_name_selecter).val(), last_name_val = $(last_name_selecter).val(), email_val = $(email_selecter).val(), region_val = $(region_selecter + " option:selected").val(), region_text = $(region_selecter + " option:selected").text(), region_center_val = $(region_center_selecter + " option:selected").val(), region_center_text = $(region_center_selecter + " option:selected").text(), error = !1;
    return $(".error-" + page_name).remove(), first_name_val || (error = !0, OM.error_message(page_name, first_name_selecter, "Please enter first name")), 
    last_name_val || (error = !0, OM.error_message(page_name, last_name_selecter, "Please enter last name")), 
    email_val || (error = !0, OM.error_message(page_name, email_selecter, "Please enter email address")), 
    region_val || (error = !0, OM.error_message(page_name, region_selecter, "Please select region")), 
    region_center_val || (error = !0, OM.error_message(page_name, region_center_selecter, "Please select center")), 
    0 == error && OM.Modal.confirm(page_name, "Profile", OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Name"), Array("value", first_name_val + " " + last_name_val)), Array({
        attr: ""
    }, Array("field", "Email Address"), Array("value", email_val)), Array({
        attr: ""
    }, Array("field", "Region"), Array("value", region_text)), Array({
        attr: ""
    }, Array("field", "Center"), Array("value", region_center_text))), 'data-list="form"')), 
    !1;
}), OM.live_event("#btn-confirm-setting-profile", "click", function() {
    var page_name = "setting-profile", first_name_val = $("#" + page_name + "-first_name").val(), last_name_val = $("#" + page_name + "-last_name").val(), email_val = $("#" + page_name + "-email").val(), region_val = $("#" + page_name + "-region option:selected").val(), center_val = $("#" + page_name + "-region-center option:selected").val();
    OM.Modal.save(page_name, OM.process + "index.php", {
        code: "settings",
        type: "save-profile",
        first_name: first_name_val,
        last_name: last_name_val,
        email: email_val,
        region: region_val,
        center: center_val,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && (OM.Modal.close("confirm-" + page_name), OM.session.fn = first_name_val, 
        OM.session.ln = last_name_val, OM.session.e = email_val, OM.session.region = region_val, 
        OM.session.center = center_val, $("#back-btn").trigger("click"));
    }, 2500);
}), OM.live_event(".btn-edit-admin-assign-center", "click", function() {
    var page_name = "admin-assign-center", id = $(this).attr("data-id"), index = $(this).attr("data-index").split(","), checked = "", mandal_lists = "", content = "", group = OM.admasigncntr[index[0]].group2, name = OM.admasigncntr[index[0]].regions[index[1]].users[index[2]].user, id = OM.admasigncntr[index[0]].regions[index[1]].users[index[2]].centers[index[3]].id, center = OM.admasigncntr[index[0]].regions[index[1]].users[index[2]].centers[index[3]].center, row = OM.admasigncntr[index[0]].regions[index[1]].users[index[2]].centers[index[3]], bal = new Array(row.bm, row.bst), bal_name = new Array("BM", "BST"), kishore = new Array(row.km, row.kst, row.campus), kishore_name = new Array("KM", "KST", "Campus");
    if ("B" == group || "C" == group) for (var a = 0; 2 > a; a++) checked = "Y" == bal[a] ? "checked" : "", 
    mandal_lists += '<li><div class="field">' + bal_name[a] + '</div><div class="value checkbox yes-no"><input type="checkbox" id="edit-' + page_name + "-" + bal_name[a] + '" value="Y" class="mandal-' + page_name + '" placeholder="' + bal_name[a] + '" ' + checked + '><label for="edit-' + page_name + "-" + bal_name[a] + '"><div class="inner"></div><div class="btn-switch"></div></label></div></li>';
    if ("K" == group || "C" == group) {
        checked = "";
        for (var a = 0; 3 > a; a++) checked = "Y" == kishore[a] ? "checked" : "", mandal_lists += '<li><div class="field">' + kishore_name[a] + '</div><div class="value checkbox yes-no"><input type="checkbox" id="edit-' + page_name + "-" + kishore_name[a] + '" value="Y" class="mandal-' + page_name + '" placeholder="' + kishore_name[a] + '" ' + checked + '><label for="edit-' + page_name + "-" + kishore_name[a] + '"><div class="inner"></div><div class="btn-switch"></div></label></div></li>';
    }
    mandal_lists && (mandal_lists = '<ul id="edit-' + page_name + '-li" data-list="form">' + mandal_lists + '</ul><div class="btn"><button data-button data-color="red" id="btn-remove-' + page_name + '">Remove this center</button> ' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Save"
    }) + '</div><input type="hidden" id="id-' + page_name + '" value="' + id + '">'), 
    content = '<h3 class="text-center">' + center + "</h3>" + mandal_lists, OM.Modal.new("edit-" + page_name, OM.Modal.format("Edit: " + name + " Center", OM.Button.close({
        page_name: "edit-" + page_name,
        color: !0,
        icon: !0
    }), content));
}), OM.live_event("#btn-save-admin-assign-center", "click", function() {
    for (var page_name = "admin-assign-center", id = $("#id-" + page_name).val(), mandals = $("#edit-" + page_name + "-li").find(".mandal-" + page_name), post = "", a = 0; a < mandals.length; a++) post += mandals[a].checked ? mandals[a].placeholder.toLowerCase() + "='Y'" : mandals[a].placeholder.toLowerCase() + "=NULL", 
    a < mandals.length - 1 && (post += ",");
    OM.Modal.save(page_name, OM.process + "index.php", {
        code: "admin",
        type: "edit-assign-center",
        id: id,
        value: post,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && (OM.Modal.close("edit-" + page_name), OM.sync("admin-assign-center"));
    }, 2500);
}), OM.live_event("#btn-remove-admin-assign-center", "click", function() {
    var page_name = "admin-assign-center", id = $("#id-" + page_name).val();
    OM.Modal.remove(page_name, OM.process + "index.php", {
        code: "admin",
        type: "remove-assign-center",
        id: id,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_remove = $("#data-remove").val();
        "success" == data_remove && (OM.Modal.close("edit-" + page_name), OM.sync("admin-assign-center"));
    }, 2500);
}), OM.live_event("#admin-assign-center-add-region-center", "change", function() {
    var page_name = "admin-assign-center-add", id = $(this).attr("id"), value = $(this).val();
    "" == value ? $("#" + page_name + "-mandal > .value").html("").parent().slideUp() : $("#" + page_name + "-mandal > .value").html(OM.Form.change_mandal_on_off(page_name, id)).parent().slideDown();
}), OM.live_event("#btn-save-admin-assign-center-add", "click", function() {
    $("#form-admin-assign-center-add").trigger("submit");
}), OM.live_event("#form-admin-assign-center-add", "submit", function() {
    var page_name = "admin-assign-center-add", user_selecter = "#" + page_name + "-user", region_selecter = "#" + page_name + "-region", region_center_selecter = "#" + page_name + "-region-center", user_val = $(user_selecter + " option:selected").val(), user_text = $(user_selecter + " option:selected").text(), region_val = $(region_selecter + " option:selected").val(), region_text = $(region_selecter + " option:selected").text(), region_center_val = $(region_center_selecter + " option:selected").val(), region_center_text = $(region_center_selecter + " option:selected").text(), mandals = $("#" + page_name + "-mandal").find(".mandal-" + page_name + ":checked"), mandal_text = "", error = !1;
    $(".error-" + page_name).remove();
    for (var a = 0; a < mandals.length; a++) mandal_text += mandals[a].placeholder, 
    a < Math.abs(mandals.length - 1) && (mandal_text += ", ");
    return user_val || (error = !0, OM.error_message(page_name, user_selecter, "Please select RC's name")), 
    region_val || (error = !0, OM.error_message(page_name, region_selecter, "Please select region")), 
    region_center_val || (error = !0, OM.error_message(page_name, region_center_selecter, "Please select center")), 
    0 == error && OM.Modal.confirm(page_name, "Assign Center", OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Name"), Array("value", user_text)), Array({
        attr: ""
    }, Array("field", "Region"), Array("value", region_text)), Array({
        attr: ""
    }, Array("field", "Center"), Array("value", region_center_text)), Array({
        attr: ""
    }, Array("field", "Mandal"), Array("value", mandal_text))), 'data-list="form"')), 
    !1;
}), OM.live_event("#btn-confirm-admin-assign-center-add", "click", function() {
    for (var page_name = "admin-assign-center-add", user_selecter = "#" + page_name + "-user", region_selecter = "#" + page_name + "-region", region_center_selecter = "#" + page_name + "-region-center", user_val = $(user_selecter + " option:selected").val(), region_val = ($(user_selecter + " option:selected").text(), 
    $(region_selecter + " option:selected").val()), region_center_val = ($(region_selecter + " option:selected").text(), 
    $(region_center_selecter + " option:selected").val()), mandals = ($(region_center_selecter + " option:selected").text(), 
    $("#" + page_name + "-mandal").find(".mandal-" + page_name)), mandal_val = "", a = 0; a < mandals.length; a++) mandal_val += mandals[a].checked ? mandals[a].placeholder.toLowerCase() + "='Y'" : mandals[a].placeholder.toLowerCase() + "=NULL", 
    a < Math.abs(mandals.length - 1) && (mandal_val += ",");
    OM.Modal.close("confirm-" + page_name), OM.Modal.save(page_name, OM.process + "index.php", {
        code: "admin",
        type: "add-assign-center",
        id: user_val,
        region: region_val,
        center: region_center_val,
        mandal: mandal_val,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && OM.sync("admin-assign-center");
    }, 2500);
}), OM.live_event(".btn-edit-admin-centers", "click", function() {
    function render_status(page_name, mandal, status) {
        for (var status_value = new Array("", "A", "B", "C", "R"), status_text = new Array("None", "A", "B", "C", "R"), checked = "", render = "", a = 0; a < status_value.length; a++) checked = status_value[a] == status ? "checked" : "", 
        render += '<input type="radio" name="' + page_name + '-status" id="' + page_name + "-status-" + status_value[a] + '" value="' + status_value[a] + '" ' + checked + '><label for="' + page_name + "-status-" + status_value[a] + '">' + status_text[a] + "</label>";
        return '<div class="radio" data-radio="' + a + '" data-mandal="' + mandal + '">' + render + '<span class="slide-button"></span></div>';
    }
    var page_name = "admin-centers", id = $(this).attr("data-id"), index = $(this).attr("data-index").split(","), checked = "", mandal_lists = "", group = OM.session.group, id = OM.select.region_center[index[0]].centers[index[1]].id, center = OM.select.region_center[index[0]].centers[index[1]].name, row = OM.select.region_center[index[0]].centers[index[1]], kishore = new Array(row.kst, row.campus), kishore_name = new Array("KST", "Campus");
    if (("B" == group || "C" == group) && (checked = "Y" == row.bst ? "checked" : "", 
    mandal_lists += '<li><div class="field">Bal/ika Mandal</div><div class="value">' + render_status(page_name, "bm", row.bm) + '</div></li><li class="float"><div class="field">BST</div><div class="value"><div class="checkbox yes-no"><input type="checkbox" id="edit-' + page_name + '-bst" value="Y" class="mandal-' + page_name + '" placeholder="BST" data-name="BST" ' + checked + '><label for="edit-' + page_name + '-bst"><div class="inner"></div><div class="btn-switch"></div></label></div></div></li>'), 
    "K" == group || "C" == group) {
        checked = "", mandal_lists += '<li><div class="field">Kishore/i Mandal</div><div class="value">' + render_status(page_name, "km", row.km) + "</div></li>";
        for (var a = 0; 2 > a; a++) checked = "Y" == kishore[a] ? "checked" : "", mandal_lists += '<li class="float"><div class="field">' + kishore_name[a] + '</div><div class="value"><div class="checkbox yes-no"><input type="checkbox" id="edit-' + page_name + "-" + kishore_name[a] + '" value="Y" class="mandal-' + page_name + '" placeholder="' + kishore_name[a] + '" data-name="' + kishore_name[a] + '" ' + checked + '><label for="edit-' + page_name + "-" + kishore_name[a] + '"><div class="inner"></div><div class="btn-switch"></div></label></div></div></li>';
    }
    mandal_lists && (mandal_lists = '<ul id="edit-' + page_name + '-li" data-list="form">' + mandal_lists + '<li><div class="align-center"><button data-button data-color="red" id="btn-remove-' + page_name + '">Remove this center</button></div><div class="note">This center will only be removed from this list. Other data (assign center, checked-in and my goals) will not remove. You have to remove them menually.</div></li></ul><div class="btn">' + OM.Button.save({
        page_name: page_name,
        color: !0,
        icon: !0,
        text: "Save"
    }) + '</div><input type="hidden" id="id-' + page_name + '" value="' + id + '">'), 
    OM.Modal.new("edit-" + page_name, OM.Modal.format("Edit: " + center + " Mandal", OM.Button.close({
        page_name: "edit-" + page_name,
        color: !0,
        icon: !0
    }), mandal_lists));
}), OM.live_event("#btn-save-admin-centers", "click", function() {
    var page_name = "admin-centers", id = $("#id-" + page_name).val(), status = $('input[name="' + page_name + '-status"]:checked').val(), mandal = $('input[name="' + page_name + '-status"]:checked').parent().attr("data-mandal"), mandals = $("#edit-" + page_name + "-li").find(".mandal-" + page_name), post = "";
    post += "" == status ? mandal + "=NULL," : mandal + "='" + status + "',";
    for (var a = 0; a < mandals.length; a++) console.log(mandals[a].getAttribute("data-name")), 
    post += mandals[a].checked ? mandals[a].getAttribute("data-name").toLowerCase() + "='Y'" : mandals[a].getAttribute("data-name").toLowerCase() + "=NULL", 
    a < Math.abs(mandals.length - 1) && (post += ",");
    OM.Modal.save(page_name, OM.process + "index.php", {
        code: "admin",
        type: "edit-centers",
        id: id,
        value: post,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && (OM.Modal.close("edit-" + page_name), OM.sync("admin-centers"));
    }, 2500);
}), OM.live_event("#btn-remove-admin-centers", "click", function() {
    var page_name = "admin-centers", id = $("#id-" + page_name).val();
    OM.Modal.remove(page_name, OM.process + "index.php", {
        code: "admin",
        type: "remove-centers",
        id: id,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_remove = $("#data-remove").val();
        "success" == data_remove && (OM.Modal.close("edit-" + page_name), OM.sync("admin-centers"));
    }, 2500);
}), OM.live_event("#btn-save-admin-centers-add", "click", function() {
    $("#form-admin-centers-add").trigger("submit");
}), OM.live_event("#form-admin-centers-add", "submit", function() {
    var page_name = "admin-centers-add", region_selecter = "#" + page_name + "-region", center_selecter = "#" + page_name + "-center", region_val = $(region_selecter + " option:selected").val(), region_text = $(region_selecter + " option:selected").text(), center_val = $(center_selecter).val(), status_val = $('input[name="' + page_name + '-status"]:checked').val(), status_text = $('input[name="' + page_name + '-status"]:checked+label').text(), status_name = $('input[name="' + page_name + '-status"]:checked').parent().parent().parent().find(".field").text(), mandals = $("#form-" + page_name).find(".mandal-" + page_name + ":checked"), mandal_text = "", error = !1;
    $(".error-" + page_name).remove(), status_val && (mandal_text += status_name + "(" + status_text + "), ");
    for (var a = 0; a < mandals.length; a++) mandal_text += mandals[a].placeholder, 
    a < Math.abs(mandals.length - 1) && (mandal_text += ", ");
    return region_val || (error = !0, OM.error_message(page_name, region_selecter, "Please select a region")), 
    center_val || (error = !0, OM.error_message(page_name, center_selecter, "Please enter center name")), 
    0 == error && OM.Modal.confirm(page_name, "Assign Center", OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Region"), Array("value", region_text)), Array({
        attr: ""
    }, Array("field", "Center"), Array("value", center_val)), Array({
        attr: ""
    }, Array("field", "Mandal"), Array("value", mandal_text))), 'data-list="form"')), 
    !1;
}), OM.live_event("#btn-confirm-admin-centers-add", "click", function() {
    var page_name = "admin-centers-add", region_selecter = "#" + page_name + "-region", center_selecter = "#" + page_name + "-center", region_val = $(region_selecter + " option:selected").val(), center_val = $(center_selecter).val(), status_val = $('input[name="' + page_name + '-status"]:checked').val(), mandal = $('input[name="' + page_name + '-status"]:checked').parent().attr("data-mandal"), mandals = $("#form-" + page_name).find(".mandal-" + page_name), mandal_val = "";
    mandal_val += "" == status_val ? mandal + "=NULL," : mandal + "='" + status_val + "',";
    for (var a = 0; a < mandals.length; a++) mandal_val += mandals[a].checked ? mandals[a].placeholder.toLowerCase() + "='Y'" : mandals[a].placeholder.toLowerCase() + "=NULL", 
    a < Math.abs(mandals.length - 1) && (mandal_val += ",");
    OM.Modal.close("confirm-" + page_name), OM.Modal.save(page_name, OM.process + "index.php", {
        code: "admin",
        type: "add-centers",
        region: region_val,
        center: center_val,
        mandal: mandal_val,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && (OM.Modal.close(page_name), OM.sync("admin-centers"));
    }, 2500);
}), OM.live_event("#btn-save-admin-select-other-option", "click", function() {
    $("#form-admin-select-other-option").trigger("submit");
}), OM.live_event("#form-admin-select-other-option", "submit", function() {
    var page_name = "admin-select-other-option", new_selecter = "#" + page_name + "-new", new_val = $(new_selecter).val(), error = !1;
    return $(".error-" + page_name).remove(), new_val || (error = !0, OM.error_message(page_name, new_selecter, "Please enter new option")), 
    0 == error && OM.Modal.confirm(page_name, "New Option", OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "New Option"), Array("value", new_val))), 'data-list="form"')), 
    !1;
}), OM.live_event("#btn-confirm-admin-select-other-option", "click", function() {
    var page_name = "admin-select-other-option", new_val = $("#" + page_name + "-new").val();
    OM.Modal.save(page_name, OM.process + "index.php", {
        code: "admin",
        type: "add-select-other-option",
        value: new_val,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && (OM.Modal.close("confirm-" + page_name), OM.sync("admin-select-other-option"));
    }, 2500);
}), OM.live_event(".btn-remove-admin-select-other-option", "click", function() {
    var page_name = "admin-select-other-option", value = $(this).attr("data-value");
    OM.Modal.remove(page_name, OM.process + "index.php", {
        code: "admin",
        type: "remove-select-other-option",
        value: value,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_remove = $("#data-remove").val();
        "success" == data_remove && OM.sync("admin-select-other-option");
    }, 2500);
}), OM.live_event("#btn-save-admin-profile-add", "click", function() {
    $("#form-admin-profile-add").trigger("submit");
}), OM.live_event("#form-admin-profile-add", "submit", function() {
    var page_name = "admin-profile-add", first_name_selecter = "#" + page_name + "-first_name", last_name_selecter = "#" + page_name + "-last_name", email_selecter = "#" + page_name + "-email", region_selecter = "#" + page_name + "-region", region_center_selecter = "#" + page_name + "-region-center", user_level_selecter = "#" + page_name + "-user_level", gender_selecter = 'input[name="' + page_name + '-gender"]', mandal_selecter = 'input[name="' + page_name + '-mandal"]', first_name_val = $(first_name_selecter).val(), last_name_val = $(last_name_selecter).val(), email_val = $(email_selecter).val(), region_val = $(region_selecter + " option:selected").val(), region_text = $(region_selecter + " option:selected").text(), region_center_val = $(region_center_selecter + " option:selected").val(), region_center_text = $(region_center_selecter + " option:selected").text(), user_level_val = $(user_level_selecter + " option:selected").val(), user_level_text = $(user_level_selecter + " option:selected").text(), gender_val = $(gender_selecter + ":checked").val(), gender_text = $('label[for="' + $(gender_selecter + ":checked").attr("id") + '"]').text(), mandal_val = $(mandal_selecter + ":checked").val(), mandal_text = $('label[for="' + $(mandal_selecter + ":checked").attr("id") + '"]').text(), error = !1;
    return $(".error-" + page_name).remove(), first_name_val || (error = !0, OM.error_message(page_name, first_name_selecter, "Please enter first name")), 
    last_name_val || (error = !0, OM.error_message(page_name, last_name_selecter, "Please enter last name")), 
    email_val || (error = !0, OM.error_message(page_name, email_selecter, "Please enter email")), 
    region_val || (error = !0, OM.error_message(page_name, region_selecter, "Please select region")), 
    region_center_val || (error = !0, OM.error_message(page_name, region_center_selecter, "Please select center")), 
    user_level_val || (error = !0, OM.error_message(page_name, user_level_selecter, "Please select user level")), 
    gender_val || (error = !0, OM.error_message(page_name, gender_selecter, "Please select a gender")), 
    mandal_val || (error = !0, OM.error_message(page_name, mandal_selecter, "Please select a mandal")), 
    0 == error && OM.Modal.confirm(page_name, "Profile", OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Name"), Array("value", first_name_val + " " + last_name_val)), Array({
        attr: ""
    }, Array("field", "Email Address"), Array("value", email_val)), Array({
        attr: ""
    }, Array("field", "Gender"), Array("value", gender_text)), Array({
        attr: ""
    }, Array("field", "Mandal"), Array("value", mandal_text)), Array({
        attr: ""
    }, Array("field", "Region"), Array("value", region_text)), Array({
        attr: ""
    }, Array("field", "Center"), Array("value", region_center_text)), Array({
        attr: ""
    }, Array("field", "User Level"), Array("value", user_level_text))), 'data-list="form"')), 
    !1;
}), OM.live_event("#btn-confirm-admin-profile-add", "click", function() {
    var page_name = "admin-profile-add", first_name_selecter = "#" + page_name + "-first_name", last_name_selecter = "#" + page_name + "-last_name", email_selecter = "#" + page_name + "-email", region_selecter = "#" + page_name + "-region", region_center_selecter = "#" + page_name + "-region-center", user_level_selecter = "#" + page_name + "-user_level", gender_selecter = 'input[name="' + page_name + '-gender"]', mandal_selecter = 'input[name="' + page_name + '-mandal"]', first_name_val = $(first_name_selecter).val(), last_name_val = $(last_name_selecter).val(), email_val = $(email_selecter).val(), region_val = $(region_selecter + " option:selected").val(), region_center_val = $(region_center_selecter + " option:selected").val(), user_level_val = $(user_level_selecter + " option:selected").val(), gender_val = $(gender_selecter + ":checked").val();
    mandal_val = $(mandal_selecter + ":checked").val(), OM.Modal.save(page_name, OM.process + "index.php", {
        code: "admin",
        type: "add-profile",
        first_name: first_name_val,
        last_name: last_name_val,
        email: email_val,
        region: region_val,
        center: region_center_val,
        user_level: user_level_val,
        gender: gender_val,
        group: mandal_val,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && (OM.Modal.close("confirm-" + page_name), OM.sync("admin-profiles"));
    }, 2500);
}), OM.live_event("#btn-save-admin-profile-edit", "click", function() {
    $("#form-admin-profile-edit").trigger("submit");
}), OM.live_event("#form-admin-profile-edit", "submit", function() {
    var page_name = "admin-profile-edit", first_name_selecter = "#" + page_name + "-first_name", last_name_selecter = "#" + page_name + "-last_name", email_selecter = "#" + page_name + "-email", region_selecter = "#" + page_name + "-region", region_center_selecter = "#" + page_name + "-region-center", user_level_selecter = "#" + page_name + "-user_level", gender_selecter = 'input[name="' + page_name + '-gender"]', mandal_selecter = 'input[name="' + page_name + '-mandal"]', first_name_val = $(first_name_selecter).val(), last_name_val = $(last_name_selecter).val(), email_val = $(email_selecter).val(), region_val = $(region_selecter + " option:selected").val(), region_text = $(region_selecter + " option:selected").text(), region_center_val = $(region_center_selecter + " option:selected").val(), region_center_text = $(region_center_selecter + " option:selected").text(), user_level_val = $(user_level_selecter + " option:selected").val(), user_level_text = $(user_level_selecter + " option:selected").text(), gender_val = $(gender_selecter + ":checked").val(), gender_text = $('label[for="' + $(gender_selecter + ":checked").attr("id") + '"]').text(), mandal_val = $(mandal_selecter + ":checked").val(), mandal_text = $('label[for="' + $(mandal_selecter + ":checked").attr("id") + '"]').text(), error = !1;
    return $(".error-" + page_name).remove(), first_name_val || (error = !0, OM.error_message(page_name, first_name_selecter, "Please enter first name")), 
    last_name_val || (error = !0, OM.error_message(page_name, last_name_selecter, "Please enter last name")), 
    email_val || (error = !0, OM.error_message(page_name, email_selecter, "Please enter email")), 
    region_val || (error = !0, OM.error_message(page_name, region_selecter, "Please select region")), 
    region_center_val || (error = !0, OM.error_message(page_name, region_center_selecter, "Please select center")), 
    user_level_val || (error = !0, OM.error_message(page_name, user_level_selecter, "Please select user level")), 
    gender_val || (error = !0, OM.error_message(page_name, gender_selecter, "Please select a gender")), 
    mandal_val || (error = !0, OM.error_message(page_name, mandal_selecter, "Please select a mandal")), 
    0 == error && OM.Modal.confirm(page_name, "Profile", OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Name"), Array("value", first_name_val + " " + last_name_val)), Array({
        attr: ""
    }, Array("field", "Email Address"), Array("value", email_val)), Array({
        attr: ""
    }, Array("field", "Gender"), Array("value", gender_text)), Array({
        attr: ""
    }, Array("field", "Mandal"), Array("value", mandal_text)), Array({
        attr: ""
    }, Array("field", "Region"), Array("value", region_text)), Array({
        attr: ""
    }, Array("field", "Center"), Array("value", region_center_text)), Array({
        attr: ""
    }, Array("field", "User Level"), Array("value", user_level_text))), 'data-list="form"')), 
    !1;
}), OM.live_event("#btn-confirm-admin-profile-edit", "click", function() {
    var page_name = "admin-profile-edit", first_name_selecter = "#" + page_name + "-first_name", last_name_selecter = "#" + page_name + "-last_name", email_selecter = "#" + page_name + "-email", region_selecter = "#" + page_name + "-region", region_center_selecter = "#" + page_name + "-region-center", user_level_selecter = "#" + page_name + "-user_level", gender_selecter = 'input[name="' + page_name + '-gender"]', mandal_selecter = 'input[name="' + page_name + '-mandal"]', first_name_val = $(first_name_selecter).val(), last_name_val = $(last_name_selecter).val(), email_val = $(email_selecter).val(), region_val = $(region_selecter + " option:selected").val(), region_center_val = $(region_center_selecter + " option:selected").val(), user_level_val = $(user_level_selecter + " option:selected").val(), gender_val = $(gender_selecter + ":checked").val(), mandal_val = $(mandal_selecter + ":checked").val(), id = $("#" + page_name + "-id").val();
    OM.Modal.save(page_name, OM.process + "index.php", {
        code: "admin",
        type: "edit-profile",
        first_name: first_name_val,
        last_name: last_name_val,
        email: email_val,
        region: region_val,
        center: region_center_val,
        user_level: user_level_val,
        group: mandal_val,
        gender: gender_val,
        id: id,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && (OM.Modal.close("confirm-" + page_name), OM.sync("admin-profiles"));
    }, 2500);
}), OM.live_event("#btn-reset-password-admin-profile-edit", "click", function() {
    var page_name = "reset-password-admin-profile-edit", id = $(this).attr("data-id");
    OM.Modal.new(page_name, OM.Modal.format("Reseting password...", "", OM.loading_circle)), 
    OM.get_data(OM.process + "index.php", {
        code: "admin",
        type: "reset-password",
        id: id,
        token: OM.session.t,
        uid: OM.session.u
    }, function(data) {
        1 == data.login && ("success" == data.status ? OM.Modal.change_content(page_name, OM.Modal.format("Success reseting password", OM.Button.close({
            page_name: page_name,
            color: !0,
            icon: !0
        }), OM.message("<h3>The new password is firstname and lastname <strong>All lowercase</strong></h3>"))) : "error" == data.status && OM.Modal.change_content(page_name, OM.Modal.format("Error reseting passowrd", OM.Button.close({
            page_name: page_name,
            color: !0,
            icon: !0
        }), OM.message("<h3>" + data.message + "</h3><p><u>Error message:</u> " + data.error + "</p>"))));
    });
}), OM.live_event("#btn-active-admin-profile-edit", "click", function() {
    var page_name = "admin-profile-edit-active", id = $(this).attr("data-id"), value = $(this).attr("data-value"), title = "";
    title = "Y" == value ? "Activating profile..." : "Deactivating profile...", OM.Modal.new(page_name, OM.Modal.format(title, "", OM.loading_circle)), 
    OM.get_data(OM.process + "index.php", {
        code: "admin",
        type: "active-profile",
        id: id,
        value: value,
        token: OM.session.t,
        uid: OM.session.u
    }, function(data) {
        1 == data.login && ("success" == data.status && OM.Page.admin_profile_edit(id, ""), 
        OM.Modal.change_content(page_name, OM.Modal.format(data.title, OM.Button.close({
            page_name: page_name,
            color: !0,
            icon: !0
        }), OM.message(data.message + data.error))));
    });
}), OM.live_event("#vicharan-notes-center", "change", function() {
    var value = $(this).val();
    "other-center" == value && ($("#vicharan-notes-assign-center").slideUp(), $("#vicharan-notes-all-region").slideDown());
}), OM.live_event("#vicharan-notes-center, #vicharan-notes-region-center", "change", function() {
    var page_name = "vicharan-notes", id = $(this).attr("id"), value = $(this).val();
    "other-center" == value ? $("#" + page_name + "-mandal > .value").html("").parent().slideUp() : $("#" + page_name + "-mandal > .value").html(OM.Form.change_mandal(page_name, id)).parent().slideDown();
}), OM.live_event("#form-vicharan-notes", "submit", function() {
    var page_name = "vicharan-notes", date_selecter = "#" + page_name + "-date", center_selecter = "#" + page_name + "-center", region_selecter = "#" + page_name + "-region", region_center_selecter = "#" + page_name + "-region-center", mandal_selecter = 'input[name="' + page_name + '-mandal"]', positive_points_selecter = "#" + page_name + "-positive_points", issues_selecter = "#" + page_name + "-issues", follow_up_list_selecter = "#" + page_name + "-follow_up_list", other_comment_selecter = "#" + page_name + "-other_comment", email_selecter = "#" + page_name + "-email", date_val = $(date_selecter).val(), center_val = $(center_selecter + " option:selected").val(), center_text = $(center_selecter + " option:selected").text(), region_val = $(region_selecter + " option:selected").val(), region_text = $(region_selecter + " option:selected").text(), region_center_val = $(region_center_selecter + " option:selected").val(), region_center_text = $(region_center_selecter + " option:selected").text(), mandal_val = $(mandal_selecter + ":checked").val(), mandal_text = $('label[for="' + $('input[name="' + page_name + '-mandal"]:checked').attr("id") + '"]').text(), positive_points_val = $(positive_points_selecter).val(), issues_val = $(issues_selecter).val(), follow_up_list_val = $(follow_up_list_selecter).val(), other_comment_val = $(other_comment_selecter).val(), email_val = $(email_selecter + ":checked").val(), error = !1;
    return $(".error-" + page_name).remove(), date_val || (error = !0, OM.error_message(page_name, date_selecter, "Please enter a date")), 
    center_val ? mandal_val || (error = !0, OM.error_message(page_name, mandal_selecter, "Please select a mandal")) : (error = !0, 
    OM.error_message(page_name, center_selecter, "Please select a center")), "other-center" == center_val ? (region_val || (error = !0, 
    OM.error_message(page_name, region_selecter, "Please select region")), region_center_val ? center_val = 'class="hidden"' : (error = !0, 
    OM.error_message(page_name, region_center_selecter, "Please select region center"))) : (region_val = 'class="hidden"', 
    region_center_val = 'class="hidden"'), positive_points_val || issues_val || follow_up_list_val || other_comment_val || (error = !0, 
    OM.error_message(page_name, positive_points_selecter, "Please enter your comment")), 
    email_val = email_val ? "Yes" : "No", 0 == error && OM.Modal.confirm(page_name, "Vicharan Notes", OM.Page.row(Array(Array({
        attr: center_val
    }, Array("field", "Date"), Array("value", OM.Date.change(date_val))), Array({
        attr: center_val
    }, Array("field", "Center"), Array("value", center_text)), Array({
        attr: region_val
    }, Array("field", "Region"), Array("value", region_text)), Array({
        attr: region_center_val
    }, Array("field", "Center"), Array("value", region_center_text)), Array({
        attr: ""
    }, Array("field", "Mandal"), Array("value", mandal_text)), Array({
        attr: ""
    }, Array("field", "Positive Points"), Array("value", positive_points_val)), Array({
        attr: ""
    }, Array("field", "Issues"), Array("value", issues_val)), Array({
        attr: ""
    }, Array("field", "Follow Up List"), Array("value", follow_up_list_val)), Array({
        attr: ""
    }, Array("field", "Other/General Comment"), Array("value", other_comment_val)), Array({
        attr: ""
    }, Array("field", "Email P. Sant/RMC"), Array("value", email_val))), 'data-list="form"')), 
    !1;
}), OM.live_event("#btn-confirm-vicharan-notes", "click", function() {
    var page_name = "vicharan-notes", date_val = $("#" + page_name + "-date").val(), center_val = $("#" + page_name + "-center option:selected").val(), region_center_val = $("#" + page_name + "-region-center option:selected").val(), mandal_val = $('input[name="' + page_name + '-mandal"]:checked').val(), positive_points_val = $("#" + page_name + "-positive_points").val(), issues_val = $("#" + page_name + "-issues").val(), follow_up_list_val = $("#" + page_name + "-follow_up_list").val(), other_comment_val = $("#" + page_name + "-other_comment").val(), email_val = $("#" + page_name + "-email:checked").val();
    "other-center" == center_val && (center_val = region_center_val), OM.Modal.close("confirm-" + page_name), 
    OM.Modal.save(page_name, OM.process + "index.php", {
        code: "vicharan-notes",
        type: "save",
        date: date_val,
        center: center_val,
        mandal: mandal_val,
        positive_points: positive_points_val,
        issues: issues_val,
        follow_up_list: follow_up_list_val,
        other_comment: other_comment_val,
        email: email_val,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && OM.sync("vicharan-notes");
    }, 2500);
}), OM.live_event("form#setup-center", "submit", function() {
    var page_name = "setup-center", region_selecter = "#" + page_name + "-region", center_selecter = "#" + page_name + "-region-center", region_val = $(region_selecter + " option:selected").val(), region_text = $(region_selecter + " option:selected").text(), center_val = $(center_selecter + " option:selected").val(), center_text = $(center_selecter + " option:selected").text();
    return OM.message_contener(page_name), OM.reset_form(page_name), region_val ? center_val ? OM.Modal.confirm(page_name, "Setup - Vicharan Centers", OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Region"), Array("value", region_text)), Array({
        attr: ""
    }, Array("field", "Center"), Array("value", center_text))), 'data-list="form"')) : OM.error_message(page_name, center_selecter, "Please select a center") : OM.error_message(page_name, region_selecter, "Please select a region"), 
    !1;
}), OM.live_event("#btn-confirm-setup-center", "click", function() {
    var page_name = "setup-center", center_val = $("#" + page_name + "-region-center option:selected").val();
    OM.Modal.close("confirm-" + page_name), OM.Modal.save(page_name, OM.process + "index.php", {
        code: "setup",
        type: "save-center",
        center: center_val,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && OM.sync("setup-start");
    }, 2500);
}), OM.live_event("#setup-next", "click", function() {
    var page_name = "setup", setup = $(this).attr("data-setup_pg");
    OM.get_data(OM.process + "index.php", {
        code: "setup",
        type: "update-setup",
        value: setup
    }, function(data) {
        "success" == data.status ? (OM.session.setup = parseInt(setup), $(window).trigger("hashchange")) : OM.Modal.new(page_name, OM.Modal.format("Error: Moving forward", OM.Button.close(page_name), OM.message("<h3>" + data.message + "</h3><p><u>Error message:</u> " + data.error + "</p>")));
    });
}), OM.live_event(".btn-remove-setup-center", "click", function() {
    var center = $(this).attr("data-center"), page_name = "setup-center";
    OM.Modal.remove(page_name, OM.process + "index.php", {
        code: "setup",
        type: "remove-center",
        center: center,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_remove = $("#data-remove").val();
        "success" == data_remove && OM.sync("setup-start");
    }, 2500);
}), OM.live_event("#setup-center-reload-list", "click", function() {
    for (var page_name = "setup-center", content = "", centers = OM.session.assign_center, a = 0; a < centers.length; a++) 0 == a && (content += "<ul data-list>"), 
    content += "<li><div>" + centers[a].name + '</div><div data-btn="right">' + OM.Button.remove({
        page_name: page_name,
        color: !0,
        icon: !0,
        attr: 'data-center="' + centers[a].name + '"'
    }) + "</div></li>", a == centers.length - 1 && (content += "</ul>");
    $("#" + page_name + "-list").html(content);
}), OM.live_event("form#setup-goal", "submit", function() {
    var page_name = "setup-goal", center_selecter = "#" + page_name + "-center", goal_selecter = "#" + page_name + "-goal", year_selecter = "#" + page_name + "-year", center_val = $(center_selecter + " option:selected").val(), center_text = $(center_selecter + " option:selected").text(), goal_val = $(goal_selecter).val(), year_val = $(year_selecter + " option:selected").val(), year_text = $(year_selecter + " option:selected").text(), error = !1;
    if (OM.message_contener(page_name), OM.reset_form(page_name), center_val || (error = !0, 
    OM.error_message(page_name, center_selecter, "Please select a center")), goal_val || (error = !0, 
    OM.error_message(page_name, goal_selecter, "Please enter goal")), year_val || (error = !0, 
    OM.error_message(page_name, year_selecter, "Please select a year")), 0 == error) {
        var year_show = "";
        OM.Date.month() < 11 && (year_show = 'class="hidden"'), OM.Modal.confirm(page_name, "Add my goal", OM.Page.row(Array(Array({
            attr: ""
        }, Array("field", "Center"), Array("value", center_text)), Array({
            attr: ""
        }, Array("field", "Goal"), Array("value", goal_val)), Array({
            attr: year_show
        }, Array("field", "Year"), Array("value", year_text))), 'data-list="form"'));
    }
    return !1;
}), OM.live_event("#btn-confirm-setup-goal", "click", function() {
    var page_name = "setup-goal", center_selecter = "#" + page_name + "-center", goal_selecter = "#" + page_name + "-goal", year_selecter = "#" + page_name + "-year", center_val = $(center_selecter).val(), goal_val = $(goal_selecter).val(), year_val = $(year_selecter).val();
    OM.Modal.close("confirm-" + page_name), OM.Modal.save(page_name, OM.process + "index.php", {
        code: "my-goals",
        type: "save",
        center: center_val,
        goal: goal_val,
        year: year_val,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && OM.sync("setup-start");
    }, 2500);
}), OM.live_event("#setup-goal-reload-list", "click", function() {
    for (var page_name = "setup-goal", content = "", search = OM.search_objects(OM.my_goals, "user", OM.session.fn + " " + OM.session.ln), a = 0; a < search.length; a++) {
        0 == a && (content += "<ul data-list>");
        for (var centers = search[a].centers, b = 0; b < centers.length; b++) content += '<li><div class="detail"><div>' + centers[b].center + '</div><div class="note">' + centers[b].year + '</div></div><div data-btn="right"><button data-button data-color="purple">' + centers[b].goal + "</button></div></li>";
        a == search.length - 1 && (content += "</ul>");
    }
    $("#" + page_name + "-list").html(content);
}), OM.live_event("form#setup-password", "submit", function() {
    {
        var page_name = "setup-password", new_selecter = "#" + page_name + "-new", confirm_selecter = "#" + page_name + "-confirm", new_val = $.trim($(new_selecter).val()), confirm_val = $.trim($(confirm_selecter).val());
        OM.Validation.password(new_val);
    }
    return OM.message_contener(page_name), OM.reset_form(page_name), null != OM.Validation.password(new_val) ? OM.error_message(page_name, new_selecter, OM.Validation.password(new_val)) : null != OM.Validation.confirm_match(new_val, confirm_val, "password") ? OM.error_message(page_name, confirm_selecter, OM.Validation.confirm_match(new_val, confirm_val, "password")) : (OM.Modal.save(page_name, OM.process + "index.php", {
        code: "setup",
        type: "save-password",
        password: php_md5(confirm_val),
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && (OM.session.setup = 2, OM.session.auto_pass = "N", OM.sync("none"), 
        OM.Page.setup_start());
    }, 2500)), !1;
}), OM.live_event("form#setup-profile", "submit", function() {
    var page_name = "setup-profile", first_name_selecter = "#" + page_name + "-first_name", last_name_selecter = "#" + page_name + "-last_name", email_selecter = "#" + page_name + "-email", region_selecter = "#" + page_name + "-region", region_center_selecter = "#" + page_name + "-region-center", first_name_val = $(first_name_selecter).val(), last_name_val = $(last_name_selecter).val(), email_val = $(email_selecter).val(), region_val = $(region_selecter + " option:selected").val(), region_text = $(region_selecter + " option:selected").text(), region_center_val = $(region_center_selecter + " option:selected").val(), region_center_text = $(region_center_selecter + " option:selected").text();
    return OM.message_contener(page_name), OM.reset_form(page_name), null != OM.Validation.firstName(first_name_val) ? OM.error_message(page_name, first_name_selecter, OM.Validation.firstName(first_name_val)) : null != OM.Validation.lastName(last_name_val) ? OM.error_message(page_name, last_name_selecter, OM.Validation.lastName(last_name_val)) : null != OM.Validation.email(email_val) ? OM.error_message(page_name, email_selecter, OM.Validation.email(email_val)) : region_val ? region_center_val ? OM.Modal.confirm(page_name, "Profile", OM.Page.row(Array(Array({
        attr: ""
    }, Array("field", "Name"), Array("value", first_name_val + " " + last_name_val)), Array({
        attr: ""
    }, Array("field", "Email Address"), Array("value", email_val)), Array({
        attr: ""
    }, Array("field", "Region"), Array("value", region_text)), Array({
        attr: ""
    }, Array("field", "Center"), Array("value", region_center_text))), 'data-list="form"')) : OM.error_message(page_name, region_center_selecter, "Please select center") : OM.error_message(page_name, region_selecter, "Please select region"), 
    !1;
}), OM.live_event("#btn-confirm-setup-profile", "click", function() {
    var page_name = "setup-profile", first_name_val = $("#" + page_name + "-first_name").val(), last_name_val = $("#" + page_name + "-last_name").val(), email_val = $("#" + page_name + "-email").val(), region_val = $("#" + page_name + "-region option:selected").val(), center_val = $("#" + page_name + "-region-center option:selected").val();
    OM.Modal.close("confirm-" + page_name), OM.Modal.save(page_name, OM.process + "index.php", {
        code: "setup",
        type: "save-profile",
        first_name: first_name_val,
        last_name: last_name_val,
        email: email_val,
        region: region_val,
        center: center_val,
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && (OM.session.fn = first_name_val, OM.session.ln = last_name_val, 
        OM.session.e = email_val, OM.session.region = region_val, OM.session.center = center_val, 
        OM.session.setup = 1, $(window).trigger("hashchange"));
    }, 2500);
}), OM.live_event("#form-auto-pass", "submit", function() {
    var page_name = "auto-pass", new_selecter = "#" + page_name + "-new", confirm_selecter = "#" + page_name + "-confirm", new_val = $.trim($(new_selecter).val()), confirm_val = $.trim($(confirm_selecter).val()), validate_new = OM.Validation.password(new_val), error = !1;
    return $(".error-" + page_name).remove(), new_val ? confirm_val ? validate_new !== !0 ? (error = !0, 
    OM.error_message(page_name, new_selecter, validate_new)) : new_val !== confirm_val && (error = !0, 
    OM.error_message(page_name, confirm_selecter, "Confirm password does not match")) : (error = !0, 
    OM.error_message(page_name, confirm_selecter, "Please enter confirm password")) : (error = !0, 
    OM.error_message(page_name, new_selecter, "please enter new password")), 0 == error && (OM.Modal.save(page_name, OM.process + "index.php", {
        code: "settings",
        type: "save-password",
        password: php_md5(confirm_val),
        token: OM.session.t,
        uid: OM.session.u
    }), setTimeout(function() {
        var data_save = $("#data-save").val();
        "success" == data_save && (OM.session.auto_pass = "N", $(window).trigger("hashchange"));
    }, 2500)), !1;
});