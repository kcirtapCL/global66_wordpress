(function() {
	const BASE = $("body").attr("data-base");

	/** GENERAL **/
	$("img").on("dragstart", function(event) {
		event.preventDefault();
	});
	/** ---------- **/

	/** LANGUAGE **/
	$(document).on("click", function(event) {
		if ($(event.target).closest(".dropdown").length === 0) {
			$(".dropdown ul").removeClass("active");
		}
	});

	$(".dropdown").on("click", function() {
		const THERE = $(this);
		THERE.find("ul").addClass("active");
	});
	/** ---------- **/

	/**
	 * SEARCH
	 * TODO: TEMPORAL FUNCTION > FIND BETTER WAY
	 **/
	let interval = null;
	let searchInput = $("#input-search");
	let targetList = $("#results-query");
	searchInput.on("keyup", function(event) {
		if (interval !== null) clearTimeout(interval);
		interval = setTimeout(function() {
			let execute = xhrSearch(event.target.value, 1);

			execute.addEventListener("progress", function() {
				$(".search-form .fa-times").addClass("active");
			});

			execute.addEventListener("load", function(event) {
				let temporalList = "";
				let response = JSON.parse(event.target.responseText);
				let countPosts = parseInt(execute.getResponseHeader("X-WP-Total"));
				let pagination = parseInt(execute.getResponseHeader("X-WP-TotalPages"));

				if (countPosts > 0) {
					$.each(response, function(index, value) {
						temporalList += `<li><a href="${value.url}" target="_self">${value.title}</a></li>`;
					});

					if (pagination > 1 && pagination !== +page) {
						targetList.find("a.load-more").attr("data-search", term);
						targetList.find("a.load-more").attr("data-page", +page + 1);
						targetList.find("a.load-more").removeClass("hidden").addClass("block");
					} else {
						targetList.find("a.load-more").removeClass("block").addClass("hidden");
					}
				} else {
					temporalList += `<li class="no-results">Sin resultados</li>`;
				}

				targetList.find("ul").empty();
				targetList.addClass("active");
				targetList.find(".fa-spinner").toggleClass("active");
				targetList.find("ul").append(temporalList);
			});

			execute.addEventListener("error", function(event) {
				console.log(event);
			});
		}, 600);
	});

	targetList.on("click", "a.load-more", function(event) {
		xhrSearch(event.target.dataset.search, event.target.dataset.page);
	});

	$(".search-form .reset-form").on("click", function() {
		searchInput.val("");
		xhrSearch("");
	});
	/** ---------- **/

	/** PAGINATION **/

	$("ul.pagination li a").on("click", "a.more-page", function(event) {
		pagination(event);
	});

	$("#all-posts").on("click", "a.more-page", function(event) {
		pagination(event);
	});

	/** ---------- **/

	function xhrSearch(term, page = 1) {
		if (term.length === 0) {
			targetList.removeClass("active");
			$(".search-form .fa-times").removeClass("active");
			return;
		}

		let xhr = new XMLHttpRequest();
		xhr.open("GET", `${BASE}/wp-json/wp/v2/search?search=${term}&page=${page}`, true);
		xhr.send(null);
		return xhr;
	}

	function pagination(event) {
		const DATASET = event.target.dataset;
		const CATEGORY = DATASET.category;
		const NEXT_PAGE = DATASET.page;
		const TARGET = $("#all-posts");

		console.log(DATASET);

		let actual_hash = window.location.hash;
		let decode_hash = actual_hash.split("/");
		if (decode_hash.includes("page")) {
			let index = decode_hash.indexOf("page");
			decode_hash[index + 1] = NEXT_PAGE;

			window.location.hash = decode_hash.join("/");
		} else {
			window.location.hash = `${actual_hash}/page/${NEXT_PAGE}`;
		}

		let execute = xhrAllPosts(CATEGORY, NEXT_PAGE);
		execute.addEventListener("load", function(event) {
			TARGET.html(event.target.responseText);
		});
	}
})();
