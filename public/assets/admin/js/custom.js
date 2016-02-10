//<![CDATA[
+ function (a) {
	"use strict";

	function b(b) {
		return this.each(function () {
			var d = a(this),
				e = d.data("bs.popover"),
				f = "object" == typeof b && b;
			(e || "destroy" != b) && (e || d.data("bs.popover", e = new c(this, f)), "string" == typeof b && e[b]())
		})
	}
	var c = function (a, b) {
		this.init("popover", a, b)
	};
	if (!a.fn.tooltip) throw new Error("Popover%20requires%20tooltip.html");
	c.VERSION = "3.2.0", c.DEFAULTS = a.extend({}, a.fn.tooltip.Constructor.DEFAULTS, {
		placement: "right",
		trigger: "click",
		content: "",
		template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
	}), c.prototype = a.extend({}, a.fn.tooltip.Constructor.prototype), c.prototype.constructor = c, c.prototype.getDefaults = function () {
		return c.DEFAULTS
	}, c.prototype.setContent = function () {
		var a = this.tip(),
			b = this.getTitle(),
			c = this.getContent();
		a.find(".popover-title")[this.options.html ? "html" : "text"](b), a.find(".popover-content").empty()[this.options.html ? "string" == typeof c ? "html" : "append" : "text"](c), a.removeClass("fade top bottom left right in"), a.find(".popover-title").html() || a.find(".popover-title").hide()
	}, c.prototype.hasContent = function () {
		return this.getTitle() || this.getContent()
	}, c.prototype.getContent = function () {
		var a = this.$element,
			b = this.options;
		return a.attr("data-content") || ("function" == typeof b.content ? b.content.call(a[0]) : b.content)
	}, c.prototype.arrow = function () {
		return this.$arrow = this.$arrow || this.tip().find(".arrow")
	}, c.prototype.tip = function () {
		return this.$tip || (this.$tip = a(this.options.template)), this.$tip
	};
	var d = a.fn.popover;
	a.fn.popover = b, a.fn.popover.Constructor = c, a.fn.popover.noConflict = function () {
		return a.fn.popover = d, this
	}
}(jQuery);
//]]>

//<![CDATA[
+ function (a) {
	"use strict";

	function b(b) {
		return this.each(function () {
			var d = a(this),
				e = d.data("bs.button"),
				f = "object" == typeof b && b;
			e || d.data("bs.button", e = new c(this, f)), "toggle" == b ? e.toggle() : b && e.setState(b)
		})
	}
	var c = function (b, d) {
		this.$element = a(b), this.options = a.extend({}, c.DEFAULTS, d), this.isLoading = !1
	};
	c.VERSION = "3.2.0", c.DEFAULTS = {
		loadingText: "loading..."
	}, c.prototype.setState = function (b) {
		var c = "disabled",
			d = this.$element,
			e = d.is("input") ? "val" : "html",
			f = d.data();
		b += "Text", null == f.resetText && d.data("resetText", d[e]()), d[e](null == f[b] ? this.options[b] : f[b]), setTimeout(a.proxy(function () {
			"loadingText" == b ? (this.isLoading = !0, d.addClass(c).attr(c, c)) : this.isLoading && (this.isLoading = !1, d.removeClass(c).removeAttr(c))
		}, this), 0)
	}, c.prototype.toggle = function () {
		var a = !0,
			b = this.$element.closest('[data-toggle="buttons"]');
		if (b.length) {
			var c = this.$element.find("input");
			"radio" == c.prop("type") && (c.prop("checked") && this.$element.hasClass("active") ? a = !1 : b.find(".active").removeClass("active")), a && c.prop("checked", !this.$element.hasClass("active")).trigger("change")
		}
		a && this.$element.toggleClass("active")
	};
	var d = a.fn.button;
	a.fn.button = b, a.fn.button.Constructor = c, a.fn.button.noConflict = function () {
		return a.fn.button = d, this
	}, a(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function (c) {
		var d = a(c.target);
		d.hasClass("btn") || (d = d.closest(".btn")), b.call(d, "toggle"), c.preventDefault()
	}).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function (b) {
		a(b.target).closest(".btn").toggleClass("focus", "focus" == b.type)
	})
}(jQuery);
//]]>

//<![CDATA[
! function (a) {
	a.fn.simpleCheckbox = function (b) {
		var c = {
				newElementClass: "switch-toggle",
				activeElementClass: "switch-on"
			},
			b = a.extend(c, b);
		this.each(function () {
			var c = a(this),
				d = a("<div/>", {
					id: "#" + c.attr("id"),
					"class": b.newElementClass,
					style: "display: block;"
				}).insertAfter(this);
			if (c.is(":checked") && d.addClass(b.activeElementClass), c.hide(), a("[for=" + c.attr("id") + "]").length) {
				var e = a("[for=" + c.attr("id") + "]");
				e.click(function () {
					return d.trigger("click"), !1
				})
			}
			d.click(function () {
				var c = a(this);
				return c.hasClass(b.activeElementClass) ? (c.removeClass(b.activeElementClass), a(c.attr("id")).attr("checked", !1)) : (c.addClass(b.activeElementClass), a(c.attr("id")).attr("checked", !0)), !1
			})
		})
	}
}(jQuery);
//]]>

//<![CDATA[
! function (a) {
	a(document).ready(function () {
		a.slidebars()
	})
}(jQuery);
//]]>

//<![CDATA[
$(document).ready(function () {
	$(".switch-button").click(function (a) {
		a.preventDefault();
		var b = $(this).attr("switch-parent"),
			c = $(this).attr("switch-target");
		$(b).slideToggle(), $(c).slideToggle()
	}), $(".hidden-button").hover(function () {
		$(".btn-hide", this).fadeIn("fast")
	}, function () {
		$(".btn-hide", this).fadeOut("normal")
	}), $(".toggle-button").click(function (a) {
		a.preventDefault(), $(".glyph-icon", this).toggleClass("icon-rotate-180"), $(this).parents(".content-box:first").find(".content-box-wrapper").slideToggle()
	}), $(".remove-button").click(function (a) {
		a.preventDefault();
		var b = $(this).attr("data-animation"),
			c = $(this).parents(".content-box:first");
		$(c).addClass("animated"), $(c).addClass(b);
		window.setTimeout(function () {
			$(c).slideUp()
		}, 500), window.setTimeout(function () {
			$(c).removeClass(b).fadeIn()
		}, 2500)
	}), $(function () {
		"use strict";
		$(".infobox-close").click(function (a) {
			a.preventDefault(), $(this).parent().fadeOut()
		})
	})
});
//]]>

//<![CDATA[
$(document).ready(function () {
	$(".overlay-button").click(function () {
		var a = $(this).attr("data-theme"),
			b = $(this).attr("data-opacity"),
			c = $(this).attr("data-style"),
			d = '<div id="loader-overlay" class="ui-front loader ui-widget-overlay ' + a + " opacity-" + b + '"><img src="../../assets/images/spinner/loader-' + c + '.gif" alt="" /></div>';
		$("#loader-overlay").length && $("#loader-overlay").remove(), $("body").append(d), $("#loader-overlay").fadeIn("fast"), setTimeout(function () {
			$("#loader-overlay").fadeOut("fast")
		}, 3e3)
	}), $(".refresh-button").click(function (a) {
		$(".glyph-icon", this).addClass("icon-spin"), a.preventDefault();
		var b = $(this).parents(".content-box"),
			c = $(this).attr("data-theme"),
			d = $(this).attr("data-opacity"),
			e = $(this).attr("data-style"),
			f = '<div id="refresh-overlay" class="ui-front loader ui-widget-overlay ' + c + " opacity-" + d + '"><img src="../../assets/images/spinner/loader-' + e + '.gif" alt="" /></div>';
		$("#refresh-overlay").length && $("#refresh-overlay").remove(), $(b).append(f), $("#refresh-overlay").fadeIn("fast"), setTimeout(function () {
			$("#refresh-overlay").fadeOut("fast"), $(".glyph-icon", this).removeClass("icon-spin")
		}, 1500)
	})
});
//]]>

//<![CDATA[
$(function () {
	"use strict";
	$('a[href="#"]').click(function (a) {
		a.preventDefault()
	})
}), $(function () {
	"use strict";
	$(".todo-box li input").on("click", function () {
		$(this).parent().toggleClass("todo-done")
	})
}), $(function () {
	"use strict";
	var a = 0;
	$(".timeline-scroll .tl-row").each(function (b, c) {
		var d = $(c);
		a += d.outerWidth() + parseInt(d.css("margin-left"), 10) + parseInt(d.css("margin-right"), 10)
	}), $(".timeline-horizontal", this).width(a)
}), $(function () {
	"use strict";
	$(".input-switch-alt").simpleCheckbox()
}), $(function () {
	"use strict";
	$(".scrollable-slim").slimScroll({
		color: "#8da0aa",
		size: "10px",
		alwaysVisible: !0
	})
}), $(function () {
	"use strict";
	$(".scrollable-slim-sidebar").slimScroll({
		color: "#8da0aa",
		size: "10px",
		height: "100%",
		alwaysVisible: !0
	})
}), $(function () {
	"use strict";
	$(".scrollable-slim-box").slimScroll({
		color: "#8da0aa",
		size: "6px",
		alwaysVisible: !1
	})
}), $(function () {
	"use strict";
	$(".loading-button").click(function () {
		var a = $(this);
		a.button("loading")
	})
}), $(function () {
	"use strict";
	$(".tooltip-button").tooltip({
		container: "body"
	})
}), $(function () {
	"use strict";
	$(".alert-close-btn").click(function () {
		$(this).parent().addClass("animated fadeOutDown")
	})
}), $(function () {
	"use strict";
	$(".popover-button").popover({
		container: "body",
		html: !0,
		animation: !0,
		content: function () {
			var a = $(this).attr("data-id");
			return $(a).html()
		}
	}).click(function (a) {
		a.preventDefault()
	})
}), $(document).ready(function () {
	$.material.init()
}), $(function () {
	"use strict";
	$(".popover-button-default").popover({
		container: "body",
		html: !0,
		animation: !0
	}).click(function (a) {
		a.preventDefault()
	})
});
var mUIColors = {
		"default": "#3498db",
		gray: "#d6dde2",
		primary: "#00bca4",
		success: "#2ecc71",
		warning: "#e67e22",
		danger: "#e74c3c",
		info: "#3498db"
	},
	getUIColor = function (a) {
		return mUIColors[a] ? mUIColors[a] : mUIColors["default"]
	};
//document.getElementById("fullscreen-btn").addEventListener("click", function () {
//	screenfull.enabled && screenfull.request()
//});
//]]>