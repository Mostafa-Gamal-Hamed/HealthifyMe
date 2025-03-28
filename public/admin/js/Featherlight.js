/**
 * Featherlight - ultra slim jQuery lightbox
 * Version 1.7.14 - http://noelboss.github.io/featherlight/
 *
 * Copyright 2019, Noël Raoul Bossart (http://www.noelboss.com)
 * MIT Licensed.
 **/
!(function (a) {
    "function" == typeof define && define.amd
        ? define(["jquery"], a)
        : "object" == typeof module && module.exports
        ? (module.exports = function (b, c) {
              return (
                  void 0 === c &&
                      (c =
                          "undefined" != typeof window
                              ? require("jquery")
                              : require("jquery")(b)),
                  a(c),
                  c
              );
          })
        : a(jQuery);
})(function (a) {
    "use strict";
    function b(a, c) {
        if (!(this instanceof b)) {
            var d = new b(a, c);
            return d.open(), d;
        }
        (this.id = b.id++),
            this.setup(a, c),
            this.chainCallbacks(b._callbackChain);
    }
    function c(a, b) {
        var c = {};
        for (var d in a) d in b && ((c[d] = a[d]), delete a[d]);
        return c;
    }
    function d(a, b) {
        var c = {},
            d = new RegExp("^" + b + "([A-Z])(.*)");
        for (var e in a) {
            var f = e.match(d);
            if (f) {
                var g = (f[1] + f[2].replace(/([A-Z])/g, "-$1")).toLowerCase();
                c[g] = a[e];
            }
        }
        return c;
    }
    if ("undefined" == typeof a)
        return void (
            "console" in window &&
            window.console.info(
                "Too much lightness, Featherlight needs jQuery."
            )
        );
    if (a.fn.jquery.match(/-ajax/))
        return void (
            "console" in window &&
            window.console.info(
                "Featherlight needs regular jQuery, not the slim version."
            )
        );
    var e = [],
        f = function (b) {
            return (e = a.grep(e, function (a) {
                return a !== b && a.$instance.closest("body").length > 0;
            }));
        },
        g = {
            allow: 1,
            allowfullscreen: 1,
            frameborder: 1,
            height: 1,
            longdesc: 1,
            marginheight: 1,
            marginwidth: 1,
            mozallowfullscreen: 1,
            name: 1,
            referrerpolicy: 1,
            sandbox: 1,
            scrolling: 1,
            src: 1,
            srcdoc: 1,
            style: 1,
            webkitallowfullscreen: 1,
            width: 1,
        },
        h = { keyup: "onKeyUp", resize: "onResize" },
        i = function (c) {
            a.each(b.opened().reverse(), function () {
                return c.isDefaultPrevented() || !1 !== this[h[c.type]](c)
                    ? void 0
                    : (c.preventDefault(), c.stopPropagation(), !1);
            });
        },
        j = function (c) {
            if (c !== b._globalHandlerInstalled) {
                b._globalHandlerInstalled = c;
                var d = a
                    .map(h, function (a, c) {
                        return c + "." + b.prototype.namespace;
                    })
                    .join(" ");
                a(window)[c ? "on" : "off"](d, i);
            }
        };
    (b.prototype = {
        constructor: b,
        namespace: "featherlight",
        targetAttr: "data-featherlight",
        variant: null,
        resetCss: !1,
        background: null,
        openTrigger: "click",
        closeTrigger: "click",
        filter: null,
        root: "body",
        openSpeed: 250,
        closeSpeed: 250,
        closeOnClick: "background",
        closeOnEsc: !0,
        closeIcon: "&#10005;",
        loading: "",
        persist: !1,
        otherClose: null,
        beforeOpen: a.noop,
        beforeContent: a.noop,
        beforeClose: a.noop,
        afterOpen: a.noop,
        afterContent: a.noop,
        afterClose: a.noop,
        onKeyUp: a.noop,
        onResize: a.noop,
        type: null,
        contentFilters: ["jquery", "image", "html", "ajax", "iframe", "text"],
        setup: function (b, c) {
            "object" != typeof b ||
                b instanceof a != !1 ||
                c ||
                ((c = b), (b = void 0));
            var d = a.extend(this, c, { target: b }),
                e = d.resetCss ? d.namespace + "-reset" : d.namespace,
                f = a(
                    d.background ||
                        [
                            '<div class="' + e + "-loading " + e + '">',
                            '<div class="' + e + '-content">',
                            '<button class="' +
                                e +
                                "-close-icon " +
                                d.namespace +
                                '-close" aria-label="Close">',
                            d.closeIcon,
                            "</button>",
                            '<div class="' +
                                d.namespace +
                                '-inner">' +
                                d.loading +
                                "</div>",
                            "</div>",
                            "</div>",
                        ].join("")
                ),
                g =
                    "." +
                    d.namespace +
                    "-close" +
                    (d.otherClose ? "," + d.otherClose : "");
            return (
                (d.$instance = f.clone().addClass(d.variant)),
                d.$instance.on(
                    d.closeTrigger + "." + d.namespace,
                    function (b) {
                        if (!b.isDefaultPrevented()) {
                            var c = a(b.target);
                            (("background" === d.closeOnClick &&
                                c.is("." + d.namespace)) ||
                                "anywhere" === d.closeOnClick ||
                                c.closest(g).length) &&
                                (d.close(b), b.preventDefault());
                        }
                    }
                ),
                this
            );
        },
        getContent: function () {
            if (this.persist !== !1 && this.$content) return this.$content;
            var b = this,
                c = this.constructor.contentFilters,
                d = function (a) {
                    return b.$currentTarget && b.$currentTarget.attr(a);
                },
                e = d(b.targetAttr),
                f = b.target || e || "",
                g = c[b.type];
            if (
                (!g && f in c && ((g = c[f]), (f = b.target && e)),
                (f = f || d("href") || ""),
                !g)
            )
                for (var h in c) b[h] && ((g = c[h]), (f = b[h]));
            if (!g) {
                var i = f;
                if (
                    ((f = null),
                    a.each(b.contentFilters, function () {
                        return (
                            (g = c[this]),
                            g.test && (f = g.test(i)),
                            !f &&
                                g.regex &&
                                i.match &&
                                i.match(g.regex) &&
                                (f = i),
                            !f
                        );
                    }),
                    !f)
                )
                    return (
                        "console" in window &&
                            window.console.error(
                                "Featherlight: no content filter found " +
                                    (i
                                        ? ' for "' + i + '"'
                                        : " (no target specified)")
                            ),
                        !1
                    );
            }
            return g.process.call(b, f);
        },
        setContent: function (b) {
            return (
                this.$instance.removeClass(this.namespace + "-loading"),
                this.$instance.toggleClass(
                    this.namespace + "-iframe",
                    b.is("iframe")
                ),
                this.$instance
                    .find("." + this.namespace + "-inner")
                    .not(b)
                    .slice(1)
                    .remove()
                    .end()
                    .replaceWith(a.contains(this.$instance[0], b[0]) ? "" : b),
                (this.$content = b.addClass(this.namespace + "-inner")),
                this
            );
        },
        open: function (b) {
            var c = this;
            if (
                (c.$instance.hide().appendTo(c.root),
                !((b && b.isDefaultPrevented()) || c.beforeOpen(b) === !1))
            ) {
                b && b.preventDefault();
                var d = c.getContent();
                if (d)
                    return (
                        e.push(c),
                        j(!0),
                        c.$instance.fadeIn(c.openSpeed),
                        c.beforeContent(b),
                        a
                            .when(d)
                            .always(function (a) {
                                a && (c.setContent(a), c.afterContent(b));
                            })
                            .then(c.$instance.promise())
                            .done(function () {
                                c.afterOpen(b);
                            })
                    );
            }
            return c.$instance.detach(), a.Deferred().reject().promise();
        },
        close: function (b) {
            var c = this,
                d = a.Deferred();
            return (
                c.beforeClose(b) === !1
                    ? d.reject()
                    : (0 === f(c).length && j(!1),
                      c.$instance.fadeOut(c.closeSpeed, function () {
                          c.$instance.detach(), c.afterClose(b), d.resolve();
                      })),
                d.promise()
            );
        },
        resize: function (a, b) {
            if (a && b) {
                this.$content.css("width", "").css("height", "");
                var c = Math.max(
                    a / (this.$content.parent().width() - 1),
                    b / (this.$content.parent().height() - 1)
                );
                c > 1 &&
                    ((c = b / Math.floor(b / c)),
                    this.$content
                        .css("width", "" + a / c + "px")
                        .css("height", "" + b / c + "px"));
            }
        },
        chainCallbacks: function (b) {
            for (var c in b)
                this[c] = a.proxy(b[c], this, a.proxy(this[c], this));
        },
    }),
        a.extend(b, {
            id: 0,
            autoBind: "[data-featherlight]",
            defaults: b.prototype,
            contentFilters: {
                jquery: {
                    regex: /^[#.]\w/,
                    test: function (b) {
                        return b instanceof a && b;
                    },
                    process: function (b) {
                        return this.persist !== !1 ? a(b) : a(b).clone(!0);
                    },
                },
                image: {
                    regex: /\.(png|jpg|jpeg|gif|tiff?|bmp|svg)(\?\S*)?$/i,
                    process: function (b) {
                        var c = this,
                            d = a.Deferred(),
                            e = new Image(),
                            f = a(
                                '<img src="' +
                                    b +
                                    '" alt="" class="' +
                                    c.namespace +
                                    '-image" />'
                            );
                        return (
                            (e.onload = function () {
                                (f.naturalWidth = e.width),
                                    (f.naturalHeight = e.height),
                                    d.resolve(f);
                            }),
                            (e.onerror = function () {
                                d.reject(f);
                            }),
                            (e.src = b),
                            d.promise()
                        );
                    },
                },
                html: {
                    regex: /^\s*<[\w!][^<]*>/,
                    process: function (b) {
                        return a(b);
                    },
                },
                ajax: {
                    regex: /./,
                    process: function (b) {
                        var c = a.Deferred(),
                            d = a("<div></div>").load(b, function (a, b) {
                                "error" !== b && c.resolve(d.contents()),
                                    c.reject();
                            });
                        return c.promise();
                    },
                },
                iframe: {
                    process: function (b) {
                        var e = new a.Deferred(),
                            f = a("<iframe/>"),
                            h = d(this, "iframe"),
                            i = c(h, g);
                        return (
                            f
                                .hide()
                                .attr("src", b)
                                .attr(i)
                                .css(h)
                                .on("load", function () {
                                    e.resolve(f.show());
                                })
                                .appendTo(
                                    this.$instance.find(
                                        "." + this.namespace + "-content"
                                    )
                                ),
                            e.promise()
                        );
                    },
                },
                text: {
                    process: function (b) {
                        return a("<div>", { text: b });
                    },
                },
            },
            functionAttributes: [
                "beforeOpen",
                "afterOpen",
                "beforeContent",
                "afterContent",
                "beforeClose",
                "afterClose",
            ],
            readElementConfig: function (b, c) {
                var d = this,
                    e = new RegExp("^data-" + c + "-(.*)"),
                    f = {};
                return (
                    b &&
                        b.attributes &&
                        a.each(b.attributes, function () {
                            var b = this.name.match(e);
                            if (b) {
                                var c = this.value,
                                    g = a.camelCase(b[1]);
                                if (a.inArray(g, d.functionAttributes) >= 0)
                                    c = new Function(c);
                                else
                                    try {
                                        c = JSON.parse(c);
                                    } catch (h) {}
                                f[g] = c;
                            }
                        }),
                    f
                );
            },
            extend: function (b, c) {
                var d = function () {
                    this.constructor = b;
                };
                return (
                    (d.prototype = this.prototype),
                    (b.prototype = new d()),
                    (b.__super__ = this.prototype),
                    a.extend(b, this, c),
                    (b.defaults = b.prototype),
                    b
                );
            },
            attach: function (b, c, d) {
                var e = this;
                "object" != typeof c ||
                    c instanceof a != !1 ||
                    d ||
                    ((d = c), (c = void 0)),
                    (d = a.extend({}, d));
                var f,
                    g = d.namespace || e.defaults.namespace,
                    h = a.extend(
                        {},
                        e.defaults,
                        e.readElementConfig(b[0], g),
                        d
                    ),
                    i = function (g) {
                        var i = a(g.currentTarget),
                            j = a.extend(
                                { $source: b, $currentTarget: i },
                                e.readElementConfig(b[0], h.namespace),
                                e.readElementConfig(
                                    g.currentTarget,
                                    h.namespace
                                ),
                                d
                            ),
                            k =
                                f ||
                                i.data("featherlight-persisted") ||
                                new e(c, j);
                        "shared" === k.persist
                            ? (f = k)
                            : k.persist !== !1 &&
                              i.data("featherlight-persisted", k),
                            j.$currentTarget.blur && j.$currentTarget.blur(),
                            k.open(g);
                    };
                return (
                    b.on(h.openTrigger + "." + h.namespace, h.filter, i),
                    { filter: h.filter, handler: i }
                );
            },
            current: function () {
                var a = this.opened();
                return a[a.length - 1] || null;
            },
            opened: function () {
                var b = this;
                return (
                    f(),
                    a.grep(e, function (a) {
                        return a instanceof b;
                    })
                );
            },
            close: function (a) {
                var b = this.current();
                return b ? b.close(a) : void 0;
            },
            _onReady: function () {
                var b = this;
                if (b.autoBind) {
                    var c = a(b.autoBind);
                    c.each(function () {
                        b.attach(a(this));
                    }),
                        a(document).on("click", b.autoBind, function (d) {
                            if (!d.isDefaultPrevented()) {
                                var e = a(d.currentTarget),
                                    f = c.length;
                                if (((c = c.add(e)), f !== c.length)) {
                                    var g = b.attach(e);
                                    (!g.filter ||
                                        a(d.target).parentsUntil(e, g.filter)
                                            .length > 0) &&
                                        g.handler(d);
                                }
                            }
                        });
                }
            },
            _callbackChain: {
                onKeyUp: function (b, c) {
                    return 27 === c.keyCode
                        ? (this.closeOnEsc && a.featherlight.close(c), !1)
                        : b(c);
                },
                beforeOpen: function (b, c) {
                    return (
                        a(document.documentElement).addClass(
                            "with-featherlight"
                        ),
                        (this._previouslyActive = document.activeElement),
                        (this._$previouslyTabbable = a(
                            "a, input, select, textarea, iframe, button, iframe, [contentEditable=true]"
                        )
                            .not("[tabindex]")
                            .not(this.$instance.find("button"))),
                        (this._$previouslyWithTabIndex =
                            a("[tabindex]").not('[tabindex="-1"]')),
                        (this._previousWithTabIndices =
                            this._$previouslyWithTabIndex.map(function (b, c) {
                                return a(c).attr("tabindex");
                            })),
                        this._$previouslyWithTabIndex
                            .add(this._$previouslyTabbable)
                            .attr("tabindex", -1),
                        document.activeElement.blur &&
                            document.activeElement.blur(),
                        b(c)
                    );
                },
                afterClose: function (c, d) {
                    var e = c(d),
                        f = this;
                    return (
                        this._$previouslyTabbable.removeAttr("tabindex"),
                        this._$previouslyWithTabIndex.each(function (b, c) {
                            a(c).attr("tabindex", f._previousWithTabIndices[b]);
                        }),
                        this._previouslyActive.focus(),
                        0 === b.opened().length &&
                            a(document.documentElement).removeClass(
                                "with-featherlight"
                            ),
                        e
                    );
                },
                onResize: function (a, b) {
                    return (
                        this.resize(
                            this.$content.naturalWidth,
                            this.$content.naturalHeight
                        ),
                        a(b)
                    );
                },
                afterContent: function (a, b) {
                    var c = a(b);
                    return (
                        this.$instance
                            .find("[autofocus]:not([disabled])")
                            .focus(),
                        this.onResize(b),
                        c
                    );
                },
            },
        }),
        (a.featherlight = b),
        (a.fn.featherlight = function (a, c) {
            return b.attach(this, a, c), this;
        }),
        a(document).ready(function () {
            b._onReady();
        });
});
