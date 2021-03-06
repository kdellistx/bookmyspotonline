/***************************************************
 * BY: Randy S. Baker
 * ON: 23-OCT-2018
 * FILE: fecha.min.js
 * NOTE: DatePicker scripts & helpers...
 ***************************************************/

 /**************************************
 * Initialize the plugin...
 **************************************/
! function(n, t) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : n.fecha = t()
}(this, function() {
    "use strict";
    var n = {},
        t = /d{1,4}|M{1,4}|YY(?:YY)?|S{1,3}|Do|ZZ|([HhMsDm])\1?|[aA]|"[^"]*"|'[^']*'/g,
        e = /\d\d?/,
        r = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i,
        u = /\[([^]*?)\]/gm,
        o = function() {};

    function a(n, t) {
        for (var e = [], r = 0, u = n.length; r < u; r++) e.push(n[r].substr(0, t));
        return e
    }

    function i(n) {
        return function(t, e, r) {
            var u = r[n].indexOf(e.charAt(0).toUpperCase() + e.substr(1).toLowerCase());
            ~u && (t.month = u)
        }
    }

    function s(n, t) {
        for (n = String(n), t = t || 2; n.length < t;) n = "0" + n;
        return n
    }
    var m = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        c = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        d = a(c, 3),
        f = a(m, 3);
    n.i18n = {
        dayNamesShort: f,
        dayNames: m,
        monthNamesShort: d,
        monthNames: c,
        amPm: ["am", "pm"],
        DoFn: function(n) {
            return n + ["th", "st", "nd", "rd"][n % 10 > 3 ? 0 : (n - n % 10 != 10) * n % 10]
        }
    };
    var h = {
            D: function(n) {
                return n.getDate()
            },
            DD: function(n) {
                return s(n.getDate())
            },
            Do: function(n, t) {
                return t.DoFn(n.getDate())
            },
            d: function(n) {
                return n.getDay()
            },
            dd: function(n) {
                return s(n.getDay())
            },
            ddd: function(n, t) {
                return t.dayNamesShort[n.getDay()]
            },
            dddd: function(n, t) {
                return t.dayNames[n.getDay()]
            },
            M: function(n) {
                return n.getMonth() + 1
            },
            MM: function(n) {
                return s(n.getMonth() + 1)
            },
            MMM: function(n, t) {
                return t.monthNamesShort[n.getMonth()]
            },
            MMMM: function(n, t) {
                return t.monthNames[n.getMonth()]
            },
            YY: function(n) {
                return String(n.getFullYear()).substr(2)
            },
            YYYY: function(n) {
                return s(n.getFullYear(), 4)
            },
            h: function(n) {
                return n.getHours() % 12 || 12
            },
            hh: function(n) {
                return s(n.getHours() % 12 || 12)
            },
            H: function(n) {
                return n.getHours()
            },
            HH: function(n) {
                return s(n.getHours())
            },
            m: function(n) {
                return n.getMinutes()
            },
            mm: function(n) {
                return s(n.getMinutes())
            },
            s: function(n) {
                return n.getSeconds()
            },
            ss: function(n) {
                return s(n.getSeconds())
            },
            S: function(n) {
                return Math.round(n.getMilliseconds() / 100)
            },
            SS: function(n) {
                return s(Math.round(n.getMilliseconds() / 10), 2)
            },
            SSS: function(n) {
                return s(n.getMilliseconds(), 3)
            },
            a: function(n, t) {
                return n.getHours() < 12 ? t.amPm[0] : t.amPm[1]
            },
            A: function(n, t) {
                return n.getHours() < 12 ? t.amPm[0].toUpperCase() : t.amPm[1].toUpperCase()
            },
            ZZ: function(n) {
                var t = n.getTimezoneOffset();
                return (t > 0 ? "-" : "+") + s(100 * Math.floor(Math.abs(t) / 60) + Math.abs(t) % 60, 4)
            }
        },
        l = {
            D: [e, function(n, t) {
                n.day = t
            }],
            Do: [new RegExp(e.source + r.source), function(n, t) {
                n.day = parseInt(t, 10)
            }],
            M: [e, function(n, t) {
                n.month = t - 1
            }],
            YY: [e, function(n, t) {
                var e = +("" + (new Date).getFullYear()).substr(0, 2);
                n.year = "" + (t > 68 ? e - 1 : e) + t
            }],
            h: [e, function(n, t) {
                n.hour = t
            }],
            m: [e, function(n, t) {
                n.minute = t
            }],
            s: [e, function(n, t) {
                n.second = t
            }],
            YYYY: [/\d{4}/, function(n, t) {
                n.year = t
            }],
            S: [/\d/, function(n, t) {
                n.millisecond = 100 * t
            }],
            SS: [/\d{2}/, function(n, t) {
                n.millisecond = 10 * t
            }],
            SSS: [/\d{3}/, function(n, t) {
                n.millisecond = t
            }],
            d: [e, o],
            ddd: [r, o],
            MMM: [r, i("monthNamesShort")],
            MMMM: [r, i("monthNames")],
            a: [r, function(n, t, e) {
                var r = t.toLowerCase();
                r === e.amPm[0] ? n.isPm = !1 : r === e.amPm[1] && (n.isPm = !0)
            }],
            ZZ: [/([\+\-]\d\d:?\d\d|Z)/, function(n, t) {
                "Z" === t && (t = "+00:00");
                var e, r = (t + "").match(/([\+\-]|\d\d)/gi);
                r && (e = 60 * r[1] + parseInt(r[2], 10), n.timezoneOffset = "+" === r[0] ? e : -e)
            }]
        };
    return l.dd = l.d, l.dddd = l.ddd, l.DD = l.D, l.mm = l.m, l.hh = l.H = l.HH = l.h, l.MM = l.M, l.ss = l.s, l.A = l.a, n.masks = {
        default: "ddd MMM DD YYYY HH:mm:ss",
        shortDate: "M/D/YY",
        mediumDate: "MMM D, YYYY",
        longDate: "MMMM D, YYYY",
        fullDate: "dddd, MMMM D, YYYY",
        shortTime: "HH:mm",
        mediumTime: "HH:mm:ss",
        longTime: "HH:mm:ss.SSS"
    }, n.format = function(e, r, o) {
        var a = o || n.i18n;
        if ("number" == typeof e && (e = new Date(e)), "[object Date]" !== Object.prototype.toString.call(e) || isNaN(e.getTime())) throw new Error("Invalid Date in fecha.format");
        var i = [];
        return (r = (r = (r = n.masks[r] || r || n.masks.default).replace(u, function(n, t) {
            return i.push(t), "??"
        })).replace(t, function(n) {
            return n in h ? h[n](e, a) : n.slice(1, n.length - 1)
        })).replace(/\?\?/g, function() {
            return i.shift()
        })
    }, n.parse = function(e, r, u) {
        var o = u || n.i18n;
        if ("string" != typeof r) throw new Error("Invalid format in fecha.parse");
        if (r = n.masks[r] || r, e.length > 1e3) return !1;
        var a = !0,
            i = {};
        if (r.replace(t, function(n) {
                if (l[n]) {
                    var t = l[n],
                        r = e.search(t[0]);
                    ~r ? e.replace(t[0], function(n) {
                        return t[1](i, n, o), e = e.substr(r + n.length), n
                    }) : a = !1
                }
                return l[n] ? "" : n.slice(1, n.length - 1)
            }), !a) return !1;
        var s, m = new Date;
        return !0 === i.isPm && null != i.hour && 12 != +i.hour ? i.hour = +i.hour + 12 : !1 === i.isPm && 12 == +i.hour && (i.hour = 0), null != i.timezoneOffset ? (i.minute = +(i.minute || 0) - +i.timezoneOffset, s = new Date(Date.UTC(i.year || m.getFullYear(), i.month || 0, i.day || 1, i.hour || 0, i.minute || 0, i.second || 0, i.millisecond || 0))) : s = new Date(i.year || m.getFullYear(), i.month || 0, i.day || 1, i.hour || 0, i.minute || 0, i.second || 0, i.millisecond || 0), s
    }, n
});