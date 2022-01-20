(function() {
  const BASE = $('body').attr('data-base');

  /** GENERAL **/
  $('img').on('dragstart', function(event) {
    event.preventDefault();
  });
  /** ---------- **/

  /** LANGUAGE **/
  $(document).on('click', function(event) {
    if ($(event.target).closest('.dropdown').length === 0) {
      $('.dropdown ul').removeClass('active');
    }
  });

  $('.dropdown').on('click', function() {
    const THERE = $(this);
    THERE.find('ul').addClass('active');
  });
  /** ---------- **/

  /**
   * SEARCH
   * TODO: TEMPORAL FUNCTION > FIND BETTER WAY
   **/
  let interval = null;
  let searchInput = $('#input-search');
  let targetList = $('#results-query');
  searchInput.on('keyup', function(event) {
    if (interval !== null) clearTimeout(interval);
    interval = setTimeout(function() {
      requestXhr(event.target.value, 1, true);
    }, 600);
  });

  targetList.on('click', 'a.load-more', function(event) {
    requestXhr(event.target.dataset.search, event.target.dataset.page);
  });

  $('.search-form .reset-form').on('click', function() {
    searchInput.val('');
    requestXhr('');
  });

  function requestXhr(term, page = 1, clean = false) {
    if (term.length === 0) {
      targetList.removeClass('active');
      $('.search-form .fa-times').removeClass('active');
      return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open('GET', `${BASE}/wp-json/wp/v2/search?search=${term}&page=${page}`, true);
    xhr.send(null);

    xhr.addEventListener('progress', function() {
      $('.search-form .fa-times').addClass('active');
    });

    xhr.addEventListener('load', function(event) {
      let temporalList = '';
      let response = JSON.parse(event.target.responseText);
      let countPosts = parseInt(xhr.getResponseHeader('X-WP-Total'));
      let pagination = parseInt(xhr.getResponseHeader('X-WP-TotalPages'));

      if (countPosts > 0) {
        $.each(response, function(index, value) {
          temporalList += `<li><a href="${value.url}" target="_self">${value.title}</a></li>`;
        });

        if (pagination > 1 && pagination !== +page) {
          targetList.find('a.load-more').attr('data-search', term);
          targetList.find('a.load-more').attr('data-page', +page + 1);
          targetList.find('a.load-more').removeClass('hidden').addClass('block');
        } else {
          targetList.find('a.load-more').removeClass('block').addClass('hidden');
        }
      } else {
        temporalList += `<li class="no-results">Sin resultados</li>`;
      }

      if (clean) targetList.find('ul').empty();
      targetList.addClass('active');
      targetList.find('.fa-spinner').toggleClass('active');
      targetList.find('ul').append(temporalList);
    });

    xhr.addEventListener('error', function(event) {
      console.log(event);
    });
  }

  /** ---------- **/
})();
